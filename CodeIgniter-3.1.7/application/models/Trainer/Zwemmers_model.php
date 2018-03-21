
<?php

class Zwemmers_model extends CI_Model {

    // +----------------------------------------------------------
    // |    Trainingscentrum Wezenberg
    // +----------------------------------------------------------
    // |
    // |    Zwemmers model
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

    public function getZwemmer($persoonId) {
        $this->db->where('id', $persoonId);
        $query = $this->db->get('persoon');
        return $query->row();
    }

}

?>

