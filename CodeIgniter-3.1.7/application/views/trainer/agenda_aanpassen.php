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

<div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Hulp agenda beheren</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php echo toonAfbeelding("singlepageoverlay.jpg", 'style="width: 100%"') ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn button-blue" data-dismiss="modal">Sluiten</button>
      </div>
    </div>
  </div>
</div>

<!-- Laat de agenda zien -->

<div class="d-flex row" id="container-agenda">
  <div id="agenda" class="col-12 col-sm-8 col-md-9 col-xl-10 order-1 order-sm-0">

<<<<<<< HEAD
  </div>
=======
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
            <button type="button" class="btn btn-success" data-toggle="modal" data-toggle="tooltip" title="Activiteit wijzigen" data-target="#aanpassenActiviteit"><i class="fas fa-pencil-alt"></i></button>
            <button type="button" class="btn btn-danger" data-toggle="modal" data-toggle="tooltip" title="Activiteit verwijderen" data-target="#activiteitVerwijderen"><i class="fas fa-trash-alt"></i></button>
>>>>>>> 9024b48892408cba746d8940a006567c7787eb1e

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

      <p><div><a class="btn btn-light d-flex justify-content-center text-dark" id="help" data-toggle="modal" data-target="#helpModal"><i class="material-icons">help</i> &nbsp;Hulp</a></div></p>
    </p>
  </div>
</div>

<!-- Modal voor event waar men op klikt -->

<div class="modal fade" id="aanpassenActiviteit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<<<<<<< HEAD
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
        ?>

        <?php echo form_hidden('id', ''); ?>

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
          </div>
        </div>

        <div id="training-form" class="d-none">
          <div class="form-group">
            <?php
            echo form_label('Soort training', 'soort');
            echo form_dropdown('soort', $soortTraining, '', 'id="soort" class="form-control"');
            ?>
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
          </div>
        </div>

        <div id="supplement-form" class="d-none">
          <div class="form-group">
            <?php
            echo form_label('Supplementnaam', 'supplementnaam');
            echo form_dropdown('supplementnaam', $supplementennamen, '', 'id="supplementnaam" class="form-control"');
            ?>
          </div>

          <div class="form-group">
            <?php
            echo form_label('Hoeveelheid', 'hoeveelheid');
            echo form_input(array('name' => 'hoeveelheid',
            'id' => 'hoeveelheid',
            'value' => '',
            'class' => 'form-control',
            'placeholder' => 'bv. 2',
            'type' => 'number',
            'required' => 'required'));
            ?>
          </div>
        </div>

        <div id="opmerking-form" class="form-group d-none">
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
=======
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
                ?>
                
                <?php echo form_hidden('id', ''); ?>
                <?php echo form_hidden('reeksId', ''); ?>

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
                    </div>
                </div>
>>>>>>> 9024b48892408cba746d8940a006567c7787eb1e

        <div id="personen-form" class="form-group d-none">
          <?php
          echo form_label('Toevoegen voor', 'personen');
          echo '<div class="rounded border border-grey p-2">';
          foreach ($voorPersonen as $persoon) {
            echo '<div class="m-2" >';
            echo form_checkbox('personen[]', array_search($persoon, $voorPersonen), false, 'id="' . array_search($persoon, $voorPersonen) . '"');
            echo $persoon;
            echo '</div>';
          }
          echo '</div>';
          ?>
        </div>

        <ul class="nav nav-tabs mt-4 mb-4 d-none" id="tabDatum" role="tablist">
          <li class="nav-item">
            <a class="nav-link active pr-4 pl-4" id="dag-tab" data-toggle="tab" href="#dag" role="tab" aria-controls="home" aria-selected="true">Enkele dag</a>
          </li>
          <li class="nav-item">
            <a class="nav-link pr-4 pl-4" id="reeks-tab" data-toggle="tab" href="#reeks" role="tab" aria-controls="profile" aria-selected="false">Reeks</a>
          </li>
        </ul>
        <div class="tab-content mt-2" id="tabDatumContent">
          <div class="tab-pane fade show active" id="dag" role="tabpanel" aria-labelledby="dag-tab">
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
                </div>

                <div class="form-group col-4">
                  <?php
                  echo form_label('Beginuur', 'beginuur');

                  echo form_dropdown('beginuur', $uren, '', 'id="beginuur" class="form-control"');
                  ?>
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
                </div>

                <div class="form-group col-4">
                  <?php
                  echo form_label('Einduur', 'einduur');
                  echo form_dropdown('einduur', $uren, '', 'id="einduur" class="form-control"');
                  ?>
                </div>
              </div>
            </div>

            <div class="form-group supplementDatum d-none">
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
            </div>
          </div>
          <div class="tab-pane fade" id="reeks" role="tabpanel" aria-labelledby="reeks-tab">
            <div id="tijdstipReeks-form" class="d-none">
              <p id="" class="d-flex align-items-center">Elke&nbsp; <b class="dagReeks"></b> &nbsp;voor de volgende tijdspanne:</p>
              <div class="row begindatum">
                <div id="container-begindatum" class="form-group col-8">
                  <?php
                  echo form_label('Begindatum', 'begindatumReeks');
                  echo form_input(array('name' => 'begindatumReeks',
                  'id' => 'begindatumReeks',
                  'value' => '',
                  'class' => 'form-control datepicker2',
                  'required' => 'required',
                  'data-provide' => 'datepicker',
                  'data-date-format' => 'dd/mm/yyyy',
                  'data-date-language' => 'nl-BE'));
                  ?>
                </div>

                <div class="form-group col-4">
                  <?php
                  echo form_label('Beginuur', 'beginuurReeks');

                  echo form_dropdown('beginuurReeks', $uren, '', 'id="beginuurReeks" class="form-control"');
                  ?>
                </div>
              </div>

              <div class="row einddatum">
                <div id="container-einddatum" class="form-group col-8">
                  <?php
                  echo form_label('Einddatum', 'einddatumReeks');
                  echo form_input(array('name' => 'einddatumReeks',
                  'id' => 'einddatumReeks',
                  'value' => '',
                  'class' => 'form-control datepicker2',
                  'required' => 'required',
                  'data-provide' => 'datepicker',
                  'data-date-format' => 'dd/mm/yyyy',
                  'data-date-language' => 'nl-BE'));
                  ?>
                </div>

                <div class="form-group col-4">
                  <?php
                  echo form_label('Einduur', 'einduurReeks');
                  echo form_dropdown('einduurReeks', $uren, '', 'id="einduurReeks" class="form-control"');
                  ?>
                </div>
              </div>
            </div>
<<<<<<< HEAD

            <div class="form-group supplementDatum d-none">
              <p class="d-flex align-items-center">Elke&nbsp; <b class="dagReeks"></b> &nbsp;voor de volgende tijdspanne:</p>
              <div class="row">
                <div id="container-begindatum" class="form-group col-6">
                  <?php
                  echo form_label('Begindatum', 'begindatumSupplement');
                  echo form_input(array('name' => 'begindatumSupplement',
                  'id' => 'datum',
                  'value' => '',
                  'class' => 'form-control datepicker2',
                  'required' => 'required',
                  'data-provide' => 'datepicker',
                  'data-date-format' => 'dd/mm/yyyy',
                  'data-date-language' => 'nl-BE'));
                  ?>
                </div>

                <div id="container-einddatum" class="form-group col-6">
                  <?php
                  echo form_label('Einddatum', 'einddatumSupplement');
                  echo form_input(array('name' => 'einddatumSupplement',
                  'id' => 'einddatumSupplement',
                  'value' => '',
                  'class' => 'form-control datepicker2',
                  'required' => 'required',
                  'data-provide' => 'datepicker',
                  'data-date-format' => 'dd/mm/yyyy',
                  'data-date-language' => 'nl-BE'));
                  ?>
                </div>
              </div>
=======
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" id="deleteActiviteitButton" class="btn btn-danger" data-toggle="modal" data-toggle="tooltip" title="Activiteit verwijderen" onclick=""><i class="fas fa-trash-alt"></i></button>
                <div>
                    <button type="button" class="btn" data-dismiss="modal">Annuleren</button>
                <?php
                    echo form_submit('ok', 'Opslaan', 'class="btn button-blue"');
                echo '</div>';
                echo form_close();
                ?> <!-- Modal sluit knop -->
>>>>>>> 9024b48892408cba746d8940a006567c7787eb1e
            </div>
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
<<<<<<< HEAD
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
=======
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Kies de activiteit die u wilt toevoegen, uit onderstaande lijst.
                
                <?php
                $activiteitenKeuzeJSONParse = json_decode($kleuren);
                $activiteitenKeuze = [];
                
                foreach ($activiteitenKeuzeJSONParse as $activiteitKeuzeJSONParse) {
                    if (strpos($activiteitKeuzeJSONParse->activiteit, 'training') !== false) {
                        if (!in_array('Training', $activiteitenKeuze)) {
                            $activiteitenKeuze[] = 'Training';
                        }
                    }
                    else {
                        $activiteitenKeuze[] = $activiteitKeuzeJSONParse->activiteit;
                    }
                }
                echo form_dropdown('activiteitToevoegen', $activiteitenKeuze, '', 'id="activiteitToevoegen" class="form-control mt-3"');
                
                echo form_hidden('startDate', '', 'id="startDate"');
                echo form_hidden('endDate', '', 'id="endDate"');
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Annuleren</button>
                <button type="button" class="btn button-blue" data-dismiss="modal" id="gaDoorToevoegen">Ga door</button>
            </div>
        </div>
>>>>>>> 9024b48892408cba746d8940a006567c7787eb1e
    </div>
  </div>
</div>

<!-- Eigen scripts -->

<!-- Script om agenda in het nederlands te zetten -->

<script src='<?php echo base_url() ?>assets/scripts/fullcalendar/locale/nl.js'></script>

<!-- Script om agenda aan te passen -->

<script type="text/javascript">
<<<<<<< HEAD
$('#tabDatum a').on('click', function (e) {
  e.preventDefault();

  if ($(this).hasClass('disabled')) {
    $(this).tab('hide');
  }
  else {
    $(this).tab('show');
  }

});

$('.runFunction').on('click', function agendaInladen() {
  var persoonId = 0;
  persoonId = $(this).data('id');
  $('.runFunction').removeClass('active');
  $(this).addClass('active');
  $('#agenda').fullCalendar('removeEvents');

  // Breedte van het scherm opslaan in een variabele
  var width = $(window).width();

  $.ajax({
    method: "POST",
    url: site_url + "/Trainer/Agenda/ladenAgendaPersoon",
    data: {persoonId: persoonId},
    dataType: "json",
    success: function (result) {
      $('#agenda').fullCalendar('addEventSource', result);

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
            var weekdag = ["Zondag","Maandag","Dinsdag","Woensdag","Donderdag","Vrijdag","Zaterdag"];
            var datumGeklikt = new Date(calEvent.start);
            var dagnaam = datumGeklikt.getDay();
            var day = datumGeklikt.getDate();
            var month = datumGeklikt.getMonth() + 1;
            var year = datumGeklikt.getFullYear();
            $.each(kleuren, function(index) {
              if (calEvent.color == kleuren[index].kleur) {
                $('.modal-title').html(kleuren[index].activiteit + ' aanpassen');
                $('.dagReeks').html(weekdag[dagnaam]);

                var site_url = '<?php echo site_url(); ?>';
                aanpassenActiviteit(kleuren[index].activiteit, calEvent.extra, site_url);
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
          events: result
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
=======
    $('#gaDoorToevoegen').on('click', function() {
//        $('#toevoegenActiviteit').modal('hide');
        setTimeout(function() {
            toevoegenActiviteit();
        }, 350);
    });
    
    $('#tabDatum a').on('click', function (e) {
        e.preventDefault();

        if ($(this).hasClass('disabled')) {
            $(this).tab('hide');
        }
        else {
            $(this).tab('show');
        }
        
    });
    
    $('.runFunction').on('click', function agendaInladen() {
        var persoonId = 0;
        persoonId = $(this).data('id');
        $('.runFunction').removeClass('active');
        $(this).addClass('active');
        $('#agenda').fullCalendar('removeEvents');

        // Breedte van het scherm opslaan in een variabele
        var width = $(window).width();
        
        $.ajax({
            method: "POST",
            url: site_url + "/Trainer/Agenda/ladenAgendaPersoon",
            data: {persoonId: persoonId},
            dataType: "json",
            success: function (result) {
                $('#agenda').fullCalendar('addEventSource', result);
                
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
                                var weekdag = ["Zondag","Maandag","Dinsdag","Woensdag","Donderdag","Vrijdag","Zaterdag"];
                                var datumGeklikt = new Date(calEvent.start);
                                var dagnaam = datumGeklikt.getDay();
//                                var day = datumGeklikt.getDate();
//                                var month = datumGeklikt.getMonth() + 1;
//                                var year = datumGeklikt.getFullYear();
                                $.each(kleuren, function(index) {
                                    if (calEvent.color == kleuren[index].kleur) {
                                        $('.modal-title').html(kleuren[index].activiteit + ' aanpassen');
                                        $('.dagReeks').html(weekdag[dagnaam]);
                                        
                                        var site_url = '<?php echo site_url(); ?>';
                                        aanpassenActiviteit(kleuren[index].activiteit, calEvent.extra, site_url);
                                        console.log('ok');
                                    }
                                });
                            },
                            selectable: true,
                            select: function(startDate, endDate) {
                                $('#toevoegenActiviteit').modal();
                                $('#toevoegenActiviteit .modal-title').html('Activiteit toevoegen');
                                var site_url = '<?php echo site_url(); ?>';
                                $('#toevoegenActiviteit input[name=startDate]').attr('value', startDate.toString());
                                $('#toevoegenActiviteit input[name=endDate]').attr('value', endDate.toString());
                            },
                            events: result
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
                            events: result
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
                            events: result
                        });
                        break;
                };
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
>>>>>>> 9024b48892408cba746d8940a006567c7787eb1e
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
          events: result
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
          events: result
        });
        break;
      };
    },
    error: function (xhr, status, error) {
      alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
    }
  });

  $('#agenda').fullCalendar('rerenderEvents');
});

$(document).ready(function () {
  $('.runFunction:first').click();
  $('.datepicker2').datepicker({
    autoclose: true,
    orientation: 'auto'
  });
});
</script>
