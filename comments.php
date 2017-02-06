<!-- You can start editing here. -->

<div id="comments">
  <?php
// Do not delete these lines
  if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
    die('Please do not load this page directly. Thanks!');

  if (post_password_required()) {
    ?>
    <p class="alert"><?php _e('This post is password protected. Enter the password to view comments.', 'youare'); ?></p>
    <?php
    return;
  }
  ?>
<?php if (have_comments()) : ?>

    <div class="comment-number block_bottom">
      <h3 class="line-middle"><span><?php comments_number(__('No Comments Yet', 'youare'), __('1 Comment', 'youare'), __('% Comments', 'youare')); ?></span></h3>   
    </div><!--end comment-number-->

    <ol class="commentlist block_bottom">
  <?php wp_list_comments('type=comment&callback=custom_comment'); ?>    
    </ol>

    
  <?php if (!empty($comments_by_type['pings'])) : ?>
      <h3 class="pinghead"><?php _e('Trackbacks &amp; Pingbacks', 'youare'); ?></h3>
      <ol class="pinglist">
      <?php wp_list_comments('type=pings&callback=list_pings'); ?>
      </ol>
    <?php endif; 
     else : // this is displayed if there are no comments so far  ?>

    <?php if ('open' == $post->comment_status) : ?>
      <!-- If comments are open, but there are no comments. -->
  <?php else : // comments are closed  ?>
      <!-- If comments are closed. -->
      <p class="note"><?php _e('Comments are closed for this entry.', 'youare'); ?></p>
    <?php endif; 
     endif; 
      if ('open' == $post->comment_status) : ?>
    <div id="respond">
      <p class="cancel-comment-reply"><?php cancel_comment_reply_link(); ?></p>
  <?php if (get_option('comment_registration') && !$user_ID) : ?>
        <p><?php echo sprintf(__('You must be <a href="%s/wp-login.php?redirect_to=%s">logged in</a> to post a comment.', 'youare'), get_option('siteurl'), urlencode(get_permalink())); ?></p>
      </div><!--end data-->

      <?php else : ?>
      <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post">
        <?php if ($user_ID) : ?>
          <p><?php echo sprintf(__('Logged in as <a href="%s/wp-admin/profile.php">%s</a>. <a href="%s" title="Log out of this account">Log out &raquo;</a>', 'youare'), get_option('siteurl'), $user_identity, wp_logout_url(get_permalink())); ?></p>
    <?php else : ?>

          <fieldset class="fourcol">
            <label for="author" class="comment-field"><?php _e('Name', 'youare'); ?> <?php if ($req)
        _e('(required)', 'youare'); ?>:</label>
            <input type="text" name="author" id="author" value="<?php echo $comment_author; ?>"  tabindex="1" />
          </fieldset>
          <fieldset class="fourcol">
            <label for="email" class="comment-field"><?php _e('Email', 'youare'); ?> <?php if ($req)
        _e('(required)', 'youare'); ?>:</label>
            <input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" tabindex="2" /> 
          </fieldset>
          <fieldset class="fourcol last">
            <label for="url" class="comment-field"><?php _e('Website (optional)', 'youare'); ?>: </label>
            <input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" tabindex="3" /> <small><?php _e('Please include http://', 'youare'); ?></small>
          </fieldset>
        <?php endif; ?>


    <?php do_action('comment_form', $post->ID); ?>

        <fieldset class="clear">
          <label for="comment" class="comment-field"><?php _e('Comment', 'youare'); ?></label>
          <textarea name="comment" id="comment" cols="50" rows="3" tabindex="4"></textarea> <small class="pright"><?php _e('Your email address will <strong>not</strong> be published. Your photo in comments, use <a rel="external" href="http://gravatar.com">Gravatar</a>', 'youare'); ?>.</small>
        </fieldset>


        <button type="submit" tabindex="5"><?php _e('Comment', 'youare'); ?></button>
    <?php comment_id_fields(); ?>
        <!--input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" /-->

      </form><!--end form-->
    </div><!--end respond-->

  <?php endif; // If registration required and not logged in  
   endif; // if you delete this the sky will fall on your head  ?>
</div><!--end comments-->
