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
                    'id'        => '_wpll_country_restriction_type_role',
                    'label'     => __('Rule of Restriction', 'location-logic'),
                    'default'   => 'all',
                    'style'     => 'max-width:350px;width:100%;',
                    'class'     => 'availability wpll_restricted_type wplcation_select2',
                    'value'     => get_post_meta(get_the_ID(), '_wpll_country_restriction_type_role', true),
                    'options'   => array(
	                        'all'       => __('Available all countries', 'location-logic'),
	                        'specific'  => __('Available selected countries', 'location-logic'),
	                        'excluded'  => __('Not Available selected countries', 'location-logic'),
                    )
                )
            );

            $selections = get_post_meta($post->ID, '_wpll_restricted_countries', true);

            if (empty($selections) || !is_array($selections)) {
                $selections = array();
            }
            $countries_obj = new WC_Countries();
            $countries = $countries_obj->__get('countries');
            asort($countries);
            ?>
            <p class="form-field forminp restricted_countries">
                <label for="_restricted_countries[<?php echo get_the_ID(); ?>]"><?php echo __('Select countries', 'location-logic');
                ?></label>
                <select id="_restricted_countries[<?php echo get_the_ID(); ?>]" multiple="multiple" name="_restricted_countries[<?php echo get_the_ID(); ?>][]"
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


            $restriction_country = sanitize_text_field($_POST['_wpll_country_restriction_type_role']);

            if (!isset($_POST['_restricted_countries']) || empty($_POST['_restricted_countries'])) {
                update_post_meta($post_id, '_wpll_country_restriction_type_role', 'all');
            } else {
                if (!empty($restriction_country))
                    update_post_meta($post_id, '_wpll_country_restriction_type_role', $restriction_country);
            }

            $countries = array();
            if (isset($_POST["_restricted_countries"])) {
                $countries = wc_clean($_POST['_restricted_countries'][$post_id]);
            }
            update_post_meta($post_id, '_restricted_countries', $countries);

        }

	}

}

new WpllSingleProductAttributes();