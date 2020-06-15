// Javascript functions

jQuery( document ).ready(function($) {
	
});

function iabstract_format(d){
     // `d` is the original data object for the row
     return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
         '<tr>' +
             '<td><strong>Note des membres</strong></td>' +
             '<td><strong style="font-size: 1.2em;">' + d.NoteMoyenne + '</strong></td>' +
         '</tr>' +
         '<tr>' +
             '<td><strong>Abstract Structuré</strong></td>' +
             '<td style="text-align: left;">' + d.Abstract + '</td>' +
         '</tr>' +
     '</table>';  
}

function iabstract_selected(abstract_id, form_id, user_id) {
	jQuery.confirm({
		theme: 'supervan',
		backgroundDismiss: false,
		backgroundDismissAnimation: 'shake',
		title: 'Sélectionner cet abstract',
		content: 'Vous confirmez la sélection de cet abstract ?' +
          '<form action="" class="formName">' +
          '<div class="form-group">' +
          '<input type="hidden" name="user_id" value="' + user_id + '">' +
          '<input type="hidden" name="abstract_id" value="' + abstract_id + '">' +
          '<input type="hidden" name="form_id" value="' + form_id + '">' +
          '</div>' +
          '</form>',
		buttons: {
               formSubmit: {
                   text: 'Sélectionner',
                   btnClass: 'btn-blue',
                   action: function () {
                         var user_id     = this.$content.find('input[name="user_id"]').val();
                         var abstract_id = this.$content.find('input[name="abstract_id"]').val();
                         var form_id     = this.$content.find('input[name="form_id"]').val();
                         var data = {
                              action: 'iabstract_response',
                              switch_p: 'user_select',
                              user_id: user_id,
                              abstract_id: abstract_id,
                              form_id: form_id,
                         };
                         // iabstract_ajax_script.ajaxurl is a variable that will contain the url to the ajax processing file
                         jQuery.post(iabstract_ajax_script.ajaxurl, data, function(response) {
                              jQuery.confirm({
                                  boxWidth: '300px',
                                  useBootstrap: false,
                                  title: 'Confirmation',
                                  content: response,
                                  buttons: {
                                      ok: {
                                          text: 'OK',
                                          btnClass: 'btn-blue',
                                          action: function () {
                                              location.href = window.location.href;
                                          }
                                      },
                                  },
                              });
                         });

                   }
               },
               cancel: function () {
                   //text: ""
                   // no action - Close
               },
		}
	});
	return false;
}

function iabstract_note(abstract_id, form_id, user_id, first) {
	// Initialize
	var select     = "";
     var title_note = (first == 'Y') ? 'Notez cet abstract' : 'Renotez cet abstract';
     var title_text = (first == 'Y') ? 'Notez' : 'Renotez';
     var first_note = (first == 'Y') ? 'Y' : 'N';
	for (var note = 0; note <= iabstract_ajax_script.iabstract_note_max; note++) {
		select += '<option value="'+note+'">'+note+'</option>';
	}
	// Confirm
    jQuery.confirm({
		theme: 'supervan',
		backgroundDismiss: false,
          backgroundDismissAnimation: 'shake',
          title: title_note,
          content: '' +
          '<form action="" class="formName">' +
          '<div class="form-group">' +
          '<select class="user_note form-control" name="user_note" required>' + select + '</select>' +
          '<input type="hidden" name="user_id" value="' + user_id + '">' +
          '<input type="hidden" name="abstract_id" value="' + abstract_id + '">' +
          '<input type="hidden" name="form_id" value="' + form_id + '">' +
          '</div>' +
          '</form>',
          buttons: {
            formSubmit: {
                text: title_text,
                btnClass: 'btn-blue',
                action: function () {
                    var user_note   = this.$content.find('select[name="user_note"]').val();
                    var user_id     = this.$content.find('input[name="user_id"]').val();
                    var abstract_id = this.$content.find('input[name="abstract_id"]').val();
                    var form_id     = this.$content.find('input[name="form_id"]').val();
                    if (!user_note) {
						jQuery.alert({
							boxWidth: '300px',
							useBootstrap: false,
							title: "Notation de l'abstract",
							content: 'Vous devez indiquer une note'
						});
                        return false;
                    } else {
                         var data = {
                              action: 'iabstract_response',
                              switch_p: 'user_note',
                              user_note: user_note,
                              user_id: user_id,
                              abstract_id: abstract_id,
                              form_id: form_id,
                              first_note: first_note,
                              note_max: iabstract_ajax_script.iabstract_note_max,
                         };
                         // iabstract_ajax_script.ajaxurl is a variable that will contain the url to the ajax processing file
                         jQuery.post(iabstract_ajax_script.ajaxurl, data, function(response) {
                              jQuery.confirm({
                                  boxWidth: '300px',
                                  useBootstrap: false,
                                  title: 'Confirmation!',
                                  content: response,
                                  buttons: {
                                      ok: {
                                          text: 'OK',
                                          btnClass: 'btn-blue',
                                          action: function () {
                                              location.href = window.location.href;
                                          }
                                      },
                                  },
                              });
                         });
                    }
                }
            },
            cancel: function () {
               //text: ""
                // no action - Close
            },
          },
    });
	return false;
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