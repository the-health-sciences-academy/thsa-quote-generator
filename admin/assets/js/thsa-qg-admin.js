/**
 * 
 * 
 * admin js
 * @since 1.2.0
 * @author thsa
 * 
 * 
 */

var labels_ = JSON.parse(thsaqgvars.labels);

jQuery(document).ready(function(){

    jQuery('.thsa_admin_qg_tab li').click(function(){
        var get_parent = jQuery(this).parent('ul');
        jQuery(get_parent).find('li').removeClass('active');
        jQuery(this).addClass('active');
        var get_target = jQuery(this).data('target');
        jQuery('.thsa_tab_content .thsa_tab_child').removeClass('active');
        jQuery(get_target).addClass('active');
    });

    jQuery('.thsa_qg_select_woo').selectWoo({
        width: '100%', 
        placeholder: labels_.select});
    jQuery('.thsa_qg_product_select').selectWoo({
        width: '100%',
        placeholder: labels_.select
    });

    jQuery('.thsa_qg_customer_select').selectWoo({ 
        placeholder: labels_.search_user,
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

    jQuery('.thsa_qg_customer_select').change(function(){
        var id = jQuery(this).val();
        jQuery.ajax({
            method: "POST",
            url: thsaqgvars.ajaxurl,
            data: { 
                action: thsaqgvars.customer_details, 
                id: id,
                nonce: thsaqgvars.nonce
            }
            }).done(function( response ) {
                if(response){
                    var details = JSON.parse(response);
                    jQuery('.thsa_qg_name span').text(details.fullname);
                    jQuery('.thsa_qg_email span').text(details.email_address);
                    jQuery('.thsa_qg_billing span').html(details.billing_address);
                }
            }
        );
    });


    //initialize the product select
    thsa_qg_load_select();

    jQuery('.thsa_qg_filter_option').change(function(){
        jQuery('.thsa_qg_product_select').val('').change();
    });

    jQuery('.thsa_qg_product_select').change(function(){
        var type = jQuery('.thsa_qg_filter_option').val();
       
        if(!jQuery(this).val())
            return;

        switch(type){
            case 'product':
                thsa_qg_gen_selected_product(this);   
                break;
            case 'category':
                thsa_qg_gen_selected_category(this, 'category');
                break;
            case 'tag':
                thsa_qg_gen_selected_category(this, 'tag');
                break;
        }

        setTimeout(function(){
            jQuery('.thsa_qg_product_select').val('').change();
        },5);
            
    });

    jQuery('.thsa_qg_remove_added_item').click(function(){
        if(confirm('Are you sure you want to remove selected item(s)')){
            jQuery('.thsa_qg_selected_products tr').each(function(){
                var parent = jQuery(this);
                var ftd = jQuery(this).find('td:first-child');
                var selected = jQuery(ftd).find('input[type=checkbox]');
                if(jQuery(selected).is(':checked')){
                    jQuery(parent).remove();
                }
            });
        }
        jQuery('.thsa_qg_select_all').prop('checked',false);

        if(jQuery('.thsa_qg_selected_products tr').length == 0){
            var parent_tr = thsa_field_generator(
                {
                    type: 'tr',
                    attributes: [
                        {
                            attr: 'class',
                            value: 'thsa_qg_no_product'
                        }
                    ]
                }
            );
            var none_td = thsa_field_generator(
                {
                    type: 'td',
                    attributes: [
                        {
                            attr: 'colspan',
                            value: 3
                        }
                    ]
                }
            );

            var center = thsa_field_generator(
                {
                    type: 'center',
                    text: labels_.no_products_added
                }
            );

            jQuery(none_td).append(center);
            jQuery(parent_tr).append(none_td);
            jQuery('.thsa_qg_selected_products').append(parent_tr);
        }
    });

    jQuery('.thsa_qg_select_all').click(function(){
        var pro_status = jQuery(this).is(':checked');
        jQuery('.thsa_qg_selected_products tr').each(function(){
            var ftd = jQuery(this).find('td:first-child');
            jQuery(ftd).find('input[type=checkbox]').prop('checked', pro_status);
        });
    });


});

function thsa_qg_load_select()
{

    jQuery('.thsa_qg_product_select').selectWoo({ 
        placeholder: labels_.enter_keywords,
        width: '100%',
        minimumInputLength: 1,
        ajax: {
            url: thsaqgvars.ajaxurl,
            data: function (params) {
                var get_filter = jQuery('.thsa_qg_filter_option').val();
                var query = {
                    search: params.term,
                    action: thsaqgvars.product_options,
                    nonce: thsaqgvars.nonce,
                    filter: get_filter
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
                                    text: parsed[x].text,
                                    price_html: parsed[x].price_html,
                                    price_number: parsed[x].price_number,
                                    price_regular_number: parsed[x].price_regular_number,
                                    price_sale_number: parsed[x].price_sale_number
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

}

function thsa_qg_gen_selected_product(obj)
{
        var data = jQuery(obj).selectWoo('data')[0];            
        thsa_generate_field_to(data);
        
        
}

function thsa_generate_field_to(data)
{

    //check first if the data is added
    var is_added = false;
    jQuery('.thsa_qg_selected_products tr').each(function(){
        if(data.id == jQuery(this).data('selected')){
            is_added = true;
        }
    });

    if(is_added){
        setTimeout(function(){
            jQuery('.thsa_qg_product_select').val('').change();
        },5);
        return;
    }

    jQuery('tr.thsa_qg_no_product').remove();

    var body = jQuery('.thsa_qg_selected_products');
        //data
        var parent_tr = thsa_field_generator(
            {
                type: 'tr',
                attributes: [
                    {
                        attr: 'class',
                        value: 'thsa_parent_tr'
                    },
                    {
                        attr: 'data-selected',
                        value: data.id
                    },
                    {
                        attr: 'data-selected-name',
                        value: data.text
                    }
                ]
            }
        );

        var td_option = thsa_field_generator(
            {
                type: 'td'
            }
        );

        var option_field = thsa_field_generator(
            {
                type: 'input',
                attributes: [
                    {
                        attr: 'type',
                        value: 'checkbox'
                    }
                ]
            }
        );
        jQuery(td_option).append(option_field);

        var td_option_name = thsa_field_generator(
            {
                type: 'td',
                text: data.text
            }
        );
        
        var td_option_price = thsa_field_generator(
            {
                type: 'td'
            }
        );

        jQuery(td_option_price).html(data.price_html);

        jQuery(parent_tr).append(td_option);
        jQuery(parent_tr).append(td_option_name);
        jQuery(parent_tr).append(td_option_price);
        jQuery(body).append(parent_tr);
}

function thsa_qg_gen_selected_category(obj, type = null){
    jQuery('.thsa_qg_product_select, .thsa_qg_filter_option').selectWoo("enable", false);
    
    var term = jQuery(obj).val();

    jQuery.ajax({
        method: "POST",
        url: thsaqgvars.ajaxurl,
        data: { 
            action: thsaqgvars.product_from_cat, 
            term: term,
            nonce: thsaqgvars.nonce,
            type: type
        }
        }).done(function( response ) {
            if(response){
                var details = JSON.parse(response);
                for(var x in details){
                    thsa_generate_field_to(details[x]);
                }
            }
            jQuery('.thsa_qg_product_select, .thsa_qg_filter_option').prop("disabled", false);
        }
    );

}