<div class="thsa_qg_wrapper">
    <div class="thsa_qg_inner">
        <h3><?php esc_html_e('Customer', 'thsa-quote-generator'); ?></h3>
        <ul class="thsa_admin_qg_tab">
            <li <?php echo ($params['tab'] == 'new')? "class=\"active\"" : null; ?> data-target=".thsa_new_tab"><?php esc_html_e('New Customer', 'thsa-quote-generator'); ?></li>
            <li <?php echo ($params['tab'] == 'exist')? "class=\"active\"" : null; ?> data-target=".thsa_existed_tab"><?php esc_html_e('Returning Customer', 'thsa-quote-generator'); ?></li>
        </ul>
        <input type="hidden" class="thsa_qg_customer_type" name="thsa_qg_customer_type" value="1">
        <div class="thsa_tab_content">
            <div class="thsa_tab_child thsa_new_tab <?php echo ($params['tab'] == 'new')? "active" : null; ?>">
                <table border="0" class="widefat">
                    <tr>
                        <td width="33%">
                            <input type="text" class="widefat" name="thsa_qg_customer_name" placeholder="<?php esc_html_e('First name', 'thsa-quote-generator'); ?>" value="<?php 
                                if(isset($params['data']['firstname'])){
                                    esc_html_e($params['data']['firstname'],'thsa-quote-generator');
                                }
                            ?>">
                        </td>
                        <td width="33%">
                            <input type="text" class="widefat" name="thsa_qg_customer_lastname" placeholder="<?php esc_html_e('Last name', 'thsa-quote-generator'); ?>" value="<?php 
                                if(isset($params['data']['lastname'])){
                                    esc_html_e($params['data']['lastname'],'thsa-quote-generator');
                                }
                            ?>">
                        </td>
                        <td width="33%">
                            <input type="email" class="widefat" name="thsa_qg_customer_email" placeholder="<?php esc_html_e('Email Address', 'thsa-quote-generator'); ?>" value="<?php
                                if(isset($params['data']['email'])){
                                    esc_html_e($params['data']['email'],'thsa-quote-generator');
                                }
                            ?>">
                        </td>
                    </tr>
                </table>
            </div>
            <div class="thsa_tab_child thsa_existed_tab <?php echo ($params['tab'] == 'exist')? "active" : null; ?>">
                <select class="widefat thsa_qg_customer_select" name="thsa_qg_customer_select"></select>
                <div class="thsa_qg_user_details">
                    <table border="0" class="widefat">
                        <tr>
                            <td width="50%">
                                <p class="thsa_qg_name"><label><?php esc_html_e('Full name', 'thsa-quote-generator'); ?></label>
                                    <span><?php 
                                        if(isset($params['data']['fullname'])){
                                            esc_html_e($params['data']['fullname'],'thsa-quote-generator');
                                        }
                                    ?></span>
                                </p>
                                <p class="thsa_qg_email"><label><?php esc_html_e('Email Address', 'thsa-quote-generator'); ?></label>
                                    <span><?php
                                        if(isset($params['data']['email_address'])){
                                            esc_html_e($params['data']['email_address'],'thsa-quote-generator');
                                        }
                                    ?></span>
                                </p>
                            </td>
                            <td width="50%" valign="top">
                                <p class="thsa_qg_billing"><label><?php esc_html_e('Billing Address', 'thsa-quote-generator'); ?></label>
                                    <span><?php
                                        if(isset($params['data']['billing_address'])){
                                            esc_html_e($params['data']['email_address'],'thsa-billing_address-generator');
                                        }
                                    ?></span>
                                </p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>