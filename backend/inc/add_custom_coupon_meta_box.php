<?php
global $woocommerce;
global $product;

// Add a custom field to Admin coupon settings pages
add_action('woocommerce_coupon_options', 'add_coupon_text_field', 10);
if (!function_exists('add_coupon_text_field')) {
    function add_coupon_text_field()
    {
        global $woocommerce, $post;
        echo '<div class="options_group">';
        $hide_coupon_country = implode('', get_post_meta($post->ID, '_no_free_shipping_checkbox'));

	    woocommerce_wp_checkbox(
		    array(
			    'id'            => '_no_free_shipping_checkbox',
			    'wrapper_class' => '',
			    'label'         => __('Exclude From Free Shipping', 'woocommerce' ),
			    'description'   => __( 'Dis-allow Free Shipping', 'woocommerce' )
		    )
	    );

	    //$select_country_type = get_post_meta(get_the_ID(), '_wpll_country_restriction_type_role', true);
	    woocommerce_wp_select(
		    array(
			    'id' => '_wpll_country_restriction_type_role2',
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
            <label for="_restricted_countries"><?php echo __('Select countries', 'woo-product-country-base-restrictions'); ?></label>
            <select id="_restricted_countries" multiple="multiple" name="_restricted_countries[]"
                    style="width:100%;max-width: 350px;"
                    data-placeholder="<?php esc_attr_e('Choose countries&hellip;', 'woocommerce'); ?>"
                    title="<?php esc_attr_e('Country', 'woocommerce') ?>"
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
		    echo "<p><b>" . __("You need to setup shipping locations in WooCommerce settings ", 'woo-product-country-base-restrictions') . " <a href='admin.php?page=wc-settings'> " . __("HERE", 'woo-product-country-base-restrictions') . "</a> " . __("before you can choose country restrictions", 'woo-product-country-base-restrictions') . "</b></p>";
	    }

	    echo '</div>';

    }
}



// Save the custom field value from Admin coupon settings pages
add_action( 'woocommerce_coupon_options_save', 'save_coupon_text_field', 10, 2 );
if ( ! function_exists( 'save_coupon_text_field' ) ) {
	function save_coupon_text_field( $post_id, $coupon ) {

		if ( isset( $_POST['_hide_country_coupon'] ) ) {
			$coupon->update_meta_data( '_hide_country_coupon', sanitize_text_field( $_POST['_hide_country_coupon'] ) );
			$coupon->save();
		}
	}
}






/**
 * Extra Meta Box add on Woocommerce Product Price Below
 */
add_action('woocommerce_product_options_general_product_data', 'wpcl_adv_product_options');
function wpcl_adv_product_options()
{

    echo '<div class="options_group">';
	$wc_radio = isset( $_POST['_price_per_word_character'] ) ? $_POST['_price_per_word_character'] : '';
	woocommerce_wp_radio( array(
		'options'     => array(
			"gio_location" => "Calculate prices by the exchange rate",
			"manual"       => " Set prices manually"
		),
		'name'        => '_price_per_word_character',
		'value'       => $wc_radio,
		'class'        => 'radio_box',
		'id'          => '_price_per_word_character',
		'label'       => __( 'Price for.....!', 'woocommerce-price-per-word' ),
		'desc_tip'    => 'true',
		'description' => __( 'Choose whether to set ', 'woocommerce-price-per-word' )
	) );
    echo '</div>';
	echo '<div class="options_group">';
    echo '<div class="manual box">manual have selected <strong>red radio button</strong> so i am here</div>';
    echo '<div class="gio_location box">gio_location have selected <strong>red radio button</strong> so i am here</div>';
	echo '</div>';
?>

	<script>
        jQuery(document).ready(function(){
            jQuery('.box').hide();
            jQuery('input[type="radio"]').click(function(){
                var inputValue = jQuery(this).attr("value");
                var targetBox = jQuery("." + inputValue);
                jQuery(".box").not(targetBox).hide();
                jQuery(targetBox).show();
            });
        });

	</script>
	<?php


}

// Save the data of the custom tab in edit product page settings
add_action( 'woocommerce_process_product_meta',   'shipping_costs_process_product_meta_fields_save' );
function shipping_costs_process_product_meta_fields_save( $post_id ){
	// save the radio button field data
	$wc_radio = isset( $_POST['_price_per_word_character'] ) ? $_POST['_price_per_word_character'] : '';
	update_post_meta( $post_id, '_price_per_word_character', $wc_radio );
}






// Shortcode
add_shortcode('logic_help', 'my_logic_function');
function my_logic_function()
{

    $geoloc = WC_Geolocation::geolocate_ip();
    $country_name = $geoloc['country'];

    echo '<prev>';
    print_r($country_name);
    echo '</prev>';


    switch ($country_name) {
        case "BD":
            $country_name = "Bangladesh!";
            break;
        case "CA":
            $country_name = "Canada!";
            break;
        case "BR":
            $country_name = "Brazil!";
            break;
        case "IN":
            $country_name = "India!";
            break;
        case "NL":
            $country_name = "Netherlands!";
            break;
        case "US":
            $country_name = "United States!";
            break;
        case "PK":
            $country_name = "Pakistan!";
            break;
        default:
            $country_name = "Other Country!";
    }
    echo $country_name;

}

// Add new field - usage restriction tab
function action_woocommerce_coupon_options_usage_restriction($coupon_get_id, $coupon)
{
	woocommerce_wp_text_input( array(
		'id'          => 'customer_user_role',
		'label'       => __( 'WPCL User role restrictions', 'woocommerce' ),
		'placeholder' => __( 'No restrictions', 'woocommerce' ),
		'description' => __( 'List of allowed user roles. Separate user roles with commas.', 'woocommerce' ),
		'desc_tip'    => true,
		'type'        => 'text',
	) );
}
add_action('woocommerce_coupon_options_usage_restriction', 'action_woocommerce_coupon_options_usage_restriction',
    10, 2);

// Save
function action_woocommerce_coupon_options_save($post_id, $coupon)
{
    update_post_meta($post_id, 'customer_user_role', $_POST['customer_user_role']);
}
add_action('woocommerce_coupon_options_save', 'action_woocommerce_coupon_options_save', 10, 2);

// Valid
function filter_woocommerce_coupon_is_valid( $is_valid, $coupon, $discount ) {
	// Get meta
	$customer_user_role = $coupon->get_meta( 'customer_user_role' );

	// NOT empty
	if ( ! empty( $customer_user_role ) ) {
		// Convert string to array
		$customer_user_role = explode( ', ', $customer_user_role );

		// Get current user role
		$user  = wp_get_current_user();
		$roles = ( array ) $user->roles;

		// Compare
		$compare = array_diff( $roles, $customer_user_role );

		// NOT empty
		if ( ! empty ( $compare ) ) {
			$is_valid = false;
		}
	}
	return $is_valid;
}
add_filter( 'woocommerce_coupon_is_valid', 'filter_woocommerce_coupon_is_valid', 10, 3 );




