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
$teller = 0;

foreach ($meldingen as $melding) {
    $datum = $melding->melding->datumStop;
    if ($datum >= date("Y-m-d")) {
        echo "<tr><td>" . $datum . "</td><td>" . $melding->melding->meldingBericht . "</td></tr>";
        $teller++;
    }
};

if ($teller === 0) {
    echo "<tr><td>U heeft geen meldingen.</td></tr>";
};
?>
    </tbody>
</table>


