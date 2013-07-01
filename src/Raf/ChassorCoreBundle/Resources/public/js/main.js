// Lien dynamique d'inscription
var _href = $('#lienInscription').attr('href'); 
$('input[id=codePromo]').change(function()
{ 
    $('#lienInscription').attr('href', _href + '-' + $('#codePromo').val().substr(0,6))
});

// tri des tableaux
$(document).ready(function() { $(".stupid").stupidtable(); });

// fonction de test d'existence
jQuery.fn.exists = function(){return this.length>0;}

// Affichge énoncé de l'énigme
$(".enigmeclose").hide();
$(".btnopenenigme").click(function(){
	if($(".enigmenotclose").exists()){
		$(".enigmenotclose").addClass("enigmeclose").removeClass("enigmenotclose").slideUp();
	}
	else{
		$(".enigmeclose").addClass("enigmenotclose").removeClass("enigmeclose").slideDown();
	}
	return false;
});

// Affichage "mauvaise réponse"
if($(".reponsebox .btnred").exists()){
	$(".reponsebox .submit").hide();
	$(".reponsebox .btnred").delay(3000).fadeOut(500, function(){
		$(".reponsebox .submit").fadeIn();
	});
}

// gestion messages chassor
$("#chassor_msg .close").click(function(){
	$("#chassor_msg").fadeOut();
});
$("#chassor_msg").click(function(){
	$("#chassor_msg").fadeOut();
});
$(".bottomClose").click(function(){
	$("#chassor_msg").fadeOut();
});

// ...
