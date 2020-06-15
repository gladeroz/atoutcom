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
    //console.log(d);
     // `d` is the original data object for the row
     return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
         '<tr>' +
             '<td><strong>Auteur Principal</strong></td>' +
             '<td>' + d.auteurPrincipal + '</td>' +
         '</tr>' +
         '<tr>' +
             '<td><strong>Email</strong></td>' +
             '<td>' + d.Email + '</td>' +
         '</tr>' +
         '<tr>' +
             '<td><strong>Pays</strong></td>' +
             '<td>' + d.Pays + '</td>' +
         '</tr>' +
         '<tr>' +
             '<td><strong>Ville</strong></td>' +
             '<td>' + d.Ville + '</td>' +
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
                         // iabstract_ajax_script_admin.ajaxurl is a variable that will contain the url to the ajax processing file
                         jQuery.post(iabstract_ajax_script_admin.ajaxurl, data, function(response) {
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

// Fonction pour deselectionner un abstract
function iabstract_unselected(entry_id, form_id, selected, actionClick) {
  if(actionClick ==="deselect"){
    var title ="De-sélection d\'un abstract";
    var content = "Vous confirmez la de-sélection de cet abstract ?";
    var text = "De-sélectionner";
  }

  if(actionClick ==="reselect"){
    var title ="Sélection d\'un abstract";
    var content = "Vous confirmez la Sélection de cet abstract ?";
    var text = "Sélectionner";
  }
  jQuery.confirm({
    theme: 'supervan',
    backgroundDismiss: false,
    backgroundDismissAnimation: 'shake',
    title: title,
    content: content+
          '<form action="" class="formName">' +
          '<div class="form-group">' +
          '<input type="hidden" name="entry_id" value="' + entry_id + '">' +
          '<input type="hidden" name="selected" value="' + selected + '">' +
          '<input type="hidden" name="form_id" value="' + form_id + '">' +
          '<input type="hidden" name="actionClick" value="' + actionClick + '">' +
          '</div>' +
          '</form>',
    buttons: {
               formSubmit: {
                   text: text,
                   btnClass: 'btn-blue',
                   action: function () {
                         var entry_id = this.$content.find('input[name="entry_id"]').val();
                         var form_id     = this.$content.find('input[name="form_id"]').val();
                         var selected_data    = this.$content.find('input[name="selected"]').val();
                         var actionClick    = this.$content.find('input[name="actionClick"]').val();
                         var data = {
                              action: 'iabstract_response',
                              switch_p: 'user_unselect',
                              entry_id: entry_id,
                              form_id: form_id,
                              selected: selected_data,
                              actionClick: actionClick,
                         };
                         // iabstract_ajax_script_admin.ajaxurl is a variable that will contain the url to the ajax processing file
                         jQuery.post(iabstract_ajax_script_admin.ajaxurl, data, function(response) {
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


// Fonction pour rejeter un abstract
function iabstract_rejected(entry_id, user_id, form_id, form_action) {
  var title ="Rejet d\'un abstract";
  var content = "Vous confirmez le rejet de cet abstract ?";
  var text = "Rejet";

  jQuery.confirm({
    theme: 'supervan',
    backgroundDismiss: false,
    backgroundDismissAnimation: 'shake',
    title: title,
    content: content+
          '<form action="" class="formName">' +
          '<div class="form-group">' +
          '<input type="hidden" name="entry_id" value="' + entry_id + '">' +
          '<input type="hidden" name="form_id" value="' + form_id + '">' +
          '<input type="hidden" name="user_id" value="' + user_id + '">' +
          '<input type="hidden" name="form_action" value="' + form_action + '">' +
          '</div>' +
          '</form>',
    buttons: {
               formSubmit: {
                   text: text,
                   btnClass: 'btn-blue',
                   action: function () {
                         var entry_id = this.$content.find('input[name="entry_id"]').val();
                         var form_id     = this.$content.find('input[name="form_id"]').val();
                         var form_action    = this.$content.find('input[name="form_action"]').val();
                         var user_id    = this.$content.find('input[name="user_id"]').val();
                         var data = {
                              action: 'iabstract_response',
                              switch_p: 'user_reject',
                              entry_id: entry_id,
                              form_id: form_id,
                              form_action: form_action,
                              user_id: user_id,
                         };
                         // iabstract_ajax_script_admin.ajaxurl is a variable that will contain the url to the ajax processing file
                         jQuery.post(iabstract_ajax_script_admin.ajaxurl, data, function(response) {
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

// Fonction pour rejeter un abstract
function iabstract_comment(entry_id, user_id, form_id) {
  //console.log(this);
  //var comment = $(this).find('textarea[name="comment"]').val();
  var comment = $(".com_"+entry_id).val();
  var title ="Enregistrement d\'un commentaire";
  var content = "Vous confirmez l'enregistrement de ce commentaire ?";
  var text = "Valider";

  jQuery.confirm({
    theme: 'supervan',
    backgroundDismiss: false,
    backgroundDismissAnimation: 'shake',
    title: title,
    content: content+
          '<form action="" class="formName">' +
          '<div class="form-group">' +
          '<input type="hidden" name="entry_id" value="' + entry_id + '">' +
          '<input type="hidden" name="form_id" value="' + form_id + '">' +
          '<input type="hidden" name="user_id" value="' + user_id + '">' +
          '<input type="hidden" name="comment" value="' + comment + '">' +
          '</div>' +
          '</form>',
    buttons: {
               formSubmit: {
                   text: text,
                   btnClass: 'btn-blue',
                   action: function () {
                         var entry_id = this.$content.find('input[name="entry_id"]').val();
                         var form_id     = this.$content.find('input[name="form_id"]').val();
                         var form_action    = this.$content.find('input[name="form_action"]').val();
                         var comment    = this.$content.find('input[name="comment"]').val();
                         var data = {
                              action: 'iabstract_response',
                              switch_p: 'user_comment',
                              entry_id: entry_id,
                              form_id: form_id,
                              user_id: user_id,
                              comment: comment,
                         };
                         // iabstract_ajax_script_admin.ajaxurl is a variable that will contain the url to the ajax processing file
                         jQuery.post(iabstract_ajax_script_admin.ajaxurl, data, function(response) {
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
    for (var note = 0; note <= iabstract_ajax_script_admin.iabstract_note_max; note++) {
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
                              note_max: iabstract_ajax_script_admin.iabstract_note_max,
                         };
                         // iabstract_ajax_script_admin.ajaxurl is a variable that will contain the url to the ajax processing file
                         jQuery.post(iabstract_ajax_script_admin.ajaxurl, data, function(response) {
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