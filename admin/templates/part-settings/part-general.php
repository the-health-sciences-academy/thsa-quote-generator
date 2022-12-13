<div class="thsa_qg_email_settings">
        <h3><?php esc_html_e('Store', 'thsa-quote-generator'); ?></h3>
        <p>
            <label><?php esc_html_e('Checkout Page','thsa-quote-generator'); ?><br/>
            <select class="thsa_qg_settings_pages thsa_qg_select_woo_inline">
                <option></option>
                <?php if(isset($params['pages'])): 
                    $selected = null;
                    foreach($params['pages'] as $page):    

                        if(isset($params['settings']['checkout'])){
                            $selected = ($params['settings']['checkout'] == $page->ID)? "selected" : null;
                        }
                        
                ?>
                    <option value="<?php esc_attr_e($page->ID,'thsa-quote-generator'); ?>" <?php esc_html_e($selected,'thsa-quote-generator'); ?>><?php esc_html_e($page->post_title,'thsa-quote-generator'); ?></option>
                <?php endforeach; ?>
                <?php endif; ?>
            </select>
            </label>
        </p>
        <br/>
        <p>
            <input type="button" class="button button-primary button-large thsa_save_gen_ettings" value="<?php esc_html_e('Save Changes', 'thsa-quote-generator') ?>"> <span class="thsa_qg_response thsa_qg_response_general"><?php esc_html_e('Changes has been save','thsa-quote-generator'); ?></span>
        </p>
        
</div>