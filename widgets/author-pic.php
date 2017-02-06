<?php

class You_Author_Pic extends WP_Widget {

  /**
   * Widget setup.
   */
  function You_Author_Pic() {
    /* Widget settings. */
    $widget_ops = array('classname' => 'photo_author fixed', 'description' => __('Widget for Author Page, you must indicate your photo', 'youare'));

    /* Widget control settings. */
    $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'author-pic-widget');

    /* Create the widget. */
    $this->WP_Widget('author-pic-widget', __('Custom Author Photo', 'youare'), $widget_ops, $control_ops);
  }

  /**
   * How to display the widget on the screen.
   */
  function widget($args, $instance) {
    extract($args);

    /* Our variables from the widget settings. */
    $title = apply_filters('widget_title', $instance['title']);
    $picture = get_option('Y_photo_url_about');

    echo $before_widget;

    if (false && $title)
      echo $before_title . $title . $after_title;

    if ($picture) {
      ?>
      <figure>
        <img src="<?php echo $picture ? $picture : get_bloginfo('template_url') . '/images/sidebar/photo_default_about.jpg' ?>" alt="Photo" />
      </figure>
      <?php
    }

    /* After widget (defined by themes). */
    echo $after_widget;
  }

  /**
   * Update the widget settings.
   */
  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    return $instance;
  }

  /**
   * Displays the widget settings controls on the widget panel.
   * Make use of the get_field_id() and get_field_name() function
   * when creating your form elements. This handles the confusing stuff.
   */
  function form($instance) {

    /* Set up some default widget settings. */
    $defaults = array('title' => __('About', 'youare'), 'picture' => get_bloginfo('template_url') . '/images/sidebar/photo_default_about.jpg', 'show_social' => true);
    $instance = wp_parse_args((array) $instance, $defaults);
    ?>

    <p><?php _e('The photo is set in YouAre Theme Options, if you want to modify it you must go there', 'youare'); ?></p>

    <?php
  }

}

