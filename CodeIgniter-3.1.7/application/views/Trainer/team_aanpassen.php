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

$attributenFormulier = array('id' => 'form-zwemmer',
    'data-toggle' => 'validator',
    'role' => 'form');

$archiveren = array('class' => 'btn btn-danger btn-xs btn-round', 'data-toggle' => 'tooltip', 'title' => 'Zwemmer archiveren');
?>
<div id="Team">
    <div style="float:right">
        <?php
        echo "<button type='button' class='btn btn-warning btn-xs btn-round' data-toggle='modal' data-toggle='tooltip' title='Zwemmer toevoegen' data-target='#zwemmerToevoegen'><i class='fas fa-plus'></i></button>";
        ?>
        <br>
    </div>
    <table class="table">
        <tbody>
            <?php
            foreach ($zwemmers as $zwemmer) {
                echo "<tr>"
                . "<td>" . toonAfbeelding('Zwemmers/' . $zwemmer->foto . '.png', 'id="avatar" class="shadow img-circle"') . "</td>"
                . "<td>" . $zwemmer->voornaam . " " . $zwemmer->achternaam . "</td><td>" . $zwemmer->email . "</td>
                <td><button type='button' class='btn btn-success' id='aanpassen" . $zwemmer->id . "' onclick='zwemmerUpdate(this.id)' value='" . $zwemmer->id . "'data-toggle='modal' data-toggle='tooltip' title='Zwemmer wijzigen' data-target='#zwemmerAanpassen'>" . "<i class='fas fa-pencil-alt'></i></button>"
                . "<td><button type='button' class='btn btn-danger' id='archiveren" . $zwemmer->id . "' onclick='zwemmerArchiveer(this.id)' value='" . $zwemmer->id . "'data-toggle='modal' data-toggle='tooltip' title='Zwemmer archiveren'>" . "<i class='fas fa-archive'></i></button>"
                        . anchor('Trainer/Team/archiveren/' . $zwemmer->id, form_button("knopArchiveer", "<i class='fas fa-pencil-alt'></i>", $archiveren)) . "</td></tr>\n";
            }
            ?>
        </tbody>
    </table>
</div>


<!-- Modal Toevoegen -->
<div class="modal fade" id="zwemmerToevoegen" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-center">
                <h5 class="modal-title" id="exampleModalLongTitle">Zwemmer toevoegen</h5> <!-- Modal titel -->
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
                
                <?php echo form_close();?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn button-blue" data-dismiss="modal">Sluiten</button> <!-- Modal sluit knop -->
                <button type="button" class="btn button-blue" onclick="zwemmerOpslaan('toevoegen')">Opslaan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Wijzigen -->
<div class="modal fade" id="zwemmerAanpassen" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Zwemmer wijzigen</h5> <!-- Modal titel -->
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
                        'placeholder' => 'Omschrijving',));
                    ?>
                    <div class="help-block with-errors"></div>
                </div>
                <?php echo form_close();?>
            </div>
            <div class="modal-footer form-group">
                <button type="button" class="btn button-blue" data-dismiss="modal">Sluiten</button> <!-- Modal sluit knop -->
                <button type="button" class="btn button-blue" onclick="zwemmerOpslaan('aanpassen')">Opslaan</button>
            </div>
        </div>
    </div>
</div>