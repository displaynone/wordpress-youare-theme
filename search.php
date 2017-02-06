<?php get_header(); ?>
<?php if (have_posts()) : ?>

  <h1 class="title"><?php _e('Search Results for ', 'youare'); ?> "<?php the_search_query(); ?>"</h1>

  <p class="meta"><?php /* Search Count */ $allsearch = &new WP_Query("s=$s&showposts=-1");
  $key = esc_html($s, 1);
  $count = $allsearch->post_count;
  echo $count . ' ';
  _e('posts', 'youare');
  wp_reset_query(); ?></p>

      </div> <!--end splash-->
    </div> <!--end row-->
  </div> <!--end container-->  

  <div class="container content-background">
    <div class="row content-background bottom_corner">
      <div id="content"> 
        <div class="eightcol singlepost">  
  <?php get_search_form(); ?>

              <?php while (have_posts()) : the_post(); ?>
            <div class="post" id="post-<?php the_ID(); ?>">
              <div class="date"> <strong><?php the_time('d') ?></strong> <span><?php the_time('M') ?></span> <em><?php the_time('Y') ?></em> </div>
              <?php
            if (has_post_thumbnail()) { // check if the post has a Post Thumbnail assigned to it.
              echo '<a href="' . get_permalink() . '">';
              the_post_thumbnail('archive');
              echo '</a>';
            }
            ?>

		<h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php echo sprintf(__('Permanent Link to %s', 'youare'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h2>
              <div class="entry excerpt">
                <p class="pleft bold"><?php edit_post_link(__('Edit This', 'youare'), '<strong>', '</strong>.'); ?> <?php comments_number(__('No comments', 'youare'), __('1 comment', 'youare'), __('% comments', 'youare')); ?>.-</p> <?php the_excerpt(__('read more...', 'youare')); ?>
              
              </div><!--end entry-->
            </div><!--end post-->
          <?php endwhile; /* rewind or continue if all posts have been fetched */ ?>

          <div class="pright">
  <?php wp_pagenavi(); ?>
          </div>

<?php else : ?>

          <h1 class="title"><?php _e('Search Results for', 'youare'); ?> "<?php the_search_query(); ?>"</h1>

        </div> <!--end splash-->
      </div> <!--end row-->
    </div> <!--end container-->  

    <div class="container content-background">
      <div class="row content-background bottom_corner">
        <div id="content"> 
          <div class="eightcol singlepost">   
            <form class="search" method="get" id="search_form" action="<?php bloginfo('url'); ?>/">
              <input type="text" name="s" id="s" class="search" onclick="this.value=''" type="text" value="<?php the_search_query(); ?>" />                
            </form>
            <p class="alert"><?php _e('No results found! You sure you wrote it correctly? Please try again.', 'youare'); ?></p>
<?php endif; ?>

          <script type="text/javascript">
            // focus on search field after it has loaded
            document.getElementById('s') && document.getElementById('s').focus();
          </script>

        </div><!--end singlepost-->

<?php get_sidebar(); ?>
<?php get_footer(); ?>