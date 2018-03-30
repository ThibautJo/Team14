<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sessies extends CI_Controller {

        // +----------------------------------------------------------
        // | Fair Trade Shop - sessies
        // +----------------------------------------------------------
        // | 2 ITF - 201x-201x
        // +----------------------------------------------------------
        // | Sessies controller
        // |
        // +----------------------------------------------------------
        // | Thomas More
        // +----------------------------------------------------------
    
        public function __construct()
	{
            parent::__construct();
            
            $this->load->helper('url');
            $this->load->library('session');
        }
        
        public function index()
	{
            if ($this->session->has_userdata('aangemeld')) {
                $data['aangemeld'] = true;
                
                $data['gebruikersnaam'] = $this->session->userdata('gebruikersnaam');
                $data['email'] = $this->session->userdata('email');
                
            } else {
                $data['aangemeld'] = false; 
            }
            
            $data['titel']  = 'Sessies';
            
            $partials = array('hoofding' => 'main_header',
                'inhoud' => 'sessies_toon', 
                'voetnoot' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
	}

        public function meldAan()
	{            
            $this->session->set_userdata('gebruikersnaam', 'johndoe');
            $this->session->set_userdata('email', 'johndoe@some-site.com');
            $this->session->set_userdata('aangemeld', TRUE);
            
            redirect('sessies/index');
	}

        public function meldAf()
	{            
            $this->session->unset_userdata('gebruikersnaam');
            $this->session->unset_userdata('email');
            $this->session->unset_userdata('aangemeld');
            
            redirect('sessies/index');
	}
        
}

/* End of file Sessies.php */
/* Location: ./application/controllers/Sessies.php */