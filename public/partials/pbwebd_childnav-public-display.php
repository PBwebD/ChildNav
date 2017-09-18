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

// Get all options
global $post;

$options = get_option($this->plugin_name);

$depth = ( intval($options['depth']) < -1 ) ? -1 : intval($options['depth']);
$include = ( empty($options['include']) ) ? '' : $options['include'];
$exclude = ( empty($options['exclude']) ) ? '' : $options['exclude'];
$sort = ( empty($options['sort']) ) ? 'menu_order' : $options['sort'];
$list_title = ( empty($options['list_title']) ) ? '' : $options['list_title'];
$show_parent = ( empty($options['show_parent']) ) ? 'no' : $options['show_parent'];
$current_class = ( empty($options['current_class']) ) ? 'none' : $options['current_class'];
$before_list = ( empty($options['include']) ) ? '' : $options['before_list'];
$after_list = ( empty($options['include']) ) ? '' : $options['after_list'];

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
    'depth' => $depth,
    'echo' => 0,
    'exclude' => $exclude,
    'include' => $include,
    'post_type' => $post->post_type,
    'sort_column' => $sort,
    'title_li' => $list_title
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