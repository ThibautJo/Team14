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
<div id="Team">
    <table class="table">
        <tbody>
            <?php
            foreach ($zwemmers as $zwemmer) {
                echo "<tr>"
                . "<td>" . toonAfbeelding('Zwemmers/' . $zwemmer->foto . '.png', 'id="avatar" class="shadow img-circle"') . "</td>"
                . "<td>" . $zwemmer->voornaam . " " . $zwemmer->achternaam . "</td><td>" . $zwemmer->email . "</td></tr>\n";
            }
            ?>
        </tbody>
    </table>
</div>

