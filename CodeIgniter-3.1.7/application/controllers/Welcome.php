<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->helper("my_html_helper");
        $this->load->helper("my_url_helper");
        $this->load->helper('url');
        $this->load->helper('form');

        // Auteur inladen in footer
        $this->data = new stdClass();
        $this->data->team = array("Klied Daems" => "false", "Thibaut Joukes" => "false", "Jolien Lauwers" => "true", "Tom Nuyts" => "false", "Lise Van Eyck" => "false");
    }

    public function index() {
        $data['titel'] = 'Home';
        $data['team'] = $this->data->team;
        $data['persoon'] = $this->authex->getPersoonInfo();

        $partials = array('hoofding' => 'bezoeker_main_header',
            'inhoud' => 'bezoeker/home',
            'aanmeldFormulier' => 'bezoeker/home_aanmelden',
            'voetnoot' => 'bezoeker_main_footer');

        $this->template->load('bezoeker_main_master', $partials, $data);
    }

    public function meldAan()
    {
        $data['titel'] = 'Aanmelden';
        $data['team'] = $this->data->team;
        $data['persoon']  = $this->authex->getPersoonInfo();

        $partials = array('hoofding' => 'bezoeker_main_header',
            'inhoud' => 'bezoeker/home',
            'aanmeldFormulier' => 'bezoeker/home_aanmelden',
            'voetnoot' => 'bezoeker_main_footer');

        $this->template->load('bezoeker_main_master', $partials, $data);
    }

    public function toonFout()
    {
        $data['titel'] = 'Fout';
        $data['team'] = $this->data->team;
        $data['persoon']  = $this->authex->getPersoonInfo();

        $data['foutBoodschap'] = "De combinatie van het email-adres en wachtwoord is foutief! Probeer opnieuw.";

        $partials = array('hoofding' => 'bezoeker_main_header',
            'inhoud' => 'bezoeker/home',
            'foutMelding' => 'bezoeker/home_fout',
            'voetnoot' => 'bezoeker_main_footer');

        $this->template->load('bezoeker_main_master', $partials, $data);
    }

    public function controleerAanmelden()
    {
        $email = $this->input->post('email');
        $wachtwoord = $this->input->post('wachtwoord');

        if ($this->authex->meldAan($email, $wachtwoord)) {
            
            $persoon = $this->authex->getPersoonInfo();
            
            // controleren welk soort gebruiker zich aanmeldt            
            switch ($persoon->soort) {
                case "Trainer":
                    redirect('trainer/supplement');
                    break;
                case "Zwemmer":
                    redirect('zwemmer/agenda');
                    break;
            }   
            
        } else {
            redirect('welcome/toonFout');
        }
    }

    public function meldAf()
    {
        $this->authex->meldAf();
        redirect('Welcome');
    }

}
