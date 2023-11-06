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
 * Plugin administration sendmail are defined here.
 *
 * @package     local_sendmail
 * @category    admin
 * @copyright   2023 Shree Ram <shreeramsharma1990@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$componentname = 'local_sendmail';

if ($hassiteconfig) {
    // Adding the category to the local plugin list.
    $ADMIN->add('localplugins', new \admin_category('local_sendmail', get_string('pluginname', $componentname)));
    $settingspage = new \admin_settingpage('sendmail', get_string('pluginsettings', $componentname));

    $settings = [];

    // Setting for enable/disable.
    $settings[] = new \admin_setting_configcheckbox(
        'local_sendmail/enable_local_sendmail',
        get_string('enable_local_sendmail', 'local_sendmail'),
        get_string('enable_local_sendmail_msg', 'local_sendmail'),
        1
    );

    // Setting to define a message to be sent to a user from a form.
    $settings[] = new \admin_setting_configtext(
        'local_sendmail/mail_subject',
        get_string('mail_subject', 'local_sendmail'),
        get_string('mail_subject', 'local_sendmail'),
        get_string('mail_subject_content', 'local_sendmail'),
    );
    // Setting to define a message to be sent to a user from a form.
    $settings[] = new \admin_setting_confightmleditor(
        'local_sendmail/mail_body',
        get_string('mail_body', 'local_sendmail'),
        get_string('mail_body', 'local_sendmail'),
        get_string('mail_body_content', 'local_sendmail')
    );

    // Add all the settings to the settings page.
    foreach ($settings as $setting) {
        $settingspage->add($setting);
    }

    // Add the settings page to the nav tree.
    $ADMIN->add('local_sendmail', $settingspage);
}
