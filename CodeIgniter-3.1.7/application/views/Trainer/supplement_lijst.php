<?php

/**
 * @file supplement_lijst.php
 * 
 * View waarin een lijst van supplement gegevens worden weergegeven
 * - krijgt $supplementen binnen
 */


// +----------------------------------------------------------
// |    Trainingscentrum Wezenberg
// +----------------------------------------------------------
// |    Auteur: Lise Van Eyck       |       Helper:
// +----------------------------------------------------------
// |
// |    Supplement lijst view
// |
// +----------------------------------------------------------
// |    Team 14
// +----------------------------------------------------------

//$wijzigen = array('class' => 'btn btn-success btn-xs btn-round', 'data-toggle' => 'tooltip', 'title' => 'Supplement wijzigen');
//$schrappen = array('class' => 'btn btn-danger btn-xs btn-round', 'data-toggle' => 'tooltip', 'title' => 'Supplement schrappen');
//$toevoegen = array('class' => 'btn btn-warning btn-xs btn-round', 'data-toggle' => 'tooltip', 'title' => 'Supplement toevoegen');

echo haalJavascriptOp("validator.js");


$functieOpties="";
$functieOpties[0] = '--Select--';

foreach ($functies as $functie) {
    $functieOpties[$functie->ID] = ucfirst($functie->Functie);
}

?>

<table class="table">
    <thead>
      <tr>
        <th>Naam</th>
        <th>Functie</th>
        <th>Omschrijving</th>
        <th></th>
        <th><button type='button' class='btn btn-warning' data-toggle='modal' data-toggle='tooltip' title='Supplement toevoegen' data-target='#mijnDialoogscherm'><i class='fas fa-plus'></i></button></th>
        <?php
        //echo "<th>" . anchor('Trainer/Supplement/maakNieuwe', form_button("knopnieuw", "<i class='fas fa-plus'></i>", $toevoegen)) . "</th>";
        ?>
      </tr>
    </thead>
    <tbody>
<?php
    foreach ($supplementen as $supplement) {        
        echo "<tr><td>" . ucfirst($supplement->Naam) . "</td><td>" . ucfirst($supplement->functie->Functie) ."</td><td>" . ucfirst($supplement->Omschrijving) . "</td><td>"
//               . anchor('Trainer/Supplement/wijzig/' . $supplement->ID, form_button("knopWijzig", "<i class='fas fa-pencil-alt'></i>", $wijzigen)) . "</td><td>"
//               . anchor('Trainer/Supplement/schrap/' . $supplement->ID, form_button("knopSchrap", "<i class='fas fa-trash-alt'></i>", $schrappen)) . "</td></tr>\n";
                . "<button type='button' class='btn btn-success' id='aanpassen" . $supplement->ID . "' onclick='supplementUpdate(this.id)' data-id='" . $supplement->ID . "'data-toggle='modal' data-toggle='tooltip' title='Supplement wijzigen' data-target='#aanpassen'><i class='fas fa-pencil-alt'></i></button></td><td>"
                . "<button type='button' class='btn btn-danger' id='verwijder" . $supplement->ID . "' onclick='supplementVerwijder(this.id)' value='" . $supplement->ID . "' data-toggle='tooltip' title='Supplement verwijderen' ><i class='fas fa-trash-alt'></i></button></td></tr>\n";

;}
?>
	

       </tbody>
</table>


<div class="modal fade" id="mijnDialoogscherm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Voedingssupplement toevoegen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                  <form id="form-supplement" action="#" method="post">
                        <table>
                          <tr>
                            <td>
                              <label for="naam">Naam</label>
                              <input type="text" name="naam" id="naam" required>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <label for="functie">Functie</label>                              
                                    <?php
                                        echo form_dropdown('FunctieId', $functieOpties, '0');
                                    ?>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <label for="omschrijving">Omschrijving</label>
                              <input type="text" name="omschrijving" id="omschrijving" required>
                            </td>
                          </tr>
                        </table>

                      </form>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn button-blue" onclick="supplementOpslaan()">Opslaan</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="aanpassen" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Voedingssupplement aanpassen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form id="form-supplement" data-toggle="validator" action="#" method="post">
        <table>
          <tr>
            <td>
                <?php
                                echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => $supplement->ID));
                                ?>
              <?php
                   echo form_labelpro('Naam', 'naam');
                   echo form_input(array('name' => 'naam', 'id' => 'naam', 'value' => $supplement->Naam, 'class' => 'form-control', 'placeholder' => 'Naam', 'required' => 'required'));
              ?>
            </td>
          </tr>
          <tr>
            <td>
              <?php
                   echo form_labelpro('Functie', 'functie');
                   echo form_dropdown('FunctieId', $functieOpties, $supplement->FunctieId);
              ?>
            </td>
          </tr>
          <tr>
            <td>
                <?php
                   echo form_labelpro('Omschrijving', 'omschrijving');
                   echo form_input(array('name' => 'omschrijving', 'id' => 'omschrijving', 'value' => $supplement->Omschrijving, 'class' => 'form-control', 'placeholder' => 'Omschrijving', 'required' => 'required'));
                ?>
            </td>
          </tr>
        </table>

      </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn button-blue" data-dismiss="modal">Sluiten</button>
            </div>
        </div>
    </div>
</div>


     <!-- <button type="button" class="btn btn-primary" onclick="wedstrijdOpslaan()">Opslaan</button> -->



