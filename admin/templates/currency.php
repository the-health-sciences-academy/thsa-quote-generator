<div class="thsa_qg_wrapper">
    <div class="thsa_qg_inner">
        <h3>Currency</h3>
        <div><div class="thsa_qg_notices thsa_qg_currency_notice no_margin"><span class="dashicons dashicons-info"></span> <?php esc_html_e('No currency plugin is detected') ?> <a href="javascript:void(0);" class="thsa_qg_see_supported">see supported plugins</a></div></div>
        <select class="thsa_qg_currency thsa_qg_select_woo" name="thsa_qg_currency">
            <option></option>
            <?php foreach($params['currency'] as $code => $currency): 
                $selected = ($params['current'] == $code)? 'selected' : null;
            ?>
                <option value="<?php esc_html_e($code); ?>" <?php echo $selected; ?>><?php esc_html_e($currency,'thsa-quote-generator'); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>