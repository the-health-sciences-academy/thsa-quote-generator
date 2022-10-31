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
                        <label><br/>
                        <select class="widefat thsa_qg_product_select"></select>
                        </label>
                    </td>
                </tr>
            </table>

            <table class="widefat wp-list-table widefat fixed striped table-view-list thsa_qg_product_table">
                <thead>
                    <tr>
                        <th width="2%"><input type="checkbox" class="thsa_qg_select_all"></th>
                        <th width="83%"><b><?php _e('Product','thsa-quote-generator'); ?></b></th>
                        <th width="15%"><b><?php _e('Price','thsa-quote-generator'); ?></b></th>
                    </tr>
                </thead>
                <tbody class="thsa_qg_selected_products">
                    <?php 
                        if(!isset($params['products'])):
                    ?>
                        <tr class="thsa_qg_no_product">
                            <td colspan="3"><center><?php _e('No products added', 'thsa-quote-generator'); ?></center></td>
                        </tr>
                    <?php
                        else:
                        endif;
                    ?>
                </tbody>
            </table>
            <input type="button" class="button button-secondary thsa_qg_remove_added_item" data-source="products" value="Remove">
        </div>
    </div>
</div>