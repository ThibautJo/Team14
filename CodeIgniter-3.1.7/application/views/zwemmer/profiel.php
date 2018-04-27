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


?>
<div>
    <h1>Profiel gegevens</h1>
    <p>Naam: <?php echo $profiel->voornaam . " " . $profiel->achternaam?></p>
    <p>Adres: <?php echo $profiel->straat . " " . $profiel->huisnummer ?></p>
    <p>Gemeente: <?php echo $profiel->postcode . " " . $profiel->gemeente ?></p>
    <p>Telefoonnummer: <?php echo $profiel->telefoonnummer?></p>
    <p>Email: <?php echo $profiel->email?></p>
            
</div>
            



