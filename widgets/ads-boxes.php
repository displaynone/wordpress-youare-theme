<?php

class You_Ads_Boxes extends WP_Widget {

  /**
   * Widget setup.
   */
  function You_Ads_Boxes() {
    /* Widget settings. */
    $widget_ops = array('classname' => 'ads_boxes clear', 'description' => __('Two 125x125 ads blocks', 'youare'));

    /* Widget control settings. */
    $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'ads-boxes-widget');

    /* Create the widget. */
    $this->WP_Widget('ads-boxes-widget', __('Custom Ads', 'youare'), $widget_ops, $control_ops);
  }

  /**
   * How to display the widget on the screen.
   */
  function widget($args, $instance) {
    extract($args);

    /* Our variables from the widget settings. */
    $title = apply_filters('widget_title', $instance['title']);
    $ad1_link = $instance['ad1_link'];
    $ad1_picture = $instance['ad1_picture'];
    $ad1_alt = $instance['ad1_alt'];
    $ad2_link = $instance['ad2_link'];
    $ad2_picture = $instance['ad2_picture'];
    $ad2_alt = $instance['ad2_alt'];

    echo $before_widget;
    ?>
      <h2 class="widget"><?php echo $title ? $title : __('Ads', 'youare'); ?></h2>
      <a href="<?php echo ($ad1_link) ? htmlspecialchars($ad1_link, UTF - 8) : "#"; ?>"><img class="alignleft" src="<?php echo $ad1_picture ? (preg_match('#http://#', $ad1_picture) ? $ad1_picture : bloginfo('template_url') . '/images/sidebar/' . $ad1_picture ) : bloginfo('template_url') . '/images/sidebar/125_ad.gif'; ?>" width="125" height="125" alt="<?php echo stripslashes($ad1_alt); ?>" /></a>
      <a href="<?php echo ($ad2_link) ? htmlspecialchars($ad2_link, UTF - 8) : "#"; ?>"><img class="alignright" src="<?php echo $ad2_picture ? (preg_match('#http://#', $ad2_picture) ? $ad2_picture : bloginfo('template_url') . '/images/sidebar/' . $ad2_picture ) : bloginfo('template_url') . '/images/sidebar/125_ad.gif'; ?>" width="125" height="125" alt="<?php echo stripslashes($ad2_alt); ?>" /></a>
    </aside><!--end bnbox-->
    
    <?php
    /* After widget (defined by themes). */
    echo $after_widget;
  }

  /**
   * Update the widget settings.
   */
  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['ad1_link'] = strip_tags($new_instance['ad1_link']);
    $instance['ad1_picture'] = strip_tags($new_instance['ad1_picture']);
    $instance['ad1_alt'] = strip_tags($new_instance['ad1_alt']);
    $instance['ad2_link'] = strip_tags($new_instance['ad2_link']);
    $instance['ad2_picture'] = strip_tags($new_instance['ad2_picture']);
    $instance['ad2_alt'] = strip_tags($new_instance['ad2_alt']);

    return $instance;
  }

  /**
   * Displays the widget settings controls on the widget panel.
   * Make use of the get_field_id() and get_field_name() function
   * when creating your form elements. This handles the confusing stuff.
   */
  function form($instance) {

    /* Set up some default widget settings. */
    $defaults = array('title' => __('Ads', 'youare'), 'ad1_link' => '', 'ad1_picture' => '', 'ad1_alt' => '', 'ad1_link' => '', 'ad1_picture' => '', 'ad1_alt' => '');
    $instance = wp_parse_args((array) $instance, $defaults);
    ?>
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'youare'); ?></label>
      <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
    </p>
    <p><strong><?php _e('Ads box 1', 'youare'); ?></strong></p>
    <p>
      <label for="<?php echo $this->get_field_id('ad1_link'); ?>"><?php _e('Link URL:', 'youare'); ?></label>
      <input id="<?php echo $this->get_field_id('ad1_link'); ?>" name="<?php echo $this->get_field_name('ad1_link'); ?>" value="<?php echo $instance['ad1_link']; ?>" style="width:100%;" />
      <label for="<?php echo $this->get_field_id('ad1_picture'); ?>"><?php _e('Image URL:', 'youare'); ?></label>
      <input id="<?php echo $this->get_field_id('ad1_picture'); ?>" name="<?php echo $this->get_field_name('ad1_picture'); ?>" value="<?php echo $instance['ad1_picture']; ?>" style="width:100%;" />
      <label for="<?php echo $this->get_field_id('ad1_alt'); ?>"><?php _e('Alternate text:', 'youare'); ?></label>
      <input id="<?php echo $this->get_field_id('ad1_alt'); ?>" name="<?php echo $this->get_field_name('ad1_alt'); ?>" value="<?php echo $instance['ad1_alt']; ?>" style="width:100%;" />
    </p>

    <p><strong><?php _e('Ads box 2', 'youare'); ?></strong></p>
    <p>
      <label for="<?php echo $this->get_field_id('ad2_link'); ?>"><?php _e('Link URL:', 'youare'); ?></label>
      <input id="<?php echo $this->get_field_id('ad2_link'); ?>" name="<?php echo $this->get_field_name('ad2_link'); ?>" value="<?php echo $instance['ad2_link']; ?>" style="width:100%;" />
      <label for="<?php echo $this->get_field_id('ad2_picture'); ?>"><?php _e('Image URL:', 'youare'); ?></label>
      <input id="<?php echo $this->get_field_id('ad2_picture'); ?>" name="<?php echo $this->get_field_name('ad2_picture'); ?>" value="<?php echo $instance['ad2_picture']; ?>" style="width:100%;" />
      <label for="<?php echo $this->get_field_id('ad2_alt'); ?>"><?php _e('Alternate text:', 'youare'); ?></label>
      <input id="<?php echo $this->get_field_id('ad2_alt'); ?>" name="<?php echo $this->get_field_name('ad2_alt'); ?>" value="<?php echo $instance['ad2_alt']; ?>" style="width:100%;" />
    </p>

    <?php
  }

}

