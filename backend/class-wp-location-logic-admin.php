<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

if (!class_exists('WPLocationLogicAdmin')) {
    class WPLocationLogicAdmin
    {
        public $utils;
        public $db;

        public function __construct()
        {
            $this->utils = new WPLocationLogic();

            add_action("admin_menu", array($this, 'wp_location_logic_admin_menu'));
            add_action('admin_enqueue_scripts', array($this, 'wp_location_logic_admin_enqueue'));
            add_action( 'plugin_action_links_' . WP_LOCATION_LOGIC_BASE_PATH, array( $this, 'wp_location_logic_action_links') );
//            $this->db = new WpLocationLogicDB($this);
//            new TwinkleSMTPAdminAjax($this);

        }

        function wp_location_logic_action_links($links) {
            $settings_url = add_query_arg( 'page', 'wp-location-logic', get_admin_url() . 'admin.php' );
            $setting_arr = array('<a href="' . esc_url( $settings_url ) . '">Settings</a>');
            $links = array_merge($setting_arr, $links);
            return $links;
        }


        function wp_location_logic_admin_menu()
        {
            $icon_url = WP_LOCATION_LOGIC_IMG_DIR . "twinkle_smtp_icon.svg";
            add_menu_page("Location Logic", "Location Logic", 'manage_options', "wp-location-logic", array($this, 'wp_location_logic_admin_dashboard'), $icon_url, 80);
        }

        function wp_location_logic_admin_enqueue( $page )
        {
            if($page == "toplevel_page_wp-location-logic"){
                $this->utils->enqueue_style('select2', 'select2.min.css');
                $this->utils->enqueue_style('admin', 'admin.css');

                $this->utils->enqueue_script('analytics', 'analytics.js', array('jquery'));
                $this->utils->enqueue_script('settings', 'settings.js', array('jquery'));
                $this->utils->enqueue_script('admin', 'admin.js', array('jquery'));
                $this->utils->enqueue_script('select2', 'select2.min.js', array('jquery'));
            }
        }

        function wp_location_logic_admin_dashboard()
        {
            include_once WP_LOCATION_LOGIC_PATH . "backend/templates/dashboard.php";
        }
    }
}
new WPLocationLogicAdmin();
