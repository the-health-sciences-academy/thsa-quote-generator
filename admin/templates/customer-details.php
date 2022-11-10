<div class="thsa_qg_wrapper">
    <div class="thsa_qg_inner">
        <h3><?php _e('Customer', 'thsa-quote-generator'); ?></h3>
        <ul class="thsa_admin_qg_tab">
            <li <?php echo ($params['tab'] == 'new')? 'class="active"' : null; ?> data-target=".thsa_new_tab"><?php _e('New Customer', 'thsa-quote-generator'); ?></li>
            <li <?php echo ($params['tab'] == 'exist')? 'class="active"' : null; ?> data-target=".thsa_existed_tab"><?php _e('Returning Customer', 'thsa-quote-generator'); ?></li>
        </ul>
        <input type="hidden" class="thsa_qg_customer_type" name="thsa_qg_customer_type" value="1">
        <div class="thsa_tab_content">
            <div class="thsa_tab_child thsa_new_tab <?php echo ($params['tab'] == 'new')? 'active"' : null; ?>">
                <table border="0" class="widefat">
                    <tr>
                        <td width="33%">
                            <input type="text" class="widefat" name="thsa_qg_customer_name" placeholder="<?php _e('First name', 'thsa-quote-generator'); ?>" value="<?php echo (isset($params['data']['firstname']))? $params['data']['firstname'] : null; ?>">
                        </td>
                        <td width="33%">
                            <input type="text" class="widefat" name="thsa_qg_customer_lastname" placeholder="<?php _e('Last name', 'thsa-quote-generator'); ?>" value="<?php echo (isset($params['data']['lastname']))? $params['data']['lastname'] : null; ?>">
                        </td>
                        <td width="33%">
                            <input type="email" class="widefat" name="thsa_qg_customer_email" placeholder="<?php _e('Email Address', 'thsa-quote-generator'); ?>" value="<?php echo (isset($params['data']['email']))? $params['data']['email'] : null; ?>">
                        </td>
                    </tr>
                </table>
            </div>
            <div class="thsa_tab_child thsa_existed_tab <?php echo ($params['tab'] == 'exist')? 'active"' : null; ?>">
                <select class="widefat thsa_qg_customer_select" name="thsa_qg_customer_select"></select>
                <div class="thsa_qg_user_details">
                    <table border="0" class="widefat">
                        <tr>
                            <td width="50%">
                                <p class="thsa_qg_name"><label><?php _e('Full name', 'thsa-quote-generator'); ?></label>
                                    <span><?php echo (isset($params['data']['fullname']))? $params['data']['fullname'] : null; ?></span>
                                </p>
                                <p class="thsa_qg_email"><label><?php _e('Email Address', 'thsa-quote-generator'); ?></label>
                                    <span><?php echo (isset($params['data']['email_address']))? $params['data']['email_address'] : null; ?></span>
                                </p>
                            </td>
                            <td width="50%" valign="top">
                                <p class="thsa_qg_billing"><label><?php _e('Billing Address', 'thsa-quote-generator'); ?></label>
                                    <span><?php echo (isset($params['data']['billing_address']))? $params['data']['billing_address'] : null; ?></span>
                                </p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>