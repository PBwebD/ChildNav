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

        parent::__construct( 'pbwebd_childnav_widget', 'Child Nav', $widget_options );

    }

    public function widget( $args, $instance ) {

        global $post;

        // GET ID OF PARENT PAGE
        if ( $post->post_parent ) {
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
            'title_li' => $instance['list_title']
        ) );

        $current_class = $instance['current'];

        echo '<div class="childmenu">';

            if( $instance['show_parent'] == 'yes' ) {
                echo '<h3><a href="' . get_permalink($parent) . '">' . get_the_title($parent) . '</a></h3>';
            }

            echo '<ul class="' . $current_class . '">' .
                $instance['before_list'] .
                $page_list .
                $instance['after_list'] .
            '</ul>

        </div>';

    }

    public function form( $instance ) {

        $depth = ( intval($instance['depth']) < -1 ) ? -1 : intval($instance['depth']);
        $include = ( empty($instance['include']) ) ? '' : $instance['include'];
        $exclude = ( empty($instance['exclude']) ) ? '' : $instance['exclude'];
        $sort = ( empty($instance['sort']) ) ? 'menu_order' : $instance['sort'];
        $list_title = ( empty($instance['list_title']) ) ? '' : $instance['list_title'];
        $show_parent = ( empty($instance['show_parent']) ) ? 'no' : $instance['show_parent'];
        $current_class = ( empty($instance['current_class']) ) ? 'none' : $current_class;
        $before_list = $instance['before_list'];
        $after_list = $instance['after_list']; ?>

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
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('list_title'); ?>">List Title:</label>
            <input type="text" id="<?php echo $this->get_field_id('list_title'); ?>" name="<?php echo $this->get_field_name('list_title'); ?>" value="<?php echo $list_title; ?>" />
        </p>

        <p>
            <label>Show Parent?</label>
            <input type="radio" name="<?php echo $this->get_field_name('show_parent'); ?>" value="yes"<?php echo ( $show_parent == 'yes' ) ? ' checked="checked"' : ''; ?>> Yes<br />
            <input type="radio" name="<?php echo $this->get_field_name('show_parent'); ?>" value="no"<?php echo ( $show_parent == 'no' ) ? ' checked="checked"' : ''; ?>> No
        </p>

        <p>
            <label>Current Page Style</label>
            <input type="radio" name="<?php echo $this->get_field_name('current_class'); ?>" value="none" <?php checked($current_class, 'none'); ?>> Default (None - Inherits any custom styles from the theme)<br />
            <input type="radio" name="<?php echo $this->get_field_name('current_class'); ?>" value="current-bold" <?php checked($current_class, 'current-bold'); ?>> Bold Font<br />
            <input type="radio" name="<?php echo $this->get_field_name('current_class'); ?>" value="current-italic" <?php checked($current_class, 'current-italic'); ?>> Italic Font<br />
            <input type="radio" name="<?php echo $this->get_field_name('current_class'); ?>" value="current-underline" <?php checked($current_class, 'current-underline'); ?>> Underline Text
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('before_list'); ?>">Add items to top of list:</label>
            <textarea id="<?php echo $this->get_field_id('before_list'); ?>" name="<?php echo $this->get_field_name('before_list'); ?>"><?php echo $before_list; ?></textarea>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('after_list'); ?>">Add  items to bottom of list:</label>
            <textarea id="<?php echo $this->get_field_id('after_list'); ?>" name="<?php echo $this->get_field_name('after_list'); ?>"><?php echo $after_list; ?></textarea>
        </p>

    <?php }

    public function update( $new_instance, $old_instance ) {

        $instance = $old_instance;

        $instance['depth'] = ( $new_instance['depth'] < -1 ) ? -1 : $new_instance['depth'];
        $instance['include'] = preg_replace('/\s+/', '', sanitize_text_field($new_instance['include']));
        $instance['exclude'] = preg_replace('/\s+/', '', sanitize_text_field($new_instance['exclude']));
        $instance['sort'] = ( empty($new_instance['sort']) ) ? 'menu_order' : $new_instance['sort'];
        $instance['list_title'] = ( empty($new_instance['list_title']) ) ? '' : sanitize_text_field($new_instance['list_title']);
        $instance['show_parent'] = ( empty($new_instance['show_parent']) ) ? 'no' : $new_instance['show_parent'];
        $instance['current_class'] = ( empty($new_instance['current_class']) ) ? 'none' : $new_instance['current_class'];
        $instance['before_list'] = wp_kses($new_instance['before_list'], array(
            'li' => array('class'),
            'a' => array('href', 'class', 'target', 'rel')
        ));
        $instance['after_list'] = wp_kses($new_instance['after_list'], array(
            'li' => array('class'),
            'a' => array('href', 'class', 'target', 'rel')
        ));

        return $instance;

    }

}

function pbwebd_load_childnav() {
    register_widget( 'Pbwebd_childnav_Widget' );
}
add_action( 'widgets_init', 'pbwebd_load_childnav' );