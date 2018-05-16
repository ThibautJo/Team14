<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// +----------------------------------------------------------
// |    Trainingscentrum Wezenberg
// +----------------------------------------------------------
// |    Auteur: Jolien Lauwers       |       Helper:
// +----------------------------------------------------------
// |
// |    Authex library
// |
// +----------------------------------------------------------
// |    Team 14
// +----------------------------------------------------------

/**
 * @class Authex
 * @brief Controller-klasse voor het valideren van gebruikers en sessies.
 * 
 * Controller-klasse met alle methodes die gebruikt worden voor het valideren van gebruikersrechten, valideren van ingevoerde aanmeldgegevens en sessievariabelen.
 */
class Authex {

    public function __construct() {
        $CI = & get_instance();
    }

    function meldAan($email, $wachtwoord) {

        /**
        * Verifiërd de ingevoerde aanmeldgegevens (email en wachtwoord) en logt de overeenstemmende gebruiker in het systeem.
        */
        
        $CI = & get_instance();
        $persoon = $CI->persoon_model->getPersoon($email, $wachtwoord);

        if ($persoon == null) {
            return false;
        } else {
            $CI->session->set_userdata('Id', $persoon->id);
            return true;
        }
    }
    
    function isAangemeld() {
        
        /**
        * Verifierd dat de gebruiker is aangemeld indien deze beschikt over een id binnen de database.
        */

        // persoon is aangemeld als sessievariabele gebruiker_id bestaat
        $CI = & get_instance();

        if ($CI->session->has_userdata('Id')) {
            return true;
        } else {
            return false;
        }
    }
    
    function getPersoonInfo() {
        
        /**
        * Verifierd de ingevoerde aanmeldgegevens (email en wachtwoord) en logt de overeenstemmende gebruiker in het systeem.
        */
        
        // geef persoon-object als zwemmer aangemeld is
        $CI = & get_instance();

        if (!$this->isAangemeld()) {
            return null;
        } else {
            $id = $CI->session->userdata('Id');
            return $CI->persoon_model->get($id);
        }
    }

    function meldAf() {

        // afmelden, dus sessievariabele wegdoen
        $CI = & get_instance();
        $CI->session->unset_userdata('Id');
    }

}
