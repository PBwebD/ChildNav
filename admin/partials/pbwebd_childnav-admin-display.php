<?php
/**
 * Provide an admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://pbwebd.com
 * @since      1.0.0
 *
 * @package    Pbwebd_childnav
 * @subpackage Pbwebd_childnav/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap childnav-wrap">

    <h2><?php echo esc_html(get_admin_page_title()); ?></h2>
    <p>These defaults are used for shortcodes. Widget settings are set per-widget.</p>

    <form method="post" name="pbwebd-pagenav_options" action="options.php">

        <?php $options = get_option($this->plugin_name);

        $depth = ( intval($options['depth']) < -1 ) ? -1 : intval($options['depth']);
        $include = ( empty($options['include']) ) ? '' : $options['include'];
        $exclude = ( empty($options['exclude']) ) ? '' : $options['exclude'];
        $sort = ( empty($options['sort']) ) ? 'menu_order' : $options['sort'];
        $list_title = ( empty($options['list_title']) ) ? '' : $options['list_title'];
        $show_parent = ( empty($options['show_parent']) ) ? 'no' : $options['show_parent'];
        $current_class = ( empty($options['current_class']) ) ? 'none' : $options['current_class'];
        $before_list = $options['before_list'];
        $after_list = $options['after_list'];

        settings_fields($this->plugin_name);
        do_settings_sections($this->plugin_name); ?>

        <fieldset>
            <!-- Depth -->
            <div class="input-wrapper">
                <label for="<?php echo $this->plugin_name; ?>-depth"><?php esc_attr_e('Depth:', $this->plugin_name); ?></label>
                <span><input type="number" id="<?php echo $this->plugin_name; ?>-depth" name="<?php echo $this->plugin_name; ?>[depth]" value="<?php echo $depth; ?>" /></span>
                <p class="subtext">Depth to display in the side navigation. Enter a whole number -1 or greater.</p>
            </div>

            <!-- Exclude Pages -->
            <div class="input-wrapper">
                <label for="<?php echo $this->plugin_name; ?>-exclude"><?php esc_attr_e('Exclude Pages:', $this->plugin_name); ?></label>
                <span><input type="text" id="<?php echo $this->plugin_name; ?>-exclude" name="<?php echo $this->plugin_name; ?>[exclude]" value="<?php echo $exclude; ?>" /></span>
                <p class="subtext">Comma-Separated list of pages to exclude from the side navigation.</p>
            </div>

            <!-- Include Pages -->
            <div class="input-wrapper">
                <label for="<?php echo $this->plugin_name; ?>-include"><?php esc_attr_e('Include Pages:', $this->plugin_name); ?></label>
                <span><input type="text" id="<?php echo $this->plugin_name; ?>-include" name="<?php echo $this->plugin_name; ?>[include]" value="<?php echo $include; ?>" /></span>
                <p class="subtext">Comma-Separated list of pages to include from the side navigation.</p>
            </div>

            <!-- Sort Pages -->
            <div class="input-wrapper">
                <label for="<?php echo $this->plugin_name; ?>-sort"><?php esc_attr_e('Sort Method:', $this->plugin_name); ?></label>
                <span><select id="<?php echo $this->plugin_name; ?>-sort" name="<?php echo $this->plugin_name; ?>[sort]">
                    <option value="menu_order"<?php selected($sort, 'menu_order') ?>>Menu Order</option>
                    <option value="post_date"<?php selected($sort, 'post_date') ?>>Post Date</option>
                    <option value="post_title"<?php selected($sort, 'post_title') ?>>Post Title</option>
                    <option value="post_name"<?php selected($sort, 'post_name') ?>>Post Name</option>
                    <option value="post_parent"<?php selected($sort, 'post_parent') ?>>Post Parent</option>
                    <option value="id"<?php selected($sort, 'id') ?>>Post ID</option>
                </select></span>
                <p class="subtext">Method to sort pages.</p>
            </div>

            <!-- List Title -->
            <div class="input-wrapper">
                <label for="<?php echo $this->plugin_name; ?>-list_title"><?php esc_attr_e('List Title:', $this->plugin_name); ?></label>
                <span><input type="number" id="<?php echo $this->plugin_name; ?>-list_title" name="<?php echo $this->plugin_name; ?>[list_title]" value="<?php echo $list_title; ?>" /></span>
                <p class="subtext">Title to display above the page list.</p>
            </div>

            <!-- Show Parent Page -->
            <div class="input-wrapper">
                <label><?php esc_attr_e('Show Parent?', $this->plugin_name); ?></label>
                <span><input type="radio" name="<?php echo $this->plugin_name; ?>[show_parent]" value="yes" <?php checked($show_parent, 'yes'); ?>> Yes<br />
                <input type="radio" name="<?php echo $this->plugin_name; ?>[show_parent]" value="no" <?php checked($show_parent, 'no'); ?>> No</span>
                <p class="subtext">Select whether to display the parent page title and link above the page list.</p>
            </div>

            <!-- Current Page Style -->
            <div class="input-wrapper">
                <label><?php esc_attr_e('Current Page Style', $this->plugin_name); ?></label>
                <span><input type="radio" name="<?php echo $this->plugin_name; ?>[current_class]" value="none" <?php checked($current_class, 'none'); ?>> Default (None - Inherits any custom styles from the theme)<br />
                <input type="radio" name="<?php echo $this->plugin_name; ?>[current_class]" value="current-bold" <?php checked($current_class, 'current-bold'); ?>> Bold Font<br />
                <input type="radio" name="<?php echo $this->plugin_name; ?>[current_class]" value="current-italic" <?php checked($current_class, 'current-italic'); ?>> Italic Font<br />
                <input type="radio" name="<?php echo $this->plugin_name; ?>[current_class]" value="current-underline" <?php checked($current_class, 'current-underline'); ?>> Underline Text</span>
                <p class="subtext">Select how to indicate the current page. Default will not add any additional styles.</p>
            </div>

            <div class="input-wrapper">
                <label for="<?php echo $this->plugin_name; ?>-before_list"><?php esc_attr_e('HTML before list items:', $this->plugin_name); ?></label>
                <span><textarea id="<?php echo $this->plugin_name; ?>-before_list" name="<?php echo $this->plugin_name; ?>[before_list]"><?php echo $before_list; ?></textarea></span>
                <p class="subtext">List items inserted directly inside the opening ul tag. Use this to add custom pages to the top of the list.</p>
            </p>

            <div class="input-wrapper">
                <label for="<?php echo $this->plugin_name; ?>-after_list"><?php esc_attr_e('HTML before list items:', $this->plugin_name); ?></label>
                <span><textarea id="<?php echo $this->plugin_name; ?>-after_list" name="<?php echo $this->plugin_name; ?>[after_list]"><?php echo $after_list; ?></textarea></span>
                <p class="subtext">List items inserted directly inside the opening ul tag. Use this to add custom pages to the top of the list.</p>
            </p>

        </fieldset>

        <?php submit_button('Save all changes', 'primary', 'submit', TRUE); ?>

    </form>

</div>