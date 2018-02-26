$(document).ready(function(){
    $('#acd-form').submit(function() {
        if ($("input[name='file']")[0].value.trim().length > 0 || $("input[name='link']")[0].value.trim().length > 0) {
            return true;
        } else {
            alert('Vous devez entrer un lien ou sélectionner un fichier à télédécharger !');
            return false;
        }
    });
});