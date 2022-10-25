<div class="thsa_qg_wrapper">
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

    <table class="widefat wp-list-table widefat fixed striped table-view-list">
        <thead>
            <tr>
                <th width="2%"><input type="checkbox" class="thsa_qg_select_all"></th>
                <th width="83%"><b><?php _e('Product','thsa-quote-generator'); ?></b></th>
                <th width="15%"><b><?php _e('Price','thsa-quote-generator'); ?></b></th>
            </tr>
        </thead>
        <tbody class="thsa_qg_selected_products"></tbody>
    </table>
    <br/>
    <input type="button" class="button button-secondary thsa_qg_remove_added_item" value="Remove">
</div>
</div>