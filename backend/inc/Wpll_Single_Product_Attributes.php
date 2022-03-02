<?php
global $woocommerce;
global $product;

if ( class_exists( 'Wpll_Single_Product_Attributes' ) ) {
	class Wpll_Single_Product_Attributes {

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
			//// Custom Filed Product variation
			add_action( 'woocommerce_product_after_variable_attributes', array( $this, 'variation_settings_fields', 10, 3 ) );
			add_action( 'woocommerce_save_product_variation', array( $this, 'save_variation_settings_fields', 10, 2 ) );
			add_filter( 'woocommerce_available_variation', array( $this, 'load_variation_settings_fields' ) );
		}


		function variation_settings_fields( $loop, $variation_data, $variation ) {

			echo '<div id="wpll_product_data" class="panel woocommerce_options_panel hidden">';
			$country_type_attribute = get_post_meta( get_the_ID(), '_wpll_country_restriction_type_role_by_attribute', true );
			woocommerce_wp_select(
				array(
					'id'       => '_wpll_country_restriction_type_role_by_attribute',
					'label'    => __( 'Rule of Restriction', 'location-logic' ),
					'default'  => 'all',
					'style'    => 'max-width:450px;width:100%;',
					'class'    => 'availability wpll_restricted_type',
					'selected' => true,
					'options'  => array(
						'all'      => __( 'Available all countries', 'location-logic' ),
						'specific' => __( 'Available selected countries', 'location-logic' ),
						'excluded' => __( 'Not Available selected countries', 'location-logic' ),
					)
				)
			);

			woocommerce_wp_textarea_input(
				array(
					'id'            => "my_text_field{$loop}",
					'name'          => "my_text_field[{$loop}]",
					'value'         => get_post_meta( $variation->ID, 'my_text_field', true ),
					'label'         => __( 'WPC Text', 'woocommerce' ),
					'desc_tip'      => true,
					'description'   => __( 'Some description.', 'woocommerce' ),
					'wrapper_class' => 'form-row form-row-full',
				)
			);

		}


		function save_variation_settings_fields( $variation_id, $loop ) {
			$text_field = $_POST['my_text_field'][ $loop ];

			if ( ! empty( $text_field ) ) {
				update_post_meta( $variation_id, 'my_text_field', esc_attr( $text_field ) );
			}
		}
	}
}

