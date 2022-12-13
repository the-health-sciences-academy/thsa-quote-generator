/**
 * 
 * 
 * settings js
 * @since 1.2.0
 * @author thsa
 * 
 * 
 */
jQuery(document).ready(function(){
    Coloris({
        el: '.coloris',
        theme: 'large',
        themeMode: 'light' // light, dark, auto,
    });

    jQuery('.thsa_qg_settings_tab li').click(function(){
        var get_target = jQuery(this).data('target');
        jQuery('.thsa_qg_settings_tab li').removeClass('active');
        jQuery(this).addClass('active');
        jQuery('.thsa_settings_content .thsa_qg_tab_content').removeClass('active');
        jQuery('.thsa_settings_content .'+get_target).addClass('active');
    });

    jQuery('.thsa_save_gen_ettings').click(function(){
        jQuery(this).val(labels_.saving);
        jQuery(this).prop('disabled', true);

        var checkout_page = jQuery('.thsa_qg_settings_pages').val();
        jQuery.ajax({
            method: "POST",
            url: thsaqgvars.ajaxurl,
            data: { 
                action: thsaqgvars.save_settings, 
                type: 'general',
                checkout: checkout_page,
                nonce: thsaqgvars.nonce
            }
            }).done(function( response ) {
                if(response){
                    response = JSON.parse(response);
                    if(response.status == 'success'){
                        jQuery('.thsa_qg_response_general').show();
                        jQuery('.thsa_save_gen_ettings').val('Save');
                        jQuery('.thsa_save_gen_ettings').prop('disabled', false);
                        setTimeout(function(){
                            jQuery('.thsa_qg_response_general').hide();
                        }, 10000);
                    }
                }
            }
        );
    });

    jQuery('.thsa_qg_save_email_settings').click(function(){

        jQuery(this).val('Saving...');
        jQuery(this).prop('disabled', true);

        var from_email = jQuery('.thsa_email_set_email').val();
        var title = jQuery('.thsa_email_set_title').val();
        var content = tinymce.get('thsaqgemailcontent').getContent({format: 'raw'});

        jQuery.ajax({
            method: "POST",
            url: thsaqgvars.ajaxurl,
            data: { 
                action: thsaqgvars.save_settings, 
                type: 'email',
                from_email: from_email,
                title: title,
                content: content,
                nonce: thsaqgvars.nonce
            }
            }).done(function( response ) {
                if(response){
                    response = JSON.parse(response);
                    if(response.status == 'success'){
                        jQuery('.thsa_qg_response_email').show();
                        jQuery('.thsa_qg_save_email_settings').val('Save');
                        jQuery('.thsa_qg_save_email_settings').prop('disabled', false);
                        setTimeout(function(){
                            jQuery('.thsa_qg_response_email').hide();
                        }, 10000);
                    }
                }
            }
        );
        
    });

    jQuery('.thsa_qg_save_email_preview').click(function(){
        jQuery('.thsa_qg_email_preview_wrap').show();
        jQuery.ajax({
            method: "POST",
            url: thsaqgvars.ajaxurl,
            data: { 
                action: thsaqgvars.preview_email,
                nonce: thsaqgvars.nonce
            }
            }).done(function( response ) {
                console.log(response);
                if(response){
                    response = JSON.parse(response);
                    if(response.status == 'success'){
                        jQuery('.thsa_qg_email_prev_content').html(response.message);
                    }
                }
            }
        );
    });

    jQuery('.thsa_qg_settings_save_coupon').click(function(){
        jQuery(this).val('Saving...');
        jQuery(this).prop('disabled', true);

        var individual_usage = (jQuery('.thsa_qg_settings_individual_use').is(':checked'))? 'yes' : null;
        var product_ids = (jQuery('.thsa_qg_settings_coupon_pids').val())? jQuery('.thsa_qg_settings_coupon_pids').val() : null;
        var exclude_ids = (jQuery('.thsa_qg_settings_coupon_exclude_pids').val())? jQuery('.thsa_qg_settings_coupon_exclude_pids').val() : null;
        var usage_limit = (jQuery('.thsa_qg_settings_usage_limit').val())? jQuery('.thsa_qg_settings_usage_limit').val() : null;
        var expiry_date = (jQuery('.thsa_qg_settings_expiry_date').val())? jQuery('.thsa_qg_settings_expiry_date').val() : null;
        var before_tax = (jQuery('.thsa_qg_settings_apply_before_tax').is(':checked'))? 'yes' : null;
        var free_shipping = (jQuery('.thsa_qg_settings_free_shipping').is(':checked'))? 'yes' : null;

        jQuery.ajax({
            method: "POST",
            url: thsaqgvars.ajaxurl,
            data: { 
                action: thsaqgvars.save_settings, 
                type: 'coupon',
                individual_usage: individual_usage,
                product_ids: (product_ids)? product_ids.join(',') : null,
                exclude_ids: (exclude_ids)? exclude_ids.join(',') : null,
                usage_limit: usage_limit,
                expiry_date: expiry_date,
                before_tax: before_tax,
                free_shipping: free_shipping,
                nonce: thsaqgvars.nonce
            }
            }).done(function( response ) {
                if(response){
                    response = JSON.parse(response);
                    if(response.status == 'success'){
                        jQuery('.thsa_qg_coupon_message').show();
                        jQuery('.thsa_qg_settings_save_coupon').val('Save');
                        jQuery('.thsa_qg_settings_save_coupon').prop('disabled', false);
                        setTimeout(function(){
                            jQuery('.thsa_qg_coupon_message').hide();
                        }, 10000);
                    }
                }
            }
        );
    });

    jQuery('.thsa_qg_plates_el').click( function(){

        var plate = jQuery(this).find('.thsa_qg_plate').data('plate');
        var plate_cap = jQuery(this).find('.thsa_qg_plate').data('plate-cap');
        jQuery('.thsa_quote_settings_content').find('.thsa_qg_plates_el').each(function(){
            jQuery(this).removeClass('active');
        });
        jQuery(this).addClass('active');

        jQuery('.thsa_qg_plate_name').val(plate_cap);
        jQuery('.thsa_qg_text_color').val(thsaqg_plates[plate].color);
        jQuery('.thsa_qg_text_color').closest('.clr-field').css('color',thsaqg_plates[plate].color);
        jQuery('.thsa_qg_background_color').val(thsaqg_plates[plate].background_color);
        jQuery('.thsa_qg_background_color').closest('.clr-field').css('color',thsaqg_plates[plate].background_color);
        jQuery('.thsa_qg_header_text_color').val(thsaqg_plates[plate].title.color);
        jQuery('.thsa_qg_header_text_color').closest('.clr-field').css('color',thsaqg_plates[plate].title.color);
        jQuery('.thsa_qg_header_color').val(thsaqg_plates[plate].title.background_color);
        jQuery('.thsa_qg_header_color').closest('.clr-field').css('color',thsaqg_plates[plate].title.background_color);
        jQuery('.thsa_qg_border_color').val(thsaqg_plates[plate].border_color);
        jQuery('.thsa_qg_border_color').closest('.clr-field').css('color',thsaqg_plates[plate].border_color);
        jQuery('.thsa_qg_total_font_color').val(thsaqg_plates[plate].total.color);
        jQuery('.thsa_qg_total_font_color').closest('.clr-field').css('color',thsaqg_plates[plate].total.color);
        
    } );

    jQuery('.thsa_qg_save_plate').click(function(){
        jQuery(this).prop('disabled', true);
        jQuery(this).val('Saving...');

        var thsa_qg_plate_name = jQuery('.thsa_qg_plate_name').val();
        var thsa_qg_text_color = jQuery('.thsa_qg_text_color').val();
        var thsa_qg_header_text_color = jQuery('.thsa_qg_header_text_color').val();
        var thsa_qg_header_color = jQuery('.thsa_qg_header_color').val();
        var thsa_qg_border_color = jQuery('.thsa_qg_border_color').val();
        var thsa_qg_total_font_color = jQuery('.thsa_qg_total_font_color').val();
        var thsa_qg_total_row_color = jQuery('.thsa_qg_total_row_color').val();
        var thsa_qg_total_font_size = jQuery('.thsa_qg_total_font_size').val();
        var thsa_qg_background_color = jQuery('.thsa_qg_background_color').val();


        jQuery.ajax({
            method: "POST",
            url: thsaqgvars.ajaxurl,
            data: { 
                action: thsaqgvars.save_settings,
                nonce: thsaqgvars.nonce,
                thsa_qg_plate_name: thsa_qg_plate_name,
                thsa_qg_background_color: thsa_qg_background_color,
                thsa_qg_text_color: thsa_qg_text_color,
                thsa_qg_header_text_color: thsa_qg_header_text_color,
                thsa_qg_header_color: thsa_qg_header_color,
                thsa_qg_border_color: thsa_qg_border_color,
                thsa_qg_total_font_color: thsa_qg_total_font_color,
                thsa_qg_total_row_color: thsa_qg_total_row_color,
                thsa_qg_total_font_size: thsa_qg_total_font_size,
                type: 'plates'
            }
            }).done(function( response ) {
                if(response){
                    response = JSON.parse(response);
                    if(response.status == 'success'){
                        
                    }
                }
                jQuery('.thsa_qg_save_plate').prop('disabled', false);
                jQuery('.thsa_qg_save_plate').val('Save');
            }
        );
    });

    jQuery('.thsa_qg_restore_default').click(function(){
        jQuery(this).prop('disabled', true);
        jQuery(this).val('Restoring...');

        jQuery.ajax({
            method: "POST",
            url: thsaqgvars.ajaxurl,
            data: { 
                action: thsaqgvars.save_settings,
                nonce: thsaqgvars.nonce,
                type: 'restore_plate'
            }
            }).done(function( response ) {
                if(response){
                    response = JSON.parse(response);
                    if(response.status == 'success'){
                        
                    }
                }
                jQuery('.thsa_qg_restore_default').prop('disabled', false);
                jQuery('.thsa_qg_restore_default').val('Restore Default');
            }
        );
    });

});


