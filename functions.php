<?php
//define( 'SAVEQUERIES', TRUE ); 
define('FUNCTIONS', TEMPLATEPATH . '/functions');
define('WIDGETS', TEMPLATEPATH . '/widgets');
define('COPY', FUNCTIONS . '/youare.php');
require_once (FUNCTIONS . '/comments.php');
require_once (FUNCTIONS . '/youare-admin.php');
require_once (FUNCTIONS . '/sidebar-widgets.php');
require_once (FUNCTIONS . '/contact-form.php');
require_once (FUNCTIONS . '/short-codes.php');
require_once (FUNCTIONS . '/home-post.php');
require_once (FUNCTIONS . '/theme-customizer.php');
require_once (FUNCTIONS . '/refresh-thumbnails.php');
require_once (WIDGETS . '/author-pic.php');
require_once (WIDGETS . '/follow-links.php');
require_once (WIDGETS . '/single-category-list.php');
require_once (WIDGETS . '/about-box.php');
require_once (WIDGETS . '/ads-boxes.php');
require_once (WIDGETS . '/monthly-archives.php');
require_once (WIDGETS . '/popular-categories.php');
require_once (WIDGETS . '/popular-tags.php');
require_once (WIDGETS . '/twitter-timeline.php');

if (!isset($content_width))
  $content_width = 693;

// Meta description and keywords
function csv_tags() {
  $list = get_the_tags();
  if ($list) {
    foreach ($list as $tag) {
      $csv_tags[] = $tag->name;
    }
  }
  foreach ((get_the_category()) as $tag) {
    $csv_tags[] = $tag->cat_name;
  }
  echo is_array($csv_tags) ? '<meta name="keywords" content="' . implode(',', $csv_tags) . '" />' : '';
}
// Remove [...] excerpt
function trim_excerpt($text) {
  return rtrim($text,'[...]');
}
add_filter('get_the_excerpt', 'trim_excerpt');

// Comments hack: Permalinks: edit, delete or mark certain comments as spam without visiting your WordPress dashboard (http://www.smashingmagazine.com/2009/07/23/10-wordpress-comments-hacks/)
function delete_comment_link($id) {
  if (current_user_can('edit_post')) {
    echo '| <a title="' . __('Delete comment', 'youare') . '" href="' . admin_url("comment.php?action=cdc&c=$id") . '">' . __('delete', 'youare') . '</a> ';
    echo '| <a title="' . __('Mark comment as spam', 'youare') . '" href="' . admin_url("comment.php?action=cdc&dt=spam&c=$id") . '">' . __('mark as spam', 'youare') . '</a>';
  }
}

// Comment hack: this code automatically rejects any request for comment posting coming from a browser (or, more commonly, a bot) that has no referrer in the request
function check_referrer() {
  if (!isset($_SERVER['HTTP_REFERER']) || $_SERVER['HTTP_REFERER'] == рс) {
    wp_die(__('Please enable referrers in your browser, or, if you\'re a spammer, bugger off!', 'youare'));
  }
}

add_action('check_comment_flood', 'check_referrer');

// Comments number without pingbacks and trackbacks
function countComments($count) {
  global $wp_query, $post;

  return isset($wp_query->comments_by_type)?count($wp_query->comments_by_type['comment']):$post->comment_count;
}

add_filter('get_comments_number', 'countComments', 0);



// Numeric Page Navigation: (Lester Chan - http://lesterchan.net/wordpress/readme/wp-pagenavi.html)
// Function: Page Navigation Options
function pagenavi_init() {
  $pagenavi_options = array();
  $pagenavi_options['pages_text'] = __('Page %CURRENT_PAGE% of %TOTAL_PAGES%', 'youare');
  $pagenavi_options['current_text'] = '%PAGE_NUMBER%';
  $pagenavi_options['page_text'] = '%PAGE_NUMBER%';
  $pagenavi_options['first_text'] = __('&laquo; First', 'youare');
  $pagenavi_options['last_text'] = __('Last &raquo;', 'youare');
  $pagenavi_options['next_text'] = __('&raquo;', 'youare');
  $pagenavi_options['prev_text'] = __('&laquo;', 'youare');
  $pagenavi_options['dotright_text'] = __('...', 'youare');
  $pagenavi_options['dotleft_text'] = __('...', 'youare');
  $pagenavi_options['style'] = 1;
  $pagenavi_options['num_pages'] = 5;
  $pagenavi_options['always_show'] = 0;
  return $pagenavi_options;
}

// Function: Page Navigation: Boxed Style Paging
function wp_pagenavi($before = '', $after = '') {
  global $wpdb, $wp_query;
  $pagenavi_options = array();
  $pagenavi_options = pagenavi_init();

  if (!is_single()) {
    $request = $wp_query->request;
    $posts_per_page = intval(get_query_var('posts_per_page'));
    $paged = intval(get_query_var('paged'));
    $numposts = $wp_query->found_posts;
    $max_page = $wp_query->max_num_pages;

    /*
      $numposts = 0;
      if(strpos(get_query_var('tag'), " ")) {
      preg_match('#^(.*)\sLIMIT#siU', $request, $matches);
      $fromwhere = $matches[1];
      $results = $wpdb->get_results($fromwhere);
      $numposts = count($results);
      } else {
      preg_match('#FROM\s*+(.+?)\s+(GROUP BY|ORDER BY)#si', $request, $matches);
      $fromwhere = $matches[1];
      $numposts = $wpdb->get_var("SELECT COUNT(DISTINCT ID) FROM $fromwhere");
      }
      $max_page = ceil($numposts/$posts_per_page);
     */
    if (empty($paged) || $paged == 0) {
      $paged = 1;
    }
    $pages_to_show = intval($pagenavi_options['num_pages']);
    $pages_to_show_minus_1 = $pages_to_show - 1;
    $half_page_start = floor($pages_to_show_minus_1 / 2);
    $half_page_end = ceil($pages_to_show_minus_1 / 2);
    $start_page = $paged - $half_page_start;
    if ($start_page <= 0) {
      $start_page = 1;
    }
    $end_page = $paged + $half_page_end;
    if (($end_page - $start_page) != $pages_to_show_minus_1) {
      $end_page = $start_page + $pages_to_show_minus_1;
    }
    if ($end_page > $max_page) {
      $start_page = $max_page - $pages_to_show_minus_1;
      $end_page = $max_page;
    }
    if ($start_page <= 0) {
      $start_page = 1;
    }
    if ($max_page > 1 || intval($pagenavi_options['always_show']) == 1) {
      $pages_text = str_replace("%CURRENT_PAGE%", number_format_i18n($paged), $pagenavi_options['pages_text']);
      $pages_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pages_text);
      echo $before . '<div class="wp-pagenavi">' . "\n";
      switch (intval($pagenavi_options['style'])) {
        case 1:

          if (!empty($pages_text)) {
            echo '<span class="pages">&#8201;' . $pages_text . '&#8201;</span>';
          }
          if ($start_page >= 2 && $pages_to_show < $max_page) {
            $first_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['first_text']);
            echo '<a href="' . clean_url(get_pagenum_link()) . '" title="' . $first_page_text . '">&#8201;' . $first_page_text . '&#8201;</a>';
            if (!empty($pagenavi_options['dotleft_text'])) {
              echo '<span class="extend">&#8201;' . $pagenavi_options['dotleft_text'] . '&#8201;</span>';
            }
          }
          previous_posts_link($pagenavi_options['prev_text']);
          for ($i = $start_page; $i <= $end_page; $i++) {
            if ($i == $paged) {
              $current_page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['current_text']);
              echo '<span class="current">&#8201;' . $current_page_text . '&#8201;</span>';
            } else {
              $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
              echo '<a href="' . clean_url(get_pagenum_link($i)) . '" title="' . $page_text . '">&#8201;' . $page_text . '&#8201;</a>';
            }
          }
          next_posts_link($pagenavi_options['next_text'], $max_page);
          if ($end_page < $max_page) {
            if (!empty($pagenavi_options['dotright_text'])) {
              echo '<span class="extend">&#8201;' . $pagenavi_options['dotright_text'] . '&#8201;</span>';
            }
            $last_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['last_text']);
            echo '<a href="' . clean_url(get_pagenum_link($max_page)) . '" title="' . $last_page_text . '">&#8201;' . $last_page_text . '&#8201;</a>';
          }
          break;
        case 2;
          echo '<form action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '" method="get">' . "\n";
          echo '<select size="1" onchange="document.location.href = this.options[this.selectedIndex].value;">' . "\n";
          for ($i = 1; $i <= $max_page; $i++) {
            $page_num = $i;
            if ($page_num == 1) {
              $page_num = 0;
            }
            if ($i == $paged) {
              $current_page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['current_text']);
              echo '<option value="' . clean_url(get_pagenum_link($page_num)) . '" selected="selected" class="current">' . $current_page_text . "</option>\n";
            } else {
              $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
              echo '<option value="' . clean_url(get_pagenum_link($page_num)) . '">' . $page_text . "</option>\n";
            }
          }
          echo "</select>\n";
          echo "</form>\n";
          break;
      }
      echo '</div>' . $after . "\n";
    }
  }
}

// Create sitemap xml In WordPress Without Using Any Plugins (http://bit.ly/o5RkYr)
add_action("publish_post", "eg_create_sitemap");
add_action("publish_page", "eg_create_sitemap");

function eg_create_sitemap() {
  $postsForSitemap = get_posts(array(
      'numberposts' => -1,
      'orderby' => 'modified',
      'post_type' => array('post', 'page'),
      'order' => 'DESC'
          ));

  $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
  $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

  foreach ($postsForSitemap as $post) {
    setup_postdata($post);

    $postdate = explode(" ", $post->post_modified);

    $sitemap .= '<url>' .
            '<loc>' . get_permalink($post->ID) . '</loc>' .
            '<lastmod>' . $postdate[0] . '</lastmod>' .
            '<changefreq>monthly</changefreq>' .
            '</url>';
  }

  $sitemap .= '</urlset>';

  $fp = fopen(ABSPATH . "sitemap.xml", 'w');
  fwrite($fp, $sitemap);
  fclose($fp);
}

// Better SEO automatically remove short words from URL (http://bit.ly/mQntKC)
add_filter('sanitize_title', 'remove_short_words');

function remove_short_words($slug) {
  if (!is_admin())
    return $slug;
  $slug = explode('-', $slug);
  foreach ($slug as $k => $word) {
    if (strlen($word) < 3) {
      unset($slug[$k]);
    }
  }
  return implode('-', $slug);
}

// URL Search Friendly (http://bit.ly/o0waD5)
function search_url_rewrite_rule() {
  if (is_search() && !empty($_GET['s'])) {
    wp_redirect(home_url("/search/") . urlencode(get_query_var('s')));
    exit();
  }
}

add_action('template_redirect', 'search_url_rewrite_rule');


function you_search_filter($s) {
  return urldecode($s);
}
add_filter('get_search_query', 'you_search_filter');
add_filter('the_search_query', 'you_search_filter');

add_action('parse_query', 'you_query_vars_search_filter' );
function you_query_vars_search_filter( $qvars ) {
  $qvars->query_vars['s'] = urldecode($qvars->query_vars['s']);
  return $qvars;
}

// Monthly archive grouped by year (Oriol Morell - http://oriolmorell.cat)
function get_year_archives($type='monthly', $show_post_count = false) {
  global $month, $wpdb;

  // over-ride general date format ? 0 = no: use the date format set in Options, 1 = yes: over-ride
  $archive_date_format_over_ride = 0;

  $now = current_time('mysql');

  $arcresults = $wpdb->get_results("SELECT DISTINCT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, count(ID) as posts FROM $wpdb->posts WHERE post_date < '
$now' AND post_date != '0000-00-00 00:00:00' AND post_status = 'publish' GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date DESC" . $limit);
  if ($arcresults) {
    $afterafter = $after;
    $act_year = 0;
    $output = "";
    foreach ($arcresults as $arcresult) {
      if ($act_year != $arcresult->year) {
        if (strlen($output)) {
          $output.="</ul></li>";
        }
        $act_year = $arcresult->year;
        $output.="<li>" . $act_year . ": <ul class='months'>";
      }
      $url = get_month_link($arcresult->year, $arcresult->month);
      if ($show_post_count) {
        $text = sprintf('%s', substr($month[zeroise($arcresult->month, 2)], 0, 3));
        $after = '&nbsp;(' . $arcresult->posts . ')' . $afterafter;
      } else {
        $text = sprintf('%s', substr($month[zeroise($arcresult->month, 2)], 0, 3));
      }
      $output.="<li>" . get_archives_link($url, $text, $format, $before, $after) . "</li>";
    }
    echo "<ul class='year_arch'>" . $output . "</ul></li></ul>";
  }
}

/* Disable the Admin Bar. */
add_filter('show_admin_bar', '__return_false');
remove_action('personal_options', '_admin_bar_preferences');


// Gravatar Favicon (Patrick Chia - http://patrick.bloggles.info/plugins/)
if (!function_exists('get_favicon')) :

  function get_favicon($id_or_email, $size = '96', $default = '', $alt = false) {
    $avatar = you_avatar(); // get_avatar($id_or_email, $size, $default, $alt);

    preg_match('#src=[\'"]([^\'"]+)[\'"]#', $avatar, $m);
    $newAvatar = $m[1];

    return $newAvatar;
  }

endif;

function blog_favicon() {
  $apple_icon = get_favicon(get_bloginfo('admin_email'), 60);
  $favicon_icon = get_favicon(get_bloginfo('admin_email'), 18);

  if (get_option('show_avatars')) {
    echo "<link rel=\"apple-touch-icon\" href=\"$apple_icon\" />\n";
    echo "<link rel=\"shortcut icon\" type=\"image/png\" href=\"$favicon_icon\" />\n";
  }
}

// Modify admin logo using avatar
function admin_logo() {
  $admin_logo = get_favicon(get_bloginfo('admin_email'), 31);

  if (get_option('show_avatars')) {
    ?>
    <style type="text/css">
      #header-logo{background-image: none;
                   -moz-border-radius: 5px;
                   -webkit-border-bottom-left-radius: 5px;	-webkit-border-bottom-right-radius: 5px; -webkit-border-top-left-radius: 5px; -webkit-border-top-right-radius: 5px;
                   -khtml-border-bottom-left-radius: 5px;-khtml-border-bottom-right-radius: 5px;-khtml-border-top-left-radius: 5px;-khtml-border-top-right-radius: 5px;
                   border-bottom-left-radius: 5px;	border-bottom-right-radius: 5px;border-bottom-top-radius: 5px;border-bottom-top-radius: 5px;}
    </style>
    <script type="text/javascript">
      jQuery(document).ready(function() {jQuery('#header-logo').attr('src', '<?php echo $admin_logo; ?>')});
    </script>
    <?php
  }
}

// Feed logo using avatar
function add_feed_logo() {
  $feed_logo = get_favicon(get_bloginfo('admin_email'), 48);
  echo "
   <image>
    <title>" . get_bloginfo('name') . "</title>
    <url>" . $feed_logo . "</url>
    <link>" . get_bloginfo('siteurl') . "</link>
   </image>\n";
}

add_action('wp_head', "blog_favicon");
add_action('admin_head', 'blog_favicon');
add_action('login_head', 'blog_favicon');
add_action('admin_head', 'admin_logo');
add_action('rss_head', add_feed_logo);
add_action('rss2_head', add_feed_logo);

if (!function_exists('y_addgravatar')) {

  // Add a new avatar for defaults
  function y_addgravatar($avatar_defaults) {
    $myavatar = get_bloginfo('template_directory') . '/images/youare_gravatar.png';
    //default avatar
    $avatar_defaults[$myavatar] = 'YouAre';

    return $avatar_defaults;
  }

  add_filter('avatar_defaults', 'y_addgravatar');
}



// Adding menus to theme
add_action('init', 'register_my_menus');

function register_my_menus() {
  register_nav_menus(
          array(
              'header-menu' => __('Header')
          )
  );
}

/** Adding home script */
add_action('wp_enqueue_scripts', 'you_add_scripts');

function you_add_scripts() {
  if (is_home() || is_paged()) {
    wp_enqueue_script('jquery');
    wp_register_script('you_home_scripts', get_bloginfo('template_directory') . '/js/home.js');
    wp_enqueue_script('you_home_scripts');
    wp_register_script('you_customize', get_bloginfo('template_directory') . '/js/customize.js');
    wp_enqueue_script('you_customize');
  } else if (is_single()) {
    wp_enqueue_script('jquery');
    wp_register_script('you_single_scripts', get_bloginfo('template_directory') . '/js/single.js');
    wp_enqueue_script('you_single_scripts');
  }
  if (isset($_GET['css_creator']) && current_user_can('manage_options')) {
    wp_register_script('you_css_creator', get_bloginfo('template_directory') . '/js/css_creator.js.php?' . (isset($_GET['you_css']) ? 'you_css=' . $_GET['you_css'] : ''));
    wp_enqueue_script('you_css_creator');
    wp_register_script('jquery_minicolors', get_bloginfo('template_directory') . '/js/jquery.miniColors.js');
    wp_enqueue_script('jquery_minicolors');
    wp_register_style('jquery_minicolors', get_bloginfo('template_directory') . '/css/jquery.miniColors.css');
    wp_enqueue_style('jquery_minicolors');
  }
  if (/*current_user_can('manage_options') &&*/ current_user_can('publish_posts') && get_option('Y_publish_form')) {
    wp_register_script('jquery-uniform-min', get_bloginfo('template_directory') . '/js/jquery.uniform.min.js');
    wp_enqueue_script('jquery-uniform-min');
    wp_register_script('you-publish', get_bloginfo('template_directory') . '/js/publish.js');
    wp_enqueue_script('you-publish');
    //wp_register_script('media-upload', '/wp-admin/js/media-upload.js', array( 'thickbox' ), '20110113' );
    //wp_enqueue_script( 'media-upload' ); 
    //wp_enqueue_script( 'jquery-ui-core' ); 
    //wp_enqueue_style( 'thickbox' );
  }
  wp_register_script('css3-mediaqueries', get_bloginfo('template_directory') . '/js/css3-mediaqueries.js');
  wp_enqueue_script('css3-mediaqueries');
  // Portlet
  wp_register_script('you_portlet', get_bloginfo('template_directory') . '/js/portlet.js');
  wp_enqueue_script('you_portlet');
  wp_enqueue_script('jquery-ui-sortable');
  wp_register_style('you-jquery-ui', get_bloginfo('template_directory') . '/css/jquery-ui.css');
  wp_enqueue_style('you-jquery-ui');
  
}

// Modify limits in queries for pagination, home posts are ROWSx3
add_filter('post_limits', 'you_pagination_limits');

function you_pagination_limits($limits) {
  if (!is_home()) return $limits;
    
  preg_match('#LIMIT (\d+), (\d+)#', $limits, $m);

  if (isset($m[1]) && isset($m[2])) {
    global $wp_query;
    $per_page = $wp_query->query_vars['posts_per_page'];
    $per_page = !is_paged() ? intval($per_page / 3) * 3 + 1 : intval($per_page / 3) * 3;
    if ($m[2] == $per_page && $m[1]) {
      return 'LIMIT ' . ($m[1] + 1) . ', ' . $per_page;
    }
  }
   
  return $limits;
}

// Adding post thumbnails
if (function_exists('add_theme_support')) {
  add_theme_support('post-thumbnails');
  $def = array(
      'splash' => array(100, 100, true), 
      'list' => array(100, 100, true),
      'archive' => array(80, 80, true),
      'normal' => array(60, 60, true),
      'single' => array(325, 325, false)
    );
  $thumbs_sizes = get_option('P_thumbs_size', $def );
  if (empty($thumbs_sizes)) $thumbs_sizes = $def;

  foreach($thumbs_sizes as $t=>$v) {
    add_image_size($t, $v[0], $v[1], $v[2]);
  }
}

// Post Password Protected
add_filter('the_password_form', 'custom_password_form');

function custom_password_form() {
  global $post;
  $label = 'pwbox-' . ( empty($post->ID) ? rand() : $post->ID );
  $o = '<form class="protected-post-form" action="' . get_option('siteurl') . '/wp-pass.php" method="post">
	' . __("<p class=\"alert\">This post is password protected. To view it please enter your password below:</p>", 'youare') . '
	<div class="block_top block_bottom"><input name="post_password" id="' . $label . '" class="protected" type="password" /><button type="submit" class="default">'.__('Submit Password', 'youare').'</button></div>
	</form>
	';
  return $o;
}
// Add Excerpts to Your Pages
add_action( 'init', 'you_excerpt_pages' );
function you_excerpt_pages() {
     add_post_type_support( 'page', 'excerpt' );
}
// Modifying the excerpt
add_filter('the_excerpt', 'you_the_excerpt');

function you_the_excerpt($content) {
  global $you_is_first_post;
  $p = get_post(get_the_ID());
  if (get_option('Y_modify_excerpt')) {
    $excp = get_option('Y_excerpt');
    if (!$excp) $excp = __("read more...", 'youare');
    if ($p->post_excerpt)
      return $p->post_excerpt . ($excp ? ' <a href="' . get_permalink() . '">' . __($excp, 'youare') . '</a>' : '');
    //$content = get_the_content();
    if (!$content || !trim($content)) {
      $content = get_option('Y_empty_excerpt');
      if (!preg_match('#</p>$#', $content))
        $content = '<p>' . $content . '</p>';
    }
    $content = strip_tags($content, '<em><strong><i><b>');
    $len = get_option('Y_excerpt_length');
    if (!$len) $len = 100;
    $_content = preg_split('/[\s\,\.\:\;]+/', $content, $len + 1, PREG_SPLIT_OFFSET_CAPTURE);

    $pos = count($_content) > $len ? $len : count($_content) - 1;
    $content = '<p>' . substr(str_replace("\n",'',$content), 0, $_content[$pos][1]) . '</p>';
    return preg_replace('#(\[\.\.\.\])?</p>#', $excp ? ' <a href="' . get_permalink() . '">' . __($excp, 'youare') . '</a></p>' : '', $content);
  } else {
    return $content;
  }
}

// Default title for empty titles
add_filter('the_title', 'you_the_title');

function you_the_title($title) {
  if (empty($title))
    return __('This post has not title', 'youare');
  return $title;
}

// Gets avatar depending of configuration: facebook, twitter, google+, gravatar
function you_avatar($url = false, $size = 60) {
  $v = get_option('Y_header_logo');
  if (!$v || $v == 'gravatar') {
    $res = get_avatar(get_option('admin_email'), $size);
    return $url? preg_replace('#.*src="([^"]*)".*#', '$1', str_replace("'", '"', $res)):$res;
  }
  if ($v == 'twitter') {
    if ($url) {
      return 'http://api.twitter.com/1/users/profile_image/' . get_option('Y_twitter') . '.json?size=bigger';
    } else {
      return '<img width="'.$size.'" height="'.$size.'" src="http://api.twitter.com/1/users/profile_image/' . get_option('Y_twitter') . '.json?size=bigger" alt="" />';
    }
  }
  if ($v == 'facebook') {
    if ($url) {
      return 'https://graph.facebook.com/' . get_option('Y_facebook') . '/picture';
    } else {
      return '<img width="'.$size.'" height="'.$size.'" src="https://graph.facebook.com/' . get_option('Y_facebook') . '/picture" alt="" />';
    }
  }
  if ($v == 'googleplus') {
    if ($url) {
      return 'http://profiles.google.com/s2/photos/profile/' . get_option('Y_googleplus') . '?sz='.$size;
    } else {
      return '<img src="http://profiles.google.com/s2/photos/profile/' . get_option('Y_googleplus') . '?sz='.$size.'" alt="" />';
    }
  }

  return $url? $v:'<img width="'.$size.'" height="'.$size.'" src="' . $v . '" alt="" />';
}

function curPageURL() {
  $pageURL = 'http';
  if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
  $pageURL .= "://";
  if ($_SERVER["SERVER_PORT"] != "80") {
    $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
  } else {
    $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
  }
  return $pageURL;
}

// Show Home Link in wp_nav_menu default fallback function (http://bit.ly/rntOUe)
function my_page_menu_args($args) {
  $args['show_home'] = true;
  return $args;
}

add_filter('wp_page_menu_args', 'my_page_menu_args');

load_theme_textdomain('youare', get_template_directory() . '/lang');

remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');

add_filter('home_template', 'you_home_templates');
 
// Select home template
function you_home_templates($path) {
  $tpl = get_option('Y_home_design');
  if (isset($_COOKIE['you_customize_home']) && $_COOKIE['you_customize_home']) $tpl = $_COOKIE['you_customize_home'];
//var_dump($tpl);  
  if (!$tpl || !in_array($tpl, array('index', 'index_list')))
    $tpl = 'index';
  return str_replace('index.php', $tpl . '.php', $path);
}

// Customize user home preference (list or grid)
function you_customize_home() {
  if (isset($_GET['you_customize'])) {
    switch($_GET['you_customize']) {
      case 'list':
        //setcookie('you_customize_home', 'index_list', time()*60*60*24*365, '/');
        break;
      case 'grid':
        //setcookie('you_customize_home', 'index', time()*60*60*24*365, '/');
        break;
      default:
        //setcookie('you_customize_home', null, -1);
    }
    wp_redirect(isset($_SERVER["REDIRECT_URL"])?$_SERVER["REDIRECT_URL"]:'/');
    exit();
  }
}
add_action('init', 'you_customize_home', 1);

// If post thumbnail width is lower than content width/2 then class = right
function you_post_thumbnail_html($html) {
  global $content_width;
  preg_match('#width="([^"]+)"#', $html, $s);
  if (isset($s[1]) && $s[1] < $content_width/2) {
    preg_match('#class="([^"]+)"#', $html, $c);
    if (isset($c[1]) && strpos($c[1], "right") === FALSE) {
      return str_replace('class="'.$c[1].'"', 'class="'.$c[1].' right"', $html);
    }
  }
  return $html;
}
add_filter('post_thumbnail_html', 'you_post_thumbnail_html');

// Adding previous and next posts editing links to Edit Post page
function you_add_navigation_edit_posts() {
  if(preg_match('#wp-admin/post\.php#', $_SERVER["SCRIPT_NAME"]) && isset($_GET['post']) &&  isset($_GET['action']) && $_GET['action'] == 'edit') {
    global $post;
    if(!empty($post)) { // && $post->post_type == 'post') {
      foreach(array(true, false) as $prev) {
        $p = get_adjacent_post(false, '', $prev);
        if (!empty($p)) {
          echo '<script type="text/javascript">';
          echo 'jQuery(document).ready(function() {jQuery(".wrap h2").append(\'<a class="add-new-h2" href="'.admin_url('post.php?action=edit&post='.$p->ID).'" title="'.__('Edit', 'youare').' '.$p->post_title.'">'.($prev?'&laquo; ':'').(strlen($p->post_title) > 25?mb_substr($p->post_title, 0, 25).'...':$p->post_title).(!$prev?' &raquo;':'').'</a>\');});';
          echo '</script>';
        }  
      }
    }
  }
  
}
add_action('admin_head', 'you_add_navigation_edit_posts');

add_filter('wp_nav_menu_objects', 'you_submenu');
function you_submenu($items){
  foreach($items as $i => $item) $pos[$item->ID] = $i;
  foreach($items as $item) {
    if ($item->menu_item_parent) {
      if (isset($pos[$item->menu_item_parent])) {
        if (!in_array('menu-item-has-submenu', $items[$pos[$item->menu_item_parent]]->classes)) $items[$pos[$item->menu_item_parent]]->classes[] = 'menu-item-has-submenu';
      }
    }
  }

  return $items;
}

