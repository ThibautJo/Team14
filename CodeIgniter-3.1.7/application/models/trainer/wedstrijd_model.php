
<?php

class wedstrijd_model extends CI_Model {
  /**
   * @class Wedstrijd_model
   * @brief Model-klasse voor wedstrijden
   *
   * Model-klasse met alle methodes die gebruikt worden om wedstrijden te beheren
   */

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

    $this->load->helper("my_html_helper");
    $this->load->helper("my_url_helper");
    $this->load->helper('url');
  }
  /**
   * \brief Retourneert de opgevraagde wedstrijden
   *
   * @param $start Is de startperiode van de wedstrijden
   * @param $end Is de einPeriode van de wedstrijden
   * @return De gevraagde wedstrijd(en)
   */
  public function getWedstrijden($start = null, $end = null) {
    if($start != null && $end != null){
      $this->db->where('datumStart >=', $start);
      $this->db->where('datumStop <=', $end);
    }

    $query = $this->db->get('wedstrijd');
    return $query->result();
  }
  /**
   * Retourneert
   *
   * @param $id De id van het gevraagde wedstrijd
   * @return Het gevraagde wedstrijd
   */
  public function getWedstrijdenWithId($id) {
    $this->db->where('id', $id);
    $query = $this->db->get('wedstrijd');
    return $query->row();
  }
  /**
   * Retourneert de ingeschrevenen bij het bijhorenede wedstrijd
   *
   * @param $wedstrijdID wedstrijd waar men in wilt zoeken
   * @return De ingeschrevenen bij het opgegeven wedstrijd
   */
  public function getIngeschrevenen($wedstrijdID) {
    // eerst reeksenperwedstrijd ophalen
    $this->db->where('wedstrijdId', $wedstrijdID);
    $query = $this->db->get('reeksPerWedstrijd');
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
  /**
   * Retourneert de afstanden van het wedstrijd
   *
   * @return Het opgevraagde record
   */
  public function getAfstanden() {
    $query = $this->db->get('afstand');
    return $query->result();
  }
  /**
   * Retourneert de slagen van het wedstrijd
   *
   * @return Het opgevraagde record
   */
  public function getSlagen() {
    $query = $this->db->get('slag');
    return $query->result();
  }
  /**
   * \brief Verwijderd de wedstrijd en bijhorende reeksen
   *
   * @param $id is het opgegeven wedstrijdID
   */
  public function deleteWedstrijd($id) {
    $this->db->where('id', $id);
    $this->db->delete('wedstrijd');
    //ook bijhorende reekse<getwedstrijdwith></getwedstrijdwith><getwedstrijdwith></getwedstrijdwith><getwedstrijdwi></getwedstrijdwi><getwedstrijd></getwedstrijd><getwed></getwed>n verwijderen
    $this->db->where('wedstrijdId', $id);
    $this->db->delete('reeksPerWedstrijd');
  }
  /**
   * Slaagt nieuw wedstrijd op
   *
   * @param $data is het wedstrijd object dat opgeslagen word
   * @return Het ingevoegde wedstrijd ID
   */
  public function insertWedstrijd($data) {
    $this->db->insert('wedstrijd', $data);
    return $this->db->insert_id();
  }
  /**
   * Update bestaand wedstrijd
   *
   * @param $data is het wedstrijd object dat geüpdate moet worden
   */
  public function updateWedstrijd($data) {
    $this->db->where('id', $data->id);
    $this->db->update('wedstrijd', $data);
  }
  /**
   * Slaagt nieuw wedstrijd op
   *
   * @param $wedID is het gegeven weddstrijd id
   * @param $reeksen zijn de reeksen die opgeslagen moeten worden
   */
  public function insertReeksen($wedID, $reeksen) {
    $data = array();
    $i = 0;
    foreach ($reeksen->slagen as $slag) {
      $data = array(
        'wedstrijdId' => $wedID,
        'slagId' => $slag,
        'afstandId' => $reeksen->afstanden[$i]
      );

      $this->db->insert('reeksPerWedstrijd', $data);
      $i++;
    }


  }
  /**
   * Haalt reeksen op die bij het opgegeven wedstrijd horen
   *
   * @param $id is het wedstrijd id
   * @return de reeksen van het gegeven wedstrijd
   */
  public function getReeksenWithWedstrijdID($id) {
    $this->db->where('wedstrijdId', $id);
    $query = $this->db->get('reeksPerWedstrijd');

    return $query->result();
  }
  /**
   * Slaagt nieuw wedstrijd op
   *
   * @param $id
   * @return de slag van opgegeven wedstrijd
   */
  public function getSlagWithID($id) {
    $this->db->where('id', $id);
    $query = $this->db->get('slag');
    return $query->row();
  }
  /**
   * Slaagt nieuw wedstrijd op
   *
   * @param $data is het wedstrijd object dat opgeslagen word
   * @return Het ingevoegde wedstrijd ID
   */
  public function getAfstandWithID($id) {
    $this->db->where('id', $id);
    $query = $this->db->get('afstand');
    return $query->row();
  }
  /**
   * update bestaande reeksen bijhorend bij opgegeven wedstrijd
   *
   * @param $wedID is het wedstrijd ID
   * @param $reeksen zijn de nieuwe reeksen die opgeslagen moeten worden
   * @see Wedstrijd_model::insertReeksen()
   */
  public function updateReeksen($wedID,$reeksen) {
    //delete alle reekesen
    $this->db->where('wedstrijdId', $wedID);
    $this->db->delete('reeksPerWedstrijd');

    //toevoegen van degene die er gekozen waren
    $this->insertReeksen($wedID,$reeksen);
  }


  public function getResultatenTabel($wedID = null){

    $resultaten = new stdClass();

    $query = $this->db->get('resultaat');

    $resultaten->resultaten = $query->result();
    $i = 0;
    foreach ($resultaten->resultaten as $resultaat) {
      $inschrijving = $this->getIngeschrevenenWithId($resultaat->inschrijvingId);
      $ronde = $this->getRondeWithId($resultaat->rondeId);
      $reeks = $this->getReeksWithID($inschrijving->reeksPerWedstrijdId);
      $persoon = $this->getPersoonWithId($inschrijving->persoonId);
      $slag = $this->getSlagWithID($reeks->slagId);
      $afstand = $this->getAfstandWithID($reeks->afstandId);
      $wedstrijd = $this->getWedstrijdenWithId($reeks->wedstrijdId);

      if ($wedID != null) {
        if ($wedstrijd->id === $wedID) {
          $resultaten->resultaten[$i]->ronde = $ronde->ronde;
          $resultaten->resultaten[$i]->reeks = $afstand->afstand .' '. $slag->slag;
          $resultaten->resultaten[$i]->persoonNaam = $persoon->voornaam .' '.$persoon->achternaam;
          $resultaten->resultaten[$i]->wedstrijdNaam = $wedstrijd->naam;
        }
        else{
          unset($resultaten->resultaten[$i]);
        }
      }
      else {
        $resultaten->resultaten[$i]->ronde = $ronde->ronde;
        $resultaten->resultaten[$i]->reeks = $afstand->afstand .' '. $slag->slag;
        $resultaten->resultaten[$i]->persoonNaam = $persoon->voornaam .' '.$persoon->achternaam;
        $resultaten->resultaten[$i]->wedstrijdNaam = $wedstrijd->naam;
      }


      $i++;
    }

    return $resultaten;

  }
  public function getRondes(){
    $query = $this->db->get('ronde');
    return $query->result();
  }
  public function getRondeWithId($id){
    $this->db->where('id', $id);
    $query = $this->db->get('ronde');
    return $query->row();
  }
  public function getIngeschrevenenWithId($id){
    $this->db->where('id', $id);
    $query = $this->db->get('inschrijving');
    return $query->row();
  }

  public function getReeksWithID($id){
    $this->db->where('id', $id);
    $query = $this->db->get('reeksPerWedstrijd');
    return $query->row();
  }
  public function getPersoonWithId($id){
    $this->db->where('id', $id);
    $query = $this->db->get('persoon');
    return $query->row();
  }

}

?>
