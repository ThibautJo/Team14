
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
echo haalJavascriptOp("validator.js");
?>

<div id="wedstrijd">
  <h1>Wedstrijd resultaten</h1>
  <div class="table-responsive-xl">
    <?php
    $template = array(
      'table_open' => '<table class="table table-hover">'
    );
    $this->table->set_template($template);

    $this->table->set_heading(array('data' => 'Naam', 'scope' => 'col'), array('data' => 'Wedstrijd', 'scope' => 'col'), array('data' => 'Ronde', 'scope' => 'col'),
    array('data' => 'Reeks', 'scope' => 'col'), array('data' => 'Tijd', 'scope' => 'col'), "",
    "<button type='button' class='btn btn-warning btn-xs btn-round' data-toggle='modal' data-target='#resultaatToeveoegen' id='' onclick=''><i class='fas fa-plus'></button>");

    foreach ($resultaten->resultaten as $resultaat) {
      $time = date("H:i:s",strtotime($resultaat->tijd));
      $this->table->add_row($resultaat->persoonNaam, $resultaat->wedstrijdNaam, $resultaat->ronde, $resultaat->reeks, $time,
      "<button type='button' class='btn btn-success' id='aanpassen".$resultaat->id."' onclick='wedstrijdOpvragen(this.id)' value='".$resultaat->id."'><i class='fas fa-pencil-alt'></i></button>",
      "<button type='button' class='btn btn-danger' id='verwijder".$resultaat->id."' onclick='wedstrijdVerwijder(this.id)' value='".$resultaat->id."'><i class='fas fa-trash-alt'></i></button>");
    }

    echo $this->table->generate();
    ?>
    <button type="button" class="btn btn-primary" onclick="document.location.href= site_url + '/Trainer/WedstrijdResultaten/index?pagina=weergaven'">Weergaven</button>

    <!-- Modal toevoegen -->
    <div class="modal fade" id="resultaatToeveoegen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="popup-title">Resultaat toevoegen</h3>
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
                  echo form_label("Naam", 'naam-persoon');
                  echo form_input(array('name'=>'naam-persoon', 'id'=>'naam-persoon', 'required' => 'required'));
                  ?>
                </td>
              </tr>
              <tr>
                <td>
                  <?php
                  echo form_label("Wedstrijd", 'naam-wedstrijd');
                  echo form_input(array('name'=>'naam-wedstrijd', 'id'=>'naam-wedstrijd', 'required' => 'required'));
                  ?>
                </td>
              </tr>
              <tr>
                <td>
                  <?php
                  echo form_label("Ronde", 'naam-ronde');
                  echo form_input(array('name'=>'naam-ronde', 'id'=>'naam-ronde', 'required' => 'required'));
                  ?>
                </td>
              </tr>
              <tr>
                <td>
                  <?php
                  echo form_label("Reeks", 'naam-reeks');
                  echo form_input(array('name'=>'naam-reeks', 'id'=>'naam-reeks', 'required' => 'required'));
                  ?>
                </td>
              </tr>
              <tr>
                <td>
                  <?php
                  echo form_label("Tijd", 'naam-tijd');
                  echo form_input(array('name'=>'naam-tijd', 'id'=>'naam-tijd', 'required' => 'required'));
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
</div>
