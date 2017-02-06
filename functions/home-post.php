<?php
/* Allow to post from home */

// Redirect to new post if it's generated using home posting
add_filter('redirect_post_location', 'you_home_posting_redirection');

function you_home_posting_redirection($location) {
  if (isset($_POST['home_posting'])) {
    return get_permalink($_POST['ID']);
  } else {
    return $location;
  }
}

// Home posting form
function you_dashboard_quick_press() {
  if (/*!current_user_can('manage_options') ||*/ !current_user_can('publish_posts') || !get_option('Y_publish_form'))
    return;
  include_once( ABSPATH . '/wp-admin/includes/media.php' );
  include_once( ABSPATH . '/wp-admin/includes/post.php' );
  global $post_ID;

  $drafts = false;

  /* Check if a new auto-draft (= no new post_ID) is needed or if the old can be used */
  $last_post_id = (int) get_user_option('dashboard_quick_press_last_post_id'); // Get the last post_ID
  if ($last_post_id) {
    $post = get_post($last_post_id);
    if (empty($post) || $post->post_status != 'auto-draft') { // auto-draft doesn't exists anymore
      $post = get_default_post_to_edit('post', true);
      update_user_option((int) $GLOBALS['current_user']->ID, 'dashboard_quick_press_last_post_id', (int) $post->ID); // Save post_ID
    } else {
      $post->post_title = ''; // Remove the auto draft title
    }
  } else {
    $post = get_default_post_to_edit('post', true);
    update_user_option((int) $GLOBALS['current_user']->ID, 'dashboard_quick_press_last_post_id', (int) $post->ID); // Save post_ID
  }

  $post_ID = (int) $post->ID;
  ?>
  <p id="quickpost" class="row"><a class="bg topcorner" href="" title="<?php _e('Write a Quick Post', 'youare'); ?>"><?php _e('Write a Quick Post', 'youare'); ?></a></p>

  <div class="row" id="home-publishing">
    <form name="post" action="<?php echo esc_url(admin_url('post.php')); ?>" method="post" id="quick-press" class="bg biground aristo">

      <div class="sixcol">
        <input type="text" name="post_title" id="title" tabindex="1" autocomplete="off"  value="<?php _e('Title', 'youare'); ?>" onfocus="if (this.value == '<?php _e('Title', 'youare'); ?>') {this.value='';}" />

        <textarea name="content" class="mceEditor" rows="3" cols="15" tabindex="2"  onfocus="if (this.value == '<?php _e('Content', 'youare'); ?>') {this.value='';}"><?php _e('Content', 'youare'); ?></textarea>
      </div>

      <script type="text/javascript">edCanvas = document.getElementById('content');edInsertContent = null;</script>

      <div class="sixcol last">
        <input type="text" name="tags_input" id="tags-input" tabindex="3"  value="<?php _e('Tags', 'youare'); ?>"  onfocus="if (this.value == '<?php _e('Tags', 'youare'); ?>') {this.value='';}" />

        <?php wp_dropdown_categories(array('hide_empty' => 0, 'name' => 'post_category[]', 'orderby' => 'name', 'selected' => $category->parent, 'hierarchical' => true, 'show_option_none' => __('None', 'youare')));
        ?>
      </div>

      <input type="hidden" name="action" id="quickpost-action" value="post" />
      <input type="hidden" name="post_ID" value="<?php echo $post_ID; ?>" />
      <input type="hidden" name="post_type" value="post" />
      <input type="hidden" name="home_posting" value="true" />
      <input type="hidden" name="post_status" value="publish" />
      <input type="hidden" name="comment_status" value="<?php echo get_option('default_comment_status'); ?>" />
      <?php wp_nonce_field('add-post'); ?>
      <button type="submit" id="publish" accesskey="p" class="button-primary"><?php _e('Publish', 'youare'); ?></button>
    </form>
  </div>
  <?php
}
