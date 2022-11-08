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

    thsa_qg_calculate();

    jQuery('.thsa_qg_payment_type').click(function(){
        if(jQuery(this).val() == 'upfront'){
            jQuery('.thsa_qg_plan_fields').hide();
        }else{
            jQuery('.thsa_qg_plan_fields').show();
        }
    });

    jQuery('.thsa_admin_qg_tab li').click(function(){
        var get_parent = jQuery(this).parent('ul');
        jQuery(get_parent).find('li').removeClass('active');
        jQuery(this).addClass('active');
        var get_target = jQuery(this).data('target');
        jQuery('.thsa_tab_content .thsa_tab_child').removeClass('active');
        jQuery(get_target).addClass('active');
       
        if(get_target == '.thsa_new_tab'){
            jQuery('.thsa_qg_customer_type').val(1);
        }else{
            jQuery('.thsa_qg_customer_type').val(2);
        }
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

        var source = jQuery(this).data('source');
        var parent_wrap = null;
        var colspan = 0;
        var selectall = null;
        var no_product_class = null;
        var no_item_text = null;
        
        switch(source){
            case 'products':
                parent_wrap = 'thsa_qg_selected_products';
                colspan = 3;
                selectall = 'thsa_qg_select_all';
                no_product_class = 'thsa_qg_no_product';
                no_item_text = labels_.no_products_added;
            break;
            case 'fee':
                parent_wrap = 'thsa_qg_added_fees';
                colspan = 4;
                selectall = 'thsa_qg_fee_select_all';
                no_product_class = 'thsa_qg_no_fee';
                no_item_text = labels_.no_fees_added;
            break;
        }

        if(confirm('Are you sure you want to remove selected item(s)')){
            jQuery('.'+parent_wrap+' tr').each(function(){
                var parent = jQuery(this);
                var ftd = jQuery(this).find('td:first-child');
                var selected = jQuery(ftd).find('input[type=checkbox]');
                if(jQuery(selected).is(':checked')){
                    jQuery(parent).remove();
                }
            });
        }
        jQuery('.'+selectall).prop('checked',false);

        if(jQuery('.'+parent_wrap+' tr').length == 0){
            var parent_tr = thsa_field_generator(
                {
                    type: 'tr',
                    attributes: [
                        {
                            attr: 'class',
                            value: no_product_class
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
                            value: colspan
                        }
                    ]
                }
            );

            var center = thsa_field_generator(
                {
                    type: 'center',
                    text: no_item_text
                }
            );

            jQuery(none_td).append(center);
            jQuery(parent_tr).append(none_td);
            jQuery('.'+parent_wrap).append(parent_tr);
        }

        thsa_qg_calculate();
    });

    jQuery('.thsa_qg_select_all').click(function(){
        var pro_status = jQuery(this).is(':checked');
        jQuery('.thsa_qg_selected_products tr').each(function(){
            var ftd = jQuery(this).find('td:first-child');
            jQuery(ftd).find('input[type=checkbox]').prop('checked', pro_status);
        });
    }); 

    jQuery('.thsa_qg_fee_select_all').click(function(){
        
        var is_checked = false;
        if(jQuery(this).is(':checked')){
            is_checked = true;
        }
        jQuery('.thsa_qg_added_fees tr').each(function(){
            var td = jQuery(this).find('td');
            var checkk = jQuery(td).find('input[type=checkbox]');
            if(is_checked){
                jQuery(checkk).prop('checked',true);   
            }else{
                jQuery(checkk).prop('checked',false);   
            }
        });
    });

    //add fee
    jQuery('.thsa_qg_add_fee').click(function(){

        //get name
        var name = jQuery('.thsa_qg_fee_name').val();
        var amount = jQuery('.thsa_qg_fee_amount').val();
        //var recur = jQuery('.thsa_qg_fee_recurring').val();

        if(!name || !amount)
            return;

       

        jQuery('.thsa_qg_no_fee').remove();

        var parent = jQuery('.thsa_qg_added_fees');
        var parent_tr = thsa_field_generator(
            {
                type: 'tr',
                attributes: [
                    {
                        attr: 'data-fee',
                        value: amount
                    }
                ]
            }
        );
        var td = thsa_field_generator(
            {
                type: 'td',

            }
        );
        var checkbox = thsa_field_generator(
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
        jQuery(td).append(checkbox);

        //generate hidden field
        var hidden_value = {
            fee_name: name,
            fee_amount: amount
        };
        var hidden_field = thsa_field_generator(
            {
                type: 'input',
                attributes: [
                    {
                        attr: 'name',
                        value: 'thsa_qg_added_fee[]'
                    },
                    {
                        attr: 'value',
                        value: JSON.stringify(hidden_value)
                    },
                    {
                        attr: 'type',
                        value: 'hidden'
                    }
                ]
            }
        );
        jQuery(td).append(hidden_field);
        
        var td_feename = thsa_field_generator(
            {
                type: 'td',
                text: name

            }
        );
        
        var td_amount = thsa_field_generator(
            {
                type: 'td',
                text: amount
            }
        );
       
        jQuery(parent_tr).append(td);
        jQuery(parent_tr).append(td_feename);
        jQuery(parent_tr).append(td_amount);
        
        jQuery(parent).append(parent_tr);

        //clear fields
        jQuery('.thsa_qg_fee_name').val('');
        jQuery('.thsa_qg_fee_amount').val('');

        thsa_qg_calculate('fee');
    });


    //fix amount on keyup
    jQuery('.thsa_qg_fix_amount').on('keyup', function(){
        thsa_qg_calculate('fixed');
    });
    jQuery('.thsa_qg_percent_amount').on('keyup', function(){
        thsa_qg_calculate('percent');
    });


    //plan
    jQuery('.thsa_qg_payment_type').change(function(){
        var getstatus = jQuery(this).val();
        if(getstatus == 'upfront'){
            jQuery('.thsa_qg_plan_summary').hide();
        }else{
            jQuery('.thsa_qg_term_number').val('');
            jQuery('.thsa_qg_plan_term').val('day');
            jQuery('.thsa_qg_plan_summary').show();
        }
        thsa_qg_calculate();
    });

    jQuery('.thsa_qg_term_number').on('keyup',function(){
        thsa_qg_calculate('term');
    });
    jQuery('.thsa_qg_plan_term').change(function(){
        thsa_qg_calculate('term');
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
                    },
                    {
                        attr: 'data-price-num',
                        value: data.price_number
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

        //generate hidden field
        var hidden_field = thsa_field_generator(
            {
                type: 'input',
                attributes: [
                    {
                        attr: 'name',
                        value: 'thsa_qg_added_product[]'
                    },
                    {
                        attr: 'value',
                        value: data.id
                    },
                    {
                        attr: 'type',
                        value: 'hidden'
                    }
                ]
            }
        );
        jQuery(td_option).append(hidden_field);

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

        thsa_qg_calculate('product');
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

//caculate numbers
function thsa_qg_calculate(source = null)
{
    //calculate products
    if(jQuery('.thsa_qg_selected_products tr').length > 0){
        //there is products lets calculate
        switch(source){
            case 'percent':
                get_set_total = thsa_qg_product_total();
                var percent = thsa_qg_percent_calculation(get_set_total);
                var fee = thsa_qg_fee_calculation();
    
                var type = jQuery('.thsa_qg_payment_type').val();
                if(type == 'upfront'){
                    get_set_total = (get_set_total - percent) + fee;
                }else{
                    get_set_total = (get_set_total - discount);
                    var term = thsa_qg_term_calculation(get_set_total);
                    if(term > 0){
                        get_set_total = term + fee;
                    }else{
                        get_set_total = get_set_total + fee;
                    }
                }
                break;
            case 'term':
            case 'product':
            case 'fixed':
            case 'fee':
            default:
                get_set_total = thsa_qg_product_total();
                var discount = thsa_qg_fixed_calculation(get_set_total);
                var fee = thsa_qg_fee_calculation();

                var type = jQuery('.thsa_qg_payment_type').val();
                if(type == 'upfront'){
                    get_set_total = (get_set_total - discount) + fee;
                }else{
                    get_set_total = (get_set_total - discount);
                    var term = thsa_qg_term_calculation(get_set_total);
                    if(term > 0){
                        get_set_total = term + fee;
                    }else{
                        get_set_total = get_set_total + fee;
                    }
                }
                break;
        }
        jQuery('.thsa_qg_total_field').val(thsa_qg_round_number(get_set_total));
        thsa_qg_update_label();
        
    }
}

function thsa_qg_product_total()
{
    var temp_product_total = 0;
    jQuery('.thsa_qg_selected_products tr').each(function(){
        var price = jQuery(this).data('price-num');
        price = (price)? parseFloat(price) : 0;
        temp_product_total += price;
    });
    return temp_product_total;
}

function thsa_qg_fixed_calculation(get_set_total = 0)
{
    if(get_set_total == 0)
        return 0;

    var get_dis_fixed = jQuery('.thsa_qg_fix_amount').val();
    get_dis_fixed = (get_dis_fixed)? get_dis_fixed : 0;
    get_dis_fixed = parseInt(get_dis_fixed);
    var temp_percent = get_dis_fixed / get_set_total * 100;
    if(temp_percent > 0){
        jQuery('.thsa_qg_percent_amount').val(thsa_qg_round_number(temp_percent));
    }else{
        jQuery('.thsa_qg_percent_amount').val('');
    }
    
    return get_dis_fixed;
}

function thsa_qg_percent_calculation(get_set_total = 0)
{
    if(get_set_total == 0)
        return 0;

    var get_dis_percent = jQuery('.thsa_qg_percent_amount').val(); 
    get_dis_percent = (get_dis_percent)? get_dis_percent : 0;
    get_dis_percent = parseFloat(get_dis_percent);   
    get_dis_percent = get_dis_percent / 100;
    var tem_am = get_set_total * get_dis_percent;
    if(tem_am > 0){
        jQuery('.thsa_qg_fix_amount').val(thsa_qg_round_number(tem_am));
    }else{
        jQuery('.thsa_qg_fix_amount').val('');
    }
    
    return tem_am;
}

function thsa_qg_fee_calculation()
{
    var total_fee = 0;
    jQuery('.thsa_qg_added_fees tr').each(function(){
        var get_fee = jQuery(this).data('fee');
        if(get_fee){
            get_fee = parseFloat(get_fee);
            total_fee = total_fee +  get_fee;
        }
    });
    return total_fee;
}

function thsa_qg_term_calculation(get_set_total = 0)
{
    if(get_set_total == 0)
        return 0;

    var term = jQuery('.thsa_qg_term_number').val();
    if(!term)
        return 0;

    term = parseInt(term);
    term = (term % 1 != 0)? 0 : term;

    if(term > 1){
        return get_set_total / term;
    }else{
        return 0;
    }

}

function thsa_qg_round_number(amount = 0)
{
    if(amount < 0)
        return 0;

    return Math.round(amount);
}

function thsa_qg_update_label()
{
   var get_set_total = thsa_qg_product_total();
   var fee = thsa_qg_fee_calculation();
   var discounts = jQuery('.thsa_qg_fix_amount').val();
   discounts = (discounts)? discounts : 0;
   jQuery('.thsa_qg_original_total_label').text(get_set_total);
   jQuery('.thsa_qg_total_savings_label').text(discounts);
   jQuery('.thsa_qg_total_fee_label').text(fee);

   //plan
   var type = jQuery('.thsa_qg_payment_type').val();
   if(type == 'plan'){
        var term = jQuery('.thsa_qg_term_number').val();
        var plan = jQuery('.thsa_qg_plan_term').val();
        var total = jQuery('.thsa_qg_total_field').val();

        if(term > 0){
            term = parseInt(term);
            discounts = parseFloat(discounts);
            var temp_total = get_set_total - discounts;
            var term_num = temp_total / term;
            term_num = thsa_qg_round_number(term_num);
            term_text = term_num+' per '+plan;
            jQuery('.thsa_qg_term_label').text(term_text);

            var topay = term_num * term;
            jQuery('.thsa_qg_topay_label').text(thsa_qg_round_number(topay));
        }else{
            jQuery('.thsa_qg_term_label').text('');
            jQuery('.thsa_qg_topay_label').text('');
        }
        
   }
   
}