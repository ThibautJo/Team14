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
 * View waarin een lijst van huidige startpaginaitems worden weergegeven.
 * - krijgt $startpaginaitems binnen
 */

$attributenFormulier = array('id' => 'form-startpaginaitem',
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

    function startpaginaItemUpdate(startpaginaItemID) {

        console.log("id =" + startpaginaItemID);
        var id = $("#" + startpaginaItemID).val();

        $.post(site_url + '/Trainer/startpagina/wijzigStartpaginaItem/' + id, function (data) {
            // data = object van startpaginaItem
            data = JSON.parse(data);

            // Vult modal op met object startpaginaItem.
            opvullenModalstartpaginaItemAanpassen(data);

        }).fail(function () {
            alert("Er is iets misgelopen, neem contact op met de administrator.");
        });

        // Opent modal met ingevulde gegevans van dit object.
        $("#startpaginaItemAanpassen").modal();

    }
    function opvullenModalstartpaginaItemAanpassen(dataStartpaginaItem) {
        
        // Vult velden van modal in wanneer startpaginaItem geselecteerd wordt om aan te passen.
        
        console.log(dataStartpaginaItem);
        console.log(dataStartpaginaItem["id"]);
        
        $('#startpaginaItemAanpassen #id').attr("value", dataStartpaginaItem["id"]);
        $('#startpaginaItemAanpassen #titel').val(dataStartpaginaItem["titel"]);
        $('#startpaginaItemAanpassen #inhoud').attr("value", dataStartpaginaItem["inhoud"]);

    }

    function startpaginaItemVerwijder(startpaginaItemID) {
        
        if (!confirm("Weet je zeker dat je dit wilt verwijderen?")) {
            return false;
        } else {
            
            // Id van het geselecteerde startpaginaItem wordt verwijderd.
            var id = $("#" + startpaginaItemID).val();
            $.post(site_url + '/Trainer/startpagina/verwijderStartpaginaItem/' + id, function (data) {
                alert("Dit nieuwtje is verwijderd!");
                $("tr#" + id).remove();
            }).fail(function () {
                alert("Er is iets misgelopen, neem contact op met de administrator.");
            });
        }
    }

    function startpaginaItemOpslaan(actie) {

        var ok = true;
        var formToSubmit = '';
        
        // Form valideren.        
        if (actie === "toevoegen") {
            formToSubmit = "#startpaginaItemToevoegen #form-startpaginaitem";
            if (!form_validatie(formToSubmit)) {
                ok = false;
                return false;
            }
        } else {
            formToSubmit = "#startpaginaItemAanpassen #form-startpaginaitem";
            if (!form_validatie(formToSubmit)) {
                ok = false;
                return false;
            }
        }

        // Wanneer alle velden ingevuld zijn, wordt dit uitgevoerd.
        if (ok) {
            $(formToSubmit).attr('action', site_url + '/Trainer/startpagina/opslaanStartpaginaItem/' + actie);

            $(formToSubmit).submit();
        }
    }


    // startpaginaItem end

</script>

