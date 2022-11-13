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
    jQuery('.thsa_qg_settings_tab li').click(function(){
        var get_target = jQuery(this).data('target');
        jQuery('.thsa_qg_settings_tab li').removeClass('active');
        jQuery(this).addClass('active');
        jQuery('.thsa_settings_content .thsa_qg_tab_content').removeClass('active');
        jQuery('.thsa_settings_content .'+get_target).addClass('active');
    });

    jQuery('.thsa_save_gen_ettings').click(function(){
        jQuery(this).val('Saving...');
        jQuery(this).prop('disabled', true);

        var checkout_page = jQuery('.thsa_qg_settings_pages').val();
        var round = null;
        jQuery('.thsa_qg_round_option').each(function(){
            if(jQuery(this).is(':checked')){
                round = jQuery(this).val();
            }
        });
        var decimal = jQuery('.thsa_qg_decimal_set').val();
        jQuery.ajax({
            method: "POST",
            url: thsaqgvars.ajaxurl,
            data: { 
                action: thsaqgvars.save_general, 
                type: 'general',
                checkout: checkout_page,
                round: round,
                decimal: decimal,
                nonce: thsaqgvars.nonce
            }
            }).done(function( response ) {
                if(response){
                    response = JSON.parse(response);
                    if(response.status == 'success'){
                        jQuery('.thsa_qg_response').show();
                        jQuery('.thsa_save_gen_ettings').val('Save');
                        jQuery('.thsa_save_gen_ettings').prop('disabled', false);
                        setTimeout(function(){
                            jQuery('.thsa_qg_response').hide();
                        }, 10000);
                    }
                }
            }
        );
    });
});