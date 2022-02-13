<?php

$UserData = get_userdata(1);
$UserName = $UserData->display_name;

?>

<div id="wp_location_main_wrapper" >

    <div id="wp_location_main_header">
        <div class="col-1">
            <h2>WelCome,  <?php echo $UserName; ?>.</h2>
            <p>Version : 0.0.1</p>
        </div>
        <div class="col-2">

        </div>
    </div>

    <div id="wp_location_full_container">

        <div id="wp_location_left_sidebar">
            <h2>WP Location Logic</h2>
            <header id="tabs_menu" class="tabs-nav">
                <ul class="tabs">
                    <li  class="tab_item tab_item_active" data-target="dashboard">Dashboard</li>
                    <li class="tab_item" data-target="all_conditions">All Conditions</li>
                    <li class="tab_item" data-target="all_logic">All Logic Blocks</li>
                    <li class="tab_item" data-target="banner_bars">Logic Bars / Banners</li>
                    <li class="tab_item" data-target="popup">Logic Popups</li>
                    <li class="tab_item" data-target="coupon_code">Logic Coupon Code</li>
                    <li class="tab_item" data-target="logic_goal">All Logic Goals</li>
                    <li class="tab_item" data-target="redirects">Redirects</li>
                    <li class="tab_item" data-target="integrations">Integrations</li>
                    <li class="tab_item" data-target="woocommerce">Woocommerce</li>
                    <li class="tab_item" data-target="setting">Setting</li>
                </ul>
            </header>
        </div>
        <div id="tab_content" class="wp_location_main_container">

            <section class="tabs-content">
                <div class="tab_body" data-id="dashboard">

                </div>
                <div class="tab_body" data-id="all_conditions">
                    <div class="tab_body_header">
                        <h2><?php _e('Conditions', 'location-logic') ?></h2>
                        <button>Create Conditions</button>
                    </div>
                    <div id="wplc_condiction">
                        <div id="demo" class="wplc_accordion">
                            <div class="wplc_accordion_card">
                                <div class="wplc_accordion_title"><label for="condition_name">Condition Name</label></div>
                                <div class="wplc_accordion_panel">

                                    <div class="wpcl_primary_condition">
                                        <div class="condition_name">
                                            <input type="text" id="condition_name" name="condition_name" value=""
                                                   placeholder="Condition Name">
                                        </div>
                                        <select>
                                            <option value="if">If</option>
                                        </select>
                                        <select class="wplcation_select2" >
                                            <option value="Condition Category">Condition Category</option>
                                            <option value="Custom Data">Custom Data</option>
                                            <option value="Geolocation">Geolocation</option>
                                            <option value="Logic Hop Goals">Logic Hop Goals</option>
                                            <option value="Time">Time</option>
                                            <option value="URL Parameters">URL Parameters</option>
                                            <option value="User Content Viewed">User Content Viewed</option>
                                            <option value="Visitor Behavior">Visitor Behavior</option>
                                            <option value="Visitor Data">Visitor Data</option>
                                            <option value="Visitor Device">Visitor Device</option>
                                            <option value="Visitor Metadata">Visitor Metadata</option>
                                        </select>
                                        <button id="add_more_condition" class=""><span class="dashicons
                                dashicons-insert"></span></button>
                                    </div>

                                    <div class="wpcl_secondary_condition">
                                        <div class="secondary_condition_title">AND / OR </div>
                                        <select>
                                            <option value="AND">And</option>
                                            <option value="OR">Or</option>
                                        </select>

                                        <select class="wplcation_select2" >
                                            <option value="Condition Category">Condition Category</option>
                                            <option value="Custom Data">Custom Data</option>
                                            <option value="Geolocation">Geolocation</option>
                                            <option value="Logic Hop Goals">Logic Hop Goals</option>
                                            <option value="Time">Time</option>
                                            <option value="URL Parameters">URL Parameters</option>
                                            <option value="User Content Viewed">User Content Viewed</option>
                                            <option value="Visitor Behavior">Visitor Behavior</option>
                                            <option value="Visitor Data">Visitor Data</option>
                                            <option value="Visitor Device">Visitor Device</option>
                                            <option value="Visitor Metadata">Visitor Metadata</option>
                                        </select>
                                        <button id="remove_more_text" class="add_button"><span class="dashicons dashicons-remove "></span>
                                        </button>
                                    </div>
                                </div>
                                <button id="remove_more_text" class="add_button"><span class="dashicons dashicons-remove "></span>
                                </button>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="tab_body" data-id="all_logic">
                    <h3>All Logic Blocks</h3>

                </div>
                <div class="tab_body" data-id="banner_bars">
                    <h3>All Logic Bars</h3>
                    <p>Just go out and talk to a tree. Make friends with it. For the lack of a better word I call them hangy downs. There's nothing wrong with having a tree as a friend. Maybe there's a happy little waterfall happening over here. I think there's an artist hidden in the bottom of every single one of us. So often we avoid running water, and running water is a lot of fun.</p>
                </div>
                <div class="tab_body" data-id="popup">
                    <h3>All Logic Goals</h3>
                    <p>Just go out and talk to a tree. Make friends with it. For the lack of a better word I call them hangy downs. There's nothing wrong with having a tree as a friend. Maybe there's a happy little waterfall happening over here. I think there's an artist hidden in the bottom of every single one of us. So often we avoid running water, and running water is a lot of fun.</p>
                </div>
                <div class="tab_body" data-id="coupon_code">
                    <h3>Redirects</h3>
                    <p>Just go out and talk to a tree. Make friends with it. For the lack of a better word I call them hangy downs. There's nothing wrong with having a tree as a friend. Maybe there's a happy little waterfall happening over here. I think there's an artist hidden in the bottom of every single one of us. So often we avoid running water, and running water is a lot of fun.</p>
                </div>
                <div class="tab_body" data-id="logic_goal">
                    <h3>Integrations</h3>
                    <p>Just go out and talk to a tree. Make friends with it. For the lack of a better word I call them hangy downs. There's nothing wrong with having a tree as a friend. Maybe there's a happy little waterfall happening over here. I think there's an artist hidden in the bottom of every single one of us. So often we avoid running water, and running water is a lot of fun.</p>
                </div>
                <div class="tab_body" data-id="redirects">
                    <h3>Woocommerce</h3>
                    <p>Just go out and talk to a tree. Make friends with it. For the lack of a better word I call them hangy downs. There's nothing wrong with having a tree as a friend. Maybe there's a happy little waterfall happening over here. I think there's an artist hidden in the bottom of every single one of us. So often we avoid running water, and running water is a lot of fun.</p>
                </div>
                <div class="tab_body" data-id="integrations">
                    <h3>Setting</h3>
                    <p>Just go out and talk to a tree. Make friends with it. For the lack of a better word I call them hangy downs. There's nothing wrong with having a tree as a friend. Maybe there's a happy little waterfall happening over here. I think there's an artist hidden in the bottom of every single one of us. So often we avoid running water, and running water is a lot of fun.</p>
                </div>
            </section>

<!--            <button class="save_button bottom_button">Save Change</button>-->

        </div>
        <div id="wp_location_right_sidebar">
            <h2>Quick Start Instructions</h2>
            <h2>Documentation</h2>
        </div>
    </div>

</div>

<script type="text/javascript">


    jQuery(document).ready(function($){
        'use strict';

        jQuery('.wplcation_select2').select2();

        jQuery("#tab_content .tab_body").hide();
        jQuery("#tab_content .tab_body[data-id='dashboard']").show();

        jQuery("#tabs_menu .tabs .tab_item").unbind("click");
        jQuery("#tabs_menu .tabs .tab_item").bind("click", function () {

            jQuery("#tabs_menu .tabs .tab_item").removeClass('tab_item_active');
            jQuery(this).addClass('tab_item_active');

            jQuery("#tab_content .tab_body").hide();
            jQuery("#tab_content .tab_body[data-id='" + jQuery(this).data('target') + "']").show();
        });

    });

    jQuery(function() {
        jQuery('.wplc_accordion_title').click(function(j) {

            var dropDown = jQuery(this).closest('.wplc_accordion_card').find('.wplc_accordion_panel');
            jQuery(this).closest('.acc').find('.acc__panel').not(dropDown).slideUp();

            if (jQuery(this).hasClass('active')) {
                jQuery(this).removeClass('active');
            } else {
                jQuery(this).closest('.acc').find('.wplc_accordion_title.active').removeClass('active');
                jQuery(this).addClass('active');
            }

            dropDown.stop(false, true).slideToggle();
            j.preventDefault();
        });
    });


</script>