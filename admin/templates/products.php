<div class="thsa_qg_wrapper">
    <div class="thsa_qg_inner">
        <h3><?php _e('Products', 'thsa-quote-generator'); ?></h3>
        <div class="thsa_product_options">        
            <table class="widefat no-border" border="0">
                <tr>
                    <td width="20%">
                        <label><?php _e('Search By','thsa-quote-generator') ?>
                        <select class="widefat thsa_qg_select_woo thsa_qg_filter_option">
                            <option value="product"><?php _e('Products','thsa-quote-generator') ?></option>
                            <option value="category"><?php _e('Category','thsa-quote-generator') ?></option>
                            <option value="tag"><?php _e('Tag','thsa-quote-generator') ?></option>
                        </select>
                        </label>
                    </td>
                    <td width="80%">
                        <label>Select Product
                        <select class="widefat thsa_qg_product_select"></select>
                        </label>
                    </td>
                    <td width="10%">
                        <input type="button" class="button button-primary button-medium thsa_qg_add_product" value="<?php _e('Add','thsa_quote_generator'); ?>">
                    </td>
                </tr>
            </table>

            <table class="widefat wp-list-table widefat fixed striped table-view-list thsa_qg_product_table">
                <thead>
                    <tr>
                        <th width="2%"><input type="checkbox" class="thsa_qg_select_all"></th>
                        <th width="63%"><b><?php _e('Product','thsa-quote-generator'); ?></b></th>
                        <th width="15%"><b><?php _e('Price','thsa-quote-generator'); ?></b></th>
                        <th width="10%"><b><?php _e('Quantity','thsa-quote-generator'); ?></b></th>
                        <th width="10%"><b><?php _e('Amount','thsa-quote-generator'); ?></b></th>
                    </tr>
                </thead>
                <tbody class="thsa_qg_selected_products">
                    <?php 
                        if(empty($params['products'])):
                    ?>
                        <tr class="thsa_qg_no_product">
                            <td colspan="5"><center><?php _e('No products added', 'thsa-quote-generator'); ?></center></td>
                        </tr>
                    <?php
                        else:
                            foreach($params['products'] as $product):    
                                ?>
                                    <tr class="thsa_parent_tr" data-selected="<?php echo $product['id'] ?>" data-selected-name="<?php echo $product['text']; ?>" data-price-num="<?php echo $product['price_number']; ?>">
                                        <td>
                                            <input type="checkbox">
                                            <input name="thsa_qg_added_product[]" value="<?php echo $product['id']; ?>" type="hidden">
                                        </td>
                                        <td><?php echo $product['text']; ?></td>
                                        <td>
                                            <?php echo $product['price_html']; ?>
                                        </td>
                                        <td>
                                            <input name="thsa_qg_added_product_qty[]" class="thsa_qg_added_product_qty" value="<?php echo $product['qty']; ?>" type="number">
                                        </td>
                                        <td class="thsa_qg_product_amount"><?php echo $product['amount']; ?></td>
                                    </tr>
                                <?php 
                            endforeach;  
                        endif;
                    ?>
                </tbody>
            </table>
            <input type="button" class="button button-secondary thsa_qg_remove_added_item" data-source="products" value="<?php _e('Remove','thsa_quote_generator'); ?>">
        </div>
    </div>
</div>