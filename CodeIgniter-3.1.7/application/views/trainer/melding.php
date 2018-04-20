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


?>

<table class="table">
    <thead>
      <tr>
        <th>Datum</th>
        <th>Inhoud</th>
      </tr>
    </thead>
    <tbody>
<?php
    foreach ($meldingen as $melding) { 
        $datum = $melding->datumStop;
        if ($datum >= date("Y-m-d")) {
            echo "<tr><td>" . $datum . "</td><td>" . $melding->meldingBericht ."</td>";
        }
    };
        
?>
       </tbody>
</table>


