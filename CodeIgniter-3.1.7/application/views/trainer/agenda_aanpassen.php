<?php
// +----------------------------------------------------------
// |    Trainingscentrum Wezenberg
// +----------------------------------------------------------
// |    Auteur: Tom Nuyts       |       Helper:
// +----------------------------------------------------------
// |
// |    Agenda view
// |
// +----------------------------------------------------------
// |    Team 14
// +----------------------------------------------------------
?>

<!-- laden scripts en stylesheet agenda -->

<link rel="stylesheet" href="<?php echo base_url() ?>assets/scripts/fullcalendar/fullcalendar.min.css" />
<script src="<?php echo base_url() ?>assets/scripts/fullcalendar/lib/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/scripts/fullcalendar/fullcalendar.min.js"></script>
<script src="<?php echo base_url() ?>assets/scripts/fullcalendar/gcal.js"></script>



<!-- Laat de agenda zien -->

<div class="d-flex row">
    <div id="agenda" class="col-12 col-sm-8 col-md-9 col-xl-10 order-1 order-sm-0">

    </div>

    <div class="col-12 col-sm-4 col-md-3 col-xl-2 order-0 order-sm-1 mb-4">
        <p class="font-weight-bold header-list-group pt-1">Agenda van:</p>
        <div class="list-group">
            <?php
            foreach ($listGroupItems as $listGroupItem) {
                echo $listGroupItem;
            }
            ?>
        </div>
        <p class="mt-4 d-flex justify-content-between">
            <button type="button" class="btn btn-warning" data-toggle="modal" data-toggle="tooltip" title="Activiteit toevoegen" data-target="#activiteitToevoegen"><i class="fas fa-plus"></i></button>
            <button type="button" class="btn btn-success" data-toggle="modal" data-toggle="tooltip" title="Activiteit wijzigen" data-target="#activiteitWijzigen"><i class="fas fa-pencil-alt"></i></button>
            <button type="button" class="btn btn-danger" data-toggle="modal" data-toggle="tooltip" title="Activiteit verwijderen" data-target="#activiteitVerwijderen"><i class="fas fa-trash-alt"></i></button>
            <p><?php echo divAnchor("/Trainer/Agenda/index/" . $_GET['persoonId'] . "?persoonId=" . $_GET['persoonId'], 'Weergaven', 'class="btn button-blue d-flex justify-content-center"') ?></p>
        </p>
    </div>
</div>

<!-- Modal voor event waar men op klikt -->

<div class="modal fade" id="aanpassenActiviteit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"></h5> <!-- Modal titel -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <!-- Modal sluit knop ( X ) -->
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"> <!-- Modal inhoud -->
                <?php
                $attributenFormulier = array('id' => 'aanpassenFormulier',
                                                'class' => 'needs-validation',
                                                'novalidate' => '',
                                                'role' => 'form');
                echo form_open('Trainer/Agenda/registreerActiviteit', $attributenFormulier);
                
                $uren = array('06:00', '06:30', '07:00', '07:30', '08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30', '20:00', '20:30', '21:00', '21:30', '22:00', '22:30', '23:00', '23:30', '24:00');
                $persoon = $_GET['persoonId'];
                ?>
                
                <?php echo form_hidden('id', ''); ?>
                
                <?php echo form_hidden('persoon', $persoon); ?>

                <div id="titel-form" class="d-none">
                    <div class="form-group">
                        <?php
                        echo form_label('Gebeurtenisnaam', 'gebeurtenisnaam');
                        echo form_input(array('name' => 'gebeurtenisnaam',
                            'id' => 'gebeurtenisnaam',
                            'value' => '', 
                            'class' => 'form-control',
                            'placeholder' => 'Gebeurtenisnaam', 
                            'required' => 'required'));
                        ?>
                        <div class="invalid-feedback">
                            Vul dit veld in.
                        </div>
                    </div>
                </div>

                <div id="training-form" class="d-none">
                    <div class="form-group">
                        <?php
                        echo form_label('Soort training', 'soort');
                        echo form_dropdown('soort', $soortTraining, '', 'id="soort" class="form-control"');
                        ?>
                        <div class="invalid-feedback">
                            Maak een keuze uit de lijst.
                        </div>
                    </div>
                </div>
                
                <div id="wedstrijd-form" class="d-none">
                    <div class="form-group">
                        <?php
                        echo form_label('Plaats', 'plaats');
                        echo form_input(array('name' => 'plaats',
                            'id' => 'plaats',
                            'value' => '', 
                            'class' => 'form-control',
                            'placeholder' => 'Plaats', 
                            'required' => 'required'));
                        ?>
                        <div class="invalid-feedback">
                            Vul dit veld in.
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <?php
                        echo form_label('Programma (link)', 'programma');
                        echo form_input(array('name' => 'programma',
                            'id' => 'programma',
                            'value' => '', 
                            'class' => 'form-control',
                            'placeholder' => 'http://www.programma.be', 
                            'required' => 'required'));
                        ?>
                        <div class="invalid-feedback">
                            Vul dit veld in.
                        </div>
                    </div>
                </div>
                
                <div id="tijdstip-form" class="d-none">
                    <div class="row begindatum">
                        <div id="container-begindatum" class="form-group col-8">
                            <?php
                            echo form_label('Begindatum', 'begindatum');
                            echo form_input(array('name' => 'begindatum',
                                'id' => 'begindatum', 
                                'value' => '',
                                'class' => 'form-control datepicker2',
                                'required' => 'required',
                                'data-provide' => 'datepicker',
                                'data-date-format' => 'dd/mm/yyyy',
                                'data-date-language' => 'nl-BE'));
                            ?>
                            <div class="invalid-feedback">
                                Kies een datum.
                            </div>
                        </div>

                        <div class="form-group col-4">
                            <?php
                            echo form_label('Beginuur', 'beginuur');
                            
                            echo form_dropdown('beginuur', $uren, '', 'id="beginuur" class="form-control"');
                            ?>
                            <div class="invalid-feedback">
                                Kies een uur.
                            </div>
                        </div>
                    </div>

                    <div class="row einddatum">
                        <div id="container-einddatum" class="form-group col-8">
                            <?php
                            echo form_label('Einddatum', 'einddatum');
                            echo form_input(array('name' => 'einddatum',
                                'id' => 'einddatum', 
                                'value' => '',
                                'class' => 'form-control datepicker2',
                                'required' => 'required',
                                'data-provide' => 'datepicker',
                                'data-date-format' => 'dd/mm/yyyy',
                                'data-date-language' => 'nl-BE'));
                            ?>
                            <div class="invalid-feedback">
                                Kies een datum.
                            </div>
                        </div>

                        <div class="form-group col-4">
                            <?php
                            echo form_label('Einduur', 'einduur');
                            echo form_dropdown('einduur', $uren, '', 'id="einduur" class="form-control"');
                            ?>
                            <div class="invalid-feedback">
                                Kies een uur.
                            </div>
                        </div>
                    </div>
                </div>
                
                <div id="supplement-form" class="d-none">
                    <div class="form-group">
                        <?php
                        echo form_label('Supplementnaam', 'supplementnaam');
                        echo form_dropdown('supplementnaam', $supplementennamen, '', 'id="supplementnaam" class="form-control"');
                        ?>
                        <div class="invalid-feedback">
                            Maak een keuze uit de lijst.
                        </div>
                    </div>
                                        
                    <div class="form-group">
                        <?php
                        echo form_label('Datum', 'datum');
                        echo form_input(array('name' => 'datum',
                            'id' => 'datum', 
                            'value' => '',
                            'class' => 'form-control datepicker2',
                                'required' => 'required',
                                'data-provide' => 'datepicker',
                                'data-date-format' => 'dd/mm/yyyy',
                                'data-date-language' => 'nl-BE'));
                        ?>
                        <div class="invalid-feedback">
                            Kies een datum.
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <?php
                    echo form_label('Extra opmerkingen', 'opmerking');
                    
                    echo form_textarea(array('name' => 'opmerking',
                        'id' => 'opmerking',
                        'value' => '', 
                        'class' => 'form-control',
                        'placeholder' => 'opmerking', 
                        'rows' => '3'));
                    ?>
                </div>
                
                <div class="form-group">
                    <?php
                    echo form_label('Toevoegen voor', 'personen');
                    echo form_dropdown('personen', $voorPersonen, '', 'id="personen" class="form-control"');
                    ?>
                    <div class="invalid-feedback">
                        Maak een keuze uit de lijst.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Annuleren</button>
                <?php
                echo form_submit('ok', 'Opslaan', 'class="btn button-blue"');
                echo form_close();
                ?> <!-- Modal sluit knop -->
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="toevoegenActiviteit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"></h5> <!-- Modal titel -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <!-- Modal sluit knop ( X ) -->
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"> <!-- Modal inhoud -->
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn button-blue" data-dismiss="modal">Sluiten</button> <!-- Modal sluit knop -->
            </div>
        </div>
    </div>
</div>

<!-- Eigen scripts -->

<!-- Script om agenda in het nederlands te zetten -->

<script src='<?php echo base_url() ?>assets/scripts/fullcalendar/locale/nl.js'></script>

<!-- Script om agenda aan te passen -->

<script type="text/javascript">
    $(document).ready(function () {
        $('.datepicker2').datepicker({
            autoclose: true,
            orientation: 'auto'
        });
        
        // Breedte van het scherm opslaan in een variabele
        var width = $(window).width();

        // Filteren op schermbreedte (d.m.v. switch)
        switch (true) {

            // Bij groot scherm volledige agenda
            case (width > 992):
                $('#agenda').fullCalendar({
                    defaultView: 'agendaWeek', // Week agenda
                    titleFormat: 'D MMMM YYYY', // Titel van agenda [1 - 7 januari 0000]
                    allDaySlot: true,
                    allDayText: 'Suppl.',
                    height: 'parent', // Hoogte zelfde als zijn parent
                    minTime: "06:00:00", // Begintijd kalender
                    // EventClick functie zorgt ervoor dat je het event kan aanklikken en meer informatie kan bekijken in het modal dat opent
                    eventClick: function(calEvent) {
                        var kleuren = <?php echo $kleuren ?>;
                        $.each(kleuren, function(index) {
                            if (calEvent.color == kleuren[index].kleur) {
                                $('.modal-title').html(kleuren[index].activiteit + ' aanpassen');
                                var site_url = '<?php echo site_url(); ?>';
                                aanpassenActiviteit(kleuren[index].activiteit, calEvent.extra, $('input[name=persoon]').val(), site_url);
                                console.log('ok');
                            }
                        });
                    },
                    selectable: true,
                    select: function(startDate, endDate) {
                        $('#toevoegenActiviteit').modal('show');
//                        $('.modal-title').html('Activiteit toevoegen');
//                        $('.modal-body').html('');
                    },
                    events: <?php echo $activiteiten?>
                });
                break;
            
            // Bij middelmatig scherm 3-dagen agenda
            case (width < 992) && (width > 576):
                $('#agenda').fullCalendar({
                    defaultView: 'agendaThreeDay', // 3-dagen agenda
                    views: {
                        agendaThreeDay: {
                            type: 'agenda',
                            duration: {days: 3}
                        }
                    },
                    titleFormat: 'D MMMM YYYY',
                    allDayText: 'Suppl.',
                    height: 'parent',
                    minTime: "06:00:00",
                    eventClick: function(calEvent) {
                        $('#aanpassenActiviteit').modal('show');
                        $('.modal-body').html(calEvent.title);
                        var kleuren = <?php echo $kleuren ?>;
                        $.each(kleuren, function(index) {
                            if (calEvent.color === kleuren[index].kleur) {
                                $('.modal-title').html(kleuren[index].activiteit);
                            }
                        });
                    },
                    events: <?php echo $activiteiten?>
                });
                break;
            
            // Bij klein scherm dag agenda
            case (width < 576):
                $('#agenda').fullCalendar({
                    defaultView: 'agendaDay', // Dag agenda
                    titleFormat: 'D/M/Y',
                    allDayText: 'Suppl.',
                    height: 'auto', // Geen scrollbar bij hoogte
                    minTime: "06:00:00",
                    eventClick: function(calEvent) {
                        $('#aanpassenActiviteit').modal('show');
                        $('.modal-body').html(calEvent.title);
                        var kleuren = <?php echo $kleuren ?>;
                        $.each(kleuren, function(index) {
                            if (calEvent.color === kleuren[index].kleur) {
                                $('.modal-title').html(kleuren[index].activiteit);
                            }
                        });
                    },
                    events: <?php echo $activiteiten ?>
                });
                break;
        };
    });
</script>