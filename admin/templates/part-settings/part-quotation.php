<div class="thsa_quote_settings_content">
    
    <table cellpadding="0" cellspacing="0" class="thsa_qg_appe_table" width="100%">
        <tr>
            <td width="15%" valign="top">
                <h2><?php esc_html_e('Appearance', 'thsa-quote-generator'); ?></h2>
                <p>
                    <label>
                        <?php esc_html_e('Style Name', 'thsa-quote-generator'); ?><br/>
                        <input class="widefat thsa_qg_plate_name" type="text">
                    </label>
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Text color', 'thsa-quote-generator'); ?><br/>
                        <input class="widefat thsa_qg_text_color coloris" type="text">
                    </label>
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Header text color', 'thsa-quote-generator'); ?><br/>
                        <input class="widefat thsa_qg_header_text_color coloris" type="text">
                    </label>
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Header background color', 'thsa-quote-generator'); ?><br/>
                        <input class="widefat thsa_qg_header_color coloris" type="text">
                    </label>
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Item row(even) background color', 'thsa-quote-generator'); ?><br/>
                        <input class="widefat thsa_qg_item_row_even coloris" type="text">
                    </label>
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Item row(odd) background color', 'thsa-quote-generator'); ?><br/>
                        <input class="widefat thsa_qg_item_row_odd coloris" type="text">
                    </label>
                </p>

                <p>
                    <label>
                        <?php esc_html_e('Border color', 'thsa-quote-generator'); ?><br/>
                        <input class="widefat thsa_qg_border_color coloris" type="text">
                    </label>
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Total row background color', 'thsa-quote-generator'); ?><br/>
                        <input class="widefat thsa_qg_total_row_color coloris" type="text">
                    </label>
                </p>

                <p>
                    <label>
                        <?php esc_html_e('Total font color', 'thsa-quote-generator'); ?><br/>
                        <input class="widefat thsa_qg_total_font_color coloris" type="text">
                    </label>
                </p>

                <p>
                    <label>
                        <?php esc_html_e('Total font size', 'thsa-quote-generator'); ?><br/>
                        <input class="widefat thsa_qg_total_font_size" type="number" placeholder="default">
                    </label>
                </p>

                <p><br/>
                    <input type="button" class="button button-primary thsa_qg_save_plate" value="<?php esc_html_e('Save Changes', 'thsa-quote-generator') ?>">&nbsp;
                    <input type="button" class="button button-secondary thsa_qg_restore_default" value="<?php esc_html_e('Restore Default', 'thsa-quote-generator') ?>">
                </p>
            </td>
            <td width="85%" valign="top">
                <div class="thsa_qg_color_plates">
                    <?php 
                        $plates = ['blackcurrant' ,'honeydew','pear', 'banana', 'strawberry','blueberry','poncan','lychees','grapes'];
                    ?>

                    <table border="0" cellpadding="10" cellspacing="0" width="100%">
                        
                        <tr>
                            <?php foreach($plates as $index => $plate): echo ($index % 3 == 0)? '</tr><tr>' : null; ?>
                            <td width="33.3%">
                                <div class="thsa_qg_plates_el">
                                    <span class="title"><?php esc_html_e(ucfirst($plate), 'thsa-quote-generator'); ?></span>
                                <table cellspacing="0" cellpadding="0" data-plate-cap="<?php esc_attr_e(ucfirst($plate)); ?>" data-plate="<?php esc_attr_e($plate); ?>" class="thsa_qg_plate_corporate thsa_qg_plate thsa_qg_plate_<?php esc_attr_e($plate); ?>" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Content 1</td>
                                        <td>0.00</td>
                                        <td>1</td>
                                        <td>0.00</td>
                                    </tr>
                                    <tr>
                                        <td>Content 2</td>
                                        <td>0.00</td>
                                        <td>1</td>
                                        <td>0.00</td>
                                    </tr>
                                    <tr>
                                        <td>Content 3</td>
                                        <td>0.00</td>
                                        <td>1</td>
                                        <td>0.00</td>
                                    </tr>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                   
                                        <td colspan="2"></td>
                                        <td>Subtotal</td>
                                        <td>0.00</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td>Discount</td>
                                        <td>-0.00</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td>Total Today</td>
                                        <td>0.00</td>
                                    </tr>
                                    </tfoot>
                                </table>
                                    
                                </div>
                            </td>
                            <?php 
                                
                            endforeach; ?>
                        </tr>
                        
                    </table>
                </div>
            </td>
        </tr>
    </table>
</div>