jQuery(document).keydown(function (e) {
  var keyCode = e.keyCode || e.which,
      arrow = {left: 37, up: 38, right: 39, down: 40 };
  var target = e.target.nodeName.toLowerCase();
  if (target != 'input' && target != 'textarea' ) {
    switch (keyCode) {
      case arrow.left:
        var e = jQuery('nav.pagination a.previous');
        if (e.length > 0) document.location = e.attr('href');
      break;
      case arrow.up:
        //..
      break;
      case arrow.right:
        var e = jQuery('nav.pagination a.next');
        if (e.length > 0) document.location = e.attr('href');
      break;
      case arrow.down:
        //..
      break;
    }
  }
});
