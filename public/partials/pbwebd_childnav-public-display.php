<?php
/**
 * Provide a public-facing view for the plugin
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://pbwebd.com
 * @since      1.0.0
 *
 * @package    Pbwebd_childnav
 * @subpackage Pbwebd_childnav/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php
// todo? wrapper class option
// todo? use current page styles option
// do I need to validate vars?

// Get all options
global $post;

$options = get_option($this->plugin_name);

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
    'depth' => $options['depth'],
    'echo' => 0,
    'exclude' => $options['exclude'],
    'include' => $options['include'],
    'post_type' => $post->post_type,
    'sort_column' => $options['sort'],
    'title_li' => $options['list_title']
) );

$current_class = $options['current_class'];

echo '<div class="childmenu">';

    if( $show_parent == 'yes' ) {
        echo '<h3><a href="' . get_permalink($parent) . '">' . get_the_title($parent) . '</a></h3>';
    }

    echo '<ul class="' . $current_class . '">' .
        $options['before_list'] .
        $page_list .
        $options['after_list'] .
    '</ul>

</div>';

?>