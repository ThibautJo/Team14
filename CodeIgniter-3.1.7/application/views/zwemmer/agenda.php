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

<div class="modal fade" id="openenActiviteit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                    allDayText: 'Suppl.',
                    height: 'parent', // Hoogte zelfde als zijn parent
                    minTime: "06:00:00", // Begintijd kalender
                    // EventClick functie zorgt ervoor dat je het event kan aanklikken en meer informatie kan bekijken in het modal dat opent
                    eventClick: function(calEvent) {
                        $('#openenActiviteit').modal('show');
                        if (calEvent.description !== '') {
                            $('.modal-body').html('<p class="font-weight-bold">' + calEvent.title + '</p>' + '<p>' + calEvent.description + '</p>');
                        }
                        else {
                            $('.modal-body').html('<p>' + calEvent.title + '</p>');
                        }
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
                        $('#openenActiviteit').modal('show');
                        if (calEvent.description !== '') {
                            $('.modal-body').html('<p class="font-weight-bold">' + calEvent.title + '</p>' + '<p>' + calEvent.description + '</p>');
                        }
                        else {
                            $('.modal-body').html('<p>' + calEvent.title + '</p>');
                        }
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
                        $('#openenActiviteit').modal('show');
                        if (calEvent.description !== '') {
                            $('.modal-body').html('<p class="font-weight-bold">' + calEvent.title + '</p>' + '<p>' + calEvent.description + '</p>');
                        }
                        else {
                            $('.modal-body').html('<p>' + calEvent.title + '</p>');
                        }
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
        }
    });
</script>