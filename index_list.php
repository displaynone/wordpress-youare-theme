<?php
/*
  Template Name: Main Index (Blog Posts)
 */
?>

<?php get_header(); ?>

<?php if (have_posts()) : ?>
  <?php if (is_paged()) { ?>
          <h1 class="title"><?php _e('Page ', 'youare');
          echo $paged; ?></h1>
        </div> <!--end splash-->
      </div> <!--end row-->
    </div> <!--end container-->  

    <div class="container">
      <div class="row content-background bottom_corner">
        <div id="content"> 
          <div class="eightcol singlepost"> 
  <?php } ?>
  <?php
  $cont = 0;
  while (have_posts()) : the_post();
    $cont++;
    ?>
  <?php if ($cont == 2 && !is_paged()) { ?>

        </div> <!--end splash-->
      </div> <!--end row-->
    </div> <!--end container-->  
    <div class="container">
      <div class="row content-background bottom_corner">
        <div id="content"> 
          <div class="eightcol singlepost"> 
  <?php } ?>
            <div class="post" id="post-<?php the_ID(); ?>">

    <?php if (($cont > 1 && !is_paged()) || is_paged()) { ?>
                  <div class="date"> 
                    <strong><?php the_time('d') ?></strong> 
                    <span><?php the_time('M') ?></span> 
                    <em><?php the_time('Y') ?></em> 
                  </div>  <?php } ?>

                  <?php if ($cont == 1 && !is_paged()) { ?>
                  <article>
                    <?php
                    
                    if ($cont == 1 && has_post_thumbnail()) { // check if the post has a Post Thumbnail assigned to it.
                      echo '<a href="' . get_permalink() . '">';
                      the_post_thumbnail('splash', array('title' => ""));
                      echo '</a>';
                    }
                    ?>

    <?php } ?>
                  <?php
                    
                    if ($cont > 1 && has_post_thumbnail()) { // check if the post has a Post Thumbnail assigned to it.
                      echo '<a href="' . get_permalink() . '">';
                      the_post_thumbnail('list', array('title' => ""));
                      echo '</a>';
                    }
                    ?>
			<h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php echo sprintf(__('Permanent Link to %s', 'youare'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h2>

                  <?php if ($cont == 1 && !is_paged()) { ?>
                    <p class="meta home"><?php edit_post_link(__('Edit This', 'youare'), '<strong>', '</strong>. '); ?> <?php the_date(); ?>. <?php comments_number(__('No comments', 'youare'), __('1 comment', 'youare'), __('% comments', 'youare')); ?> </p>
    <?php } ?>

                  <div class="<?php if ($cont == 1 && !is_paged()) { ?>intro<?php } else { ?>entry excerpt<?php } ?>">
                  <?php if ($cont > 1 && !is_paged()) { ?><p class="meta"><?php edit_post_link(__('Edit This', 'youare'), '<strong>', '</strong>. '); ?><?php comments_number(__('No comments', 'youare'), __('1 comment', 'youare'), __('% comments', 'youare')); ?></p> <?php } ?>
                    
                  <?php the_excerpt(__('read more...', 'youare')); ?>

                  </div><!--end entry-->
    <?php if ($cont == 1 && !is_paged()) { ?>
                  </article>
              <?php } ?>

              </div><!--end post-->

              <?php endwhile; /* rewind or continue if all posts have been fetched */ ?>

            <div class="clear pcenter">
            	<?php wp_pagenavi(); ?>
            </div>


        <?php endif; ?>

      </div><!--end singlepost-->

<?php get_sidebar(); ?>
<?php get_footer(); ?>