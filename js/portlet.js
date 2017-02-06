/* jQuery Cookie plugin */
jQuery.cookie=function(name,value,options){
  if(typeof value!='undefined'){
    options=options||{};
    
    if(value===null){
      value='';
      options.expires=-1;
    }
    var expires='';
    if(options.expires&&(typeof options.expires=='number'||options.expires.toUTCString)){
      var date;
      if(typeof options.expires=='number'){
        date=new Date();
        date.setTime(date.getTime()+(options.expires*24*60*60*1000));
      }else{
        date=options.expires;
      }
      expires='; expires='+date.toUTCString();
    }
    var path=options.path?'; path='+(options.path):'';
    var domain=options.domain?'; domain='+(options.domain):'';
    var secure=options.secure?'; secure':'';
    document.cookie=[name,'=',encodeURIComponent(value),expires,path,domain,secure].join('');
  }else{
    var cookieValue=null;
    if(document.cookie&&document.cookie!=''){
      var cookies=document.cookie.split(';');
      for(var i=0;i<cookies.length;i++){
        var cookie=jQuery.trim(cookies[i]);
        if(cookie.substring(0,name.length+1)==(name+'=')){
          cookieValue=decodeURIComponent(cookie.substring(name.length+1));
          break;
        }
      }
      }
    return cookieValue;
}
};

jQuery.fn.resetPortlet = function() {
  var positions = jQuery.cookie(portlets_position);
  if (positions) {
    positions = positions.split(',');
    for(var i=positions.length-1; i>=0; i--) {
      jQuery(this).prepend(jQuery('#'+positions[i]));
      jQuery('#'+positions[i]+' h2 span.ui-icon-minimize').removeClass('ui-icon-minimize').addClass('ui-icon-maximize');
    }
  }
}

var portlets_position = 'portlets_position';
jQuery(document).ready(function() {
  portlets_position = new Array();
  jQuery('#sidebar aside').each(function() {portlets_position.push(this.id.substr(0, 2));});
  portlets_position.sort();
  portlets_position = portlets_position.join('_');
  jQuery("#sidebar").resetPortlet();

  jQuery('#sidebar').data("default_positions", new Array());


  jQuery("#sidebar").sortable({
    connectWith: '#sidebar',
    cancel: 'aside.fixed',
    handle: 'h2',
    axis: 'y',
    placeholder: 'ui-state-highlight',
    forcePlaceholderSize: true,
      
    stop: function(event, ui) { 
        jQuery(".ui-icon-circle-arrow-n").removeClass('ui-icon-disabled');
        jQuery(".ui-icon-circle-arrow-s").removeClass('ui-icon-disabled');
        jQuery("#sidebar aside:not([class~=fixed]):not([class~=widget_search]):first h2 .ui-icon-circle-arrow-n").addClass('ui-icon-disabled');
        jQuery("#sidebar aside:not([class~=fixed]):not([class~=widget_search]):last h2 .ui-icon-circle-arrow-s").addClass('ui-icon-disabled');
      
        var ids='';
        jQuery("#sidebar aside").each(function() {ids += (ids!=''?',':'')+this.id});
console.log(portlets_position, ids);        
        jQuery.cookie(portlets_position, ids, {
        expires: 100, 
        path: "/"
      });
    }

  });

  jQuery("#sidebar aside").sortable({
    axis: 'y', 
    handle: 'span', 
    cancel: 'aside.fixed'
  }).find('aside:not([class~=fixed]):not([class~=widget_search])').prepend('<span class="ui-preicon ui-icon-grip-dotted-vertical"></span>');

  jQuery("#sidebar aside:not([class~=fixed]):not([class~=widget_search])")
  .find("h2")
  .prepend('<span class="ui-icon ui-icon-circle-arrow-s"></span><span class="ui-icon ui-icon-circle-arrow-n"></span>')
  .parent();
    
  jQuery("#sidebar aside h2 .ui-icon-triangle-1-s").click(function() {
    jQuery(this).toggleClass("ui-icon-triangle-1-s").toggleClass("ui-icon-triangle-1-e");
    jQuery(this).parents("h2").siblings().toggle();
  });
  jQuery("#sidebar aside:not([class~=fixed]):not([class~=widget_search]):first h2 .ui-icon-circle-arrow-n").addClass('ui-icon-disabled');
  jQuery("#sidebar aside:not([class~=fixed]):not([class~=widget_search]):last h2 .ui-icon-circle-arrow-s").addClass('ui-icon-disabled');
  jQuery("#sidebar aside:not([class~=fixed]):not([class~=widget_search]) h2 .ui-icon-circle-arrow-s").click(function() {
    var $this = jQuery(this);
    //console.log($this);    
    if (!$this.hasClass('ui-icon-disabled')) {
      var box = $this.parents('#sidebar aside');
      var next = box.next();
      var tt = parseInt(box.offset().top);
      var nt = parseInt(next.offset().top);
      var ttop = next.height()+parseInt(next.css('margin-bottom').replace(/px/, ''));
      var ntop = box.height()+parseInt(box.css('margin-bottom').replace(/px/, ''));
      box.animate({
        'top': '+'+ttop
      }, 1000);
      next.animate({
        'top': '-'+ntop
      }, 1000, function() {
        next.insertBefore(box);
        next.css('top', '0px');
        box.css('top', '0px');
        jQuery(".ui-icon-circle-arrow-n").removeClass('ui-icon-disabled');
        jQuery(".ui-icon-circle-arrow-s").removeClass('ui-icon-disabled');
        jQuery("#sidebar aside:not([class~=fixed]):not([class~=widget_search]):first h2 .ui-icon-circle-arrow-n").addClass('ui-icon-disabled');
        jQuery("#sidebar aside:not([class~=fixed]):not([class~=widget_search]):last h2 .ui-icon-circle-arrow-s").addClass('ui-icon-disabled');
        var ids='';
        jQuery("#sidebar aside").each(function() {ids += (ids!=''?',':'')+this.id; console.log(ids); });
        jQuery.cookie(portlets_position, ids, {
          expires: 100, 
          path: "/"
        });
      });
    }
  });
  jQuery("#sidebar aside:not([class~=fixed]):not([class~=widget_search]) h2 .ui-icon-circle-arrow-n").click(function() {
    var $this = jQuery(this);
    if (!$this.hasClass('ui-icon-disabled')) {
      var box = $this.parents('#sidebar aside');
      var prev = box.prev();
      var tt = parseInt(box.offset().top);
      var nt = parseInt(prev.offset().top);
      var ttop = prev.height()+parseInt(prev.css('margin-bottom').replace(/px/, ''));
      var ntop = box.height()+parseInt(box.css('margin-bottom').replace(/px/, ''));
      box.animate({
        'top': '-'+ttop
      }, 1000);
      prev.animate({
        'top': '+'+ntop
      }, 1000, function() {
        box.insertBefore(prev);
        prev.css('top', '0px');
        box.css('top', '0px');
        jQuery(".ui-icon-circle-arrow-n").removeClass('ui-icon-disabled');
        jQuery(".ui-icon-circle-arrow-s").removeClass('ui-icon-disabled');
        jQuery("#sidebar aside:not([class~=fixed]):not([class~=widget_search]):first h2 .ui-icon-circle-arrow-n").addClass('ui-icon-disabled');
        var ids='';
        jQuery("#sidebar aside").addClass('ui-icon-disabled').each(function() {ids += (ids!=''?',':'')+this.id});
        jQuery.cookie(portlets_position, ids, {
          expires: 100, 
          path: "/"
        });
      });
    }
  });

  jQuery("#sidebar aside:not([class~=fixed]):not([class~=widget_search]) h2 .ui-icon-wrench").click(function() {
    var h2 = jQuery(this).parent('h2');
    var next = h2.next();
    if (next.is('.settings')) {
      next.toggle();
    } else {
      h2.after('<div class="settings">Ahora mismo no hace nada</div>');
    }
  });

});
