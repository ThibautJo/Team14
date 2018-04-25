<?php

// +----------------------------------------------------------
// |    Trainingscentrum Wezenberg
// +----------------------------------------------------------
// |    Auteur: Lise Van Eyck       |       Helper:
// +----------------------------------------------------------
// |
// |    Melding view
// |
// +----------------------------------------------------------
// |    Team 14
// +----------------------------------------------------------

$personen="";

foreach ($zwemmers as $zwemmer) {
    $personen[$zwemmer->voornaam] = ucfirst($zwemmer->voornaam);
}

$attributenFormulier = array('id' => 'form-melding',
    'class' => 'needs-validation',
    'novalidate' => '',
    'role' => 'form');
?>

<table class="table">
    <thead>
      <tr>
        <th>Datum</th>
        <th>Aan</th>
        <th>Inhoud</th>
        <th></th>
        <th><button type='button' class='btn btn-warning' data-toggle='modal' data-target='#meldingToevoegen'><i class='fas fa-plus'></i></button></th>

      </tr>
    </thead>
    <tbody>
<?php
    foreach ($meldingen as $melding) { 
        $datum = $melding->datumStop;
        if ($datum >= date("Y-m-d")) {
                
                   echo "<tr><td>" . $datum . "</td><td>" . $melding->voornaam . "</td><td>" . $melding->meldingBericht ."</td><td>"
                    . "<button type='button' class='btn btn-success' id='aanpassen" . $melding->meldingPerPersoon . "' onclick='meldingUpdate(this.id)' value='" . $melding->meldingPerPersoon . "' data-toggle='modal' data-target='#meldingAanpassen'><i class='fas fa-pencil-alt'></i></button></td><td>"
                    . "<button type='button' class='btn btn-danger' id='verwijder" . $melding->id . "' onclick='meldingVerwijder(this.id)' value='" . $melding->id . "'><i class='fas fa-trash-alt'></i></button></td></tr>\n"; 
                
            
        }
    };
        
?>
       </tbody>
</table>

<!-- Toevoegen -->
<div class="modal fade" id="meldingToevoegen" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Melding toevoegen</h5>
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
                            echo form_label('Aan', 'aan');
                            echo form_dropdown('zwemmer', $personen, '', "class='form-control'");
                            ?>
                        </div>
                        <div class="form-group">
                            <?php
                            echo form_label('Vervaldatum', 'datumStop');
                            echo form_input(array('type' => 'date',
                                'name' => 'datumStop',
                                'id' => 'datumStop',
                                'value' => date("Y-m-d"),
                                'class' => 'form-control',
                                'required' => 'required'));
                            ?>
                            <div class="invalid-feedback">
                                Kies een datum.
                            </div>
                        </div>
                        <div class="form-group">
                            <?php
                            echo form_label('Inhoud', 'inhoud');
                            echo form_input(array('name' => 'inhoud',
                                'id' => 'inhoud',
                                'value' => '',
                                'class' => 'form-control',
                                'placeholder' => 'Inhoud',
                                'required' => 'required'));
                            ?>
                            <div class="invalid-feedback">
                                Vul dit veld in.
                            </div>
                        </div>
                      <?php echo form_close();?>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn button-primary" data-dismiss="modal">Annuleren</button>
                <button type="button" class="btn button-blue" onclick="meldingOpslaan('toevoegen')">Opslaan</button>
            </div>
        </div>
    </div>
</div>

<!-- aanpassen -->
<div class="modal fade" id="meldingAanpassen" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Melding aanpassen</h5>
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
                    echo form_label('Aan', 'aan');
                    echo form_dropdown('zwemmer', $personen, '', "id='aan' class='form-control'" );
                    ?>
                </div>
                <div class="form-group">
                    <?php
                    echo form_label('Vervaldatum', 'datumStop');
                    echo form_input(array('type' => 'date',
                        'name' => 'datumStop',
                        'id' => 'datumStop',
                        'value' => 'date("Y-m-d")',
                        'class' => 'form-control',
                        'required' => 'required'));
                    ?>
                    <div class="invalid-feedback">
                        Kies een datum.
                    </div>
                </div>
                <div class="form-group">
                    <?php
                    echo form_label('Inhoud', 'inhoud');
                    echo form_input(array('name' => 'inhoud',
                        'id' => 'inhoud',
                        'value' => '',
                        'class' => 'form-control',
                        'placeholder' => 'Inhoud',
                        'required' => 'required'));
                    ?>
                    <div class="invalid-feedback">
                        Vul dit veld in.
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn button-primary" data-dismiss="modal">Annuleren</button>
                <button type="button" class="btn button-blue" onclick="MeldingOpslaan('aanpassen')">Opslaan</button>
            </div>
        </div>
    </div>
</div>

<script>



</script>


