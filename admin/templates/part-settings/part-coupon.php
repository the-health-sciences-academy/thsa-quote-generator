<div class="thsa_qg_email_settings">
        <?php 
            print_r($params['settings']);
        ?>
        <h3><?php esc_html_e('Coupon', 'thsa-quote-generator') ?></h3>
        <p>
            <?php $status = (isset($params['settings']['individual_usage']) == 'yes')? 'checked' : null; ?>
            <label><input type="checkbox" class="thsa_qg_settings_individual_use" <?php esc_html_e($status,'thsa-quote-generation'); ?>> <?php esc_html_e('Individual Use', 'thsa-quote-generator'); ?></label>
        </p>
        <p>
            <label><?php esc_html_e('Products', 'thsa-quote-generator'); ?><br/>
                <select class="thsa_qg_settings_coupon_pids thsa_qg_select_woo_inline_half" multiple>
                    <?php foreach($params['products'] as $product): ?>
                        <option value="<?php esc_html_e($product['id'],'thsa-quote-generator'); ?>"><?php esc_html_e($product['title'],'thsa-quote-generator'); ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
        </p>
        <p>
            <label><?php esc_html_e('Exclude Products', 'thsa-quote-generator'); ?><br/>
                <select class="thsa_qg_settings_coupon_exclude_pids thsa_qg_select_woo_inline_half" multiple>
                    <?php foreach($params['products'] as $product): ?>
                        <option value="<?php esc_html_e($product['id'],'thsa-quote-generator'); ?>"><?php esc_html_e($product['title'],'thsa-quote-generator'); ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
        </p>
        <p>
            <label><?php esc_html_e('Usage Limit','thsa-quote-generator'); ?><br/>
                <input type="number" class="thsa_email_set_field thsa_qg_settings_usage_limit" placeholder="1">
            </label>
        </p>
        <p>
            <label><?php esc_html_e('Expiry Date','thsa-quote-generator'); ?><br/>
                <input type="date" class="thsa_email_set_field thsa_qg_settings_expiry_date">
            </label>
        </p>
        <p>
            <label><input type="checkbox" class="thsa_qg_settings_apply_before_tax" checked> <?php esc_html_e('Apply Before Tax', 'thsa-quote-generator'); ?></label>
        </p>
        <p>
            <label><input type="checkbox" class="thsa_qg_settings_free_shipping"> <?php esc_html_e('Free Shipping', 'thsa-quote-generator'); ?></label>
        </p>
        <br/>
        <p>
            <input type="submit" class="button button-primary thsa_qg_settings_save_coupon" value="Save"> 
            <span class="thsa_qg_response thsa_qg_coupon_message"><?php esc_html_e('Changes has been save','thsa-quote-generator'); ?></span>
        </p>
</div>