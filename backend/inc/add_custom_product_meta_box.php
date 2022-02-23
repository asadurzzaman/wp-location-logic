<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

    /*
     * All hooke for Single Product Meta Filed
     * */
    add_action('woocommerce_product_data_tabs', 'wpll_custom_product_meta_tab');
    add_action( 'woocommerce_product_data_panels', 'wpll_product_panels' );
    add_action( 'add_meta_boxes',  'add_product_custom_image' );
    add_action('woocommerce_process_product_meta', 'wpll_product_custom_fields_save');
    //// Hooks Custom Product variation Filed
    add_action( 'woocommerce_product_after_variable_attributes', 'wpll_variation_settings_fields', 10, 3 );
    add_action( 'woocommerce_save_product_variation', 'save_wpll_variation_settings_fields', 10, 2 );

    function wpll_custom_product_meta_tab($default_data ){

        $default_data['wpll'] = array(
            'label' => __( 'WPLL Setting', 'location-logic' ),
            'target' => 'wpll_product_data',
            'class'    => array('custom_class_name'),
            'priority' => 21,
        );

        return $default_data;
    }

    /*
     * Product Panel for WPLL Setting
     * @since 1.0.0
     * */
    function wpll_product_panels(){

        global $woocommerce, $post;

        echo '<div id="wpll_product_data" class="panel woocommerce_options_panel hidden">';
        $select_country_type = get_post_meta( get_the_ID(), '_wpll_country_restriction_type_role', true );
        woocommerce_wp_select(
            array(
                'id'      => '_wpll_country_restriction_type_role',
                'label'   => __( 'Rule of Restriction', 'location-logic' ),
                'default'       => 'all',
                'style'			=> 'max-width:350px;width:100%;',
                'class'         => 'availability wpll_restricted_type wplcation_select2',
                'selected' => true,
                'options'       => array(
                    'all'       => __( 'Available all countries', 'location-logic' ),
                    'specific'  => __( 'Available selected countries', 'location-logic' ),
                    'excluded'  => __( 'Not Available selected countries', 'location-logic' ),
                )
            )
        );

        $selections = get_post_meta( $post->ID, '_restricted_countries', true );

        if(empty($selections) || ! is_array($selections)) {
            $selections = array();
        }
        $countries_obj   = new WC_Countries();
        $countries   = $countries_obj->__get('countries');
        asort( $countries );
    ?>
        <p class="form-field forminp restricted_countries">
            <label for="_restricted_countries"><?php echo __( 'Select countries', 'woo-product-country-base-restrictions' ); ?></label>
            <select id="_restricted_countries" multiple="multiple" name="_restricted_countries[]" style="width:100%;max-width: 350px;"
                    data-placeholder="<?php esc_attr_e( 'Choose countries&hellip;', 'woocommerce' ); ?>" title="<?php esc_attr_e( 'Country', 'woocommerce' ) ?>"
                    class="wc-enhanced-select" >
                <?php
                if ( ! empty( $countries ) ) {
                    foreach ( $countries as $key => $val ) {
                        echo '<option value="' . esc_attr( $key ) . '" ' . selected( in_array( $key, $selections ), true, false ).'>' . $val . '</option>';
                    }
                }
                ?>
            </select>
        </p>
        <?php
        if( empty( $countries ) ) {
            echo "<p><b>" .__( "You need to setup shipping locations in WooCommerce settings ", 'woo-product-country-base-restrictions')." <a href='admin.php?page=wc-settings'> ". __( "HERE", 'woo-product-country-base-restrictions' )."</a> ".__( "before you can choose country restrictions", 'woo-product-country-base-restrictions' )."</b></p>";
        }

        echo '</div>';

    }

    /*
     * Save All Meta Data Filed
     *
     * */
    function wpll_product_custom_fields_save($post_id){

        if (!empty( $_POST['_wpll_country_restriction_type_role'] )){
            update_post_meta ($post_id, '_wpll_country_restriction_type_role',  sanitize_text_field($_POST['_wpll_country_restriction_type_role']));
        }

        if( !empty($_POST['$country_type_attribute']) ){
            update_post_meta($post_id,'$country_type_attribute', sanitize_text_field($_POST['$country_type_attribute']));
        }

    }

    /*
    * Adding a WPLL settings fields to the WPLL settings for all variation type products
    *
    * @since 1.0.0
    * @para $loop, $variation_data, $variation
    */
    function wpll_variation_settings_fields( $loop, $variation_data, $variation ) {

        woocommerce_wp_select(
            array(
                'id'      => '_wpll_country_restriction_role_attribute[' . $variation->ID . ']',
                'label'   => __( 'Rule of Restriction', 'location-logic' ),
                'default'       => 'all',
                'class'         => 'availability wpll_restricted_type',
                'style'			=> 'width:100%;',
                'value'         => get_post_meta( $variation->ID, '_wpll_country_restriction_role_attribute', true ),
                'options'       => array(
                    'all'       => __( 'Available for all countries', 'location-logic' ),
                    'specific'  => __( 'Available for selected countries', 'location-logic' ),
                    'excluded'  => __( 'Not Available for selected countries', 'location-logic' ),
                )
            )
        );


        $selections = get_post_meta( $variation->ID, '_attribute_restricted_countries', true );
        if(empty($selections) || ! is_array($selections)) {
            $selections = array();
        }
        $countries_obj   = new WC_Countries();
        $countries   = $countries_obj->__get('countries');
        asort( $countries );

        ?>
        <p class="form-field forminp restricted_countries">
            <label for="_attribute_restricted_countries[<?php echo $variation->ID; ?>]"><?php echo __( 'Select 
            countries', 'location-logic' ); ?></label>
            <select multiple="multiple" name="_attribute_restricted_countries[<?php echo $variation->ID; ?>][]" style="width:100%;max-width: 350px;"
                    data-placeholder="<?php esc_attr_e( 'Choose countries&hellip;', 'location-logic' ); ?>" title="<?php
            esc_attr_e( 'Country', 'location-logic' ) ?>"
                    class="wc-enhanced-select">
                <?php
                if ( ! empty( $countries ) ) {
                    foreach ( $countries as $key => $val ) {
                        echo '<option value="' . esc_attr( $key ) . '" ' . selected( in_array( $key, $selections ),
                                true, false ).'>' . $val . '</option>';
                    }
                }
                ?>
            </select>
        </p>
        <?php
        if( empty( $countries ) ) {
            echo "<p><b>" .__( "You need to setup shipping locations in WooCommerce settings ", 'location-logic')." <a href='admin.php?page=wc-settings'> ". __( "HERE", 'location-logic' )."</a> ".__( "before you can choose country restrictions", 'location-logic' )."</b></p>";
        }
    }

    /*
    * Save the product meta settings for variation product
    *
    * @since 1.0.0
    * @para $post_id
    */
    function save_wpll_variation_settings_fields( $post_id ) {

        $restriction = sanitize_text_field($_POST['_wpll_country_restriction_role_attribute'][ $post_id ]);

        if( !isset( $_POST['_attribute_restricted_countries'] ) || empty( $_POST['_attribute_restricted_countries'] ) ) {
            update_post_meta( $post_id, '_wpll_country_restriction_role_attribute', 'all' );
        } else {
            if ( !empty( $restriction ) )
                update_post_meta( $post_id, '_wpll_country_restriction_role_attribute', $restriction );
        }

        $countries = array();
        if(isset($_POST["_attribute_restricted_countries"])) {
            $countries = wc_clean( $_POST['_attribute_restricted_countries'][ $post_id ] );
        }
        update_post_meta( $post_id, '_attribute_restricted_countries', $countries );
    }

















/*
 * Product Image Change by country
 *
 * */
    function add_product_custom_image() {
        add_meta_box(
            'add_meta_img', __( 'Product Image (Condition)', 'prfx-textdomain' ),
            'add_custom_image',
            'product',
            'side',
            ''
        );
    }

    function add_custom_image(){

        global $woocommerce, $post;
        $countries_object  =   new WC_Countries();
        $countries         =   $countries_object->__get('countries');
        $selected_country = implode('', get_post_meta($post->ID, '_the_country_field'));

        woocommerce_wp_select([
            'id'       => '_the_country_field',
            'label'    => __( 'Select', 'woocommerce' ),
            'selected' => true,
            'value'    => $selected_country,
            'options' => $countries,
        ]);

        echo "<h4>Image Upload Option</h4>";

    }












// // Product Visible for country based

//function wpll_hide_product_if_country( $visible, $product_id ){
//
//    global $product;
//    $location = WC_Geolocation::geolocate_ip();
//    $country = $location['country'];
//
//
//    if ( $country == "BD" && $product_id == 30 ) {
//        $visible = false;
//    }
//    return $visible;
//}


