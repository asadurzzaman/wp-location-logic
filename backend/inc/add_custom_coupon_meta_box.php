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

    echo '<div class="options_group wpll_coupon">';

    woocommerce_wp_radio(
        array(
            'id' => 'customer_restriction_type',
            'label' => __( 'Customer Restrictions', 'location-logic' ),
            'description' => __( 'Restricts coupon to specific customers based on purchase history.', 'location-logic' ),
            'desc_tip' => true,
            'class' => 'select',
            'options' => array(
                'none'      => __( 'Default (no restriction)', 'location-logic' ),
                'new'       => __( 'New customers only', 'location-logic' ),
                'existing'  => __( 'Existing customers only', 'location-logic' ),
            ),
        )
    );

	echo "</div>";

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
    );

    ?>
		<div class="options_group wpll_coupon">
			<p class="form-field <?php echo $id; ?>_only_field">
				<label for="<?php echo esc_attr( $id ); ?>">
		            <?php echo esc_html( $title ); ?>
				</label>
				<select multiple="multiple" name="<?php echo $id; ?>[]" style="width:50%" data-placeholder="<?php
				esc_attr_e( 'Choose roles&hellip;', 'woocommerce-coupon-restrictions' ); ?>" aria-label="<?php esc_attr_e( 'Role', 'woocommerce-coupon-restrictions' ) ?>" class="wc-enhanced-select">
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




	<?php

	    echo '<div class="options_group wpll_coupon">';

	    woocommerce_wp_checkbox(
	        array(
	            'id'            => 'wpll_lc_restrictions',
	            'label'         => __( 'location restrictions', 'location-logic' ),
	            'description'   => __( 'Enables location restriction options.', 'location-logic' )
	        )
	    );
	    ?>
		<script>
	        // assign function to onclick property of checkbox
	        document.getElementById('wpll_lc_restrictions').onclick = function() {
	            // call toggleSub when checkbox clicked
	            // toggleSub args: checkbox clicked on (this), id of element to show/hide
	            toggleSub(this, 'active_sub');
	        };

	        // called onclick of checkbox
	        function toggleSub(box, id) {
	            // get reference to related content to display/hide
	            var el = document.getElementById(id);

	            if ( box.checked ) {
	                el.style.display = 'block';
	            } else {
	                el.style.display = 'none';
	            }
	        }
		</script>

		<div id="active_sub" class="woocommerce-coupon-restrictions-locations" style="display: none" >
			<?php
			    woocommerce_wp_select(
			        array(
			            'id' => 'wpll_address_location_restrictions',
			            'label' => __( 'Location restrictions for checkout page', 'location-logic' ),
			            'class' => 'select short',
			            'options' => array(
			                'billing'   => __( 'Billing', 'location-logic' ),
	                        'shipping'  => __( 'Shipping', 'location-logic' ),
			            ),
			        )
			    );

		        $selections = get_post_meta($coupon_get_id->ID, '_coupon_restricted_countries', true);
		        if (empty($selections) || !is_array($selections)) {
		            $selections = array();
		        }
		        $countries_obj = new WC_Countries();
		        $countries = $countries_obj->__get('countries');
		        asort($countries);

			    ?>

			<p class="form-field country_restriction_only_field">

				<label for="country_restriction"> <?php echo esc_html( 'Restrict to specific countries', 'location-logic' ); ?> </label>

				<select multiple="multiple" name="_coupon_restricted_countries[<?php echo $coupon_get_id->ID; ?>][]"
				        style="width:50%;max-width: 350px;"
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

		echo '</div>'; // .options-group
	}
add_action('woocommerce_coupon_options_usage_restriction', 'action_woocommerce_coupon_options_usage_restriction',
	    10, 2);



	// Save Filed
	function action_woocommerce_coupon_options_save($post_id, $coupon){

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





