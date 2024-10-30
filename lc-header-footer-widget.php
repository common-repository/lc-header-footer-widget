<?php
/*
Plugin Name: LC Header Footer Widget
Plugin URI: https://wordpress.org/plugins/lc-header-footer-widget/
Description: Add support for Live Composer Headers and Footers to themes that only have Widget support
Version: 1.1.5
Author: James Low
Author URI: http://jameslow.com
License: MIT License
*/

define( 'DS_LIVE_COMPOSER_HF', true );
define( 'DS_LIVE_COMPOSER_HF_AUTO', false );

class LC_Header_Footer_Widget extends WP_Widget {
	static $is_widget = false;
	var $current_id = null;
	var $current_type = null;
	
	public function __construct() {
		$description = 'Display the Live Composer Header/Footer in a widget';
		$classname = get_class($this);
		$options = array( 
			'classname' => $classname,
			'description' => $description,
		);
		parent::__construct($classname, 'LC Header/Footer Widget', $options);
	}
	public function get_post_metadata($value, $object_id, $meta_key, $single) {
		if ($object_id == $this->current_id && $meta_key == 'dslc_'.$this->current_type) {
			return $single ? $object_id : array($object_id);
		}
		return $value;
	}
	public function widget($args, $instance) {
		$page_id = $instance['page_id'];
		if (self::editing_hf()) {
			$settings = self::get_options(self::id());
			if (self::id() == $page_id || ($page_id == $settings['dslc_hf_for'][0] && $settings['dslc_hf_type'][0] == 'default')) {
				self::$is_widget = true;
				while (have_posts()) {
					the_post();
					the_content();
				}
				self::$is_widget = false;
				return;
			}
		}
		if (function_exists('dslc_hf_get_header')) {
			if (!self::editing_page()) {
				if ($page_id == 'header') {
					echo dslc_hf_get_header();
				} elseif ($page_id == 'footer') {
					echo dslc_hf_get_footer();
				} else {
					$settings = self::get_options($page_id);
					$this->current_id = $page_id;
					add_filter('get_post_metadata', array($this, 'get_post_metadata'), 10, 4);
					$this->current_type = 'header';
					if ($settings['dslc_hf_for'][0] == 'header') {
						echo dslc_hf_get_header($page_id);
					} elseif ($settings['dslc_hf_for'][0] == 'footer') {
						$this->current_type = 'footer';
						echo dslc_hf_get_footer($page_id);
					}
					$this->current_type = null;
					$this->current_id = null;
					remove_filter('get_post_metadata', array($this, 'get_post_metadata'), 10);
				}
			} else {
				echo '<a href="/wp-admin/edit.php?post_type=dslc_hf" target="_blank">Click here to edit header/footer</a>';
			}
		} else {
			echo 'Please install or activate the Live Composer plugin.';
		}
	}
	public function option($title, $id, $current) {
		echo '<option value="'.$id.'"'.($id==$current?' selected':'').'>'.$title.'</option>';
	}
	public function form($instance) {
		$page_id = $instance['page_id'];
	?>
		<p>
		<label for="<?php echo esc_attr($this->get_field_id('page_id') );?>">Header/Footer:</label>
		<select class="widefat" id="<?php echo esc_attr($this->get_field_id('page_id')); ?>" name="<?php echo esc_attr($this->get_field_name('page_id')); ?>">
	<?php
		self::option('(Default Header)','header',$page_id);
		self::option('(Default Footer)','footer',$page_id);
		$templates = self::get_templates();
		foreach ($templates as $template) {
			self::option($template->post_title,$template->ID,$page_id);
		}
	?>
		</select>
		</p>
	<?php
	}
	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['page_id'] = !empty($new_instance['page_id']) ? strip_tags($new_instance['page_id']) : 'header';
		return $instance;
	}
	public static function editing_hf() {
		return strpos($_SERVER['REQUEST_URI'], '/dslc_hf/') !== false;
	}
	public static function editing_page() {
		return isset($_GET['dslc']);
	}
	public static function id() {
		return sanitize_text_field($_GET['page_id']);
	}
	public static function type() {
		return get_post_meta(self::id(), 'dslc_hf_for', true);
	}
	public static function add_hooks() {
		add_action('widgets_init', array('LC_Header_Footer_Widget', 'widgets_init'));
		//display_functions.php - add_filter( 'the_content', 'dslc_filter_content', 101 );
		add_filter('the_content', array('LC_Header_Footer_Widget', 'the_content'), 102);
	}
	public static function the_content($content) {
		return self::$is_widget || !self::editing_hf() ? $content : '';
	}
	public static function widgets_init() {
		register_widget('LC_Header_Footer_Widget');
	}
	public static function get_templates() {
		$args = array(
			'posts_per_page'   => -1,
			'offset'           => 0,
			'category'         => '',
			'category_name'    => '',
			'orderby'          => 'post_title',
			'order'            => 'ASC',
			'include'          => '',
			'exclude'          => '',
			'meta_key'         => '',
			'meta_value'       => '',
			'post_type'        => 'dslc_hf',
			'post_mime_type'   => '',
			'post_parent'      => '',
			'author'	   => '',
			'author_name'	   => '',
			'post_status'      => 'publish',
			'suppress_filters' => true 
		);
		return get_posts($args);
	}
	public static function get_options($page_id) {
		return get_post_meta($page_id);
	}
}
LC_Header_Footer_Widget::add_hooks();