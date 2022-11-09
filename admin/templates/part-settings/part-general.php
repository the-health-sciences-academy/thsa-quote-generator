<div class="thsa_qg_email_settings">
        <h3><?php _e('Amounts', 'thsa_quote_generator') ?></h3>
        <p>
            <label>
                <input type="radio" name="thsa_qg_round_option[]" checked> <?php _e('Round off', 'thsa_quote_generator') ?>
            </label>
        </p>
        <p>
            <label>
                <input type="radio" name="thsa_qg_round_option[]"> <?php _e('Round up', 'thsa_quote_generator') ?>
            </label>
        </p>
        <p>
            <label>
                <input type="radio" name="thsa_qg_round_option[]"> <?php _e('Round down', 'thsa_quote_generator') ?>
            </label>
        </p>

        <p>
            <label>
                <input type="number" placeholder="0" min="0" max="5"> <?php _e('Number in decimal', 'thsa_quote_generator') ?>
            </label>
        </p>
        <br/>
        <p>
            <input type="button" class="button button-primary" value="<?php _e('Save', 'thsa_quote_generator') ?>"> 
        </p>
        
</div>