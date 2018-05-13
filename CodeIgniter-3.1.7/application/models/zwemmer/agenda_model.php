<?php

class Agenda_model extends CI_Model {

    // +----------------------------------------------------------
    // |    Trainingscentrum Wezenberg
    // +----------------------------------------------------------
    // |    Auteur: Tom Nuyts       |       Helper:
    // +----------------------------------------------------------
    // |
    // |    Agenda model
    // |
    // +----------------------------------------------------------
    // |    Team 14
    // +----------------------------------------------------------

    function __construct() {
        parent::__construct();

        //helpers inladen
        $this->load->helper("my_html_helper");
        $this->load->helper("my_url_helper");
        $this->load->helper('url');
    }

    public function getActiviteit($activiteitId) {
        // Activiteit ophalen uit de databank
        $this->db->where('id', $activiteitId);
        $query = $this->db->get('activiteit');
        return $query->row();
    }

    public function getTypeActiviteit($activiteitId) {
        // Type activiteit ophalen uit de databank (training of stage)
        $this->db->where('id', $activiteitId);
        $query = $this->db->get('typeActiviteit');
        return $query->row();
    }

    public function getTypeTraining($trainingId) {
        // Type training ophalen uit de databank
        $this->db->where('id', $trainingId);
        $query = $this->db->get('typeTraining');
        return $query->row();
    }

    public function getVolledigeActiviteit($activiteitId) {
        $this->db->where('id', $activiteitId);
        $query = $this->db->get('activiteit');

        $activiteit = $query->row();
        $activiteit->typeTraining = $this->getTypeTraining($activiteit->typeTrainingId);
        $activiteit->typeActiviteit = $this->getTypeActiviteit($activiteit->typeActiviteitId);

        return $activiteit;
    }

    public function getAllTypeTraining() {
        // Type trainingen ophalen uit de databank
        $query = $this->db->get('typeTraining');
        $trainingen = $query->result();
        $soortTrainingen = [];

        $teller = 0;
        foreach ($trainingen as $training) {
            $soortTrainingen[$teller] = ucfirst($training->typeTraining);
            $teller++;
        }
        $soortTrainingen[$teller] = NULL;

        return $soortTrainingen;
    }

    public function getActiviteitenByPersoon($persoonId) {
        // Alle activiteiten (trainingen en stages) van een bepaalde persoon ophalen uit de databank
        $this->db->where('persoonid', $persoonId);
        $query = $this->db->get('activiteitPerPersoon');

        $activiteiten = $query->result();

        foreach ($activiteiten as $activiteit) {
            // Tabel activiteitperpersoon joinen met de tabel activiteit, typeactiviteit en typetraining
            $activiteit->activiteit = $this->getActiviteit($activiteit->activiteitId);
            
            $activiteit->typeActiviteit = $this->getTypeActiviteit($activiteit->activiteit->typeActiviteitId);

            $activiteit->typeTraining = $this->getTypeTraining($activiteit->activiteit->typeTrainingId);
        }

        return $activiteiten;
    }

    public function getReeksPerWedstrijd($reeksPerWedstrijdId) {
        // Wedstrijdreeks ophalen uit de databank
        $this->db->where('id', $reeksPerWedstrijdId);
        $query = $this->db->get('reeksPerWedstrijd');
        return $query->row();
    }
    
    public function getReeksenPerWedstrijd($wedstrijdId) {
        // Wedstrijdreeks ophalen uit de databank
        $this->db->where('wedstrijdId', $wedstrijdId);
        $query = $this->db->get('reeksPerWedstrijd');
        return $query->result();
    }
    
    public function getWedstrijd($wedstrijdId) {
        // Wedstrijd ophalen uit de databank
        $this->db->where('id', $wedstrijdId);
        $query = $this->db->get('wedstrijd');
        return $query->row();
    }
    
//    public function getPersonenFromWedstrijd($wedstrijdId) {
//        // Personen die deelnemen aan een wedstrijd ophalen uit de databank
//        $query = $this->getReeksenPerWedstrijd($this->getWedstrijd($wedstrijdId));
//        $reeksenPerWedstrijd = $query->result();
//        $personen = [];
//        
//        foreach ($reeksenPerWedstrijd as $reeksPerWedstrijd) {
//            $this->db->where('reeksPerWedstrijdId', $reeksPerWedstrijd->id);
//            $query = $this->db->get('inschrijving');
//            $inschrijving = $query->row();
//            
//            $personen = $inschrijving->persoonId;
//        }
//        
//        return $personen;
//    }

    public function getWedstrijdenByPersoon($persoonId) {
        // Alle wedstrijden van een bepaalde persoon ophalen uit de databank
        $this->db->where('persoonid', $persoonId);
        $query = $this->db->get('inschrijving');

        $wedstrijden = $query->result();

        foreach ($wedstrijden as $wedstrijd) {
            // Tabel inschrijving joinen met de tabel reeksperwedstrijd en wedstrijd
            $wedstrijd->reeksPerWedstrijd = $this->getReeksPerWedstrijd($wedstrijd->reeksPerWedstrijdId);

            $wedstrijd->wedstrijd = $this->getWedstrijd($wedstrijd->reeksPerWedstrijd->wedstrijdId);
        }

        return $wedstrijden;
    }

    public function getOnderzoekenByPersoon($persoonId) {
        // Alle medische onderzoeken van een bepaalde persoon ophalen uit de databank
        $this->db->where('persoonid', $persoonId);
        $query = $this->db->get('medischeAfspraak');
        return $query->result();
    }

    public function getOnderzoek($onderzoekId) {
        // Alle medische onderzoeken van een bepaalde persoon ophalen uit de databank
        $this->db->where('id', $onderzoekId);
        $query = $this->db->get('medischeAfspraak');
        return $query->row();
    }

    public function getSupplement($supplementId) {
        // Supplement ophalen uit de databank
        $this->db->where('id', $supplementId);
        $query = $this->db->get('supplementPerPersoon');

        $supplement = $query->row();
        $supplement->supplement = $this->getSupplementPersoon($supplement->supplementId);
        $supplement->functie = $this->getSupplementFunctie($supplement->supplement->supplementFunctieId);

        return $supplement;
    }

    public function getSupplementPersoon($supplementId) {
        // Supplement ophalen uit de databank
        $this->db->where('id', $supplementId);
        $query = $this->db->get('supplement');
        return $query->row();
    }

    public function getAllSupplementen() {
        // Supplementen ophalen uit de databank
        $query = $this->db->get('supplement');
        $supplementen = $query->result();
        $supplementenNamen = [];

        $teller = 0;
        foreach ($supplementen as $supplement) {
            $supplementenNamen[$teller] = ucfirst($supplement->naam);
            $teller++;
        }

        return $supplementenNamen;
    }

    public function getSupplementFunctie($functieId) {
        // Functie van een supplement ophalen uit de databank
        $this->db->where('id', $functieId);
        $query = $this->db->get('supplementFunctie');
        return $query->row();
    }

    public function getSupplementenByPersoon($persoonId) {
        // Alle supplementen van een bepaalde persoon ophalen uit de databank
        $this->db->where('persoonid', $persoonId);
        $query = $this->db->get('supplementPerPersoon');

        $supplementen = $query->result();

        foreach ($supplementen as $supplement) {
            // Tabel supplementperpersoon joinen met de tabel supplementfunctie
            $supplement->supplement = $this->getSupplementPersoon($supplement->supplementId);

            $supplement->functie = $this->getSupplementFunctie($supplement->supplement->supplementFunctieId);
        }

        return $supplementen;
    }

    public function getKleurenActiviteiten() {
        // De kleuren van de verschillende activiteiten ophalen uit de databank
        $query = $this->db->get('kleur');
        return $query->result();
    }

    public function getKleurActiviteit($kleurId) {
        // De kleur van een activiteit ophalen uit de databank
        $this->db->where('id', $kleurId);
        $query = $this->db->get('kleur');
        return $query->row();
    }
}
