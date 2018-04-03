
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
    $this->db->where('id', $id);
    $query = $this->db->get('wedstrijd');
    return $query->row();
  }
  public function getIngeschrevenen($wedstrijdID) {
    // eerst reeksenperwedstrijd ophalen
    $this->db->where('wedstrijdId', $wedstrijdID);
    $query = $this->db->get('reeksperwedstrijd');
    $reeksPerWestrijd = $query->result();
    //inschrijvingen ophalen
    $persoonIDs = array();
    foreach ($reeksPerWestrijd as $reeks) {
      $this->db->where('reeksPerWedstrijdId', $reeks->id);
      $query = $this->db->get('inschrijving');
      $inschrijvingen = $query->result();
      foreach ($inschrijvingen as $inschrijving) {
        // $this->db->where('ID', $inschrijving->PersoonId);
        array_push($persoonIDs, $inschrijving->persoonId);
      }

    }
    //personen ophalen
    $namen = array();
    foreach ($persoonIDs as $value) {
      $this->db->where('id', $inschrijving->persoonId);
      $query = $this->db->get('persoon');
      $result = $query->row();
      array_push($namen, $result->voornaam. ' ' . $result->achternaam);
    }
    $personen = new stdClass();
    $personen->ID = $persoonIDs;
    $personen->namen = $namen;
    // $personen->namen = mysqli_fetch_object($this->db->query('SELECT CONCAT(persoon.Voornaam, persoon.Achternaam) As naam FROM `persoon` INNER JOIN inschrijving ON inschrijving.PersoonId = persoon.ID INNER JOIN reeksperwedstrijd ON reeksperwedstrijd.ID = inschrijving.ReeksPerWedstrijdId INNER JOIN wedstrijd ON wedstrijd.ID = reeksperwedstrijd.WedstrijdId WHERE wedstrijd.ID = 1'))->naam;
    // $personen->ID = mysqli_fetch_object($this->db->query('SELECT persoon.ID FROM `persoon` INNER JOIN inschrijving ON inschrijving.PersoonId = persoon.ID INNER JOIN reeksperwedstrijd ON reeksperwedstrijd.ID = inschrijving.ReeksPerWedstrijdId INNER JOIN wedstrijd ON wedstrijd.ID = reeksperwedstrijd.WedstrijdId WHERE wedstrijd.ID = 1'))->ID;

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
    $this->db->where('id', $id);
    $this->db->delete('wedstrijd');
    //ook bijhorende reeksen verwijderen
    $this->db->where('wedstrijdId', $id);
    $this->db->delete('reeksperwedstrijd');
  }
  public function insertWedstrijd($data) {
    $this->db->insert('wedstrijd', $data);
    return $this->db->insert_id();
  }
  public function updateWedstrijd($data) {
    $this->db->where('id', $data->id);
    $this->db->update('wedstrijd', $data);
  }
  public function insertReeksen($wedID, $reeksen) {
    $data = array();
    $i = 0;
    foreach ($reeksen->slagen as $slag) {
      $data = array(
        'WedstrijdId' => $wedID,
        'SlagId' => $slag,
        'AfstandId' => $reeksen->afstanden[$i]
      );

      $this->db->insert('reeksperwedstrijd', $data);
      $i++;
    }


  }
  public function getReeksenWithWedstrijdID($id) {
    $this->db->where('wedstrijdId', $id);
    $query = $this->db->get('reeksperwedstrijd');

    return $query->result();
  }
  public function getSlagWithID($id) {
    $this->db->where('id', $id);
    $query = $this->db->get('slag');
    return $query->row();
  }
  public function getAfstandWithID($id) {
    $this->db->where('id', $id);
    $query = $this->db->get('afstand');
    return $query->row();
  }

  public function updateReeksen($wedID,$reeksen) {
    //delete alle reekesen
    $this->db->where('wedstrijdId', $wedID);
    $this->db->delete('reeksperwedstrijd');

    //toevoegen van degene die er gekozen waren
    $this->insertReeksen($wedID,$reeksen);
  }

}

?>
