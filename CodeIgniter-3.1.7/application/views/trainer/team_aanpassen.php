<?php
// +----------------------------------------------------------
// |    Trainingscentrum Wezenberg
// +----------------------------------------------------------
// |    Auteur: Klaus Daems       |       Helper:
// +----------------------------------------------------------
// |
// |    Zwemmers beheren
// |
// +----------------------------------------------------------
// |    Team 14
// +----------------------------------------------------------

$attributenFormulier = array('id' => 'form-persoon',
    'data-toggle' => 'validator',
    'role' => 'form',
    'enctype' => 'multipart/form-data');

$archiveren = array('class' => 'btn btn-danger btn-xs btn-round', 'data-toggle' => 'tooltip', 'title' => 'Persoon archiveren');
?>
<div id="Team">
    <div style="float:right">
        <?php
        echo "<button type='button' class='btn btn-warning btn-xs btn-round' data-toggle='modal' data-toggle='tooltip' title='Persoon toevoegen' data-target='#persoonToevoegen'><i class='fas fa-plus'></i></button>";
        echo "<button type='button' class='btn btn-warning btn-xs btn-round' data-toggle='modal' data-toggle='tooltip' title='Persoon toevoegen uit archief' data-target='#zwemmerToevoegenUitArchief'><i class='fas fa-archive'></i></button>";
        ?>
        <br>
    </div>
    <table class="table">
        <tbody>
            <?php
            foreach ($personen as $persoon) {
                echo "<tr>"
                . "<td>" . toonAfbeelding('Profiel/Avatar_' . $persoon->voornaam . "_" . $persoon->achternaam . '.jpg', 'id="avatar" class="shadow img-circle"') . "</td>"
                . "<td>" . $persoon->voornaam . " " . $persoon->achternaam . "</td><td>" . $persoon->email . "</td>
                <td><button type='button' class='btn btn-success' id='aanpassen" . $persoon->id . "' onclick='persoonUpdate(this.id)' value='" . $persoon->id . "'data-toggle='modal' data-toggle='tooltip' title='Persoon wijzigen' data-target='#persoonWijzigen'>" . "<i class='fas fa-pencil-alt'></i></button>"
                        . anchor('Trainer/Team/archiveren/' . $persoon->id, form_button("knopArchiveer", "<i class='fas fa-archive'></i>", $archiveren)) . "</td></tr>\n";
            }
            ?>
        </tbody>
    </table>
</div>

<?php 
$opties = array('Zwemmer' => 'Zwemmer', 'Trainer' => 'Trainer');
?>
<!-- Modal Toevoegen -->
<div class="modal fade" id="persoonToevoegen" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-center">
                <h5 class="modal-title" id="exampleModalLongTitle">Persoon toevoegen</h5> <!-- Modal titel -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <!-- Modal sluit knop ( X ) -->
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"> <!-- Modal inhoud -->
                <?php
                echo form_open('', $attributenFormulier);
                ?>
                
                <div class="form-group">
                    <?php
                    echo form_label('Soort', 'soort');
                    echo form_dropdown('soort', $opties, '', 'class="form-control"')
                    ?>
                    <div class="help-block with-errors"></div>
                </div>
                
                <div class="form-group">
                    <?php
                    echo form_label('Voornaam', 'voornaam');
                    echo form_input(array('name' => 'voornaam',
                        'id' => 'voornaam',
                        'value' => '',
                        'class' => 'form-control',
                        'placeholder' => 'Voornaam',
                        'required' => 'required'));
                    ?>
                    <div class="help-block with-errors"></div>
                </div>
                
                <div class="form-group">
                    <?php
                    echo form_label('Achternaam', 'achternaam');
                    echo form_input(array('name' => 'achternaam',
                        'id' => 'achternaam',
                        'value' => '',
                        'class' => 'form-control',
                        'placeholder' => 'Achternaam',
                        'required' => 'required'));
                    ?>
                    <div class="help-block with-errors"></div>
                </div>
                
                <div class="form-group">
                    <?php
                    echo form_label('Email', 'email');
                    echo form_input(array('name' => 'email',
                        'id' => 'email',
                        'value' => '',
                        'class' => 'form-control',
                        'placeholder' => 'Email',
                        'required' => 'required'));
                    ?>
                    <div class="help-block with-errors"></div>
                </div>
                
                <div class="form-group">
                    <?php
                    echo form_label('Wachtwoord', 'wachtwoord');
                    echo form_input(array('name' => 'wachtwoord',
                        'id' => 'wachtwoord',
                        'value' => '',
                        'class' => 'form-control',
                        'placeholder' => 'Wachtwoord',
                        'required' => 'required'));
                    ?>
                    <div class="help-block with-errors"></div>
                </div>
                
                <div class="form-group">
                    <?php
                    echo form_label('Over jezelf', 'over jezelf');
                    echo form_input(array('name' => 'omschrijving',
                        'id' => 'omschrijving',
                        'value' => '',
                        'class' => 'form-control',
                        'placeholder' => 'Omschrijving',
                        'required' => 'required'));
                    ?>
                    <div class="help-block with-errors"></div>
                </div>
                
                <div class="form-group">
                    <?php
                    echo form_label('Upload profielfoto ', 'upload profielfoto ');
                    echo form_label(' -> "Avatar_Voornaam_Achternaam.jpg"');
                    echo form_upload(array('name' => 'upload',
                        'id' => 'upload',
                        'value' => '',
                        'class' => 'form-control-file'))
                    ?>
                    <div class="help-block with-errors"></div>
                </div>
                
                <?php echo form_close();?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn button-blue" data-dismiss="modal">Sluiten</button> <!-- Modal sluit knop -->
                <button type="button" class="btn button-blue" onclick="persoonOpslaan('toevoegen')">Opslaan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Wijzigen -->
<div class="modal fade" id="persoonWijzigen" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Gegevens wijzigen</h5> <!-- Modal titel -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <!-- Modal sluit knop ( X ) -->
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"> <!-- Modal inhoud -->
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
                    echo form_label('Voornaam', 'voornaam');
                    echo form_input(array('name' => 'voornaam',
                        'id' => 'voornaam',
                        'value' => '',
                        'class' => 'form-control',
                        'placeholder' => 'Voornaam',
                        'required' => 'required'));
                    ?>
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <?php
                    echo form_label('Achternaam', 'achternaam');
                    echo form_input(array('name' => 'achternaam',
                        'id' => 'achternaam',
                        'value' => '',
                        'class' => 'form-control',
                        'placeholder' => 'Achternaam',
                        'required' => 'required'));
                    ?>
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <?php
                    echo form_label('Email', 'email');
                    echo form_input(array('name' => 'email',
                        'id' => 'email',
                        'value' => '',
                        'class' => 'form-control',
                        'placeholder' => 'Email',
                        'required' => 'required'));
                    ?>
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <?php
                    echo form_label('Over jezelf', 'over jezelf');
                    echo form_input(array('name' => 'omschrijving',
                        'id' => 'omschrijving',
                        'value' => '',
                        'class' => 'form-control',
                        'placeholder' => 'Omschrijving'));
                    ?>
                    <div class="help-block with-errors"></div>
                </div>
                <?php echo form_close();?>
            </div>
            <div class="modal-footer form-group">
                <button type="button" class="btn button-blue" data-dismiss="modal">Sluiten</button> <!-- Modal sluit knop -->
                <button type="button" class="btn button-blue" onclick="persoonOpslaan('wijzigen')">Opslaan</button>
            </div>
        </div>
    </div>
</div>

    
<?php
$archief="";
$archief[0]="--Select--";

foreach ($zwemmersuitarchief as $zwemmeruitarchief) {
    $archief[$zwemmeruitarchief->id] = $zwemmeruitarchief->voornaam . " " . $zwemmeruitarchief->achternaam;
}

?>
<!-- Zwemmer uit archief halen -->
<div class="modal fade" id="zwemmerToevoegenUitArchief" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-center">
                <h5 class="modal-title" id="exampleModalLongTitle">Zwemmer toevoegen uit archief</h5> <!-- Modal titel -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <!-- Modal sluit knop ( X ) -->
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"> <!-- Modal inhoud -->
                <?php
                echo form_open('', $attributenFormulier);
                ?>
                
                <div class="form-group">
                            <?php
                            echo form_label('Archief', 'archief');
                            echo form_dropdown('archief', $archief, 'id="zwemmeruitarchief"', 'class="form-control"');

                            ?>
                            <div class="help-block with-errors"></div>
                        </div>
                <?php echo form_close();?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn button-blue" data-dismiss="modal">Sluiten</button> <!-- Modal sluit knop -->
                <button type="button" class="btn button-blue" onclick="zwemmerUitArchiefHalen()">Opslaan</button>
            </div>
        </div>
    </div>
</div>