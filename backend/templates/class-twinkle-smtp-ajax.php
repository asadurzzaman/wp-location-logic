<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

if (!class_exists('TwinkleSMTPAdminAjax')) {
    class TwinkleSMTPAdminAjax
    {


        public $admin_class;

        public function __construct($admin_obj)
        {
            $this->admin_class = $admin_obj;

            add_action( 'wp_ajax_twinkle_smtp_get_smtp_data', array($this, 'twinkle_smtp_get_smtp_data') );

        }

        function twinkle_smtp_get_smtp_data() {
            include_once TWINKLE_SMTP_PATH . "backend/api/get_smtp_data.php";
            wp_die();
        }

    }
}
