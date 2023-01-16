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
     * 
     * determin if the woocommerce subscription is active
     * 
     * 
     */
    var $woocommerce_subscription = false;

    /**
     * 
     * 
     * determine if the aelia woocommerce currency switcher is active
     * 
     * 
     */
    var $aelia_woo_currency_switcher = false;

    /**
     * 
     * check if any supported plugin is available for subscriptions
     * 
     */
    var $has_subscriptions = false;

    /**
     * 
     * 
     * check if any supported plugin available for currencies
     * 
     * 
     */
    var $has_currencies = false;

    public function __construct()
    {
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        $this->woocommerce_subscription = is_plugin_active( 'woocommerce-subscriptions/woocommerce-subscriptions.php' );
        $this->aelia_woo_currency_switcher = is_plugin_active( 'woocommerce-aelia-currencyswitcher/woocommerce-aelia-currencyswitcher.php' );

        $subscriptions_ = [ $this->woocommerce_subscription ];
        foreach($subscriptions_ as $subs){
            if( $subs ){
                $this->has_subscriptions = true;
                break;
            }
        }

        $currencies_ = [ $this->aelia_woo_currency_switcher ];
        foreach($currencies_ as $cur){
            if( $cur ){
                $this->has_currencies = true;
                break;
            }
        }

    }
    
    /**
     * 
     * 
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
        if ( $this->aelia_woo_currency_switcher ) {
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
        if ( $this->aelia_woo_currency_switcher ) {
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
                    'price_number' => $price_number,
                    'price_regular_number' => $price_regular_number,
                    'price_sale_number' => $price_sale_number,
                    'formatted_price_number' => $this->format_number( ['amount' => $price_number, 'round' => false ] ),
                    'formatted_regular_price_number' => $this->format_number( ['amount' => $price_regular_number, 'round' => false ] ),
                    'formatted_sale_price_number' => $this->format_number( ['amount' => $price_sale_number, 'round' => false ] )
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
            'price_number' => $price_number,
            'price_regular_number' => $price_regular_number,
            'price_sale_number' => $price_sale_number,
            'formatted_price_number' => $this->format_number( ['amount' => $price_number, 'round' => false ] ),
            'formatted_regular_price_number' => $this->format_number( ['amount' => $price_regular_number, 'round' => false ] ),
            'formatted_sale_price_number' => $this->format_number( ['amount' => $price_sale_number, 'round' => false ] )
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
        if ( $this->aelia_woo_currency_switcher ) {
            
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
    public function coupon_currency( $id, $amount = 0 )
    {

        if( !isset($id) )
            return;

        /**
         * 
         * aelia currency switcher
         * 
         */
        if ( $this->aelia_woo_currency_switcher ) {

            //get endabled currencies
            $settings = $this->aelia_currency_switcher();
            $currencies = $settings['enabled_currencies'];

            if(!empty($currencies)){
                $amounts = [];
                foreach($currencies as $currencies){
                    $amounts[$currencies] = [
                        'coupon_amount' => $amount,
                        'minimum_amount' => null,
                        'maximum_amount' => null
                    ];
                }
                if(!empty($amounts))
                    update_post_meta( $id, '_coupon_currency_data', $amounts );
            }


        }
            
        

    }

    /**
     * 
     * 
     * generate_plan
     * @since 1.2.0
     * @param
     * @return
     * 
     * 
     */
    public function generate_plan($post_id = 0, $data = null)
    {
        if(!$data || !$post_id)
            return;

        if(!isset($data['products']))
            return;

        
        if ( $this->woocommerce_subscription ) {
                    
            //calculate amount
            $tem_total = 0;
            foreach($data['products'] as $product){
                if(!isset($product[0])){
                    continue;
                }
                $prod = wc_get_product($product[0]);
                $tem_total += ($prod->get_price() * $product[1]);
            }

            //deduct the discount
            $tem_total -= ($data['fixed_amount_discount'])? $data['fixed_amount_discount'] : 0;

            //calculate monthly
            $monthly = 0;
            if(isset($data['term_number'])){
                $monthly = $tem_total / $data['term_number'];
            }

            //check if exist
            $args = [
                'post_type' => 'product',
                'numberposts' => 1,
                'name' => 'quotation-'.$post_id,
                'post_status' => 'publish',
                'fields' => 'ids'
            ];
            $get_sub = get_posts($args);

            if(empty($get_sub)){
                $objProduct = new \WC_Product_Subscription();
                $objProduct->set_name('quotation-'.$post_id);
                $objProduct->set_status('publish');		
                $objProduct->set_price($monthly); 
                $objProduct->set_regular_price($monthly);
                $sub_id = $objProduct->save();

            }else{
                $sub_id = $get_sub[0];
            }

            $get_tags = (array) wp_get_object_terms( $sub_id, $this->product_tag );
            $get_tags = (array) $get_tags[0];
            $it_has = ( in_array($this->quote_slug_tag, $get_tags) )? true : false;

            if( !$it_has ){
                $qg_term = get_term_by( 'slug', $this->quote_slug_tag, $this->product_tag );
                wp_set_object_terms( $sub_id, $qg_term->term_id, $this->product_tag );
            }

            update_post_meta( $sub_id, '_sold_individually', 'yes');
            update_post_meta( $sub_id, '_subscription_sign_up_fee', 0);
            update_post_meta( $sub_id, '_subscription_price', $monthly );
            update_post_meta( $sub_id, '_price', $monthly );
            update_post_meta( $sub_id, '_regular_price', $monthly );
            update_post_meta( $sub_id, '_subscription_length', $data['term_number'] );
            update_post_meta( $sub_id, '_subscription_period', $data['term_plan_type'] );
            update_post_meta( $sub_id, '_subscription_period_interval', $data['term_every'] );

            update_post_meta( $sub_id, '_subscription_trial_period', $data['free_trial_interval_duration'] );
            update_post_meta( $sub_id, '_subscription_trial_length', $data['free_trial_interval'] );

            update_post_meta( $sub_id, '_virtual', $data['is_virtual']);
            update_post_meta( $sub_id, '_downloadable', $data['is_download']);
            update_post_meta( $sub_id, '_tax_status', $data['is_taxable']);
            update_post_meta( $sub_id, '_tax_class', $data['tax_class']);
            update_post_meta( $sub_id, '_stock', NULL );
            update_post_meta( $sub_id, '_stock_status', 'instock' );

            if($data['is_download'] == 'yes'){
                update_post_meta( $sub_id, '_downloadable_files', $data['dl_files']);
                update_post_meta( $sub_id, '_download_limit', $data['dl_limit']);
                update_post_meta( $sub_id, '_download_expiry', $data['dl_limit_expiry']);
            }
            
            return $sub_id;

        }

        return;
        
    }


}



?>