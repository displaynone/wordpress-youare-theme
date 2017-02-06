<?php

class You_Follow_Links extends WP_Widget {

  /**
   * Widget setup.
   */
  function You_Follow_Links() {
    /* Widget settings. */
    $widget_ops = array('classname' => 'subscribe fixed', 'description' => __('Widget for follow links, your social identity: Twitter, Facebook, Google+, LinkedIn', 'youare'));

    /* Widget control settings. */
    $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'follow-links-widget');

    /* Create the widget. */
    $this->WP_Widget('follow-links-widget', __('Custom Follow Links', 'youare'), $widget_ops, $control_ops);
  }

  /**
   * How to display the widget on the screen.
   */
  function widget($args, $instance) {
    extract($args);

    /* Our variables from the widget settings. */
    $title = apply_filters('widget_title', $instance['title']);
    $show_twitter = isset($instance['show_twitter']) ? $instance['show_twitter'] : false;
    $show_facebook = isset($instance['show_facebook']) ? $instance['show_facebook'] : false;
    $show_googleplus = isset($instance['show_googleplus']) ? $instance['show_googleplus'] : false;
    $show_linkedin = isset($instance['show_linkedin']) ? $instance['show_linkedin'] : false;
		echo $before_widget;

    if (false && $title)
      echo $before_title . $title . $after_title;

    if ($show_twitter || $show_facebook || $show_googleplus || $show_linkedin) {
      ?>
      <p class="subscribe">

        <?php
        if ($show_twitter) {
          $twitter = get_option('Y_twitter');
          if ($twitter) {
            ?>    <strong><a class="external twitter" title="Twitter" href="http://www.twitter.com/<?php echo $twitter; ?>">Twitter</a></strong> <?php
        }
      }
        ?>
        <?php
        if ($show_facebook) {
          $facebook = get_option('Y_facebook');
          if ($facebook) {
            ?>    <strong><a class="external facebook" title="Facebook" href="http://www.facebook.com/<?php echo $facebook; ?>">Facebook</a></strong> <?php
        }
      }
        ?>
        <?php
        if ($show_googleplus) {
          $googleplus = get_option('Y_googleplus');
          if ($googleplus) {
            ?>    <strong><a rel="me" class="external googleplus" title="Google Plus" href="https://plus.google.com/<?php echo $googleplus; ?>?rel=author">Google+</a></strong> <?php
        }
      }
        ?>
        <?php
        if ($show_linkedin) {
          $linkedin = get_option('Y_linkedin');
          if ($linkedin) {
            ?>    <strong class="last"><a class="external linkedin" title="LinkedIn" href="http://www.linkedin.com/in/<?php echo $linkedin; ?>">LinkedIn</a></strong> <?php
        }
      }
        ?>
      </p>
      <?php
		echo $after_widget;
    }
  }

  /**
   * Update the widget settings.
   */
  function update($new_instance, $old_instance) {
    $instance = $old_instance;

    $instance['title'] = strip_tags($new_instance['title']);
    $instance['picture'] = strip_tags($new_instance['picture']);
    $instance['show_twitter'] = $new_instance['show_twitter'] == 'on';
    $instance['show_facebook'] = $new_instance['show_facebook'] == 'on';
    $instance['show_googleplus'] = $new_instance['show_googleplus'] == 'on';
    $instance['show_linkedin'] = $new_instance['show_linkedin'] == 'on';

    return $instance;
  }

  /**
   * Displays the widget settings controls on the widget panel.
   * Make use of the get_field_id() and get_field_name() function
   * when creating your form elements. This handles the confusing stuff.
   */
  function form($instance) {

    /* Set up some default widget settings. */
    $defaults = array('title' => __('About', 'youare'), 'show_twitter' => true, 'show_facebook' => true, 'show_googleplus' => true, 'show_linkedin' => true);
    $instance = wp_parse_args((array) $instance, $defaults);
    ?>

    <?php
    $twitter = get_option('Y_twitter');
    $facebook = get_option('Y_facebook');
    $googleplus = get_option('Y_googleplus');
    $linkedin = get_option('Y_linkedin');
    ?>
    <style>.inactive_item {font-style: italic; color: #ccc;} .inactive_item span { color: #F33; }</style>
    <p><?php _e('You must configure your social accounts in YouAre Theme Options', 'youare'); ?></p>
    <p>
      <input class="checkbox" type="checkbox" <?php checked($instance['show_twitter'], true); ?> id="<?php echo $this->get_field_id('show_twitter'); ?>" name="<?php echo $this->get_field_name('show_twitter'); ?>" <?php echo!$twitter ? ' disabled="disabled" ' : '' ?>/> 
      <label for="<?php echo $this->get_field_id('show_twitter'); ?>" <?php echo!$twitter ? ' class="inactive_item" ' : '' ?>><?php _e('Show Twitter?', 'youare'); ?> <?php echo!$twitter ? ' <span>Not configured</span> ' : '' ?></label>
    </p>

    <p>
      <input class="checkbox" type="checkbox" <?php checked($instance['show_facebook'], true); ?> id="<?php echo $this->get_field_id('show_facebook'); ?>" name="<?php echo $this->get_field_name('show_facebook'); ?>" <?php echo!$facebook ? ' disabled="disabled" ' : '' ?>/> 
      <label for="<?php echo $this->get_field_id('show_facebook'); ?>" <?php echo!$facebook ? ' class="inactive_item" ' : '' ?>><?php _e('Show Facebook?', 'youare'); ?> <?php echo!$facebook ? ' <span>Not configured</span> ' : '' ?></label>
    </p>

    <p>
      <input class="checkbox" type="checkbox" <?php checked($instance['show_googleplus'], true); ?> id="<?php echo $this->get_field_id('show_googleplus'); ?>" name="<?php echo $this->get_field_name('show_googleplus'); ?>" <?php echo!$googleplus ? ' disabled="disabled" ' : '' ?>/> 
      <label for="<?php echo $this->get_field_id('show_googleplus'); ?>" <?php echo!$googleplus ? ' class="inactive_item" ' : '' ?>><?php _e('Show Google+?', 'youare'); ?> <?php echo!$googleplus ? ' <span>Not configured</span> ' : '' ?></label>
    </p>

    <p>
      <input class="checkbox" type="checkbox" <?php checked($instance['show_linkedin'], true); ?> id="<?php echo $this->get_field_id('show_linkedin'); ?>" name="<?php echo $this->get_field_name('show_linkedin'); ?>" <?php echo!$linkedin ? ' disabled="disabled" ' : '' ?>/> 
      <label for="<?php echo $this->get_field_id('show_linkedin'); ?>" <?php echo!$linkedin ? ' class="inactive_item" ' : '' ?>><?php _e('Show LinkedIn?', 'youare'); ?> <?php echo!$linkedin ? ' <span>Not configured</span> ' : '' ?></label>
    </p>

    <?php
  }

}