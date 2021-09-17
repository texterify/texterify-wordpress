<?php

class Texterify_Dashboard {
    function render_plugin_settings_page() {
        ?>
        <h2>Texterify Settings</h2>
        <form action="options.php" method="post">
            <?php
            settings_fields( 'dbi_example_plugin_options' );
            do_settings_sections( 'dbi_example_plugin' ); ?>
            <input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e( 'Save' ); ?>" />
        </form>
        <?php
    }

    public function dashboar_menu() {
        add_options_page('Texterify', 'Texterify', 'manage_options', 'texterify', array($this, 'render_plugin_settings_page'));
    }

    public function register() {
        # Add settings menu item.
        add_action('admin_menu', array($this, 'dashboar_menu'));
    }
}
