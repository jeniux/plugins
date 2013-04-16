<?php
/*
Plugin Name: Jeniux Flickr Widget
Plugin URI: http://jeniux.dk/flickr-widget
Description: Just a simple Flickr widget
Version: 1.0
Author: Josh Bryan
Author URI: http://jeniux.dk
License: GPLv2
*/

/* Copyright 2012 Jeniux Media (email : support@jeniux.dk)
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*/




//INSTALL
/*register_activation_hook( __FILE__, 'jx_social_install' );
function jx_social_install() {
  if (version_compare( get_bloginfo( 'version' ), '3.1', ' < ' ) ) {
		deactivate_plugins( basename( __FILE__ ) ); // Deactivate plugin
	}
}
*/
// INIT Widget
add_action( 'widgets_init', 'jeniux_flickr_widget_register' );

// REGISTER Widget
function jeniux_flickr_widget_register() {
register_widget( 'jeniux_flickr_widget' );
}


class jeniux_flickr_widget extends WP_Widget {

	
	function jeniux_flickr_widget() {

	  $widget_ops = array(
	  	'classname' => 'jeniux_flickr_widget_class',
	  	'description' => 'Just a simple Flickr Widget'
	  );
	  		

	$this-> WP_Widget( 'jeniux_flickr_widget', 'Jeniux Flickr Widget', $widget_ops);

	}

	
	function form($instance) {

	  $defaults = array(
	  	'title' => 'Flickr Jeniux',
		'flickr_username' => '94434802@N04',
		'flickr_size' => 's',
		'flickr_count' => '6',
		'flickr_display' => 'latest'

	  );
	  
	  $instance = wp_parse_args( (array) $instance, $defaults );
	  
	  $title = $instance['title'];
	  $flickr_username = $instance['flickr_username'];	
	  $flickr_size = $instance['flickr_size'];
	  $flickr_count = $instance['flickr_count'];  
	  $flickr_display = $instance['flickr_display'];  



  ?>

<p> Title:
  <input class="widefat" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<p> Flickr ID:
  <input class="widefat" name="<?php echo $this->get_field_name( 'flickr_username' ); ?>" type="text" value="<?php echo esc_attr( $flickr_username ); ?>" />
</p>
<p><small>If you are having trouble finding your Flickr ID, use this site(<a href="http://idgettr.com/">http://idgettr.com/</a>) to look up your ID by entering your username.</small></p>
<p> Image Size:
  <select name=" <?php echo $this->get_field_name( 'flickr_size' ); ?>" >
    <option value="s" <?php selected( $flickr_size, 's' ); ?> > Small </option>
    <option value="t" <?php selected( $flickr_size, 't' ); ?> > Thumbnail </option>
    <option value="m" <?php selected( $flickr_size, 'm' ); ?> > Medium </option>
  </select>
</p>
<p> Image Count:
  <select name=" <?php echo $this-> get_field_name( 'flickr_count' ); ?>" >
    <option value="1" <?php selected( $flickr_count, '1' ); ?> > 1 </option>
    <option value="2" <?php selected( $flickr_count, '2' ); ?> > 2 </option>
    <option value="3" <?php selected( $flickr_count, '3' ); ?> > 3 </option>
    <option value="4" <?php selected( $flickr_count, '4' ); ?> > 4 </option>
    <option value="5" <?php selected( $flickr_count, '5' ); ?> > 5 </option>
    <option value="6" <?php selected( $flickr_count, '6' ); ?> > 6 </option>
    <option value="7" <?php selected( $flickr_count, '7' ); ?> > 7 </option>
    <option value="8" <?php selected( $flickr_count, '8' ); ?> > 8 </option>
    <option value="9" <?php selected( $flickr_count, '9' ); ?> > 9 </option>
    <option value="10" <?php selected( $flickr_count, '10' ); ?> > 10 </option>
  </select>
</p>
<p> Display:
  <select name=" <?php echo $this-> get_field_name( 'flickr_display' ); ?>" >
    <option value="latest" <?php selected( $flickr_display, 'latest' ); ?> > Latest </option>
    <option value="random" <?php selected( $flickr_display, 'random' ); ?> > Random </option>
  </select>
</p>
<?php
	}
	
	
	
	
	function update($new_instance, $old_instance) {
	  $instance = $old_instance;
	  $instance['title'] = strip_tags( $new_instance['title'] );
	  $instance['flickr_username'] = strip_tags( $new_instance['flickr_username'] );
	  $instance['flickr_size'] = strip_tags( $new_instance['flickr_size'] );
	  $instance['flickr_count'] = strip_tags( $new_instance['flickr_count'] );
	  $instance['flickr_display'] = strip_tags( $new_instance['flickr_display'] );


	  return $instance;
	}
	
	
	
	
	function widget($args, $instance) {
	  extract($args);
	  
	  echo $before_widget;


      $title = empty( $instance['title'] ) ? '' : $instance['title'];
	  $flickr_username = empty( $instance['flickr_username'] ) ? '94434802@N04' : $instance['flickr_username'];
	  $flickr_size = empty( $instance['flickr_size'] ) ? 's' : $instance['flickr_size'];
	  $flickr_count = empty( $instance['flickr_count'] ) ? '6' : $instance['flickr_count'];	  	  
	  $flickr_display = empty( $instance['flickr_display'] ) ? 'latest' : $instance['flickr_display'];



	
	  
	  if ( !empty( $title ) ) { echo  $before_title . $title . $after_title; } else {echo $after_title; }
	  	
		if ( $flickr_username) { ?>
<div class="jx-flickr"> 
  <script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $flickr_count;?>&display=<?php echo $flickr_display;?>&source=user&amp;user=<?php echo $flickr_username;?>&size=<?php echo $flickr_size;?>"></script> 
</div>
<?php
		}
		
	  echo $after_widget;
	}
	
}



function jeniux_flckr_print_stylesheet() {
?><style type="text/css">/*WIDGET::FLICKR*/div.jx-flickr a{float:left;padding:4px;margin:4px;background:#eee;}div.jx-flickr a:hover{background:#addffe;}div.jx-flickr a img{border:0;margin:0px;}</style>
<?php
}
add_action( 'wp_print_styles', 'jeniux_flckr_print_stylesheet' );

?>
