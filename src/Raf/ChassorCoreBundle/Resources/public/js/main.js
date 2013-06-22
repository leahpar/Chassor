// Lien dynamique d'inscription
var _href = $('#lienInscription').attr('href'); 
$('input[id=codePromo]').change(function()
{ 
    $('#lienInscription').attr('href', _href + '-' + $('#codePromo').val().substr(0,6))
});

// tri des tableaux
$(document).ready(function() { $(".stupid").stupidtable(); });
