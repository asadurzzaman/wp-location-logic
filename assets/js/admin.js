function twinkle_smtp_hide_all_views(){
    'use strict';

    jQuery("#twinkle_smtp_analytics").hide()
    jQuery("#twinkle_smtp_settings").hide()

}


jQuery(document).ready(function($){
    'use strict';

    jQuery('.tabs-nav a').click(function() {

        // Check for active
        jQuery('.tabs-nav li').removeClass('active');
        jQuery(this).parent().addClass('active');

        // Display active tab
        let currentTab = jQuery(this).attr('href');
        jQuery('.tabs-content div').hide();
        jQuery(currentTab).show();

        return false;
    });

});



