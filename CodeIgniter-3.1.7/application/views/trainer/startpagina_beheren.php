<?php

// +----------------------------------------------------------
// |    Trainingscentrum Wezenberg
// +----------------------------------------------------------
// |    Auteur: Jolien Lauwers      |       Helper:
// +----------------------------------------------------------
// |
// |    Startpagina beheren view
// |
// +----------------------------------------------------------
// |    Team 14
// +----------------------------------------------------------

/**
 * @file startpagina_beheren.php
 * 
 * View waarin een lijst van huidige startpaginaitems worden weergegeven
 * - krijgt $startpaginatekst binnen
 */

$attributenFormulier = array('id' => 'form-supplement',
    'class' => 'needs-validation',
    'novalidate' => '',
    'role' => 'form');
?>

<table class="table">
    <thead>
      <tr>
        <th>Titel</th>
        
        <th>Inhoud</th>
        <th></th>
        <th><button type='button' class='btn btn-warning' data-toggle='modal' data-toggle='tooltip' title='Artikel toevoegen' data-target='#artikelToevoegen'><i class='fas fa-plus'></i></button></th>
      </tr>
    </thead>
    <tbody>
<?php

    foreach ($startpaginateksten as $startpaginatekst) {        
        echo "<tr id='" . $startpaginatekst->id . "'><td>" . ucfirst($startpaginatekst->titel) . "</td><td>" . ucfirst($startpaginatekst->inhoud) . "</td></tr>\n";

;}
?>
	

       </tbody>
</table>

