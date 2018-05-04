
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
  <form action="#" id="frmSortWedstrijd" method="post" style="display: inline-block; margin: 10px;">
    <select id="wedstrijdSelect">
      <?php
      foreach ($wedstrijden as $wedstrijd) {
        if ($wedstrijd->id == 1) {
          echo "<option value='0' selected>Alle wedstrijden</option>";
          if(isset($_GET['wedstrijdid']) && $_GET['wedstrijdid'] == $wedstrijd->id ){
            echo "<option value='".$wedstrijd->id."' selected>".$wedstrijd->naam."</option>";
          }
          else {
            echo "<option value='".$wedstrijd->id."' >".$wedstrijd->naam."</option>";
          }
        }
        else{
          if(isset($_GET['wedstrijdid']) && $_GET['wedstrijdid'] == $wedstrijd->id ){
            echo "<option value='".$wedstrijd->id."' selected>".$wedstrijd->naam."</option>";
          }
          else {
            echo "<option value='".$wedstrijd->id."' >".$wedstrijd->naam."</option>";
          }
        }
      }
      ?>
    </select>
  </form>



  <?php
  $template = array(
    'table_open' => '<table class="table">'
  );
  $this->table->set_template($template);

  $this->table->set_heading(array('data' => 'Naam', 'scope' => 'col'), array('data' => 'Wedstrijd', 'scope' => 'col'), array('data' => 'Ronde', 'scope' => 'col'),
  array('data' => 'Reeks', 'scope' => 'col'), array('data' => 'Tijd', 'scope' => 'col'));

  foreach ($resultaten->resultaten as $resultaat) {
    $time = date("H:i:s",strtotime($resultaat->tijd));
    $this->table->add_row($resultaat->persoonNaam, $resultaat->wedstrijdNaam, $resultaat->ronde, $resultaat->reeks, $time);
  }

  echo $this->table->generate();
  ?>
  <button type="button" class="btn btn-primary" onclick="document.location.href= site_url + '/Trainer/WedstrijdResultaten/index?pagina=aanpassen'">Aanpassen</button>


</div>

<script type="text/javascript">

$('#wedstrijdSelect').on('change', function() {
  var wedID = $('#wedstrijdSelect').val();

  $('#frmSortWedstrijd').attr("action", site_url+"/Trainer/wedstrijdResultaten/index?pagina=weergaven&wedstrijdid="+wedID);
  $('#frmSortWedstrijd').submit();
});

</script>
