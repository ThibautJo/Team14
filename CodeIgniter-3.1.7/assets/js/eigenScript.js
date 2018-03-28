$(function(){

});

/*popup-dialog*/
$( ".popup-header > button, .popup-background" ).click(function() {
  $(".popup-background").css({"display":"none"});
  $(".popup-dialog").css({"display":"none"});
});


function wedstrijdToevoegen(){
  $(".popup-dialog").css({"display":"none"});
  $(".popup-background").css({"display":"block"});
  $("#toevoegen").css({"display":"block"});
}

function wedstrijdUpdate(){


}
//global variabel voor reeksen
var wedstrijdAfstanden = [];
var wedstrijdSlagen = [];
function addReeks(){
  wedstrijdAfstanden.push($('#afstand-wedstrijd').val());
  wedstrijdSlagen.push($('#slag-wedstrijd').val());
  console.log(wedstrijdAfstanden);
  console.log(wedstrijdSlagen);
}
function wedstrijdOpslaan(){

  var ok = true;
  //form valideren
  $('#form-wedstrijd *').filter('input').each(function(){
    if($(this).val() == "" && $(this).attr("required")){
      alert("niet alle velden zijn ingevuld");
      ok = false;
      return false;
    }
  });

  //word uitgevoerd als alles ingevuld is
  if (ok) {
    $('#form-wedstrijd').attr('action', site_url+'/Trainer/wedstrijden/opslaanWedstrijd?pagina=aanpassen&afstanden='+wedstrijdAfstanden+'&slagen='+wedstrijdSlagen);
    wedstrijdReeksen = [];
    $('#form-wedstrijd').submit();
  }

}

function wedstrijdVerwijder(elementID){
  if (!confirm("Zeker dat je dit wilt verwijderen?")) {
    return false;
  }
  else{
    //id van wedstrijd
    var id = $("#"+elementID).val();
    // alert(id);
    //verwijderen
    $.post(site_url+'/Trainer/wedstrijden/verwijderWedstrijd/'+id, function(data){
      alert("Wedstrijd is verwijderd!");
      $("tr#"+id).remove();
    }).fail(function() {
      alert( "Er is iets misgelopen, neem contact op met de administrator." );
    });
  }
}

function popupZwemmerToevoegen(){
  $(".popup-dialog").css({"display":"none"});
  $(".popup-background").css({"display":"block"});
  $("#toevoegen").css({"display":"block"});
}

function popupZwemmerWijzigen(){
  $(".popup-dialog").css({"display":"none"});
  $(".popup-background").css({"display":"block"});
  $("#wijzigen").css({"display":"block"});
}