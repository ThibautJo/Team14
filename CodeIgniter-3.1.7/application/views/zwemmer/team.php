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
$attributenFormulier = array('id' => 'form-zwemmer',
    'data-toggle' => 'validator',
    'role' => 'form',
    'enctype' => 'multipart/form-data');

$profielTonen = array('class' => 'btn btn-danger btn-xs btn-round', 'data-toggle' => 'tooltip', 'title' => 'Zwemmer profiel tonen');
?>
<div id="Team">
    <table class="table">
        <tbody>
            <?php
            foreach ($zwemmers as $zwemmer) {
                echo "<tr>"
                . "<td>" . toonAfbeelding('Profiel/Avatar_' . $zwemmer->voornaam . "_" . $zwemmer->achternaam . '.jpg', 'id="avatar" class="shadow img-circle"') . "</td>"
                . "<td>" . $zwemmer->voornaam . " " . $zwemmer->achternaam . "</td><td>" . $zwemmer->email . "</td>
                <td><button type='button' class='btn btn-success' id='tonen" . $zwemmer->id . "' onclick='zwemmerProfielTonen(this.id)' value='" . $zwemmer->id . "'data-toggle='modal' data-toggle='tooltip' title='Zwemmer profiel tonen' data-target='#profielTonen'>" . "<i class='far fa-address-card'></i></button></td></tr>\n";
            }
            ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="profielTonen" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Profiel</h5> <!-- Modal titel -->
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
                        'readonly' => 'readonly'));
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
                        'readonly' => 'readonly'));
                    ?>
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <?php
                    echo form_label('Adres', 'Adres');
                    echo form_input(array('name' => 'straat',
                        'id' => 'straat',
                        'value' => '',
                        'class' => 'form-control',
                        'placeholder' => 'Straat',
                        'readonly' => 'readonly'));
                    echo form_input(array('name' => 'huisnummer',
                        'id' => 'huisnummer',
                        'value' => '',
                        'class' => 'form-control',
                        'placeholder' => 'Huisnummer',
                        'readonly' => 'readonly'));
                    echo form_input(array('name' => 'postcode',
                        'id' => 'postcode',
                        'value' => '',
                        'class' => 'form-control',
                        'placeholder' => 'Postcode',
                        'readonly' => 'readonly'));
                    echo form_input(array('name' => 'gemeente',
                        'id' => 'gemeente',
                        'value' => '',
                        'class' => 'form-control',
                        'placeholder' => 'Gemeente',
                        'readonly' => 'readonly'));
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
                        'placeholder' => 'Telefoonnummer',
                        'readonly' => 'readonly'));
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
                        'readonly' => 'readonly'));
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
                        'readonly' => 'readonly'));
                    ?>
                    <div class="help-block with-errors"></div>
                </div>
                <?php echo form_close(); ?>
                <div class="modal-footer form-group">
                    <button type="button" class="btn button-blue" data-dismiss="modal">Sluiten</button> <!-- Modal sluit knop -->
                </div>
            </div>
        </div>
    </div>
</div>

