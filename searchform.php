<?php
global $search_form_showed;

if (!$search_form_showed) {
  $search_form_showed = true;
  ?>
  <form method="get" id="search_form" action="<?php echo home_url(); ?>/">
    <div class="aristo">
      <input type="text"  name="s" id="s" class="search" value="<?php the_search_query(); ?>" />

    </div>
  </form>
<?php } ?>
