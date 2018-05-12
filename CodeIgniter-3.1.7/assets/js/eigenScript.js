function form_validatie(formID, bool) {
    // bool = true --> controlleert ook op comboboxes
    //(dit is handig om toevoegen en minder bij aanpassen) (vraag uitleg thibaut)

    var ok = true;
    //inputs checken
    $(formID + ' *').filter('input').each(function () {
        var foutID = "#" + $(this).attr("id") + "-fout";

        if ($(this).attr("required") && $(this).val() == "") {
            $(foutID).removeAttr('hidden');
            $(this).css({"margin-bottom": '0px', "border-color": "red"});
            ok = false;
        } else {
            $(foutID).css({'display': 'none'});
            $(this).css({"margin-bottom": '20px', "border-color": "blue"});
            $(foutID).css({"margin-bottom": '0px'});
        }
    });
    //comboboxes checken
    if (bool === true) {
        $(formID + ' *').filter('select').each(function () {
            var foutID = "#" + $(this).attr("id") + "-fout";

            if ($(this).attr("required") && $('#' + this.id).prop('selectedIndex') == 0) {
                $(foutID).removeAttr('hidden');
                $(this).css({"margin-bottom": '0px', "border-color": "red"});
                ok = false;
            } else {
                $(foutID).css({'display': 'none'});
                $(this).css({"margin-bottom": '20px', "border-color": "blue"});
                $(foutID).css({"margin-bottom": '0px'});
            }
        });
    }

    // true = geen fouten gevonden
    return ok;
}
//modal Close
$(".close").click(function () {
    $('.modal').modal('hide');
});


// wedstrijden starts
function wedstrijdOpslaan(actie) {

    var ok = true;
    var formToSubmit = '';
    //form valideren
    if (actie == "toevoegen") {
        formToSubmit = "#wedstrijdToevoegen #form-wedstrijd";
        if (!form_validatie(formToSubmit, true) || typeof wedstrijdAfstanden == "undefined" || wedstrijdAfstanden == null || wedstrijdAfstanden.length == null || wedstrijdAfstanden.length <= 0) {
            alert("Velden of reeksen zijn niet volledig!");
            ok = false;
        }
    } else {
        formToSubmit = "#wedstrijdAanpassen #form-wedstrijd";
        if (!form_validatie(formToSubmit) || typeof wedstrijdAfstanden == "undefined" || wedstrijdAfstanden == null || wedstrijdAfstanden.length == null || wedstrijdAfstanden.length <= 0) {
            alert("niet alle velden zijn ingevuld");
            ok = false;
        }
    }

    //word uitgevoerd als alles ingevuld is
    if (ok) {
        $(formToSubmit).attr('action', site_url + '/Trainer/wedstrijden/opslaanWedstrijd/' + actie + '?pagina=aanpassen&afstanden=' + wedstrijdAfstanden + '&slagen=' + wedstrijdSlagen);
        wedstrijdAfstanden = [];
        wedstrijdSlagen = [];
        $('.modal').modal('hide');
        $(formToSubmit).submit();
    }
}

function wedstrijdVerwijder(elementID) {
    if (!confirm("Zeker dat je dit wilt verwijderen?")) {
        return false;
    } else {
        //id van wedstrijd
        var id = $("#" + elementID).val();
        // alert(id);
        //verwijderen
        $.post(site_url + '/Trainer/wedstrijden/verwijderWedstrijd/' + id, function (data) {
            alert("Wedstrijd is verwijderd!");
            $("tr#" + id).remove();
        }).fail(function () {
            alert("Er is iets misgelopen, neem contact op met de administrator.");
        });
    }
}

function wedstrijdOpvragen(wedstrijdID) {

    var id = $("#" + wedstrijdID).val();

    $.post(site_url + '/Trainer/wedstrijden/wedstrijdOpvragen/' + id, function (data) {
        //data = object van wedstrijd
        data = JSON.parse(data);
        // console.log(data[0]["Naam"]);

        //modal opvullen met object wedstrijd
        opvullenModalAanpassen(data, id);

    }).fail(function () {
        alert("Er is iets misgelopen, neem contact op met de administrator.");
    });

    // modal openen met ingevulde gegevens van dit object
    $("#wedstrijdAanpassen").modal();

}
function opvullenModalAanpassen(dataWedstrijd, wedstrijdID) {
    console.log(dataWedstrijd);
    // console.log(dataWedstrijd[0]["Naam"]);
    $('#wedstrijdAanpassen #wedstrijdID').attr("value", dataWedstrijd["id"]);
    $('#wedstrijdAanpassen #titel-wedstrijd').val(dataWedstrijd["naam"]);
    $('#wedstrijdAanpassen #datum-wedstrijdStart').attr("value", dataWedstrijd["datumStart"]);
    $('#wedstrijdAanpassen #datum-wedstrijdStop').attr("value", dataWedstrijd["datumStop"]);
    $('#wedstrijdAanpassen #locatie-wedstrijd').val(dataWedstrijd["plaats"]);
    $('#wedstrijdAanpassen #programma-wedstrijd').val(dataWedstrijd["programma"]);

    //reeksen toevoegen
    reeksenLeegmaken();
    // 1st opvragen
    $.post(site_url + '/Trainer/wedstrijden/reeksenOpvragen/' + wedstrijdID, function (data) {
        data = JSON.parse(data);
        // console.log(data);
        // 2des invullen
        $("#wedstrijdAanpassen .reeksen tr").html("");
        data["afstandIDs"].forEach((a, index, array) => {
            data["slagIDs"].forEach((s, index2, array2) => {
                if (index == index2) {
                    wedstrijdAfstanden.push(Object.keys(data["afstandIDs"][index]).toString());
                    wedstrijdSlagen.push(Object.keys(data["slagIDs"][index]).toString());
                    tijdelijk1.push(Object.keys(data["afstandIDs"][index]).toString());
                    tijdelijk2.push(Object.keys(data["slagIDs"][index]).toString());
                    $("#wedstrijdAanpassen .reeksen").append("<tr id='rowUpdate" + index + "'><td style='padding:10px 0;'>" + a[Object.keys(a)] + " " + s[Object.keys(s)] + "</td><td style='padding:10px 0;'>" +
                            "<button type='button' class='btn-xs btn-danger btn-circle' id='verwijder" + a[Object.keys(a)] + s[Object.keys(s)] + "' onclick='verwijderReeksArrays(" + "rowUpdate" + index + "," + Object.keys(s) + "," + Object.keys(a) + ")' style='margin-left: 15px;'><i class='fas fa-trash-alt'></i></button></td></tr>");
                }
            });
        });

    }).fail(function () {
        alert("Er is iets misgelopen, neem contact op met de administrator.");
    });
}

function verwijderReeksArrays(trID, slag, afstand) {
    // verwijder op combinatie, niet index
    console.log(trID);
    $.each(wedstrijdAfstanden, function (index, value) {
        //eerste combinatie
        $.each(wedstrijdAfstanden, function (index2, value2) {

            if (wedstrijdAfstanden[index2] == afstand) {
                //eerste is al gelijk aan iets, 2de ook? (met zelfde index natuurlijk)
                if (wedstrijdSlagen[index2] == slag) {
                    // als deze ook klopt dan bestaat reeks al.
                    //verwijder deze index
                    wedstrijdAfstanden.splice(index2, 1);
                    wedstrijdSlagen.splice(index2, 1);
                    tijdelijk1.splice(index2, 1);
                    tijdelijk2.splice(index2, 1);
                    $(trID).html("");
                }
            }

        });

    });
}
function reeksenLeegmaken() {
    wedstrijdAfstanden = [];
    wedstrijdSlagen = [];

    tijdelijk1 = [];
    tijdelijk2 = [];
    $(".reeksen tr").html("");
}
//global variabel voor reeksen
var wedstrijdAfstanden = [];
var wedstrijdSlagen = [];

var tijdelijk1 = [];
var tijdelijk2 = [];


function reeksToevoegen(actie) {
    var modalToUse = '';
    if (actie == "toevoegen") {
        modalToUse = "#wedstrijdToevoegen";
    } else {
        modalToUse = "#wedstrijdAanpassen";
    }

    var ok = true;

    //checken of de combinatie al bestaat (zodat we geen dezelfde reeksen hebben)
    tijdelijk1.forEach((s, index) => {
        [$(modalToUse + ' .afstand-wedstrijd').val(), $(modalToUse + ' .slag-wedstrijd').val()].forEach((m, index2, array) => {
            console.log($(modalToUse + ' .afstand-wedstrijd').val() + "-" + $(modalToUse + ' .slag-wedstrijd').val());
            if (tijdelijk1[index] == m && tijdelijk2[index] == array[index2 + 1]) {
                //zit de combinatie al in de reeks?
                ok = false;
            }

        });
    });

    if (ok) {
        tijdelijk1.push($(modalToUse + ' .afstand-wedstrijd').val());
        tijdelijk2.push($(modalToUse + ' .slag-wedstrijd').val());
        // $("#wedstrijdToevoegen .reeksen").append("<p>"+$('.afstand-wedstrijd option:selected').text()+" "+$('#slag-wedstrijd option:selected').text()+"</p>");
        $(modalToUse + " .reeksen").append("<tr id='rowAdd" + $(modalToUse + ' .afstand-wedstrijd option:selected').val() + $(modalToUse + ' .slag-wedstrijd option:selected').val() + "'><td style='padding:10px 0;'>" + $(modalToUse + ' .afstand-wedstrijd option:selected').text() + " " + $(modalToUse + ' .slag-wedstrijd option:selected').text() + "</td><td style='padding:10px 0;'>" +
                "<button type='button' class='btn-xs btn-danger btn-circle' id='' onclick='verwijderReeksArrays(" + "rowAdd" + $(modalToUse + ' .afstand-wedstrijd option:selected').val() + $(modalToUse + ' .slag-wedstrijd option:selected').val() + "," + $(modalToUse + ' .slag-wedstrijd option:selected').val() + "," + $(modalToUse + ' .afstand-wedstrijd option:selected').val() + ")' style='margin-left: 15px;'><i class='fas fa-trash-alt'></i></button></td></tr>");
        wedstrijdAfstanden.push($(modalToUse + ' .afstand-wedstrijd').val());
        wedstrijdSlagen.push($(modalToUse + ' .slag-wedstrijd').val());
    }
}

//wedstrijden end

// zwemmer start

function persoonUpdate(persoonID) {

    console.log("id =" + persoonID);
    var id = $("#" + persoonID).val();

    $.post(site_url + '/Trainer/team/wijzigPersoon/' + id, function (data) {
        //data = object van supplement
        data = JSON.parse(data);
        // console.log(data[0]["Naam"]);

        //modal opvullen met object wedstrijd
        opvullenModalPersoonWijzigen(data);

    }).fail(function () {
        alert("Er is iets misgelopen, neem contact op met de administrator.");
    });
    // modal openen met ingevulde gegevans van dit object
    $("#persoonWijzigen").modal();

}

function opvullenModalPersoonWijzigen(dataPersoon) {
  console.log(dataPersoon);
  console.log(dataPersoon["id"]);

  $('#persoonWijzigen #id').attr("value", dataPersoon["id"]);
  $('#persoonWijzigen #voornaam').val(dataPersoon["voornaam"]);
  $('#persoonWijzigen #achternaam').val(dataPersoon["achternaam"]);
  $('#persoonWijzigen #email').val(dataPersoon["email"]);
  $('#persoonWijzigen #wachtwoord').val(dataPersoon["wachtwoord"]);
  $('#persoonWijzigen #omschrijving').val(dataPersoon["omschrijving"]);

}

function zwemmerProfielTonen(persoonID) {

    console.log("id =" + persoonID);
    var id = $("#" + persoonID).val();

    $.post(site_url + '/Zwemmer/team/profielTonen/' + id, function (data) {
        //data = object van supplement
        data = JSON.parse(data);
        // console.log(data[0]["Naam"]);

        //modal opvullen met object wedstrijd
        opvullenModalZwemmerProfielTonen(data);

    }).fail(function () {
        alert("Er is iets misgelopen, neem contact op met de administrator.");
    });
    // modal openen met ingevulde gegevans van dit object
    $("#profielTonen").modal();

}
function opvullenModalZwemmerProfielTonen(dataProfiel) {
    console.log(dataProfiel);
    console.log(dataProfiel["id"]);
    $('#profielTonen #id').attr("value", dataProfiel["id"]);
    $('#profielTonen #voornaam').val(dataProfiel["voornaam"]);
    $('#profielTonen #achternaam').val(dataProfiel["achternaam"]);
    $('#profielTonen #straat').val(dataProfiel["straat"]);
    $('#profielTonen #huisnummer').val(dataProfiel["huisnummer"]);
    $('#profielTonen #postcode').val(dataProfiel["postcode"]);
    $('#profielTonen #gemeente').val(dataProfiel["gemeente"]);
    $('#profielTonen #telefoonnummer').val(dataProfiel["telefoonnummer"]);
    $('#profielTonen #email').val(dataProfiel["email"]);
    $('#profielTonen #omschrijving').val(dataProfiel["omschrijving"]);

}

function persoonOpslaan(actie) {

    var ok = true;
    var formToSubmit = '';
    //form valideren
    if (actie == "toevoegen") {
        $('#persoonToevoegen #form-persoon *').filter('input').each(function () {
            if ($(this).attr("required") && $(this).val() == "") {
                alert("Niet alle velden zijn ingevuld");
                ok = false;
                return false;
            }


    });
    formToSubmit = "#persoonToevoegen #form-persoon";
  } else {
    $('#persoonWijzigen #form-persoon *').filter('input').each(function () {
      if ($(this).attr("required") && $(this).val() == "") {
        alert("Niet alle velden zijn ingevuld");
        ok = false;
        return false;
      }

    });
    formToSubmit = "#persoonWijzigen #form-persoon";
  }

    //word uitgevoerd als alles ingevuld is
    if (ok) {
        $(formToSubmit).attr('action', site_url + '/Trainer/team/opslaanPersoon/' + actie);

        $(formToSubmit).submit();
    }
}

function zwemmerUitArchiefHalen() {
    var ok = true;
    var formToSubmit = '';
    $('#zwemmerToevoegenUitArchief #form-persoon *').filter('select').each(function () {
        if ($(this).val() === "0") {
            alert("Er is geen persoon aangeduid");
            ok = false;
            return false;
        }
    });
    formToSubmit = "#zwemmerToevoegenUitArchief #form-persoon";

    //word uitgevoerd als alles ingevuld is
    if (ok) {
        $(formToSubmit).attr('action', site_url + '/Trainer/team/opslaanZwemmerUitArchiefHalen');

        $(formToSubmit).submit();
    }
}


//zwemmer end
// supplement start

function supplementUpdate(supplementID) {

    console.log("id =" + supplementID);
    var id = $("#" + supplementID).val();

    $.post(site_url + '/Trainer/supplement/wijzigSupplement/' + id, function (data) {
        //data = object van supplement
        data = JSON.parse(data);
        // console.log(data[0]["Naam"]);

        //modal opvullen met object wedstrijd
        opvullenModalSupplementAanpassen(data);

    }).fail(function () {
        alert("Er is iets misgelopen, neem contact op met de administrator.");
    });


    // modal openen met ingevulde gegevans van dit object
    $("#supplementAanpassen").modal();

}
function opvullenModalSupplementAanpassen(dataSupplement) {
    console.log(dataSupplement);
    console.log(dataSupplement["id"]);
    // console.log(dataSupplement[0]["Naam"]);
    $('#supplementAanpassen #id').attr("value", dataSupplement["id"]);
    $('#supplementAanpassen #naam').val(dataSupplement["naam"]);
    $('#supplementAanpassen #functie').attr("value", dataSupplement["supplementFunctieId"]);
    $("#functie option").each(function ()
    {
        if ($(this).val() === dataSupplement["supplementFunctieId"]) {
            $("option[value=" + $(this).val() + "]").attr("selected", "selected");
        }
    });
    $('#supplementAanpassen #omschrijving').attr("value", dataSupplement["omschrijving"]);

}

function supplementVerwijder(elementID) {
    if (!confirm("Zeker dat je dit wilt verwijderen?")) {
        return false;
    } else {
        //id van supplement
        var id = $("#" + elementID).val();
        // alert(id);
        //verwijderen
        $.post(site_url + '/Trainer/supplement/verwijderSupplement/' + id, function (data) {
            alert("Voedingssupplement is verwijderd!");
            $("tr#" + id).remove();
        }).fail(function () {
            alert("Er is iets misgelopen, neem contact op met de administrator.");
        });
    }
}

function supplementOpslaan(actie) {

    var ok = true;
    var formToSubmit = '';
    //form valideren
    if (actie === "toevoegen") {
        formToSubmit = "#supplementToevoegen #form-supplement";
        if (!form_validatie(formToSubmit)) {
            //alert("Niet alle velden zijn ingevuld");
            ok = false;
            return false;
        }
    } else {
        formToSubmit = "#supplementAanpassen #form-supplement";
        if (!form_validatie(formToSubmit)) {
            //alert("Niet alle velden zijn ingevuld");
            ok = false;
            return false;
        }
    }

    //word uitgevoerd als alles ingevuld is
    if (ok) {
        $(formToSubmit).attr('action', site_url + '/Trainer/supplement/opslaanSupplement/' + actie);

        $(formToSubmit).submit();
    }
}

// supplement end


// agenda start

function aanpassenActiviteit(activiteit, id, site_url) {
    linkActiviteit = '';
    switch (true) {
        case activiteit === "Wedstrijd":
            linkActiviteit = 'wijzigWedstrijd';
            break;
        case activiteit === "Medische afspraak":
            linkActiviteit = 'wijzigOnderzoek';
            break;
        case activiteit === "Supplement":
            linkActiviteit = 'wijzigSupplement';
            break;
        default:
            linkActiviteit = 'wijzigActiviteit';
            break;
    }
    $.post(site_url + '/trainer/agenda/' + linkActiviteit + '/' + id,
            function (data) {
                //data = object van activiteit
                data = JSON.parse(data);

                //modal opvullen met object activiteit
                opvullenModalActiviteitAanpassen(data, id, activiteit, site_url);
            }).fail(function () {
        alert("Er is iets misgelopen, neem contact op met de administrator.");
    });


    // modal openen met ingevulde gegevans van dit object
    $("#aanpassenActiviteit").modal();
}

function dateHelper_getDate(date) {
    var datetimeToDate = date.split(' ');
    var date = datetimeToDate[0].split('-');
    var date2 = date[2] + '/' + date[1] + '/' + date[0];

    return date2;
}

function dateHelper_getTime(date) {
    var datetimeToDate = date.split(' ');
    var time = datetimeToDate[1].split(':');
    var time2 = time[0] + ':' + time[1];

    return time2;
}

function opvullenModalActiviteitAanpassen(data, id, activiteit, site_url) {
    var uren = ['06:00', '06:30', '07:00', '07:30', '08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30', '20:00', '20:30', '21:00', '21:30', '22:00', '22:30', '23:00', '23:30', '24:00'];
    $('#aanpassenActiviteit #titel-form').addClass('d-none');
    $('#aanpassenActiviteit input[name=id]').attr('value', id);
    $('#aanpassenActiviteit #training-form').addClass('d-none');
    $('#aanpassenActiviteit #wedstrijd-form').addClass('d-none');
    $('#aanpassenActiviteit #tijdstip-form').addClass('d-none');
    $('#aanpassenActiviteit #supplement-form').addClass('d-none');
    $("#aanpassenActiviteit #beginuur option").attr("selected", false);
    $("#aanpassenActiviteit #einduur option").attr("selected", false);
    $("#aanpassenActiviteit #supplementnaam option").attr("selected", false);
    $("#aanpassenActiviteit #soort option").attr("selected", false);
    $('#aanpassenActiviteit #opmerking').html('');
    $('#aanpassenActiviteit .datepicker2').datepicker('update', '');

    $("#aanpassenActiviteit input[name='personen[]']").attr("checked", false);
    $('#aanpassenActiviteit #opmerking-form').addClass('d-none');
    $('#aanpassenActiviteit #personen-form').addClass('d-none');
    $('#aanpassenActiviteit #tabDatum').addClass('d-none');
    $('#aanpassenActiviteit .supplementDatum').addClass('d-none');
    $('#aanpassenActiviteit #tabDatum a').removeClass('disabled');
    
    switch (true) {
        case activiteit === "Wedstrijd":
            $('#aanpassenActiviteit form').attr('action', site_url + '/Trainer/Agenda/registreerWedstrijd');
            $('#aanpassenActiviteit #aanpassenFormulier').attr('novalidate', '');
            $('#aanpassenActiviteit #titel-form').removeClass('d-none');
            $('#aanpassenActiviteit #wedstrijd-form').removeClass('d-none');
            $('#aanpassenActiviteit #tijdstip-form').removeClass('d-none');
            $('#aanpassenActiviteit #gebeurtenisnaam').attr('value', data['naam']);
            $('#aanpassenActiviteit #plaats').attr('value', data['plaats']);
            $('#aanpassenActiviteit #programma').attr('value', data['programma']);
            $('#aanpassenActiviteit .begindatum .datepicker2').datepicker('update', dateHelper_getDate(data['datumStart']));
            $('#aanpassenActiviteit .einddatum .datepicker2').datepicker('update', dateHelper_getDate(data['datumStop']));

            $("#aanpassenActiviteit #beginuur option[value='" + uren.indexOf(dateHelper_getTime(data['datumStart'])) + "']").attr("selected","selected");
            $("#aanpassenActiviteit #einduur option[value='" + uren.indexOf(dateHelper_getTime(data['datumStop'])) + "']").attr("selected","selected");
            $("#aanpassenActiviteit #einduur option[value='" + data['persoonId'] + "']").attr("selected","selected");
            break;
        case activiteit === "Medische afspraak":
            $('#aanpassenActiviteit form').attr('action', site_url + '/Trainer/Agenda/registreerOnderzoek');
            $('#aanpassenActiviteit #titel-form').removeClass('d-none');
            $('#aanpassenActiviteit #tijdstip-form').removeClass('d-none');
            $('#aanpassenActiviteit #gebeurtenisnaam').attr('value', data['omschrijving']);
            $('#aanpassenActiviteit .begindatum .datepicker2').datepicker('update', dateHelper_getDate(data['tijdstipStart']));
            $('#aanpassenActiviteit .einddatum .datepicker2').datepicker('update', dateHelper_getDate(data['tijdstipStop']));
            $("#aanpassenActiviteit #beginuur option[value='" + uren.indexOf(dateHelper_getTime(data['tijdstipStart'])) + "']").attr("selected", "selected");
            $("#aanpassenActiviteit #einduur option[value='" + uren.indexOf(dateHelper_getTime(data['tijdstipStop'])) + "']").attr("selected", "selected");
            $('#aanpassenActiviteit #tijdstipReeks-form').removeClass('d-none');
            $('#aanpassenActiviteit #opmerking-form').removeClass('d-none');
            $('#aanpassenActiviteit #tabDatum').removeClass('d-none');
            break;
        case activiteit === "Supplement":
            $('#aanpassenActiviteit form').attr('action', site_url + '/Trainer/Agenda/registreerSupplement');
            $('#aanpassenActiviteit #supplement-form').removeClass('d-none');
            $("#aanpassenActiviteit #supplementnaam option[value='" + (data['supplement']['id'] - 1) + "']").attr("selected", "selected");
            $('#aanpassenActiviteit #hoeveelheid').attr('value', data['hoeveelheid']);
            $('#aanpassenActiviteit #datum').datepicker('update', dateHelper_getDate(data['datum']));
            $('#aanpassenActiviteit #opmerking').html(data['supplement']['omschrijving']);
            $('#aanpassenActiviteit .datepicker').datepicker('update', '19-04-2018');
            $('#aanpassenActiviteit #opmerking-form').removeClass('d-none');
            $('#aanpassenActiviteit #tabDatum').removeClass('d-none');
            $('#aanpassenActiviteit .supplementDatum').removeClass('d-none');
            break;
        case activiteit === "Stage":
            $('#aanpassenActiviteit form').attr('action', site_url + '/Trainer/Agenda/registreerActiviteit');
            $('#aanpassenActiviteit #titel-form').removeClass('d-none');
            $('#aanpassenActiviteit #tijdstip-form').removeClass('d-none');
            $('#aanpassenActiviteit #gebeurtenisnaam').attr('value', data['stageTitel']);
            $('#aanpassenActiviteit .begindatum .datepicker2').datepicker('update', dateHelper_getDate(data['tijdstipStart']));
            $('#aanpassenActiviteit .einddatum .datepicker2').datepicker('update', dateHelper_getDate(data['tijdstipStop']));
            $("#aanpassenActiviteit #beginuur option[value='" + uren.indexOf(dateHelper_getTime(data['tijdstipStart'])) + "']").attr("selected", "selected");
            $("#aanpassenActiviteit #einduur option[value='" + uren.indexOf(dateHelper_getTime(data['tijdstipStop'])) + "']").attr("selected", "selected");
            $('#aanpassenActiviteit #tijdstipReeks-form').removeClass('d-none');
            $('#aanpassenActiviteit #opmerking-form').removeClass('d-none');
            $('#aanpassenActiviteit #personen-form').removeClass('d-none');
            $.each(data['personen'], function(index){
                $("#aanpassenActiviteit input[name='personen[]'][value=" + data['personen'][index] + "]").attr("checked", true);
            });
            $('#aanpassenActiviteit #tabDatum').removeClass('d-none');
            break;
        default:
            $('#aanpassenActiviteit form').attr('action', site_url + '/Trainer/Agenda/registreerActiviteit');
            var typeTraininId = data["typeTrainingId"] - 1;
            $('#aanpassenActiviteit #titel-form').removeClass('d-none');
            $('#aanpassenActiviteit #training-form').removeClass('d-none');
            $('#aanpassenActiviteit #tijdstip-form').removeClass('d-none');
            $('#aanpassenActiviteit #gebeurtenisnaam').attr('value', data['stageTitel']);
            $("#aanpassenActiviteit #soort option[value='" + typeTraininId + "']").attr("selected", "selected");

            if (data['reeksId'] === null) {
                $('#aanpassenActiviteit #tabDatum #reeks-tab').addClass('disabled');
//                $('#aanpassenActiviteit #tabDatum ').addClass('active');
                $('#aanpassenActiviteit #tabDatum #dag-tab').tab('show');
                $('#aanpassenActiviteit #tijdstip-form').removeClass('d-none');
                $('#aanpassenActiviteit #begindatum').datepicker('update', dateHelper_getDate(data['tijdstipStart']));
                $('#aanpassenActiviteit #einddatum').datepicker('update', dateHelper_getDate(data['tijdstipStop']));
                $("#aanpassenActiviteit #beginuur option[value='" + uren.indexOf(dateHelper_getTime(data['tijdstipStart'])) + "']").attr("selected", "selected");
                $("#aanpassenActiviteit #einduur option[value='" + uren.indexOf(dateHelper_getTime(data['tijdstipStop'])) + "']").attr("selected", "selected");
            }
            else {
                $('#aanpassenActiviteit #tabDatum #dag-tab').addClass('disabled');
//                $('#aanpassenActiviteit #tabDatum #reeks-tab').addClass('active');
                $('#aanpassenActiviteit #tabDatum #reeks-tab').tab('show');
                $('#aanpassenActiviteit #tijdstipReeks-form').removeClass('d-none');
                $('#aanpassenActiviteit #begindatumReeks').datepicker('update', dateHelper_getDate(data['reeks'][0]['tijdstipStop']));
                $('#aanpassenActiviteit #einddatumReeks').datepicker('update', dateHelper_getDate(data['reeks'][data.reeks.length-1]['tijdstipStop']));
                $("#aanpassenActiviteit #beginuurReeks option[value='" + uren.indexOf(dateHelper_getTime(data['tijdstipStart'])) + "']").attr("selected", "selected");
                $("#aanpassenActiviteit #einduurReeks option[value='" + uren.indexOf(dateHelper_getTime(data['tijdstipStop'])) + "']").attr("selected", "selected");
            }
            $('#aanpassenActiviteit #opmerking-form').removeClass('d-none');
            $('#aanpassenActiviteit #personen-form').removeClass('d-none');
            $.each(data['personen'], function(index){
                $("#aanpassenActiviteit input[name='personen[]'][value=" + data['personen'][index] + "]").attr("checked", true);
            });
            $('#aanpassenActiviteit #tabDatum').removeClass('d-none');
            break;
    }
}

// agenda stop

// melding start

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
        formToSubmit = "#meldingToevoegen #form-melding";
        if (!form_validatie(formToSubmit)) {
            //alert("Niet alle velden zijn ingevuld");
            ok = false;
            return false;
        }
    } else {
        formToSubmit = "#meldingAanpassen #form-melding";
        if (!form_validatie(formToSubmit)) {
            //alert("Niet alle velden zijn ingevuld");
            ok = false;
            return false;
        }
    }

    //word uitgevoerd als alles ingevuld is
    if (ok) {
        $(formToSubmit).attr('action', site_url + '/Trainer/melding/opslaanMelding/' + actie);

        $(formToSubmit).submit();
    }
}

// melding end

// inschrijven zwemmer start

function inschrijvingOpslaan() {

    var ok = true;
    var formToSubmit = '';
    //form valideren

    formToSubmit = "#inschrijvenWedstrijd #mijnFormulier";
    if (!form_validatie(formToSubmit)) {
        //alert("Niet alle velden zijn ingevuld");
        ok = false;
        return false;
    }

    //word uitgevoerd als alles ingevuld is
    if (ok) {
        $(formToSubmit).attr('action', site_url + '/Zwemmer/wedstrijden/opslaanInschrijving/');
        $(formToSubmit).submit();
        alert("Inschrijving gelukt!");
    }
}

// inschrijven zwemmer end

// inschrijven trainer start

function inschrijvingGoedkeuren(elementID) {
    if (!confirm("Zeker dat je dit wilt goedkeuren?")) {
        return false;
    } else {
        // var formToSubmit = '';
        var id = $("#" + elementID).val();

        // formToSubmit = "#form-hidden";

        // $(formToSubmit).attr('action', site_url + '/Trainer/inschrijving/goedkeurenInschrijving/' + id);
        // $(formToSubmit).submit();
        $.post(site_url + '/Trainer/inschrijving/goedkeurenInschrijving/' + id, function (data) {
            alert("Inschrijving is goedgekeurd!");
            $("tr#" + id).remove();
        }).fail(function () {
            alert("Er is iets misgelopen, neem contact op met de administrator.");
        });
        
    }
}

function inschrijvingAfkeuren(elementID) {
    if (!confirm("Zeker dat je dit wilt afkeuren?")) {
        return false;
    } else {
        var id = $("#" + elementID).val();
        $.post(site_url + '/Trainer/inschrijving/afkeurenInschrijving/' + id, function (data) {
            alert("Inschrijving is afgekeurd!");
            $("tr#" + id).remove();
        }).fail(function () {
            alert("Er is iets misgelopen, neem contact op met de administrator.");
        });
    }
}

// inschrijving trainer end
