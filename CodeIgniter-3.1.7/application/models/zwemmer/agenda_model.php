<?php

/**
 * @class Agenda_model
 * @brief Model-klasse voor agenda
 *
 * Model-klasse die alle methodes bevat om de agenda te laten zien
 */

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

    /**
     * Constructor
     */
    
    function __construct() {
        parent::__construct();

        //helpers inladen
        $this->load->helper("my_html_helper");
        $this->load->helper("my_url_helper");
        $this->load->helper('url');
    }
    
    /**
     * Retourneert een activiteit
     * @param $activiteitId De id van de activiteit
     * @return Het opgevraagde record
     */

    public function getActiviteit($activiteitId) {
        // Activiteit ophalen uit de databank
        $this->db->where('id', $activiteitId);
        $query = $this->db->get('activiteit');
        return $query->row();
    }
    
    /**
     * Retourneert een typeActiviteit
     * @param $activiteitId De id van de activiteit waarvan je een typeActiviteit opvraagt
     * @return Het opgevraagde record
     */

    public function getTypeActiviteit($activiteitId) {
        // Type activiteit ophalen uit de databank (training of stage)
        $this->db->where('id', $activiteitId);
        $query = $this->db->get('typeActiviteit');
        return $query->row();
    }
    
    /**
     * Retourneert een typeTraining
     * @param $trainingId De id van de soort training waarvan je een typeTraining opvraagt
     * @return Het opgevraagde record
     */

    public function getTypeTraining($trainingId) {
        // Type training ophalen uit de databank
        $this->db->where('id', $trainingId);
        $query = $this->db->get('typeTraining');
        return $query->row();
    }
    
    /**
     * Retourneert een volledig activiteiten object inclusief al zijn relatietabellen
     * @param $activiteitId De id van de activiteit die wordt opgevraagd
     * @see getTypeTraining($typeTrainingId)
     * @see getTypeActiviteit($typeActiviteitId)
     * @return Het opgevraagde record
     */

    public function getVolledigeActiviteit($activiteitId) {
        $this->db->where('id', $activiteitId);
        $query = $this->db->get('activiteit');

        $activiteit = $query->row();
        $activiteit->typeTraining = $this->getTypeTraining($activiteit->typeTrainingId);
        $activiteit->typeActiviteit = $this->getTypeActiviteit($activiteit->typeActiviteitId);

        return $activiteit;
    }
    
    /**
     * Retourneert een alle training types
     * @return Het opgevraagde record
     */

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
    
    /**
     * Retourneert alle activiteiten van een bepaalde persoon
     * @param $persoonId De id van de persoon waarvan je de activiteiten opvraagt
     * @see getActiviteit($activiteitId)
     * @see getTypeActiviteit($typeActiviteitId)
     * @see getTypeTraining($typeTrainingId)
     * @return Het opgevraagde record
     */

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
    
     /**
     * Retourneert een reeksPerWedstrijd
     * @param $reeksPerWedstrijdId De id van de reeksPerWedstrijd die je opvraagt
     * @return Het opgevraagde record
     */

    public function getReeksPerWedstrijd($reeksPerWedstrijdId) {
        // Wedstrijdreeks ophalen uit de databank
        $this->db->where('id', $reeksPerWedstrijdId);
        $query = $this->db->get('reeksPerWedstrijd');
        return $query->row();
    }
    
    /**
     * Retourneert alle reeksPerWedstrijd objecten van een bepaalde wedstrijd
     * @param $wedstrijdId De id van de wedstrijd die je opvraagt
     * @return Het opgevraagde record
     */
    
    public function getReeksenPerWedstrijd($wedstrijdId) {
        // Wedstrijdreeks ophalen uit de databank
        $this->db->where('wedstrijdId', $wedstrijdId);
        $query = $this->db->get('reeksPerWedstrijd');
        return $query->result();
    }
    
    /**
     * Retourneert een wedstrijd
     * @param $wedstrijdId De id van de wedstrijd die je opvraagt
     * @return Het opgevraagde record
     */
    
    public function getWedstrijd($wedstrijdId) {
        // Wedstrijd ophalen uit de databank
        $this->db->where('id', $wedstrijdId);
        $query = $this->db->get('wedstrijd');
        return $query->row();
    }
    
    /**
     * Retourneert alle wedstrijden waar een bepaalde persoon aan deelneemt
     * @param $persoonId De id van de persoon waarvan je de wedstrijden opvraagt
     * @see getReeksPerWedstrijd($reeksPerWedstrijdId)
     * @see getWedstrijd($wedstrijdId)
     * @return Het opgevraagde record
     */

    public function getWedstrijdenByPersoon($persoonId) {
        // Alle wedstrijden van een bepaalde persoon ophalen uit de databank (inschrijving moet geaccepteerd zijn ==> status = 2)
        $this->db->where('persoonid', $persoonId);
        $this->db->where('status', 2);
        $query = $this->db->get('inschrijving');

        $wedstrijden = $query->result();

        foreach ($wedstrijden as $wedstrijd) {
            // Tabel inschrijving joinen met de tabel reeksperwedstrijd en wedstrijd
            $wedstrijd->reeksPerWedstrijd = $this->getReeksPerWedstrijd($wedstrijd->reeksPerWedstrijdId);

            $wedstrijd->wedstrijd = $this->getWedstrijd($wedstrijd->reeksPerWedstrijd->wedstrijdId);
        }

        return $wedstrijden;
    }
    
    /**
     * Retourneert alle medische afspraken waar een bepaalde persoon aan deelneemt
     * @param $persoonId De id van de persoon waarvan je de medische afspraken opvraagt
     * @return Het opgevraagde record
     */

    public function getOnderzoekenByPersoon($persoonId) {
        // Alle medische onderzoeken van een bepaalde persoon ophalen uit de databank
        $this->db->where('persoonid', $persoonId);
        $query = $this->db->get('medischeAfspraak');
        return $query->result();
    }
    
    /**
     * Retourneert een medische afspraak
     * @param $onderzoekId De id van de medische afspraak die je opvraagt
     * @return Het opgevraagde record
     */

    public function getOnderzoek($onderzoekId) {
        // Alle medische onderzoeken van een bepaalde persoon ophalen uit de databank
        $this->db->where('id', $onderzoekId);
        $query = $this->db->get('medischeAfspraak');
        return $query->row();
    }
    
    /**
     * Retourneert een volledig supplementen object inclusief al zijn relatietabellen
     * @param $supplementId De id van het supplementPerPersoon dat je opvraagt
     * @see getSupplementPersoon($supplementId)
     * @see getSupplementFunctie($supplementFunctieId)
     * @return Het opgevraagde record
     */

    public function getSupplement($supplementId) {
        // Supplement ophalen uit de databank
        $this->db->where('id', $supplementId);
        $query = $this->db->get('supplementPerPersoon');

        $supplement = $query->row();
        $supplement->supplement = $this->getSupplementPersoon($supplement->supplementId);
        $supplement->functie = $this->getSupplementFunctie($supplement->supplement->supplementFunctieId);

        return $supplement;
    }
    
    /**
     * Retourneert een supplement
     * @param $supplementId De id van het supplement dat je opvraagt
     * @return Het opgevraagde record
     */

    public function getSupplementPersoon($supplementId) {
        // Supplement ophalen uit de databank
        $this->db->where('id', $supplementId);
        $query = $this->db->get('supplement');
        return $query->row();
    }
    
    /**
     * Retourneert alle supplementennamen
     * @return Het opgevraagde record
     */

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
    
    /**
     * Retourneert een supplementenFunctie
     * @param $functieId De id van de supplementenFunctie die je opvraagt
     * @return Het opgevraagde record
     */

    public function getSupplementFunctie($functieId) {
        // Functie van een supplement ophalen uit de databank
        $this->db->where('id', $functieId);
        $query = $this->db->get('supplementFunctie');
        return $query->row();
    }
    
    /**
     * Retourneert alle supplementen, inclusief zijn relatietabellen, van een bepaalde persoon
     * @param $persoonId De id van de persoon waarvan je de supplementen opvraagt
     * @see getSupplementPersoon($supplementId)
     * @see getSupplementFunctie($supplementFunctieId)
     * @return Het opgevraagde record
     */


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
    
    /**
     * Retourneert alle kleuren van de verschillende activiteiten uit de databank
     * @return Het opgevraagde record
     */

    public function getKleurenActiviteiten() {
        // De kleuren van de verschillende activiteiten ophalen uit de databank
        $query = $this->db->get('kleur');
        return $query->result();
    }
    
    /**
     * Retourneert een kleur van een activiteit
     * @param $kleurId De id van een kleur die je opvraagt
     * @return Het opgevraagde record
     */

    public function getKleurActiviteit($kleurId) {
        // De kleur van een activiteit ophalen uit de databank
        $this->db->where('id', $kleurId);
        $query = $this->db->get('kleur');
        return $query->row();
    }
}
