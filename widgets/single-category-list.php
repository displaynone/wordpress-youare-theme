<?php

class You_Single_Category_List extends WP_Widget {

  /**
   * Widget setup.
   */
  function You_Single_Category_List() {
    /* Widget settings. */
    $widget_ops = array('classname' => 'single_categories fixed', 'description' => __('Widget showing category list for a single post', 'youare'));

    /* Widget control settings. */
    $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'single-category-list-widget');

    /* Create the widget. */
    $this->WP_Widget('single-category-list-widget', __('Custom Single Category List', 'youare'), $widget_ops, $control_ops);
  }

  /**
   * How to display the widget on the screen.
   */
  function widget($args, $instance) {
    extract($args);

    /* Our variables from the widget settings. */
    $title = apply_filters('widget_title', $instance['title']);

    if (false && $title)
      echo $before_title . $title . $after_title;
    ?>
    <?php if (is_single()) : ?>
      <?php echo $before_widget; ?>
        <p class="folder"><?php the_category(', ') ?></p>
      <?php echo $after_widget; ?>
    <?php endif; ?>
    <?php
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
    $defaults = array();
    $instance = wp_parse_args((array) $instance, $defaults);
    ?>
    <p><?php _e('This widget is only showed when it is a single post', 'youare'); ?></p>
    <?php
  }

}

