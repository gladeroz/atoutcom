// Javascript ADMIN functions

function iabstract_confirm_delete(txt) {
    var r = confirm("Suppression de " + txt);
    if (r == true) {
        return true;
    } else {
        return false;
    }
}

function rtrim (str, charlist) {
    //  discuss at: http://locutus.io/php/rtrim/
    // original by: Kevin van Zonneveld (http://kvz.io)
    //    input by: Erkekjetter
    //    input by: rem
    // improved by: Kevin van Zonneveld (http://kvz.io)
    // bugfixed by: Onno Marsman (https://twitter.com/onnomarsman)
    // bugfixed by: Brett Zamir (http://brett-zamir.me)
    //   example 1: rtrim('    Kevin van Zonneveld    ')
    //   returns 1: '    Kevin van Zonneveld'
    charlist = !charlist ? ' \\s\u00A0' : (charlist + '').replace(/([[\]().?/*{}+$^:])/g, '\\$1');
    var re = new RegExp('[' + charlist + ']+$', 'g');
    return (str + '').replace(re, '');
}

function iabstract_format(d){
    
     // `d` is the original data object for the row
     return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
         '<tr>' +
             '<td><strong>Auteur Principal</strong></td>' +
             '<td>' + d.auteurPrincipal + '</td>' +
         '</tr>' +
         '<tr>' +
             '<td><strong>Titre de l\'Abstract</strong></td>' +
             '<td>' + d.titreAbstract + '</td>' +
         '</tr>' +
         '<tr>' +
             '<td><strong>Abstract Structuré</strong></td>' +
             '<td>' + d.Abstract + '</td>' +
         '</tr>' +
         '<tr>' +
             '<td><strong>Note des membres</strong></td>' +
             '<td>' + d.Members + '</td>' +
         '</tr>' +
     '</table>';  
}