<?php

// +----------------------------------------------------------
// |    Trainingscentrum Wezenberg
// +----------------------------------------------------------
// |    Auteur: Lise Van Eyck       |       Helper:
// +----------------------------------------------------------
// |
// |    Melding view
// |
// +----------------------------------------------------------
// |    Team 14
// +----------------------------------------------------------

/**
 * @file melding.php
 * 
 * View waarin alle meldingen worden weergegeven.
 * - krijgt een $meldingen binnen.
 */

?>
<table class="table">
    <thead>
        <tr>
            <th>Datum</th>
            <th>Aan</th>
            <th>Inhoud</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($meldingen as $melding) {
            $datum = $melding->datumStop;
            if ($datum >= date("Y-m-d")) {
                echo "<tr><td>" . $datum . "</td><td>" . $melding->voornaam . "</td><td>" . $melding->meldingBericht . "</td>";
            }
        };
        ?>
        <tr><td><?php echo divAnchor('/Trainer/melding/beheren/', 'Aanpassen', 'class="btn button-blue justify-content-center"') ?></td><td></td><td></td></tr>
    </tbody>
</table>

