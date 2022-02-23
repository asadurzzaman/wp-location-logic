<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

    /*
     * All hooke for Single Product Meta Filed
     * */
    add_action('woocommerce_product_data_tabs', 'wpll_custom_product_meta_tab');
    add_action( 'woocommerce_product_data_panels', 'wpll_product_panels' );
    //add_filter( 'woocommerce_product_is_visible', 'wpll_hide_product_if_country', 9999, 2 );
    add_action( 'add_meta_boxes',  'add_product_custom_image' );
    add_action('woocommerce_process_product_meta', 'wpll_product_custom_fields_save');


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
     *
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

        $selected_country = implode('', get_post_meta($post->ID, '_type_role_country_list'));
        $countries_object  =   new WC_Countries();
        $countries         =   $countries_object->__get('countries');
        //var_dump($countries);
    ?>
        <p class="form-field forminp restricted_countries">

            <label for="_type_role_country_list"><?php echo __( 'Select countries', 'location-logic' ); ?></label>
            <select multiple="multiple" id="_type_role_country_list" name="_type_role_country_list" class="wplcation_select2"
                     data-placeholder="<?php __('Choose countries&hellip;','location-logic'); ?>" title="<?php esc_attr_e( 'Country', 'woocommerce' ) ?>">

                <?php
                    foreach ( $countries as $key => $val ) {
                        echo '<option value="' . esc_attr( $key ) . '">' . $val . '</option>';
                    }
                ?>

            </select>
        </p>
        <?php
        if( empty( $countries ) ) {
            echo "<p><b>" .__( "You need to setup shipping locations in WooCommerce settings ", 'woo-product-country-base-restrictions')." <a href='admin.php?page=wc-settings'> ". __( "HERE", 'woo-product-country-base-restrictions' )."</a> ".__( "before you can choose country restrictions", 'woo-product-country-base-restrictions' )."</b></p>";
        }

//        woocommerce_wp_select([
//            'id'       => '_type_role_country_list',
//            'label'    => __( 'Select', 'location-logic' ),
//            'selected' => true,
//            'value'    => $selected_country,
//            'options' => $countries,
//            'class'     =>  'wplcation_select2',
//           ' multiple' =>'multiple',
//        ]);

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

//        if (!empty( $_POST['my_text_field'] )){
//            update_post_meta ($post_id, 'my_text_field',  sanitize_text_field($_POST['my_text_field']));
//        }
//
//        if (!empty( $_POST['_regular_product_field'] )){
//            update_post_meta($post_id, '_regular_product_field', sanitize_text_field($_POST['_regular_product_field']));
//        }
    }




//    function WPll_single_product_attribute(){
//
//
//    }










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


