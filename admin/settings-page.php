<?php
/**
  * Create Polr plugins settings page
  */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
  * @wp-hook admin_init
  * Add plugin admin settings
  */
function polr_admin_init() { // The fields to show in the settings page
  // When you use register_settings you are creating items to save. Fields to save
    register_setting('polr-group', 'polr_settings_api_key'); // Options group (required), title. How it is saved in databases. The prefix is important to save in databases. In this case, polr
		register_setting('polr-group', 'polr_settings_host');
}
add_action('admin_init', 'polr_admin_init');



/**
  * Show admin settings page
  */
function polr_plugin_options() { // Page design. This function is called in admin-menu.php
    ?>
    <div class="wrap">
        <?php screen_icon(); ?>
        <h2>Polr Wordpress Plugin</h2>
        <form action="<?php echo esc_url( admin_url('options.php') ); ?>" method="post">
            <?php settings_fields('polr-group'); ?>
            <?php @do_settings_fields('polr-group'); ?>
            <table class="form-table">
							<tr valign="top">
									<th scope="row"><label for="polr_settings_host_title"><?php echo esc_html(__('Host URL', 'wp-polr')); ?></label></th>
									<td>
											<input type="url" name="polr_settings_host" id="polr_settings_host" placeholder="https://polr.me" value="<?php echo esc_url(get_option('polr_settings_host')); // If a previous value exists, it shows it ?>" />
									</td>
							</tr>
                <tr valign="top">
                    <th scope="row"><label for="polr_dashboard_title"><?php echo esc_html(__('API key', 'wp-polr')); ?></label></th>
                    <td>
                        <input type="text" name="polr_settings_api_key" id="polr_settings_api_key" value="<?php echo esc_attr(get_option('polr_settings_api_key')); // If a previous value exists, it shows it ?>" />
                        <br/><small><?php echo esc_html(__('You find the API key in your dashboard', 'wp-polr')); ?></small>
                    </td>
                </tr>
            </table> <?php @submit_button(); ?>
        </form>
    </div>
    <?php
}

?>
