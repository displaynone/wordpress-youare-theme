<?php
require( dirname(__FILE__) . '/../../../../wp-load.php' );
if (!current_user_can('manage_options')) exit();
$default_css = file_get_contents(get_bloginfo('template_directory').'/'.get_option('Y_alt_stylesheet'));

$lines = explode("\n", $default_css);
$css = array();
$desc='';
foreach($lines as $l) {
  $l = trim($l);
  if (empty($l)) continue;
  preg_match('#/\*([^\*]+)\*/#', $l, $m);
  if (isset($m[1])) {
    $desc = $m[1];
    continue;
  }
  preg_match('#([^\{]+)\{([^\}]+)\}#', $l, $m);
  if (isset($m[1]) && isset($m[2])) {
    $style = new stdClass();
    $props = array();
    $stls = explode(';', $m[2]);
    foreach($stls as $s) {
      $e = explode(':', $s);
      if (isset($e[1])) {
        $p = new stdClass();
        $p->value = $e[1];
        $p->default = $e[1];
        $props[trim($e[0])] = $p;
      }
    }
    $style->desc = $desc;
    $style->selector = trim($m[1]);
    $style->properties = $props;
    $css[str_replace(' ', '_', preg_replace('#[^\w\s_]#', '', $desc))] = $style;
  }
}

echo 'var you_styles = '.json_encode($css).';';
?>
function draw_creator_window() {
  var form = '<select id="css-styles-selector">';
  for(var ele in you_styles) {
    form += '<option value="'+ele+'">'+you_styles[ele].desc+'</option>';
  }
  form += '</select>';
  var e = jQuery('<div style="z-index: 2000; position: fixed; text-align: center; width: 100%; font-weight: normal; "><div id="creator-div" style="display: none; background: rgba(200, 200, 200, 0.9); color: #000; text-shadow: 0 0; border-bottom: #666; width: 100%; padding: 20px 100px; text-align: left; font-size: 1.2em; "><p><strong><?php _e('This is a quick way to generate different designs. If you need something more complete you must create your own CSS file.', 'youare'); ?></strong></p><p><?php _e('Select a element:', 'youare'); ?> '+form+'</p><div id="creator-properties"></div><p><input type="button" id="save-css" value="<?php _e('Save css', 'youare'); ?>" /></p></div><div style="background: #666; color: #AAA; padding: 10px 20px; margin: 0 auto; width: 150px; opacity: 0.7; "><a href="#show_creator" style="color: #FFF; text-shadow: 0px 0px;"><?php _e('Show/Hide CSS creator', 'youare'); ?></a></div>').prependTo(document.body);
  jQuery('a[href$=show_creator]').click(function() {jQuery('#creator-div').toggle();});
  jQuery('#css-styles-selector').change(change_selector_properties);
  jQuery('#save-css').click(function() { var name = prompt('<?php _e('Write your new css name. Use only words, letters or _', 'youare'); ?>', jQuery('#colors-css').attr('href').replace('<?php echo get_bloginfo('template_directory').'/'; ?>', '').replace('.css', '')+'_2'); if (!name) return; jQuery.post('<?php echo get_bloginfo('template_directory').'/functions/create-css.php'; ?>', {n: name, c: generate_css(true)}, function(data) {alert(data);}); });
}

function change_selector_properties() {
  var e = jQuery('#css-styles-selector').val();
  var html = '<p><?php _e('Selector:', 'youare'); ?> <strong>'+you_styles[e].selector+'</strong></p>';
  html += '<p><?php _e('Properties', 'youare'); ?></p>';
  for(var p in you_styles[e].properties) {
    var id = (e+'WW'+p).replace(/\s/g, '_');
    var v = you_styles[e].properties[p].value;
    html += '<p><strong>'+p+'</strong> <input id="'+id+'" value="'+v+'" class="css_properties" type="text" style="float: none; padding: 2px 5px; " />';
    var c = v.match(/#[0-9A-F]{3,6}/i);
    if (c != null) html += ' <input  id="picker'+id+'" type="hidden" value="'+c+'" class="color_picker" />';
    html += '</p>';
  }

  jQuery('#creator-properties').html(html);
  jQuery("input.color_picker").miniColors({change: function(hex, rgb) { var e = jQuery('#'+this[0].id.replace('picker', '')); e.val(e.val().replace(/#[0-9A-F]{3,6}/i, hex)); e.change(); }});
  jQuery("input.css_properties").change(function() {var d = this.id.split('WW'); you_styles[d[0]].properties[d[1]].value = this.value; generate_css(false); });

}

function generate_css(echo) {
  jQuery('#generated-css').remove();
  var css='';
  for(var ele in you_styles) {
    css += '/*'+ele+'*/\n';
    css += you_styles[ele].selector+'{ ';
    for(var props in you_styles[ele].properties) {
      var v = you_styles[ele].properties[props].value;
      if (v.match(/url\(/) && !v.match(/url\(http:\/\//)) v = v.replace(/url\(/, 'url(<?php echo get_bloginfo('template_directory').'/'; ?>');
      css += props+':'+v+';';
    }
    css += '}\n\n';
  }
  if (echo) return css;
  var style = jQuery('<style type="text/css" id="generated-css" />').appendTo('head');
  style.html(css);

}

jQuery(document).ready(function() {draw_creator_window(); change_selector_properties(); });