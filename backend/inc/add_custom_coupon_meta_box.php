<?php
global $woocommerce;
global $product;


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

////////////////////////////////////////////////////////////////////////////////
/////// Usage Coupon Restrictions Filed for Coupon Usage Restrictions Tabs
////////////////////////////////////////////////////////////////////////////////

function action_woocommerce_coupon_options_usage_restriction($coupon_get_id, $coupon){

    echo '<div class="options_group">';

    woocommerce_wp_radio(
        array(
            'id' => 'customer_restriction_type',
            'label' => __( 'WPLL Customer Restrictions', 'location-logic' ),
            'description' => __( 'Restricts coupon to specific customers based on purchase history.', 'location-logic' ),
            'desc_tip' => true,
            'class' => 'select',
            'options' => array(
                'none' => __( 'Default (no restriction)', 'location-logic' ),
                'new' => __( 'New customers only', 'location-logic' ),
                'existing' => __( 'Existing customers only', 'location-logic' ),
            ),
        )
    );


    $id = 'role_restriction';
    $title = __( 'User role restriction', 'location-logic' );
    //$values = $coupon->get_post_meta( $id, true );

    $selections = array();
    if ( ! empty( $values ) ) {
        $selections = $values;
    }

    // An array of all roles.
    $roles = array_reverse( get_editable_roles() );

    // Adds a fabricated role for "Guest" to allow guest checkouts.
    $roles['woocommerce-coupon-restrictions-guest'] = array(
        'name' => __( 'Guest (No User Account)', 'location-logic' ),
    );?>

<div class="options_group">
	<p class="form-field <?php echo $id; ?>_only_field">
		<label for="<?php echo esc_attr( $id ); ?>">
            <?php echo esc_html( $title ); ?>
		</label>
		<select multiple="multiple" name="<?php echo $id; ?>[]" style="width:350px" data-placeholder="<?php esc_attr_e( 'Choose roles&hellip;', 'woocommerce-coupon-restrictions' ); ?>" aria-label="<?php esc_attr_e( 'Role', 'woocommerce-coupon-restrictions' ) ?>" class="wc-enhanced-select">
            <?php
            foreach ( $roles as $id => $role ) {
                $selected = in_array( $id, $selections );
                $role_name = translate_user_role( $role['name'] );

                echo '<option value="' . $id . '" ' . selected( $selected, true, false ) . '>' . esc_html( $role_name ) . '</option>';
            }
            ?>
		</select>
	</p>
</div>
</div>
<?php

    echo '<div class="options_group">';

    woocommerce_wp_checkbox(
        array(
            'id' => 'location_restrictions',
            'label' => __( 'Use location restrictions', 'location-logic' ),
            'description' => __( 'Displays and enables location restriction options.', 'location-logic' )
        )
    );
    ?>
	<div class="woocommerce-coupon-restrictions-locations" >
	<?php
	    woocommerce_wp_select(
	        array(
	            'id' => 'address_for_location_restrictions',
	            'label' => __( 'Address for location restrictions', 'location-logic' ),
	            'class' => 'select',
	            'options' => array(
	                'shipping' => __( 'Shipping', 'location-logic' ),
	                'billing' => __( 'Billing', 'location-logic' ),
	            ),
	        )
	    );

	    // Country restriction.
	    $id = 'country_restriction';
	    $title = __( 'Restrict to specific countries', 'location-logic' );
	    $values = $coupon->get_meta( $id, true );

	    $selections = array();
	    if ( ! empty( $values ) ) {
	        $selections = $values;
	    }

	    // An array of all countries.
	    $countries = WC()->countries->get_countries();

	    // An array of countries the shop sells to.
	    // Calls the global instance for PHP5.6 compatibility.
	    //$shop_countries = WC_Coupon_Restrictions()->admin->shop_countries();
	    ?>

	<p class=" form-field <?php echo $id; ?>_only_field">
		<label for="<?php echo esc_attr( $id ); ?>">
            <?php echo esc_html( $title ); ?>
		</label>
		<select id="wccr-restricted-countries" multiple="multiple" name="<?php echo esc_attr( $id ); ?>[]" style="width:350px" data-placeholder="<?php esc_attr_e( 'Choose countries&hellip;', 'location-logic' ); ?>" aria-label="<?php esc_attr_e( 'Country', 'location-logic' ) ?>" class="wc-enhanced-select">
		</select>
		<span class="woocommerce-help-tip" data-tip="<?php esc_attr_e( 'Select any country that your store currently sells to.', 'location-logic' ); ?>"></span>
		<div class="wcr-field-options" style="margin-left: 162px;">
			<button id="wccr-add-all-countries" type="button" class="button button-secondary" aria-label="<?php esc_attr_e( 'Adds all the countries that the store sells to in the restricted field.', 'location-logic' ); ?>">
	            <?php echo esc_html_e( 'Add All Countries', 'location-logic' ); ?>
			</button>
			<button id="wccr-clear-all-countries" type="button" class="button button-secondary" aria-label="<?php esc_attr_e( 'Clears all restricted country selections.', 'location-logic' ); ?>">
	            <?php echo esc_html_e( 'Clear', 'location-logic' ); ?>
			</button>
		</div>
	</p>
	</div>
    <?php

    // State restrictions
    woocommerce_wp_textarea_input(
        array(
            'label'   => __( 'Restrict to specific states', 'location-logic' ),
            'description'    => __( 'Use the two digit state codes. Comma separate to specify multiple states.', 'location-logic' ),
            'desc_tip' => true,
            'id'      => 'state_restriction',
            'type'    => 'textarea',
        )
    );

    // Postcode / Zip Code restrictions
    woocommerce_wp_textarea_input(
        array(
            'label'   => __( 'Restrict to specific zip codes', 'location-logic' ),
            'description'    => __( 'Comma separate to list multiple zip codes. Wildcards (*) can be used to match portions of zip codes.', 'location-logic' ),
            'desc_tip' => true,
            'id'      => 'postcode_restriction',
            'type'    => 'textarea',
        )
    );

    echo '</div>'; // .woocommerce-coupon-restrictions-locations
    echo '</div>'; // .options-group
}
add_action('woocommerce_coupon_options_usage_restriction', 'action_woocommerce_coupon_options_usage_restriction',
    10, 2);

// Save Filed
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

?>





