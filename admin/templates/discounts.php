<div class="thsa_qg_wrapper">
    <div class="thsa_qg_inner">
        <h3><?php esc_html_e('Discounts', 'thsa-quote-generator'); ?></h3>
        <div class="thsa_qg_table_con">
            <label class="main_label"><?php esc_html_e('Payment Type','thsa-quote-generator'); ?></label>
            <table border="0" class="thsa_qg_discount_table1">
                <?php $payment_type = (isset($params['data']['payment_type']))? $params['data']['payment_type'] : null; ?>
                <tr>
                    <td>
                        <select class="thsa_qg_payment_type widefat" name="thsa_qg_payment_type">
                            <option value="upfront" <?php echo ($payment_type == 'upfront')? 'selected' : null; ?>><?php esc_html_e('Upfront Payment', 'thsa-quote-generator'); ?></option>
                            <option value="plan" <?php echo ($payment_type == 'plan')? 'selected' : null; ?>><?php esc_html_e('Payment Plan', 'thsa-quote-generator'); ?></option>
                        </select>
                    </td>
                    <td class="thsa_qg_plan_manage_button">
                        <input type="button" class="button button-secondary" value="<?php esc_html_e('Manage Subscription Settings','thsa-quote-generator'); ?>">
                    </td>
                    <td>
                        <?php 
                            $selected = 'checked';
                            if(isset($params['data']['allow_payment_type_edit'])){
                                $selected = ($params['data']['allow_payment_type_edit'] == 'Y')? 'checked' : null;
                            }
                        ?>
                        <label><input type="checkbox" name="allow_payment_type_edit" <?php echo $selected; ?> value="Y"> <?php esc_html_e('not allow changing Payment Type', 'thsa-quote-generator'); ?></label>
                    </td>
                </tr>
            </table>
        </div>

        <div class="thsa_qg_plan_settings">

                        <p>
                            <label><input type="checkbox"> <?php esc_html_e('Virtual','thsa-quote-generator'); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" class="thsa_qg_dl_option"> <?php esc_html_e('Downloadable','thsa-quote-generator'); ?>
                            </label>
                        </p>
                        <p>
                            <label><?php esc_html_e('Period Interval','thsa-quote-generator'); ?><br/>
                                <input type="number" class="thsa_qg_set_field" placeholder="1">
                            </label>
                        </p>
                        <p>
                            <label><?php esc_html_e('Tax Status','thsa-quote-generator'); ?><br/>
                                <select class="thsa_qg_set_field">
                                    <option value="taxable"><?php esc_html_e('Taxable', 'thsa-quote-generator'); ?></option>
                                    <option value="shipping"><?php esc_html_e('Shipping', 'thsa-quote-generator'); ?></option>
                                    <option value="none"><?php esc_html_e('None', 'thsa-quote-generator'); ?></option>
                                </select>
                            </label>
                        </p>

                        <p>
                            <label><?php esc_html_e('Tax Classes','thsa-quote-generator'); ?><br/>
                                <select class="thsa_qg_set_field">
                                    <?php if(isset($params['taxes'])): 
                                        foreach($params['taxes'] as $class):    
                                    ?>
                                        <option value="<?php esc_html_e(strtolower(str_replace(' ','-',$class))); ?>"><?php esc_html_e($class, 'thsa-quote-generator'); ?></option>
                                    <?php 
                                        endforeach;
                                    endif; ?>
                                </select>
                            </label>
                        </p>

                        <div class="thsa_qg_event_action thsa_qg_event_action_downloadable">

                           
                            <table class="thsa_qg_downloadable_files wp-list-table widefat striped table-view-list" border="0">
                                <thead>
                                    <tr>
                                        <th colspan="4"><?php esc_html_e('Downloadable Files','thsa-quote-generator'); ?></th>
                                    </tr>
                                </thead>
                                <tbody class="thsa_qg_dl_file_con">
                                    <tr>
                                        <td><input type="text" class="widefat" placeholder="<?php esc_html_e('File Name','thsa-quote-generator'); ?>"></td>
                                        <td><input type="text" class="widefat thsa_upload_url_text" placeholder="<?php esc_html_e('File','thsa-quote-generator'); ?>" readonly></td>
                                        <td width="5%"><input type="button" class="button button-primary widefat" value="<?php esc_html_e('Upload','thsa-quote-generator'); ?>"></td>
                                        <td width="2%"><span class="dashicons dashicons-dismiss thsa_remove_file_download"></span></td>
                                    </tr>
                                </tbody>
                                
                                <tfoot>
                                    <tr>
                                        <td colspan="4">
                                            <input type="button" class="button button-secondary thsa_qg_add_dl_file" value="Add File">
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            

                            <p>
                                <label><?php esc_html_e('Download Limit','thsa-quote-generator'); ?><br/>
                                    <input type="number" class="thsa_qg_set_field" placeholder="Never">
                                </label>
                                <i>Leave blank for unlimited re-downloads.</i>
                            </p>
                            <p>
                                <label><?php esc_html_e('Download Expiry','thsa-quote-generator'); ?><br/>
                                    <input type="number" class="thsa_qg_set_field" placeholder="Never">
                                </label>
                                <i>Enter the number of days before a download link expires, or leave blank.</i>
                            </p>
                        </div>

                        

                        //update_post_meta( $new_product_id, '_tax_status', 'taxable' );//If needed
		update_post_meta( $new_product_id, '_manage_stock', 'no' );
		update_post_meta( $new_product_id, '_sold_individually', 'yes' );
		update_post_meta( $new_product_id, '_virtual', 'yes' );
		update_post_meta( $new_product_id, '_downloadable', 'no' );
		update_post_meta( $new_product_id, '_download_limit', "-1" );
		update_post_meta( $new_product_id, '_download_expiry', "-1" );
		update_post_meta( $new_product_id, '_stock', NULL );
		update_post_meta( $new_product_id, '_stock_status', 'instock' );
		update_post_meta( $new_product_id, 'woo_limit_one_select_dropdown', "1" );
		update_post_meta( $new_product_id, 'woo_limit_one_time_dropdown', 'all' );
		update_post_meta( $new_product_id, '_dependency_type', '3' );
		update_post_meta( $new_product_id, '_dependency_selection_type', 'new_product_ids' );
		//update_post_meta( $new_product_id, '_subscription_limit', 'active' );
		update_post_meta( $new_product_id, '_subscription_limit', 'no' );
		update_post_meta( $new_product_id, '_subscription_one_time_shipping', 'no' );


        Array
(
    [_edit_lock] => Array
        (
            [0] => 1669300707:1
        )

    [_edit_last] => Array
        (
            [0] => 1
        )

    [_regular_price] => Array
        (
            [0] => 1000
        )

    [total_sales] => Array
        (
            [0] => 0
        )

    [_tax_status] => Array
        (
            [0] => taxable
        )

    [_tax_class] => Array
        (
            [0] => 
        )

    [_manage_stock] => Array
        (
            [0] => no
        )

    [_backorders] => Array
        (
            [0] => no
        )

    [_sold_individually] => Array
        (
            [0] => yes
        )

    [_virtual] => Array
        (
            [0] => yes
        )

    [_downloadable] => Array
        (
            [0] => yes
        )

    [_download_limit] => Array
        (
            [0] => -1
        )

    [_download_expiry] => Array
        (
            [0] => -1
        )

    [_stock] => Array
        (
            [0] => 
        )

    [_stock_status] => Array
        (
            [0] => instock
        )

    [_wc_average_rating] => Array
        (
            [0] => 0
        )

    [_wc_review_count] => Array
        (
            [0] => 0
        )

    [_downloadable_files] => Array
        (
            [0] => a:1:{s:36:"e8ad2168-858b-4965-95df-efe5a6545e8e";a:4:{s:2:"id";s:36:"e8ad2168-858b-4965-95df-efe5a6545e8e";s:4:"name";s:6:"Test 1";s:4:"file";s:66:"http://localhost/thsaapp/wp-content/uploads/2022/10/hoodie-2-1.jpg";s:7:"enabled";b:1;}}
        )

    [_product_version] => Array
        (
            [0] => 7.0.0
        )

    [_price] => Array
        (
            [0] => 1000
        )

    [_subscription_payment_sync_date] => Array
        (
            [0] => 0
        )

    [_subscription_price] => Array
        (
            [0] => 1000
        )

    [_sale_price] => Array
        (
            [0] => 
        )

    [_sale_price_dates_from] => Array
        (
            [0] => 
        )

    [_sale_price_dates_to] => Array
        (
            [0] => 
        )

    [_subscription_trial_length] => Array
        (
            [0] => 5
        )

    [_subscription_sign_up_fee] => Array
        (
            [0] => 100
        )

    [_subscription_period] => Array
        (
            [0] => month
        )

    [_subscription_period_interval] => Array
        (
            [0] => 1
        )

    [_subscription_length] => Array
        (
            [0] => 12
        )

    [_subscription_trial_period] => Array
        (
            [0] => day
        )

    [_subscription_limit] => Array
        (
            [0] => no
        )

    [_subscription_one_time_shipping] => Array
        (
            [0] => no
        )

)
        </div>

        <div class="thsa_qg_table_con">
            <label class="main_label"><?php _e('Discount Value','thsa-quote-generator'); ?></label>
            <table border="0" class="thsa_qg_discount_table2">
                <tr>
                    <td valign="middle">
                        <input type="number" class="widefat thsa_qg_fix_amount" name="thsa_qg_fix_amount" value="<?php
                            if(isset($params['data']['fixed_amount_discount'])){
                                esc_html_e($params['data']['fixed_amount_discount'],'thsa-quote-generator');
                            }
                        ?>" placeholder="Fix discount">
                    </td>
                    <td valign="middle">
                        <label><input type="number" class="thsa_qg_percent_amount" name="thsa_qg_percent_amount" value="<?php 
                            if(isset($params['data']['fixed_amount_discount'])){
                                esc_html_e($params['data']['fixed_amount_discount'],'thsa-quote-generator');
                            }
                        ?>" placeholder="Percentage discount"><span class="thsa_qg_tail_text">%</span></label>
                    </td>
                    <td valign="middle">
                        <table class="thsa_qg_wide thsa_qg_plan_fields" border="0" <?php echo ($payment_type == 'plan')? "style=\"display:block;\"" : null; ?>>
                            <tr>
                                <td>
                                    <input type="number" name="thsa_qg_term_number" class="thsa_qg_term_number" value="<?php
                                        if(isset($params['data']['term_number'])){
                                            esc_html_e($params['data']['term_number'],'thsa-quote-generator');
                                        }
                                    ?>" placeholder="Term">
                                </td>
                                <td>
                                    <?php 
                                        $plan_type = (isset($params['data']['term_plan_type']))? $params['data']['term_plan_type'] : null;
                                    ?>
                                    <select class="thsa_qg_plan_term" name="thsa_qg_plan_term">
                                        <option value="day" <?php echo ($plan_type == 'day')? 'selected' : null; ?>><?php esc_html_e('Day(s)','thsa-quote-generator'); ?></option>
                                        <option value="week" <?php echo ($plan_type == 'week')? 'selected' : null; ?>><?php esc_html_e('Week(s)','thsa-quote-generator'); ?></option>
                                        <option value="month" <?php echo ($plan_type == 'month')? 'selected' : null; ?>><?php esc_html_e('Month(s)','thsa-quote-generator'); ?></option>
                                        <option value="year" <?php echo ($plan_type == 'year')? 'selected' : null; ?>><?php esc_html_e('Year(s)','thsa-quote-generator'); ?></option>
                                    </select>
                                </td>
                                <td>
                                    <?php 
                                        $allow_status = 'checked';
                                        if(isset($params['data']['allow_term_edit'])){
                                            $allow_status = ($params['data']['allow_term_edit'] == 'Y')? 'checked' : null;
                                        }
                                    ?>
                                    <label><input type="checkbox" name="thsa_allow_term_edit" <?php echo $allow_status; ?> value="Y"> <?php esc_html_e('Do not allow term edit', 'thsa-quote-generator'); ?></label>
                                </td>
                            </tr>
                        </table>
                    </td>
     
                </tr>
            </table>
        </div>

    </div>
</div>