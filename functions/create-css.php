<?php
// Generate new CSS file 
require( dirname(__FILE__) . '/../../../../wp-load.php' );
if (!current_user_can('manage_options')) return _e('You don\'t have permission to do that.', 'youare');

$name = sanitize_key($_POST['n']);
$css = $_POST['c'];

file_put_contents(dirname(__FILE__).'/../'.$name.'.css', $css);
echo __('CSS file generated.', 'youare');