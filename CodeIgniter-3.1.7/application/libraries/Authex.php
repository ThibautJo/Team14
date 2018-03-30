<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Authex {

    // +----------------------------------------------------------
    // | TV Shop
    // +----------------------------------------------------------
    // | 2ITF - 201x-201x
    // +----------------------------------------------------------
    // | Authex library
    // |
    // +----------------------------------------------------------
    // | Nelson Wells (http://nelsonwells.net/2010/05/creating-a-simple-extensible-codeigniter-authentication-library/)
    // | 
    // | aangepast door Thomas More
    // +----------------------------------------------------------

    public function __construct() {
        
        $CI = & get_instance();
        $CI->load->model('persoon_model');
    }

    function getPersoonInfo() {
        
        // geef persoon-object als zwemmer aangemeld is        
        $CI = & get_instance();

        if (!$this->isAangemeld()) {
            return null;
        } else {
            $id = $CI->session->userdata('Id');
            return $CI->persoon_model->get($id);
        }
    }

    function isAangemeld() {
        
        // persoon is aangemeld als sessievariabele gebruiker_id bestaat
        $CI = & get_instance();

        if ($CI->session->has_userdata('Id')) {
            return true;
        } else {
            return false;
        }
    }

    function meldAan($email, $wachtwoord) {
        
        // persoon aanmelden met opgegeven email en wachtwoord
        $CI = & get_instance();
        $persoon = $CI->persoon_model->getPersoon($email, $wachtwoord);

        if ($persoon == null) {
            return false;
        } else {
            $CI->session->set_userdata('Id', $persoon->id);
            return true;
        }
    }

    function meldAf() {
        
        // afmelden, dus sessievariabele wegdoen
        $CI = & get_instance();
        $CI->session->unset_userdata('Id');
    }
    
//    function registreer($naam, $email, $wachtwoord) {
//        // nieuwe persoon registreren als email nog niet bestaat
//        $CI = & get_instance();
//
//        if ($CI->persoon_model->controleerEmailVrij($email)) {
//            $id = $CI->persoon_model->voegToe($naam, $email, $wachtwoord);
//            return $id;
//        } else {
//            return 0;
//        }
//    }

}
