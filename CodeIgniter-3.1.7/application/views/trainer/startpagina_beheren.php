<?php
// +----------------------------------------------------------
// |    Trainingscentrum Wezenberg
// +----------------------------------------------------------
// |    Auteur: Jolien Lauwers      |       Helper:
// +----------------------------------------------------------
// |
// |    Startpagina beheren view
// |
// +----------------------------------------------------------
// |    Team 14
// +----------------------------------------------------------

/**
 * @file startpagina_beheren.php
 * 
 * View waarin een lijst van huidige startpaginaitems worden weergegeven
 * - krijgt $startpaginatekst binnen
 */
$attributenFormulier = array('id' => 'form-supplement',
    'class' => 'needs-validation',
    'novalidate' => '',
    'role' => 'form');
?>

<table class="table">
    <thead>
        <tr>
            <th>Titel</th>

            <th>Inhoud</th>
            <th></th>
            <th><button type='button' class='btn btn-warning' data-toggle='modal' data-toggle='tooltip' title='Nieuws toevoegen' data-target='#startpaginaItemToevoegen'><i class='fas fa-plus'></i></button></th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($startpaginaitems as $startpaginaitem) {
            echo "<tr id='" . $startpaginaitem->id . "'><td>" . ucfirst($startpaginaitem->titel) . "</td><td>" . ucfirst($startpaginaitem->inhoud) . "</td><td>"
            . "<button type='button' class='btn btn-success' id='aanpassen" . $startpaginaitem->id . "' onclick='startpaginaItemUpdate(this.id)' value='" . $startpaginaitem->id . "' data-toggle='modal' data-target='#startpaginaItemAanpassen'><i class='fas fa-pencil-alt'></i></button></td><td>"
            . "<button type='button' class='btn btn-danger' id='verwijder" . $startpaginaitem->id . "' onclick='startpaginaItemVerwijder(this.id)' value='" . $startpaginaitem->id . "'><i class='fas fa-trash-alt'></i></button></td></tr>\n";
            ;
        }
        ?>

    </tbody>
</table>

<!-- Toevoegen -->

<div class="modal fade" id="startpaginaItemToevoegen" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Nieuws toevoegen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                echo form_open('', $attributenFormulier);
                ?>                
                <div class="form-group">
                    <?php
                    echo form_label('Titel', 'titel');
                    echo form_input(array('name' => 'titel',
                        'id' => 'titel',
                        'value' => '',
                        'class' => 'form-control',
                        'placeholder' => 'Geef een titel op.',
                        'required' => 'required'));
                    ?>
                    <div class="invalid-feedback">
                        Vul dit veld in.
                    </div>
                </div>
                <div class="form-group">
                    <?php
                    echo form_label('Inhoud', 'inhoud');
                    echo form_input(array('name' => 'inhoud',
                        'id' => 'inhoud',
                        'value' => '',
                        'class' => 'form-control',
                        'placeholder' => 'Schrijf hier de inhoud.',
                        'required' => 'required'));
                    ?>
                    <div class="invalid-feedback">
                        Vul dit veld in.
                    </div>
                </div>

                <?php echo form_close(); ?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn button-primary" data-dismiss="modal">Annuleren</button>
                <button type="button" class="btn button-blue" onclick="startpaginaItemOpslaan('toevoegen')">Opslaan</button>
            </div>
        </div>
    </div>
</div>

<!-- Aanpassen -->

<div class="modal fade" id="startpaginaItemAanpassen" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Nieuws aanpassen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                echo form_open('', $attributenFormulier);
                ?>
                <div class="form-group">
                    <?php
                    echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => ''));
                    ?>
                </div>
                <div class="form-group">
                    <?php
                    echo form_label('Titel', 'titel');
                    echo form_input(array('name' => 'titel',
                        'id' => 'titel',
                        'value' => '',
                        'class' => 'form-control',
                        'placeholder' => 'Geef een titel op.',
                        'required' => 'required'));
                    ?>
                    <div class="invalid-feedback">
                        Vul dit veld in.
                    </div>
                </div>
                <div class="form-group">
                    <?php
                    echo form_label('Inhoud', 'inhoud');
                    echo form_input(array('name' => 'inhoud',
                        'id' => 'inhoud',
                        'value' => '',
                        'class' => 'form-control',
                        'placeholder' => 'Schrijf hier de inhoud.',
                        'required' => 'required'));
                    ?>
                    <div class="invalid-feedback">
                        Vul dit veld in.
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn button-primary" data-dismiss="modal">Annuleren</button>
                <button type="button" class="btn button-blue" onclick="startpaginaItemOpslaan('aanpassen')">Opslaan</button>
            </div>
        </div>
    </div>
</div>

<script>

    // startpaginaItem start

    function meldingUpdate(meldingID) {

        console.log("id =" + meldingID);
        var id = $("#" + meldingID).val();

        $.post(site_url + '/Trainer/melding/wijzigMelding/' + id, function (data) {
            //data = object van melding
            data = JSON.parse(data);

            //modal opvullen met object melding
            opvullenModalMeldingAanpassen(data);

        }).fail(function () {
            alert("Er is iets misgelopen, neem contact op met de administrator.");
        });


        // modal openen met ingevulde gegevans van dit object
        $("#meldingAanpassen").modal();

    }
    function opvullenModalMeldingAanpassen(dataMelding) {
        $('#meldingAanpassen #id').attr("value", dataMelding["id"]);
        $('#meldingAanpassen #datumStop').val(dataMelding["datumStop"]);
        $('#meldingAanpassen #inhoud').attr("value", dataMelding["meldingBericht"]);
        $('#meldingAanpassen #aan').attr("value", dataMelding["voornaam"]);

        console.log(dataMelding["voornaam"]);
        $("#aan option").each(function ()
        {
            console.log($(this).val());

            if ($(this).text() === dataMelding["voornaam"]) {
                $("option[value=" + $(this).val() + "]").attr("selected", "selected");
            }
        });
    }
    function meldingVerwijder(elementID) {
        if (!confirm("Zeker dat je dit wilt verwijderen?")) {
            return false;
        } else {
            //id van melding
            var id = $("#" + elementID).val();
            // alert(id);
            //verwijderen
            $.post(site_url + '/Trainer/melding/verwijderMelding/' + id, function (data) {
                alert("Melding is verwijderd!");
                $("tr#" + id).remove();
            }).fail(function () {
                alert("Er is iets misgelopen, neem contact op met de administrator.");
            });
        }
    }

    function meldingOpslaan(actie) {

        var ok = true;
        var formToSubmit = '';
        //form valideren
        if (actie == "toevoegen") {
            $('#meldingToevoegen #form-melding *').filter('input').each(function () {
                if ($(this).attr("required") && $(this).val() == "") {
                    alert("Niet alle velden zijn ingevuld");
                    ok = false;
                    return false;
                }
            });
            formToSubmit = "#meldingToevoegen #form-melding";
        } else {
            $('#meldingAanpassen #form-melding *').filter('input').each(function () {
                if ($(this).attr("required") && $(this).val() == "") {
                    alert("Niet alle velden zijn ingevuld");
                    ok = false;
                    return false;
                }
            });
            formToSubmit = "#meldingAanpassen #form-melding";
        }

        //word uitgevoerd als alles ingevuld is
        if (ok) {
            $(formToSubmit).attr('action', site_url + '/Trainer/melding/opslaanMelding/' + actie);

            $(formToSubmit).submit();
        }
    }

// startpaginaItem end


</script>

