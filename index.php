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
 * User listing - mail sent
 *
 * @package     local_sendmail
 * @category    string
 * @copyright   2023 Shree Ram <shreeramsharma1990@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');

$currentpage = new \moodle_url('/local/sendmail/index.php');
$PAGE->set_url($currentpage);
require_login();

// Only admin can access this page.
if (!is_siteadmin($USER->id)) {
    throw new \moodle_exception('accessdenied', 'admin');
}

// Set title and heading.
$PAGE->set_title(get_string('pluginname', 'local_sendmail'));
$PAGE->set_heading(get_string('pluginname', 'local_sendmail'));
$PAGE->navbar->add(get_string('pluginname', 'local_sendmail'), $currentpage);
$PAGE->navbar->add(get_string('sendmail:listuser_send_mail', 'local_sendmail'));

echo $OUTPUT->header();

// Selecting records.
$records = $DB->get_records_sql("SELECT id, firstname, lastname, email, timecreated from {local_sendmail_users} order by id desc");

$table = new html_table();
$table->attributes['class'] = 'generaltable mod_index';

$table->head = [];
$table->align = [];

// Firstname.
$table->head[] = get_string('firstname');
$table->align[] = 'center';

// Lastname.
$table->head[] = get_string('lastname');
$table->align[] = 'left';

// Email.
$table->head[] = get_string('email');
$table->align[] = 'left';

// Email sent_date.
$table->head[] = get_string('email_sent_date', 'local_sendmail');
$table->align[] = 'left';

// Add data rows.
if (count($records) > 0) {
    foreach ($records as $record) {
        $row = [];
        $row[] = $record->firstname;
        $row[] = $record->lastname;
        $row[] = $record->email;
        $row[] = date('Y-m-d', $record->timecreated);
        $table->data[] = $row;
    }
} else {
    $row = [
        html_writer::tag('td', get_string('no_records', 'local_sendmail'), ['colspan' => 4]),
    ];
    $table->data[] = $row;
}

echo html_writer::table($table);

echo $OUTPUT->footer();
