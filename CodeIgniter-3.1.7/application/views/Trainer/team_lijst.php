
<?php
// +----------------------------------------------------------
// |    Trainingscentrum Wezenberg
// +----------------------------------------------------------
// |    Auteur: Klaus Daems       |       Helper:
// +----------------------------------------------------------
// |
// |    Training home
// |
// +----------------------------------------------------------
// |    Team 14
// +----------------------------------------------------------
?>
<?php
$aanpassen = array('class' => 'btn btn-warning btn-xs btn-round', 'data-toggle' => 'tooltip', 'title' => 'Team aanpassen');
?>


<div id="team">
    <div>
        <?php
        echo "<th>" . anchor('Trainer/Team/aanpassen', form_button("knopaanpassen", "<i class='fas fa-plus'></i>", $aanpassen)) . "</th>";
        ?>
        <br>
    </div>
    <?php
    foreach ($zwemmers as $zwemmer)
        echo "<div><h2>" . toonAfbeelding('Zwemmers/' . $zwemmer->Foto . '.png', 'id="avatar" class="shadow img-circle"') . " " . $zwemmer->Voornaam . " " . $zwemmer->Achternaam . "</h2></div>"
        ?>
</div>
