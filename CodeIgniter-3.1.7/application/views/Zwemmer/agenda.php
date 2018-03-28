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

<div id="agenda">

</div>

<!-- Modal voor event waar men op klikt -->

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
        

        // Breedte van het scherm opslaan in een variabele
        var width = $(window).width();

        // Filteren op schermbreedte (d.m.v. switch)
        switch (true) {

            // Bij groot scherm volledige agenda
            case (width > 992):
                $('#agenda').fullCalendar({
                    defaultView: 'agendaWeek', // Week agenda
                    titleFormat: 'D MMMM YYYY', // Titel van agenda [1 - 7 januari 0000]
                    height: 'parent', // Hoogte zelfde als zijn parent
                    minTime: "06:00:00", // Begintijd kalender
                    // EventClick functie zorgt ervoor dat je het event kan aanklikken en meer informatie kan bekijken in het modal dat opent
                    eventClick: function(calEvent) { 
                        $('#exampleModalCenter').modal('show'); // Modal openen
                        $('.modal-body').html(calEvent.title); // Modal inhoud opvullen
                        switch (calEvent.color) { // Filteren op kleur van het event
                            case '#FF7534':
                                $('.modal-title').html('Wedstrijd'); // Modal titel opvullen
                                break;
                            case '#BB9BFF':
                                $('.modal-title').html('Medisch onderzoek');
                                break;
                            case '#B5DD6C':
                            case '#7CD246':
                            case '#0FA865':
                            case '#93E2C1':
                                $('.modal-title').html('Training');
                                break;
                            case '#A0C7E8':
                                $('.modal-title').html('Stage');
                                break;
                            case '#E5343D':
                                $('.modal-title').html('Supplement');
                                $('.modal-body').html('<b>' + calEvent.title + '</b>');
                                $('.modal-body').append(', ' + calEvent.description);
                                break;
                        }
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
                    height: 'parent',
                    minTime: "06:00:00",
                    eventClick: function(calEvent) {
                        $('#exampleModalCenter').modal('show');
                        $('.modal-body').html(calEvent.title);
                        switch (calEvent.color) {
                            case '#FF7534':
                                $('.modal-title').html('Wedstrijd');
                                break;
                            case '#BB9BFF':
                                $('.modal-title').html('Medisch onderzoek');
                                break;
                            case '#B5DD6C':
                            case '#7CD246':
                            case '#0FA865':
                            case '#93E2C1':
                                $('.modal-title').html('Training');
                                break;
                            case '#A0C7E8':
                                $('.modal-title').html('Stage');
                                break;
                            case '#E5343D':
                                $('.modal-title').html('Supplement');
                                $('.modal-body').html('<b>' + calEvent.title + '</b>');
                                $('.modal-body').append(', ' + calEvent.description);
                                break;
                        }
                    },
                    events: <?php echo $activiteiten?>
                });
                break;
            
            // Bij klein scherm dag agenda
            case (width < 576):
                $('#agenda').fullCalendar({
                    defaultView: 'agendaDay', // Dag agenda
                    titleFormat: 'D MMMM YYYY',
                    height: 'auto', // Geen scrollbar bij hoogte
                    minTime: "06:00:00",
                    eventClick: function(calEvent) {
                        $('#exampleModalCenter').modal('show');
                        $('.modal-body').html(calEvent.title);
                        switch (calEvent.color) {
                            case '#FF7534':
                                $('.modal-title').html('Wedstrijd');
                                break;
                            case '#BB9BFF':
                                $('.modal-title').html('Medisch onderzoek');
                                break;
                            case '#B5DD6C':
                            case '#7CD246':
                            case '#0FA865':
                            case '#93E2C1':
                                $('.modal-title').html('Training');
                                break;
                            case '#A0C7E8':
                                $('.modal-title').html('Stage');
                                break;
                            case '#E5343D':
                                $('.modal-title').html('Supplement');
                                $('.modal-body').html('<b>' + calEvent.title + '</b>');
                                $('.modal-body').append(', ' + calEvent.description);
                                break;
                        }
                    },
                    events: <?php echo $activiteiten?>
                });
                break;
        }
    });
</script>
<?php



