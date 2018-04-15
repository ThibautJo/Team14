
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
echo haalJavascriptOp("validator.js");
?>

<div id="wedstrijd">
  <h1><?php echo $maand; ?></h1>

  <?php
  $template = array(
    'table_open' => '<table class="table table-hover">'
  );
  $this->table->set_template($template);

  $this->table->set_heading(array('data' => 'Datum', 'scope' => 'col'), array('data' => 'Naam', 'scope' => 'col'), array('data' => 'Locatie', 'scope' => 'col'),
                            array('data' => 'Programma', 'scope' => 'col'), array('data' => 'Ingeschrevenen', 'scope' => 'col'), "Actie",
                          "<button type='button' class='btn btn-warning btn-xs btn-round' data-toggle='modal' data-target='#wedstrijdToevoegen' id='' onclick='reeksenLeegmaken()' value=''><i class='fas fa-plus'></button>");

  $this->table->add_row();

  // var_dump($wedstrijden);

  foreach ($wedstrijden as $wedstrijd) {
  echo "<tr scope='row' id='". $wedstrijd->id ."'>";
  if ($wedstrijd->personen->namen) {
    foreach ($wedstrijd->personen->namen as $persoon) {
      $this->table->add_row(date("d-m-Y", strtotime($wedstrijd->datumStart)), $wedstrijd->naam, $wedstrijd->plaats,
      array('data' => "Open Programma", 'href' => 'http://'.$wedstrijd->programma.'' ), $persoon,
      "<button type='button' class='btn btn-success' id='aanpassen".$wedstrijd->id."' onclick='wedstrijdOpvragen(this.id)' value='".$wedstrijd->id."'><i class='fas fa-pencil-alt'></i></button>",
     "<button type='button' class='btn btn-danger' id='verwijder".$wedstrijd->id."' onclick='wedstrijdVerwijder(this.id)' value='".$wedstrijd->id."'><i class='fas fa-trash-alt'></i></button>" );
    }
  }
  else {
    $this->table->add_row(date("d-m-Y", strtotime($wedstrijd->datumStart)), $wedstrijd->naam, $wedstrijd->plaats,
    array('data' => "Open Programma", 'href' => 'http://'.$wedstrijd->programma.'' ), '...',
    "<button type='button' class='btn btn-success' id='aanpassen".$wedstrijd->id."' onclick='wedstrijdOpvragen(this.id)' value='".$wedstrijd->id."'><i class='fas fa-pencil-alt'></i></button>",
   "<button type='button' class='btn btn-danger' id='verwijder".$wedstrijd->id."' onclick='wedstrijdVerwijder(this.id)' value='".$wedstrijd->id."'><i class='fas fa-trash-alt'></i></button>" );
  }
  echo "</tr>";
  }
  echo $this->table->generate();
   ?>

  <button type="button" class="btn btn-primary" onclick="document.location.href= site_url + '/Trainer/wedstrijden/index?pagina=weergaven'">Weergaven</button>


  <!-- Modal toevoegen -->
<div class="modal fade" id="wedstrijdToevoegen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="popup-title">Wedstrijd toevoegen</h3>
        <button type="button" class="close" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php
        $attributenFormulier = array('id' => 'form-wedstrijd',
            'data-toggle' => 'validator',
            'role' => 'form');
        echo form_open('#', $attributenFormulier);

         ?>
          <table>
            <tr>
              <td>
                <?php
                    echo form_label("Titel", 'titel-wedstrijd');
                    echo form_input(array('name'=>'titel-wedstrijd', 'id'=>'titel-wedstrijd', 'required' => 'required'));
                ?>
              </td>
              <td rowspan="4" class="reeksen">
                <?php echo form_label("Voeg een reeks toe:", 'programma-wedstrijd'); ?>
                <select class="afstand-wedstrijd">
                  <?php
                  //adding slag en afstand
                  foreach ($afstanden as $afstand) {
                    echo "<option value='".$afstand->id."'>".$afstand->afstand."</option>";
                  }
                  ?>
                </select>
                <select class="slag-wedstrijd">
                  <?php
                  //adding slag en afstand
                  foreach ($slagen as $slag) {
                    echo "<option value='".$slag->id."'>".$slag->slag."</option>";
                  }
                  ?>
                </select>
                <button type="button" class="btn btn-default" onclick="reeksToevoegen('toevoegen')" aria-label="Left Align" style="margin-left: 10px;">
                  <span class="glyphicon glyphicon-align-left" aria-hidden="true">+</span>
                </button>
              </td>
            </tr>
            <tr>
              <td>
                <?php
                  echo form_label("Datum", 'datum-wedstrijd');
                  echo form_input(array('type'=> 'date', 'name'=>'datum-wedstrijdStart', 'id'=>'datum-wedstrijdStart', 'required'));
                  echo '<p style="display: inline; margin: 0 10px;"> tot </p>';
                  echo form_input(array('type'=> 'date', 'name'=>'datum-wedstrijdStop', 'id'=>'datum-wedstrijdStop', 'required'));
                 ?>
              </td>
            </tr>
            <tr>
              <td>
                <?php
                  echo form_label("Locatie", 'locatie-wedstrijd');
                  echo form_input(array('name'=>'locatie-wedstrijd', 'id'=>'locatie-wedstrijd', 'required'));
                 ?>
              </td>
            </tr>
            <tr>
              <td>
                <?php
                  echo form_label("Programma", 'programma-wedstrijd');
                  echo form_input(array('name'=>'programma-wedstrijd', 'id'=>'programma-wedstrijd', 'required'));
                 ?>
              </td>
            </tr>

          </table>
        <?php echo form_close(); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="wedstrijdOpslaan('toevoegen')">Opslaan</button>
      </div>
    </div>
  </div>
</div>

  <!-- Modal aanpassen -->
<div class="modal fade" id="wedstrijdAanpassen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="popup-title">Wedstrijd Aanpassen</h3>
        <button type="button" class="close" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php
        $attributenFormulier = array('id' => 'form-wedstrijd',
            'data-toggle' => 'validator',
            'role' => 'form');
        echo form_open('#', $attributenFormulier);

         ?>
          <table>
            <tr>
              <td>
                <?php
                    echo form_label("Titel", 'titel-wedstrijd');
                    echo form_input(array('name'=>'titel-wedstrijd', 'id'=>'titel-wedstrijd', 'required' => 'required'));
                ?>
              </td>
              <td rowspan="4" class="reeksen">
                <?php echo form_label("Voeg een reeks toe:", 'programma-wedstrijd'); ?>
                <select class="afstand-wedstrijd">
                  <?php
                  //adding slag en afstand
                  foreach ($afstanden as $afstand) {
                    echo "<option value='".$afstand->id."'>".$afstand->afstand."</option>";
                  }
                  ?>
                </select>
                <select class="slag-wedstrijd">
                  <?php
                  //adding slag en afstand
                  foreach ($slagen as $slag) {
                    echo "<option value='".$slag->id."'>".$slag->slag."</option>";
                  }
                  ?>
                </select>
                <button type="button" class="btn btn-default" onclick="reeksToevoegen('toevoegen')" aria-label="Left Align" style="margin-left: 10px;">
                  <span class="glyphicon glyphicon-align-left" aria-hidden="true">+</span>
                </button>
              </td>
            </tr>
            <tr>
              <td>
                <?php
                  echo form_label("Datum", 'datum-wedstrijd');
                  echo form_input(array('type'=> 'date', 'name'=>'datum-wedstrijdStart', 'id'=>'datum-wedstrijdStart', 'required'));
                  echo '<p style="display: inline; margin: 0 10px;"> tot </p>';
                  echo form_input(array('type'=> 'date', 'name'=>'datum-wedstrijdStop', 'id'=>'datum-wedstrijdStop', 'required'));
                 ?>
              </td>
            </tr>
            <tr>
              <td>
                <?php
                  echo form_label("Locatie", 'locatie-wedstrijd');
                  echo form_input(array('name'=>'locatie-wedstrijd', 'id'=>'locatie-wedstrijd', 'required'));
                 ?>
              </td>
            </tr>
            <tr>
              <td>
                <?php
                  echo form_label("Programma", 'programma-wedstrijd');
                  echo form_input(array('name'=>'programma-wedstrijd', 'id'=>'programma-wedstrijd', 'required'));
                 ?>
              </td>
            </tr>

          </table>
        <?php echo form_close(); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="wedstrijdOpslaan('aanpassen')">Opslaan</button>
      </div>
    </div>
  </div>
</div>


</div>
