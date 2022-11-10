<div class="thsa_quotation_table">
    <table class="thsa_qg_table">
        <tr>
            <th width="55%"><?php _e('Product','thsa_quote_generator'); ?></th>
            <th width="15%"><?php _e('Price','thsa_quote_generator'); ?></th>
            <th width="15%"><?php _e('Quantity','thsa_quote_generator'); ?></th>
            <th width="15%"><?php _e('Amount','thsa_quote_generator'); ?></th>
        </tr>
        <?php 
            if(isset($params['products'])):
                foreach($params['products'] as $pid => $product):
        ?>
        <tr>
            <td><?php echo $product['text']; ?></td>
            <td><?php echo $product['price_html']; ?></td>
            <td><?php echo $product['qty']; ?></td>
            <td><?php echo wc_price($product['amount']); ?></td>
        </tr>
        <?php 
                endforeach;
            else: ?>
        <tr>
            <td colspan="4"><?php _e('No items available', 'thsa_quote_generator'); ?></td>
        </tr>
        <?php endif; ?>
        <tfoot>
            <tr>
                <td></td>
                <td colspan="2"><?php _e('SubTotal','thsa_quote_generator'); ?></td>
                <td colspan="1"><?php echo wc_price($params['undiscounted']); ?></td>
            </tr>
            <?php 
                if(isset($params['data']['fixed_amount_discount'])): 
                    $discounts = $params['data']['fixed_amount_discount'];
            ?>
            <tr>
                <td></td>
                <td colspan="2"><?php _e('Discount','thsa_quote_generator'); ?></td>
                <td colspan="1">- <?php echo wc_price($discounts); ?></td>
            </tr>
            <?php endif; 
                if(isset($params['data']['fees'])): 
                    foreach($params['data']['fees'] as $fee):
            ?>
            <tr>
                <td></td>
                <td colspan="2">
                    <?php echo $fee['fee_name']; ?>
                </td>
                <td colspan="1">
                    <?php echo wc_price($fee['fee_amount']); ?>
                </td>
            </tr>
            <?php
                    endforeach; 
                endif; 
            ?>
            <tr class="thsa_qg_public_total">
                <td></td>
                <td colspan="2">
                    <?php _e('Total','thsa_quote_generator'); ?>
                </td>
                <td colspan="1">
                    <?php echo wc_price($params['grand_total']); ?>
                </td>
            </tr>
        </tfoot>
    </table>
    <?php do_action('thsa_qg_before_total_button'); ?>
    <div class="thsa_qg_row thsa_qg_total_foot">
        <div class="thsa_qg_col-6">
            <?php _e('Quotation expires on Jan 01, 2011','thsa_quote_generator'); ?>
        </div>
        <div class="thsa_qg_col-6">
            <input type="button" value="<?php _e('Proceed to checkout','thsa_quote_generator'); ?>">
        </div>
    </div>
    
</div>