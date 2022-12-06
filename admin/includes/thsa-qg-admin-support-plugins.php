<?php 
/**
 * 
 * 
 * thsa_qg_admin_support_plugins
 * @since 1.2.0
 * @author thsa
 * 
 * 
 */
namespace thsa\qg\admin\support\plugins;
use thsa\qg\common\thsa_qg_common_class;

defined( 'ABSPATH' ) or die( 'No access area' );


class thsa_qg_admin_support_plugins extends thsa_qg_common_class
{
    
    /**
     * 
     * setttings
     * @since 1.2.0
     * @param string - assigned plugin name
     * @return array
     * 
     * 
     * 
     */
    public function settings( $plugin = null )
    {
        if(!$plugin)
            return;

        switch($plugin)
        {
            case 'aelia':
                return  $this->aelia_currency_switcher();
                break;
        }
    }

    /**
     * 
     * 
     * aelia_currency_switcher
     * plugin: aelia currency switcher
     * @since 1.2.0
     * @param
     * @return
     * 
     */
    public function aelia_currency_switcher()
    {
        if ( is_plugin_active( 'woocommerce-aelia-currencyswitcher/woocommerce-aelia-currencyswitcher.php' ) ) {
            //do stuffs for aelia
            $settings = get_option('wc_aelia_currency_switcher');
            return apply_filters('thsa_qg_aelia_settings', 
                [
                    'enabled_currencies' => $settings['enabled_currencies'],
                    'exchange_rates' => $settings['exchange_rates']
                ]
            );
        }else{
            return;
        }
    }

    /**
     * 
     * 
     * currency_values
     * @since 1.2.0
     * @param array
     * @return array
     * 
     * 
     */
    public function currency_values( $args = [] )
    {
        
        $price_html = $args['product_prices']['price_html'];
        $price_number = $args['product_prices']['price_number'];
        $price_regular_number = $args['product_prices']['price_regular_number'];
        $price_sale_number = $args['product_prices']['price_sale_number'];
        
        /**
         * 
         * 
         * aelia currency switcher
         * 
         * 
         */
        if ( is_plugin_active( 'woocommerce-aelia-currencyswitcher/woocommerce-aelia-currencyswitcher.php' ) ) {
            //check if manually added
            $currency_prices = get_post_meta($args['product_id'], '_regular_currency_prices', true);
            $currency_prices = json_decode($currency_prices);
            $currency_prices = (array) $currency_prices;

            if(!empty($currency_prices)){
                    
                $currency_sale_prices = get_post_meta($args['product_id'], '_sale_currency_prices', true);
                $currency_sale_prices = json_decode($currency_sale_prices);
                $currency_sale_prices = (array) $currency_sale_prices;

                if( !empty($currency_sale_prices) ){

                    $price_sale_ = ( !empty($currency_sale_prices[ $args['currency'] ]) )? $currency_sale_prices[ $args['currency'] ] : get_post_meta( $args['product_id'], '_price', true);
                    $price_ = ( !empty($currency_prices[ $args['currency'] ]) )? $currency_prices[ $args['currency'] ] : get_post_meta( $args['product_id'], '_price', true);

                    $price_html = $this->price_html(
                        [
                            'sale' => $price_sale_,
                            'regular' => $price_,
                            'currency' => $args['currency']
                        ]
                    );
                    $price_number = $price_sale_;
                    $price_regular_number = $price_sale_;
                    $price_sale_number = $price_sale_;

                }else{
                    $price_ = ( !empty($currency_prices[ $args['currency'] ]) )? $currency_prices[ $args['currency'] ] : get_post_meta( $args['product_id'], '_price', true);
                    $price_html = $this->price_html(
                        [
                            'regular' => $price_,
                            'currency' => $args['currency']
                        ]
                    );

                    $price_number = $price_;
                    $price_regular_number = $price_;
                }

                return [
                    'price_html' => $price_html,
                    'price_number' => $price_number,
                    'price_regular_number' => $price_regular_number,
                    'price_sale_number' => $price_sale_number
                ];

            }else{
                //compute rate if product has no manual coversion
                $settings = $this->aelia_currency_switcher();

                if(isset($settings)){

                    $get_sale_price = get_post_meta( $args['product_id'], '_sale_price', true );
                    if( !empty($get_sale_price) ){

                        $price_regular_number = get_post_meta( $args['product_id'], '_regular_price', true );

                        if( isset($settings['exchange_rates'][ $args['currency'] ]['rate']) ){
                            $mark_up = $settings['exchange_rates'][$args['currency']];
                            $rate = $settings['exchange_rates'][$args['currency']]['rate'];
                            
                            if(isset( $mark_up['rate_markup'] ) && $mark_up['rate_markup'] != ''){
                                
                                if( strpos($mark_up['rate_markup'],'%') !== false ){
                                    $temp_markup = str_replace('%','',$mark_up['rate_markup']);
                                    $temp_rate =  $rate * ($temp_markup / 100 ) + $rate;
                                }else{
                                    $temp_rate = $rate + $mark_up['rate_markup'];
                                }
                                $price_regular_number = $price_regular_number * $temp_rate;
                                $get_sale_price = $get_sale_price * $temp_rate;

                            }else{
                                //no markup
                                $price_regular_number = $price_regular_number * $rate;
                                $get_sale_price = $get_sale_price * $rate;
                            }
                        }

                        $price_html = $this->price_html(
                            [
                                'sale' => $get_sale_price,
                                'regular' => $price_regular_number,
                                'currency' => $args['currency']
                            ]
                        );
                        $price_number = $get_sale_price;
                        $price_sale_number = $get_sale_price;
                        
                    }else{

                        $price_regular_number = get_post_meta( $args['product_id'], '_price', true );

                        if( isset($settings['exchange_rates'][ $args['currency'] ]['rate']) ){
                            $mark_up = $settings['exchange_rates'][ $args['currency'] ];
                            $rate = $settings['exchange_rates'][ $args['currency'] ]['rate'];
                            
                            if(isset( $mark_up['rate_markup'] )){
                                
                                if( strpos($mark_up['rate_markup'],'%') !== false ){
                                    $mark_up = $mark_up['rate_markup'] / 100;
                                }else{
                                    $mark_up = $mark_up['rate_markup'];
                                }

                                $temp_rate = $rate + $mark_up;
                                $price_regular_number = $price_regular_number * $temp_rate;

                            }else{
                                //no markup
                                $price_regular_number = $price_regular_number * $rate;
                            }
                        }

                        $price_html = $this->price_html(
                            [
                                'regular' => $price_regular_number,
                                'currency' => $args['currency']
                            ]
                        );
                        $price_number = $price_regular_number;

                    }

                }
                //calculate rate
                return [
                    'price_html' => $price_html,
                    'price_number' => $this->format_number( ['amount' => $price_number, 'round' => false ] ),
                    'price_regular_number' => $this->format_number( ['amount' => $price_regular_number, 'round' => false ] ),
                    'price_sale_number' => $this->format_number( ['amount' => $price_sale_number, 'round' => false ] )
                ];

            }

        } 
        /**
         * 
         * 
         * 
         * end of aelia curreny switcher
         * 
         * 
         * 
         */
        
        //just return what is passed
        return [
            'price_html' => $price_html,
            'price_number' => $this->format_number( ['amount' => $price_number, 'round' => false ] ),
            'price_regular_number' => $this->format_number( ['amount' => $price_regular_number, 'round' => false ] ),
            'price_sale_number' => $this->format_number( ['amount' => $price_sale_number, 'round' => false ] )
        ];
    }



    /**
     * 
     * 
     * switch_currency
     * @since 1.2.0
     * @param
     * @return
     * 
     * 
     */

    public function switch_post_currency( $currency = null )
    {

        if( !isset($currency) )
            return;

        /**
         * 
         * 
         * For aelia currency switcher
         * 
         * 
         */
        if ( is_plugin_active( 'woocommerce-aelia-currencyswitcher/woocommerce-aelia-currencyswitcher.php' ) ) {
            
            $_POST['aelia_cs_currency'] = $currency;

        }
        
    }

    /**
     * 
     * 
     * coupon_currency
     * @since 1.2.0
     * @param object
     * @return
     * 
     * 
     */
    public function coupon_currency( $obj = null, $data )
    {

        if( !isset($obj) )
            return;

        /**
         * 
         * aelia currency switcher
         * 
         */
        if ( is_plugin_active( 'woocommerce-aelia-currencyswitcher/woocommerce-aelia-currencyswitcher.php' ) ) {

            //get endabled currencies
            $settings = $this->aelia_currency_switcher();
            $currencies = $settings['enabled_currencies'];

            if(!empty($currencies)){
                $amounts = [];
                foreach($currencies as $currencies){
                    $amounts[$currencies] = [
                        'coupon_amount' => $data['discount'],
                        'minimum_amount' => null,
                        'maximum_amount' => null
                    ];
                }
                if(!empty($amounts))
                    $obj->update_coupon_meta($data['id'], '_coupon_currency_data', $amounts);
            }


        }
            
        

    }


}



?>