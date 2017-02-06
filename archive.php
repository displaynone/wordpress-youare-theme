<?php get_header(); ?> 
<?php if (have_posts()) : ?>
  <?php
  /**************
   * 
   * CATEGORIES
   * 
   **************/
  if (is_category()) {
    // if this category has children
    $categ_object = get_category(get_query_var('cat'), false);
    $list_subcats = wp_list_categories('title_li=&depth=1&echo=0&child_of=' . (int) $categ_object->cat_ID);

    // wordpress never returns null or empty string. If children, <a> tag will be found, otherwise string is returned.
    preg_match_all('|<a.*?href=[\'"](.*?)[\'"].*?>|i', $list_subcats, $m);

    if (!$m[1]) {
      // there are no subcategories. Why?
      // this is either the last child or this category really doesn't have subcategories
      // last child must have a parent, right?
      if ((int) $categ_object->category_parent > 0) {
        // we'll need parent category name for the title, extract name via category ID
        $parent_cat_name = $wpdb->get_var("SELECT name FROM $wpdb->terms WHERE term_id=" . (int) $categ_object->category_parent);
        ?>
        <p class="pright subscribe"><a class="rss" title="<?php _e('Subscribe to this category', 'youare'); ?>" href="<?php echo get_category_feed_link('cat_id', 'feed'); ?>feed/"><?php echo sprintf(__('Subscribe to %s', 'youare'), '<strong>' . single_cat_title(null, false) . '</strong>'); ?></a></p>
        <h1><a href="<?php echo get_category_link($categ_object->category_parent) ?>" title="<?php _e('Go to this category', 'youare'); ?>"><?php echo $parent_cat_name; ?></a></h1>
        <ul class="subnav">
          <?php wp_list_categories('title_li=&show_count=1&depth=1&child_of=' . (int) $categ_object->category_parent); ?>
        </ul>
        <?php
      } else {
        $parent_cat_name = $wpdb->get_var("SELECT name FROM $wpdb->terms WHERE term_id=" . (int) $categ_object->cat_ID);
        ?>
        <p class="pright subscribe"><a class="rss" title="<?php _e('Subscribe to this category', 'youare'); ?>" href="<?php echo get_category_feed_link('cat_id', 'feed'); ?>feed/"><?php echo sprintf(__('Subscribe to %s', 'youare'), '<strong>' . single_cat_title(null, false) . '</strong>'); ?></a></p>
        <h1><a href="<?php echo get_category_link($categ_object->cat_ID) ?>" title="<?php _e('Go to this category', 'youare'); ?>"><?php echo single_cat_title("", false) ?></a></h1>
        <?php
        global $wp_query;
        $count = $wp_query->found_posts;

        if ($count == '1') {
          ?>
          <p class="meta">1 <?php _e('post', 'youare'); ?></p>
        <?php } else { ?> <p class="meta"> <?php echo $count; ?> <?php _e('posts', 'youare'); ?></p>

        <?php } ?>



        <?php
      }
    } else {
      // ohoho! ...but here are some. List them all...
      ?>
      <p class="pright subscribe"><a class="rss" title="<?php _e('Subscribe to this category', 'youare'); ?>" href="<?php echo get_category_feed_link('cat_id', 'feed'); ?>feed/"><?php echo sprintf(__('Subscribe to %s', 'youare'), '<strong>' . single_cat_title(null, false) . '</strong>'); ?></a></p>
      <h1><a href="<?php echo get_category_link($categ_object->cat_ID . "") ?>" title="<?php _e('Go to this category', 'youare'); ?>"><?php echo $categ_object->cat_name; ?></a></h1>
      <ul class="subnav">
      <?php wp_list_categories('title_li=&show_count=1&depth=1&child_of=' . (int) $categ_object->cat_ID); ?>
      </ul>
      <?php
    }
  /********
   * 
   * TAGS 
   * 
   ********/
  } elseif (is_tag()) {
    ?>
    <p class="pright subscribe"><a class="rss" title="<?php _e('Subscribe to this tag', 'youare'); ?>" href="<?php echo get_category_feed_link('cat_id', 'feed'); ?>feed/"><?php echo sprintf(__('Subscribe to %s', 'youare'), '<strong>' . single_tag_title(null, false) . '</strong>'); ?></a></p>

    <h1><a href="/tags" title="<?php _e('Tags', 'youare'); ?>"><?php _e('Tags', 'youare'); ?></a> &raquo; <?php single_tag_title(); ?></h1> 

    <?php
    global $wp_query;
    $count = $wp_query->post_count;

    if ($count == '1') {
      ?>
      <p class="meta">1 <?php _e('post', 'youare'); ?></p>
    <?php } else { ?> <p class="meta"> <?php echo $count; ?> <?php _e('posts', 'youare'); ?>
    <?php } ?>

      <em class="twitter">#<a href="http://twitter.com/#search?q=<?php single_tag_title(); ?>"><?php single_tag_title(); ?></a></em></p>
    <?php
  /***************
   * 
   * DAY ARCHIVES
   * 
   ***************/
  } elseif (is_day()) {
    ?>
    <h1><?php the_time('F jS, Y'); ?> </h1> 


    <?php
    global $wp_query;
    $count = $wp_query->post_count;
    if ($count == '1') {
      ?>
      <p class="meta">1 <?php _e('post', 'youare'); ?> </p>
    <?php } else { ?> <p class="meta"> <?php echo $count; ?> <?php _e('posts', 'youare'); ?> </p>

    <?php } ?>


    <?php
  /***************
   * 
   * MONTH ARCHIVES
   * 
   ***************/
  } elseif (is_month()) {
    ?>
    <h1><?php the_time('F Y'); ?> </h1> 


    <?php
    global $wp_query;
    $count = $wp_query->post_count;
    if ($count == '1') {
      ?>
      <p class="meta">1 <?php _e('post', 'youare'); ?></p>
    <?php } else { ?> <p class="meta"> <?php echo $count; ?> <?php _e('posts', 'youare'); ?></p>

    <?php } ?>
    <?php
  /***************
   * 
   * YEAR ARCHIVES
   * 
   ***************/
  } elseif (is_year()) {
    ?>
    <h1><?php the_time('Y'); ?> </h1>

    <?php
    global $wp_query;
    $count = $wp_query->post_count;
    if ($count == '1') {
      ?>
      <p class="meta">1 <?php _e('post', 'youare'); ?></p>
    <?php } else { ?> <p class="meta"> <?php echo $count; ?> <?php _e('posts', 'youare'); ?></p>

    <?php } ?>

    <?php
  /***************
   * 
   * AUTHOR ARCHIVES
   * 
   ***************/
  } elseif (is_author()) {
    if (isset($_GET['author_name']))
      $current_author = get_userdatabylogin($author_name);
    else
      $current_author = get_userdata(intval($author));
    ?>
    <h1><?php echo sprintf(__('Posts by %s', 'youare'), $current_author->nickname); ?></h1>

    <?php
    global $wp_query;
    $count = $wp_query->post_count;
    if ($count == '1') {
      ?>
      <p class="meta">1 <?php _e('post', 'youare'); ?></p>
    <?php } else { ?> <p class="meta"> <?php echo $count; ?> <?php _e('posts', 'youare'); ?></p>

    <?php } ?>

    <?php
  /***************
   * 
   * BLOG ARCHIVES
   * 
   ***************/
  } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
    ?>
    <h1><?php _e('Blog Archives', 'youare'); ?></h1>
    <?php
  }
  ?>
		
    </div> <!--end splash-->
  </div> <!--end row-->
</div> <!--end container-->  

<div class="container">
  <div class="row content-background bottom_corner">
    <div id="content"> 
      <div class="eightcol singlepost"> 
  <?php
  while (have_posts()) : the_post();
    ?>
        <div class="post" id="post-<?php the_ID(); ?>">
          <div class="date"> <strong><?php the_time('d') ?></strong> <span><?php the_time('M') ?></span> <em><?php the_time('Y') ?></em> </div>
          <?php
            if (has_post_thumbnail()) { // check if the post has a Post Thumbnail assigned to it.
              echo '<a href="' . get_permalink() . '">';
              the_post_thumbnail('archive', array('title' => ""));
              echo '</a>';
            }
            ?>

		<h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php echo sprintf(__('Permanent Link to %s', 'youare'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h2>
          <div class="entry excerpt">
            
            <p class="pleft bold"><?php edit_post_link(__('Edit This', 'youare'), '<strong>', '</strong>.'); ?> <?php comments_number(__('No comments', 'youare'), __('1 comment', 'youare'), __('% comments', 'youare')); ?>.-</p>
<?php the_excerpt(__('read more...', 'youare')); ?>
          
          </div><!--end entry-->
        </div><!--end post-->

      <?php endwhile; /* rewind or continue if all posts have been fetched */ ?>

      <div class="clear pcenter">
      <?php wp_pagenavi(); ?>
      </div>

<?php endif; ?>

      </div><!--end singlepost-->

<?php get_sidebar(); ?>
<?php get_footer(); ?>