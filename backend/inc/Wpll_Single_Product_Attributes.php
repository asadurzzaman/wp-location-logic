<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

global $woocommerce;
global $product;

if ( !class_exists( 'WpllSingleProductAttributes' ) ) {
	class WpllSingleProductAttributes {

		public static function get_instance() {

			if ( null === self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		public function __construct() {
			$this->init();
		}

		public function init() {

            add_action('woocommerce_product_data_tabs', array( $this, 'wpll_custom_product_meta_tab'));
            add_action('woocommerce_product_data_panels', array( $this, 'wpll_product_panels'));
            add_action('woocommerce_process_product_meta', array( $this, 'wpll_product_custom_fields_save'));
		}

		/*
         * Product Panel for WPLL Tab
         * @since 1.0.0
         * */
        function wpll_custom_product_meta_tab($default_data) {

            $default_data['wpll'] = array(
                'label' => __('WPLL Setting', 'location-logic'),
                'target' => 'wpll_product_data',
                'class' => array('llc-product-tab'),
                'priority' => 21,
            );

            return $default_data;
        }

        /*
         * Product Panel for WPLL Setting
         * @since 1.0.0
         * */
        function wpll_product_panels() {

            global $post;
            echo '<div id="wpll_product_data" class="panel woocommerce_options_panel hidden">';
            echo '<div class="options_group"><h4 style="padding-left: 12px;font-size: 14px;">Country Based Restrictions</h4>';
            $select_country_type = get_post_meta(get_the_ID(), '_wpll_country_restriction_type_role', true);
            woocommerce_wp_select(
                array(
                    'id' => '_wpll_country_restriction_type_role',
                    'label' => __('Rule of Restriction', 'location-logic'),
                    'default' => 'all',
                    'style' => 'max-width:350px;width:100%;',
                    'class' => 'availability wpll_restricted_type wplcation_select2',
                    'selected' => true,
                    'options' => array(
                        'all' => __('Available all countries', 'location-logic'),
                        'specific' => __('Available selected countries', 'location-logic'),
                        'excluded' => __('Not Available selected countries', 'location-logic'),
                    )
                )
            );

            $selections = get_post_meta($post->ID, '_restricted_countries', true);

            if (empty($selections) || !is_array($selections)) {
                $selections = array();
            }
            $countries_obj = new WC_Countries();
            $countries = $countries_obj->__get('countries');
            asort($countries);
            ?>
            <p class="form-field forminp restricted_countries">
                <label for="_restricted_countries"><?php echo __('Select countries', 'location-logic'); ?></label>
                <select id="_restricted_countries" multiple="multiple" name="_restricted_countries[]"
                        style="max-width: 350px;width:100%;"
                        data-placeholder="<?php esc_attr_e('Choose countries&hellip;', 'location-logic'); ?>"
                        title="<?php esc_attr_e('Country', 'location-logic') ?>"
                        class="wc-enhanced-select">
                    <?php
                    if (!empty($countries)) {
                        foreach ($countries as $key => $val) {
                            echo '<option value="' . esc_attr($key) . '" ' . selected(in_array($key, $selections), true, false) . '>' . $val . '</option>';
                        }
                    }
                    ?>
                </select>
            </p>
            <?php
            if (empty($countries)) {
                echo "<p><b>" . __("You need to setup shipping locations in WooCommerce settings ", 'location-logic') . " <a href='admin.php?page=wc-settings'> " . __("HERE", 'location-logic') . "</a> " . __("before you can choose country restrictions", 'location-logic') . "</b></p>";
            }

            echo '</div>';

        }

        /*
         * Save All Meta Data Filed
         *
         * */
        function wpll_product_custom_fields_save($post_id) {

            if (!empty($_POST['_wpll_country_restriction_type_role'])) {
                update_post_meta($post_id, '_wpll_country_restriction_type_role', sanitize_text_field($_POST['_wpll_country_restriction_type_role']));
            }

            if (!empty($_POST['countries'])) {
                update_post_meta($post_id, 'countries', sanitize_text_field($_POST['countries']));
            }


        }

//		function variation_settings_fields( $loop, $variation ) {
//
//			echo '<div id="wpll_product_data" class="panel woocommerce_options_panel hidden">';
//			$country_type_attribute = get_post_meta( get_the_ID(), '_wpll_country_restriction_type_role_by_attribute', true );
//			woocommerce_wp_select(
//				array(
//					'id'       => '_wpll_country_restriction_type_role_by_attribute',
//					'label'    => __( 'Rule of Restriction', 'location-logic' ),
//					'default'  => 'all',
//					'style'    => 'max-width:450px;width:100%;',
//					'class'    => 'availability wpll_restricted_type',
//					'selected' => true,
//					'options'  => array(
//						'all'      => __( 'Available all countries', 'location-logic' ),
//						'specific' => __( 'Available selected countries', 'location-logic' ),
//						'excluded' => __( 'Not Available selected countries', 'location-logic' ),
//					)
//				)
//			);
//
//			woocommerce_wp_textarea_input(
//				array(
//					'id'            => "my_text_field{$loop}",
//					'name'          => "my_text_field[{$loop}]",
//					'value'         => get_post_meta( $variation->ID, 'my_text_field', true ),
//					'label'         => __( 'WPC Text', 'woocommerce' ),
//					'desc_tip'      => true,
//					'description'   => __( 'Some description.', 'woocommerce' ),
//					'wrapper_class' => 'form-row form-row-full',
//				)
//			);
//
//		}

//
//		function save_variation_settings_fields( $variation_id, $loop ) {
//			$text_field = $_POST['my_text_field'][ $loop ];
//
//			if ( ! empty( $text_field ) ) {
//				update_post_meta( $variation_id, 'my_text_field', esc_attr( $text_field ) );
//			}
//		}
	}

}

new WpllSingleProductAttributes();


