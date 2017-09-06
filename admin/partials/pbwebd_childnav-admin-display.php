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

<div class="wrap">

    <h2><?php echo esc_html(get_admin_page_title()); ?></h2>

    <form method="post" name="pbwebd-pagenav_options" action="options.php">

        <?php // Grab all options
        $options = get_option($this->plugin_name);

        // Title quote
        $depth = (empty($options['depth']) ? -1 : $options['depth']);
        $include = (empty($options['include']) ? '' : $options['include']);
        $exclude = (empty($options['exclude']) ? '' : $options['exclude']);
        $sort = (empty($options['sort']) ? 'menu_order' : $options['sort']);

        settings_fields($this->plugin_name);
        do_settings_sections($this->plugin_name); ?>

        <!-- Depth -->
        <fieldset>
            <legend class="screen-reader-text"><span>Depth to display in the side navigation. Enter a number -1 or greater.</span></legend>
            <label for="<?php echo $this->plugin_name; ?>-depth">
                <span><?php esc_attr_e('Depth:', $this->plugin_name); ?></span>
                <input type="number" id="<?php echo $this->plugin_name; ?>-depth" name="<?php echo $this->plugin_name; ?>[depth]" value="<?php echo $depth; ?>" />
            </label>
        </fieldset>

        <!-- Exclude Pages -->
        <fieldset>
            <legend class="screen-reader-text"><span>Comma-Separated list of pages to exclude from the side navigation.</span></legend>
            <label for="<?php echo $this->plugin_name; ?>-exclude">
                <span><?php esc_attr_e('Exclude Pages:', $this->plugin_name); ?></span>
                <input type="text" id="<?php echo $this->plugin_name; ?>-exclude" name="<?php echo $this->plugin_name; ?>[exclude]" value="<?php echo $exclude; ?>" />
            </label>
        </fieldset>

        <!-- Include Pages -->
        <fieldset>
            <legend class="screen-reader-text"><span>Comma-Separated list of pages to include from the side navigation.</span></legend>
            <label for="<?php echo $this->plugin_name; ?>-include">
                <span><?php esc_attr_e('Include Pages:', $this->plugin_name); ?></span>
                <input type="text" id="<?php echo $this->plugin_name; ?>-include" name="<?php echo $this->plugin_name; ?>[include]" value="<?php echo $include; ?>" />
            </label>
        </fieldset>

        <!-- Sort Pages -->
        <fieldset>
            <legend class="screen-reader-text"><span>Method to sort pages.</span></legend>
            <label for="<?php echo $this->plugin_name; ?>-sort">
                <span><?php esc_attr_e('Sort Method:', $this->plugin_name); ?></span>
                <select id="<?php echo $this->plugin_name; ?>-sort" name="<?php echo $this->plugin_name; ?>[sort]">
                    <option value="menu_order"<?php selected($sort, 'menu_order') ?>>Menu Order</option>
                    <option value="post_date"<?php selected($sort, 'post_date') ?>>Post Date</option>
                    <option value="post_title"<?php selected($sort, 'post_title') ?>>Post Title</option>
                    <option value="post_name"<?php selected($sort, 'post_name') ?>>Post Name</option>
                    <option value="post_parent"<?php selected($sort, 'post_parent') ?>>Post Parent</option>
                    <option value="id"<?php selected($sort, 'id') ?>>Post ID</option>
                </select>
            </label>
        </fieldset>

        <?php submit_button('Save all changes', 'primary', 'submit', TRUE); ?>

    </form>

</div>