// Display customize layer
jQuery(document).ready(function() {
  jQuery('#switch_design a:eq(0)').click(function() { jQuery.cookie('you_customize_home', 'index_list', {expires: 100, path: "/" }); document.location = this.href; return false;});
  jQuery('#switch_design a:eq(1)').click(function() { jQuery.cookie('you_customize_home', 'index', {expires: 100, path: "/" }); document.location = this.href; return false; });
});

