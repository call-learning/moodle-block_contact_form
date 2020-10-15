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
 * Strings for component 'block_html', language 'en', branch 'MOODLE_20_STABLE'
 *
 * @package   block_contact_form
 * @copyright 2020 - CALL Learning - Laurent David <laurent@call-learning>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['configtitle'] = 'Contact Form block title';
$string['configintro'] = 'Introduction text';
$string['intro'] = 'Let\'s get in touch ! Please fill this form and send us a message.';
$string['configmustlogin'] = 'Must login to use the form';
$string['contact_form:addinstance'] = 'Add a new Contact Form block';
$string['contact_form:myaddinstance'] = 'Add a new Contact Form block to Dashboard';
$string['newcontactform'] = 'New Contact Form Block';
$string['pluginname'] = 'Contact Form Block';

$string['subject'] = 'Subject';
$string['message'] = 'Message';
$string['send'] = 'Send';
$string['sendfromname'] = 'From name';
$string['sendfromemail'] = 'From email';
$string['emailcontentsupport'] = '
<p>Dear [supportname],</p>
<p>A message has been sent through the contact form by "[sendername]"([senderemail]).</p>
<p>From the site [sitefullname] <a href="[siteurl]">[siteurl]</a></p>
<hr>';

$string['emailcontentsupportsubject'] = '[sitefullname] - Contact from "[sendername]"<[senderemail]>';

$string['messagefailed'] = 'Sorry but we failed to send the message. Please come back later';
$string['messagesuccess'] = 'Congratulations ! The message has been sent to the administrator of the site. We will retrieve it as soon
as possible.';
$string['mustbeloggedin'] = 'You must be logged in to use this form';
$string['title'] = 'Contact Form';