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
 * Process - sending email
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

if (!(has_capability('local/sendmail:upload_csv', context_system::instance()))) {
    throw new \moodle_exception('accessdenied', 'admin');
}
if (empty($SESSION->csvdata)) {
    echo $OUTPUT->notification(get_string('something_wrrong', 'local_sendmail'), 'notifyproblem');
    echo $OUTPUT->footer();
    exit;
}

$rows = $SESSION->csvdata;
$headers = str_getcsv(array_shift($rows));


// Loop through the rows to process the data.
foreach ($rows as $row) {
    $rowdata = str_getcsv($row);

    $firstname = $rowdata[0];
    $lastname = $rowdata[1];
    $email = $rowdata[2];


    if ($firstname == "" || $lastname == "" || $email == "") {
        continue;
    }

    $record = new stdClass();
    $record->firstname = $firstname;
    $record->lastname = $lastname;
    $record->email = $email;
    $record->timecreated = time();

    // Getting mail content from the configuration.
    $sendmailconfig = get_config('local_sendmail');
    $emailsubject = $sendmailconfig->mail_subject;
    $emailmessage = $sendmailconfig->mail_body;
    $replace = [
        '{firstname}' => $record->firstname,
        '{sitename}' => $SITE->shortname,
    ];
    $emailmessage1 = str_replace(array_keys($replace), array_values($replace), $emailmessage);

    $record->mail_subject = $emailsubject;
    $record->mail_body = $emailmessage1;
    // Insert records into the table.
    $insert = $DB->insert_record('local_sendmail_users', $record);

    if ($insert) {
        $record->id = $insert;
        $emailuserfrom = $USER;
        email_to_user($record, $emailuserfrom, $emailsubject, $emailmessage1);
    }
}
// Unsert csv session.
unset($SESSION->csvdata);

// Display a success message.
echo $OUTPUT->notification(get_string('success', 'local_sendmail'), 'notifysuccess');
echo $OUTPUT->footer();
