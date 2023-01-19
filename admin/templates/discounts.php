<div class="thsa_qg_wrapper">
    <div class="thsa_qg_inner">
        <h3><?php esc_html_e('Discounts', 'thsa-quote-generator'); ?></h3>
        <div class="thsa_qg_table_con">
            
        <div><div class="thsa_qg_notices thsa_qg_discount_notice no_margin"><span class="dashicons dashicons-info"></span> <?php esc_html_e('No subscription plugin is detected') ?> <a href="javascript:void(0);" class="thsa_qg_see_supported">see supported plugins</a></div></div>

            <label class="main_label"><?php esc_html_e('Payment Type','thsa-quote-generator'); ?></label>
            <table border="0" class="thsa_qg_discount_table1">
                <?php $payment_type = (isset($params['data']['payment_type']))? $params['data']['payment_type'] : null; ?>
                <tr>
                    <td>
                        <select class="thsa_qg_payment_type widefat" name="thsa_qg_payment_type">
                            <option value="upfront" <?php echo ($payment_type == 'upfront')? 'selected' : null; ?>><?php esc_html_e('Upfront Payment', 'thsa-quote-generator'); ?></option>
                            <?php $this->pro_features( $payment_type, 'payment-plan'); ?>
                        </select>
                    </td>

                    <?php $this->pro_features( $payment_type, 'payment-plan-settings'); ?>

                    <td>
                        <?php 
                            $selected = 'checked';
                            if(isset($params['data']['allow_payment_type_edit'])){
                                $selected = ($params['data']['allow_payment_type_edit'] == 'Y')? 'checked' : null;
                            }
                        ?>
                        <!-- this feature seems not needed -->
                        <!-- <label><input type="checkbox" name="allow_payment_type_edit" <?php //echo $selected; ?> value="Y"> <?php //esc_html_e('not allow changing Payment Type', 'thsa-quote-generator'); ?></label> -->
                    </td>
                </tr>
            </table>
        </div>

        <?php $this->pro_features( $params['data'], 'payment-plan-settings-area' ); ?>

        <div class="thsa_qg_table_con">
            <label class="main_label"><?php esc_attr_e('Discount Value','thsa-quote-generator'); ?></label>
            <table border="0" class="thsa_qg_discount_table2">
                <tr>
                    <td valign="middle">
                        <input type="text" class="widefat thsa_qg_fix_amount right_text" name="thsa_qg_fix_amount" value="<?php
                            if(isset($params['data']['fixed_amount_discount'])){
                                echo esc_attr( $params['data']['fixed_amount_discount'] );
                            }
                        ?>" placeholder="Fix discount">
                    </td>
                    <td valign="middle">
                        <label><input type="text" class="thsa_qg_percent_amount" name="thsa_qg_percent_amount" placeholder="<?php esc_attr_e( 'Percentage discount', 'thsa-quote-generator' ) ?>"><span class="thsa_qg_tail_text">%</span></label>
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
                                            echo esc_attr( $params['data']['term_number'] );
                                        }
                                    ?>" placeholder="<?php esc_attr_e('Term','thsa-quote-generator'); ?>">
                                </td>
                                
                                <td>
                                    <?php 
                                        $plan_type = ( isset( $params['data']['term_plan_type'] ) )? $params['data']['term_plan_type'] : null;
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
                                        if( isset( $params['data']['allow_term_edit'] ) ){
                                            $allow_status = ( $params['data']['allow_term_edit'] == 'Y' )? 'checked' : null;
                                        }
                                    ?>
                                    <!-- this feature seems not needed -->
                                    <!-- <label><input type="checkbox" name="thsa_allow_term_edit" <?php //echo $allow_status; ?> value="Y"> <?php //esc_html_e('Do not allow term edit', 'thsa-quote-generator'); ?></label> -->
                                </td>
                            </tr>
                        </table>
                    </td>
     
                </tr>
            </table>
        </div>

    </div>
</div>