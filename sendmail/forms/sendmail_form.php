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
 * send mail form
 *
 * @package     local_sendmail
 * @category    string
 * @copyright   2023 Shree Ram <shreeramsharma1990@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die;
require_once("$CFG->libdir/formslib.php");
class sendmail_form extends moodleform {
    public function definition() {
        global $CFG;
        $mform = $this->_form;

        // ... sample file with column
        $samplecsvlink = new moodle_url('/local/sendmail/sample.csv');
        $mform->addElement('static', 'samplecsvlink', '', '<a href="' . $samplecsvlink . '">' .
        get_string('sampel_csv', 'local_sendmail') . '</a>');

        $mform->addElement('filepicker', 'csv_file', get_string('file'), null, ['accepted_types' => '*.csv']);
        $this->add_action_buttons();
    }
}
