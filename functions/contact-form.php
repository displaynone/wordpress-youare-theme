<?php

if (!session_id())
  add_action('init', 'session_start');

// Contact form using shortcodes
function you_contact_form_shortcode($atts, $content = null) {
  extract(shortcode_atts(array("email" => ''), $atts));
  $_SESSION['you_contact_form_email'] = $email;
  $data = unserialize($_SESSION['you_post_data']);

  $html = '<div id="content-form" class="data">
     <form action="" method="post">'
          . ($_SESSION['you_contact_form_ok'] ? '<p class="success">' . $_SESSION['you_contact_form_ok'] . '</p>' : '')
          . ($_SESSION['you_contact_form_error'] ? '<p class="alert">' . implode('<br />', unserialize($_SESSION['you_contact_form_error'])) . '</p>' : '')
          . '<fieldset>
					<legend>' . __('Name*', 'youare') . '</legend>
					<input type="text" name="you_author" id="author" value="' . (isset($data['you_author']) ? $data['you_author'] : '') . '" tabindex="1">
				</fieldset>
       <fieldset>
					<legend>' . __('Email*', 'youare') . '</legend>
					<input type="text" name="you_email" id="you_email" value="' . (isset($data['you_email']) ? $data['you_email'] : '') . '" tabindex="2"> 
				</fieldset>
        <fieldset class="last">
					<legend>' . __('Subject*', 'youare') . '</legend>
					<input type="text" name="you_subject" id="you_subject" value="' . (isset($data['you_subject']) ? $data['you_subject'] : '') . '" tabindex="3">
				</fieldset>
        
      <fieldset id="contact_message" class="clear">
				<legend>' . __('Message*', 'youare') . '</legend>
				<textarea name="you_comment" id="you_comment" cols="50" rows="3" tabindex="4">' . (isset($data['you_comment']) && isset($data['you_contact_form_error']) ? $data['you_author'] : '') . '</textarea>
			</fieldset>
     
				<button type="submit" tabindex="5">' . __('Send', 'youare') . '</button>
        <input type="hidden" name="you_contact_form" value="true">
     		
    </form>
  </div>';
  unset($_SESSION['you_post_data']);
  unset($_SESSION['you_contact_form_ok']);
  unset($_SESSION['you_contact_form_error']);
  return $html;
}

// adding shortcode
add_shortcode('youcontactform', 'you_contact_form_shortcode');

// Adding contact form button into Tinymce editor
function you_contact_form_button() {
  if (!current_user_can('edit_posts') && !current_user_can('edit_pages'))
    return;
  if (get_user_option('rich_editing') == 'true') {
    add_filter('mce_external_plugins', 'you_add_contactform_tinymce_plugin');
    add_filter('mce_buttons', 'you_register_contact_button');
  }
}

add_action('init', 'you_contact_form_button');

function you_register_contact_button($buttons) {
  array_push($buttons, "|", "youcontactform");
  return $buttons;
}

function you_add_contactform_tinymce_plugin($plugin_array) {
  $plugin_array['youcontactform'] = get_bloginfo('template_url') . '/js/contact-form-plugin.js';
  return $plugin_array;
}

function you_refresh_mce($ver) {
  $ver += 3;
  return $ver;
}

add_filter('tiny_mce_version', 'you_refresh_mce');

// Processing contact form
add_action('init', 'you_contact_form_process');

function you_contact_form_process() {
  if (isset($_POST['you_contact_form'])) {
    $email_to = $_SESSION['you_contact_form_email'];
    $author = ( isset($_POST['you_author']) ) ? trim(strip_tags($_POST['you_author'])) : null;
    $email = ( isset($_POST['you_email']) ) ? trim(strip_tags($_POST['you_email'])) : null;
    $subject = ( isset($_POST['you_subject']) ) ? trim(strip_tags($_POST['you_subject'])) : null;
    $message = ( isset($_POST['you_comment']) ) ? trim(strip_tags($_POST['you_comment'])) : null;
    $error = array();
    if ($author == '')
      $error[] = __('Error: please fill the required field (name).', 'youare');
    if (!is_email($email))
      $error[] = __('Error: please enter a valid email address.', 'youare');
    if ($subject == '')
      $error[] = __('Error: please fill the required field (subject).', 'youare');
    if (!$email_to)
      wp_die(__('ERROR: Invalid Contact Form Session.', 'youare'));
    if (!empty($error)) {
      $_SESSION['you_contact_form_error'] = serialize($error);
    } else {
      require_once ABSPATH . WPINC . '/class-phpmailer.php';

      $mail_to_send = new PHPMailer();
      $mail_to_send->FromName = $author;
      $mail_to_send->From = $email;
      $mail_to_send->Subject = $subject;
      $mail_to_send->Body = $message;

      $mail_to_send->AddAddress($email_to); //contact form destination e-mail
      if (!$mail_to_send->Send())
        wp_die(__('Error: unable to send e-mail - status code: ', 'youare') . $mail_to_send->ErrorInfo);
      else
        $_SESSION['you_contact_form_ok'] = __('Your message has been sent. Thanks', 'youare');
    }
    $_SESSION['you_post_data'] = serialize($_POST);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
  }
}