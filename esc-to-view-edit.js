/*global escToViewEdit */
jQuery(function($) {
  $('body').keydown(function( event ) {
    if(event.which === 27) {
      if(escToViewEdit.url) {
        window.location.href = escToViewEdit.url;
      }
    }
  });
});
