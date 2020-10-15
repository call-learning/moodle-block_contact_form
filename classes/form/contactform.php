<?php
// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Contact Moodle form
 *
 * @package    block_contact_form
 * @copyright 2020 - CALL Learning - Laurent David <laurent@call-learning>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_contact_form\form;
defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->libdir . '/formslib.php');

class contactform extends \moodleform {
    /**
     * Form definition
     *
     * @throws \coding_exception
     */
    protected function definition() {
        $mform = $this->_form;
        $mform->addElement('text', 'name', get_string('name'));
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', null, 'required', null, 'client');
        $mform->addRule('name', null, 'required', null, 'client');

        $mform->addElement('text', 'email', get_string('email'));
        $mform->setType('email', PARAM_EMAIL);
        $mform->addRule('email', null, 'required', null, 'client');

        $mform->addElement('text', 'subject', get_string('subject', 'block_contact_form'));
        $mform->setType('subject', PARAM_TEXT);
        $mform->addRule('subject', null, 'required', null, 'client');

        $mform->addElement('textarea',
            'message',
            get_string('message', 'block_contact_form'),
            'wrap="virtual" rows="8" cols="70"');
        $mform->setType('message', PARAM_CLEANHTML);
        $mform->addRule('message', null, 'required', null, 'client');
        if (!empty($CFG->recaptchapublickey) && !empty($CFG->recaptchaprivatekey) &&
            !isloggedin() || isguestuser()) {
            $mform->addElement('recaptcha', 'recaptcha_element', get_string('security_question', 'auth'));
        }

        // Show strings - submit button.
        $mform->addElement('submit', 'submit', get_string('send', 'block_contact_form'));
    }
}