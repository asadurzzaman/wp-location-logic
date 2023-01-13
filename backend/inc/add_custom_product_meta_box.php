<?php

if (!defined('ABSPATH')) {
    exit;
}

/*
 * All hooke for Single Product Meta Filed
 * */
add_action('woocommerce_product_data_tabs', 'wpll_custom_product_meta_tab');
add_action('woocommerce_product_data_panels', 'wpll_product_panels');
add_action('add_meta_boxes', 'add_product_custom_image');
add_action('woocommerce_process_product_meta', 'wpll_product_custom_fields_save');

/*
 * Product Panel for WPLL Setting
 * @since 1.0.0
 * */
function wpll_custom_product_meta_tab($default_data)
{

    $default_data['wpll'] = array(
        'label' => __('WPLL Setting', 'location-logic'),
        'target' => 'wpll_product_data',
        'class' => array('llc-product-tab'),
        'priority' => 21,
    );

    return $default_data;
}

/*
 * Product Panel for WPLL Setting
 * @since 1.0.0
 * */
function wpll_product_panels()
{

    global $woocommerce, $post;

    echo '<div id="wpll_product_data" class="panel woocommerce_options_panel hidden">';
    $select_country_type = get_post_meta(get_the_ID(), '_wpll_country_restriction_type_role', true);
    woocommerce_wp_select(
        array(
            'id' => '_wpll_country_restriction_type_role',
            'label' => __('Rule of Restriction', 'location-logic'),
            'default' => 'all',
            'style' => 'max-width:350px;width:100%;',
            'class' => 'availability wpll_restricted_type wplcation_select2',
            'selected' => true,
            'options' => array(
                'all' => __('Available all countries', 'location-logic'),
                'specific' => __('Available selected countries', 'location-logic'),
                'excluded' => __('Not Available selected countries', 'location-logic'),
            )
        )
    );

    $selections = get_post_meta($post->ID, '_restricted_countries', true);

    if (empty($selections) || !is_array($selections)) {
        $selections = array();
    }
    $countries_obj = new WC_Countries();
    $countries = $countries_obj->__get('countries');
    asort($countries);
    ?>
    <p class="form-field forminp restricted_countries">
        <label for="_restricted_countries"><?php echo __('Select countries', 'woo-product-country-base-restrictions'); ?></label>
        <select id="_restricted_countries" multiple="multiple" name="_restricted_countries[]"
                style="width:100%;max-width: 350px;"
                data-placeholder="<?php esc_attr_e('Choose countries&hellip;', 'woocommerce'); ?>"
                title="<?php esc_attr_e('Country', 'woocommerce') ?>"
                class="wc-enhanced-select">
            <?php
            if (!empty($countries)) {
                foreach ($countries as $key => $val) {
                    echo '<option value="' . esc_attr($key) . '" ' . selected(in_array($key, $selections), true, false) . '>' . $val . '</option>';
                }
            }
            ?>
        </select>
    </p>
    <?php
    if (empty($countries)) {
        echo "<p><b>" . __("You need to setup shipping locations in WooCommerce settings ", 'woo-product-country-base-restrictions') . " <a href='admin.php?page=wc-settings'> " . __("HERE", 'woo-product-country-base-restrictions') . "</a> " . __("before you can choose country restrictions", 'woo-product-country-base-restrictions') . "</b></p>";
    }

    echo '</div>';

}

/*
 * Save All Meta Data Filed
 *
 * */
function wpll_product_custom_fields_save($post_id)
{

    if (!empty($_POST['_wpll_country_restriction_type_role'])) {
        update_post_meta($post_id, '_wpll_country_restriction_type_role', sanitize_text_field($_POST['_wpll_country_restriction_type_role']));
    }

    if (!empty($_POST['$country_type_attribute'])) {
        update_post_meta($post_id, '$country_type_attribute', sanitize_text_field($_POST['$country_type_attribute']));
    }

}


/**
 * Extra Meta Box add on Woocommerce Product Price Below
 * @since 1.0.0
 *
 */
add_action('woocommerce_product_options_general_product_data', 'wpcl_adv_product_options');
function wpcl_adv_product_options()
{

    echo '<div class="options_group">';
    $wc_radio = isset( $_POST['_price_per_word_character'] ) ? $_POST['_price_per_word_character'] : '';
    woocommerce_wp_radio( array(
        'options'     => array(
            "gio_location" => "Calculate prices by the exchange rate",
            "manual"       => " Set prices manually"
        ),
        'name'        => '_price_per_word_character',
        'value'       => $wc_radio,
        'class'        => 'radio_box',
        'id'          => '_price_per_word_character',
        'label'       => __( 'Price for.....!', 'location-logic' ),
        'desc_tip'    => 'true',
        'description' => __( 'Choose whether to set ', 'wlocation-logic' )
    ) );
    echo '</div>';
    echo '<div class="options_group">';
    echo '<div class="manual box">manual have selected <strong>red radio button</strong> so i am here</div>';
    echo '<div class="gio_location box">gio_location have selected <strong>red radio button</strong> so i am here</div>';
    echo '</div>';
    ?>

	<script>
        jQuery(document).ready(function(){
            jQuery('.box').hide();
            jQuery('input[type="radio"]').click(function(){
                var inputValue = jQuery(this).attr("value");
                var targetBox = jQuery("." + inputValue);
                jQuery(".box").not(targetBox).hide();
                jQuery(targetBox).show();
            });
        });

	</script>
    <?php


}

// Save the data of the custom tab in edit product page settings
add_action( 'woocommerce_process_product_meta',   'shipping_costs_process_product_meta_fields_save' );
function shipping_costs_process_product_meta_fields_save( $post_id ){
    // save the radio button field data
    $wc_radio = isset( $_POST['_price_per_word_character'] ) ? $_POST['_price_per_word_character'] : '';
    update_post_meta( $post_id, '_price_per_word_character', $wc_radio );
}



/*
 * Product Image Change by country
 *
 * */
//
//function add_product_custom_image()
//{
//    add_meta_box(
//        'add_meta_img', __('Product Image (Condition)', 'prfx-textdomain'),
//        'add_custom_image',
//        'product',
//        'side',
//        ''
//    );
//}
//
//function add_custom_image($post, $thumbnail_id)
//{
//    echo "<h4>Image Upload Option</h4>";
//    $post = get_post($post);
//    $thumbnail_id = absint($thumbnail_id);
//    if ($post && $thumbnail_id && get_post($thumbnail_id)) {
//        if (wp_get_attachment_image($thumbnail_id, 'thumbnail')) {
//            return update_post_meta($post->ID, '_thumbnail_id', $thumbnail_id);
//        } else {
//            return delete_post_meta($post->ID, '_thumbnail_id');
//        }
//    }
//    return false;
//}
//
//
//add_action( 'add_meta_boxes', 'multi_media_uploader_meta_box' );
//function multi_media_uploader_meta_box() {
//	add_meta_box(
//	        'my-post-box',
//            'Product Image',
//            'multi_media_uploader_meta_box_func',
//            'product',
//            'side',
//    );
//}
//
//function multi_media_uploader_meta_box_func($post, $thumbnail_id) {
//	$banner_img = get_post_meta($post->ID,'post_banner_img',true);
//
//	$post = get_post($post);
//	$thumbnail_id = absint($thumbnail_id);
//
//	global $woocommerce, $post;
//	$countries_object = new WC_Countries();
//	$countries = $countries_object->__get('countries');
//	$selected_country = implode('', get_post_meta($post->ID, '_the_country_field'));
//
//	woocommerce_wp_select([
//		'id' => '_the_country_field',
//		'label' => __('Select', 'woocommerce'),
//		'selected' => true,
//		'value' => $selected_country,
//		'options' => $countries,
//	]);
//	?>
<!--    <div class="inside">-->
<!--	    --><?php //echo multi_media_uploader_field( 'post_banner_img', $banner_img ); ?>
<!--    </div>-->
<!---->
<!--    <script type="text/javascript">-->
<!--        jQuery(function($) {-->
<!---->
<!--            $('body').on('click', '.wc_multi_upload_image_button', function(e) {-->
<!--                e.preventDefault();-->
<!--                var button = $(this),-->
<!--                    custom_uploader = wp.media({-->
<!--                        title: 'Insert image',-->
<!--                        button: { text: 'Use this image' },-->
<!--                        multiple: true-->
<!--                    }).on('select', function() {-->
<!--                        var attech_ids = '';-->
<!--                        attachments-->
<!--                        var attachments = custom_uploader.state().get('selection'),-->
<!--                            attachment_ids = new Array(),-->
<!--                            i = 0;-->
<!--                        attachments.each(function(attachment) {-->
<!--                            attachment_ids[i] = attachment['id'];-->
<!--                            attech_ids += ',' + attachment['id'];-->
<!--                            if (attachment.attributes.type == 'image') {-->
<!--                                $(button).siblings('ul').append('<li data-attechment-id="' + attachment['id'] + '"><a href="' + attachment.attributes.url + '" target="_blank"><img class="true_pre_image" src="' + attachment.attributes.url + '" /></a><i class=" dashicons dashicons-no delete-img"></i></li>');-->
<!--                            } else {-->
<!--                                $(button).siblings('ul').append('<li data-attechment-id="' + attachment['id'] + '"><a href="' + attachment.attributes.url + '" target="_blank"><img class="true_pre_image" src="' + attachment.attributes.icon + '" /></a><i class=" dashicons dashicons-no delete-img"></i></li>');-->
<!--                            }-->
<!---->
<!--                            i++;-->
<!--                        });-->
<!---->
<!--                        var ids = $(button).siblings('.attechments-ids').attr('value');-->
<!--                        if (ids) {-->
<!--                            var ids = ids + attech_ids;-->
<!--                            $(button).siblings('.attechments-ids').attr('value', ids);-->
<!--                        } else {-->
<!--                            $(button).siblings('.attechments-ids').attr('value', attachment_ids);-->
<!--                        }-->
<!--                        $(button).siblings('.wc_multi_remove_image_button').show();-->
<!--                    })-->
<!--                        .open();-->
<!--            });-->
<!---->
<!--            $('body').on('click', '.wc_multi_remove_image_button', function() {-->
<!--                $(this).hide().prev().val('').prev().addClass('button').html('Add Media');-->
<!--                $(this).parent().find('ul').empty();-->
<!--                return false;-->
<!--            });-->
<!---->
<!--        });-->
<!---->
<!--        jQuery(document).ready(function() {-->
<!--            jQuery(document).on('click', '.multi-upload-medias ul li i.delete-img', function() {-->
<!--                var ids = [];-->
<!--                var this_c = jQuery(this);-->
<!--                jQuery(this).parent().remove();-->
<!--                jQuery('.multi-upload-medias ul li').each(function() {-->
<!--                    ids.push(jQuery(this).attr('data-attechment-id'));-->
<!--                });-->
<!--                jQuery('.multi-upload-medias').find('input[type="hidden"]').attr('value', ids);-->
<!--            });-->
<!--        })-->
<!--    </script>-->
<!--	--><?php
//}
//
//function multi_media_uploader_field($name, $value = '') {
//	$image = '">Add Image';
//	$image_str = '';
//	$image_size = 'thumbnail';
//	$display = 'none';
//	$value = explode(',', $value);
//
//	if (!empty($value)) {
//		foreach ($value as $values) {
//			if ($image_attributes = wp_get_attachment_image_src($values, $image_size)) {
//				$image_str .= '<li data-attechment-id=' . $values . '><a href="' . $image_attributes[0] . '" target="_blank"><img src="' . $image_attributes[0] . '" /></a><i class="dashicons dashicons-no delete-img"></i></li>';
//			}
//		}
//
//	}
//
//	if($image_str){
//		$display = 'inline-block';
//	}
//
//	return '<div class="multi-upload-medias"><ul>' . $image_str . '</ul><a href="#" class="wc_multi_upload_image_button button' . $image . '</a><input type="hidden" class="attechments-ids ' . $name . '" name="' . $name . '" id="' . $name . '" value="' . esc_attr(implode(',', $value)) . '" /><a href="#" class="wc_multi_remove_image_button button" style="display:inline-block;display:' . $display . '">Remove Image</a></div>';
//}

// Save Meta Box values.

//add_action( 'save_post', 'wc_meta_box_save' );
//function wc_meta_box_save( $post_id ) {
//
//	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
//		return;
//	}
//
//	if( !current_user_can( 'edit_post' ) ){
//		return;
//	}
//
//	if( isset( $_POST['post_banner_img'] ) ){
//		update_post_meta( $post_id, 'post_banner_img', $_POST['post_banner_img'] );
//	}
//}


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


