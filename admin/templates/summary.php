<div class="thsa_qg_wrapper">
    <div class="thsa_qg_inner">
        <div class="thsa_qg_table_con">
            <div class="thsa_qg_summary_box">
                <h3><?php _e('Summary', 'thsa-quote-generator'); ?></h3>
                <div class="thsa_qg_summary_box_numbers">
                    <p><?php _e('Original Total Amount:','thsa-quote-generator'); ?> <span class="thsa_qg_original_total_label">0</span></p>
                    <p><?php _e('Total Savings:','thsa-quote-generator'); ?> <span class="thsa_qg_total_savings_label">0</span></p>
                    <p><?php _e('Total Fee:','thsa-quote-generator'); ?> <span class="thsa_qg_total_fee_label">0</span></p>
                </div>
                <div class="thsa_qg_summary_box_numbers thsa_qg_plan_summary" <?php echo ($params['data']['payment_type'] == 'plan')? 'style="display:block"' : null;  ?>>
                    <p><?php _e('Terms:','thsa-quote-generator)'); ?> <span class="thsa_qg_term_label"></span></p>
                    <p><?php _e('To Pay:','thsa-quote-generator)'); ?> <span class="thsa_qg_topay_label"></span></p>
                </div>  
                <div class="thsa_qg_total_field_wrap">
                        Total Today
                        <input type="number" class="thsa_qg_total_field widefat" placeholder="0">
                    </div>
            </div>
        </div>
    </div>
</div>