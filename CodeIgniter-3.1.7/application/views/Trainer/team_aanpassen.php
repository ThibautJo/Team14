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

$wijzigen = array('class' => 'btn btn-success btn-xs btn-round', 'data-toggle' => 'tooltip', 'title' => 'Zwemmer wijzigen' , 'id' => '$zwemmer->ID');
$schrappen = array('class' => 'btn btn-danger btn-xs btn-round', 'data-toggle' => 'tooltip', 'title' => 'Zwemmer schrappen');
$toevoegen = array('class' => 'btn btn-warning btn-xs btn-round', 'data-toggle' => 'tooltip', 'title' => 'Zwemmer toevoegen');
?>
<div id="Team">
<div>
    <button type="button" class="btn btn-primary" onclick="popupZwemmerToevoegen()" style="float:right;">Toevoegen</button>
</div>
<table class="table">
    <tbody>
        <?php
        foreach ($zwemmers as $zwemmer) {
            echo "<tr><td>" . toonAfbeelding('Zwemmers/' . $zwemmer->Foto . '.png', 'id="avatar" class="shadow img-circle"') . "</td><td>" . $zwemmer->Voornaam . " " . $zwemmer->Achternaam . "</td><td>" . $zwemmer->Email . "</td><td>"
            . anchor('Trainer/Team/wijzig/' . $zwemmer->ID, form_button("knopWijzig", "<i class='fas fa-pencil-alt' onclick='pupZwemmerWijzigen'></i>", $wijzigen))
            . anchor('Trainer/Team/schrap/' . $zwemmer->ID, form_button("knopSchrap", "<i class='fas fa-trash-alt'></i>", $schrappen)) . "</td></tr>\n";
            ;
        }
        ?>
    </tbody>
</table>
</div>


<!-- toegoegen -->
<div class="popup-background"></div>
<div class="popup-dialog" id="toevoegen">
    <div class="popup-header">
        <h3 class="popup-title">Zwemmer toevoegen</h3>
        <button type="button" class="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="popup-content">
        <form id="form-zwemmer" action="#" method="post">
            <div class="container">
            <table style="float:right; padding-right:20px">
                <tr>
                    <td>
                        <label for="titel-wedstrijd">Naam: </label> 
                    </td>
                    <td>
                        <input type="text" name="naam-zwemmer" id="naam-zwemmer" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="titel-wedstrijd">Voornaam: </label> 
                    </td>
                    <td>
                        <input type="text" name="voornaam-zwemmer" id="voornaam-zwemmer" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="titel-wedstrijd">E-mail: </label> 
                    </td>
                    <td>
                        <input type="text" name="email-zwemmer" id="email-zwemmer" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="titel-wedstrijd">Wachtwoord: </label> 
                    </td>
                    <td>
                        <input type="text" name="wachtwoord-zwemmer" id="wachtwoord-zwemmer" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="titel-wedstrijd">Woonplaats: </label> 
                    </td>
                    <td>
                        <input type="text" name="woonplaats-zwemmer" id="woonplaats-zwemmer" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="titel-wedstrijd">Telefoonnummer: </label> 
                    </td>
                    <td>
                        <input type="text" name="telefoonnummer-zwemmer" id="telefoonnummer-zwemmer" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="titel-wedstrijd">Over jezelf: </label> 
                    </td>
                    <td>
                        <textarea rows="5" cols="17" name="omschrijving-zwemmer" id="omschrijving-zwemmer"></textarea>
                    </td>
                </tr>
            </table>
            </div>
        </form>
    </div>
    <div class="popup-footer">
        <button type="button" class="btn btn-primary" onclick="$toevoegen" style="float:right;">Toevoegen</button>
    </div>
</div>
<!-- Wijzigen -->
<div class="popup-dialog" id="wijzigen">
    <div class="popup-header">
        <h3 class="popup-title">Zwemmer Aanpassen</h3>
        <button type="button" class="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="popup-content">
        <form id="form-zwemmer" action="#" method="post">
            <div class="container">
            <table style="float:right; padding-right:20px">
                <tr>
                    <td>
                        <label for="titel-wedstrijd">Familienaam: </label> 
                    </td>
                    <td>
                        <input type="text" name="naam-zwemmer" id="naam-zwemmer" value="$zwemmers->Achternaam" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="titel-wedstrijd">Voornaam: </label> 
                    </td>
                    <td>
                        <input type="text" name="voornaam-zwemmer" id="voornaam-zwemmer" value='$zwemmers->Naam'>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="titel-wedstrijd">E-mail: </label> 
                    </td>
                    <td>
                        <input type="text" name="email-zwemmer" id="email-zwemmer" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="titel-wedstrijd">Wachtwoord: </label> 
                    </td>
                    <td>
                        <input type="text" name="wachtwoord-zwemmer" id="wachtwoord-zwemmer" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="titel-wedstrijd">Woonplaats: </label> 
                    </td>
                    <td>
                        <input type="text" name="woonplaats-zwemmer" id="woonplaats-zwemmer" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="titel-wedstrijd">Telefoonnummer: </label> 
                    </td>
                    <td>
                        <input type="text" name="telefoonnummer-zwemmer" id="telefoonnummer-zwemmer" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="titel-wedstrijd">Over jezelf: </label> 
                    </td>
                    <td>
                        <textarea rows="5" cols="17" name="omschrijving-zwemmer" id="omschrijving-zwemmer"></textarea>
                    </td>
                </tr>
            </table>
            </div>
        </form>
    </div>
    <div class="popup-footer">
        <button type="button" class="btn btn-primary" onclick="$toevoegen" style="float:right;">Toevoegen</button>
    </div>
</div>