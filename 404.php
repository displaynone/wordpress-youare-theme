<?php get_header(); ?>

      

        <h1 class="title"><?php _e('Error 404: Page Not Found', 'youare'); ?></h1>
        <?php get_search_form(); ?>
        <script type="text/javascript">
          // focus on search field after it has loaded
          document.getElementById('s') && document.getElementById('s').focus();
        </script>
      

    </div> <!--end splash-->
  </div> <!--end row-->
</div> <!--end container-->


<?php get_footer(); ?>