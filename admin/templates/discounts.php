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
                        <input type="button" class="button button-secondary thsa_qg_manage_plan_settings" value="<?php esc_html_e('Manage Subscription Settings','thsa-quote-generator'); ?>">
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
                            <label><input type="checkbox" name="thsa_qg_sub_is_virtual" value="Y"> <?php esc_html_e('Virtual','thsa-quote-generator'); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="thsa_qg_sub_is_dl" class="thsa_qg_dl_option" value="Y"> <?php esc_html_e('Downloadable','thsa-quote-generator'); ?>
                            </label>
                        </p>
                        <div>
                            <table border="0" cellspacing="0">
                                <tr>
                                    <td>
                                    <label><?php esc_html_e('Free Trial','thsa-quote-generator'); ?><br/>
                                        <input type="number" name="thsa_qg_sub_free_trial" class="thsa_qg_set_field" placeholder="0">
                                    </label>
                                    </td>
                                    <td>
                                    <label><?php esc_html_e(' ','thsa-quote-generator'); ?><br/>
                                        <select name="thsa_qg_sub_free_trial_duration">
                                            <option value="days"><?php esc_html_e('Days', 'thsa-quote-generator'); ?></option>
                                            <option value="weeks"><?php esc_html_e('Weeks', 'thsa-quote-generator'); ?></option>
                                            <option value="months"><?php esc_html_e('Months', 'thsa-quote-generator'); ?></option>
                                            <option value="years"><?php esc_html_e('Years', 'thsa-quote-generator'); ?></option>
                                        </select>
                                    </label>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <p>
                            <label><?php esc_html_e('Tax Status','thsa-quote-generator'); ?><br/>
                                <select class="thsa_qg_set_field" name="thsa_qg_sub_tax_status">
                                    <option value="taxable"><?php esc_html_e('Taxable', 'thsa-quote-generator'); ?></option>
                                    <option value="shipping"><?php esc_html_e('Shipping', 'thsa-quote-generator'); ?></option>
                                    <option value="none"><?php esc_html_e('None', 'thsa-quote-generator'); ?></option>
                                </select>
                            </label>
                        </p>

                        <p>
                            <label><?php esc_html_e('Tax Classes','thsa-quote-generator'); ?><br/>
                                <select class="thsa_qg_set_field" name="thsa_qg_sub_tax_class">
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
                                        <td><input type="text" class="widefat" name="thsa_qg_file_name[]" placeholder="<?php esc_html_e('File Name','thsa-quote-generator'); ?>"></td>
                                        <td><input type="text" name="thsa_qg_file_url[]" class="widefat thsa_upload_url_text" placeholder="<?php esc_html_e('File','thsa-quote-generator'); ?>" readonly></td>
                                        <td width="5%"><input type="button" class="button button-primary widefat thsa_qg_upload_file" value="<?php esc_html_e('Upload','thsa-quote-generator'); ?>"></td>
                                        <td width="2%"><span class="dashicons dashicons-dismiss thsa_remove_file_download"></span></td>
                                    </tr>
                                </tbody>
                                
                                <tfoot>
                                    <tr>
                                        <td colspan="4">
                                            <input type="button" class="button button-secondary thsa_qg_add_dl_file" value="<?php esc_html_e('Add File','thsa-quote-generator'); ?>">
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            

                            <p>
                                <label><?php esc_html_e('Download Limit','thsa-quote-generator'); ?><br/>
                                    <input type="number" class="thsa_qg_set_field" name="thsa_qg_sub_dl_limit" placeholder="<?php esc_html_e('Never','thsa-quote-generator'); ?>">
                                </label>
                                <i><?php esc_html_e('Leave blank for unlimited re-downloads.','thsa-quote-generator'); ?></i>
                            </p>
                            <p>
                                <label><?php esc_html_e('Download Expiry','thsa-quote-generator'); ?><br/>
                                    <input type="number" class="thsa_qg_set_field" name="thsa_qg_sub_dl_expiry" placeholder="Never">
                                </label>
                                <i><?php esc_html_e('Enter the number of days before a download link expires, or leave blank.','thsa-quote-generator'); ?></i>
                            </p>
                        </div>
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
                                    <select name="thsa_qg_term_every">
                                        <option value="1"><?php esc_html_e('every', 'thsa-quote-generator'); ?></option>
                                        <option value="2"><?php esc_html_e('every 2nd', 'thsa-quote-generator'); ?></option>
                                        <option value="3"><?php esc_html_e('every 3rd', 'thsa-quote-generator'); ?></option>
                                        <option value="4"><?php esc_html_e('every 4th', 'thsa-quote-generator'); ?></option>
                                        <option value="5"><?php esc_html_e('every 5th', 'thsa-quote-generator'); ?></option>
                                        <option value="6"><?php esc_html_e('every 6th', 'thsa-quote-generator'); ?></option>
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="thsa_qg_term_number" class="thsa_qg_term_number" value="<?php
                                        if(isset($params['data']['term_number'])){
                                            esc_html_e($params['data']['term_number'],'thsa-quote-generator');
                                        }
                                    ?>" placeholder="<?php esc_html_e('Term','thsa-quote-generator'); ?>">
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