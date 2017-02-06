<?php

// Lists most popular tags in a widget (Robin Dalton - http://bit.ly/qGeSZu)

function popular_tags_load_widget() {
	register_widget( 'Most_Popular_tags_Widget' );
}

class Most_Popular_tags_Widget extends WP_Widget {
			
	/* Set up some default widget settings. */
	var $defaults = array();

	function Most_Popular_tags_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'populartags', 'description' => __('Display popular tags.', 'youare') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'poptags-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'poptags-widget', __('Custom Most Popular Tags', 'youare'), $widget_ops, $control_ops );
		
		$this->defaults = array ('taglist_title' => __( 'Tags', 'youare' ),
							'taglist_show_count' => 1,
							'taglist_order' => 1,
							'taglist_limit' => 10,
							'taglist_dropdown' => 0,
							'taglist_tag_exc' => '',
							'taglist_exclude_zero' => 1,
							'taglist_cache' => ''
						 );
		
		if(!get_option('populartags')) {
			add_option('populartags', $this->defaults);
		}
	}
	
	function widget( $args, $instance ) {
		extract( $args );		
		$cache = get_option('populartags');
		
		echo $before_widget;
		if($instance['taglist_title'] != '') {
			echo $before_title . $instance['taglist_title'] . $after_title;
		}
		
		echo $cache['taglist_cache'];
		
		echo $after_widget;	
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		foreach($new_instance as $key => $val) {
			$instance[$key] = strip_tags( $new_instance[$key] );
		}
		$instance['taglist_show_count'] = ( $new_instance['taglist_show_count'] == 1 ) ? 1 : 0;
		$instance['taglist_dropdown'] = ( $new_instance['taglist_dropdown'] == 1 ) ? 1 : 0;
		$instance['taglist_exclude_zero'] = ( $new_instance['taglist_exclude_zero'] == 1) ? 1 : 0;

		update_option('populartags', $instance);
		taglist_generate_tag_cache();

		return $instance;
	}

	function form( $instance ) {
		
		$instance = wp_parse_args( (array) $instance, $this->defaults ); 
		
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'taglist_title' ); ?>"><?php _e('Title:', 'youare'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'taglist_title' ); ?>" name="<?php echo $this->get_field_name( 'taglist_title' ); ?>" value="<?php echo $instance['taglist_title']; ?>" style="width:225px;" />
		</p>

		<p>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'taglist_show_count' ); ?>" name="<?php echo $this->get_field_name( 'taglist_show_count' ); ?>" value="1"<?php echo ($instance['taglist_show_count'] == 1) ? ' checked="checked"' : ''; ?>>
			<label for="<?php echo $this->get_field_id( 'taglist_show_count' ); ?>"><?php _e('Display Count', 'youare'); ?></label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'taglist_order' ); ?>"><?php _e('Tag List order:', 'youare'); ?></label>
			<select id="<?php echo $this->get_field_id( 'taglist_order' ); ?>" name="<?php echo $this->get_field_name( 'taglist_order' ); ?>">
				<option value="1"<?php echo ($instance['taglist_order'] == 1) ? ' selected="selected"' : ''; ?>><?php _e('Most Popular', 'youare'); ?></option>
				<option value="2"<?php echo ($instance['taglist_order'] == 2) ? ' selected="selected"' : ''; ?>><?php _e('Alphabetical', 'youare'); ?></option>
				</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'taglist_limit' ); ?>"><?php _e('Tag Limit:', 'youare'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'taglist_limit' ); ?>" name="<?php echo $this->get_field_name( 'taglist_limit' ); ?>" value="<?php echo $instance['taglist_limit']; ?>" style="width:50px;" /><br />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'taglist_tag_exc' ); ?>"><?php _e('Exclude Tag by name:', 'youare'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'taglist_tag_exc' ); ?>" name="<?php echo $this->get_field_name( 'taglist_tag_exc' ); ?>" value="<?php echo $instance['taglist_tag_exc']; ?>" style="width:225px;" />
			<span style="font-size:.9em;"><?php _e('Separate names by comma.', 'youare'); ?></span>
		</p>
		
		<p>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'taglist_exclude_zero' ); ?>" name="<?php echo $this->get_field_name( 'taglist_exclude_zero' ); ?>" value="1"<?php echo ($instance['taglist_exclude_zero'] == 1) ? ' checked="checked"' : ''; ?>>
			<label for="<?php echo $this->get_field_id( 'taglist_exclude_zero' ); ?>"><?php _e('Exclude tags with 0 posts', 'youare'); ?></label>
		</p>

		<p>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'taglist_dropdown' ); ?>" name="<?php echo $this->get_field_name( 'taglist_dropdown' ); ?>" value="1"<?php echo ($instance['taglist_dropdown'] == 1) ? ' checked="checked"' : ''; ?>>
			<label for="<?php echo $this->get_field_id( 'taglist_dropdown' ); ?>"><?php _e('Display as a drop down', 'youare'); ?></label>
		</p>
		
	<?php
	}
}

function taglist_generate_tag_cache() {
	global $wpdb;
	
	$instance = get_option('populartags');
    $tag_exc_sql = '';
    if($instance['taglist_tag_exc'] != '') {
      $exc_tag = implode(',', array_map(
        create_function('$cat', 'return "\'".trim($cat)."\'";'),
        explode(',', $instance['taglist_tag_exc'])
      )); 
      $tag_exc_sql =  'AND a.name NOT IN ('.$exc_tag.') AND a.slug NOT IN ('.$exc_tag.')';
    }
    $ex_zero = ($instance['taglist_exclude_zero'] == 1) ? 'AND b.count != \'0\'' : '';
    
    $query = "SELECT a.name, a.slug, b.term_id, b.count FROM $wpdb->term_taxonomy b
    			LEFT JOIN $wpdb->terms a
    			ON b.term_id = a.term_id
    			WHERE b.taxonomy = 'post_tag'
    			$ex_zero
    			$tag_exc_sql
    			ORDER BY b.count DESC
    			LIMIT $instance[taglist_limit]";

    
    $get_tags = $wpdb->get_results($query);
    
    if($get_tags) {
    	if($instance['taglist_order'] == 2) {
    		usort($get_tags, "resort_tag_list");
    	}
    	
    	if($instance['taglist_dropdown'] == 1) {
    		
    		$cache = '<select onChange="document.location.href=this.options[this.selectedIndex].value;">';
			$cache .= "<option>tags</option>\n";
			
			foreach($get_tags as $cat) {
				$cache .= "<option value=\"" . get_tags_link( $cat->term_id ) . "\">".$cat->name;
					if($instance['taglist_show_count'] == 1) {
						$cache .= " (".$cat->count.")";
					}
				$cache .= "</option>\n";
			}
			$cache .= "</select>\n";
			
		} else {
    
   			$cache = '<ul class="popular-tag-list">';
    
			foreach($get_tags as $cat) {
				$cache .= '<li><a href="' . get_tag_link( $cat->term_id ) . '">' . $cat->name;
					if($instance['taglist_show_count'] == 1) {
						$cache .= ' (' . $cat->count . ')';
					}
				$cache .= '</a></li>';
			}
	
			$cache .= '</ul>';
		}
	
	$instance['taglist_cache'] = $cache;

	update_option('populartags', $instance);
	}	
}
function resort_tag_list($a, $b) {
    return strcmp($a->name, $b->name);
}
function jme_tags_list($args=array()) {
	// set default options
	$default = array ( 'show_count' => 1,
						'order' => 1,
						'limit' => 10,
						'dropdown' => 0,
						'cat_exc' => '',
						'exclude_zero' => 1
					 );
	$option['taglist_show_count'] = ($args['show_count'] == 0) ? $args['show_count'] : $default['show_count'];
	$option['taglist_order'] = ($args['order'] == 2) ? $args['order'] : $default['order'];
	$option['taglist_limit'] = ($args['limit']) ? $args['limit'] : $default['limit'];
	$option['taglist_dropdown'] = ($args['dropdown'] == 1) ? $args['dropdown'] : $default['dropdown'];
	$option['taglist_tag_exc'] = ($args['cat_exc'] != '') ? $args['cat_exc'] : $default['cat_exc'];
	$option['taglist_exclude_zero'] = ($args['exclude_zero'] == 0) ? $args['exclude_zero'] : $default['exclude_zero'];
	update_option('populartags',$option);
	taglist_generate_tag_cache();
	$cache = get_option('populartags');
	echo $cache['taglist_cache'];
}

add_action('widgets_init', 'popular_tags_load_widget');

add_action('edit_post', 'taglist_generate_tag_cache');
add_action('delete_post', 'taglist_generate_tag_cache');
add_action('publish_post', 'taglist_generate_tag_cache');