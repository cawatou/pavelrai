<?php
/*** Widget code for Recent Sermons ***/
class recent_sermons extends WP_Widget {
	// constructor
	function recent_sermons() {
		 $widget_ops = array('description' => __( 'Display recent sermons.', 'imic-framework-admin') );
         parent::WP_Widget(false, $name = __('Recent Sermons','imic-framework-admin'), $widget_ops);
	}
	// widget form creation
	function form($instance) {
	
		// Check values
		if( $instance) {
			 $title = esc_attr($instance['title']);
			 $number = esc_attr($instance['number']);
		} else {
			 $title = '';
			 $number = '';
		}
	?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'imic-framework-admin'); ?></label>
            <input class="spTitle" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of sermons to show', 'imic-framework-admin'); ?></label>
            <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" />
        </p> 
	<?php
	}
	// update widget
	function update($new_instance, $old_instance) {
		  $instance = $old_instance;
		  // Fields
		  $instance['title'] = strip_tags($new_instance['title']);
		  $instance['number'] = strip_tags($new_instance['number']);
		  
		 return $instance;
	}
	// display widget
	function widget($args, $instance) {
            global $wp_query;
            $temp_wp_query = clone $wp_query;
	   extract( $args );
	   // these are the widget options
	   $post_title = apply_filters('widget_title', $instance['title']);
	   $number = apply_filters('widget_number', $instance['number']);
	   
	   $numberPost = (!empty($number))? $number : 3 ;	
	   	   
	   echo $args['before_widget'];
	   echo '<div class="listing sermons-listing">';	
		if( !empty($instance['title']) ){
			echo '<header class="listing-header">';
			echo $args['before_title'];
			echo apply_filters('widget_title',$instance['title'], $instance, $this->id_base);
			echo $args['after_title'];
			echo '</header>';
		}
$posts = query_posts(array('order'=>'DESC', 'post_type' => 'sermons', 'posts_per_page' => $numberPost, 'post_status' => 'publish'));
		if(!empty($posts)){ 
			echo '<section class="listing-cont">
					<ul>';
			 $liFirst = $liOthers = '';		
			 $flag = 0;
			 foreach($posts as $post){ 
			 	$custom = get_post_custom($post->ID);
				if(!empty($custom['imic_sermons_url'][0]) && $flag==0){
                               $liFirst .='<li class="item sermon featured-sermon">
                                    <span class="date">'.get_the_time(get_option('date_format'),$post->ID).'</span>
                                    <h4><a href="'.get_permalink($post->ID).'">'.$post->post_title.'</a></h4>
                                    <div class="featured-sermon-video">' . imic_video_embed($custom['imic_sermons_url'][0], '200', '150') . '</div><p>'.
                                      wp_trim_words($post->post_content,30)
                                    .'</p><div class="sermon-actions">';
									if (!empty($custom['imic_sermons_url'][0])) {
											$liFirst .= '<a href="' . get_permalink($post->ID) . '" data-placement="top" data-toggle="tooltip" data-original-title="' . __('Video', 'imic-framework-admin') . '"><i class="fa fa-video-camera"></i></a>';
									}
									 $attach_full_audio= imic_sermon_attach_full_audio($post->ID);
								         if (!empty($attach_full_audio)) {
										$liFirst .= '<a href="' . get_permalink($post->ID) . '#play-audio" data-placement="top" data-toggle="tooltip" data-original-title="' . __('Audio', 'imic-framework-admin') . '"><i class="fa fa-headphones"></i></a>';
									}
									if (!empty($attach_full_audio)) {
										$liFirst .= '<a href="' . get_template_directory_uri() . '/download/download.php?file=' . $attach_full_audio . '" data-placement="top" data-toggle="tooltip" data-original-title="' . __('Download Audio', 'imic-framework-admin') . '"><i class="fa fa-download"></i></a>';
									}
									 $attach_pdf= imic_sermon_attach_full_pdf($post->ID);
									if (!empty($attach_pdf)) {
									$liFirst .= '<a href="' . get_template_directory_uri() . '/download/download.php?file=' . $attach_pdf . '" data-placement="top" data-toggle="tooltip" data-original-title="' . __('Download PDF', 'imic-framework-admin') . '"><i class="fa fa-book"></i></a>';
									}
                                       
                            $liFirst .= '</div>
                                </li>';
								
				}else{
					$liOthers .= '<li class="item sermon">
                                    <h2 class="sermon-title"><a href="'.get_permalink($post->ID).'">'.$post->post_title.'</a></h2>
                                    <span class="meta-data"><i class="fa fa-calendar"></i>'.__(' on ','imic-framework-admin').get_the_time(get_option('date_format'),$post->ID).'</span>
                                </li>';
				}
                                $flag++;
			 }
			echo $liFirst.$liOthers; 
                        
			echo '</ul></section>';
		}else{
		   _e('No Sermon Found','imic-framework-admin');
		}
             echo '</div>';
	   echo $args['after_widget'];
           $wp_query = clone $temp_wp_query;
           
	}
}
// register widget
add_action('widgets_init', create_function('', 'return register_widget("recent_sermons");'));
?>