<div class="thsa_qg_wrapper">
    <div class="thsa_qg_inner">
        <div class="thsa_qg_table_con">
        <h3><?php _e('Fees', 'thsa-quote-generator'); ?></h3>
        <table>
            <tr>
                <td>
                    <label>
                        <?php _e('Fee Name','thsa-quote-generator'); ?>
                        <input type="text" class="widefat thsa_qg_fee_name" >
                    </label>
                </td>
                <td>
                    <label>
                        <?php _e('Amount','thsa-quote-generator'); ?>
                        <input type="number" class="widefat thsa_qg_fee_amount" placeholder="0">
                    </label>
                </td>
                <td valign="bottom">
                    <input type="button" class="button button-primary thsa_qg_add_fee" value="Add">
                </td>
            </tr>
        </table>
        </div>
        <div class="thsa_qg_table_con">
        <table class="widefat wp-list-table widefat fixed striped table-view-list thsa_qg_fees_list">
            <thead>
                <tr>
                    <th width="2%"><input type="checkbox" class="thsa_qg_fee_select_all"></th>
                    <th width="73%"><b><?php _e('Fee Name', 'thsa-quote-generator'); ?></b></th>
                    <th width="15%"><b><?php _e('Amount', 'thsa-quote-generator'); ?></b></th>
                </tr>
            </thead>
            <tbody class="thsa_qg_added_fees">

            <?php 
                if(isset($params['data']['fees'])): 
                    foreach($params['data']['fees'] as $fee):   
                        $fee_json = json_encode($fee); 
            ?>
                    <tr data-fee="<?php echo $fee['fee_amount']; ?>">
                        <td>
                            <input type="checkbox">
                            <input name="thsa_qg_added_fee[]" value="<?php echo htmlentities($fee_json); ?>" type="hidden">
                        </td>
                        <td><?php echo $fee['fee_name']; ?></td>
                        <td><?php echo $fee['fee_amount']; ?></td>
                    </tr>
            <?php 
                    endforeach;
                else:
            ?>
                <tr class="thsa_qg_no_fee">
                    <td colspan="4"><center><?php _e('No fees added', 'thsa-quote-generator'); ?></center></td>
                </tr>
            <?php
                endif; 
            ?>
                
            </tbody>
        </table>
        <input type="button" class="button button-secondary thsa_qg_remove_added_item" data-source="fee" value="Remove">
        </div>
    </div>
</div>