<div class="thsa_quotation_table">
    <table cellspacing="0" cellpadding="10" class="thsa_qg_table" style="<?php echo $this->render_inline_style(
                    [
                        [
                        'type' => 'thsa_qg_text_color',
                        'value' => (isset($params['style']['thsa_qg_text_color']))? $params['style']['thsa_qg_text_color'] : null
                        ],
                        [
                        'type' => 'thsa_qg_background_color',
                        'value' => (isset($params['style']['thsa_qg_background_color']))? $params['style']['thsa_qg_background_color'] : null
                        ]
                    ]
                    ); 
            ?>">
        <thead>
        <tr>
            <th width="55%" style="<?php 
                echo $this->render_inline_style(
                    [
                        [
                        'type' => 'thsa_qg_header_color',
                        'value' => (isset($params['style']['thsa_qg_header_color']))? $params['style']['thsa_qg_header_color'] : null
                        ],
                        [
                        'type' => 'thsa_qg_header_text_color',
                        'value' => (isset($params['style']['thsa_qg_header_text_color']))? $params['style']['thsa_qg_header_text_color'] : null
                        ],
                        [
                        'type' => 'thsa_qg_border_color',
                        'value' => (isset($params['style']['thsa_qg_border_color']))? $params['style']['thsa_qg_border_color'] : null
                        ]

                    ]
                ); 
            ?> text-align: left;"><?php esc_attr_e('Product','thsa_quote_generator'); ?></th>
            <th width="15%" style="<?php 
                echo $this->render_inline_style(
                    [
                        [
                        'type' => 'thsa_qg_header_color',
                        'value' => (isset($params['style']['thsa_qg_header_color']))? $params['style']['thsa_qg_header_color'] : null
                        ],
                        [
                        'type' => 'thsa_qg_header_text_color',
                        'value' => (isset($params['style']['thsa_qg_header_text_color']))? $params['style']['thsa_qg_header_text_color'] : null
                        ],
                        [
                            'type' => 'thsa_qg_border_color',
                            'value' => (isset($params['style']['thsa_qg_border_color']))? $params['style']['thsa_qg_border_color'] : null
                            ]

                    ]
                ); 
            ?> text-align: left;"><?php esc_attr_e('Price','thsa_quote_generator'); ?></th>
            <th width="15%" style="<?php 
                echo $this->render_inline_style(
                    [
                        [
                        'type' => 'thsa_qg_header_color',
                        'value' => (isset($params['style']['thsa_qg_header_color']))? $params['style']['thsa_qg_header_color'] : null
                        ],
                        [
                        'type' => 'thsa_qg_header_text_color',
                        'value' => (isset($params['style']['thsa_qg_header_text_color']))? $params['style']['thsa_qg_header_text_color'] : null
                        ],
                        [
                            'type' => 'thsa_qg_border_color',
                            'value' => (isset($params['style']['thsa_qg_border_color']))? $params['style']['thsa_qg_border_color'] : null
                            ]

                    ]
                ); 
            ?> text-align: left;"><?php esc_attr_e('Quantity','thsa_quote_generator'); ?></th>
            <th width="15%" style="<?php 
                echo $this->render_inline_style(
                    [
                        [
                        'type' => 'thsa_qg_header_color',
                        'value' => (isset($params['style']['thsa_qg_header_color']))? $params['style']['thsa_qg_header_color'] : null
                        ],
                        [
                        'type' => 'thsa_qg_header_text_color',
                        'value' => (isset($params['style']['thsa_qg_header_text_color']))? $params['style']['thsa_qg_header_text_color'] : null
                        ],
                        [
                            'type' => 'thsa_qg_border_color',
                            'value' => (isset($params['style']['thsa_qg_border_color']))? $params['style']['thsa_qg_border_color'] : null
                            ]

                    ]
                ); 
            ?> text-align: left;"><?php esc_attr_e('Amount','thsa_quote_generator'); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php 
            if(isset($params['products'])):
                foreach($params['products'] as $pid => $product):
        ?>
        <tr>
            <td style="<?php 
                echo $this->render_inline_style(
                    [
                        [
                        'type' => 'thsa_qg_text_color',
                        'value' => (isset($params['style']['thsa_qg_text_color']))? $params['style']['thsa_qg_text_color'] : null
                        ],
                        [
                        'type' => 'thsa_qg_background_color',
                        'value' => (isset($params['style']['thsa_qg_background_color']))? $params['style']['thsa_qg_background_color'] : null
                        ],
                        [
                            'type' => 'thsa_qg_border_color',
                            'value' => (isset($params['style']['thsa_qg_border_color']))? $params['style']['thsa_qg_border_color'] : null
                        ]

                    ]
                ); 
            ?>"><?php esc_attr_e($product['text'],'thsa-quote-generator'); ?></td>
            <td style="<?php 
                echo $this->render_inline_style(
                    [
                        [
                        'type' => 'thsa_qg_text_color',
                        'value' => (isset($params['style']['thsa_qg_text_color']))? $params['style']['thsa_qg_text_color'] : null
                        ],
                        [
                        'type' => 'thsa_qg_background_color',
                        'value' => (isset($params['style']['thsa_qg_background_color']))? $params['style']['thsa_qg_background_color'] : null
                        ],
                        [
                            'type' => 'thsa_qg_border_color',
                            'value' => (isset($params['style']['thsa_qg_border_color']))? $params['style']['thsa_qg_border_color'] : null
                        ]

                    ]
                ); 
            ?>"><?php echo $product['price_html']; ?></td>
            <td style="<?php 
                echo $this->render_inline_style(
                    [
                        [
                        'type' => 'thsa_qg_text_color',
                        'value' => (isset($params['style']['thsa_qg_text_color']))? $params['style']['thsa_qg_text_color'] : null
                        ],
                        [
                        'type' => 'thsa_qg_background_color',
                        'value' => (isset($params['style']['thsa_qg_background_color']))? $params['style']['thsa_qg_background_color'] : null
                        ],
                        [
                            'type' => 'thsa_qg_border_color',
                            'value' => (isset($params['style']['thsa_qg_border_color']))? $params['style']['thsa_qg_border_color'] : null
                        ]

                    ]
                ); 
            ?>"><?php esc_attr_e($product['qty'],'thsa-quote-generator'); ?></td>
            <td style="<?php 
                echo $this->render_inline_style(
                    [
                        [
                        'type' => 'thsa_qg_text_color',
                        'value' => (isset($params['style']['thsa_qg_text_color']))? $params['style']['thsa_qg_text_color'] : null
                        ],
                        [
                        'type' => 'thsa_qg_background_color',
                        'value' => (isset($params['style']['thsa_qg_background_color']))? $params['style']['thsa_qg_background_color'] : null
                        ],
                        [
                            'type' => 'thsa_qg_border_color',
                            'value' => (isset($params['style']['thsa_qg_border_color']))? $params['style']['thsa_qg_border_color'] : null
                        ]

                    ]
                ); 
            ?>"><?php echo $product['amount']; ?></td>
        </tr>
        <?php 
                endforeach;
            else: ?>
        <tr>
            <td colspan="4" style="<?php 
                echo $this->render_inline_style(
                    [
                        [
                        'type' => 'thsa_qg_text_color',
                        'value' => (isset($params['style']['thsa_qg_text_color']))? $params['style']['thsa_qg_text_color'] : null
                        ],
                        [
                        'type' => 'thsa_qg_background_color',
                        'value' => (isset($params['style']['thsa_qg_background_color']))? $params['style']['thsa_qg_background_color'] : null
                        ],
                        [
                            'type' => 'thsa_qg_border_color',
                            'value' => (isset($params['style']['thsa_qg_border_color']))? $params['style']['thsa_qg_border_color'] : null
                        ]

                    ]
                ); 
            ?>"><?php esc_attr_e('No items available', 'thsa-quote-generator'); ?></td>
        </tr>
        <?php endif; ?>
        </tbody>
        <tfoot>
            <?php 
            if(isset($params['labels'])): 
                foreach($params['labels'] as $label => $value):
                    if(!$value)
                        continue;

                    if($label != 'Fees'):   
                        $class = ($label == 'Total Today')? 'thsa_qg_public_total' : null;
                        $class = ( isset($params['from_email']) )? $class.' thsa_qg_public_total_email' : null;
            ?>
                    <tr class="<?php esc_html_e($class); ?>">
                        <td style="<?php 
                echo $this->render_inline_style(
                    [
                        [
                        'type' => 'thsa_qg_text_color',
                        'value' => (isset($params['style']['thsa_qg_text_color']))? $params['style']['thsa_qg_text_color'] : null
                        ],
                        [
                        'type' => 'thsa_qg_background_color',
                        'value' => (isset($params['style']['thsa_qg_background_color']))? $params['style']['thsa_qg_background_color'] : null
                        ],
                        [
                            'type' => 'thsa_qg_border_color',
                            'value' => (isset($params['style']['thsa_qg_border_color']))? $params['style']['thsa_qg_border_color'] : null
                        ]

                    ]
                ); 
            ?>"></td>
                        <td style="<?php 
                echo $this->render_inline_style(
                    [
                        [
                        'type' => 'thsa_qg_text_color',
                        'value' => (isset($params['style']['thsa_qg_text_color']))? $params['style']['thsa_qg_text_color'] : null
                        ],
                        [
                        'type' => 'thsa_qg_background_color',
                        'value' => (isset($params['style']['thsa_qg_background_color']))? $params['style']['thsa_qg_background_color'] : null
                        ],
                        [
                            'type' => 'thsa_qg_border_color',
                            'value' => (isset($params['style']['thsa_qg_border_color']))? $params['style']['thsa_qg_border_color'] : null
                        ]

                    ]
                ); 
            ?> font-weight: bold;"><?php esc_html_e($label,'thsa-quote-generator'); ?></td>
                        <td colspan="2" style="<?php 
                echo $this->render_inline_style(
                    [
                        [
                        'type' => 'thsa_qg_text_color',
                        'value' => (isset($params['style']['thsa_qg_text_color']))? $params['style']['thsa_qg_text_color'] : null
                        ],
                        [
                        'type' => 'thsa_qg_background_color',
                        'value' => (isset($params['style']['thsa_qg_background_color']))? $params['style']['thsa_qg_background_color'] : null
                        ],
                        [
                            'type' => 'thsa_qg_border_color',
                            'value' => (isset($params['style']['thsa_qg_border_color']))? $params['style']['thsa_qg_border_color'] : null
                        ]

                    ]
                ); 
            ?>; text-align: right; font-weight: bold;"><?php echo $value; ?></td>
                    </tr>
            <?php 
                else:
                    foreach($value as $fee):
            ?>
                    <tr>
                        <td></td>
                        <td colspan="2" style="<?php 
                echo $this->render_inline_style(
                    [
                        [
                        'type' => 'thsa_qg_text_color',
                        'value' => (isset($params['style']['thsa_qg_text_color']))? $params['style']['thsa_qg_text_color'] : null
                        ],
                        [
                        'type' => 'thsa_qg_background_color',
                        'value' => (isset($params['style']['thsa_qg_background_color']))? $params['style']['thsa_qg_background_color'] : null
                        ],
                        [
                            'type' => 'thsa_qg_border_color',
                            'value' => (isset($params['style']['thsa_qg_border_color']))? $params['style']['thsa_qg_border_color'] : null
                        ]

                    ]
                ); 
            ?>"><?php esc_attr_e($fee['name'],'thsa-quote-generator'); ?></td>
                        <td colspan="1" style="<?php 
                echo $this->render_inline_style(
                    [
                        [
                        'type' => 'thsa_qg_text_color',
                        'value' => (isset($params['style']['thsa_qg_text_color']))? $params['style']['thsa_qg_text_color'] : null
                        ],
                        [
                        'type' => 'thsa_qg_background_color',
                        'value' => (isset($params['style']['thsa_qg_background_color']))? $params['style']['thsa_qg_background_color'] : null
                        ],
                        [
                            'type' => 'thsa_qg_border_color',
                            'value' => (isset($params['style']['thsa_qg_border_color']))? $params['style']['thsa_qg_border_color'] : null
                        ]

                    ]
                ); 
            ?>"><?php echo wc_price($fee['amount']); ?></td>
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