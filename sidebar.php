      <div id="sidebar" class="fourcol last">
      
      		<?php if ( is_single() || is_page() ) : ?>
                
                                <?php the_meta(); ?>
      
     			 <?php 
if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
  the_post_thumbnail('single', array('title' => ""));
} 
?>
 
 		 <?php endif; ?>
 
<?php 
global $wp_registered_sidebars;
foreach($wp_registered_sidebars as $sidebar_id=>$side) {
  if ($side["exclusive"]) continue;
  if ( !function_exists('dynamic_sidebar') || !is_visible_sidebar($side) || !dynamic_sidebar($sidebar_id) ) { }
}
?>

      </div><!--end sidebar-->
    </div> <!--end content-->
  </div> <!--end row-->
</div><!--end container-->