<div class="thsa_qg_email_settings">
        <h3><?php _e('Store', 'thsa-quote-generator'); ?></h3>
        <p>
            <label>Checkout Page<br/>
            <select></select>
            </label>
        </p>
        <br/>
        <h3><?php _e('Amounts', 'thsa-quote-generator') ?></h3>
        <p>
            <label>
                <input type="radio" name="thsa_qg_round_option[]" checked> <?php _e('Round off', 'thsa-quote-generator') ?>
            </label>
        </p>
        <p>
            <label>
                <input type="radio" name="thsa_qg_round_option[]"> <?php _e('Round up', 'thsa-quote-generator') ?>
            </label>
        </p>
        <p>
            <label>
                <input type="radio" name="thsa_qg_round_option[]"> <?php _e('Round down', 'thsa-quote-generator') ?>
            </label>
        </p>

        <p>
            <label>
                <input type="number" placeholder="0" min="0" max="5"> <?php _e('Number in decimal', 'thsa-quote-generator') ?>
            </label>
        </p>
        <br/>
        <p>
            <input type="button" class="button button-primary" value="<?php _e('Save', 'thsa-quote-generator') ?>"> 
        </p>
        
</div>