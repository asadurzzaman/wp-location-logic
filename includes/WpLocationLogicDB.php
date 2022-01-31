<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

if ( ! class_exists('WpLocationLogicDB') ) {
    class WpLocationLogicDB
    {

        public $admin_class;
        public $wpdb;

        function __construct($admin_obj) {

            $this->admin_class = $admin_obj;


            global $wpdb;
            $this->wpdb = $wpdb;


            $sql = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}twinkle_smtp_setting` (
		`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
		`key` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL ,
		`value` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL ,
		PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		";

            include_once ABSPATH . 'wp-admin/includes/upgrade.php';
            dbDelta($sql);

        }



        function getHostData() {
            return $this->wpdb->get_var( "SELECT value FROM `{$this->wpdb->prefix}twinkle_smtp_setting` WHERE `key` = 'host'" );
        }


    }
}
