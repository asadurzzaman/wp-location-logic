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
            'id' => '_regular_product_field',
            'placeholder' => '$12',
            'label' => __('Regular Product Price', 'woocommerce'),
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
    $woocommerce_custom_product_number_field = $_POST['_regular_product_field'];
    if (!empty($woocommerce_custom_product_number_field)){
        update_post_meta($post_id, '_regular_product_field', esc_attr($woocommerce_custom_product_number_field));
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
    $location = WC_Geolocation::geolocate_ip();
    $country = $location['country'];


    if ( $country == "BD" && $product_id == 30 ) {
        $visible = false;
    }
    return $visible;
}


function add_product_custom_image() {
    add_meta_box(
        'add_meta_img', __( 'Product Image (Condition)', 'prfx-textdomain' ),
        'add_custom_image',
        'product',
        'side',
        ''
    );
}
add_action( 'add_meta_boxes', 'add_product_custom_image' );


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



// Generating dynamically the product "regular price"
add_filter( 'woocommerce_product_get_regular_price', 'custom_dynamic_regular_price', 10, 2 );
add_filter( 'woocommerce_product_variation_get_regular_price', 'custom_dynamic_regular_price', 10, 2 );
function custom_dynamic_regular_price( $regular_price, $product ) {
    if( empty($regular_price) || $regular_price == 0 )
        return $product->get_price();
    else
        return $regular_price;
}


// Generating dynamically the product "sale price"
add_filter( 'woocommerce_product_get_sale_price', 'custom_dynamic_sale_price', 10, 2 );
add_filter( 'woocommerce_product_variation_get_sale_price', 'custom_dynamic_sale_price', 10, 2 );
function custom_dynamic_sale_price( $sale_price, $product ) {

    $rate = 0.8;
    if( empty($sale_price) || $sale_price == 0 )
        return $product->get_regular_price() * $rate;
    else
        return $sale_price;
};

// Displayed formatted regular price + sale price
add_filter( 'woocommerce_get_price_html', 'custom_dynamic_sale_price_html', 20, 2 );
function custom_dynamic_sale_price_html( $price_html, $product ) {
    if( $product->is_type('variable') ) return $price_html;

    $price_html = wc_format_sale_price( wc_get_price_to_display( $product, array( 'price' => $product->get_regular_price() ) ), wc_get_price_to_display(  $product, array( 'price' => $product->get_sale_price() ) ) ) . $product->get_price_suffix();

    return $price_html;
}



/*
 * Checkout page country filed override
 *
 *
 * */

//add_filter( 'woocommerce_checkout_fields' , 'wpcl_simplify_checkout_virtual' );
//function wpcl_simplify_checkout_virtual( $fields ) {
//    //unset($fields['billing']['billing_city']);
//    unset($fields['billing']['billing_country']);
//    //unset($fields['billing']['billing_state']);
//    return $fields;
//}
//add_filter( 'woocommerce_billing_fields', 'wpcl_simplify_checkout_virtual' );

function njengah_override_checkout_fields( $fields ) {

    unset($fields['billing']['billing_country']);

    return $fields;

}

add_filter('woocommerce_checkout_fields','njengah_override_checkout_fields');

function new_woocommerce_checkout_fields($fields){
    $geoloc = WC_Geolocation::geolocate_ip();
    $country_name = $geoloc['country'];

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

    echo '<select class="">';
    echo '<option value="'.$country_name.'">'.$country_name.'</option>';
    echo '</select>';

 return $fields;
}
add_action('woocommerce_billing_fields', 'new_woocommerce_checkout_fields');
?>



</select>

