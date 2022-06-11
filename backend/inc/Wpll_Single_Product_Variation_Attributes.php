<?php

if( !class_exists( "Wpll_Single_Product_Variation_Attributes" ) ){
    class Wpll_Single_Product_Variation_Attributes
    {
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
//			add_action( 'woocommerce_product_after_variable_attributes', array( $this, 'variation_settings_fields', 10, 3 ) );
//			add_action( 'woocommerce_save_product_variation', array( $this, 'save_variation_settings_fields', 10, 2 ) );
//			add_filter( 'woocommerce_available_variation', array( $this, 'load_variation_settings_fields' ) );


			add_action('woocommerce_product_after_variable_attributes', array( $this, 'wpll_variation_settings_fields',
                10, 3));
            add_action('woocommerce_save_product_variation', array( $this, 'save_wpll_variation_settings_fields', 10,
                2));

        }

        /*
        * Adding a WPLL settings fields to the WPLL settings for all variation type products
        *
        * @since 1.0.0
        * @para $loop, $variation_data, $variation
        */
        function wpll_variation_settings_fields( $variation)
        {
            global $post;
            echo '<div id="wpll_product_data" class="panel woocommerce_options_panel hidden">';
            woocommerce_wp_select(
                array(
                    'id' => '_wpll_country_restriction_role_attribute[' . $variation->ID . ']',
                    'label' => __('Rule of Restriction', 'location-logic'),
                    'default' => 'all',
                    'class' => 'availability wpll_restricted_type',
                    'style' => 'width:100%;',
                    'value' => get_post_meta($variation->ID, '_wpll_country_restriction_role_attribute', true),
                    'options' => array(
                        'all' => __('Available for all countries', 'location-logic'),
                        'specific' => __('Available for selected countries', 'location-logic'),
                        'excluded' => __('Not Available for selected countries', 'location-logic'),
                    )
                )
            );


            $selections = get_post_meta($variation->ID, '_attribute_restricted_countries', true);
            if (empty($selections) || !is_array($selections)) {
                $selections = array();
            }
            $countries_obj = new WC_Countries();
            $countries = $countries_obj->__get('countries');
            asort($countries);

            ?>
            <p class="form-field forminp restricted_countries">
                <label for="_attribute_restricted_countries[<?php echo $variation->ID; ?>]"><?php echo __('Select 
            countries', 'location-logic'); ?></label>
                <select multiple="multiple" name="_attribute_restricted_countries[<?php echo $variation->ID; ?>][]"
                        style="width:100%;max-width: 350px;"
                        data-placeholder="<?php esc_attr_e('Choose countries&hellip;', 'location-logic'); ?>" title="<?php
                esc_attr_e('Country', 'location-logic') ?>"
                        class="wc-enhanced-select">
                    <?php
                    if (!empty($countries)) {
                        foreach ($countries as $key => $val) {
                            echo '<option value="' . esc_attr($key) . '" ' . selected(in_array($key, $selections),
                                    true, false) . '>' . $val . '</option>';
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
        * Save the product meta settings for variation product
        *
        * @since 1.0.0
        * @para $post_id
        */
        function save_wpll_variation_settings_fields($post_id)
        {

            $restriction = sanitize_text_field($_POST['_wpll_country_restriction_role_attribute'][$post_id]);

            if (!isset($_POST['_attribute_restricted_countries']) || empty($_POST['_attribute_restricted_countries'])) {
                update_post_meta($post_id, '_wpll_country_restriction_role_attribute', 'all');
            } else {
                if (!empty($restriction))
                    update_post_meta($post_id, '_wpll_country_restriction_role_attribute', $restriction);
            }

            $countries = array();
            if (isset($_POST["_attribute_restricted_countries"])) {
                $countries = wc_clean($_POST['_attribute_restricted_countries'][$post_id]);
            }
            update_post_meta($post_id, '_attribute_restricted_countries', $countries);
        }



    }
}
new Wpll_Single_Product_Variation_Attributes();
