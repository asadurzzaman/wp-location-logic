<?php

$UserData = get_userdata(1);
$UserName = $UserData->display_name;

?>

<div id="wp_location_main_wrapper" >

    <?php include WP_LOCATION_LOGIC_PATH . "backend/templates/views/dashboard_header.php"; ?>

    <div id="wp_location_full_container">

        <?php include WP_LOCATION_LOGIC_PATH . "backend/templates/views/dashboard_tab.php"; ?>

        <div id="tab_content" class="wp_location_main_container">

            <section class="tabs-content">

                <div class="tab_body" data-id="dashboard">
                    <?php include WP_LOCATION_LOGIC_PATH . "backend/templates/views/dashboard.php"; ?>
                </div>

                <div class="tab_body" data-id="all_conditions">
                    <?php include WP_LOCATION_LOGIC_PATH . "backend/templates/views/all_conditions.php"; ?>

                </div>

                <div class="tab_body" data-id="all_logic_blocks">
                    <h3>All Logic Blocks</h3>
                    <?php include WP_LOCATION_LOGIC_PATH . "backend/templates/views/all_logic_blocks.php"; ?>
                </div>
                <div class="tab_body" data-id="banner_bars">
                    <h3>Logic Banner</h3>
                    <p>Just go out and talk to a tree. Make friends with it. For the lack of a better word I call them hangy downs. There's nothing wrong with having a tree as a friend. Maybe there's a happy little waterfall happening over here. I think there's an artist hidden in the bottom of every single one of us. So often we avoid running water, and running water is a lot of fun.</p>
                </div>
                <div class="tab_body" data-id="popup">
                    <h3>Logic Popup</h3>
                    <p>Just go out and talk to a tree. Make friends with it. For the lack of a better word I call them hangy downs. There's nothing wrong with having a tree as a friend. Maybe there's a happy little waterfall happening over here. I think there's an artist hidden in the bottom of every single one of us. So often we avoid running water, and running water is a lot of fun.</p>
                </div>
                <div class="tab_body" data-id="coupon_code">
                    <h3>Coupon Code</h3>
                    <p>Just go out and talk to a tree. Make friends with it. For the lack of a better word I call them hangy downs. There's nothing wrong with having a tree as a friend. Maybe there's a happy little waterfall happening over here. I think there's an artist hidden in the bottom of every single one of us. So often we avoid running water, and running water is a lot of fun.</p>
                </div>
                <div class="tab_body" data-id="logic_goal">
                    <h3>Logic Goal</h3>
                    <p>Just go out and talk to a tree. Make friends with it. For the lack of a better word I call them hangy downs. There's nothing wrong with having a tree as a friend. Maybe there's a happy little waterfall happening over here. I think there's an artist hidden in the bottom of every single one of us. So often we avoid running water, and running water is a lot of fun.</p>
                </div>
                <div class="tab_body" data-id="redirects">
                    <h3>Redirects</h3>
                    <p>Just go out and talk to a tree. Make friends with it. For the lack of a better word I call them hangy downs. There's nothing wrong with having a tree as a friend. Maybe there's a happy little waterfall happening over here. I think there's an artist hidden in the bottom of every single one of us. So often we avoid running water, and running water is a lot of fun.</p>
                </div>
                <div class="tab_body" data-id="integrations">
                    <h3>Integrations</h3>
                    <p>Just go out and talk to a tree. Make friends with it. For the lack of a better word I call them hangy downs. There's nothing wrong with having a tree as a friend. Maybe there's a happy little waterfall happening over here. I think there's an artist hidden in the bottom of every single one of us. So often we avoid running water, and running water is a lot of fun.</p>
                </div>
                <div class="tab_body" data-id="woocommerce">
                    <h3>Woocommerce</h3>
                </div>
                <div class="tab_body" data-id="setting">
                    <h3>Setting</h3>
                    <p>Just go out and talk to a tree. Make friends with it. For the lack of a better word I call them hangy downs. There's nothing wrong with having a tree as a friend. Maybe there's a happy little waterfall happening over here. I think there's an artist hidden in the bottom of every single one of us. So often we avoid running water, and running water is a lot of fun.</p>
                </div>

            </section>

<!--            <button class="save_button bottom_button">Save Change</button>-->

        </div>
        <?php include WP_LOCATION_LOGIC_PATH . "backend/templates/views/dashboard_sidebar.php"; ?>

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



</script>