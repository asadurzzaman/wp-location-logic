jQuery(document).ready(function($){
    'use strict';

    jQuery(function(){
        jQuery(".btn-copy").on('click', function(){
            var ele = jQuery(this).closest('.category').clone(true);
            jQuery(this).closest('.category').after(ele);
        })
    })

});
