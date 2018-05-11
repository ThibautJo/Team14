<?php

/**
 * @file supplement_lijst.php
 * 
 * View waarin een lijst van supplement gegevens worden weergegeven
 * - krijgt een $supplementen-object binnen
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

$functieOpties="";

foreach ($functies as $functie) {
    $functieOpties[$functie->id] = ucfirst($functie->supplementFunctie);
}

$attributenFormulier = array('id' => 'form-supplement',
    'class' => 'needs-validation',
    'novalidate' => '',
    'role' => 'form');
?>

<table class="table">
    <thead>
      <tr>
        <th>Naam</th>
        <th>Functie</th>
        <th>Omschrijving</th>
        <th></th>
        <th><button type='button' class='btn btn-warning' data-toggle='modal' data-toggle='tooltip' title='Supplement toevoegen' data-target='#supplementToevoegen'><i class='fas fa-plus'></i></button></th>
      </tr>
    </thead>
    <tbody>
<?php

    foreach ($supplementen as $supplement) {        
        echo "<tr id='" . $supplement->id . "'><td>" . ucfirst($supplement->naam) . "</td><td>" . ucfirst($supplement->supplementFunctie->supplementFunctie) ."</td><td>" . ucfirst($supplement->omschrijving) . "</td><td>"
                . "<button type='button' class='btn btn-success' id='aanpassen" . $supplement->id . "' onclick='supplementUpdate(this.id)' value='" . $supplement->id . "'data-toggle='modal' data-toggle='tooltip' title='Supplement wijzigen' data-target='#supplementAanpassen'><i class='fas fa-pencil-alt'></i></button></td><td>"
                . "<button type='button' class='btn btn-danger' id='verwijder" . $supplement->id . "' onclick='supplementVerwijder(this.id)' value='" . $supplement->id . "' data-toggle='tooltip' title='Supplement verwijderen' ><i class='fas fa-trash-alt'></i></button></td></tr>\n";

;}
?>
	

       </tbody>
</table>


<!-- Toevoegen -->
<div class="modal fade" id="supplementToevoegen" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Voedingssupplement toevoegen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                    echo form_open('', $attributenFormulier);
                ?>
                        <div class="form-group">
                            <?php
                            echo form_label('Naam', 'naam');
                            echo form_input(array('name' => 'naam',
                                'id' => 'naam',
                                'value' => '',
                                'class' => 'form-control',
                                'placeholder' => 'Naam',
                                'required' => 'required'));
                            echo form_label("Vak is leeg!", 'naam', array("id" => "naam-fout", "class" => "fout", "hidden" => "hidden"));
                            ?>
                            <div class="invalid-feedback">
                                Vul dit veld in.
                            </div>
                        </div>
                        <div class="form-group">
                            <?php
                            echo form_label('Functie', 'functie');
                            echo form_dropdown('functie', $functieOpties, '', "class='form-control'");
                            ?>
                        </div>
                 
                        <div class="form-group">
                            <?php
                            echo form_label('Omschrijving', 'omschrijving');
                            echo form_input(array('name' => 'omschrijving',
                                'id' => 'omschrijving',
                                'value' => '',
                                'class' => 'form-control',
                                'placeholder' => 'Omschrijving',
                                'required' => 'required'));
                            echo form_label("Vak is leeg!", 'omschrijving', array("id" => "omschrijving-fout", "class" => "fout", "hidden" => "hidden"));
                            ?>
                            <div class="invalid-feedback">
                                Vul dit veld in.
                            </div>
                        </div>
                          
                      <?php echo form_close();?>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn button-primary" data-dismiss="modal">Annuleren</button>
                <button type="button" class="btn button-blue" onclick="supplementOpslaan('toevoegen')">Opslaan</button>
            </div>
        </div>
    </div>
</div>

<!-- aanpassen -->
<div class="modal fade" id="supplementAanpassen" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Voedingssupplement aanpassen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                    echo form_open('', $attributenFormulier);
                ?>
                <div class="form-group">
                    <?php
                    echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => ''));
                    ?>
                </div>
        
                <div class="form-group">
                    <?php
                    echo form_label('Naam', 'naam');
                    echo form_input(array('name' => 'naam',
                        'id' => 'naam',
                        'value' => '',
                        'class' => 'form-control',
                        'placeholder' => 'Naam',
                        'required' => 'required'));
                    echo form_label("Vak is leeg!", 'naam', array("id" => "naam-fout", "class" => "fout", "hidden" => "hidden"));
                    ?>
                    <div class="invalid-feedback">
                        Vul dit veld in.
                    </div>
                </div>
                
                <div class="form-group">
                    <?php
                    echo form_label('Functie', 'functie');
                    echo form_dropdown('functie', $functieOpties, '', "id='functie' class='form-control'");
                    ?>
                </div>
                
                <div class="form-group">
                    <?php
                    echo form_label('Omschrijving', 'omschrijving');
                    echo form_input(array('name' => 'omschrijving',
                        'id' => 'omschrijving',
                        'value' => '',
                        'class' => 'form-control',
                        'placeholder' => 'Omschrijving',
                        'required' => 'required'));
                    echo form_label("Vak is leeg!", 'naam', array("id" => "naam-fout", "class" => "fout", "hidden" => "hidden"));
                    ?>
                    <div class="invalid-feedback">
                        Vul dit veld in.
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn button-primary" data-dismiss="modal">Annuleren</button>
                <button type="button" class="btn button-blue" onclick="supplementOpslaan('aanpassen')">Opslaan</button>
            </div>
        </div>
    </div>
</div>



