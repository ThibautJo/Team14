<?php

/**
 * @class Inschrijving_model
 * @brief Model-klasse voor inschrijvingen
 *
 * Model-klasse die alle methodes bevat om te interageren met de database-table inschrijving
 */
class Inschrijving_model extends CI_Model {
    // +----------------------------------------------------------
    // |    Trainingscentrum Wezenberg
    // +----------------------------------------------------------
    // |    Auteur: Lise Van Eyck       |       Helper:
    // +----------------------------------------------------------
    // |
    // |    Inschrijving model
    // |
    // +----------------------------------------------------------
    // |    Team 14
    // +----------------------------------------------------------

    /**
     * Constructor
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * Retourneert het record met id=$id uit de tabel inschrijving
     * @param $id De id van het record dat opgevraagd wordt
     * @return Het opgevraagde record
     */
    function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('inschrijving');
        return $query->row();
    }

    /**
     * Retourneert een array van alle inschrijvingen in behandeling met bijhorende
     * persoon en wedstrijd
     * 
     * @return De opgevraagde array
     */
    function getInschrijvingen() {
        $this->db->where('status', 1);
        $query = $this->db->get('inschrijving');
        $inschrijving = $query->result();

        $inschrijvingen = array();
        foreach ($inschrijving as $item) {
            $inschrijven = array();
            $inschrijven['inschrijving'] = $item->id;
            $inschrijven['persoonId'] = $item->persoonId;

            $this->db->where('id', $item->persoonId);
            $queryPersoon = $this->db->get('persoon');
            $this->db->where('id', $item->reeksPerWedstrijdId);
            $queryReeksPerWedstrijd = $this->db->get('reeksPerWedstrijd');
            $reeksPerWedstrijd = $queryReeksPerWedstrijd->row();

            $this->db->where('id', $reeksPerWedstrijd->slagId);
            $querySlag = $this->db->get('slag');
            $this->db->where('id', $reeksPerWedstrijd->afstandId);
            $queryAfstand = $this->db->get('afstand');
            $this->db->where('id', $reeksPerWedstrijd->wedstrijdId);
            $queryWedstrijd = $this->db->get('wedstrijd');

            $persoon = $queryPersoon->row();
            $slag = $querySlag->row();
            $afstand = $queryAfstand->row();
            $wedstrijd = $queryWedstrijd->row();

            $obj_merged = (object) array_merge((array) $persoon, (array) $inschrijven, (array) $reeksPerWedstrijd, (array) $slag, (array) $afstand, (array) $wedstrijd);
            array_push($inschrijvingen, $obj_merged);
        }



        return $inschrijvingen;
    }

    /**
     * Retourneert een array van alle reeksen van bepaalde wedstrijd
     * 
     * @param $id De id van het record dat opgevraagd wordt
     * @return De opgevraagde array
     */
    public function getReeksPerWedstrijd($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('reeksPerWedstrijd');

        $reeksPerWedstrijd = $query->result();

        $reeksen = array();
        foreach ($reeksPerWedstrijd as $item) {
            $reeksWedstrijd = array();
            $reeksWedstrijd['reeksPerWedstrijd'] = $item->id;

            $this->db->where('id', $item->slagId);
            $querySlag = $this->db->get('slag');
            $this->db->where('id', $item->afstandId);
            $queryAfstand = $this->db->get('afstand');
            $this->db->where('id', $item->wedstrijdId);
            $queryWedstrijd = $this->db->get('wedstrijd');

            $wedstrijd = $queryWedstrijd->row();
            $slag = $querySlag->row();
            $afstand = $queryAfstand->row();

            $obj_merged = (object) array_merge((array) $slag, (array) $afstand, (array) $wedstrijd, (array) $reeksWedstrijd);
            array_push($reeksen, $obj_merged);
        }
        return $reeksen;
    }

    /**
     * Voegt een nieuw record toe aan de tabel inschrijving
     * @param $inschrijving Het inschrijvingen object waar de ingevulde data in zit
     */
    function insertInschrijving($inschrijving) {
        $this->db->insert('inschrijving', $inschrijving);
    }

    /**
     * Wijzigt een inschrijving-record uit de tabel inschrijving
     * @param $inschrijving Het inschrijvingen object waar de aangepaste data in zit
     */
    function updateInschrijving($inschrijving) {
        $this->db->where('id', $inschrijving->id);
        $this->db->update('inschrijving', $inschrijving);
    }

}

?>
