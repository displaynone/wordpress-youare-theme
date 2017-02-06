<?php



// Updating sidebar options
function you_sidebar_action($theme) {
  if (isset($_POST['you_sidebar']) && isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && $_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest") {
    require( dirname(__FILE__) . '/../../../../wp-load.php' );
    global $current_user;
    if ($current_user->caps["administrator"]) {
      $sidebar_id = $_POST['sidebar_id'];
      if (isset($_POST['visible'])) {
        update_option('sidebar_visible_' . $sidebar_id, $_POST['visible']);
      }
      $sidebar_data['posts'] = isset($_POST['posts']);
      $sidebar_data['categories'] = isset($_POST['categories']);
      $sidebar_data['allpages'] = isset($_POST['allpages']);
      $sidebar_data['pages'] = array();
      $sidebar_data['cats'] = array();
      foreach ($_POST as $k => $v) {
        if (preg_match('/page_/', $k))
          $sidebar_data['pages'][] = str_replace('page_', '', $k);
        if (preg_match('/cat_/', $k))
          $sidebar_data['cats'][] = str_replace('cat_', '', $k);
      }
      update_option("sidebar_" . $sidebar_id, $sidebar_data);
    }
  } else {
    // Widgets Sidebar
    if (function_exists('register_sidebar_widget')) {

      register_sidebar(array(
          'name' => __('Author Sidebar', 'youare'),
          'id' => 'sidebar-author',
          'description' => __('Sidebar for the author page', 'youare'),
          'before_widget' => '<aside id="%1$s" class="widget %2$s">',
          'after_widget' => '</aside>',
          'before_title' => '<h2 class="widgettitle">',
          'after_title' => '</h2>',
          'exclusive' => false,
          'visible' => true,
          'pageable' => true
      ));
      register_sidebar(array(
          'name' => __('Main Sidebar', 'youare'),
          'id' => 'sidebar-main',
          'description' => __('Main sidebar for all the pages', 'youare'),
          'before_widget' => '<aside id="%1$s" class="widget %2$s">',
          'after_widget' => '</aside>',
          'before_title' => '<h2 class="widgettitle">',
          'after_title' => '</h2>',
          'exclusive' => false,
          'visible' => true
      ));
      register_sidebar(array(
          'name' => __('Archives Index Page Sidebar', 'youare'),
          'id' => 'sidebar-archives',
          'before_widget' => '<aside id="%1$s" class="widget %2$s">',
          'after_widget' => '</aside>',
          'before_title' => '<h2 class="widgettitle">',
          'after_title' => '</h2>',
          'exclusive' => true,
          'visible' => true
      ));

      $you_installed_widgets = get_option('you_installed_widgets');
      global $wp_widget_factory;
      if (isset($wp_widget_factory->widgets["You_About_Box"]) && !$you_installed_widgets) {
        // Theme not instaled, setting to not configurated
        update_option('you_installed_widgets', 1);
        global $wp_registered_sidebars;
        foreach ($wp_registered_sidebars as $k => $side) {
          update_option('sidebar_visible_' . $k, 'true');
        }
        // Default widgets
        retrieve_widgets();
        global $sidebars_widgets;
        $sidebars_widgets["sidebar-author"][] = "author-pic-widget-13";
        $sidebars_widgets["sidebar-author"][] = "follow-links-widget-13";
        $sidebars_widgets["sidebar-main"][] = "search-13";
        $sidebars_widgets["sidebar-main"][] = "single-category-list-widget-13";
        $sidebars_widgets["sidebar-main"][] = "about-box-widget-13";
        $sidebars_widgets["sidebar-main"][] = "rss-links-widget-13";
        $sidebars_widgets["sidebar-main"][] = "ads-boxes-widget-13";
        $sidebars_widgets["sidebar-archives"][] = "about-box-widget-13";
        $sidebars_widgets["sidebar-archives"][] = "poptags-widget-13";
        $sidebars_widgets["sidebar-archives"][] = "popcat-widget-13";
        //$ss["sidebar-main"][] = "categories-13";
        //$ss["sidebar-main"][] = "monthly-archives-widget-13";
        wp_set_sidebars_widgets($sidebars_widgets);
        // Author Pic
        $ss = get_option('widget_author-pic-widget', array());
        $ss[13] = array("title" => "", "picture" => get_bloginfo('template_directory') . "/images/sidebar/photo_default_about.jpg", "show_social" => NULL);
        update_option('widget_author-pic-widget', $ss);
        // Follow Links
        $ss = get_option('widget_follow-links-widget', array());
        $ss[13] = array('show_twitter' => 'on', 'show_facebook' => 'on', 'show_googleplus' => 'on', 'show_linkedin' => 'on');
        update_option('widget_follow-links-widget', $ss);
        // Search
        $ss = get_option('widget_search', array());
        $ss[13] = array("title" => "");
        update_option('widget_search', $ss);
        // Single Catgegoriy List
        $ss = get_option('widget_single-category-list-widget', array());
        $ss[13] = array();
        update_option('widget_single-category-list-widget', $ss);
        // About Box
        $ss = get_option('widget_about-box-widget', array());
        $ss[13] = array('title' => __('About the author', 'youare'), 'show_links' => true);
        update_option('widget_about-box-widget', $ss);
        // RSS Links
        $ss = get_option('widget_rss-links-widget', array());
        $ss[13] = array();
        update_option('widget_rss-links-widget', $ss);
        // Ads boxes
        $ss = get_option('widget_ads-boxes-widget', array());
        $ss[13] = array();
        update_option('widget_ads-boxes-widget', $ss);
        // RSS Links
        $ss = get_option('widget_poptags-widget', array());
        $ss[13] = array('taglist_title' => __('Tags', 'youare'), 'taglist_limit' => 10);
        update_option('widget_poptags-widget', $ss);
        // Ads boxes
        $ss = get_option('widget_popcat-widget', array());
        $ss[13] = array('catlist_title' => __('Topics', 'youare'), 'catlist_limit' => 10);
        update_option('widget_popcat-widget', $ss);
        // Categories
        //$ss = get_option('widget_categories', array());
        //$ss[13] = array('title'=>__('Topics', 'youare'), 'hierarchical'=>'on', 'counter'=>'on');
        //update_option('widget_categories', $ss);
        // Monthly Archives
        //$ss = get_option('widget_monthly-archives-widget', array());
        //$ss[13] = array();
        //update_option('widget_monthly-archives-widget', $ss);

        update_option('sidebar_visible_sidebar-author', "true");
        update_option('sidebar_visible_sidebar-main', "true");
        update_option('sidebar_visible_sidebar-archives', "true");
        $sidebar_data['posts'] = true;
        $sidebar_data['categories'] = true;
        $sidebar_data['allpages'] = true;
        $sidebar_data['pages'] = array();
        $sidebar_data['cats'] = array();
        update_option('sidebar_sidebar-main', $sidebar_data);
        update_option('Y_modify_excerpt', true);
        update_option('Y_excerpt_length', 100);
        update_option('Y_publish_form', true);
        $you_installed_widgets = 1;
      }

      switch ($you_installed_widgets) {
        case 1:
          add_action('admin_notices', 'you_admin_help');
          break;
      }

      add_action('admin_enqueue_scripts', 'you_admin_sidebar_widgets');

      function you_admin_sidebar_widgets() {
        wp_register_script('you_admin_widgets', get_bloginfo('template_directory') . '/js/admin_widgets.js.php');
        wp_enqueue_script('you_admin_widgets');
        wp_enqueue_script('jquery-ui-dialog');
        wp_enqueue_style('wp-jquery-ui-dialog');
        wp_register_style('google-jquery-ui-dialog', get_bloginfo('template_directory') . '/css/jquery-ui.css');
        wp_enqueue_style('google-jquery-ui-dialog');
      }

    }
  }
}
add_action('init', 'you_sidebar_action', 100);


// Theme help messages
function you_admin_help() {
  if (!get_option('Y_author_page')) {
    echo '<div class="updated"><p>' . __('You must set Author Page in YouAre Options', 'youare') . '</p></div>';
  } else {
    if (!get_option('Y_author_page_init')) {
      $sidebar_data['posts'] = false;
      $sidebar_data['categories'] = false;
      $sidebar_data['allpages'] = false;
      $sidebar_data['pages'] = array(get_option('Y_author_page'));
      $sidebar_data['cats'] = array();
      update_option('sidebar_sidebar-author', $sidebar_data);
      update_option('Y_author_page_init', true);
      echo '<div class="message"><p><strong>' . __('The Author Sidebar has been configured', 'youare') . '</strong></p></div>';
    }
  }
  if (!get_option('Y_about')) {
    echo '<div class="updated"><p>' . __('You must configure your About description in YouAre Options', 'youare') . '</p></div>';
  }
}

add_action('widgets_init', 'you_load_widgets');

/**
 * Register our widget.
 * 'Example_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function you_load_widgets() {
  register_widget('You_Author_Pic');
  register_widget('You_About_Box');
  register_widget('You_Follow_Links');
//  register_widget('You_RSS_Links');
  register_widget('You_Single_Category_List');
  register_widget('You_Ads_Boxes');
  register_widget('You_Monthly_Archives');
  register_widget('You_Twitter_Timeline');
}

// Checks if sidebar is visible or not
function is_visible_sidebar($sidebar) {
//echo '<pre>'; var_dump($sidebar);  
  $side = get_option('sidebar_' . $sidebar['id']);
  if (empty($side)) return true;
//var_dump($side, get_option('sidebar_visible_'.$sidebar['id']));
  if ($sidebar['visible'] && get_option('sidebar_visible_' . $sidebar['id']) != 'true')
    return false;
  if (isset($sidebar['pageable']) && $sidebar['pageable']) {
    if ($side['allpages'] && is_page())
      return true;
    if ($side['posts'] && is_single())
      return true;
    if ($side['categories'] && is_category())
      return true;
    if ($side['categories'] && is_single())
      return true;
    $id = get_the_ID();
    if ($side['pages'] && in_array($id, $side['pages']))
      return true;
    if ($id) {
      $cats = get_the_category($id);
      foreach ($cats as $c)
        if (in_array($c->cat_ID, $side['cats']))
          return true;
    }
    return false;
  }
  return true;
}


function you_reset_widgets($theme) {
  update_option('you_installed_widgets', 0);
}
add_action('switch_theme', 'you_reset_widgets');