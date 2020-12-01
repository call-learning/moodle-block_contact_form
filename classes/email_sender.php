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
 * Email sender
 *
 * @package    block_contact_form
 * @copyright 2020 - CALL Learning - Laurent David <laurent@call-learning>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_contact_form;
defined('MOODLE_INTERNAL') || die();

/**
 * Class email_sender
 *
 * Send a given message to the support user. For now the copy of the message is not
 * sent to the real user as we need to make sure this is not used to send unwanted messages through the site.
 *
 * @package    block_contact_form
 * @copyright 2020 - CALL Learning - Laurent David <laurent@call-learning>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class email_sender {

    /**
     * @var bool|\stdClass no reply user
     */
    protected $noreplyuser;
    /**
     * @var string email to
     */
    protected $toemail;
    /**
     * @var string name to
     */
    protected $toname;
    /**
     * @var string from name
     */
    protected $fromname;
    /**
     * @var stringfrom email
     */
    protected $fromemail;
    /**
     * @var string subject
     */
    protected $subject;
    /**
     * @var string message
     */
    protected $message;

    /**
     * email_sender constructor.
     *
     * @param \stdClass $formdata
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public function __construct($formdata) {
        $config = get_config('block_contact_form');
        $noreplyuser = \core_user::get_noreply_user();

        $this->toemail = $noreplyuser->email;
        $this->toname = fullname($noreplyuser);
        if ($config->sendtoemail) {
            $this->toemail = $config->sendtoemail;
        }
        if ($config->sendtoname) {
            $this->toname = $config->sendtoname;
        }
        $this->fromname = $formdata->name;
        $this->fromemail = $formdata->email;
        $this->subject = clean_param($formdata->subject, PARAM_TEXT);
        $this->message = clean_param($formdata->message, PARAM_TEXT);
        $this->noreplyuser = $noreplyuser;

    }

    /**
     * Send the email with additional content for explanation
     *
     * @return bool
     * @throws \coding_exception
     */
    public function send_email() {
        global $CFG, $SITE;
        // A couple of tags in the message.
        $tags = array('[sendername]', '[senderemail]', '[sendtoname]', '[sendtoemail]',
            '[subject]', '[lang]', '[userip]', '[sitefullname]', '[siteshortname]', '[siteurl]'
        );
        $info = array( $this->fromname,
            $this->fromemail,
            $this->toname,
            $this->toemail,
            $this->subject,
            current_language(),
            getremoteaddr(),
            $SITE->fullname,
            $SITE->shortname,
            $CFG->wwwroot
        );

        // Create the footer - Add some system information.
        $headermessage = get_string('emailcontentsupport', 'block_contact_form');
        $headermessage = format_text($headermessage, FORMAT_HTML, array('trusted' => true, 'noclean' => true, 'para' => false));
        $headermessage = str_replace($tags, $info, $headermessage);

        $fullmessage = $headermessage . '<br>' . $this->message;

        $subject = get_string('emailcontentsupportsubject', 'block_contact_form');
        $subject = str_replace($tags, $info, $subject);
        $touser = \core_user::get_noreply_user();
        $touser->firstname = $this->toname;
        $touser->email = $this->toemail;
        return email_to_user($touser,
            $this->noreplyuser,
            $subject,
            html_to_text($fullmessage),
            $fullmessage,
            '',
            '',
            true);
    }
}
