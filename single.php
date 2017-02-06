<?php get_header(); ?>

      <div class="pright comments"><span><?php comments_popup_link(__('Leave a comment', 'youare'), __('1 Comment', 'youare'), __('% Comments', 'youare')); ?></span></div>

      <h1 class="title"><?php the_title(); ?></h1>

      <p class="meta">
        	<span id="time" class="pleft">
			<?php edit_post_link(__('Edit This', 'youare'), '<strong>', '</strong>'); ?> <a href="#" onclick="javascript:print();" rel="nofollow" class="print" title="<?php _e('Print', 'youare'); ?>"><?php _e('Print', 'youare'); ?></a> <time datetime="<?php the_time('Y-m-d') ?>" pubdate><?php the_date(); ?>. <a href="<?php echo get_permalink() ?>" rel="bookmark" title="Link"> <?php the_time(); ?></a></time> 
       		 </span>

		<a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="<?php echo get_option('Y_twitter'); ?>">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script> 
      </p>

    </div> <!--end splash-->
  </div> <!--end row-->
</div> <!--end container-->  

<nav class="pagination">
  <?php
  $next_post = get_next_post();
  if ($next_post) {
    $next_title = strip_tags(str_replace('"', '', $next_post->post_title));
    echo "\t" . '<a rel="next" href="' . get_permalink($next_post->ID) . '" title="' . $next_title . '" class="next">' . __('Next &raquo;', 'youare') . '</a>' . "\n";
  }
  $prev_post = get_previous_post();
  if ($prev_post) {
    $prev_title = strip_tags(str_replace('"', '', $prev_post->post_title));
    echo "\t" . '<a rel="prev" href="' . get_permalink($prev_post->ID) . '" title="' . $prev_title . '" class="previous">' . __('&laquo; Prev', 'youare') . '</a>' . "\n";
  }
  ?>
</nav>
<div class="container">
  <div class="row content-background bottom_corner">
    <div id="content"> 
      <div class="eightcol singlepost"> 
      
      
      <?php 
  if (have_posts()) {
    while (have_posts()) {
      the_post();
      the_content(__('read more...', 'youare'));
      wp_link_pages();
?>



        
            

          </div><!--end singlepost-->

          <?php get_sidebar(); ?>

          <div class="container">
            <div class="row bgalt">

              <?php
            } /* rewind or continue if all posts have been fetched */
            comments_template('', true);
          } else {
            
          }
          ?>
        </div> <!--end row-->
      </div> <!--end container--> 

      </article>

<?php get_footer(); ?>
