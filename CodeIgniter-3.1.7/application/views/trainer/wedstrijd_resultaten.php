<?php
/**
 * @file wedstrijden_weergaven.php
 *
 * View waarin de gegevens van een wedstrijden worden weergegeven
 */

// +----------------------------------------------------------
// |    Trainingscentrum Wezenberg
// +----------------------------------------------------------
// |    Auteur: Thibaut Joukes       |       Helper:
// +----------------------------------------------------------
// |
// |    Wedstrijd weergaven
// |
// +----------------------------------------------------------
// |    Team 14
// +----------------------------------------------------------
$attributenFormulier = array('id' => 'mijnFormulier',
'data-toggle' => 'validator',
'role' => 'form');

$maandKey = null;
$maanden = array(
  0 => "Alle wedstrijden",
  1 => "januari",
  2 => "februari",
  3 => "maart",
  4 => "april",
  5 => "mei",
  6 => "juni",
  7 => "juli",
  8 => "augustus",
  9 => "september",
  10 => "oktober",
  11 => "november",
  12 => "december"
);

?>

<div id="wedstrijd">
  <h1 style="display: inline;"><?php if($maand == 0){ echo "Alle wedstrijden";}else{echo $maanden[$maand]; }?></h1>
  <form action="#" method="post" style="display: inline-block; margin: 10px;">
    <select id="datumSelected">
      <?php

      foreach ($maanden as $key => $value) {
        if (strtolower($value) == strtolower($maanden[$maand])) {
          echo "<option value='".$key."' selected>".$value."</option>";
          $maandKey = $key;
        }
        else{
          echo "<option value='".$key."'>".$value."</option>";
        }
      }
      ?>
    </select>
    <label>Jaar:</label>
    <a href="<?php echo site_url('/Trainer/WedstrijdResultaten/index?pagina=weergaven&maand='.$maandKey.'&jaar='.$jaar.'&actie=vorige'); ?>" style="font-weight: bold;"> < </a>
    <?php echo $jaar; ?>
    <a href="<?php echo site_url('/Trainer/WedstrijdResultaten/index?pagina=weergaven&maand='.$maandKey.'&jaar='.$jaar.'&actie=volgende'); ?>" style="font-weight: bold;"> > </a>
  </form>

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
        $this->table->add_row(date("d-m-Y", strtotime($wedstrijd->datumStart)), "<a href='".site_url('/Trainer/WedstrijdResultaten/resultatenWedstrijd?wedstrijdid='.$wedstrijd->id)."'>".$wedstrijd->naam."</a>", $wedstrijd->plaats,
        array('data' => "Open Programma", 'href' => 'http://'.$wedstrijd->programma.'' ), $persoon );
      }
    }
    else {
      $this->table->add_row(date("d-m-Y", strtotime($wedstrijd->datumStart)),  "<a href='".site_url('/Trainer/WedstrijdResultaten/resultatenWedstrijd?wedstrijdid='.$wedstrijd->id)."'>".$wedstrijd->naam."</a>", $wedstrijd->plaats,
      array('data' => "Open Programma", 'href' => 'http://'.$wedstrijd->programma.'' ), '...' );
    }
    echo "</tr>";
  }
  echo $this->table->generate();
  ?>

  <button type="button" class="btn button-blue justify-content-center" onclick="document.location.href= site_url + '/Trainer/WedstrijdResultaten/index?pagina=aanpassen'">Aanpassen</button>








</div>
<script type="text/javascript">

$('#datumSelected').on('change', function() {
  datumSelect();
});

function datumSelect(){
  switch($("#datumSelected").val()) {
    case "0":
    window.location.href = '<?php echo site_url('/Trainer/WedstrijdResultaten/index?pagina=weergaven&maand=0&jaar='.$jaar); ?>';
    break;
    case "1":
    window.location.href = '<?php echo site_url('/Trainer/WedstrijdResultaten/index?pagina=weergaven&maand=1&jaar='.$jaar); ?>';
    break;
    case "2":
    window.location.href = '<?php echo site_url('/Trainer/WedstrijdResultaten/index?pagina=weergaven&maand=2&jaar='.$jaar); ?>';
    break;
    case "3":
    window.location.href = '<?php echo site_url('/Trainer/WedstrijdResultaten/index?pagina=weergaven&maand=3&jaar='.$jaar); ?>';
    break;
    case "4":
    window.location.href = '<?php echo site_url('/Trainer/WedstrijdResultaten/index?pagina=weergaven&maand=4&jaar='.$jaar); ?>';
    break;
    case "5":
    window.location.href = '<?php echo site_url('/Trainer/WedstrijdResultaten/index?pagina=weergaven&maand=5&jaar='.$jaar); ?>';
    break;
    case "6":
    window.location.href = '<?php echo site_url('/Trainer/WedstrijdResultaten/index?pagina=weergaven&maand=6&jaar='.$jaar); ?>';
    break;
    case "7":
    window.location.href = '<?php echo site_url('/Trainer/WedstrijdResultaten/index?pagina=weergaven&maand=7&jaar='.$jaar); ?>';
    break;
    case "8":
    window.location.href = '<?php echo site_url('/Trainer/WedstrijdResultaten/index?pagina=weergaven&maand=8&jaar='.$jaar); ?>';
    break;
    case "9":
    window.location.href = '<?php echo site_url('/Trainer/WedstrijdResultaten/index?pagina=weergaven&maand=9&jaar='.$jaar); ?>';
    break;
    case "10":
    window.location.href = '<?php echo site_url('/Trainer/WedstrijdResultaten/index?pagina=weergaven&maand=10&jaar='.$jaar); ?>';
    break;
    case "11":
    window.location.href = '<?php echo site_url('/Trainer/WedstrijdResultaten/index?pagina=weergaven&maand=11&jaar='.$jaar); ?>';
    break;
    case "12":
    window.location.href = '<?php echo site_url('/Trainer/WedstrijdResultaten/index?pagina=weergaven&maand=12&jaar='.$jaar); ?>';
    break;
    default:
    break;
  }
}
</script>
