<?php

class Texterify_Dashboard {
    function render_plugin_settings_page() {
        global $wpdb;
        $results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}_postmeta WHERE meta_key = \"_pll_strings_translations\"", ARRAY_A);
//         $results = $wpdb->get_results ( "
//     SELECT *
//     FROM  $wpdb->posts
//         WHERE post_type = 'page'
// " );
        $results = $wpdb->get_results("
    SELECT *
    FROM  $wpdb->postmeta
        WHERE meta_key = '_pll_strings_translations'
");

        ?>
        <div class="wrap texterify-dashboard">
            <h1>Texterify Dashboard</h1>
            <p>
                Welcome to your Texterify Wordpress Dashboard.
                <br/>
                To sync your Wordpress content with Texterify check out the following guide: <a href="https://docs.texterify.com/integrations/wordpress">Wordpress integration guide</a>.
            </p>
            <table class="form-table">
                <tbody>
                    <!-- <tr>
                        <th>
                            <h2>Authorization secret</h2>
                            <div class="description">Use this value to allow Texterify to synchronize content with your site.</div>
                        </th>
                        <td>
                        <div class="secret-wrapper">
                            <code class="secret-value"><?php echo "123"; ?></code>
                            <br/>
                            <a class="secret-generate-new" href="">Generate new secret</a>
                        </div>
                        </td>
                    </tr> -->
                    <tr>
                        <th>
                            <h2>Debug output</h2>
                            <div class="description">This section is just for debugging purposes.</div>
                        </th>
                        <td>
                            <div class="debug-wrapper">
                                <?php
                                    var_dump($results);
                                ?>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php
    }

    public function dashboard_scripts() {
        wp_register_style('texterify-dashboard-page', TEXTERIFY_URL . 'public/css/texterify-dashboard.css');
        wp_enqueue_style('texterify-dashboard-page');
    }

    public function dashboard_menu() {
        add_options_page('Texterify', 'Texterify', 'manage_options', 'texterify', array($this, 'render_plugin_settings_page'));
    }

    public function register() {
        # Add settings menu item.
        add_action('admin_menu', array($this, 'dashboard_menu'));

        add_action('admin_enqueue_scripts', array($this, 'dashboard_scripts'));
    }
}
