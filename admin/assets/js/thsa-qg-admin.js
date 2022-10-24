/**
 * 
 * 
 * admin js
 * @since 1.2.0
 * 
 * 
 */

jQuery(document).ready(function(){

    jQuery('.thsa_admin_qg_tab li').click(function(){
        var get_parent = jQuery(this).parent('ul');
        jQuery(get_parent).find('li').removeClass('active');
        jQuery(this).addClass('active');
        var get_target = jQuery(this).data('target');
        jQuery('.thsa_tab_content .thsa_tab_child').removeClass('active');
        jQuery(get_target).addClass('active');
    });


    jQuery('.thsa_qg_customer_select').selectWoo({ 
        placeholder: 'Search User',
        width: '100%',
        minimumInputLength: 1,
        ajax: {
            url: thsaqgvars.ajaxurl,
            data: function (params) {
                var query = {
                    search: params.term,
                    action: thsaqgvars.customer_action,
                    nonce: thsaqgvars.nonce
                }
                return query;
            },
            processResults: function( data ) {
              
				var options = [];
				if ( data ) {
			
					var parsed = JSON.parse(data);
                    for(var x in parsed){
                        options.push(
                            {
                                id: parsed[x].id,
                                text: parsed[x].id + ' - ' + parsed[x].text
                            }
                        );
                    } 
				
				}
				return {
					results: options
				};
			},
			cache: true
        }
    });
});