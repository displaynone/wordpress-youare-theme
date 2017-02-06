<!doctype html>
<html <?php language_attributes(); ?>>
  <head>
    <?php load_theme_textdomain('youare', get_template_directory() . '/lang'); ?>
    <meta charset="<?php bloginfo('charset'); ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <!-- Adding "maximum-scale=1" fixes the Mobile Safari auto-zoom bug: http://filamentgroup.com/examples/iosScaleBug/ -->
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <?php $twitter = get_option('Y_twitter'); if ($twitter) { ?>
    <meta name="twitter:creator" value="@<?php echo $twitter; ?>">
   
    <meta name="twitter:site" value="@<?php echo $twitter; ?>">  
    <?php } ?>
    <?php if (is_front_page()) : ?>
      <title><?php bloginfo('name'); ?></title>
      <meta property="og:title" content="<?php bloginfo('name'); ?>" />
      <meta name="twitter:title" value="<?php bloginfo('name'); ?>" />
    <?php elseif (is_single()) : ?>
      <title><?php the_title(); ?></title>
      <meta property="og:title" content="<?php the_title(); ?>" />
      <meta name="twitter:title" value="<?php the_title(); ?>" />
    <?php elseif (is_404()) : ?>
      <title><?php _e('Page not found', 'youare'); ?> &middot; <?php bloginfo('name'); ?></title>
      <meta property="og:title" content="<?php _e('Page not found', 'youare'); ?> &middot; <?php bloginfo('name'); ?>" />
      <meta name="twitter:title" value="<?php _e('Page not found', 'youare'); ?> &middot; <?php bloginfo('name'); ?>" />
    <?php elseif (is_search()) : ?>
      <title><?php echo __('Search Results for ', 'youare') . esc_html($s); ?> | <?php bloginfo('name'); ?></title>
      <meta property="og:title" content="<?php echo __('Search Results for ', 'youare') . esc_html($s); ?> | <?php bloginfo('name'); ?>" />
      <meta name="twitter:title" value="<?php echo __('Search Results for ', 'youare') . esc_html($s); ?> | <?php bloginfo('name'); ?>" />
    <?php else : ?>
      <title><?php wp_title($sep = ''); ?> &middot; <?php bloginfo('name'); ?></title>
      <meta property="og:title" content="<?php wp_title($sep = ''); ?> &middot; <?php bloginfo('name'); ?>" />
      <meta name="twitter:title" value="<?php wp_title($sep = ''); ?> &middot; <?php bloginfo('name'); ?>" />
    <?php endif; ?>
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  	<![endif]-->
    <!-- Basic Meta Data -->	
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <?php if (is_single() || is_page()) : if (have_posts()) : while (have_posts()) : the_post(); ?>
          <meta name="description" content="<?php echo strip_tags(get_the_excerpt()); ?>" />
          <meta property="og:description" content="<?php echo strip_tags(get_the_excerpt()); ?>" />
          <?php csv_tags(); ?>
        <?php endwhile;
      endif;
    elseif (is_home()) : ?>
      <meta name="description" content="<?php bloginfo('name'); ?>. <?php bloginfo('description'); ?>" />
      <meta property="og:description" content="<?php bloginfo('description'); ?>" />
    <?php endif; ?>

    <!--Stylesheets-->
    	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="all" />
  	
    <?php
    $y_alt_stylesheet = get_option('Y_alt_stylesheet');
    if (isset($_GET['you_css']) && current_user_can('manage_options')) {
      echo '<link rel="stylesheet" id="colors-css" href="' . get_bloginfo('template_directory') . '/' . $_GET['you_css'] . '" type="text/css" media="screen" />';
    } else if ($y_alt_stylesheet && !($y_alt_stylesheet == 'Select a stylesheet:')) {
      echo '<link rel="stylesheet" href="' . get_bloginfo('template_directory') . '/' . $y_alt_stylesheet . '" type="text/css" media="screen" />';
    } else {
      ?>
      <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/1_default_colors.css" type="text/css" media="screen" />

    <?php } ?>
      
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,400,300,600" type="text/css" />

    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/print.css" type="text/css" media="print" />

      <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?>RSS 2.0 Feed" href="<?php bloginfo('rss2_url'); ?>" />
	

    <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> <?php _e('Comments RSS 2.0 Feed', 'youare'); ?>" href="<?php bloginfo('comments_rss2_url'); ?>" />

    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

    <meta property="og:site_name" content="<?php bloginfo('name'); ?>" />
    <?php if(has_post_thumbnail()) { ?>
      <meta property="og:image" content="<?php echo preg_replace('#.*src="([^"]*)".*#', '$1', str_replace("'", '"', get_the_post_thumbnail())); ?>" />
      <meta name="twitter:image" content="<?php echo preg_replace('#.*src="([^"]*)".*#', '$1', str_replace("'", '"', get_the_post_thumbnail())); ?>" />
    <?php } else { ?>
      <meta property="og:image" content="<?php echo you_avatar(true, 250); ?>" />
      <meta name="twitter:image" content="<?php echo you_avatar(true, 250); ?>" />
    <?php } ?>
    <?php global $wp; $current_url = add_query_arg( $wp->query_string, '', home_url( $wp->request ) ); ?>
    <meta property="og:url" content="<?php echo curPageURL(); ?>" />
    <?php if (get_option('Y_googleplus')) { ?><link href="https://plus.google.com/<?php echo get_option('Y_googleplus'); ?>" rel="publisher" /><?php } ?>        
    <!--WP Hook-->
    <?php if (is_singular())
      wp_enqueue_script('comment-reply'); ?>

<?php wp_head(); ?>
  </head>

<body <?php body_class(); ?> <?php language_attributes(); ?> <?php if (is_single() || is_archive())
  echo(' id="archives_page"'); ?>>

    <header id="branding">
      <div class="container">
        <div class="row vcard"> 
				<a href="#mobile" id="navlink">Nav</a>
          <nav>
          <?php wp_nav_menu(array('theme_location' => 'header-menu')); ?>
              
              
          </nav>

          <a class="photo" href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>"><?php echo you_avatar(); ?></a>

<?php if (is_home())
  echo('<h1 id="logo">'); else
  echo('<div id="logo">'); ?><a class="url" href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>"><span class="fn"><?php bloginfo('name'); ?></span></a><?php if (is_home())
  echo('</h1>'); else
  echo('</div>'); ?>
<?php $twitter_username = get_option('Y_twitter');
if ($twitter_username) { ?>
            <p id="username"><a href="http://twitter.com/<?php echo $twitter_username; ?>" class="twitter-follow-button" data-button="grey" data-link-color="6688aa" data-text-color="ffffff" data-show-count="false"><?php _e('Follow', 'youare'); ?> @<?php echo $twitter_username; ?></a>
              <script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script></p>
      <?php } ?>

        </div><!--end row vcard-->
      </div><!--container-->

    </header>

<?php if (is_single()) : ?> 
      <article>
<?php endif; ?>

      <div id="masthead" class="container">

		<?php if (is_home() ) : ?> 
			<!-- Start Homepage Design -->	

			<div id="switch_design">
				<a href="?you_customize" title="<?php _e('Homepage Design - Display list of posts', 'youare'); ?>"><img src="<?php echo $picture?$picture: get_bloginfo('template_url').'/images/icons/home_list.png' ?>" alt="<?php _e('List of posts', 'youare'); ?>" /></a>
				
				<a href="?you_customize" title="<?php _e('Homepage Design - Display posts in Columns', 'youare'); ?>"><img src="<?php echo $picture?$picture: get_bloginfo('template_url').'/images/icons/home_grid.png' ?>" alt="<?php _e('Posts in Columns', 'youare'); ?>" /></a>

			</div>
			<!-- End Homepage Design -->

		<?php endif; ?>

	<?php you_dashboard_quick_press(); ?>

        <div class="row bg topcorner">
          <div class="splash">
