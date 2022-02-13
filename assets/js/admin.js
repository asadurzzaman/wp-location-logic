function twinkle_smtp_hide_all_views(){
    'use strict';

    jQuery("#twinkle_smtp_analytics").hide();
    jQuery("#twinkle_smtp_settings").hide();

    section_5_tab_init();

}


// jQuery(document).ready(function($){
//     'use strict';
//
//     jQuery('.tabs-nav a').click(function() {
//
//         // Check for active
//         jQuery('.tabs-nav li').removeClass('active');
//         jQuery(this).parent().addClass('active');
//
//         // Display active tab
//         let currentTab = jQuery(this).attr('href');
//         jQuery('.tabs-content div').hide();
//         jQuery(currentTab).show();
//
//         return false;
//     });
//
// });


// function section_5_tab_init(){
//     'use strict';
//     jQuery(".tab_body").hide();
//     jQuery(".tab_body[data-id='tab_lms']").show();
//     jQuery( "ul.tabs .tab_item").unbind( "click" );
//     jQuery( "ul.tabs .tab_item" ).bind( "click", function() {
//         jQuery( "ul.tabs .tab_item").removeClass('active');
//         jQuery(this).addClass('active');
//
//         jQuery(".tab_body").hide();
//         jQuery(".tab_body[data-id='"+jQuery(this).data('target')+"']").show();
//     });
//
// <<<<<<< HEAD
// }
// =======
// });


