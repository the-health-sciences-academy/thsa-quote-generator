<div class="thsa_qg_wrapper thsa_qg_settings_wrapper">
    <div class="thsa_qg_inner">
        <h2><?php _e('Settings','thsa-quote-generator'); ?></h2>
        <ul class="thsa_qg_settings_tab">
            <?php 
                echo $this->tab_settings_manager(
                    [
                        [
                            'text' => 'General',
                            'target' => 'thsa_set_gen_con',
                            'status' => 'active'
                        ],
                        [
                            'text' => 'Subscription',
                            'target' => 'thsa_set_subscription_con',
                            'status' => ''
                        ],
                        [
                            'text' => 'Coupon',
                            'target' => 'thsa_set_coupon_con',
                            'status' => ''
                        ],
                        [
                            'text' => 'Email',
                            'target' => 'thsa_set_email_con',
                            'status' => ''
                        ],
                        [
                            'text' => 'Quotation',
                            'target' => 'thsa_set_quote_con',
                            'status' => ''
                        ]
                    ]
                );
            ?>
        </ul>
        <div class="thsa_settings_content">
            <?php 
            $this->tab_content_manager(
                [
                    [
                        'class' => 'thsa_set_gen_con',
                        'content' => [$this, 'general_settings'],
                        'status' => 'active'
                    ],
                    [
                        'class' => 'thsa_set_subscription_con',
                        'content' => [$this, 'subscription_settings'],
                        'status' => null
                    ],
                    [
                        'class' => 'thsa_set_coupon_con',
                        'content' => [$this, 'coupon_settings'],
                        'status' => null
                    ],
                    [
                        'class' => 'thsa_set_email_con',
                        'content' => [$this, 'email_settings'],
                        'status' => null
                    ],
                    [
                        'class' => 'thsa_set_quote_con',
                        'content' => [$this, 'quote_settings'],
                        'status' => null
                    ]
                ]
            );
            ?>
        </div>
    </div>
</div>