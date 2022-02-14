<?php
/**
 * Adds a meta box to the post editing screen
 */
function prfx_custom_meta() {
    add_meta_box( 'prfx_meta', __( 'Meta Box Title', 'prfx-textdomain' ), 'new_meta_callback', 'product','side','high' );
}
add_action( 'add_meta_boxes', 'prfx_custom_meta' );
/**
 * Outputs the content of the meta box
 */
function prfx_meta_callback( $post ) {
    echo 'This is a meta box';
}

/**
 * Outputs the content of the meta box
 */
function new_meta_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'prfx_nonce' );
    $prfx_stored_meta = get_post_meta( $post->ID );
    ?>

    <p>
        <label for="meta-text" class="prfx-row-title"><?php _e( 'Example Text Input', 'prfx-textdomain' )?></label>
        <input type="text" name="meta-text" id="meta-text" value="<?php if ( isset ( $prfx_stored_meta['meta-text'] ) ) echo $prfx_stored_meta['meta-text'][0]; ?>" />
    </p>
    <p>
        <span class="prfx-row-title"><?php _e( 'Example Checkbox Input', 'prfx-textdomain' )?></span>
    <div class="prfx-row-content">
        <label for="meta-checkbox">
            <input type="checkbox" name="meta-checkbox" id="meta-checkbox" value="yes" <?php if ( isset ( $prfx_stored_meta['meta-checkbox'] ) ) checked( $prfx_stored_meta['meta-checkbox'][0], 'yes' ); ?> />
            <?php _e( 'Checkbox label', 'prfx-textdomain' )?>
        </label>
        <label for="meta-checkbox-two">
            <input type="checkbox" name="meta-checkbox-two" id="meta-checkbox-two" value="yes" <?php if ( isset ( $prfx_stored_meta['meta-checkbox-two'] ) ) checked( $prfx_stored_meta['meta-checkbox-two'][0], 'yes' ); ?> />
            <?php _e( 'Another checkbox', 'prfx-textdomain' )?>
        </label>
    </div>
    </p>
    <p>
        <span class="prfx-row-title"><?php _e( 'Example Radio Buttons', 'prfx-textdomain' )?></span>
    <div class="prfx-row-content">
        <label for="meta-radio-one">
            <input type="radio" name="meta-radio" id="meta-radio-one" value="radio-one" <?php if ( isset ( $prfx_stored_meta['meta-radio'] ) ) checked( $prfx_stored_meta['meta-radio'][0], 'radio-one' ); ?>>
            <?php _e( 'Radio Option #1', 'prfx-textdomain' )?>
        </label>
        <label for="meta-radio-two">
            <input type="radio" name="meta-radio" id="meta-radio-two" value="radio-two" <?php if ( isset ( $prfx_stored_meta['meta-radio'] ) ) checked( $prfx_stored_meta['meta-radio'][0], 'radio-two' ); ?>>
            <?php _e( 'Radio Option #2', 'prfx-textdomain' )?>
        </label>
    </div>
    </p>
    <p>
        <label for="meta-select" class="prfx-row-title"><?php _e( 'Example Select Input', 'prfx-textdomain' )?></label>
        <select name="meta-select" id="meta-select">
            <option value="select-one" <?php if ( isset ( $prfx_stored_meta['meta-select'] ) ) selected( $prfx_stored_meta['meta-select'][0], 'select-one' ); ?>><?php _e( 'One', 'prfx-textdomain' )?></option>';
            <option value="select-two" <?php if ( isset ( $prfx_stored_meta['meta-select'] ) ) selected( $prfx_stored_meta['meta-select'][0], 'select-two' ); ?>><?php _e( 'Two', 'prfx-textdomain' )?></option>';
        </select>
    </p>
    <p>
        <label for="meta-color" class="prfx-row-title"><?php _e( 'Color Picker', 'prfx-textdomain' )?></label>
        <input name="meta-color" type="text" value="<?php if ( isset ( $prfx_stored_meta['meta-color'] ) ) echo $prfx_stored_meta['meta-color'][0]; ?>" class="meta-color" />
    </p>
    <p>
        <label for="meta-image" class="prfx-row-title"><?php _e( 'Example File Upload', 'prfx-textdomain' )?></label>
        <input type="text" name="meta-image" id="meta-image" value="<?php if ( isset ( $prfx_stored_meta['meta-image'] ) ) echo $prfx_stored_meta['meta-image'][0]; ?>" />
        <input type="button" id="meta-image-button" class="button" value="<?php _e( 'Choose or Upload an Image', 'prfx-textdomain' )?>" />
    </p>

    <?php
}

/**
 * Saves the custom meta input
 */
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