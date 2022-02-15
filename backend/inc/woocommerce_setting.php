<?php
// Register Custom Taxonomy
function wplc_woo_taxonomy_add()  {
    $labels = array(
        'name'                       => 'Conditions',
        'singular_name'              => 'Condition',
        'menu_name'                  => 'Conditions',
        'all_items'                  => 'All Conditions',
        'parent_item'                => 'Parent Condition',
        'parent_item_colon'          => 'Parent Condition:',
        'new_item_name'              => 'New Condition Name',
        'add_new_item'               => 'Add New Condition',
        'edit_item'                  => 'Edit Condition',
        'update_item'                => 'Update Condition',
        'separate_items_with_commas' => 'Separate Condition with commas',
        'search_items'               => 'Search Conditions',
        'add_or_remove_items'        => 'Add or remove Conditions',
        'choose_from_most_used'      => 'Choose from the most used Conditions',
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    );
    register_taxonomy( 'condition', 'product', $args );
}
add_action( 'init', 'wplc_woo_taxonomy_add', 0 );

function wplc_condition_add_term_fields( $taxonomy ) {?>

    <div class="form-field">
        <label for="cb_custom_meta_data">Custom Meta Data Field</label>
        <input type="text" name="cb_custom_meta_data" id="cb_custom_meta_data" />
        <select name="" id="">
            <option value="">One</option>
            <option value="">One</option>
            <option value="">One</option>
            <option value="">One</option>
            <option value="">One</option>
            <option value="">One</option>
        </select>
        <p>Description for meta field goes here.</p>
    </div>
<?php
}
add_action( 'condition_add_form_fields', 'wplc_condition_add_term_fields' );



//Add new taxonomy meta box on Add Product Page
add_action( 'add_meta_boxes', 'wplc_add_meta_box');
function wplc_add_meta_box() {
    add_meta_box(
        'condition_id',
        'Set Condition',
        'wplc_custom_metabox',
        'product' ,
        'side',
        'core'
    );
}
// Call back function for Custom Meta Box
function wplc_custom_metabox( $value ) {
    echo 'This is my taxonomy metabox';
}


//// Custom Filed Product variation
//add_action( 'woocommerce_product_after_variable_attributes', 'variation_settings_fields', 10, 3 );
//add_action( 'woocommerce_save_product_variation', 'save_variation_settings_fields', 10, 2 );
//add_filter( 'woocommerce_available_variation', 'load_variation_settings_fields' );
//
//function variation_settings_fields( $loop, $variation_data, $variation ) {
//    woocommerce_wp_textarea_input(
//        array(
//            'id'            => "my_text_field{$loop}",
//            'name'          => "my_text_field[{$loop}]",
//            'value'         => get_post_meta( $variation->ID, 'my_text_field', true ),
//            'label'         => __( 'Some label', 'woocommerce' ),
//            'desc_tip'      => true,
//            'description'   => __( 'Some description.', 'woocommerce' ),
//            'wrapper_class' => 'form-row form-row-full',
//        )
//    );
//}
//
//function save_variation_settings_fields( $variation_id, $loop ) {
//    $text_field = $_POST['my_text_field'][ $loop ];
//
//    if ( ! empty( $text_field ) ) {
//        update_post_meta( $variation_id, 'my_text_field', esc_attr( $text_field ));
//    }
//}
//
//function load_variation_settings_fields( $variation ) {
//    $variation['my_text_field'] = get_post_meta( $variation[ 'variation_id' ], 'my_text_field', true );
//
//    return $variation;
//}


