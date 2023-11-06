<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * send mail
 *
 * @package     local_sendmail
 * @category    string
 * @copyright   2023 Shree Ram <shreeramsharma1990@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
global $DB, $USER, $SESSION;

require_once('forms/sendmail_form.php');
require_once($CFG->libdir . '/csvlib.class.php');
$currentpage = $CFG->wwwroot . '/local/sendmail/sendmail.php';
require_login();

$PAGE->set_url('/local/sendmail/sendmail.php');
$PAGE->set_title(get_string('uploadcsvfile', 'local_sendmail'));
$PAGE->set_pagelayout('standard');
$PAGE->navbar->add(get_string('pluginname', 'local_sendmail'), $currentpage);
$PAGE->navbar->add(get_string('sampel_email', 'local_sendmail'));
echo $OUTPUT->header();

$pluginconfig = get_config('local_sendmail');
if (!$pluginconfig->enable_local_sendmail) {
    echo $OUTPUT->notification(get_string('plugin_diabled', 'local_sendmail'), 'notifyproblem');
    echo $OUTPUT->footer();
    exit;
}
if (!(has_capability('local/sendmail:upload_csv', context_system::instance()))) {
    throw new \moodle_exception('accessdenied', 'admin');
}
$form = new sendmail_form();
if ($form->is_cancelled()) {
    redirect($currentpage);
} else if ($data = $form->get_data()) {
    // After form submit.
    $content = $form->get_file_content('csv_file');
    $rowsraw = explode("\n", $content);
    $rows = explode("\n", $content);
    $error = 0;

    // Check for the exact culumn.
    $headers = str_getcsv(array_shift($rows));
    if ($headers[0] != 'firstname' || $headers[1] != 'lastname' || $headers[2] != 'email') {
        echo $OUTPUT->notification(get_string('column_mismatch', 'local_sendmail'), 'notifyproblem');
        echo $OUTPUT->continue_button($currentpage);
        echo $OUTPUT->footer();
        exit;
    }

    if ($content !== false) {
        if (!isset($SESSION->csvdata)) {
            // Storing CSV data in the session.
            $SESSION->csvdata = $rowsraw;
        }

        // Display the CSV data (columns).
        echo html_writer::start_div('csv-data');
        $table = new html_table();
        $table->attributes['class'] = 'generaltable';
        $table->head = [
            $headers[0],
            $headers[1],
            $headers[2],
        ];

        if (count($rows) < 1) {
            echo $OUTPUT->notification(get_string('csv_no_data', 'local_sendmail'), 'notifyproblem');
            echo $OUTPUT->continue_button($currentpage);
            echo $OUTPUT->footer();
            exit;
        }

        foreach ($rows as $row) {

            $rowdata = str_getcsv($row);

            // Validate email.
            $errorinmail = '';
            if (validate_email(trim($rowdata[2]))) {
                $errorinmail = '';
            } else {
                $error = 1;
                $errorinmail = "<span style = 'color: red'> " . get_string('error_mail', 'local_sendmail') . "</span>";
            }

            // Check is firstname not empty.
            $errorfirstname = '';
            if (trim($rowdata[0]) == '') {
                $error = 1;
                $errorfirstname = "<span style = 'color: red'> " . get_string('error_firstname', 'local_sendmail') . "</span>";
            }

            // Check is lastname not empty.
            $errorlastname = '';
            if (trim($rowdata[1]) == '') {
                $error = 1;
                $errorlastname = "<span style = 'color: red'> " . get_string('error_lastname', 'local_sendmail') . "</span>";
            }

            $table->data[] = [
                $rowdata[0]. $errorfirstname,
                $rowdata[1]. $errorlastname,
                $rowdata[2] . $errorinmail,
            ];
        }

        echo html_writer::table($table);
        echo html_writer::end_div();

        // Continue button for further process.
        if ($error) {
            echo $OUTPUT->notification(get_string('fix_error', 'local_sendmail'), 'notifyproblem');
            echo $OUTPUT->footer();
            exit;
        }
        echo $OUTPUT->continue_button(new moodle_url('/local/sendmail/process.php'));
    }
} else {
    // Display the form.
    $form->display();
    echo $OUTPUT->footer();
}
