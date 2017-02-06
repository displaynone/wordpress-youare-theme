jQuery('document').ready(function(){
  jQuery('#respond form').submit(function() {
    var $this = jQuery(this);
    var comment_parent = $this.find('input[name=comment_parent]').attr('value');
    jQuery.post(
      $this.attr('action'), 
      $this.serialize(),
      function(data) {
        if (comment_parent > 0) {
          var elem = null;
          if(jQuery('#comment-'+comment_parent+' ul.children').length > 0) {
            elem = jQuery(data).hide().appendTo('#comment-'+comment_parent+' ul.children').fadeIn('slow');
          } else {
            elem = jQuery('<ul class="children">'+data+'</ul>').hide().appendTo('#comment-'+comment_parent).fadeIn('slow');
          }
          var depth = elem.parents('#comment-'+comment_parent).find('div.comment:first').attr('class').match(/depth-(\d+)/);
          if (depth.length == 2) {
            elem.find('div.comment:first').removeClass('depth-1').addClass('depth-'+(parseInt(depth[1])+1)).attr('class');
          }
          if (data.match(/p class="alert"/)) {
            setTimeout(function() {jQuery('p.alert').fadeOut('slow');}, 5000);
          } else {
            $this.find('textarea').attr('value',"");
            // Reset form position
            var n = addComment, e = n.I("wp-temp-form-div"), o = n.I(n.respondId);
            if (!e || !o) {
              return;
            }
            n.I("comment_parent").value = "0";
            e.parentNode.insertBefore(o, e);
            e.parentNode.removeChild(e);
            this.style.display = "none";
            this.onclick = null;
          }
        } else {
          if (jQuery('#comments ol').length == 0) {
            jQuery('<ol></ol>').prependTo('#comments');
          }
          jQuery(data).hide().appendTo('#comments ol').fadeIn();
        }
      }
    );
    return false;
  });
});