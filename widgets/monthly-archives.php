<?php

class You_Monthly_Archives extends WP_Widget {

  /**
   * Widget setup.
   */
  function You_Monthly_Archives() {
    /* Widget settings. */
    $widget_ops = array('classname' => '', 'description' => __('Widget showing monthly archive grouped by year', 'youare'));

    /* Widget control settings. */
    $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'monthly-archives-widget');

    /* Create the widget. */
    $this->WP_Widget('monthly-archives-widget', __('Custom Monthly archive grouped by year', 'youare'), $widget_ops, $control_ops);
  }

  /**
   * How to display the widget on the screen.
   */
  function widget($args, $instance) {
    extract($args);
    $title = apply_filters('widget_title', $instance['title']);
    echo $before_widget;
    ?><h2 class="widget"><?php echo $title ? $title : __('Archives', 'youare'); ?></h2><?php
    get_year_archives('monthly');
    echo $after_widget;
  }

  /**
   * Update the widget settings.
   */
  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);

    return $instance;
  }

  /**
   * Displays the widget settings controls on the widget panel.
   * Make use of the get_field_id() and get_field_name() function
   * when creating your form elements. This handles the confusing stuff.
   */
  function form($instance) {
    $defaults = array('title' => __('Archives', 'youare'));
    $instance = wp_parse_args((array) $instance, $defaults);
    ?>
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'youare'); ?></label>
      <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />

    </p>
    <p><em><?php _e('This widget will show a list of months', 'youare'); ?></em></p>
    <?php
  }

}

