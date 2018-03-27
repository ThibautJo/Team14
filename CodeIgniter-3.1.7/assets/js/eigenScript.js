$(function(){

});

/*popup-dialog*/
$( ".popup-header > button, .popup-background" ).click(function() {
  if ($(this).attr("class") == "popup-background") {
    if (!confirm("Sluiten = verdwenen input")) {
      return false;
    }
  }
  $(".popup-background").css({"display":"none"});
  $(".popup-dialog").css({"display":"none"});
});


function wedstrijdToevoegen(){
  $(".popup-background").css({"display":"block"});
  $(".popup-dialog").css({"display":"block"});
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