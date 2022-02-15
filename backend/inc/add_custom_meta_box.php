<?php
/**
 * Adds a meta box to the post editing screen
 */
function prfx_custom_meta() {
    add_meta_box(
            'prfx_meta', __( 'WP Location Logic', 'prfx-textdomain' ),
            'new_meta_callback',
            'product',
            'side',
            ''
    );
}
add_action( 'add_meta_boxes', 'prfx_custom_meta' );

function prfx_meta_callback( $post ) {
    echo 'This is a meta box';
}

function new_meta_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'prfx_nonce' );
    $prfx_stored_meta = get_post_meta( $post->ID );
    ?>

    <p>
    <p class="hide-if-no-js">
        <a href="#">Set product image</a>
    </p>
        <label for="meta-image" class="prfx-row-title"><?php _e( 'Example File Upload', 'prfx-textdomain' )?></label>
        <input type="text" name="meta-image" id="meta-image" value="<?php if ( isset ( $prfx_stored_meta['meta-image'] ) ) echo $prfx_stored_meta['meta-image'][0]; ?>" />
        <input type="button" id="meta-image-button" class="button" value="<?php _e( 'Choose or Upload an Image', 'prfx-textdomain' )?>" />
    </p>

    <?php
}

function prfx_meta_save( $post_id ) {

    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'prfx_nonce' ] ) && wp_verify_nonce( $_POST[ 'prfx_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

    // Checks for input and sanitizes/saves if needed
    if( isset( $_POST[ 'meta-text' ] ) ) {
        update_post_meta( $post_id, 'meta-text', sanitize_text_field( $_POST[ 'meta-text' ] ) );
    }

}
add_action( 'save_post', 'prfx_meta_save' );

// Retrieves the stored value from the database
$meta_value = get_post_meta( get_the_ID(), 'meta-text', true );

// Checks and displays the retrieved value
if( !empty( $meta_value ) ) {
    echo $meta_value;
}


// Extra Meta Box add on Woocommerce Product Price Below
add_action( 'woocommerce_product_options_general_product_data', 'wpcl_adv_product_options');
function wpcl_adv_product_options(){

    echo '<div class="options_group">';
    woocommerce_wp_radio(array(
        'options' => array(
            "gio_location" => "Calculate prices by the exchange rate",
            "manual" => " Set prices manually"
        ),
        'name' => '_price_per_word_character',
        'value' => '',
        'id' => '_price_per_word_character',
        'label' => __('Price for.....!', 'woocommerce-price-per-word'),
        'desc_tip' => 'true',
        'description' => __('Choose whether to set ', 'woocommerce-price-per-word')
    ));
    echo '</div>';

    echo '<div class="options_group">';
    $options[''] = __( 'Select a value', 'woocommerce');
    woocommerce_wp_select( array(
        'id'      => 'super_product',
        'value'   => get_post_meta( get_the_ID(), 'super_product', true ),
        'label'   => 'This is a super product',
        'options' =>  $options,
        'desc_tip' => true,
        'description' => 'If it is not a regular WooCommerce product',
    ) );
    echo '</div>';

    echo '<div class="options_group">';
    woocommerce_wp_checkbox(array(
            'id' => '_is_web_font',
        'label' => __('Web Font?', 'ss-wc-digital-details'),
        'description' => __('Enable if this file is a Web Font.', 'ss-wc-digital-details'),
        'wrapper_class' => 'hide_if_variable'
    ));
    echo '</div>';

}


add_action( 'woocommerce_process_product_meta', 'misha_save_fields', 10, 2 );
function misha_save_fields( $id, $post ){

    //if( !empty( $_POST['super_product'] ) ) {
    update_post_meta( $id, 'super_product', $_POST['super_product'] );
    //} else {
    //	delete_post_meta( $id, 'super_product' );
    //}

}
