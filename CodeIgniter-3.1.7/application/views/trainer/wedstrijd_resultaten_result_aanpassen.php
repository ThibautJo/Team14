
<?php
// +----------------------------------------------------------
// |    Trainingscentrum Wezenberg
// +----------------------------------------------------------
// |    Auteur: Thibaut Joukes       |       Helper:
// +----------------------------------------------------------
// |
// |    wedstrijdresultaten beheren
// |
// +----------------------------------------------------------
// |    Team 14
// +----------------------------------------------------------
?>

<div id="wedstrijd">
  <h1 style="display: inline;">Wedstrijd resultaten</h1>


  <table class="table table-hover">
      <thead>
        <tr>
          <th>Naam</th>
          <th>Wedstrijd</th>
          <th>Ronde</th>
          <th>Reeks</th>
          <th>Tijd</th>
          <th>Actie</th>
          <th><button type='button' class='btn btn-warning' data-toggle='modal' data-toggle='tooltip' title='Wedstrijden toevoegen' data-target='#resultaatToeveoegen'><i class='fas fa-plus'></i></button></th>
        </tr>
      </thead>
      <tbody>
        <?php

        if ($resultaten->resultaten == "" || $resultaten->resultaten == null) {
          echo "<td>Geen resultaten gevonden!</td>";
        }
        else {
          foreach ($resultaten->resultaten as $resultaat) {
            echo "<tr scope='row' id='". $resultaat->id ."'>";
            $time = date("H:i:s",strtotime($resultaat->tijd));
            echo "<td id='zwemmerNaam'>".$resultaat->persoonNaam."</td><td>".$resultaat->wedstrijdNaam."</td><td>".$resultaat->ronde."</td><td>".$resultaat->reeks."</td><td>".$time."</td><td>".
            "<button type='button' class='btn btn-success' id='aanpassen".$resultaat->id."' onclick='resultaatOpvragen(this.id)' data-toggle='modal' data-target='#resultaatAanpassen' value='".$resultaat->id."'><i class='fas fa-pencil-alt'></i></button>"."</td><td>".
            "<button type='button' class='btn btn-danger' id='verwijder".$resultaat->id."' onclick='resultaatVerwijder(this.id)' value='".$resultaat->id."'><i class='fas fa-trash-alt'></i></button> </td>";
            echo "</tr>";
          }
        }


        ?>
         </tbody>
  </table>



    <button type="button" class="btn button-blue justify-content-center" onclick="document.location.href= site_url + '/Trainer/WedstrijdResultaten/index?pagina=weergaven'">Terug</button>
    <button type="button" class="btn button-blue justify-content-center" onclick="document.location.href= site_url + '/Trainer/WedstrijdResultaten/resultatenWedstrijd?pagina=weergaven&wedstrijdid=' + <?php echo $_GET['wedstrijdid'] ?>">Weergaven</button>



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
                ?>
                <select class="form-control" name="" id="zwemmersToevoegen">
                  <?php
                      foreach ($zwemmers as $zwemmer) {
                        echo "<option value='".$zwemmer->id."'>".$zwemmer->voornaam." ".$zwemmer->achternaam."</option>";
                      }
                   ?>
                </select>
              </td>
            </tr>
            <tr>
              <td>
                <?php
                echo form_label("Ronde", 'naam-ronde');
                ?>
                <select class="form-control" name="" id="rondeToevoegen">
                  <?php
                      foreach ($rondes as $ronde) {
                        echo "<option value='".$ronde->id."'>".$ronde->ronde."</option>";
                      }
                   ?>
                </select>
              </td>
              <td>
                <?php
                echo form_label("Reeks", 'naam-reeks');
                ?>
                <select class="form-control" name="" id="reeksenToevoegen">
                  <?php
                      foreach ($reeksen as $key => $value) {
                        echo "<option value='".$key."'>".$value."</option>";
                      }
                   ?>
                </select>
              </td>
            </tr>
            <tr>
              <td>
                <?php
                echo form_label("Datum", 'naam-datum');
                echo form_input(array('type' => 'date', 'name'=>'naam-datum', 'id'=>'naam-datum', 'required' => 'required', 'class' => 'form-control'));
                ?>
              </td>
              <td>
                <?php
                echo form_label("Tijd", 'naam-tijd');
                echo form_input(array('name'=>'naam-tijd', 'id'=>'naam-tijd', 'required' => 'required', 'placeholder' => '00:00:00','class' => 'form-control'));
                ?>
              </td>
            </tr>

          </table>
          <?php echo form_close(); ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="">Opslaan</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal aanpassen -->
  <div class="modal fade" id="resultaatAanpassen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="popup-title">Resultaat aanpassen</h3>
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
                ?>
                <select class="form-control" name="" id="zwemmersToevoegen">
                  <?php
                      foreach ($zwemmers as $zwemmer) {
                        echo "<option value='".$zwemmer->id."'>".$zwemmer->voornaam." ".$zwemmer->achternaam."</option>";
                      }
                   ?>
                </select>
              </td>
            </tr>
            <tr>
              <td>
                <?php
                echo form_label("Ronde", 'naam-ronde');
                ?>
                <select class="form-control" name="" id="rondeToevoegen">
                  <?php
                      foreach ($rondes as $ronde) {
                        echo "<option value='".$ronde->id."'>".$ronde->ronde."</option>";
                      }
                   ?>
                </select>
              </td>
              <td>
                <?php
                echo form_label("Reeks", 'naam-reeks');
                ?>
                <select class="form-control" name="" id="reeksenToevoegen">
                </select>
              </td>
            </tr>
            <tr>
              <td>
                <?php
                echo form_label("Datum", 'naam-datum');
                echo form_input(array('type' => 'date', 'name'=>'naam-datum', 'id'=>'naam-datum', 'required' => 'required', 'class' => 'form-control'));
                ?>
              </td>
              <td>
                <?php
                echo form_label("Tijd", 'naam-tijd');
                echo form_input(array('name'=>'naam-tijd', 'id'=>'naam-tijd', 'required' => 'required', 'class' => 'form-control'));
                ?>
              </td>
            </tr>

          </table>
          <?php echo form_close(); ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="">Opslaan</button>
        </div>
      </div>
    </div>
  </div>

</div>

<script type="text/javascript">

$('#wedstrijdSelect').on('change', function() {
  var wedID = $('#wedstrijdSelect').val();

  $('#frmSortWedstrijd').attr("action", site_url+"/Trainer/wedstrijdResultaten/index?pagina=aanpassen&wedstrijdid="+wedID);
  $('#frmSortWedstrijd').submit();
});

</script>
