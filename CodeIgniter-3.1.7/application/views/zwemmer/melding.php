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
        echo "<tr><td>" . $melding->melding->datumStop . "</td><td>" . $melding->melding->meldingBericht ."</td>";}
?>
       </tbody>
</table>


