
<?php
// +----------------------------------------------------------
// |    Trainingscentrum Wezenberg
// +----------------------------------------------------------
// |    Auteur: Thibaut Joukes       |       Helper:
// +----------------------------------------------------------
// |
// |    Training home
// |
// +----------------------------------------------------------
// |    Team 14
// +----------------------------------------------------------
$attributenFormulier = array('id' => 'mijnFormulier',
    'data-toggle' => 'validator',
    'role' => 'form');
?>

<div id="wedstrijd">
  <h1><?php echo $maand; ?></h1>

      <?php
      $template = array(
        'table_open' => '<table class="table">'
      );
      $this->table->set_template($template);

      $this->table->set_heading(array('data' => 'Datum', 'scope' => 'col'), array('data' => 'Naam', 'scope' => 'col'), array('data' => 'Locatie', 'scope' => 'col'),
                                array('data' => 'Programma', 'scope' => 'col'), array('data' => 'Ingeschrevenen', 'scope' => 'col'));

      $this->table->add_row();

      // var_dump($wedstrijden);

      foreach ($wedstrijden as $wedstrijd) {
      echo "<tr scope='row' id='". $wedstrijd->id ."'>";
      if ($wedstrijd->personen->namen) {
        foreach ($wedstrijd->personen->namen as $persoon) {
          $this->table->add_row(date("d-m-Y", strtotime($wedstrijd->datumStart)), $wedstrijd->naam, $wedstrijd->plaats,
          array('data' => "Open Programma", 'href' => 'http://'.$wedstrijd->programma.'' ), $persoon );
        }
      }
      else {
        $this->table->add_row(date("d-m-Y", strtotime($wedstrijd->datumStart)), $wedstrijd->naam, $wedstrijd->plaats,
        array('data' => "Open Programma", 'href' => 'http://'.$wedstrijd->programma.'' ), '...' );
      }
      echo "</tr>";
      }
      echo $this->table->generate();
       ?>

  <button type="button" class="btn btn-primary" onclick="document.location.href= site_url + '/Trainer/wedstrijden/index?pagina=aanpassen'">Aanpassen</button>

</div>
