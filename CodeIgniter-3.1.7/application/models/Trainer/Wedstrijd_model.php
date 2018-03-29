
<?php

class Wedstrijd_model extends CI_Model {

  // +----------------------------------------------------------
  // |    Trainingscentrum Wezenberg
  // +----------------------------------------------------------
  // |    Auteur: Thibaut Joukes       |       Helper:
  // +----------------------------------------------------------
  // |
  // |    Agenda model
  // |
  // +----------------------------------------------------------
  // |    Team 14
  // +----------------------------------------------------------

  function __construct() {
    parent::__construct();

    $this->load->helper("MY_html_helper");
    $this->load->helper("MY_url_helper");
    $this->load->helper('url');
  }

  public function getWedstrijden() {
    $query = $this->db->get('wedstrijd');
    return $query->result();
  }
  public function getWedstrijdenWithId($id) {
    $this->db->where('ID', $id);
    $query = $this->db->get('wedstrijd');
    return $query->row();
  }
  public function getIngeschrevenen($wedstrijdID) {
    // eerst reeksenperwedstrijd ophalen
    $this->db->where('WedstrijdId', $wedstrijdID);
    $query = $this->db->get('reeksperwedstrijd');
    $reeksPerWestrijd = $query->result();
    //inschrijvingen ophalen
    $persoonIDs = array();
    foreach ($reeksPerWestrijd as $reeks) {
      $this->db->where('ReeksPerWedstrijdId', $reeks->ID);
      $query = $this->db->get('inschrijving');
      $inschrijvingen = $query->result();
      foreach ($inschrijvingen as $inschrijving) {
        // $this->db->where('ID', $inschrijving->PersoonId);
        array_push($persoonIDs, $inschrijving->PersoonId);
      }

    }
    //personen ophalen
    $namen = array();
    foreach ($persoonIDs as $value) {
      $this->db->where('ID', $inschrijving->PersoonId);
      $query = $this->db->get('persoon');
      $result = $query->row();
      array_push($namen, $result->Voornaam. ' ' . $result->Achternaam);
    }
    $personen = new stdClass();
    $personen->ID = $persoonIDs;
    $personen->namen = $namen;

    return $personen;
  }
  public function getAfstanden() {
    $query = $this->db->get('afstand');
    return $query->result();
  }
  public function getSlagen() {
    $query = $this->db->get('slag');
    return $query->result();
  }
  public function deleteWedstrijd($id) {
    $this->db->where('ID', $id);
    $this->db->delete('wedstrijd');
  }
  public function insertWedstrijd($data) {
    $this->db->insert('wedstrijd', $data);
  }
  public function updateWedstrijd($data) {
    $this->db->where('ID', $data->ID);
    $this->db->replace('wedstrijd', $data);
  }

}

?>
