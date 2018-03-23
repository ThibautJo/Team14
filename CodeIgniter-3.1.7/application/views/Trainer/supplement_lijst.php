<?php
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

$wijzigen = array('class' => 'btn btn-success btn-xs btn-round', 'data-toggle' => 'tooltip', 'title' => 'Supplement wijzigen');
$schrappen = array('class' => 'btn btn-danger btn-xs btn-round', 'data-toggle' => 'tooltip', 'title' => 'Supplement schrappen');
$toevoegen = array('class' => 'btn btn-warning btn-xs btn-round', 'data-toggle' => 'tooltip', 'title' => 'Supplement toevoegen');


?>

<table class="table">
    <thead>
      <tr>
        <th>Naam</th>
        <th>Functie</th>
        <th>Omschrijving</th>
        <th></th>
        <?php
        echo "<th>" . anchor('Trainer/Supplement/maakNieuwe', form_button("knopnieuw", "<i class='fas fa-plus'></i>", $toevoegen)) . "</th>";
        ?>
      </tr>
    </thead>
    <tbody>
<?php
    foreach ($supplementen as $supplement) {        
        echo "<tr><td>" . $supplement->Naam . "</td><td>" . ucfirst($supplement->functie->Functie) ."</td><td>" . ucfirst($supplement->Omschrijving) . "</td><td>"
               . anchor('Trainer/Supplement/wijzig/' . $supplement->ID, form_button("knopWijzig", "<i class='fas fa-pencil-alt'></i>", $wijzigen)) . "</td><td>"
               . anchor('Trainer/Supplement/schrap/' . $supplement->ID, form_button("knopSchrap", "<i class='fas fa-trash-alt'></i>", $schrappen)) . "</td></tr>\n";
;}
?>
	

       </tbody>
</table>

