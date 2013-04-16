<?php
/*
Plugin Name: Jeniux Latest News Widget
Plugin URI: http://jeniux.dk/latest-news-widget
Description: Just a simple latest news widget
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

// INIT Widget
add_action( 'widgets_init', 'jeniux_latest_news_widget_register' );

// REGISTER Widget
function jeniux_latest_news_widget_register() {
register_widget( 'jeniux_latest_news_widget' );
}


class jeniux_latest_news_widget extends WP_Widget {

  
	function jeniux_latest_news_widget() {
	  $widget_ops = array(
	  	'classname' => 'jeniux_latest_news_widget_class',
	  	'description' => 'Latest News Widget'
	  );
	  		

	$this->WP_Widget( 'jeniux_latest_news_widget', 'Jeniux Latest News Widget', $widget_ops);

	}


	function form($instance) {

	  $defaults = array(
	  	'title' => 'Flickr Jeniux',
		'news_count' => '5',
		'news_cat' => ''

	  );
	  
	  $instance = wp_parse_args( (array) $instance, $defaults );
	  
	  $title = $instance['title'];
	  $news_count = $instance['news_count'];  
	  $news_cat = $instance['news_cat'];  



  ?>

<p> Title:
  <input class="widefat" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<p> # News Items:
  <select name=" <?php echo $this->get_field_name( 'news_count' ); ?>" >
    <option value="1" <?php selected( $news_count, '1' ); ?> > 1 </option>
    <option value="2" <?php selected( $news_count, '2' ); ?> > 2 </option>
    <option value="3" <?php selected( $news_count, '3' ); ?> > 3 </option>
    <option value="4" <?php selected( $news_count, '4' ); ?> > 4 </option>
    <option value="5" <?php selected( $news_count, '5' ); ?> > 5 </option>
    <option value="6" <?php selected( $news_count, '6' ); ?> > 6 </option>
    <option value="7" <?php selected( $news_count, '7' ); ?> > 7 </option>
    <option value="8" <?php selected( $news_count, '8' ); ?> > 8 </option>
    <option value="9" <?php selected( $news_count, '9' ); ?> > 9 </option>
    <option value="10" <?php selected( $news_count, '10' ); ?> > 10 </option>
  </select>
</p>
<p> Category:
  <?php 
		  wp_dropdown_categories('name='. $this->get_field_name( 'news_cat' ).'&selected='.$news_cat.'&show_option_all=All&show_count=1&hierarchical=1'); ?>
</p>
<?php
	}
	
	
	
	
	function update($new_instance, $old_instance) {
	  $instance = $old_instance;
	  $instance['title'] = strip_tags( $new_instance['title'] );
	  $instance['news_count'] = strip_tags( $new_instance['news_count'] );
	  $instance['news_cat'] = strip_tags( $new_instance['news_cat'] );


	  return $instance;
	}
	
	
	
	
	function widget($args, $instance) {
	  extract($args);
	  
	  echo $before_widget;


      $title = empty( $instance['title'] ) ? '' : $instance['title'];
	  $news_count = empty( $instance['news_count'] ) ? '5' : $instance['news_count'];	  	  
	  $news_cat = empty( $instance['news_cat'] ) ? 'all' : $instance['news_cat'];

if ( !empty( $title ) ) { echo  $before_title . $title . $after_title; } else {echo $after_title; }?>
<div class="jx-latest-news-widget">
  <?php $latest = new WP_Query(); ?>
  <?php if($news_cat == 'all'): $latest->query('showposts='.$news_count.''); else: $latest->query('showposts='.$news_count.'&cat='.$news_cat.''); endif;

while ($latest->have_posts()) : $latest->the_post(); ?>
  <div class="jx-latest-news-widget-wrap">
    <div class="jx-latest-news-thumbnail">
      <?php if ( has_post_thumbnail() ) :?>
      <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
      <?php the_post_thumbnail();?>
      </a>
      <?php endif; ?>
    </div>
    <!-- #jx-latest-news-thumbnail -->
    
    <div class="jx-latest-news-content">
      <h6><a href="<?php the_permalink() ?>">
        <?php the_title(); ?>
        </a></h6>
      <div class="jx-latest-news-date">
        <?php the_date(); ?>
      </div>
      <!-- #jx-latest-news-date --> 
    </div>
    <!-- #jx-latest-news-content --> 
  </div>
  <!-- #jx-latest-news-widget-wrap -->
  <?php endwhile; wp_reset_query();?>
</div>
<!-- #jx-latest-news-widget --> 

<?php echo $after_widget;
	}
	
}



function jeniux_latest_news_print_stylesheet() {
?>
<style type="text/css">/* WIDGET::LATEST-NEWS*/div.jx-latest-news-widget{}div.jx-latest-news-widget-wrap { clear:both; margin-bottom: 1em; }div.jx-latest-news-widget .jx-latest-news-thumbnail { min-height: 40px; margin-bottom: 1em; padding: 4px; float: left; margin-right: .5em; min-width: 40px; }div.jx-latest-news-widget .jx-latest-news-thumbnail img { margin-top: -3px; display: block; width: 40px; border: 1px solid #ddd; padding: 3px; }div.jx-latest-news-widget .jx-latest-news-content { overflow: hidden; }div.jx-latest-news-widget h6 { line-height: 1; font-weight: normal; margin: 0; }div.jx-latest-news-widget .jx-latest-news-date { font-size: 11px; font-style: italic; }</style>
<?php
}
add_action( 'wp_print_styles', 'jeniux_latest_news_print_stylesheet' );
