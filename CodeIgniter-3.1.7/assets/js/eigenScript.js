$(function () {

});

// wedstrijden starts
function wedstrijdOpslaan(actie) {

    var ok = true;
    var formToSubmit = '';
    //form valideren
    if (actie == "toevoegen") {
        $('#wedstrijdToevoegen #form-wedstrijd *').filter('input').each(function () {
            if ($(this).attr("required") && $(this).val() == "") {
                alert("niet alle velden zijn ingevuld");
                ok = false;
                return false;
            }
        });
        formToSubmit = "#wedstrijdToevoegen #form-wedstrijd";
    } else {
        $('#wedstrijdAanpassen #form-wedstrijd *').filter('input').each(function () {
            if ($(this).attr("required") && $(this).val() == "") {
                alert("niet alle velden zijn ingevuld");
                ok = false;
                return false;
            }
        });
        formToSubmit = "#wedstrijdAanpassen #form-wedstrijd";
    }

    //word uitgevoerd als alles ingevuld is
    if (ok) {
        $(formToSubmit).attr('action', site_url + '/Trainer/wedstrijden/opslaanWedstrijd/' + actie + '?pagina=aanpassen&afstanden=' + wedstrijdAfstanden + '&slagen=' + wedstrijdSlagen);
        wedstrijdAfstanden = [];
        wedstrijdSlagen = [];
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
        opvullenModalAanpassen(data);

    }).fail(function () {
        alert("Er is iets misgelopen, neem contact op met de administrator.");
    });


    // modal openen met ingevulde gegevans van dit object
    $("#wedstrijdAanpassen").modal()

}
function opvullenModalAanpassen(dataWedstrijd) {
    console.log(dataWedstrijd);
    // console.log(dataWedstrijd[0]["Naam"]);
    $('#wedstrijdAanpassen #wedstrijdID').attr("value", dataWedstrijd["ID"]);
    $('#wedstrijdAanpassen #titel-wedstrijd').val(dataWedstrijd["Naam"]);
    $('#wedstrijdAanpassen #datum-wedstrijdStart').attr("value", dataWedstrijd["DatumStart"]);
    $('#wedstrijdAanpassen #datum-wedstrijdStop').attr("value", dataWedstrijd["DatumStop"]);
    $('#wedstrijdAanpassen #locatie-wedstrijd').val(dataWedstrijd["Plaats"]);
    $('#wedstrijdAanpassen #programma-wedstrijd').val(dataWedstrijd["Programma"]);

}

//global variabel voor reeksen
var wedstrijdAfstanden = [];
var wedstrijdSlagen = [];
function addReeks() {
    wedstrijdAfstanden.push($('#afstand-wedstrijd').val());
    wedstrijdSlagen.push($('#slag-wedstrijd').val());
    console.log(wedstrijdAfstanden);
    console.log(wedstrijdSlagen);
}

//wedstrijden end

// zwemmer start
function popupZwemmerToevoegen() {
    $(".popup-dialog").css({"display": "none"});
    $(".popup-background").css({"display": "block"});
    $("#toevoegen").css({"display": "block"});
}

function popupZwemmerWijzigen() {
    $(".popup-dialog").css({"display": "none"});
    $(".popup-background").css({"display": "block"});
    $("#wijzigen").css({"display": "block"});
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
    $("#supplementAanpassen").modal()

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
    if (actie == "toevoegen") {
        $('#supplementToevoegen #form-supplement *').filter('input').each(function () {
            if ($(this).attr("required") && $(this).val() == "") {
                alert("Niet alle velden zijn ingevuld");
                ok = false;
                return false;
            }
        });
        formToSubmit = "#supplementToevoegen #form-supplement";
    } else {
        $('#supplementAanpassen #form-supplement *').filter('input').each(function () {
            if ($(this).attr("required") && $(this).val() == "") {
                alert("Niet alle velden zijn ingevuld");
                ok = false;
                return false;
            }
        });
        formToSubmit = "#supplementAanpassen #form-supplement";
    }

    //word uitgevoerd als alles ingevuld is
    if (ok) {
        $(formToSubmit).attr('action', site_url + '/Trainer/supplement/opslaanSupplement/' + actie);

        $(formToSubmit).submit();
    }

}

// supplement end