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
 * Send Mail strings are defined here.
 *
 * @package     local_sendmail
 * @category    string
 * @copyright   2023 Shree Ram <shreeramsharma1990@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Send random email to users';
$string['sendmail:upload_csv'] = 'Upload a CSV';
$string['sendmail:listuser_send_mail'] = 'Users - Mail Sent';
$string['mail_subject'] = 'Email Subject';
$string['mail_subject_content'] = 'This is test mail Subject';
$string['mail_body'] = 'This is test mail';
$string['mail_body_content'] = '<p>Dear {firstname},</p>
<p>Hope you are doing great!</p>
<p>You are receiving this mail as someone has used your user email for the testing
purpose on the portal {sitename}.</p>
<p>Regards,</p>
<p>{sitename}</p>
';
$string['pluginsettings'] = 'Settings';
$string['enable_local_sendmail'] = 'Enable';
$string['enable_local_sendmail_msg'] = 'Enable Send random email to users.';
$string['email_sent_date'] = 'Email Sent Date';
$string['uploadcsvfile'] = 'File';
$string['column_mismatch'] = 'Columns must be firstname, lastname, email';
$string['success'] = 'The emails have been sent successfully.';
$string['sampel_csv'] = 'Download Sample CSV';
$string['sampel_email'] = 'Queue a sample email';
$string['un_unauthorized'] = 'You are not unauthorized to access this.';
$string['plugin_diabled'] = 'This plugin has been disabled by the administrator. Please reach out to the site administrator for further assistance.';
$string['csv_no_data'] = 'No data found in csv.';
$string['no_records'] = 'No records found.';
$string['error_mail'] = 'Invalid email address.';
$string['error_firstname'] = 'Invalid First Name.';
$string['error_lastname'] = 'Invalid Last Name.';
$string['fix_error'] = 'Please address the error before proceeding with further actions.';
$string['something_wrrong'] = 'Something went wrong, please try again.';
