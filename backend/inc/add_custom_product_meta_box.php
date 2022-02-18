<?php

// Display Fields
add_action('woocommerce_product_options_general_product_data', 'woocommerce_product_custom_fields');
function woocommerce_product_custom_fields()
{
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

    echo "<pre>";
    var_dump($selected_country);
    echo "</pre>";

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
        update_post_meta($post_id,'_the_country_field', $_POST['_the_country_field']);
    }

}

// Add a custom field to Admin coupon settings pages
add_action( 'woocommerce_coupon_options', 'add_coupon_text_field', 10 );
if( !function_exists('add_coupon_text_field')){
    function add_coupon_text_field() {
        woocommerce_wp_text_input( array(
            'id'                => 'seller_id',
            'label'             => __( 'Custom Option', 'woocommerce' ),
            'placeholder'       => '',
            'description'       => __( 'Custom Option', 'woocommerce' ),
            'desc_tip'    => true,

        ) );
    }
}

// Save the custom field value from Admin coupon settings pages
add_action( 'woocommerce_coupon_options_save', 'save_coupon_text_field', 10, 2 );
if( ! function_exists('save_coupon_text_field')){
    function save_coupon_text_field( $post_id, $coupon ) {

        if( isset( $_POST['seller_id'] ) ) {
            $coupon->update_meta_data( 'seller_id', sanitize_text_field( $_POST['seller_id'] ) );
            $coupon->save();
        }
    }
}







