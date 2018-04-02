$(function () {

});

// wedstrijden starts
function wedstrijdOpslaan(actie){

  var ok = true;
  var formToSubmit = '';
  //form valideren
  if (actie == "toevoegen") {
    $('#wedstrijdToevoegen #form-wedstrijd *').filter('input').each(function(){
      if($(this).attr("required") && $(this).val() == "" || typeof wedstrijdAfstanden == "undefined" || wedstrijdAfstanden == null || wedstrijdAfstanden.length == null || wedstrijdAfstanden.length <= 0){
        alert("niet alle velden zijn ingevuld");
        ok = false;
        return false;
      }
    });
    formToSubmit = "#wedstrijdToevoegen #form-wedstrijd";
  }
  else {
    $('#wedstrijdAanpassen #form-wedstrijd *').filter('input').each(function(){
      if($(this).attr("required") && $(this).val() == "" || typeof wedstrijdAfstanden == "undefined" || wedstrijdAfstanden == null || wedstrijdAfstanden.length == null || wedstrijdAfstanden.length <= 0){
        alert("niet alle velden zijn ingevuld");
        ok = false;
        return false;
      }
    });
    formToSubmit = "#wedstrijdAanpassen #form-wedstrijd";
  }

  //word uitgevoerd als alles ingevuld is
  if (ok) {
    $(formToSubmit).attr('action', site_url+'/Trainer/wedstrijden/opslaanWedstrijd/'+ actie +'?pagina=aanpassen&afstanden='+wedstrijdAfstanden+'&slagen='+wedstrijdSlagen);
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
    opvullenModalAanpassen(data, id);

    }).fail(function () {
        alert("Er is iets misgelopen, neem contact op met de administrator.");
    });

  // modal openen met ingevulde gegevens van dit object
  $("#wedstrijdAanpassen").modal()

}
function opvullenModalAanpassen(dataWedstrijd, wedstrijdID){
  console.log(dataWedstrijd);
  // console.log(dataWedstrijd[0]["Naam"]);
  $('#wedstrijdAanpassen #wedstrijdID').attr("value", dataWedstrijd["id"]);
  $('#wedstrijdAanpassen #titel-wedstrijd').val(dataWedstrijd["naam"]);
  $('#wedstrijdAanpassen #datum-wedstrijdStart').attr("value", dataWedstrijd["datumStart"]);
  $('#wedstrijdAanpassen #datum-wedstrijdStop').attr("value", dataWedstrijd["datumStop"]);
  $('#wedstrijdAanpassen #locatie-wedstrijd').val(dataWedstrijd["plaats"]);
  $('#wedstrijdAanpassen #programma-wedstrijd').val(dataWedstrijd["programma"]);

  //reeksen toevoegen
  wedstrijdAfstanden = [];
  wedstrijdSlagen = [];
  // 1st opvragen
  $.post(site_url+'/Trainer/wedstrijden/reeksenOpvragen/'+wedstrijdID, function(data){
    data = JSON.parse(data);
    console.log(data);
    // 2des invullen
    $("#wedstrijdAanpassen #reeksen tr").html("");
    data["afstandIDs"].forEach((a,index, array) => {
      data["slagIDs"].forEach((s,index2, array2) => {
        if (index == index2) {
          wedstrijdAfstanden.push(Object.keys(data["afstandIDs"][index]).toString());
          wedstrijdSlagen.push(Object.keys(data["slagIDs"][index]).toString());
          tijdelijk1.push(Object.keys(data["afstandIDs"][index]).toString());
          tijdelijk2.push(Object.keys(data["slagIDs"][index]).toString());
          $("#wedstrijdAanpassen #reeksen").append("<tr id='rowUpdate"+index+"'><td style='padding:10px 0;'>" + a[Object.keys(a)] + " " + s[Object.keys(s)] + "</td><td style='padding:10px 0;'>" +
          "<button type='button' class='btn-xs btn-danger btn-circle' id='verwijder"+a[Object.keys(a)]+s[Object.keys(s)]+"' onclick='verwijderReeksArrays("+"rowUpdate"+index+","+Object.keys(s)+","+Object.keys(a)+")' style='margin-left: 15px;'><i class='fas fa-trash-alt'></i></button></td></tr>");
        }
      });
    });
    console.log(wedstrijdAfstanden);
    console.log(wedstrijdSlagen);
  }).fail(function() {
    alert( "Er is iets misgelopen, neem contact op met de administrator." );
  });
}

function verwijderReeksArrays(trID,slag, afstand){
 // verwijder op combinatie, niet index
 console.log(trID);
 $.each(wedstrijdAfstanden, function( index, value ) {
   //eerste combinatie
   $.each(wedstrijdAfstanden, function( index2, value2 ) {

     if (wedstrijdAfstanden[index2] == afstand) {
       //eerste is al gelijk aan iets, 2de ook? (met zelfde index natuurlijk)
       if (wedstrijdSlagen[index2] == slag) {
         // als deze ook klopt dan bestaat reeks al.
         //verwijder deze index
         wedstrijdAfstanden.splice(index2, 1);
         wedstrijdSlagen.splice(index2, 1);
         tijdelijk1.splice(index2, 1);
         tijdelijk2.splice(index2, 1);
         console.log("-------------------------");
         console.log(wedstrijdAfstanden);
         console.log(wedstrijdSlagen);
         console.log("-------------------------");
         $(trID).html("");
         console.log("kom ik");
       }
     }

   });

 });
}

//global variabel voor reeksen
var wedstrijdAfstanden = [];
var wedstrijdSlagen = [];

var tijdelijk1 = [];
var tijdelijk2 = [];

function reeksToevoegen(){
  var ok = true;
  console.log(wedstrijdAfstanden);
  console.log(wedstrijdSlagen);
  //checken of de combinatie al bestaat ( zodat we geen dezelfde reeksen hebben)
  tijdelijk1.forEach((s,index) => {
    [$('#afstand-wedstrijd').val(), $('#slag-wedstrijd').val()].forEach((m,index2,array) => {
      console.log($('#afstand-wedstrijd').val());
      if (tijdelijk1[index] == m && tijdelijk2[index] == array[index2+1] ) {
          //zit de combinatie al in de reeks?
          ok = false;
        }

    });
  });


  if (ok) {
    tijdelijk1.push($('#afstand-wedstrijd').val());
    tijdelijk2.push($('#slag-wedstrijd').val());
    // $("#wedstrijdToevoegen #reeksen").append("<p>"+$('#afstand-wedstrijd option:selected').text()+" "+$('#slag-wedstrijd option:selected').text()+"</p>");
    $("#wedstrijdToevoegen #reeksen").append("<tr id='rowAdd"+$('#afstand-wedstrijd option:selected').val()+$('#slag-wedstrijd option:selected').val()+"'><td style='padding:10px 0;'>" + $('#afstand-wedstrijd option:selected').text() + " " + $('#slag-wedstrijd option:selected').text() + "</td><td style='padding:10px 0;'>" +
    "<button type='button' class='btn-xs btn-danger btn-circle' id='' onclick='verwijderReeksArrays("+"rowAdd"+$('#afstand-wedstrijd option:selected').val()+$('#slag-wedstrijd option:selected').val()+","+$('#slag-wedstrijd option:selected').val()+","+$('#afstand-wedstrijd option:selected').val()+")' style='margin-left: 15px;'><i class='fas fa-trash-alt'></i></button></td></tr>");
    wedstrijdAfstanden.push($('#afstand-wedstrijd').val());
    wedstrijdSlagen.push($('#slag-wedstrijd').val());
    console.log("-------------------------");
    console.log(tijdelijk1);
    console.log(tijdelijk2);
    console.log(wedstrijdAfstanden);
    console.log(wedstrijdSlagen);
    console.log("-------------------------");
  }
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
