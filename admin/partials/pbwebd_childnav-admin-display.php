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
        $include = (empty($options['include']) ? '' : $options['include']);
        $exclude = (empty($options['exclude']) ? '' : $options['exclude']);
        $sort = (empty($options['sort']) ? 'menu_order' : $options['sort']);

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

        </fieldset>

        <?php submit_button('Save all changes', 'primary', 'submit', TRUE); ?>

    </form>

</div>