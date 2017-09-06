<?php
/**
 * Fired during plugin activation
 *
 * @link       http://pbwebd.com
 * @since      1.0.0
 *
 * @package    Pbwebd_childnav
 * @subpackage Pbwebd_childnav/includes
 * @author     Danielle Zarcaro <info@pbwebd.com>
 */
class Pbwebd_childnav_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 */
	public static function activate() {

        // Set up defaults array
        $defaults = array(
            'depth' => -1,
            'exclude' => '',
            'include' => '',
            'sort' => 'menu_order'
        );

        // Save defaults array as settings
        $options = wp_parse_args(get_option('plugin_options'), $defaults);

	}

}
