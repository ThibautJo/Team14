<?php

class persoon_model extends CI_Model {

    // +----------------------------------------------------------
    // |    Trainingscentrum Wezenberg
    // +----------------------------------------------------------
    // |    Auteur: Jolien Lauwers  |   Helper: Tom Nuyts
    // +----------------------------------------------------------
    // |
    // |    Persoon model
    // |
    // +----------------------------------------------------------
    // |    Team 14
    // +----------------------------------------------------------

    function __construct() {
        parent::__construct();
    }

    function get($id) {

        // geef persoon-object met opgegeven $id
        $this->db->where('id', $id);
        $query = $this->db->get('persoon');
        return $query->row();
    }

    function getPersoon($email, $wachtwoord) {
        // geef persoon-object met $email en $wachtwoord EN geactiveerd = 1
        $this->db->where('email', $email);
        $query = $this->db->get('persoon');

        if ($query->num_rows() == 1) {
            $persoon = $query->row();
            // controleren of het wachtwoord overeenkomt


            if (password_verify($wachtwoord, $persoon->wachtwoord)){
                return $persoon;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

//    function controleerEmailVrij($email) {
//        // is email al dan niet aanwezig
//        $this->db->where('email', $email);
//        $query = $this->db->get('persoon');
//
//        if ($query->num_rows() == 0) {
//            return true;
//        } else {
//            return false;
//        }
//    }
//
//    function voegToe($voornaam, $achternaam, $straat, $huistnummer, $postcode, $gemeente, $telefoonnummer, $email, $wachtwoord) {
//        // voeg nieuwe gebruker toe
//        $gebruiker = new stdClass();
//        $gebruiker->voornaam = $voornaam;
//        $gebruiker->achternaam = $achternaam;
//        $gebruiker->straat = $straat;
//        $gebruiker->huistnummer = $huistnummer;
//        $gebruiker->postcode = $postcode;
//        $gebruiker->gemeente = $gemeente;
//        $gebruiker->telefoonnummer = $telefoonnummer;
//        $gebruiker->email = $email;
//        $gebruiker->wachtwoord = password_hash($wachtwoord, PASSWORD_DEFAULT);
//        $gebruiker->soort = 'Zwemmer';
//        $this->db->insert('persoon', $gebruiker);
//        return $this->db->insert_id();
//    }
}
