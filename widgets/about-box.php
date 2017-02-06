<?php

class You_About_Box extends WP_Widget {

  /**
   * Widget setup.
   */
  function You_About_Box() {
    /* Widget settings. */
    $widget_ops = array('classname' => 'bg_side about_box fixed', 'description' => __('A Short Author Bio. Your bio is defined in YouAre Theme Options', 'youare'));

    /* Widget control settings. */
    $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'about-box-widget');

    /* Create the widget. */
    $this->WP_Widget('about-box-widget', __('Custom Author Box Sidebar', 'youare'), $widget_ops, $control_ops);
  }

  /**
   * How to display the widget on the screen.
   */
  function widget($args, $instance) {
    extract($args);

    /* Our variables from the widget settings. */
    $title = apply_filters('widget_title', $instance['title']);
    $show_links = isset($instance['show_links']) ? $instance['show_links'] : false;
    $show_in_about_page = isset($instance['show_in_about_page']) ? $instance['show_in_about_page'] : false;
//		if ( $title )
//			echo $before_title . $title . $after_title;
    $about = get_option('Y_about');
    $author_page = get_option('Y_author_page');
    if ($show_in_about_page || (!$show_in_about_page && get_the_ID() != $author_page)) {
  		echo $before_widget;
      ?>
      <!--aside class="bg_side fixed <?php echo $classname; ?>"-->
        <div>
      <?php
      if ($about && $author_page) {
        ?>
            <h2 class="widget"><a rel="author" href="<?php echo get_permalink($author_page) ?>"><?php echo $title ? $title : __('About the author', 'youare'); ?></a></h2>
            <p><?php echo stripslashes($about); ?>  <a rel="author" href="<?php echo get_permalink($author_page) ?>"><?php _e('Read more', 'youare'); ?></a></p>
            <?php
          } else {
            ?>
            <p><?php _e('Go to YouAre Options menu in your WP Dashboard and check out the Author Box Sidebar section.', 'youare'); ?></p>
            <?php
          }
          $id = get_the_ID();
          if ($show_links && $author_page != $id) {
            $fl = new You_Follow_Links();
            $fl->widget(array(), array('show_twitter' => get_option('Y_twitter'), 'show_facebook' => get_option('Y_facebook'), 'show_googleplus' => get_option('Y_googleplus'), 'show_linkedin' => get_option('Y_linkedin')));
          }
          ?>    
        </div>
          <?php
          echo $after_widget;
        }

        /* After widget (defined by themes). */
      }

      /**
       * Update the widget settings.
       */
      function update($new_instance, $old_instance) {
        $instance = $old_instance;
//var_dump($new_instance); exit();
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['show_links'] = $new_instance['show_links'] == 'on';
        $instance['show_in_about_page'] = $new_instance['show_in_about_page'] == 'on';


        return $instance;
      }

      /**
       * Displays the widget settings controls on the widget panel.
       * Make use of the get_field_id() and get_field_name() function
       * when creating your form elements. This handles the confusing stuff.
       */
      function form($instance) {

        /* Set up some default widget settings. */
        $defaults = array('title' => __('About the author', 'youare'), 'show_links' => true, 'show_in_about_page' => true);
        $instance = wp_parse_args((array) $instance, $defaults);
        $twitter = get_option('Y_twitter');
        $facebook = get_option('Y_facebook');
        $googleplus = get_option('Y_googleplus');
        $linkedin = get_option('Y_linkedin');
        $has_links = $twitter || $facebook || $googleplus || $linkedin;
        ?>

    <style>.error_item {font-style: italic; color: #f33;} .description_item{color: #333; font-style: italic}</style>
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'youare'); ?></label>
      <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
    </p>
    <?php
    $about = get_option('Y_about');
    $author_page = get_option('Y_author_page');
    if (!$about) {
      ?>
      <p class="error_item"><?php _e('You must configure your description in YouAre Options', 'youare'); ?></p>
      <?php
    }
    if (!$author_page) {
      ?>
      <p class="error_item"><?php _e('You must configure your About Page in YouAre Options', 'youare'); ?></p>
      <?php
    }
    if ($author_page && $about) {
      $page = get_page($author_page);
      ?>
      <p class="description_item"><strong><?php _e('Page:', 'youare'); ?></strong><br /><a href="<?php echo get_permalink($author_page); ?>"><?php echo $page->post_title; ?></a><br /><strong><?php _e('Description:', 'youare'); ?></strong><br /><?php echo $about; ?></p>
      <?php
    }
    ?>
    <p>
      <input class="checkbox" type="checkbox" <?php checked($instance['show_in_about_page'], true); ?> id="<?php echo $this->get_field_id('show_in_about_page'); ?>" name="<?php echo $this->get_field_name('show_in_about_page'); ?>" /> 
      <label for="<?php echo $this->get_field_id('show_in_about_page'); ?>" ><?php _e('Show In About Page?', 'youare'); ?> </label>
    </p>
    <p>
      <input class="checkbox" type="checkbox" <?php checked($instance['show_links'], true); ?> id="<?php echo $this->get_field_id('show_links'); ?>" name="<?php echo $this->get_field_name('show_links'); ?>" <?php echo!$has_links ? ' disabled="disabled" ' : '' ?>/> 
      <label for="<?php echo $this->get_field_id('show_links'); ?>" <?php echo!$has_links ? ' class="inactive_item" ' : '' ?>><?php _e('Show Social Links?', 'youare'); ?> <?php echo!$has_links ? ' <span>Not configured</span> ' : '' ?></label>
    </p>    

    <?php
  }

}

