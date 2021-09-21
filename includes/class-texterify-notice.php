<?php

class Texterify_Notice {
    public function not_installed_notice_polylang() {
        $class = 'notice notice-warning';
        $message = '<b>Polylang</b> plugin is not enabled which is required by the <b>Texterify</b> plugin.';

        printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), $message);
    }

    public function not_installed_notice_application_passwords() {
        $class = 'notice notice-warning';
        $message = '<b>Application Passwords</b> plugin is not enabled which is required by the <b>Texterify</b> plugin.';

        printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), $message);
    }

    public function check_polygon_installed() {
        if (!is_plugin_active('polylang/polylang.php')) {
            add_action('admin_notices', array($this, 'not_installed_notice_polylang'));
        }

        if (!is_plugin_active('application-passwords/application-passwords.php')) {
            add_action('admin_notices', array($this, 'not_installed_notice_application_passwords'));
        }
    }

    public function register() {
        add_action('admin_init', array($this, 'check_polygon_installed'));
    }
}
