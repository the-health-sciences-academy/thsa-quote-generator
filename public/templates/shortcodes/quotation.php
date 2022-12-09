<div class="thsa_quotation_table">
    <table class="thsa_qg_table" <?php if( isset($params['from_email']) ): ?> cellpadding="5" cellspacing="0" style="width: 100%; border: 1px solid #000; background-color: white;" <?php endif; ?>>
        <tr>
            <th width="55%" <?php if( isset($params['from_email']) ): ?> style="text-align: left; border-bottom: 1px solid #000;" <?php endif; ?>><?php esc_attr_e('Product','thsa_quote_generator'); ?></th>
            <th width="15%" <?php if( isset($params['from_email']) ): ?> style="text-align: left; border-bottom: 1px solid #000;" <?php endif; ?>><?php esc_attr_e('Price','thsa_quote_generator'); ?></th>
            <th width="15%" <?php if( isset($params['from_email']) ): ?> style="text-align: left; border-bottom: 1px solid #000;" <?php endif; ?>><?php esc_attr_e('Quantity','thsa_quote_generator'); ?></th>
            <th width="15%" <?php if( isset($params['from_email']) ): ?> style="text-align: left; border-bottom: 1px solid #000;" <?php endif; ?>><?php esc_attr_e('Amount','thsa_quote_generator'); ?></th>
        </tr>
        <?php 
            if(isset($params['products'])):
                foreach($params['products'] as $pid => $product):
        ?>
        <tr>
            <td <?php if( isset($params['from_email']) ): ?> style="border-bottom: 1px solid #000;" <?php endif; ?>><?php esc_attr_e($product['text'],'thsa-quote-generator'); ?></td>
            <td <?php if( isset($params['from_email']) ): ?> style="border-bottom: 1px solid #000;" <?php endif; ?>><?php echo $product['price_html']; ?></td>
            <td <?php if( isset($params['from_email']) ): ?> style="border-bottom: 1px solid #000;" <?php endif; ?>><?php esc_attr_e($product['qty'],'thsa-quote-generator'); ?></td>
            <td <?php if( isset($params['from_email']) ): ?> style="border-bottom: 1px solid #000;" <?php endif; ?>><?php echo $product['amount']; ?></td>
        </tr>
        <?php 
                endforeach;
            else: ?>
        <tr>
            <td colspan="4"><?php esc_attr_e('No items available', 'thsa-quote-generator'); ?></td>
        </tr>
        <?php endif; ?>

        <tfoot>
            <?php 
            if(isset($params['labels'])): 
                foreach($params['labels'] as $label => $value):
                    if(!$value)
                        continue;

                    if($label != 'Fees'):   
                        $class = ($label == 'Total Today')? 'thsa_qg_public_total' : null;
            ?>
                    <tr class="<?php esc_html_e($class); ?>">
                        <td></td>
                        <td colspan="2" <?php if( isset($params['from_email']) ): ?> style="border-bottom: 1px solid #000; border-left: 1px solid #000;" <?php endif; ?>><?php esc_html_e($label,'thsa-quote-generator'); ?></td>
                        <td colspan="1" <?php if( isset($params['from_email']) ): ?> style="border-bottom: 1px solid #000;" <?php endif; ?>><?php echo $value; ?></td>
                    </tr>
            <?php 
                else:
                    foreach($value as $fee):
            ?>
                    <tr>
                        <td></td>
                        <td colspan="2" <?php if( isset($params['from_email']) ): ?> style="border-bottom: 1px solid #000;" <?php endif; ?>><?php esc_attr_e($fee['name'],'thsa-quote-generator'); ?></td>
                        <td colspan="1" <?php if( isset($params['from_email']) ): ?> style="border-bottom: 1px solid #000;" <?php endif; ?>><?php echo wc_price($fee['amount']); ?></td>
                    </tr>
            <?php
                    endforeach;
                endif;
                endforeach;
            endif; ?>
        </tfoot>
       
    </table>
    <?php do_action('thsa_qg_before_total_button'); ?>
    <div class="thsa_qg_row thsa_qg_total_foot">
        <div class="thsa_qg_col-6">
            <strong><?php if(isset($params['data']['expiry'])){ esc_attr_e('Quotation expires on '.date('M d, Y',strtotime($params['data']['expiry'])),'thsa-quote-generator'); } ?></strong>
        </div>
        <div class="thsa_qg_col-6">
            <?php if(isset($params['from_email'])): ?>
            <p style="text-align: center;"><a href="<?php echo esc_url($params['checkout_url']); ?>" <?php if($params['from_email'] == true): ?> style="padding: 10px 20px; background: #f2f2f2; border: 1px solid #CCC;" <?php endif; ?>><?php esc_html_e('Proceed to checkout','thsa-quote-generator'); ?></a></p>
            <?php else: ?>
            <input type="button" data-q-id="<?php esc_attr_e($params['qid'],'thsa-quote-generator'); ?>" class="thsa_qg_proceed_checkout" value="<?php esc_attr_e('Proceed to checkout','thsa-quote-generator'); ?>">
            <?php endif; ?>
        </div>
    </div>
    
</div>