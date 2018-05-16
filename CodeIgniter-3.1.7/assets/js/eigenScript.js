function form_validatie(formID, bool) {
    // bool = true --> controlleert ook op comboboxes
    //(dit is handig om toevoegen en minder bij aanpassen) (vraag uitleg thibaut)

    var ok = true;
    //inputs checken
    $(formID + ' *').filter('input').each(function () {
        var foutID = "#" + $(this).attr("id") + "-fout";

        if ($(this).attr("required") && $(this).val() === "") {
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

            if ($(this).attr("required") && $('#' + this.id).prop('selectedIndex') === 0) {
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
    if (actie === "toevoegen") {
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
//wedstrijd resultaten start
function resultaatOpvragen(resultaatID) {
    var id = $("#" + resultaatID).val();
    // alert(id);
    $.post(site_url + '/Trainer/WedstrijdResultaten/resultaatOpvragen/' + id, function (data) {
        data = JSON.parse(data);
        console.log(data);
        // resultaat id opvullen in hidden text input in form aanpassen
        $('#resultaatAanpassen #resultaatId').attr('value', id);
        resultaatModalOpvullen(data);

    }).fail(function () {
        alert("Er is iets misgelopen, neem contact op met de administrator.");
    });

    // modal openen met ingevulde gegevens van dit object
    $("#resultaatAanpassen").modal();
}
function resultaatModalOpvullen(data) {
    var naam = $('#' + data['id'] + ' #zwemmerNaam').html();
    $("#resultaatAanpassen #zwemmersToevoegen > option").each(function () {
        if (this.text === naam) {
            $(this).prop('selected', true);
        }
    });
    $("#resultaatAanpassen #rondeToevoegen > option").each(function () {
        if (this.text === data['ronde']['ronde']) {
            $(this).prop('selected', true);
        }
    });

    $('#resultaatAanpassen #reeksenToevoegen').empty();
    $.each(data['reeksen'], function (val, text) {
        $('#resultaatAanpassen #reeksenToevoegen').append(
                $('<option></option>').val(val).html(text)
                );
    });
    $('#resultaatAanpassen #naam-datum').attr("value", data["tijd"].split(' ')[0]);
    $('#resultaatAanpassen #naam-tijd').attr("value", data["tijd"].split(' ')[1]);

}

function resultaatOpslaan(actie) {

    var formToSubmit = '';

    //form valideren
    if (actie == "toevoegen") {
        formToSubmit = "#resultaatToeveoegen #form-wedstrijd";

    } else {
        formToSubmit = "#resultaatAanpassen #form-wedstrijd";

    }

    var wedstrijdID = $('#wedstrijdId').val();
    var resultaatID = $('#resultaatId').val();

    $(formToSubmit).attr('action', site_url + '/Trainer/WedstrijdResultaten/opslaanResultaat/' + actie + '?pagina=aanpassen&wedstrijdId=' + wedstrijdID + "&resultaatId=" + resultaatID);

    $('.modal').modal('hide');
    $(formToSubmit).submit();

}

function resultaatVerwijder(resultaatID) {
    if (!confirm("Zeker dat je dit wilt verwijderen?")) {
        return false;
    } else {
        //id van wedstrijd
        var id = $("#" + elementID).val();
        // alert(id);
        //verwijderen
        $.post(site_url + '/Trainer/WedstrijdResultaten/verwijderResultaat/' + id, function (data) {
            alert("Wedstrijd is verwijderd!");
            $("tr#" + id).remove();
        }).fail(function () {
            alert("Er is iets misgelopen, neem contact op met de administrator.");
        });
    }
}
//wedstrijd resultaten end

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

function profielGegevensTonen(profielID) {

    console.log("id =" + profielID);
    var id = $("#" + profielID).val();

    $.post(site_url + '/Zwemmer/team/profielTonen/' + id, function (data) {
        //data = object van supplement
        data = JSON.parse(data);
        // console.log(data[0]["Naam"]);

        //modal opvullen met object wedstrijd
        opvullenModalProfielGegevensTonen(data);

    }).fail(function () {
        alert("Er is iets misgelopen, neem contact op met de administrator.");
    });
    // modal openen met ingevulde gegevans van dit object
    $("#profielWijzigen").modal();

}

function opvullenModalProfielGegevensTonen(dataProfielGegevens) {
    console.log(dataProfielGegevens);
    console.log(dataProfielGegevens["id"]);
    $('#profielWijzigen #id').attr("value", dataProfielGegevens["id"]);
    $('#profielWijzigen #voornaam').val(dataProfielGegevens["voornaam"]);
    $('#profielWijzigen #achternaam').val(dataProfielGegevens["achternaam"]);
    $('#profielWijzigen #straat').val(dataProfielGegevens["straat"]);
    $('#profielWijzigen #huisnummer').val(dataProfielGegevens["huisnummer"]);
    $('#profielWijzigen #postcode').val(dataProfielGegevens["postcode"]);
    $('#profielWijzigen #gemeente').val(dataProfielGegevens["gemeente"]);
    $('#profielWijzigen #telefoonnummer').val(dataProfielGegevens["telefoonnummer"]);
    $('#profielWijzigen #email').val(dataProfielGegevens["email"]);
    $('#profielWijzigen #omschrijving').val(dataProfielGegevens["omschrijving"]);

}

function profielOpslaan() {

    var ok = true;
    var formToSubmit = '';
    //form valideren
    $('#profielWijzigen #form-profiel *').filter('input').each(function () {
        if ($(this).attr("required") && $(this).val() == "") {
            alert("Niet alle velden zijn ingevuld");
            ok = false;
            return false;
        }
    });
    formToSubmit = "#profielWijzigen #form-profiel";

    //word uitgevoerd als alles ingevuld is
    if (ok) {
        $(formToSubmit).attr('action', site_url + '/Zwemmer/profiel/profielOpslaan/');

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
    $('#aanpassenActiviteit #deleteActiviteitButton').css('display', 'block');
    $('#aanpassenActiviteit #toevoegenActiviteitButtonContainer').removeClass('justify-content-right');
    $('#aanpassenActiviteit #toevoegenActiviteitButtonContainer').addClass('justify-content-between');
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
    $('#aanpassenActiviteit #tijdstipReeks-form').addClass('d-none');
    $('#aanpassenActiviteit #tijdstip-form').addClass('d-none');
    $('#aanpassenActiviteit #deleteActiviteitButton').attr('onclick', 'verwijderActiviteit(' + id + ', "' + activiteit + '")');
    $('#aanpassenActiviteit #soort option:last').attr('hidden', true);
    $('#aanpassenActiviteit #wedstrijdAanpassen-form').addClass('d-none');
    $('#aanpassenActiviteit .buttonsActiviteitAanpassenContainer').removeClass('d-none');

    //required verwijderen
    $('#aanpassenActiviteit #gebeurtenisnaam').attr('required', false);
    $('#aanpassenActiviteit #hoeveelheid').attr('required', false);
    $('#aanpassenActiviteit #begindatum').attr('required', false);
    $('#aanpassenActiviteit #einddatum').attr('required', false);
    $('#aanpassenActiviteit #datum').attr('required', false);
    $('#aanpassenActiviteit #begindatumReeks').attr('required', false);
    $('#aanpassenActiviteit #einddatumReeks').attr('required', false);
    $('#aanpassenActiviteit #begindatumSupplement').attr('required', false);
    $('#aanpassenActiviteit #einddatumSupplement').attr('required', false);

    switch (true) {
        case activiteit === "Wedstrijd":
            $('#aanpassenActiviteit #wedstrijdAanpassen-form').removeClass('d-none');
            $('#aanpassenActiviteit .buttonsActiviteitAanpassenContainer').addClass('d-none');
            $('#aanpassenActiviteit #deleteActiviteitButton').css('display', 'none');
            $('#aanpassenActiviteit #titel-form').removeClass('d-none');
            $('#aanpassenActiviteit #wedstrijd-form').removeClass('d-none');
            $('#aanpassenActiviteit #tijdstip-form').removeClass('d-none');
            $('#aanpassenActiviteit #gebeurtenisnaam').attr({
                'value': data['naam'],
                'disabled': true
            });
            $('#aanpassenActiviteit #plaats').attr({
                'value': data['plaats'],
                'disabled': true
            });
            $('#aanpassenActiviteit #programma').attr({
                'value': data['programma'],
                'disabled': true
            });
            $('#aanpassenActiviteit .begindatum .datepicker2').datepicker('update', dateHelper_getDate(data['datumStart']));
            $('#aanpassenActiviteit #begindatum').attr('disabled', true);
            $('#aanpassenActiviteit .einddatum .datepicker2').datepicker('update', dateHelper_getDate(data['datumStop']));
            $('#aanpassenActiviteit #einddatum').attr('disabled', true);
            $("#aanpassenActiviteit #beginuur option[value='" + uren.indexOf(dateHelper_getTime(data['datumStart'])) + "']").attr("selected", "selected");
            $('#aanpassenActiviteit #beginuur').attr('disabled', true);
            $("#aanpassenActiviteit #einduur option[value='" + uren.indexOf(dateHelper_getTime(data['datumStop'])) + "']").attr("selected", "selected");
            $('#aanpassenActiviteit #einduur').attr('disabled', true);
            $('#aanpassenActiviteit #tabDatum #dag-tab').tab('show');
            $('#aanpassenActiviteit #tijdstip-form').removeClass('d-none');
            break;
        case activiteit === "Medische afspraak":
            $('#aanpassenActiviteit #begindatum').attr('required', true);
            $('#aanpassenActiviteit #einddatum').attr('required', true);
            $('#aanpassenActiviteit #gebeurtenisnaam').attr('required', true);
            $('#aanpassenActiviteit form').attr('action', site_url + '/Trainer/Agenda/registreerOnderzoek');
            $('#aanpassenActiviteit #titel-form').removeClass('d-none');
            $('#aanpassenActiviteit #tijdstip-form').removeClass('d-none');
            $('#aanpassenActiviteit #gebeurtenisnaam').attr('value', data['omschrijving']);
            $('#aanpassenActiviteit .begindatum .datepicker2').datepicker('update', dateHelper_getDate(data['tijdstipStart']));
            $('#aanpassenActiviteit .einddatum .datepicker2').datepicker('update', dateHelper_getDate(data['tijdstipStop']));
            $("#aanpassenActiviteit #beginuur option[value='" + uren.indexOf(dateHelper_getTime(data['tijdstipStart'])) + "']").attr("selected", "selected");
            $("#aanpassenActiviteit #einduur option[value='" + uren.indexOf(dateHelper_getTime(data['tijdstipStop'])) + "']").attr("selected", "selected");
            $('#aanpassenActiviteit #tabDatum #dag-tab').tab('show');
            $('#aanpassenActiviteit #tijdstip-form').removeClass('d-none');
            break;
        case activiteit === "Supplement":
            $('#aanpassenActiviteit #hoeveelheid').attr('required', true);
            $('#aanpassenActiviteit form').attr('action', site_url + '/Trainer/Agenda/registreerSupplement');
            $('#aanpassenActiviteit #supplement-form').removeClass('d-none');
            $("#aanpassenActiviteit #supplementnaam option[value='" + (data['supplement']['id'] - 1) + "']").attr("selected", "selected");
            $('#aanpassenActiviteit #hoeveelheid').attr('value', data['hoeveelheid']);
            if (data['datumStop'] === null) {
                $('#aanpassenActiviteit #datum').attr('required', true);
                $('#aanpassenActiviteit #datum').datepicker('update', dateHelper_getDate(data['datumStart']));
                $('#aanpassenActiviteit #tabDatum #reeks-tab').addClass('disabled');
                $('#aanpassenActiviteit #tabDatum #dag-tab').tab('show');
            } else {
                $('#aanpassenActiviteit #begindatumSupplement').attr('required', false);
                $('#aanpassenActiviteit #einddatumSupplement').attr('required', false);
                $('#aanpassenActiviteit #begindatumSupplement').datepicker('update', dateHelper_getDate(data['datumStart']));
                $('#aanpassenActiviteit #einddatumSupplement').datepicker('update', dateHelper_getDate(data['datumStop']));
                $('#aanpassenActiviteit #tabDatum #dag-tab').addClass('disabled');
                $('#aanpassenActiviteit #tabDatum #reeks-tab').tab('show');
            }
            $('#aanpassenActiviteit #opmerking').html(data['supplement']['omschrijving']);
            $('#aanpassenActiviteit #opmerking-form').removeClass('d-none');
            $('#aanpassenActiviteit #tabDatum').removeClass('d-none');
            $('#aanpassenActiviteit .supplementDatum').removeClass('d-none');
            $('#aanpassenActiviteit input[name=persoonSupplement]').attr('value', data['persoonId']);
            break;
        case activiteit === "Stage":
            $('#aanpassenActiviteit #begindatum').attr('required', true);
            $('#aanpassenActiviteit #einddatum').attr('required', true);
            $('#aanpassenActiviteit #gebeurtenisnaam').attr('required', true);
            $('#aanpassenActiviteit form').attr('action', site_url + '/Trainer/Agenda/registreerActiviteit');
            $('#aanpassenActiviteit input[name=reeksId]').attr('value', data['reeksId']);
            $('#aanpassenActiviteit #titel-form').removeClass('d-none');
            $('#aanpassenActiviteit #gebeurtenisnaam').attr('value', data['stageTitel']);
            $("#aanpassenActiviteit #soort option[value='4']").attr("selected", "selected");
            $('#aanpassenActiviteit .begindatum .datepicker2').datepicker('update', dateHelper_getDate(data['tijdstipStart']));
            $('#aanpassenActiviteit .einddatum .datepicker2').datepicker('update', dateHelper_getDate(data['tijdstipStop']));
            $("#aanpassenActiviteit #beginuur option[value='" + uren.indexOf(dateHelper_getTime(data['tijdstipStart'])) + "']").attr("selected", "selected");
            $("#aanpassenActiviteit #einduur option[value='" + uren.indexOf(dateHelper_getTime(data['tijdstipStop'])) + "']").attr("selected", "selected");
            $('#aanpassenActiviteit #tabDatum #dag-tab').tab('show');
            $('#aanpassenActiviteit #tijdstip-form').removeClass('d-none');
            $('#aanpassenActiviteit #personen-form').removeClass('d-none');
            $.each(data['personen'], function (index) {
                $("#aanpassenActiviteit input[name='personen[]'][value=" + data['personen'][index] + "]").attr("checked", true);
            });
            break;
        default:
            $('#aanpassenActiviteit #gebeurtenisnaam').attr('required', true);
            $('#aanpassenActiviteit form').attr('action', site_url + '/Trainer/Agenda/registreerActiviteit');
            var typeTraininId = data["typeTrainingId"] - 1;
            $('#aanpassenActiviteit #titel-form').removeClass('d-none');
            $('#aanpassenActiviteit input[name=reeksId]').attr('value', data['reeksId']);
            $('#aanpassenActiviteit #training-form').removeClass('d-none');
            $('#aanpassenActiviteit #tijdstip-form').removeClass('d-none');
            $('#aanpassenActiviteit #gebeurtenisnaam').attr('value', data['stageTitel']);
            $("#aanpassenActiviteit #soort option[value='" + typeTraininId + "']").attr("selected", "selected");
            $('#aanpassenActiviteit #personen-form').removeClass('d-none');
            $.each(data['personen'], function (index) {
                $("#aanpassenActiviteit input[name='personen[]'][value=" + data['personen'][index] + "]").attr("checked", true);
            });
            $('#aanpassenActiviteit #tabDatum').removeClass('d-none');
            if (data['reeksId'] === null) {
                $('#aanpassenActiviteit #begindatum').attr('required', true);
                $('#aanpassenActiviteit #einddatum').attr('required', true);
                $('#aanpassenActiviteit #tabDatum #reeks-tab').addClass('disabled');
                $('#aanpassenActiviteit #tabDatum #dag-tab').tab('show');
                $('#aanpassenActiviteit #tijdstip-form').removeClass('d-none');
                $('#aanpassenActiviteit #begindatum').datepicker('update', dateHelper_getDate(data['tijdstipStart']));
                $('#aanpassenActiviteit #einddatum').datepicker('update', dateHelper_getDate(data['tijdstipStop']));
                $("#aanpassenActiviteit #beginuur option[value='" + uren.indexOf(dateHelper_getTime(data['tijdstipStart'])) + "']").attr("selected", "selected");
                $("#aanpassenActiviteit #einduur option[value='" + uren.indexOf(dateHelper_getTime(data['tijdstipStop'])) + "']").attr("selected", "selected");
            } else {
                $('#aanpassenActiviteit #begindatumReeks').attr('required', true);
                $('#aanpassenActiviteit #einddatumReeks').attr('required', true);
                $('#aanpassenActiviteit #tabDatum #dag-tab').addClass('disabled');
                $('#aanpassenActiviteit #tabDatum #reeks-tab').tab('show');
                $('#aanpassenActiviteit #tijdstipReeks-form').removeClass('d-none');
                if (parseInt(data['reeksId']) < 0) {
                    $('#aanpassenActiviteit #begindatumReeks').datepicker('update', dateHelper_getDate(data['tijdstipStart']));
                    $('#aanpassenActiviteit #einddatumReeks').datepicker('update', dateHelper_getDate(data['tijdstipStop']));
                    $("#aanpassenActiviteit #beginuurReeks option[value='" + uren.indexOf(dateHelper_getTime(data['tijdstipStart'])) + "']").attr("selected", "selected");
                    $("#aanpassenActiviteit #einduurReeks option[value='" + uren.indexOf(dateHelper_getTime(data['tijdstipStop'])) + "']").attr("selected", "selected");
                    $('#aanpassenActiviteit input[name=reeksId]').attr('value', (data['reeksId'] * -1));
                    var weekdag = ["Zondag", "Maandag", "Dinsdag", "Woensdag", "Donderdag", "Vrijdag", "Zaterdag"];
                    var dagnaam = new Date(data['tijdstipStart']);
                    var dag = dagnaam.getDay();
                    $('.dagReeks').html((weekdag[dag]).toLowerCase());
                } else {
                    $('#aanpassenActiviteit #begindatumReeks').datepicker('update', dateHelper_getDate(data['reeks'][0]['tijdstipStop']));
                    $('#aanpassenActiviteit #einddatumReeks').datepicker('update', dateHelper_getDate(data['reeks'][data.reeks.length - 1]['tijdstipStop']));
                    $("#aanpassenActiviteit #beginuur option[value='" + uren.indexOf(dateHelper_getTime(data['tijdstipStart'])) + "'], #beginuurReeks option[value='" + uren.indexOf(dateHelper_getTime(data['tijdstipStart'])) + "']").attr("selected", "selected");
                    $("#aanpassenActiviteit #einduur option[value='" + uren.indexOf(dateHelper_getTime(data['tijdstipStop'])) + "'], #einduurReeks option[value='" + uren.indexOf(dateHelper_getTime(data['tijdstipStop'])) + "']").attr("selected", "selected");
                }
            }
            break;
    }
}

function toevoegenActiviteit() {
    var activiteit = $('#activiteitToevoegen option:selected').text();
    var startDate = $('#toevoegenActiviteit input[name=startDate]').attr('value');
    var endDate = $('#toevoegenActiviteit input[name=endDate]').attr('value');

    var startDate2 = new Date(startDate);
    var endDate2 = new Date(endDate);

    var startDatum = startDate2.getFullYear() + '-' + (startDate2.getMonth() + 1) + '-' + startDate2.getDate() + '%20' + (startDate2.getHours() - 2) + ':' + startDate2.getMinutes() + ':' + startDate2.getSeconds();
    var stopDatum = endDate2.getFullYear() + '-' + (endDate2.getMonth() + 1) + '-' + endDate2.getDate() + '%20' + (endDate2.getHours() - 2) + ':' + endDate2.getMinutes() + ':' + endDate2.getSeconds();

    var persoonId = $('#aanpassenActiviteit input[name=persoonSupplement]').attr('value');

    var linkActiviteit = '';
    switch (true) {
        case activiteit === "Wedstrijd":
            window.location.replace(site_url + '/Trainer/wedstrijden/index?pagina=aanpassen');
            linkActiviteit = 'wedstrijden/index?pagina=aanpassen';
            break;
        case activiteit === "Medische afspraak":
            linkActiviteit = 'agenda/toevoegenOnderzoek/' + persoonId;
            break;
        case activiteit === "Supplement":
            linkActiviteit = 'agenda/toevoegenSupplement/' + persoonId;
            break;
        case activiteit === "Training (reeks)":
            linkActiviteit = 'agenda/toevoegenActiviteit/true';
            break;
        default:
            linkActiviteit = 'agenda/toevoegenActiviteit/false';
            break;
    }
    $.post(site_url + '/trainer/' + linkActiviteit + '/' + startDatum + '/' + stopDatum,
            function (data) {
                //data = object van activiteit
                data = JSON.parse(data);

                //modal opvullen met object activiteit
                opvullenModalActiviteitAanpassen(data, 0, activiteit, site_url);
            }).fail(function () {
        alert("Er is iets misgelopen, neem contact op met de administrator.");
    });


    // modal openen met ingevulde gegevans van dit object
    $('#aanpassenActiviteit #deleteActiviteitButton').css('display', 'none');
    $('#aanpassenActiviteit #toevoegenActiviteitButtonContainer').removeClass('justify-content-between');
    $('#aanpassenActiviteit #toevoegenActiviteitButtonContainer').addClass('justify-content-right');
    $('#aanpassenActiviteit .modal-title').html(activiteit + ' toevoegen');
    $("#aanpassenActiviteit").modal('show');

}

function verwijderActiviteit(opgehaaldeId, activiteit) {
    if (!confirm("Zeker dat je dit wilt verwijderen?")) {
        return false;
    } else {
        var linkActiviteit = '';
        switch (true) {
            case activiteit === "Wedstrijd":
                linkActiviteit = 'verwijderWedstrijd';
                break;
            case activiteit === "Medische afspraak":
                linkActiviteit = 'verwijderOnderzoek';
                break;
            case activiteit === "Supplement":
                linkActiviteit = 'verwijderSupplement';
                break;
            default:
                linkActiviteit = 'verwijderActiviteit';
                break;
        }

        //id van activiteit
        var id = opgehaaldeId;
        // alert(id);
        //verwijderen
        $.post(site_url + '/Trainer/agenda/' + linkActiviteit + '/' + id,
                function (data) {
                    alert("Activiteit is verwijderd!");
                    location.reload();
                }).fail(function () {
            alert("Er is iets misgelopen, neem contact op met de administrator.");
        });
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
