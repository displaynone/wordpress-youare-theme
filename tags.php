<?php
/*
  Template Name: Tags
 */
get_header();
?>


        <h1 class="title"><?php _e('Tags Archive', 'youare'); ?></h1>
        <p><?php _e('Tag Cloud', 'youare'); ?></p>
     


     </div> <!--end splash-->
    </div> <!--end row-->
  </div> <!--end container-->  

<div class="container">
  <div class="row content-background bottom_corner">
    <div id="content"> 
      <div class="eightcol singlepost"> 
        <?php
        get_search_form();
        if (function_exists('wp_tag_cloud')) {
          ?>
          <div id="tagcloud">
            <?php wp_tag_cloud('smallest=8&largest=22&number=30&orderby=name'); ?>
          </div>
          <?php
        }
        ?>
      </div><!--end singlepost-->

      <?php get_sidebar(); ?>
      <?php get_footer(); ?>