<?php
$footer_corp = get_option('Y_promo_footer');
$footer_tagline = get_option('Y_footer_tagline');
$footer_content = get_option('Y_footer_content');
?> 

<section id="promo_down" class="container">
  <div class="row bg bottomcorner">
    <div class="splash ">
      <div class="twelvecol">
      	<?php
      if (($footer_corp == 'true')) {
        ?>
        <h2><?php echo $footer_tagline; ?></h2>
        <?php
        echo stripslashes($footer_content);
      } else {
        ?>

        <a href=""><img class="alignright" src="<?php bloginfo('template_url'); ?>/images/logo_promo_footer.png" alt="<?php _e('Logo', 'youare'); ?>" /></a>

        <h2 class="title"><?php _e('Your Company tag line or Featured work', 'youare'); ?></h2>
        <p><?php _e('Company services. Go to YouAre Options menu (the Footer Promo section) in WP Dashboard.', 'youare'); ?></p>
        <?php
      }
      ?>

      </div><!--end twelvecol-->

    </div><!--end splash-->
  </div><!--end row-->
</section><!--end container-->

<footer class="container">
  <div class="row">
			<nav id="mobile">
         	 <?php wp_nav_menu(array('theme_location' => 'header-menu')); ?>
          </nav>
    
	<div class="twelvecol">


	<p class="pright"><a rel="external" class="wordpress" href="http://wordpress.org" title="WordPress">WordPress</a> 
        <a class="rss" href="<?php bloginfo('rss2_url'); ?> " title="RSS">RSS</a> </p>

		<p><?php include (COPY); ?></p>

	 </div><!--end twelvecol-->
  </div><!--end row-->
</footer>
<?php
wp_footer();

$tmp_stats_code = get_option('Y_stats_code');
if ($tmp_stats_code != '') {
  echo stripslashes($tmp_stats_code);
}
?>
</body>
</html>