<?php
/*
Template Name: Archives Index
*/
?>

<?php get_header(); ?>	 

<?php 
$numposts = (int) $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish'"); 
$numcomms = (int) $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->comments WHERE comment_approved = '1'"); 
$numcats = wp_count_terms('category'); 

?> 
     

      <div class="pright comments"><strong><?php echo sprintf(__('%s posts. %s categories', 'youare'), $numposts, $numcats); ?></strong></div>
       

  <h1><?php the_title();?></h1>
  

   </div> <!--end splash-->
  </div> <!--end row-->
</div> <!--end container-->  

<div class="container">
  <div class="row content-background bottom_corner">
    <div id="content"> 

	
      <div class="eightcol singlepost">  
		
		<?php get_search_form(); ?>

			<script type="text/javascript">
				// focus on search field after it has loaded
				document.getElementById('s') && document.getElementById('s').focus();
			</script>
     		
<?php 
  // Getting all posts
  $all_posts = $wpdb->get_results("select ID, post_date, post_title from $wpdb->posts where post_status = 'publish' and post_type = 'post' order by post_date desc");
foreach($all_posts as $p) {
  $y = strftime('%Y', strtotime($p->post_date));
  $m = strftime('%m', strtotime($p->post_date));
  if (!isset($year_list[$y])) $year_list[$y] = array();
  if (!isset($year_list[$y][$m])) $year_list[$y][$m] = array();
  // Creating a matrix grouping posts by year and month
  $year_list[$y][$m][] = $p;
}

?>
<ul id="smart-archives-block">
<?php foreach($year_list as $y=>$item) { ?>
  <li><strong><a href="<?php  echo get_home_url(); echo '/'.$y; ?>"><?php echo $y; ?></a>:</strong>
<?php 
  for($i=1; $i<13; $i++) {
    $m = ($i<10?'0':'').$i;
    if (isset($item[$m])) {
      // Full month
?> <a href="<?php  echo get_home_url(); echo '/'.$y.'/'.$m; ?>"><?php echo mysql2date('M', $y.'-'.$m.'-01 00:00:00', true); ?></a><?php
    } else {
      // Empty month
?><span class="empty-month"><?php echo mysql2date('M', $y.'-'.$m.'-01 00:00:00', true); ?></span><?php
    }
  } ?>
  </li>
<?php } ?>
</ul>      
<div id="smart-archives-list">
<?php 
foreach($year_list as $y=>$item) { 
  foreach($item as $m=>$elems) {
?>
<h2><a href="<?php  echo get_home_url(); echo '/'.$y.'/'.$m; ?>"><?php echo mysql2date('M Y', $y.'-'.$m.'-01 00:00:00', true); ?></a></h2>
<ul>
<?php
    foreach($elems as $p) {
?>
<li><a href="<?php echo get_permalink($p->ID); ?>"><?php echo apply_filters('the_title', $p->post_title); ?></a></li>
<?php
    }
?>
</ul>
<?php
  }
}
?>
		</div>   
	</div><!--end singlepost-->

	<div id="sidebar" class="fourcol last">  

		<?php dynamic_sidebar('sidebar-archives'); ?>

	</div><!--end sidebar-->


  </div> <!--end content-->

 </div> <!--end row-->
</div><!--end container-->

<?php get_footer(); ?>