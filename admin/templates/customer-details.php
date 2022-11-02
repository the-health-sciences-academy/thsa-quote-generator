<div class="thsa_qg_wrapper">
    <div class="thsa_qg_inner">
        <h3><?php _e('Customer', 'thsa-quote-generator'); ?></h3>
        <ul class="thsa_admin_qg_tab">
            <li class="active" data-target=".thsa_new_tab"><?php _e('New Customer', 'thsa-quote-generator'); ?></li>
            <li data-target=".thsa_existed_tab"><?php _e('Returning Customer', 'thsa-quote-generator'); ?></li>
        </ul>
        <input type="hidden" class="thsa_qg_customer_type" name="thsa_qg_customer_type" value="1">
        <div class="thsa_tab_content">
            <div class="thsa_tab_child thsa_new_tab active">
                <table border="0" class="widefat">
                    <tr>
                        <td width="33%">
                            <input type="text" class="widefat" name="thsa_qg_customer_name" placeholder="<?php _e('First name', 'thsa-quote-generator'); ?>">
                        </td>
                        <td width="33%">
                            <input type="text" class="widefat" name="thsa_qg_customer_lastname" placeholder="<?php _e('Last name', 'thsa-quote-generator'); ?>">
                        </td>
                        <td width="33%">
                            <input type="email" class="widefat" name="thsa_qg_customer_email" placeholder="<?php _e('Email Address', 'thsa-quote-generator'); ?>">
                        </td>
                    </tr>
                </table>
            </div>
            <div class="thsa_tab_child thsa_existed_tab">
                <select class="widefat thsa_qg_customer_select" name="thsa_qg_customer_select"></select>
                <div class="thsa_qg_user_details">
                    <table border="0" class="widefat">
                        <tr>
                            <td width="50%">
                                <p class="thsa_qg_name"><label><?php _e('Full name', 'thsa-quote-generator'); ?></label>
                                    <span></span>
                                </p>
                                <p class="thsa_qg_email"><label><?php _e('Email Address', 'thsa-quote-generator'); ?></label>
                                    <span></span>
                                </p>
                            </td>
                            <td width="50%" valign="top">
                                <p class="thsa_qg_billing"><label><?php _e('Billing Address', 'thsa-quote-generator'); ?></label>
                                    <span></span>
                                </p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>