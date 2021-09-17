<?php

class Texterify_Notice {
    public function not_installed_notice() {
        $class = 'notice notice-warning';
        $message = 'Polylang is not installed which is required by the Texterify plugin.';

        printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
    }

    public function check_polygon_installed() {
        if (!is_plugin_active('polylang/polylang.php')) {
            add_action('admin_notices', array($this, 'not_installed_notice'));
        }
    }

    public function register() {
        add_action('admin_init', array($this, 'check_polygon_installed'));
    }
}
