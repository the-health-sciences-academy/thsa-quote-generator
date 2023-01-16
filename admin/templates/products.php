<div class="thsa_qg_wrapper">
    <div class="thsa_qg_inner">
        <h3><?php esc_html_e('Products', 'thsa-quote-generator'); ?></h3>
        <div class="thsa_product_options">        
            <table class="widefat no-border" border="0">
                <tr>
                    <td width="20%">
                        <label><?php esc_html_e('Search By','thsa-quote-generator') ?>
                        <select class="widefat thsa_qg_select_woo thsa_qg_filter_option">
                            <option value="product"><?php esc_html_e('Products','thsa-quote-generator') ?></option>
                            <option value="category"><?php esc_html_e('Category','thsa-quote-generator') ?></option>
                            <option value="tag"><?php esc_html_e('Tag','thsa-quote-generator') ?></option>
                        </select>
                        </label>
                    </td>
                    <td width="80%">
                        <label>Select Product
                        <select class="widefat thsa_qg_product_select"></select>
                        </label>
                    </td>
                    <td width="10%">
                        <input type="button" class="button button-primary button-medium thsa_qg_add_product" value="<?php esc_html_e('Add','thsa-quote-generator'); ?>">
                    </td>
                </tr>
            </table>

            <table class="widefat wp-list-table widefat fixed striped table-view-list thsa_qg_product_table">
                <thead>
                    <tr>
                        <th width="2%"><input type="checkbox" class="thsa_qg_select_all"></th>
                        <th width="63%"><b><?php esc_html_e('Product','thsa-quote-generator'); ?></b></th>
                        <th width="15%"><b><?php esc_html_e('Price','thsa-quote-generator'); ?></b></th>
                        <th width="10%"><b><?php esc_html_e('Quantity','thsa-quote-generator'); ?></b></th>
                        <th width="10%"><b><?php esc_html_e('Amount','thsa-quote-generator'); ?></b></th>
                    </tr>
                </thead>
                <tbody class="thsa_qg_selected_products">
                    <?php 
                        if(empty($params['products'])):
                    ?>
                        <tr class="thsa_qg_no_product">
                            <td colspan="5"><center><?php esc_html_e('No products added', 'thsa-quote-generator'); ?></center></td>
                        </tr>
                    <?php
                        else:
                            foreach($params['products'] as $product):    
                                ?>
                                    <tr class="thsa_parent_tr" data-selected="<?php echo esc_html_e( $product['id'] ,'thsa-quote-generator'); ?>" data-selected-name="<?php esc_html_e($product['text'],'thsa-quote-generator'); ?>" data-price-num="<?php esc_html_e( $product['price_number'] ,'thsa-quote-generator'); ?>">
                                        <td>
                                            <input type="checkbox">
                                            <input name="thsa_qg_added_product[]" value="<?php esc_html_e( $product['id'] ,'thsa-quote-generatot'); ?>" type="hidden">
                                        </td>
                                        <td><?php esc_html_e( $product['text'] ,'thsa-quote-generator'); ?></td>
                                        <td>
                                            <?php _e( $product['price_html'] ,'thsa-quote-generator'); ?>
                                        </td>
                                        <td>
                                            <input name="thsa_qg_added_product_qty[]" class="thsa_qg_added_product_qty" value="<?php esc_html_e( $product['qty'] ,'thsa-quote-generator'); ?>" type="number">
                                        </td>
                                        <td class="thsa_qg_product_amount" data-amount="<?php esc_attr_e($product['amount_num']); ?>"><?php esc_html_e( $product['amount'] ,'thsa-quote-generator'); ?></td>
                                    </tr>
                                <?php 
                            endforeach;  
                        endif;
                    ?>
                </tbody>
            </table>
            <input type="button" class="button button-secondary thsa_qg_remove_added_item" data-source="products" value="<?php esc_html_e('Remove','thsa-quote-generator'); ?>">
        </div>
    </div>
</div>