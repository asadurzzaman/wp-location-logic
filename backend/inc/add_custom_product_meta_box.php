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
                'style'			=> 'max-width:450px;width:100%;',
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
            <select id="_type_role_country_list" name="_type_role_country_list" class="wplcation_select2"
                     data-placeholder="<?php __('Choose countries&hellip;','location-logic'); ?>" title="<?php esc_attr_e( 'Country', 'woocommerce' ) ?>">

                <?php


                    foreach ( $countries as $key => $val ) {

                        echo '<option value="'.$key.'">'.$val.'</option>';

    echo '<option value="' . esc_attr( $key ) . '" ' . selected( in_array( $key, $selected_country ), true, false ) .'>' . $val . '</option>';
                    }

                ?>

            </select>
        </p>
<?php
















//        woocommerce_wp_select([
//            'id'       => '_type_role_country_list',
//            'label'    => __( 'Select', 'location-logic' ),
//            'selected' => true,
//            'value'    => $selected_country,
//            'options' => $countries,
//            'class'     =>  'wplcation_select2',
//           ' multiple' =>'multiple',
//        ]);

//        $text_value = get_post_meta( get_the_ID(), 'misha_plugin_version', true );
//        woocommerce_wp_text_input( array(
//            'id'                => 'misha_plugin_version',
//            'value'             => $text_value,
//            'label'             => 'Plugin version',
//            'description'       => 'Description when desc_tip param is not true'
//        ) );
//
//        woocommerce_wp_textarea_input( array(
//            'id'          => 'misha_changelog',
//            'value'       => get_post_meta( get_the_ID(), 'misha_changelog', true ),
//            'label'       => 'Changelog',
//            'desc_tip'    => true,
//            'description' => 'Prove the plugin changelog here',
//        ) );
//
//        woocommerce_wp_select( array(
//            'id'          => 'misha_ext',
//            'value'       => get_post_meta( get_the_ID(), 'misha_ext', true ),
//            'wrapper_class' => 'show_if_downloadable',
//            'label'       => 'File extension',
//            'selected' => true,
//            'options'     => array( '' => 'Please select', 'zip' => 'Zip', 'gzip' => 'Gzip'),
//        ) );
//
//        woocommerce_wp_text_input(
//            array(
//                'id' => '_custom_product_text_field',
//                'placeholder' => 'Custom Product Text Field',
//                'label' => __('Custom Product Text Field', 'woocommerce'),
//                'desc_tip' => 'true'
//            )
//        );



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

//        if( !empty($_POST['_type_role_country_list']) ){
//            update_post_meta($post_id,'_type_role_country_list', sanitize_text_field($_POST['_type_role_country_list']));
//        }

//        if (!empty( $_POST['_custom_product_text_field'] )){
//            update_post_meta ($post_id, '_custom_product_text_field',  sanitize_text_field($_POST['_custom_product_text_field']));
//        }
//
//        if (!empty( $_POST['_regular_product_field'] )){
//            update_post_meta($post_id, '_regular_product_field', sanitize_text_field($_POST['_regular_product_field']));
//        }



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


