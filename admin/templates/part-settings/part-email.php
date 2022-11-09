<div class="thsa_qg_email_settings">
    <div class="thsa_qg_email_content">
        <p>
            <label>
                <?php _e('From Email','thsa_quote_generator'); ?><br/>
                <input type="email" class="thsa_email_set_field" placeholder="Email Address" value="<?php echo $params['email']; ?>">
            </label>
        </p>
        <p>
            <label>
                <?php _e('Email Title','thsa_quote_generator'); ?><br/>
                <input type="text" class="thsa_email_set_field" placeholder="Quotation Email Title" value="<?php echo $params['title']; ?>">
            </label>
        </p>
        <br/>
        <div>
            <?php
                $content = $params['message'];
                $args  = ['media_buttons' => true, 'editor_height' => 400 ];
                wp_editor( $content, 'thsaqgemailcontent', $args ); 
            ?>
            <ul>
                <li><?php _e($params['shortcodes'][0].' - Customer Name', 'thsa_quote_generator'); ?></li>
                <li><?php _e($params['shortcodes'][1].' - Quotation Breakdown', 'thsa_quote_generator'); ?></li>
            </ul>
        </div>
        <br/>
        <p>
            <input type="button" class="button button-primary button-large" value="<?php _e('Save','thsa_quote_generator'); ?>">
            <input type="button" class="button button-secondary button-large" value="<?php _e('Preview','thsa_quote_generator'); ?>">
        </p>
    </div>
</div>