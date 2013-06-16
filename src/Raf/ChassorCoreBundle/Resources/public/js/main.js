// Lien dynamique d'inscription
var _href = $('#lienInscription').attr('href'); 
$('input[id=codePromo]').change(function()
{ 
    $('#lienInscription').attr('href', _href + '-' + $('#codePromo').val().substr(0,6))
});

// validation formulaire inscription
// $(".fos_user_registration_register .submit").click(function(){
// 	$(".fos_user_registration_register").submit();
// });