<?php

if (!session_id())
  add_action('init', 'session_start');

// Adding extra shortcodes button into Tinymce editor
function you_extra_shortcodes_button() {
  if (!current_user_can('edit_posts') && !current_user_can('edit_pages'))
    return;
  if (get_user_option('rich_editing') == 'true') {
    add_filter('mce_external_plugins', 'you_add_extra_tinymce_plugin');
    //add_filter('mce_buttons', 'you_register_extra_button');
  }
  add_editor_style('js/tinymce/css/you_tinymce.css');
}
add_action('init', 'you_extra_shortcodes_button');

function you_editor_toolbar_css() {
        echo '<link rel="stylesheet" type="text/css" href="' .get_bloginfo('template_url') .'/js/tinymce/css/editor_toolbar.css'. '">';
}
add_action('admin_head', 'you_editor_toolbar_css');

function you_register_extra_button($buttons) {
  array_push($buttons, "|", "youextrashortcodes");
  return $buttons;
}

function you_add_extra_tinymce_plugin($plugin_array) {
  //$plugin_array['youextrashortcodes'] = get_bloginfo('template_url') . '/js/extra-shortcodes-plugin.js';
  $plugin_array['youtabletoggle'] = get_bloginfo('template_url') . '/js/table-toggle-plugin.js';
  $plugin_array['yousuccessmessage'] = get_bloginfo('template_url') . '/js/success-message-plugin.js';
  $plugin_array['youinfomessage'] = get_bloginfo('template_url') . '/js/info-message-plugin.js';
  $plugin_array['youalertmessage'] = get_bloginfo('template_url') . '/js/alert-message-plugin.js';
  $plugin_array['youerrormessage'] = get_bloginfo('template_url') . '/js/error-message-plugin.js';
  $plugin_array['you2cols'] = get_bloginfo('template_url') . '/js/2cols-plugin.js';
  $plugin_array['you3cols'] = get_bloginfo('template_url') . '/js/3cols-plugin.js';
  $plugin_array['yourightbquote'] = get_bloginfo('template_url') . '/js/right-bquote-plugin.js';
  $plugin_array['youintro'] = get_bloginfo('template_url') . '/js/intro-plugin.js';
  
  return $plugin_array;
}

function my_mce_before_init($init_array)
{
	// add classes using a ; separated values
  //$init_array['plugins'] .= ',table';
  $init_array['theme_advanced_styles'] = "Even row=even;Feature ready=yes";
	return $init_array;
}
add_filter('tiny_mce_before_init', 'my_mce_before_init');

// Adding tables
function you_mce_load_plugins($plugins) {
  $path = get_bloginfo('template_url');
//  $plugins["tabletoggle"] = $path . '/js/tinymce/plugins/tabletoggle/editor_plugin.js';
  $plugins["table"] = $path . '/js/tinymce/plugins/table/editor_plugin.js';

  return $plugins;
}
add_filter( 'mce_external_plugins', 'you_mce_load_plugins' );

function you_mce_buttons($buttons) {
  $buttons[] = 'yousuccessmessage';
  $buttons[] = 'youinfomessage';
  $buttons[] = 'youalertmessage';
  $buttons[] = 'youerrormessage';
  $buttons[] = '|';
  $buttons[] = 'you2cols';
  $buttons[] = 'you3cols';
  $buttons[] = '|';
  $buttons[] = 'youintro';
  $buttons[] = 'yourightbquote';
  $buttons[] = '|';
  $buttons[] = 'youtabletoggle';
  $buttons[] = 'tablecontrols';

  return $buttons;
}
add_filter( 'mce_buttons_3', 'you_mce_buttons');

