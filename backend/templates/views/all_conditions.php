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

<script>
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