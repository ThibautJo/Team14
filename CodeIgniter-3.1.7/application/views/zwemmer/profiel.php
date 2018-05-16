<?php
// +----------------------------------------------------------
// |    Trainingscentrum Wezenberg
// +----------------------------------------------------------
// |    Auteur: Klaus Daems       |       Helper:
// +----------------------------------------------------------
// |
// |    Profiel view
// |
// +----------------------------------------------------------
// |    Team 14
// +----------------------------------------------------------

$attributenFormulier = array('id' => 'form-profiel',
    'data-toggle' => 'validator',
    'role' => 'form',
    'enctype' => 'multipart/form-data');
?>
<div>
    <p>Naam: <?php echo $profiel->voornaam . " " . $profiel->achternaam ?></p>
    <p>Adres: <?php echo $profiel->straat . " " . $profiel->huisnummer ?></p>
    <p>Gemeente: <?php echo $profiel->postcode . " " . $profiel->gemeente ?></p>
    <p>Telefoonnummer: <?php echo $profiel->telefoonnummer ?></p>
    <p>Email: <?php echo $profiel->email ?></p>
    <p>Over jezelf</p>
    <p><textarea rows="2" cols="25"><?php echo $profiel->omschrijving ?></textarea></p>
    <button type="button" class="btn button-blue justify-content-center" id="<?php echo $profiel->id ?>" onclick='profielGegevensTonen(this.id)' value="<?php echo $profiel->id ?>" data-toggle='modal' data-toggle='tooltip' title='Profiel wijzigen' data-target="#profielWijzigen">Aanpassen</button>
</div>

<div class="modal fade" id="profielWijzigen" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Profielgegevens wijzigen</h5> <!-- Modal titel -->
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
                    echo form_label('Naam', 'naam');
                    echo form_input(array('name' => 'achternaam',
                        'id' => 'achternaam',
                        'value' => '',
                        'class' => 'form-control',
                        'placeholder' => 'Achternaam',
                        'required' => 'required'));
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
                    echo form_label('Adres', 'adres');
                    echo form_input(array('name' => 'straat',
                        'id' => 'straat',
                        'value' => '',
                        'class' => 'form-control',
                        'placeholder' => 'Straat'));
                    echo form_input(array('name' => 'huisnummer',
                        'id' => 'huisnummer',
                        'value' => '',
                        'class' => 'form-control',
                        'placeholder' => 'Huisnummer'));
                    ?>
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <?php
                    echo form_label('Gemeente', 'gemeente');
                    echo form_input(array('name' => 'postcode',
                        'id' => 'postcode',
                        'value' => '',
                        'class' => 'form-control',
                        'placeholder' => 'Postcode'));
                    echo form_input(array('name' => 'gemeente',
                        'id' => 'gemeente',
                        'value' => '',
                        'class' => 'form-control',
                        'placeholder' => 'Gemeente'));
                    ?>
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <?php
                    echo form_label('Telefoonnummer', 'telefoonnummer');
                    echo form_input(array('name' => 'telefoonnummer',
                        'id' => 'telefoonnummer',
                        'value' => '',
                        'class' => 'form-control',
                        'placeholder' => 'Telefoonnummer'));
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
                <?php echo form_close(); ?>
            </div>
            <div class="modal-footer form-group">
                <button type="button" class="btn button-blue" data-dismiss="modal">Annuleren</button> <!-- Modal sluit knop -->
                <button type="button" class="btn button-blue" onclick="profielOpslaan()">Opslaan</button>
            </div>
        </div>
    </div>
</div>




