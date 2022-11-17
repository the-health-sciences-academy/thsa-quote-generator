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
        <h3><?php esc_html_e('Amounts', 'thsa-quote-generator') ?></h3>
        <?php 
            $off = null;
            $up = null;
            $down = null;
            if(isset($params['settings']['round'])){
                switch($params['settings']['round']){
                    case 'off':
                        $off = 'checked';
                        break;
                    case 'up':
                        $up = 'checked';
                        break;
                    case 'down':
                        $down = 'checked';
                        break;
                    default:
                        $off = 'checked';
                        break;
                }
            }
        ?>
        <p>
            <label>
                <input type="radio" name="thsa_qg_round_option" class="thsa_qg_round_option" value="off" <?php esc_html_e($off,'thsa-quote-generator'); ?>> <?php esc_html_e('Round off', 'thsa-quote-generator') ?>
            </label>
        </p>
        <p>
            <label>
                <input type="radio" name="thsa_qg_round_option" class="thsa_qg_round_option" value="up" <?php esc_html_e($up,'thsa-quote-generator'); ?>> <?php esc_html_e('Round up', 'thsa-quote-generator') ?>
            </label>
        </p>
        <p>
            <label>
                <input type="radio" name="thsa_qg_round_option" class="thsa_qg_round_option" value="down" <?php esc_html_e($down,'thsa-quote-generator'); ?>> <?php esc_html_e('Round down', 'thsa-quote-generator') ?>
            </label>
        </p>
        
        <?php 
            $decimal = null;
            if(isset($params['settings']['decimal'])){
                $decimal = $params['settings']['decimal'];
            }
        ?>
        <p>
            <label>
                <input type="number" class="thsa_qg_decimal_set" placeholder="0" min="0" max="5" value="<?php esc_html_e($decimal,'thsa-quote-generator') ?>"> <?php esc_html_e('Number in decimal', 'thsa-quote-generator') ?>
            </label>
        </p>
        <br/>
        <p>
            <input type="button" class="button button-primary button-large thsa_save_gen_ettings" value="<?php esc_html_e('Save', 'thsa-quote-generator') ?>"> <span class="thsa_qg_response thsa_qg_response_general"><?php esc_html_e('Changes has been save','thsa-quote-generator'); ?></span>
        </p>
        
</div>