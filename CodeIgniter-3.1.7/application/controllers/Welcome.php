<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        $this->load->helper("MY_html_helper");
        $this->load->helper("MY_url_helper");
        $this->load->helper('url');
        $this->load->helper('form');
    }

    public function index() {
        $data['titel'] = 'Home';        
        $data['persoon'] = $this->authex->getPersoonInfo();
        
        $partials = array('hoofding' => 'bezoeker_main_header',
            'inhoud' => 'bezoeker/home',
            'voetnoot' => 'bezoeker_main_footer');
//        
//
//        $partials = array('hoofding' => 'main_header',
//            'menu' => 'main_menu',
//            'inhoud' => 'zwemmer/home',
//            'voetnoot' => 'main_footer');
        
        
//        $partials = array('hoofding' => 'main_header',
//            'menu' => 'trainer_main_menu',
//            'inhoud' => 'trainer/home',
//            'voetnoot' => 'main_footer');

        $this->template->load('bezoeker_main_master', $partials, $data);
    }
    
    public function meldAan()
    {
        $data['titel'] = 'Aanmelden';
        $data['persoon']  = $this->authex->getPersoonInfo();

        $partials = array('hoofding' => 'bezoeker_main_header',
            'menu' => 'bezoeker_main_menu',
            'inhoud' => 'bezoeker/home_sessies', 
            'voetnoot' => 'bezoeker_main_footer');

        $this->template->load('main_master', $partials, $data);
    }

    public function toonFout()
    {
        $data['titel'] = 'Fout';
        $data['persoon']  = $this->authex->getPersoonInfo();

        $partials = array('hoofding' => 'bezoeker_main_header',
            'inhoud' => 'home_fout',
            'voetnoot' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }

    public function controleerAanmelden()
    {
        $email = $this->input->post('Email');
        $wachtwoord = $this->input->post('Wachtwoord');

        if ($this->authex->meldAan($email, $wachtwoord)) {
            redirect('Welcome');
        } else {
            redirect('Trainer/Supplement');
        }
    } 

    public function meldAf()
    {
        $this->authex->meldAf();
        redirect('Welcome');
    }       

}
