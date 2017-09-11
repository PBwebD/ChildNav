<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://pbwebd.com
 * @since      1.0.0
 *
 * @package    Pbwebd_childnav
 * @subpackage Pbwebd_childnav/public
 * @author     Danielle Zarcaro <info@pbwebd.com>
 */

/**
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 */
class Pbwebd_childnav_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Pbwebd_childnav_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Pbwebd_childnav_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/pbwebd_childnav-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Pbwebd_childnav_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Pbwebd_childnav_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/pbwebd_childnav-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register the shortcode.
	 */
	public function pbwebd_childmenu_shortcode($atts, $page_list = '') {

		global $post;

		$options = get_option($this->plugin_name);

        $depth = ( intval($options['depth']) < -1 ) ? -1 : intval($options['depth']);
        $include = ( empty($options['include']) ) ? '' : $options['include'];
        $exclude = ( empty($options['exclude']) ) ? '' : $options['exclude'];
        $sort = ( empty($options['sort']) ? 'menu_order' : $options['sort']);
        $list_title = ( empty($options['list_title']) ) ? '' : $options['list_title'];

		$atts = shortcode_atts( array(
			'depth' => $depth,
			'exclude' => $exclude,
			'include' => $include,
			'sort' => $sort,
			'list_title' => $list_title
		), $atts );

		// todo? wrapper class option
		// todo? use current page styles option

		// CHECK DEPTH
		if( $atts['depth'] < -1 ){
			$atts['depth'] = -1;
		}
		// CHECK INCLUDE/EXCLUDE
		$atts['exclude'] = preg_replace('/\s+/', '', $atts['exclude']);
		$atts['include'] = preg_replace('/\s+/', '', $atts['include']);
		// CHECK SORT COLUMN
		if( !isset($atts['sort']) ){
			$atts['sort'] = 'menu_order';
		}

		// GET ID OF PARENT PAGE
		if ($post->post_parent)	{
			$ancestors = get_post_ancestors( $post->ID );
			$root = count( $ancestors ) - 1;
			$parent = $ancestors[$root];
		} else {
			$parent = $post->ID;
		}

		$page_list = wp_list_pages( array(
			'child_of' => $parent,
			'depth' => $atts['depth'],
			'echo' => 0,
			'exclude' => $atts['exclude'],
			'include' => $atts['include'],
			'post_type' => $post->post_type,
			'sort_column' => $atts['sort'],
			'title_li' => $atts['list_title']
		) );

		return '<div class="childmenu"><ul>' . $page_list . '</ul></div>';

	}

}
