var you_resize_grid = function() {
  var max = new Array();
  var cont = 0;
  jQuery('.fourcol').height('');
  jQuery('.fourcol').each(function() {var pos = parseInt(cont/3); if(max.length == pos) {max[pos] = 0;} max[pos] = Math.max(max[pos], jQuery(this).height()); cont++;  });
  cont = 0;
  jQuery('.fourcol').each(function() {var pos = parseInt(cont/3); if(max.length == pos) {max[pos] = 0;} jQuery(this).height(max[pos]); cont++; });
};

jQuery(window).load(you_resize_grid);
jQuery(window).resize(you_resize_grid);
