jQuery(document).ready(function() {
  jQuery('.aristo select').uniform();
  jQuery('#home-publishing').hide();
  jQuery('#quickpost a').click(function() {jQuery('#home-publishing').slideToggle(); return false; })
});