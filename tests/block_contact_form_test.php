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
 * Base class for FAQ block tests
 *
 * @package   block_contact_form
 * @copyright 2020 - CALL Learning - Laurent David <laurent@call-learning.fr>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

use block_mcms\output\layout_four;
use block_mcms\output\layout_one;
use block_mcms\output\layout_three;
use block_mcms\output\layout_two;

/**
 * Unit tests for block_contact_form
 *
 * @package   block_contact_form
 * @copyright 2020 - CALL Learning - Laurent David <laurent@call-learning.fr>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_contact_form_test extends advanced_testcase {

    /**
     * Test that we can send an email
     *
     * @dataProvider email_sender_data
     * @param stdClass $data
     * @param stdClass $expected
     * @throws coding_exception
     * @throws dml_exception
     */
    public function test_email_sender($data, $expected) {
        $this->resetAfterTest();
        $emailsink = $this->redirectEmails();
        $emailsender = new \block_contact_form\email_sender($data);
        $result = $emailsender->send_email();
        $this->assertEquals($expected->sendresults, $result);
        $messages = $emailsink->get_messages();
        $message = reset($messages);
        unset($message->header);
        $this->assertEquals($expected->emailcontent, $messages[0]);
    }

    /**
     * Test data
     *
     * @return object[][]
     */
    public function email_sender_data() {
        return array(
            'Simple email' => array(
                'data' => (object) [
                    'name' => 'Test Name',
                    'email' => 'email@test.com',
                    'subject' => 'My subject',
                    'message' => 'My text'
                ],
                'expected' => (object) [
                    'sendresults' => true,
                    'emailcontent' => (object) [
                        'body' => '
Dear Admin User,

A message has been sent through the contact form. From the site PHPUnit
test site https://www.example.com/moodle [1]

From: "Test Name" - email@test.com

Subject: My subject

-------------------------

My text

Links:
------
[1] https://www.example.com/moodle
',
                        'subject' => 'PHPUnit test site - Contact from "Test Name"<email@test.com>',
                        'from' => 'noreply@www.example.com',
                        'to' => 'noreply@www.example.com'
                    ]
                ]
            ),
        );
    }
}
