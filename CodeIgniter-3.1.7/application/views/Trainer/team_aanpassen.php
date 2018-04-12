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


$archiveren = array('class' => 'btn btn-danger btn-xs btn-round', 'data-toggle' => 'tooltip', 'title' => 'Zwemmer archiveren');
?>
<div id="Team">
    <div style="float:right">
        <?php
        echo "<button type='button' class='btn btn-warning btn-xs btn-round' onclick='' data-toggle='modal' data-target='#toevoegen'><i class='fas fa-plus'></i></button>";
        ?>
        <br>
    </div>
    <table class="table">
        <tbody>
            <?php
            foreach ($zwemmers as $zwemmer) {
                echo "<tr>"
                . "<td>" . toonAfbeelding('Zwemmers/' . $zwemmer->foto . '.png', 'id="avatar" class="shadow img-circle"') . "</td>"
                . "<td>" . $zwemmer->voornaam . " " . $zwemmer->achternaam . "</td><td>" . $zwemmer->email . "</td>
                <td><button type='button' class='btn btn-success' id='aanpassen" . $zwemmer->id . "' onclick='' data-toggle='modal' data-target='#wijzigen' value='" . $zwemmer->id . "'>". "<i class='fas fa-pencil-alt'></i></button>"
                . anchor('Trainer/Team/archiveer/' . $zwemmer->id, form_button("knopSchrap", "<i class='fas fa-trash-alt'></i>", $archiveren)) . "</td></tr>\n";
                ;
            }
            ?>
        </tbody>
    </table>
</div>


<!-- Modal Toevoegen -->
<div class="modal fade" id="toevoegen" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-center">
                <h5 class="modal-title" id="exampleModalLongTitle">Zwemmer toevoegen</h5> <!-- Modal titel -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <!-- Modal sluit knop ( X ) -->
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body d-flex justify-content-center"> <!-- Modal inhoud -->
                <form id="form-zwemmerToevoegen" action="#" method="post">
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
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn button-blue" data-dismiss="modal">Sluiten</button> <!-- Modal sluit knop -->
            </div>
        </div>
    </div>
</div>

<?php echo haalJavascriptOp("validator.js"); ?>

<?php
$attributenFormulier = array('id' => '$zwemmer->ID',
    'data-toggle' => 'validator',
    'role' => 'form');
echo form_open('trainer/team/registreer', $attributenFormulier);
?>
<!-- Modal Wijzigen -->
<div class="modal fade" id="wijzigen" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Zwemmer wijzigen</h5> <!-- Modal titel -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <!-- Modal sluit knop ( X ) -->
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"> <!-- Modal inhoud -->
                <div class="form-group">
                    <?php
                    echo form_labelpro('Voornaam', 'voornaam');
                    echo form_input(array('name' => 'naam',
                        'id' => 'voornaam',
                        'value' => '',
                        'class' => 'form-control',
                        'placeholder' => 'Voornaam',
                        'required' => 'required'));l
                    ?>
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
                    <?php
                    echo form_labelpro('Achternaam', 'achternaam');
                    echo form_input(array('name' => 'achternaam',
                        'id' => 'achternaam',
                        'value' => '',
                        'class' => 'form-control',
                        'placeholder' => 'Achternaam',
                        'required' => 'required'));
                    ?>
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
                    <?php
                    echo form_labelpro('Email', 'email');
                    echo form_input(array('name' => 'email',
                        'id' => 'email',
                        'value' => '',
                        'class' => 'form-control',
                        'placeholder' => 'Email',
                        'required' => 'required'));
                    ?>
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
                    <?php
                    echo form_labelpro('Wachtwoord', 'wachtwoord');
                    echo form_input(array('name' => 'wachtwoord',
                        'id' => 'wachtwoord',
                        'value' => '',
                        'class' => 'form-control',
                        'placeholder' => 'Wachtwoord',
                        'required' => 'required'));
                    ?>
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
                    <?php
                    echo form_labelpro('Over jezelf', 'over jezelf');
                    echo form_input(array('name' => 'omschrijving',
                        'id' => 'omschrijving',
                        'value' => '',
                        'class' => 'form-control',
                        'placeholder' => 'Omschrijving',
                        'required' => 'required'));
                    ?>
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="modal-footer form-group">
                <button type="button" class="btn button-blue" data-dismiss="modal">Sluiten</button> <!-- Modal sluit knop -->
                <?php echo form_submit('knop', 'Wijzigen', "class='btn button-blue'") ?>
            </div>
        </div>
    </div>
</div>