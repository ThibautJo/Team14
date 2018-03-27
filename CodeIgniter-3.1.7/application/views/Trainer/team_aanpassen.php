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

$wijzigen = array('class' => 'btn btn-success btn-xs btn-round', 'data-toggle' => 'tooltip', 'title' => 'Zwemmer wijzigen');
$schrappen = array('class' => 'btn btn-danger btn-xs btn-round', 'data-toggle' => 'tooltip', 'title' => 'Zwemmer schrappen');
$toevoegen = array('class' => 'btn btn-warning btn-xs btn-round', 'data-toggle' => 'tooltip', 'title' => 'Zwemmer toevoegen');
?>
<div>
    <?php
    echo "<th>" . anchor('Trainer/Team/toevoegen', form_button("knoptoevoegen", "<i class='fas fa-plus'></i>", $toevoegen)) . "</th>";
    ?>
    <br>
</div>
<table class="table">
    <tbody>
<?php
foreach ($zwemmers as $zwemmer) {
    echo "<tr><td>" . toonAfbeelding('Zwemmers/' . $zwemmer->Foto . '.png', 'id="avatar" class="shadow img-circle"') . "</td><td>" . $zwemmer->Voornaam . " " . $zwemmer->Achternaam . "</td><td>" . $zwemmer->Email . "</td><td>"
    . anchor('Trainer/Team/wijzig/' . $zwemmer->ID, form_button("knopWijzig", "<i class='fas fa-pencil-alt'></i>", $wijzigen)) . "</td><td>"
    . anchor('Trainer/Team/schrap/' . $zwemmer->ID, form_button("knopSchrap", "<i class='fas fa-trash-alt'></i>", $schrappen)) . "</td></tr>\n";
    ;
}
?>
    </tbody>
</table>

 <div class="popup" onclick="">Click me!
  <span class="popuptext" id="myPopup">Popup text...</span>
</div> 
