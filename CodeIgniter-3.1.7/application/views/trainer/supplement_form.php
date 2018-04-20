<?php

/**
 * @file supplement_form.php
 * 
 * View waarin de gegevens van een supplement worden weergegeven
 * - krijgt een $supplement-object binnen
 */

// +----------------------------------------------------------
// |    Trainingscentrum Wezenberg
// +----------------------------------------------------------
// |    Auteur: Lise Van Eyck       |       Helper:
// +----------------------------------------------------------
// |
// |    Supplement form view
// |
// +----------------------------------------------------------
// |    Team 14
// +----------------------------------------------------------

echo haalJavascriptOp("validator.js");

$attributenFormulier = array('id' => 'mijnFormulier',
    'data-toggle' => 'validator',
    'role' => 'form');
echo form_open('Trainer/Supplement/registreer', $attributenFormulier);

$functieOpties="";
$functieOpties[0] = '--Select--';

foreach ($functies as $functie) {
    $functieOpties[$functie->ID] = ucfirst($functie->Functie);
}

?>

<div class="form-group">
    <?php
    echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => $supplement->ID));
    ?>
</div>

<div class="form-group">
    <?php
    echo form_labelpro('Naam', 'naam');
    echo form_input(array('name' => 'naam',
        'id' => 'naam',
        'value' => $supplement->Naam,
        'class' => 'form-control',
        'placeholder' => 'Naam',
        'required' => 'required'));
    ?>
    <div class="help-block with-errors"></div>
</div>

<div class="form-group">
    <?php
    echo form_labelpro('Functie', 'functie');

    echo form_dropdown('functie', $functieOpties, '0', 'class="form-control"');

    echo form_dropdown('FunctieId', $functieOpties, $supplement->FunctieId);
    ?>
    <div class="help-block with-errors"></div>
</div>

<div class="form-group">
    <?php
    echo form_labelpro('Omschrijving', 'omschrijving');
    echo form_input(array('name' => 'omschrijving',
        'id' => 'omschrijving',
        'value' => $supplement->Omschrijving,
        'class' => 'form-control',
        'placeholder' => 'Omschrijving',
        'required' => 'required'));
    ?>
    <div class="help-block with-errors"></div>
</div>

<div class="form-group">
    <?php echo form_submit('knop', 'Opslaan', "class='btn btn-primary'") ?>
</div>

<?php echo form_close(); ?>
