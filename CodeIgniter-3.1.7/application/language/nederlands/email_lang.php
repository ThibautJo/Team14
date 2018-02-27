<?php

/**
* CodeIgniter
 *
 * Een open source applicatie-ontwikkeling kader voor PHP
 *
 * Deze content is vrijgegeven onder de MIT-licentie (MIT)
 *
 * Copyright (c) 2014-2015, British Columbia Institute of Technology
 *
 * Hierbij wordt toestemming verleend, kosteloos, aan eenieder die een kopie
 * Van deze software en bijbehorende documentatiebestanden (de "Software"), om te gaan
 * In de Software zonder beperking, inclusief zonder beperking de rechten
 * Te gebruiken, kopiëren, wijzigen, samenvoegen, publiceren, distribueren, in sublicentie te geven en / of te verkopen
 * Kopieën van de software, en personen aan wie de Software is mogelijk te maken
 * Ingericht om dit te doen, onder de volgende voorwaarden:
 *
 * De bovenstaande copyright en deze toestemming worden opgenomen in
 * Alle kopieën of substantiële delen van de Software.
 *
 * DE SOFTWARE WORDT "AS IS", ZONDER ENIGE GARANTIE, EXPLICIET OF
 * IMPLICIET, INCLUSIEF MAAR NIET BEPERKT TOT DE GARANTIE VAN VERKOOPBAARHEID,
* GESCHIKTHEID VOOR EEN BEPAALD DOEL EN NIET-INBREUK. IN GEEN GEVAL ZAL DE
 * AUTEURS OF AUTEURSRECHTHOUDERS AANSPRAKELIJK VOOR ENIGE CLAIM, SCHADE OF ANDERE
 * AANSPRAKELIJKHEID, HETZIJ IN EEN ACTIE VAN CONTRACT, ONRECHTMATIGE DAAD OF ANDERSZINS, ALS GEVOLG VAN,
 * UIT OF IN VERBAND MET DE SOFTWARE OF HET GEBRUIK OF ANDERE HANDELINGEN IN
 * DE SOFTWARE.
 *
* @package 	CodeIgniter
* @author 	Ellislab Dev Team
* @copyright 	Copyright (c) 2008-2014, Ellislab, Inc. (http://ellislab.com/)
* @copyright 	Copyright (c) 2014-2015, British Columbia Institute of Technology (http://bcit.ca/)
* @license 	Http://opensource.org/licenses/MIT MIT-licentie
* @link 	Http://codeigniter.com
* @since 	Versie 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('Directe toegang tot scripts is niet toegestaan');
$lang[ ' email_must_be_array ' ] =  ' Het e-validatie methode moet worden doorgegeven een array. ' ;
$lang[ ' email_invalid_address ' ] =  ' Ongeldig e-mailadres:% s ' ;
$lang[ ' email_attachment_missing ' ] =  ' Kan de volgende e-mailbijlage te vinden:% s ' ;
$lang[ ' email_attachment_unreadable ' ] =  ' Kan deze bijlage te openen:% s ' ;
$lang[ ' email_no_from ' ] =  ' Kan geen mail verzenden zonder "From" header. ' ;
$lang[ ' email_no_recipients ' ] =  ' Je moet ontvangers zijn onder meer: Aan, CC of BCC ' ;
$lang [ ' email_send_failure_phpmail ' ] =  ' Kan geen e-mail met behulp van PHP mail (). Uw server kan niet worden geconfigureerd om e-mail te sturen met behulp van deze methode. ' ;
$lang [ ' email_send_failure_sendmail ' ] =  ' Kan geen e-mail te sturen met behulp van PHP Sendmail. Uw server kan niet worden geconfigureerd om e-mail te sturen met behulp van deze methode. ' ;
$lang [ ' email_send_failure_smtp ' ] =  ' Kan geen e-mail te sturen met behulp van PHP SMTP. Uw server kan niet worden geconfigureerd om e-mail te sturen met behulp van deze methode. ' ;
$lang [ ' email_sent ' ] =  ' Uw bericht is succesvol verzonden met het volgende protocol:% s ' ;
$lang [ ' email_no_socket ' ] =  ' Kan geen socket openen voor Sendmail. Controleer de instellingen. ' ;
$lang [ ' email_no_hostname ' ] =  ' Je hebt niet een SMTP hostnaam op te geven. ' ;
$lang [ ' email_smtp_error ' ] =  ' De volgende SMTP-fout opgetreden:% s ' ;
$lang [ ' email_no_smtp_unpw ' ] =  ' Fout:. Je moet een SMTP-gebruikersnaam en wachtwoord toewijzen ' ;
$lang [ ' email_failed_smtp_login ' ] =  ' Kan AUTH LOGIN commando te sturen. Fout:% s ' ;
$lang [ ' email_smtp_auth_un ' ] =  ' Kan gebruikersnaam authenticeren. Fout:% s ' ;
$lang [ ' email_smtp_auth_pw ' ] =  ' Kan het wachtwoord te verifiëren. Fout:% s ' ;
$lang [ ' email_smtp_data_failure ' ] =  ' Kan geen gegevens verzenden:% s ' ;
$lang [ ' email_exit_status ' ] =  ' Exit Status code:% s ' ;
/* Einde van het bestand email_lang.php * /
/* Locatie: ./system/language/english/email_lang.php * /