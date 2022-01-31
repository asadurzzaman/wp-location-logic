function twinkle_smtp_analytics_init(){
    'use strict';

    twinkle_smtp_hide_all_views();
    jQuery("#twinkle_smtp_analytics").show()
    jQuery("#twinkle_smtp_analytics .loader").show()



    var post_data = {
        'action': 'twinkle_smtp_get_smtp_data',
    };

    jQuery.ajax({
        url: ajaxurl,
        type: "POST",
        data: post_data,
        success: function (data) {
            jQuery("#twinkle_smtp_analytics .loader").hide()


            var obj = JSON.parse(data);

            if(obj.status == "true"){
                alert(obj.host)
            }



        }
    })

}