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
});