<?php
/**
 * Adds a meta box to the Product editing screen right bar
 */
function wplc_product_custom_meta() {
    add_meta_box(
            'prfx_meta', __( 'WP Location Logic', 'prfx-textdomain' ),
            'new_wplc_product_custom_meta',
            'product',
            'side',
            ''
    );
}
add_action( 'add_meta_boxes', 'wplc_product_custom_meta' );

function new_wplc_product_custom_meta() {

    $countries_object  =   new WC_Countries();
    $countries         =   $countries_object->__get('countries');
    echo '<div class="options_group">';
    woocommerce_form_field(
        'the_country_field',
        array(
            'type'       => 'select',
            'class'      => array( 'select' ),
            'label'      => __('Select a country'),
            'placeholder'    => __('Enter something'),
            'options'    => $countries
        )
    );
    echo '</div>';

}


