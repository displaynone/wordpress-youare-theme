<?php get_header(); ?>
<?php
global $wp_query;
$per_page = $wp_query->query_vars['posts_per_page'];
$per_page = !is_paged() ? intval($per_page / 3) * 3 + 1 : intval($per_page / 3) * 3;
query_posts('posts_per_page=' . $per_page . '&paged=' . $paged);
if (have_posts()) {
  $cont = 0;
  $dif = 1;
  while (have_posts()) {
    the_post();
    $cont++;
    if ($cont == 1 && !is_paged()) { // Primer post   
      ?>           
      <!-- The 1st post only if it's not paged -->			     
      <article class="twelvecol">
        <?php
        if (has_post_thumbnail()) { // check if the post has a Post Thumbnail assigned to it.
          echo '<a href="' . get_permalink() . '">';
          the_post_thumbnail('splash', array('title' => ""));
          echo '</a>';
        }
        ?>
          <h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
      <?php the_title(); ?></a></h2>  
        <p class="meta home"><?php edit_post_link(__('Edit This', 'youare'), '<strong>', '</strong>. '); ?> <?php the_date(); ?>. <?php comments_number(__('No comments', 'youare'), __('1 comment', 'youare'), __('% comments', 'youare')); ?> </p>
        <div class="intro">
        
        <?php the_excerpt(__('read more...', 'youare')); ?> 
        </div>			   				   				   
      </article>

       </div> <!--end splash-->
      </div> <!--end row-->
    </div> <!--end container-->  

    <?php } else { // Next posts [2, 3, 4], [5, 6, 7] if it's paged or all posts if it's paged ?>	
      <?php
      if (($cont == 2 && !is_paged()) || ($cont == 1 && is_paged())) {
        if (is_paged()) {
          $dif = 0;
          ?>
          <h1 class="title"><?php _e('Page ', 'youare');
          echo $paged; ?></h1>
        </div> <!--end row-->
      </div> <!--end container-->
    </div> <!--end splash-->  
        <?php } ?>
        <div class="container">
          <div class="row content-background bottom_corner">

            <div id="content"> 

              <div class="twelvecol">
      <?php } ?>

              <article class="fourcol block_bottom <?php if (($cont - $dif) % 3 == 0) { echo "last"; } ?>">			                

                <div class="excerpt">   
                  <h3 class="title">
                    <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
      <?php the_title(); ?></a>
                  </h3>  

                  <p class="meta"><?php the_date(); ?> <?php edit_post_link(__('Edit This', 'youare'), '<strong>', '</strong>'); ?></p>   

                  <?php
                  if (has_post_thumbnail()) { // check if the post has a Post Thumbnail assigned to it.
                    echo '<a href="' . get_permalink() . '" title="' . get_the_title() . '">';
                    the_post_thumbnail('normal');
                    echo '</a>';
                  }
                  ?>
      <?php the_excerpt(__('read more...', 'youare')); ?>  

                </div><!--end excerpt-->	

              </article>

              <?php
            }
          }
        }
        ?>

     		
			 <div class="clear pcenter">
           			 <?php wp_pagenavi(); ?>
           		 </div>

      </div> <!--end twelvecol-->
    </div> <!--end content-->

  </div> <!--end row-->
</div><!--end container-->


<?php get_footer(); ?>