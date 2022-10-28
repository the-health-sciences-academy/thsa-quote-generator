<div class="thsa_qg_wrapper">
    <div class="thsa_qg_inner">
        <h3><?php _e('Discounts', 'thsa-quote-generator'); ?></h3>
        <table border="0" class="thsa_qg_discount_table1">
            <tr>
                <td valign="center">
                    <label><?php _e('Payment Type','thsa-quote-generator'); ?>
                        <select class="thsa_qg_select_woo thsa_qg_payment_type">
                            <option></option>
                            <option value="upfront"><?php _e('Upfront Payment', 'thsa-quote-generator'); ?></option>
                            <option value="plan"><?php _e('Payment Plan', 'thsa-quote-generator'); ?></option>
                        </select>
                    </label>
                </td>
                <td valign="bottom">
                    <label><input type="checkbox" name="thsa_no_allow_changing_pay_type" value="Y"> not allow changing Payment Type</label>
                </td>
            </tr>
        </table>
        <br/>
        <table border="0" class="thsa_qg_discount_table1">
            <tr>
                <td valign="center">
                    <label><?php _e('Discount Value','thsa-quote-generator'); ?><br/>
                        <input type="number" class="widefat" name="thsa_qg_fix_amount" placeholder="Fix discount">
                    </label>
                </td>
                <td valign="bottom">
                    <input type="number" class="widefat" name="thsa_qg_percent_amount" placeholder="Percentage discount">
                </td>
            </tr>
        </table>

    </div>
</div>