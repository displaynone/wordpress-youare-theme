<?php

// Template for comments
function custom_comment($comment, $args, $depth) {
  $GLOBALS['comment'] = $comment;
  global $commentNum;
  ?>

  <li id="comment-<?php comment_ID() ?>" class="conversation">
    <article <?php comment_class(); ?>>
      <div class="body">
        <div class="head">
          <span class="number"><a href="<?php echo get_permalink(); ?>#comment-<?php comment_ID(); ?>" title="Permalink"><?php echo ($_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest") ? '' : $commentNum + 1; ?></a></span>
          <span class="author vcard"> 
            <?php
            if (function_exists('get_avatar')) {
              if (get_comment_author_url() != '')
                echo '<a title="' . get_comment_author() . '" rel="external nofollow" href="' . get_comment_author_url() . '">' . get_avatar($comment, '48') . '</a>';
              else
                echo get_avatar($comment, '48');
            }
            ?> 

            <span class="fn n bold"><?php comment_author_link() ?></span> 
          </span>

          <span class="date_comment"><time datetime="<?php the_time('Y-m-d') ?>T<?php the_time('G:i') ?>"><?php comment_date() ?> &middot; <a class="bold" href="<?php echo get_permalink(); ?>#comment-<?php comment_ID(); ?>" title="Permalink"><?php comment_date('G:i') ?>H</a></time> <?php edit_comment_link(__(' (Edit)', 'youare'), '<strong>&middot;', '</strong>'); ?> <?php delete_comment_link(get_comment_ID()); ?> 
          </span>

        </div> <!--end head-->

        <?php if ($comment->comment_approved == '0') : ?>

          <p class="alert"><?php _e('Your comment is awaiting moderation.', 'youare'); ?></p>
      <?php endif; ?>

  <?php comment_text() ?>
      </div>  <!--end .body-->     

  <?php comment_type((''), ('Trackback'), ('Pingback')); ?>			

      <div class="foot">
        <span class="reply"><strong><?php echo comment_reply_link(array('depth' => $depth, 'max_depth' => $args['max_depth'])); ?></strong></span> 

      </div>  <!--end foot-->

    </article> <!--end depth-->

    <?php $commentNum++; ?>
  <?php } 

// Template for pingbacks/trackbacks
  function list_pings($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    ?>
  <li id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); 
  }

  add_action('init', 'you_ajax_comments');

  // Ajax comments, add javascript to handle ajax posting
  // and handler the comments redirect and die (error message)
  function you_ajax_comments() {
    wp_enqueue_script('jquery');
    wp_register_script('you_ajax_comments', get_bloginfo('template_directory') . '/js/ajax_comments.js');
    wp_enqueue_script('you_ajax_comments');
    add_filter('wp_die_handler', 'you_die_handler');
    add_filter('comment_post_redirect', 'you_ajax_post_redirect');
  }

  // Die handler for comments
  function you_die_handler($message) {
    return 'you_die_comment_handler';
  }

  // Show alert message when there is an error
  function you_die_comment_handler($message, $title, $args) {
    echo '<p class="alert">' . $message . '</p>';
    exit();
  }

  // If there is a comment, show comment, no redirect
  function you_ajax_post_redirect($location) {
    preg_match('/#comment-(\d+)/', $location, $m);
    if (isset($m[1])) {
      custom_comment(get_comment($m[1]), array(), 1);
      exit();
    } else {
      return $location;
    }
  }