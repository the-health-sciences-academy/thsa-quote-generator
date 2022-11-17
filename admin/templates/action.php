<div class="thsa_qg_wrapper">
    <div class="thsa_qg_inner thsa_qg_action">
        <?php if(isset($params['has'])): ?>
        <p>
            <a href="javascript:void(0);" data-id="<?php esc_html_e($params['id'],'thsa-quote-generator'); ?>" class="button button-primary widefat thsa_qg_send_email"><?php esc_html_e('Preview and send quotation','thsa-quote-generator'); ?></a>
        </p>
        <p>
            <a href="javascript:void(0);" class="button button-secondary widefat"><?php esc_html_e('Manage Email Content','thsa-quote-generator'); ?></a>
        </p>
        <?php else: ?>
            <p><center><?php echo esc_html_e('No action is available', 'thsa-quote-generator'); ?></center></p>
        <?php endif; ?>
    </div>
</div>
<div class="thsa_qg_preview_email">
    <div class="thsa_qg_preview_email_content"><span class="thsa_qg_loader"><?php esc_html_e('Please wait...','thsa-quote-generator'); ?></span>
        <div class="thsa_qg_preview_email_content_get"></div>
        <div class="thsa_qg_preview_email_content_footer">
            <input type="button" data-id="<?php esc_html_e($params['id'],'thsa-quote-generator'); ?>" class="button button-primary" id="thsa_qg_send_email_last" value="<?php esc_html_e('Send','thsa-quote-generator'); ?>"> <input type="button" class="button button-secondary" id="thsa_qg_close_preview" value="<?php esc_html_e('Close','thsa-quote-generator'); ?>">
        </div>
    </div>
</div>