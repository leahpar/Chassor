// Lien dynamique d'inscription
var _href = $('#lienInscription').attr('href'); 
$('input[id=codePromo]').change(function()
{ 
    $('#lienInscription').attr('href', _href + '-' + $('#codePromo').val().substr(0,6))
});

// tri des tableaux
$(document).ready(function() { $(".stupid").stupidtable(); });

// affichage enigmes
jQuery.fn.exists = function(){return this.length>0;}
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