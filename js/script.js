$('#btnSearch').click(function(){

var val = $('#inputSearch').val();
if (val === "") {
alert("le champ ne peut pas être vide");
return false;
}else {
  alert("vous allez rechercher" + val);
  return true;
}

});
