<div class="thsa_qg_wrapper">
<select class="widefat thsa_qg_currency thsa_qg_select_woo" name="thsa_qg_currency">
    <option></option>
    <?php foreach($params['currency'] as $code => $currency): 
        $selected = ($params['current'] == $code)? 'selected' : null;
    ?>
        <option value="<?php echo $code; ?>" <?php echo $selected; ?>><?php _e($currency,'thsa-quote-generator'); ?></option>
    <?php endforeach; ?>
</select>
</div>