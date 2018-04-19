
<?php
// +----------------------------------------------------------
// |    Trainingscentrum Wezenberg
// +----------------------------------------------------------
// |    Auteur: Thibaut Joukes       |       Helper:
// +----------------------------------------------------------
// |
// |    wedstrijdresultaten view
// |
// +----------------------------------------------------------
// |    Team 14
// +----------------------------------------------------------
?>

<div id="wedstrijd">
  <h1>Wedstrijd resultaten</h1>

  <?php
  $template = array(
    'table_open' => '<table class="table">'
  );
  $this->table->set_template($template);

  $this->table->set_heading(array('data' => 'Naam', 'scope' => 'col'), array('data' => 'Wedstrijd', 'scope' => 'col'), array('data' => 'Ronde', 'scope' => 'col'),
  array('data' => 'Reeks', 'scope' => 'col'), array('data' => 'Tijd', 'scope' => 'col'));

  foreach ($resultaten->resultaten as $resultaat) {
    $this->table->add_row($resultaat->persoonNaam, $resultaat->wedstrijdNaam, $resultaat->ronde, $resultaat->reeks, $resultaat->tijd);
  }

  echo $this->table->generate();
  ?>
  <button type="button" class="btn btn-primary" onclick="document.location.href= site_url + '/Trainer/WedstrijdResultaten/index?pagina=aanpassen'">Aanpassen</button>


</div>
