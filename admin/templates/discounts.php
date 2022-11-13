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