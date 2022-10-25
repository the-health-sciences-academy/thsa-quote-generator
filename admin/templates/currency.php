<div class="thsa_qg_wrapper">
<select class="widefat thsa_qg_currency thsa_qg_select_woo">
    <option></option>
    <?php foreach($params['currency'] as $currency): ?>
        <option value="<?php _e($currency,'thsa-quote-generator'); ?>"><?php _e($currency,'thsa-quote-generator'); ?></option>
    <?php endforeach; ?>
</select>
</div>