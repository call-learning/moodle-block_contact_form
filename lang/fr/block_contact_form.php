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
 * @copyright 2020 - CALL Learning - Laurent David <laurent@call-learning.fr>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['configtitle'] = 'Titre du bloc du formulaire de contact';
$string['configintro'] = 'Texte d\'introduction';
$string['intro'] = 'Restons en contact! Veuillez compléter ce formulaire pour nous envoyer un message.';
$string['configmustlogin'] = 'Doit se connecter pour utiliser le formulaire';
$string['contact_form:addinstance'] = 'Ajouter un nouveau bloc de contact';
$string['contact_form:myaddinstance'] = 'Ajouter un nouveau bloc de contact au tableau de bord';
$string['incorrectpleasetryagain'] = 'Incorrect. Essayez encore.';
$string['newcontactform'] = 'Nouveau bloc de formulaire de contact';
$string['pluginname'] = 'Bloc de Formulaire de contact';
$string['title'] = 'Formulaire de contact';
$string['subject'] = 'Sujet';
$string['message'] = 'Message';
$string['send'] = 'Envoyer';
$string['sendtoname'] = 'Envoyer à (nom)';
$string['sendtoname_desc'] = 'Envoyer à (nom)';
$string['sendtoemail'] = 'Envoyer à (email)';
$string['sendtoemail_desc'] = 'Email vers qui on va envoyer le contenu du formulaire (email du support)';
$string['emailcontentsupport'] = '
<p>[sendtoname],</p>
<p>Un message a été envoyé via le formulaire de contact - du site [sitefullname] <a href="[siteurl]">[siteurl]</a></p>
<p>De: "[sendername]" - [senderemail]</p>
<p>Sujet: [subject]</p>
<hr>';

$string['emailcontentsupportsubject'] = '[sitefullname] - Contact par "[sendername]"<[senderemail]>';

$string['messagefailed'] = 'Désolé mais nous n\'avons pas réussi à envoyer le message. Merci de revenir plus tard.';
$string['messagesuccess'] = 'Félicitations ! Le message a été envoyé à l\' administrateur du site. Nous vous répondrons dans les plus brefs délais.';
$string['mustbeloggedin'] = 'Vous devez être connecté pour utiliser ce formulaire';
