<?php
if (get_option('twitter_username') && !get_option('Y_twitter'))
  update_option('Y_twitter', 'http://twitter.com/' . get_option('twitter_username'));

$themename = "YouAre Theme";
$shortname = "Y";
$theme_current_version = "1.4";
$theme_url = "http://desirity.com/youare/";



// Stylesheet Auto Detect
$alt_stylesheet_path = TEMPLATEPATH;

$alt_stylesheets = array();

if (is_dir($alt_stylesheet_path)) {
  if ($alt_stylesheet_dir = opendir($alt_stylesheet_path)) {
    while (($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false) {
      if (stristr($alt_stylesheet_file, '.css') !== false && $alt_stylesheet_file != 'style.css') {
        $alt_stylesheets[] = $alt_stylesheet_file;
      }
    }
  }
}

asort($alt_stylesheets);
array_unshift($alt_stylesheets, 'Select a stylesheet:');

$options = array();

add_action('init', 'you_init_options_theme');

function you_init_options_theme() {
  global $options, $themename, $shortname, $alt_stylesheets;
  $options = array(
      //COLOR THEME

/*      array("name" => __("Alternate Styles", 'youare'),
          "type" => "subhead"),
      array("name" => __("Alternate Theme Stylesheet", 'youare'),
          "desc" => __("<a style=\"padding: 5px 10px; background:#c60; color:#fff;border-radius: 3px; -moz-border-radius: 3px;-webkit-border-radius: 3px;\" href=\"#preview_css\">Preview</a> <br />Place additional theme stylesheets in the <code>themes/youare/</code> subdirectory to have them automatically detected.", 'youare'),
          "id" => $shortname . "_alt_stylesheet",
          "std" => "Select a stylesheet:",
          "type" => "select",
          "options" => $alt_stylesheets),
*/          
      // HOME DESIGN
      array("name" => __("Homepage Design", 'youare'),
          "type" => "subhead"),
      array("name" => __("Home template", 'youare'),
          "id" => $shortname . "_home_design",
          "desc" => __("Select the kind of homepage design you prefer.", 'youare'),
          "type" => "radio",
          "options" => array("index" => '<img src="' . get_bloginfo('template_directory') . '/images/icons/home_grid.png" /> ' . __('Grid (3 Columns). We recommend edit Settings > Reading (Show 3 posts)', 'youare'),
              "index_list" => '<img src="' . get_bloginfo('template_directory') . '/images/icons/home_list.png" /> ' . __('List. Traditional Homepage. We recommend edit Settings > Reading (Show 10 posts)', 'youare'))),
      //AUTHOR BOX
      array("name" => __("Author Box Sidebar", 'youare'),
          "type" => "subhead"),
      array("name" => __("About you (A brief description)", 'youare'),
          "id" => $shortname . "_about",
          "desc" => __("2 lines recommended. XHTML allowed. eg: I am founder of &lt;a href=\"http://domain.com\"&gt;Company Name&lt;/a&gt;, a creative web design agency based in London.", 'youare'),
          "type" => "textarea",
          "options" => array("rows" => "2",
              "cols" => "80")),
      //SOCIAL PROFILES. FOLLOW LINKS

      array("name" => __("Identity", 'youare'),
          "type" => "subhead"),
      array("name" => __("<a href=\"http://twitter.com/\">Twitter</a> (Username Only)", 'youare'),
          "id" => $shortname . "_twitter",
          "desc" => __("http://twitter.com/<strong>username</strong>", 'youare'),
          "type" => "text",
          "std" => "",
          "style" => "width: 300px",
          "row_style" => ""),
      array("name" => __("<a href=\"http://facebook.com/\">Facebook</a> (ID/Username Only)", 'youare'),
          "id" => $shortname . "_facebook",
          "desc" => __("http://facebook.com/<strong>id</strong>", 'youare'),
          "type" => "text",
          "std" => "",
          "style" => "width: 300px",
          "row_style" => ""),
      array("name" => __("<a href=\"http://plus.google.com/\">Google+</a> (ID/Username Only)", 'youare'),
          "id" => $shortname . "_googleplus",
          "desc" => __("https://plus.google.com/<strong>id</strong>", 'youare'),
          "type" => "text",
          "std" => "",
          "style" => "width: 300px",
          "row_style" => ""),
      array("name" => __("<a href=\"http://linkedin.com/\">Linkedin</a> (Username Only)", 'youare'),
          "id" => $shortname . "_linkedin",
          "desc" => __("http://linkedin.com/in/<strong>username</strong>", 'youare'),
          "type" => "text",
          "std" => "",
          "style" => "width: 300px",
          "row_style" => ""),
      // HEADER LOGO
      array("name" => __("Header Logo", 'youare'),
          "type" => "subhead"),
      array("name" => __("Your logo and favicon", 'youare'),
          "id" => $shortname . "_header_logo",
          "std" => "",
          "desc" => __('If you configure and SAVE your Twitter, Facebook or Google Plus account you will have more avatars to select from', 'youare'),
          "type" => "avatar"),
      // AUTHOR ID PAGE
      array("name" => __("Theme Pages", 'youare'),
          "type" => "subhead"),
      array("name" => __("Author/About Page", 'youare'),
          "id" => $shortname . "_author_page",
          "std" => "",
          "style" => "width: 200px",
          "type" => "page"),
      //PHOTO ABOUT/AUTHOR PAGE (Sidebar)
      array("name" => __("Your photo in the 'Author Page' (Sidebar)", 'youare'),
          "type" => "subhead"),
      array("name" => __("Photo URL", 'youare'),
          "id" => $shortname . "_photo_url_about",
          "desc" => __("eg: http://domain.com/photo.jpg. Image will be resized. <br />Tip: Place your image in the <code>/wp-content/themes/youare/images/sidebar</code> subdirectory and paste the URL of the photo", 'youare'),
          "std" => "",
          "type" => "text",
          "style" => "width: 425px"),
      // THUMBNAILS
      array("name" => __("Thumbnails sizes", 'youare'),
          "type" => "subhead"),
      array("name" => __("Modify/add thumbs sizes", 'youare'),
          "id" => $shortname . "_thumbs_size",
          "std" => array(
              'splash' => array(100, 100, true), 
              'list' => array(100, 100, true),
              'archive' => array(80, 80, true),
              'normal' => array(60, 60, true),
              'single' => array(325, 325, false)
            ),
          "desc" => __("There are different thumbs sizes used in the theme, you can modify them or add new ones", 'youare'),
          "type" => "thumbs"),
      // PUBLISH FORM
      array("name" => __("Quick Post Form", 'youare'),
          "type" => "subhead"),
      array("name" => __("Add new entries to your blog", 'youare'),
          "id" => $shortname . "_publish_form",
          "std" => "",
          "desc" => __("Show Publish Form to write a quick post without login to your WordPress dashboard", 'youare'),
          "type" => "checkbox"),
      //FOOTER PROMOTE YOUR COMPANY
      array("name" => __("Footer Promo", 'youare'),
          "type" => "subhead"),
      array("name" => __("Promote your company", 'youare'),
          "id" => $shortname . "_promo_footer",
          "desc" => __("I want to promote my company services in Footer.", 'youare'),
          "std" => "false",
          "type" => "checkbox"),
      array("name" => __("Company tag line or Featured work", 'youare'),
          "id" => $shortname . "_footer_tagline",
          "desc" => "",
          "type" => "text",
          "style" => "width: 677px",
          "row_style" => "background-color: #f1f1f1;"),
      array("name" => __("Company services", 'youare'),
          "id" => $shortname . "_footer_content",
          "desc" => __("XHTML required to look gorgeous, eg: &lt;p&gt;Company services in one line&lt;/p&gt;<br>", 'youare'),
          "std" => "",
          "type" => "textarea",
          "options" => array("rows" => "3",
              "cols" => "80")),
      //CUSTOM EXCERPT
      array("name" => __("Excerpt", 'youare'),
          "type" => "subhead"),
      array("name" => __("Excerpt length (in words)", 'youare'),
          "id" => $shortname . "_excerpt_length",
          "std" => "100",
          "type" => "text"),
      array("name" => __("Custom excerpt", 'youare'),
          "id" => $shortname . "_excerpt",
          "std" => __("read more...", 'youare'),
          "type" => "text"),
      array("name" => __("Default empty excerpt", 'youare'),
          "id" => $shortname . "_empty_excerpt",
          "std" => "",
          "desc" => __("Sometimes the posts doesn't have content, write what you want to show in these cases.", 'youare'),
          "type" => "textarea",
          "options" => array("rows" => "4",
              "cols" => "80")),
      //FOOTER CREDITS AND STATS CODE
      array("name" => __("Footer Credits / Stats Code", 'youare'),
          "type" => "subhead"),
      array("name" => __("Credits (Your name)", 'youare'),
          "id" => $shortname . "_copyright_name",
          "std" => __("Your Name Here", 'youare'),
          "type" => "text"),
      array("name" => __("Stats code", 'youare'),
          "id" => $shortname . "_stats_code",
          "desc" => __("Paste your Google Analytics (or other) tracking code here<br>", 'youare'),
          "std" => "",
          "type" => "textarea",
          "options" => array("rows" => "4",
              "cols" => "80")),
  );
}

// Adding admin menu option
function mytheme_add_admin() {

  global $themename, $shortname, $options;
  
  if (isset($_REQUEST['Y_thumbs_size'])) {
    $val = explode('$$', $_REQUEST['Y_thumbs_size']);
    $thumbs = array();
    foreach($val as $v) {
      if (!$v) break;
      $t = explode('#', $v);
      $thumbs[$t[0]] = array($t[1], $t[2], $t[3] == 'on');
    }
    $_REQUEST['Y_thumbs_size'] = $thumbs;
  
  }

  if (isset($_GET['page']) && $_GET['page'] == basename(__FILE__)) {

    if (isset($_REQUEST['action']) && 'save' == $_REQUEST['action']) {

      foreach ($options as $value) {
        update_option($value['id'], $_REQUEST[$value['id']]);
      }

      foreach ($options as $value) {
        if (isset($_REQUEST[$value['id']])) {
          update_option($value['id'], $_REQUEST[$value['id']]);
        } else {
          delete_option($value['id']);
        }
      }

      header("Location: themes.php?page=youare-admin.php&saved=true");
      die;
    } else if (isset($_REQUEST['action']) && 'reset' == $_REQUEST['action']) {

      foreach ($options as $value) {
        delete_option($value['id']);
      }

      header("Location: themes.php?page=youare-admin.php&reset=true");
      die;
    }
  }

  add_theme_page($themename . __(" Options", 'youare'), $themename . __(" Options", 'youare'), 'edit_themes', basename(__FILE__), 'mytheme_admin');
  add_theme_page(__("Refresh Thumbs", 'youare'), __("Refresh Thumbs", 'youare'), 'edit_themes', 'refresh-thumbnails.php', 'you_refresh_thumbs');
  
}

//add_theme_page($themename . 'Header Options', 'Header Options', 'edit_themes', basename(__FILE__), 'headimage_admin');

function headimage_admin() {
  
}

// Youare theme options
function mytheme_admin() {

  global $themename, $shortname, $options;

  if (isset($_REQUEST['saved']) && $_REQUEST['saved'])
    echo '<div id="message" class="updated fade"><p><strong>' . $themename . __(' settings saved.', 'youare') . '</strong></p></div>';
  if (isset($_REQUEST['reset']) && $_REQUEST['reset'])
    echo '<div id="message" class="updated fade"><p><strong>' . $themename . __(' settings reset.', 'youare') . '.</strong></p></div>';
  ?>
  <script type="text/javascript">
    jQuery(document).ready(function() {
      jQuery('a[href$=preview_css]').click(function() {this.target = '_blank'; this.href='/?css_creator=true&you_css='+jQuery('#Y_alt_stylesheet').val();})
    });
  </script>
  <div class="wrap">
    <h2 class="updatehook"><?php echo $themename . __(' Options', 'youare'); ?></h2>

    <table class="widefat" style="margin: 20px 0 0;">
      <thead>

        <tr>
          <th scope="col" style="width: 50%; font: 1.6em Baskerville, palatino, georgia, times, serif;"><?php _e('About YouAre Theme', 'youare'); ?></th>
          <th scope="col" style="font: 1.6em Baskerville, palatino, georgia, times, serif;"><?php _e('Support', 'youare'); ?></th>
        </tr>
      </thead>
      <tbody>
        <tr style="background: #f1f1f1; color: #222">
          <td><?php _e('YouAre Theme works in WordPress 3.3+ and is released under GPL License. This theme is designed and developed by <a href="http://desirity.com/">Desirity</a>. ', 'youare'); ?> 
          </td>
          <td><?php _e('We will not provide any support via email. If you have questions about using or extending this theme, the best resources are our <a href="http://themeforest.net/user/desirity/portfolio">ThemeForest\'s account</a> and <a href="http://wordpress.org/support/">WordPress Forums</a>.', 'youare'); ?>

          </td>

        </tr>
      </tbody>
    </table>

    <form method="post">

      <form method="post">


  <?php
  foreach ($options as $value) {

    switch ($value['type']) {
      case 'subhead':
        ?>
              </table>

              <hr style="border: 1px dotted #dfdfdf; margin: 20px 0">

              <table class="widefat">

                <thead>
                  <tr>
                    <th scope="col" style="width:20%" class="column-title"><?php echo $value['name']; ?></th>
                    <th scope="col"></th>
                  </tr>
                </thead>

        <?php
        break;

      case 'text':
        ?>
                <tr valign="top" style="<?php echo $value['row_style']; ?>"> 
                  <th scope="row"><?php echo $value['name']; ?>:</th>
                  <td>
                    <input style="<?php echo $value['style']; ?>" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if (get_option($value['id']) != "") {
          echo get_option($value['id']);
        } else {
          echo $value['std'];
        } ?>" />
        <?php echo $value['desc']; ?>
                  </td>
                </tr>
        <?php
        break;

              case 'thumbs':
        ?>
                <tr valign="top" style="<?php echo $value['row_style']; ?>"> 
                  <th scope="row"><?php echo $value['name']; ?>:</th>
                </tr>
                <tr><td>
                  <?php 
                    $thumbs = get_option($value['id'])? get_option($value['id']): $value['std'];
                  ?>
                    <table id="thumbs-options">
                      <tr><th><?php _e('Thumb ID', 'youare'); ?></th><th><?php _e('Width', 'youare'); ?></th><th> </th><th><?php _e('Height', 'youare'); ?></th><th><?php _e('Crop', 'youare'); ?></th><th> </th></tr>
                  <?php
                    foreach($thumbs as $t=>$v) {
                  ?>
                      <tr class="active"><td><input type="text" value="<?php echo $t; ?>" class="alpha" /></td><td><input type="text" value="<?php echo $v[0]; ?>" style="width: 50px" class="num" /></td><td>x</td><td><input type="text" value="<?php echo $v[1]; ?>" style="width: 50px" class="num" /></td><td><input type="checkbox" <?php echo $v[2]?'checked="checked"':''; ?> /></td><td><input type="button" value="<?php _e('Delete', 'youare'); ?>" class="del" /></td></tr>
                  <?php } ?>
                      <tr><td><input type="text" value="" class="alpha" /></td><td><input type="text" value="" style="width: 50px" class="num" /></td><td>x</td><td><input type="text" value="" style="width: 50px" class="num" /></td><td><input type="checkbox" /></td><td><input type="button" value="<?php _e('Add', 'youare'); ?>" class="add" /></td></tr>
                    </table>
                <p><?php _e('You must update thumbs for getting new image sizes', 'youare'); ?> <a href="<?php echo get_admin_url(); ?>themes.php?page=refresh-thumbnails.php" target="_blank" style="padding: 5px 10px; background:#c60; color:#fff;border-radius: 3px; -moz-border-radius: 3px;-webkit-border-radius: 3px;"><?php _e('Update', 'youare'); ?></a></p>
                <input type="hidden" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" />
                <script type="text/javascript">
                  jQuery('#thumbs-options').on('change', 'input', function() {
                    change_thumbs_option();
                  }).on('change', 'input.alpha', function() {
                    this.value = this.value.replace(/\s/, '-').replace(/[^a-z0-9_\-]/ig, '');
                  }).on('change', 'input.num', function() {
                    this.value = this.value.replace(/[^0-9]/ig, '');
                  }).on('click', 'input.add', function() {
                    jQuery(this)
                      .attr('value', '<?php _e('Delete', 'youare'); ?>')
                      .attr('class', 'del')
                      .parents('tr:first').addClass('active')
                      .parent().append('<tr><td><input type="text" value="" class="alpha" /></td><td><input type="text" value="" style="width: 50px" class="num" /></td><td>x</td><td><input type="text" value="" style="width: 50px" class="num" /></td><td><input type="checkbox" /></td><td><input type="button" value="<?php _e('Add', 'youare'); ?>" class="add" /></td></tr>');
                    change_thumbs_option();
                  }).on('click', 'input.del', function() {
                    jQuery(this).parents('tr:first').fadeOut('slow', function(){jQuery(this).remove()});
                    change_thumbs_option();
                  });
                  function change_thumbs_option() {
                    var val = '';
                    var ok = true;
                    jQuery('#thumbs-options tr.active input').each(function() {
                      var $this = jQuery(this);
                      if (ok) {
                        if ($this.val() == '') {
                          ok = false;
                        } else {
                          if ($this.attr('type') != 'button') {
                            val += ($this.attr('type') == 'checkbox' ? ($this.is(':checked')?'on':'off'):$this.val())+'#';
                            if ($this.attr('type') == 'checkbox') {
                              val += '$$';
                            }
                          }
                        }
                      }
                    });
                  
                    val = val.match(/(([^\$]+\$\$)+)/);
                    val = val[0];
                    jQuery('#Y_thumbs_size').val(val);
                  }
                </script>                
                  </td>
                </tr>
        <?php
        break;

      case 'select':
        ?>
                <tr valign="top"> 
                  <th scope="row"><?php echo $value['name']; ?>:</th>
                  <td>
                    <select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
              <?php foreach ($value['options'] as $option) { ?>
                        <option<?php if (get_option($value['id']) == $option) {
            echo ' selected="selected"';
          } elseif ($option == $value['std']) {
            echo ' selected="selected"';
          } ?>><?php echo $option; ?></option>
        <?php } ?>
                    </select>
        <?php echo $value['desc']; ?>
                  </td>
                </tr>
        <?php
        break;

      case 'textarea':
        $ta_options = $value['options'];
        ?>
                <tr valign="top"> 
                  <th scope="row"><?php echo $value['name']; ?>:</th>
                  <td>
                <?php echo $value['desc']; ?>
                    <textarea name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" cols="<?php echo $ta_options['cols']; ?>" rows="<?php echo $ta_options['rows']; ?>"><?php
        if (get_option($value['id']) != "") {
          echo stripslashes(get_option($value['id']));
        } else {
          echo $value['std'];
        }
                ?></textarea>
                  </td>
                </tr>
                <?php
                break;

              case "radio":
                ?>
                <tr valign="top"> 
                  <th scope="row"><?php echo $value['name']; ?>:</th>
                  <td><?php if (isset($value['desc'])) { ?><p><?php echo $value['desc']; ?></p><?php } ?>
                      <?php
                      foreach ($value['options'] as $key => $option) {
                        $radio_setting = get_option($value['id']);
                        if ($radio_setting != '') {
                          if ($key == get_option($value['id'])) {
                            $checked = "checked=\"checked\"";
                          } else {
                            $checked = "";
                          }
                        } else {
                          if ($key == $value['std']) {
                            $checked = "checked=\"checked\"";
                          } else {
                            $checked = "";
                          }
                        }
                        ?>
                      <input type="radio" name="<?php echo $value['id']; ?>" value="<?php echo $key; ?>" <?php echo $checked; ?> /><?php echo $option; ?><br />
                      <?php } ?>
                  </td>
                </tr>
                      <?php
                      break;

                    case "checkbox":
                      ?>
                <tr valign="top"> 
                  <th scope="row"><?php echo $value['name']; ?>:</th>
                  <td>
                <?php
                if (get_option($value['id'])) {
                  $checked = "checked=\"checked\"";
                } else {
                  $checked = "";
                }
                ?>
                    <input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />

                    <?php echo $value['desc']; ?>
                  </td>
                </tr>
                    <?php
                    break;

                  case "cats_ids":
                    ?>
                <tr valign="top"> 
                  <th scope="row"><?php echo $value['name']; ?>:</th>
                  <td>
                    <p>	<?php
            $pages = get_pages('depth=1&orderby=ID&hide_empty=0');
            //print_r($pages);
            echo __('<strong>Page IDs and Names</strong> (<em>Archives Page</em> you can\'t exclude). <a href="http://wptheme.youare.com/wp-content/themes/youare/images/screenshot_archives_page.png">How to make an archives page</a>.<br />', 'youare');
            foreach ($pages as $page) {
              echo $page->ID . ' = ' . $page->post_name . '<br />';
            }
                    ?>
                    </p>
                  </td>
                </tr>
                    <?php
                    break;

                  case "page":
                    ?>
                <tr valign="top">
                  <th scope="row"><?php echo $value['name']; ?>:</th>
                  <td>
                    <?php wp_dropdown_pages('name=' . $value['id'] . '&selected=' . (get_option($value['id']) != "" ? get_option($value['id']) : $value['std'])); ?>
                  </td>
                </tr>
                <?php
                break;

              case "avatar":
                $val = get_option($value['id']);
                ?>
                <tr valign="top">
                  <th scope="row"><?php echo $value['name']; ?>:</th>
                  <td><p><?php echo $value['desc']; ?></p>
                    <div style="float:left; margin-right: 40px"><input type="radio" name="<?php echo $value['id']; ?>" value="gravatar" <?php if ($val == 'gravatar' || !$val) {
          echo 'checked="checked"';
        } ?>/> Gravatar <br /><?php echo get_avatar(get_option('admin_email'), '60'); ?> </div>   
                      <?php
                      if (get_option('Y_twitter')) {
                        ?>
                      <div style="float:left; margin-right: 40px"><input type="radio" name="<?php echo $value['id']; ?>" value="twitter" <?php if ($val == 'twitter') {
                echo 'checked="checked"';
              } ?>/> Twitter <br /><img width="60" height="60" src="http://api.twitter.com/1/users/profile_image/<?php echo get_option('Y_twitter'); ?>.json?size=bigger" /> </div>
          <?php
        }
        if (get_option('Y_facebook')) {
          ?>
                      <div style="float:left; margin-right: 40px"><input type="radio" name="<?php echo $value['id']; ?>" value="facebook" <?php if ($val == 'facebook') {
            echo 'checked="checked"';
          } ?>/> Facebook <br /> <img width="60" height="60" src="https://graph.facebook.com/<?php echo get_option('Y_facebook'); ?>/picture" /> </div>

          <?php
        }
        if (get_option('Y_googleplus')) {
          ?>
                      <div style="float:left; margin-right: 40px"><input type="radio" name="<?php echo $value['id']; ?>" value="googleplus" <?php if ($val == 'googleplus') {
            echo 'checked="checked"';
          } ?> /> Google Plus <br /><img src="http://profiles.google.com/s2/photos/profile/<?php echo get_option('Y_googleplus'); ?>?sz=60" /> </div>

                  <?php
                }
                ?>
                    <div style="float:left; margin-right: 40px"><input type="radio" name="<?php echo $value['id']; ?>" value="" id="your_own_picture" <?php if (!in_array($val, array('gravatar', 'twitter', 'facebook', 'googleplus')) && $val) {
          echo 'checked="checked"';
        } ?>/> <?php _e('Your own picture (Size: 60x60px)', 'youare'); ?> <br />URL: <input type="text" value="<?php echo (!in_array($val, array('gravatar', 'twitter', 'facebook', 'googleplus')) && $val) ? $val : ''; ?>" onKeyUp="document.getElementById('your_own_picture').checked = 'checked'; document.getElementById('your_own_picture').value = this.value"  onChange="document.getElementById('your_own_picture').checked = 'checked'; document.getElementById('your_own_picture').value = this.value" />
                    </div>
                  </td></tr>
                    <?php
                    break;


                  default:

                    break;
                }
              }
              ?>

        </table>

        <p class="submit">
          <input name="save" type="submit" value="<?php _e('Save changes', 'youare'); ?>" />    
          <input type="hidden" name="action" value="save" />
        </p>
      </form>
      <form method="post">
        <p class="submit">
          <input name="reset" type="submit" value="<?php _e('Reset', 'youare'); ?>" />
          <input type="hidden" name="action" value="reset" />
        </p>
      </form>
          <?php
        }

        function option_wrapper_header($values) {
          ?>
      <tr valign="top"> 
        <th scope="row"><?php echo $values['name']; ?>:</th>
        <td>
  <?php
}

function option_wrapper_footer($values) {
  ?>
          <br />
  <?php echo $values['desc']; ?>
        </td>
      </tr>
  <?php
}

function option_wrapper_footer_nobreak($values) {
  ?>
      <?php echo $values['desc']; ?>
      </td>
      </tr>
      <?php
    }

    add_action('admin_menu', 'mytheme_add_admin');

    
