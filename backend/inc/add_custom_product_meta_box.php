<?php

// Display Fields
add_action('woocommerce_product_options_general_product_data', 'woocommerce_product_custom_fields');
function woocommerce_product_custom_fields(){
    global $woocommerce, $post;

    echo '<div class="product_custom_field">';
    // Custom Product Text Field
    woocommerce_wp_text_input(
        array(
            'id' => '_custom_product_text_field',
            'placeholder' => 'Custom Product Text Field',
            'label' => __('Custom Product Text Field', 'woocommerce'),
            'desc_tip' => 'true'
        )
    );

    //Custom Product Number Field
    woocommerce_wp_text_input(
        array(
            'id' => '_custom_product_number_field',
            'placeholder' => 'Custom Product Number Field',
            'label' => __('Custom Product Number Field', 'woocommerce'),
            'type' => 'number',
            'custom_attributes' => array(
                'step' => 'any',
                'min' => '0'
            )
        )
    );

    //Custom Product  Textarea
    woocommerce_wp_textarea_input(
        array(
            'id' => '_custom_product_textarea',
            'placeholder' => 'Custom Product Textarea',
            'label' => __('Custom Product Textarea', 'woocommerce')
        )
    );
    echo '</div>';


}

function hide_product_custom_meta() {
    add_meta_box(
        'prfx_meta', __( 'Hide country', 'prfx-textdomain' ),
        'hide_custom_meta',
        'product',
        'side',
        ''
    );
}
add_action( 'add_meta_boxes', 'hide_product_custom_meta' );

function hide_custom_meta(){

    global $woocommerce, $post;

    echo '<div class="options_group">';
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

    echo '</div>';
}

// Save Fields
add_action('woocommerce_process_product_meta', 'woocommerce_product_custom_fields_save');
function woocommerce_product_custom_fields_save($post_id){

    // Custom Product Text Field
    $woocommerce_custom_product_text_field = $_POST['_custom_product_text_field'];
    if (!empty($woocommerce_custom_product_text_field)){
        update_post_meta($post_id, '_custom_product_text_field', esc_attr($woocommerce_custom_product_text_field));
    }

// Custom Product Number Field
    $woocommerce_custom_product_number_field = $_POST['_custom_product_number_field'];
    if (!empty($woocommerce_custom_product_number_field)){
        update_post_meta($post_id, '_custom_product_number_field', esc_attr($woocommerce_custom_product_number_field));
    }

// Custom Product Textarea Field
    $woocommerce_custom_procut_textarea = $_POST['_custom_product_textarea'];
    if (!empty($woocommerce_custom_procut_textarea)){
        update_post_meta($post_id, '_custom_product_textarea', esc_html($woocommerce_custom_procut_textarea));
    }


    if( !empty($_POST['_the_country_field']) ){
        update_post_meta($post_id,'_the_country_field', sanitize_text_field($_POST['_the_country_field']));
    }

}


// // Product Visible for country based
add_filter( 'woocommerce_product_is_visible', 'wplc_hide_product_if_country', 9999, 2 );
function wplc_hide_product_if_country( $visible, $product_id ){
    global $product;
    global $selected_country;
    $location = WC_Geolocation::geolocate_ip();
    $country = $location['country'];
    if ( $country == $selected_country && $product_id == 30 ) {
        $visible = false;
    }
    return $visible;
}


add_action('save_post', 'mp_sync_on_product_save');
function mp_sync_on_product_save( $con_value ){

    if ( ! empty( $con_value ) ) {
        update_post_meta( $con_value, '__the_country_field', esc_attr( $con_value ));
    }
}








