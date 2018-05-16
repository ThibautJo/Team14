
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
    // |    Auteur: Thibaut Joukes, Lise Van Eyck       |       Helper:
    // +----------------------------------------------------------
    // |
    // |    Agenda model
    // |
    // +----------------------------------------------------------
    // |    Team 14
    // +----------------------------------------------------------

    function __construct() {
        parent::__construct();
    }

    public function getAlleWedstrijden() {

        /**
        * Retourneert alle wedstrijden uit de tabel wedstrijd.
        * @return Alle wedstrijden.
        */

        $query = $this->db->get('wedstrijd');
        return $query->result();
    }

    /**
     * \brief Retourneert de opgevraagde wedstrijden
     *
     * @param $start Is de startperiode van de wedstrijden
     * @param $end Is de einPeriode van de wedstrijden
     * @return De gevraagde wedstrijd(en)
     */
    //toekomstige wedstrijden
    public function getWedstrijdenToekomst($start = null, $end = null) {
        if (date("Y-m-d") < $start) {
            $this->db->where('datumStart >=', $start);
        } else {
            $this->db->where('datumStart >=', date("Y-m-d"));
        }

        if ($end != null) {
            $this->db->where('datumStop <=', $end);
        }

        $query = $this->db->get('wedstrijd');
        return $query->result();
    }
    /**
     * \brief Retourneert de opgevraagde wedstrijden van het verleden
     *
     * @param $start Is de startperiode van de wedstrijden
     * @param $end Is de einPeriode van de wedstrijden
     * @return De gevraagde wedstrijd(en)
     */
    //verleden wedstrijden
    public function getWedstrijdenVerleden($start = null, $end = null) {
        if (date("Y-m-d") > $start) {
            if ($start != null) {
                $this->db->where('datumStart >=', $start);
            }
            if ($end <= date("Y-m-d")) {
                $this->db->where('datumStop <=', $end);
            } else {
                $this->db->where('datumStop <=', date("Y-m-d"));
            }

            $query = $this->db->get('wedstrijd');

            return $query->result();
        } else {
            return array();
        }
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
            array_push($namen, $result->voornaam . ' ' . $result->achternaam);
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
        //ook bijhorende reekse<getwedstrijdwith></getwedstrijdwith><getwedstrijdwith></getwedstrijdwith><getwedstrijdwi></getwedstrijdwi><getwedstrijd></getwedstrijd><getwed></getwed>n verwijderen
        $this->db->where('wedstrijdId', $id);
        $this->db->delete('reeksPerWedstrijd');
        $this->db->where('id', $id);
        $this->db->delete('wedstrijd');
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
    public function updateReeksen($wedID, $reeksen) {
        $this->db->where('wedstrijdId', $wedID);
        $this->db->delete('reeksPerWedstrijd');

        //toevoegen van degene die er gekozen waren
        $this->insertReeksen($wedID, $reeksen);
    }
    /**
     * Retourneert resultaten van opgevraagde wedstrijden
     *
     * @param $wedID is het wedstrijd ID
     * @see Wedstrijd_model::getIngeschrevenenWithId()
     * @see Wedstrijd_model::getRondeWithId()
     * @see Wedstrijd_model::getReeksWithID()
     * @see Wedstrijd_model::getPersoonWithId()
     * @see Wedstrijd_model::getSlagWithID()
     * @see Wedstrijd_model::getAfstandWithID()
     * @see Wedstrijd_model::getWedstrijdenWithId()
     */
    public function getResultatenTabel($wedID = null) {

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
                    $resultaten->resultaten[$i]->reeks = $afstand->afstand . ' ' . $slag->slag;
                    $resultaten->resultaten[$i]->persoonNaam = $persoon->voornaam . ' ' . $persoon->achternaam;
                    $resultaten->resultaten[$i]->wedstrijdNaam = $wedstrijd->naam;
                } else {
                    unset($resultaten->resultaten[$i]);
                }
            } else {
                $resultaten->resultaten[$i]->ronde = $ronde->ronde;
                $resultaten->resultaten[$i]->reeks = $afstand->afstand . ' ' . $slag->slag;
                $resultaten->resultaten[$i]->persoonNaam = $persoon->voornaam . ' ' . $persoon->achternaam;
                $resultaten->resultaten[$i]->wedstrijdNaam = $wedstrijd->naam;
            }


            $i++;
        }

        return $resultaten;
    }
    /**
     * Retourneert alle ronden
     *
     */
    public function getRondes() {
        $query = $this->db->get('ronde');
        return $query->result();
    }
    /**
     * Retourneert de opgevraagde ronde
     *
     * @param $id is de opgevraagde ronde id dat men nodig heeft
     * @return De opgevraagde array
     */
    public function getRondeWithId($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('ronde');
        return $query->row();
    }
    /**
     * Retourneert de opgevraagde inschrijvings
     *
     * @param $id is het inschrijvings id dat men nodig heeft
     * @return De opgevraagde array
     */
    public function getIngeschrevenenWithId($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('inschrijving');
        return $query->row();
    }
    /**
     * Retourneert de opgevraagd reeks
     *
     * @param $id is het reeksperwedstrijd id dat men nodig heeft
     * @return De opgevraagde array
     */
    public function getReeksWithID($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('reeksPerWedstrijd');
        return $query->row();
    }
    /**
     * Retourneert de opgevraagd persoon
     *
     * @param $id is het persoon id dat men nodig heeft
     * @return De opgevraagde array
     */
    public function getPersoonWithId($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('persoon');
        return $query->row();
    }

    /**
     * Retourneert een array van alle reeksen van bepaalde wedstrijd
     *
     * @param $id De id van het record dat opgevraagd wordt
     * @return De opgevraagde array
     */
    public function getReeksPerWedstrijd($id) {
        $this->db->where('wedstrijdId', $id);
        $query = $this->db->get('reeksPerWedstrijd');

        $reeksPerWedstrijd = $query->result();

        $reeksen = array();
        foreach ($reeksPerWedstrijd as $item) {
            $reeksWedstrijd = array();
            $reeksWedstrijd['reeksPerWedstrijd'] = $item->id;

            $this->db->where('id', $item->slagId);
            $querySlag = $this->db->get('slag');
            $this->db->where('id', $item->afstandId);
            $queryAfstand = $this->db->get('afstand');
            $slag = $querySlag->row();
            $afstand = $queryAfstand->row();

            $obj_merged = (object) array_merge((array) $slag, (array) $afstand, (array) $reeksWedstrijd);
            array_push($reeksen, $obj_merged);
        }
        return $reeksen;
    }

    /**
     * Retourneert een array van een resultaat
     *
     * @param $id De id van het resultaat dat opgevraagd wordt
     * @return De opgevraagde array
     */
    public function getResultatenWithId($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('resultaat');
        return $query->row();
    }

    /**
     * Retourneert een array van de verschillende reeksen van de wedstrijd
     *
     * @param $id De id van het inschrijvingsID
     * @return De opgevraagde reeksen bijhorend deze wedstrijd via inschrijving
     */
    public function getReeksenWithInschrijvingId($id) {

        $this->db->where('id', $id);
        $query = $this->db->get('inschrijving');
        $inschrijving = $query->row(); // inschrijving->id
        //reeks per wedstrijd opvragen via inschrijving id
        $this->db->where('id', $inschrijving->reeksPerWedstrijdId);
        $query = $this->db->get('reeksperwedstrijd');
        $reeksperwedstrijd = $query->row(); // reeksperwedstrijd->wedstrijdId
        // alle reeksen van wedstrijd ophalen zodat verschillende reeksen kunnen opgrslagen worden
        $this->db->where('wedstrijdId', $reeksperwedstrijd->wedstrijdId);
        $query = $this->db->get('reeksperwedstrijd');
        $reeksWedstrijden = $query->result();

        $slag = array();
        $afstand = array();
        foreach ($reeksWedstrijden as $reeks) {
            array_push($slag, $reeks->slagId);
            array_push($afstand, $reeks->afstandId);
        }

        $slagNaam = array();
        $afstandNaam = array();
        // slagen & afstanden ophalen adhv id's
        foreach ($slag as $value) {
            $text = $this->getSlagWithID($value);
            array_push($slagNaam, $text->slag);
        }
        foreach ($afstand as $value) {
            $text = $this->getAfstandWithID($value);
            array_push($afstandNaam, $text->afstand);
        }

        // geheel van reeksen met keys en values
        $reeksenGeheel = array();
        $i = 0;
        foreach ($slagNaam as $value) {

            $reeksenGeheel[(string) ($afstand[$i] . '-' . $slag[$i])] = $afstandNaam[$i] . ' ' . $value;
            $i++;
        }

        return $reeksenGeheel;
    }
    /**
     * Retourneert een array van de verschillende reeksen van de nodige wedstrijd
     *
     * @param $id De id van de nodige wedstrijd
     * @return De opgevraagde reeksen bijhorend deze wedstrijd
     */
    public function getSlagEnAfstandWithWedstrijdId($id) {
        // alle reeksen van wedstrijd ophalen zodat verschillende reeksen kunnen opgrslagen worden
        $this->db->where('wedstrijdId', $id);
        $query = $this->db->get('reeksperwedstrijd');
        $reeksWedstrijden = $query->result();

        $slag = array();
        $afstand = array();
        foreach ($reeksWedstrijden as $reeks) {
            array_push($slag, $reeks->slagId);
            array_push($afstand, $reeks->afstandId);
        }

        $slagNaam = array();
        $afstandNaam = array();
        // slagen & afstanden ophalen adhv id's
        foreach ($slag as $value) {
            $text = $this->getSlagWithID($value);
            array_push($slagNaam, $text->slag);
        }
        foreach ($afstand as $value) {
            $text = $this->getAfstandWithID($value);
            array_push($afstandNaam, $text->afstand);
        }

        // geheel van reeksen met keys en values
        $reeksenGeheel = array();
        $i = 0;
        foreach ($slagNaam as $value) {

            $reeksenGeheel[(string) ($afstand[$i] . '-' . $slag[$i])] = $afstandNaam[$i] . ' ' . $value;
            $i++;
        }

        return $reeksenGeheel;
    }
    /**
     * Verwijderd het resultaat
     *
     * @param $id De id van het resultaat dat verwijderd word
     */
    public function verwijderResultaatViaId($id) {
        //delete resultaat
        $this->db->where('id', $id);
        $this->db->delete('resultaat');
    }
    /**
     * Retourneert een array van het gezochte inschrijving
     *
     * @param $id De id van een resultaat object
     * @return De opgevraagde array
     */
    public function getInschijvingsIdViaResultaatId($id){
      $this->db->where('id', $id);
      $query = $this->db->get('resultaat');
      return $query->row();
    }
    /**
     * Retourneert een array van het gezochte inschrijving
     *
     * @param $id De id van een resultaat object
     * @return De opgevraagde array
     */
    public function getInschijvingsIdViaReeksPerWedstrijdId($id){
      $this->db->where('reeksPerWedstrijdId', $id);
      $query = $this->db->get('inschrijving');
      return $query->row();
    }
    /**
     * Retourneert een array van het reeksenperwedstrijd
     *
     * @param $id De id van een inschrijving object
     * @return De opgevraagde array
     */
    public function getReeksPerWedstrijdViaInschrijvingId($id){
      $this->db->where('id', $id);
      $query = $this->db->get('inschrijving');
      return $query->row();
    }
    /**
     * retourneert het gezochte object adhv slag, afstand en wedstrijd
     *
     * @param $slag is het id van de slag
     * @param $afstand is het id van de afstand
     * @param $wedstrijd is het id van wedstrijd waar gezocht naar word
     */
    public function getReeksPerWedstrijdViaSlagAndAfstandAndWedid($slag, $afstand, $wedstrijd){
      $this->db->where('wedstrijdId', $wedstrijd);
      $this->db->where('slagId', $slag);
      $this->db->where('afstandId', $afstand);
      $query = $this->db->get('reeksperwedstrijd');
      return $query->row();
    }
    /**
     * Update het gevraagde object met nieuwe gegevens
     *
     * @param $data is het nieuwe object dat in de plek komt van de oude gegevens
     */
    public function updateResultaat($data){
      $this->db->where('id', $data->id);
      $this->db->update('resultaat', $data);
    }
    /**
     * Update het gevraagde object met nieuwe gegevens
     *
     * @param $data is het nieuwe object dat in de plek komt van de oude gegevens
     */
    public function updateInschrijving($data){
      $this->db->where('id', $data->id);
      $this->db->update('inschrijving', $data);
    }
    /**
     * Update het gevraagde object met nieuwe gegevens
     *
     * @param $data is het nieuwe object dat in de plek komt van de oude gegevens
     */
    public function updateReeksPerWedstrijd($data){
      $this->db->where('id', $data->id);
      $this->db->update('reeksperwedstrijd', $data);
    }
    /**
     * Insert het opgegeven object
     *
     * @param $data is het nieuwe object dat toegevoegd word
     */
    public function insertResultaat($data){
      $this->db->insert('resultaat', $data);
      return $this->db->insert_id();
    }
    /**
     * Insert het opgegeven object
     *
     * @param $data is het nieuwe object dat toegevoegd word
     */
    public function insertInschrijving($data){
      $this->db->insert('inschrijving', $data);
      return $this->db->insert_id();
    }
    /**
     * Insert het opgegeven object
     *
     * @param $data is het nieuwe object dat toegevoegd word
     */
    public function insertReeksPerWedstrijd($data){
      $this->db->insert('reeksperwedstrijd', $data);
      return $this->db->insert_id();
    }

}

?>
