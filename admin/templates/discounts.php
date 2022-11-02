<div class="thsa_qg_wrapper">
    <div class="thsa_qg_inner">
        <h3><?php _e('Discounts', 'thsa-quote-generator'); ?></h3>
        <div class="thsa_qg_table_con">
            <label class="main_label"><?php _e('Payment Type','thsa-quote-generator'); ?></label>
            <table border="0" class="thsa_qg_discount_table1">
                <tr>
                    <td>
                        <select class="thsa_qg_payment_type widefat" name="thsa_qg_payment_type">
                            <option value="upfront"><?php _e('Upfront Payment', 'thsa-quote-generator'); ?></option>
                            <option value="plan"><?php _e('Payment Plan', 'thsa-quote-generator'); ?></option>
                        </select>
                    </td>
                    <td>
                        <label><input type="checkbox" name="allow_payment_type_edit" checked value="Y"> <?php _e('not allow changing Payment Type', 'thsa-quote-generator'); ?></label>
                    </td>
                </tr>
            </table>
        </div>
        <div class="thsa_qg_table_con">
            <label class="main_label"><?php _e('Discount Value','thsa-quote-generator'); ?></label>
            <table border="0" class="thsa_qg_discount_table2">
                <tr>
                    <td valign="middle">
                        <input type="number" class="widefat thsa_qg_fix_amount" name="thsa_qg_fix_amount" placeholder="Fix discount">
                    </td>
                    <td valign="middle">
                        <label><input type="number" class="thsa_qg_percent_amount" name="thsa_qg_percent_amount" placeholder="Percentage discount"><span class="thsa_qg_tail_text">%</span></label>
                    </td>
                    <td valign="middle">
                        <table class="thsa_qg_wide thsa_qg_plan_fields" border="0">
                            <tr>
                                <td>
                                    <input type="number" name="thsa_qg_term_number" placeholder="Term">
                                </td>
                                <td>
                                    <select class="thsa_qg_plan_term" name="thsa_qg_plan_term">
                                        <option>Select</option>
                                        <option value="days"><?php _e('Day(s)','thsa-quote-generator'); ?></option>
                                        <option value="weeks"><?php _e('Week(s)','thsa-quote-generator'); ?></option>
                                        <option value="months"><?php _e('Month(s)','thsa-quote-generator'); ?></option>
                                        <option value="year"><?php _e('Year(s)','thsa-quote-generator'); ?></option>
                                    </select>
                                </td>
                                <td>
                                    <label><input type="checkbox" name="thsa_allow_term_edit" checked value="Y"> <?php _e('Do not allow term edit', 'thsa-quote-generator'); ?></label>
                                </td>
                            </tr>
                        </table>
                    </td>
     
                </tr>
            </table>
        </div>

    </div>
</div>