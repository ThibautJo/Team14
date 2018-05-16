<?php

class persoon_model extends CI_Model {
    // +----------------------------------------------------------
    // |    Trainingscentrum Wezenberg
    // +----------------------------------------------------------
    // |    Auteur: Jolien Lauwers  |   Helper: 
    // +----------------------------------------------------------
    // |
    // |    Persoon model
    // |
    // +----------------------------------------------------------
    // |    Team 14
    // +----------------------------------------------------------

    /**
     * @class Persoon_model.
     * @brief Model-klasse voor persoon
     *
     * Model-klasse die alle methodes bevat om te interacteren met de database-table persoon.
     */
    function __construct() {
        parent::__construct();
    }

    function get($id) {

        /**
         * Retourneert het record met id=$Id uit de tabel persoon.
         * @param $id De id van het record dat opgevraagd wordt.
         * @return Het opgevraagde record.
         */
        
        $this->db->where('id', $id);
        $query = $this->db->get('persoon');
        return $query->row();
    }

    function getPersoon($email, $wachtwoord) {
        
        /**
         * Retourneert een record uit de tabel persoon, met email=$email, wachtwoord=$wachtwoord en geactiveerd=1.
         * @param $email De email van het record dat opgevraagd wordt.
         * @param $wachtwoord Het wachtwoord van het record dat opgevraagd wordt.
         * @return Het opgevraagde record.
         */
        
        $this->db->where('email', $email);
        $query = $this->db->get('persoon');

        if ($query->num_rows() == 1) {
            $persoon = $query->row();
            // controleren of het wachtwoord overeenkomt


            if (password_verify($wachtwoord, $persoon->wachtwoord)) {
                return $persoon;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

}
