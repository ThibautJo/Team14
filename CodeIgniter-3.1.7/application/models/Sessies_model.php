<?php

class Sessies_model extends CI_Model {

    // +----------------------------------------------------------
    // |    Trainingscentrum Wezenberg
    // +----------------------------------------------------------
    // |
    // |    Zwemmer model
    // |
    // +----------------------------------------------------------
    // |    Team 14
    // +----------------------------------------------------------

    function __construct() {
        parent::__construct();
        
    }
    
    // +----------------------------------------------------------
    // |    Auteur: Lauwers Jolien      |       Helper: Lise Van Eyck
    // +----------------------------------------------------------
    // |
    // |    Aanmelden & afmelden
    // |
    // +----------------------------------------------------------
     

    function get($id) {
        
        // geef gebruiker-object met opgegeven $id   
        
        $this->db->where('ID', $id);
        $query = $this->db->get('persoon');
        return $query->row();
    }

    function getPersoon($email, $wachtwoord) {
        
        /**
         *  geef persson-object met $email en $wachtwoord EN geactiveerd = 1
         */
        
        $this->db->where('Email', $email);
        $query = $this->db->get('persoon');
        
        if ($query->num_rows() == 1) {
            $persoon = $query->row();
            
            // controleren of het wachtwoord overeenkomt
            if (password_verify($wachtwoord, $persoon->Wachtwoord)) {
                return $persoon;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

//    function updateLaatstAangemeld($id) {
//        
//        // pas tijd laatstAangemeld aan
//        $gebruiker = new stdClass();
//        $gebruiker->laatstAangemeld = date("Y-m-d H-i-s");
//        $this->db->where('id', $id);
//        $this->db->update('tv_gebruiker', $gebruiker);
//    }

    
//    function voegToe($naam, $email, $wachtwoord) {
//        // voeg nieuwe gebruker toe
//        $gebruiker = new stdClass();
//        $gebruiker->naam = $naam;
//        $gebruiker->email = $email;
//        $gebruiker->wachtwoord = password_hash($wachtwoord, PASSWORD_DEFAULT);
//        $gebruiker->level = 1;
//        $gebruiker->creatie = date("Y-m-d H-i-s");
//        $gebruiker->laatstAangemeld = date("Y-m-d H-i-s");
//        $gebruiker->geactiveerd = 0;
//        $this->db->insert('tv_gebruiker', $gebruiker);
//        return $this->db->insert_id();
//    }
//
//    function activeer($id) {
//        // plaats geactiveerd op 1
//        $gebruiker = new stdClass();
//        $gebruiker->geactiveerd = 1;
//        $this->db->where('id', $id);
//        $this->db->update('tv_gebruiker', $gebruiker);
//    }

    
}
