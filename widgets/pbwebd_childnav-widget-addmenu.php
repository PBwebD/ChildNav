<?php

/**
 * The widget functionality of the plugin.
 *
 * @link       http://pbwebd.com
 * @since      1.0.0
 * @package    Pbwebd_childnav
 * @subpackage Pbwebd_childnav/widgets
 * @author     Danielle Zarcaro <info@pbwebd.com>
 */
class Pbwebd_childnav_Widget extends WP_Widget {

    function __construct() {

        $widget_options = array(
            'classname' => 'Pbwebd_childnav_Widget',
            'description' => 'Add a child navigation to a sidebar.'
        );

        parent::__construct( 'pbwebd_childnav_widget', 'Child Nav', $widget_options);

    }

    public function widget( $args, $instance ) {

        global $post;

        // $title = apply_filters( 'widget_title', $instance['title'] );
        // $args['before_title'] . $title . $args['after_title'];

        // GET ID OF PARENT PAGE
        if ($post->post_parent) {
            $ancestors = get_post_ancestors( $post->ID );
            $root = count( $ancestors ) - 1;
            $parent = $ancestors[$root];
        } else {
            $parent = $post->ID;
        }

        $page_list = wp_list_pages( array(
            'child_of' => $parent,
            'depth' => $instance['depth'],
            'echo' => 0,
            'exclude' => $instance['exclude'],
            'include' => $instance['include'],
            'post_type' => $post->post_type,
            'sort_column' => $instance['sort'],
            'title_li' => ''
        ) );

        if( $page_list ){

            echo $args['before_widget'];

            // display $title
            echo $page_list;

            echo $args['after_widget'];

        }

    }

    public function form( $instance ) {

        $depth = ( intval($instance['depth']) < -1 ) ? -1 : intval($instance['depth']);
        $include = ( empty($instance['include'] ) ? '' : $instance['include']);
        $exclude = ( empty($instance['exclude'] ) ? '' : $instance['exclude']);
        $sort = ( empty($instance['sort'] ) ? 'menu_order' : $instance['sort']); ?>

        <p>
            <label for="<?php echo $this->get_field_id('depth'); ?>">Depth:</label>
            <input type="number" id="<?php echo $this->get_field_id('depth'); ?>" name="<?php echo $this->get_field_name('depth'); ?>" value="<?php echo $depth; ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('exclude'); ?>">Exclude Pages:</label>
            <input type="text" id="<?php echo $this->get_field_id('exclude'); ?>" name="<?php echo $this->get_field_name('exclude'); ?>" value="<?php echo esc_attr($exclude); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('include'); ?>">Include Pages:</label>
            <input type="text" id="<?php echo $this->get_field_id('include'); ?>" name="<?php echo $this->get_field_name('include'); ?>" value="<?php echo esc_attr($include); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('sort'); ?>">Sort By:</label>
            <select id="<?php echo $this->get_field_id('sort'); ?>" name="<?php echo $this->get_field_name('sort'); ?>">
                <option value="menu_order"<?php selected($sort, 'menu_order') ?>>Menu Order</option>
                <option value="post_date"<?php selected($sort, 'post_date') ?>>Post Date</option>
                <option value="post_title"<?php selected($sort, 'post_title') ?>>Post Title</option>
                <option value="post_name"<?php selected($sort, 'post_name') ?>>Post Name</option>
                <option value="post_parent"<?php selected($sort, 'post_parent') ?>>Post Parent</option>
                <option value="id"<?php selected($sort, 'id') ?>>Post ID</option>
            </select>
        </p><?php

    }

    public function update( $new_instance, $old_instance ) {

        $instance = $old_instance;

        $instance['depth'] = ( $new_instance['depth'] < -1 ) ? -1 : $new_instance['depth'];
        $instance['include'] = preg_replace('/\s+/', '', $new_instance['include']);
        $instance['exclude'] = preg_replace('/\s+/', '', $new_instance['exclude']);
        $instance['sort'] = ( empty( $new_instance['sort'] ) ) ? 'menu_order' : $new_instance['sort'];

        return $instance;

    }

}

function pbwebd_load_childnav() {
    register_widget( 'Pbwebd_childnav_Widget' );
}
add_action( 'widgets_init', 'pbwebd_load_childnav' );