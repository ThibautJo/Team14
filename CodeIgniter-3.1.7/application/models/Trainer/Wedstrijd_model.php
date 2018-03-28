
<?php

class Wedstrijd_model extends CI_Model {

  // +----------------------------------------------------------
  // |    Trainingscentrum Wezenberg
  // +----------------------------------------------------------
  // |    Auteur: Klaus Daems       |       Helper:
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
  public function insertWedstrijd($naam,$start,$end,$plaats,$programma) {
    $data = array(
      'Naam' => $naam,
      'DatumStart' => $start,
      'DatumStop' => $end
    );

    // $data = array(
    //   'Naam' => $naam,
    //   'DatumStart' => $start,
    //   'DatumStop' => $end,
    //   'Plaats' => $plaats,
    //   'Programma' => $programma
    // );

    $this->db->insert('wedstrijd', $data);
  }

}

?>
