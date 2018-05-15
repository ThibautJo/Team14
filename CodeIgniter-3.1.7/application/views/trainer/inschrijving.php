<?php
/**
 * @file inschrijving.php
 * 
 * View waarin een lijst van inschrijving gegevens worden weergegeven
 * - krijgt een $inschrijvingen-object binnen
 */
// +----------------------------------------------------------
// |    Trainingscentrum Wezenberg
// +----------------------------------------------------------
// |    Auteur: Lise Van Eyck       |       Helper:
// +----------------------------------------------------------
// |
// |    Inschrijving view
// |
// +----------------------------------------------------------
// |    Team 14
// +----------------------------------------------------------
?>

<table class="table">
    <thead>
        <tr>
            <th>Wedstrijd</th>
            <th>Reeks</th>
            <th>Zwemmer</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($inschrijvingen as $inschrijving) {
            echo "<tr id='" . $inschrijving->inschrijving . "'><td>" . $inschrijving->naam . "</td><td>" . $inschrijving->afstand . ' ' . $inschrijving->slag . "</td><td>" . $inschrijving->voornaam . ' ' . $inschrijving->achternaam . "</td></tr>\n";
        }
        ?>
        <tr><td><?php echo divAnchor('/Trainer/Inschrijving/aanpassen/', 'Aanpassen', 'class="btn button-blue justify-content-center"') ?></td><td></td><td></td></tr>
    </tbody>
</table>


