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
        $CI->load->model('sessies_model');
    }

//    function activeer($id) {
//        
//        // nieuwe gebruiker activeren
//        $CI = & get_instance();
//
//        $CI->zwemmer_model->activeer($id);
//    }

    function getPersoonInfo() {
        
        // geef gebruiker-object als zwemmer aangemeld is        
        $CI = & get_instance();

        if (!$this->isAangemeld()) {
            return null;
        } else {
            $id = $CI->session->userdata('ID');
            return $CI->sessies_model->get($id);
        }
    }

    function isAangemeld() {
        
        // gebruiker is aangemeld als sessievariabele gebruiker_id bestaat
        $CI = & get_instance();

        if ($CI->session->has_userdata('ID')) {
            return true;
        } else {
            return false;
        }
    }

    function meldAan($email, $wachtwoord) {
        
        // gebruiker aanmelden met opgegeven email en wachtwoord
        $CI = & get_instance();
        $persoon = $CI->sessies_model->getPersoon($email, $wachtwoord);

        if ($persoon == null) {
            return false;
        } else {
            
            // $CI->sessies_model->updateLaatstAangemeld($persoon->id);            
            $CI->session->set_userdata('ID', $persoon->ID);
            return true;
        }
    }

    function meldAf() {
        
        // afmelden, dus sessievariabele wegdoen
        $CI = & get_instance();
        $CI->session->unset_userdata('ID');
    }

}
