<div class="tab_body_header">
    <h2><?php _e('Conditions', 'location-logic') ?></h2>
    <button>Create Conditions</button>
</div>
<div id="wplc_condiction">
    <div id="demo" class="wplc_accordion">
        <div class="wplc_accordion_card">
            <div class="wplc_accordion_title"><label for="condition_name">Logic Block Name</label></div>
            <div class="wplc_accordion_panel">

                <div class="wpcl_primary_condition">
                    <div class="logic_block_shortcode">
                        <input type="text" value='[wplc_block id="" ]'>
                    </div>
                    <div class="condition_name">
                        <input type="text" id="condition_name" name="condition_name" value=""
                               placeholder="Logic Block Name">
                    </div>
                    <select>
                        <option value="if">If</option>
                    </select>
                    <select class="block_condition wplcation_select2">
                        <option value="">Select a Condition</option>
                        <option value="">New Condition</option>
                        <option value="">Default Conditions</option>
                        <option value="">No Conditions Met</option>
                        <option value="">Condition(s) Met</option>
                        <option value="">User's First Visit</option>
                        <option value="">User Repeat Visit (Data Plan Requried)</option>
                        <option value="">User Has Viewed More Than 1 Page</option>
                        <option value="">User Visiting Site Directly - No Referrer</option>
                        <option value="">User on a Desktop or Laptop Computer</option>
                        <option value="">User on a Mobile Device</option>
                        <option value="">User on a Tablet</option>
                        <option value="">User is Logged In</option>
                        <option value="">User from Google search</option>
                        <option value="">Always Display</option>
                        <option value="">WooCommerce Shopping Cart is Empty</option>
                        <option value="">WooCommerce Shopping Cart has Products</option>
                        <option value="">WooCommerce Customer Data Available</option>
                        <option value="">WooCommerce Paying Customer</option>
                    </select>
                    <select name="" id="">
                        <option value="">Condition Meet</option>
                        <option value="">Condition Not Meet</option>
                    </select>
                    <div class="condition_block_content">
                        <p>Show Content</p>
                        <textarea rows="5" cols="115"></textarea >
                        <div class="add_button">
                            <a href="#" class="button">Add Data Variable</a>
                            <a href="#" class="button">Add Media</a>
                        </div>
                    </div>

                    <div class="repeater_logic_block">

                        <select>
                            <option value="">Else If</option>
                            <option value="">Else</option>
                            <option value="">If Else</option>
                        </select>
                        <select class="block_condition wplcation_select2">
                            <option value="">Select a Condition</option>
                            <option value="">New Condition</option>
                            <option value="">Default Conditions</option>
                            <option value="">No Conditions Met</option>
                            <option value="">Condition(s) Met</option>
                            <option value="">User's First Visit</option>
                            <option value="">User Repeat Visit (Data Plan Requried)</option>
                            <option value="">User Has Viewed More Than 1 Page</option>
                            <option value="">User Visiting Site Directly - No Referrer</option>
                            <option value="">User on a Desktop or Laptop Computer</option>
                            <option value="">User on a Mobile Device</option>
                            <option value="">User on a Tablet</option>
                            <option value="">User is Logged In</option>
                            <option value="">User from Google search</option>
                            <option value="">Always Display</option>
                            <option value="">WooCommerce Shopping Cart is Empty</option>
                            <option value="">WooCommerce Shopping Cart has Products</option>
                            <option value="">WooCommerce Customer Data Available</option>
                            <option value="">WooCommerce Paying Customer</option>
                        </select>
                        <div class="condition_block_content">
                            <p>Show Content</p>
                            <textarea rows="5" cols="115"></textarea >
                            <div class="add_button">
                                <a href="#" class="button">Add Data Variable</a>
                                <a href="#" class="button">Add Media</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <button id="remove_more_text" class="add_button"><span class="dashicons dashicons-remove "></span>
            </button>
        </div>
    </div>

</div>

<script>
    // jQuery(function() {
    //     jQuery('.wplc_accordion_title').click(function(j) {
    //
    //         var dropDown = jQuery(this).closest('.wplc_accordion_card').find('.wplc_accordion_panel');
    //         jQuery(this).closest('.acc').find('.acc__panel').not(dropDown).slideUp();
    //
    //         if (jQuery(this).hasClass('active')) {
    //             jQuery(this).removeClass('active');
    //         } else {
    //             jQuery(this).closest('.acc').find('.wplc_accordion_title.active').removeClass('active');
    //             jQuery(this).addClass('active');
    //         }
    //
    //         dropDown.stop(false, true).slideToggle();
    //         j.preventDefault();
    //     });
    // });
</script>
