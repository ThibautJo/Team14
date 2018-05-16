
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
  <h1 style="display: inline;">Wedstrijd resultaten</h1>

  <?php
  $template = array(
    'table_open' => '<table class="table">'
  );
  $this->table->set_template($template);

  $this->table->set_heading(array('data' => 'Naam', 'scope' => 'col'), array('data' => 'Wedstrijd', 'scope' => 'col'), array('data' => 'Ronde', 'scope' => 'col'),
  array('data' => 'Reeks', 'scope' => 'col'), array('data' => 'Tijd', 'scope' => 'col'));
if ($resultaten->resultaten == "" || $resultaten->resultaten == null) {
  $this->table->add_row("Geen resultaten gevonden!");
}
else {
  foreach ($resultaten->resultaten as $resultaat) {
    $time = date("H:i:s",strtotime($resultaat->tijd));
    $this->table->add_row($resultaat->persoonNaam, $resultaat->wedstrijdNaam, $resultaat->ronde, $resultaat->reeks, $time);
  }
}


  echo $this->table->generate();
  ?>
  <button type="button" class="btn button-blue justify-content-center" onclick="document.location.href= site_url + '/Trainer/WedstrijdResultaten/index?pagina=weergaven'">Terug</button>
  <button type="button" class="btn button-blue justify-content-center" onclick="document.location.href= site_url + '/Trainer/WedstrijdResultaten/resultatenWedstrijd?pagina=aanpassen&wedstrijdid=' + <?php echo $_GET['wedstrijdid'] ?>">Aanpassen</button>


</div>

<script type="text/javascript">

$('#wedstrijdSelect').on('change', function() {
  var wedID = $('#wedstrijdSelect').val();

  $('#frmSortWedstrijd').attr("action", site_url+"/Trainer/wedstrijdResultaten/index?pagina=weergaven&wedstrijdid="+wedID);
  $('#frmSortWedstrijd').submit();
});

</script>
