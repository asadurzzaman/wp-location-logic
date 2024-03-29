<?php
/**
 * WPLL Single Product Attributes
 *
 * @package WPLL
 * @since 1.0.0
 */

if (!defined('WPINC')) {
    die;
}

global $woocommerce;
global $product;
       
//// Hooks Custom Product variation Filed
add_action('woocommerce_product_after_variable_attributes', 'wpll_variation_settings_fields', 10, 3);
add_action('woocommerce_save_product_variation', 'save_wpll_variation_settings_fields', 10, 2);

/*
* Adding a WPLL settings fields to the WPLL settings for all variation type products
*
* @since 1.0.0
* @para $loop, $variation_data, $variation
*/
function wpll_variation_settings_fields($loop, $variation_data, $variation)
{
    woocommerce_wp_select(
        array(
            'id' => '_wpll_country_restriction_type_role[' . $variation->ID . ']',
            'label' => __('Rule of Restriction', 'location-logic'),
            'default' => 'all',
            'class' => 'availability wpll_restricted_type',
            'style' => 'width:100%;',
            'value' => get_post_meta($variation->ID, '_wpll_country_restriction_type_role', true),
            'options' => array(
                'all' => __('Available for all countries', 'location-logic'),
                'specific' => __('Available for selected countries', 'location-logic'),
                'excluded' => __('Not Available for selected countries', 'location-logic'),
            )
        )
    );


    $selections = get_post_meta($variation->ID, '_attribute_restricted_countries', true);
    if (empty($selections) || !is_array($selections)) {
        $selections = array();
    }
    $countries_obj = new WC_Countries();
    $countries = $countries_obj->__get('countries');
    asort($countries);

    ?>
	<p class="form-field form input restricted_countries">
		<label for="_attribute_restricted_countries[<?php echo $variation->ID; ?>]"><?php echo __('Select 
            countries', 'location-logic'); ?></label>
		<select multiple="multiple" name="_attribute_restricted_countries[<?php echo $variation->ID; ?>][]"
		        style="width:100%;max-width: 350px;"
		        data-placeholder="<?php esc_attr_e('Choose countries&hellip;', 'location-logic'); ?>" title="<?php
        esc_attr_e('Country', 'location-logic') ?>"
		        class="wc-enhanced-select">
            <?php
            if (!empty($countries)) {
                foreach ($countries as $key => $val) {
                    echo '<option value="' . esc_attr($key) . '" ' . selected(in_array($key, $selections),
                            true, false) . '>' . $val . '</option>';
                }
            }
            ?>
		</select>
	</p>
    <?php
    if (empty($countries)) {
        echo "<p><b>" . __("You need to setup shipping locations in WooCommerce settings ", 'location-logic') . " <a href='admin.php?page=wc-settings'> " . __("HERE", 'location-logic') . "</a> " . __("before you can choose country restrictions", 'location-logic') . "</b></p>";
    }
}

/*
* Save the product meta settings for variation product
*
* @since 1.0.0
* @para $post_id
*/
function save_wpll_variation_settings_fields($post_id)
{

    $wpll_country_restriction_type_role = $_POST['_wpll_country_restriction_type_role'][$post_id];
    if (!empty($wpll_country_restriction_type_role)) {
        update_post_meta($post_id, '_wpll_country_restriction_type_role', esc_attr($wpll_country_restriction_type_role));
    }

    $attribute_restricted_countries = $_POST['_attribute_restricted_countries'][$post_id];
    if (!empty($attribute_restricted_countries)) {
        update_post_meta($post_id, '_attribute_restricted_countries', $attribute_restricted_countries);
    }
 
}
