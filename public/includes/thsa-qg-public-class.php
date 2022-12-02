<?php 
/**
 * 
 * 
 * thsa_qg_public
 * @since 1.2.0
 * @author thsa
 * 
 * 
 */

namespace thsa\qg\public;
use thsa\qg\common\thsa_qg_common_class;
use thsa\qg\public\shortcodes as thsaqgshorcodes;
use thsa\qg\admin\settings as qgsettings;

defined( 'ABSPATH' ) or die( 'No access area' );

class thsa_qg_public_class extends thsa_qg_common_class{


    private $quotation_data = 0;

    /**
     * 
     * 
     * __construct
     * @since 1.2.0
     * 
     * 
     */

    public function __construct()
    {
        new thsaqgshorcodes\thsa_qg_public_shortcodes();
        add_action('wp_enqueue_scripts', [$this, 'load_public_assets']);
        
        //add items to checkout
        add_action('wp', [$this,'load_items']);
        add_action('woocommerce_cart_calculate_fees',[$this,'add_fees']);
        add_filter('woocommerce_cart_totals_coupon_label', [$this,'edit_discount_name'] , 999 ,2); 
        
        add_action( 'woocommerce_before_calculate_totals', [$this, 'plan_item_prices'], 1000, 1);
        
        add_filter( 'woocommerce_cart_item_price', [$this, 'plan_item_prices_display'], 10, 4 );
        add_filter( 'woocommerce_cart_item_subtotal' , [$this, 'plan_item_prices_display'], 50, 4);


        //debug
        add_action('wp', function(){
            if(isset($_GET['debug'])){
                print_r(get_option('wc_aelia_currency_switcher'));
                echo '<br/><br/><br/>';
                print_r(get_post_meta($_GET['debug']));
                echo '<br/><br/>';
                echo wc_get_price_decimal_separator();
                die(); 
            }
        });
        
    }


    /**
     * 
     * 
     * load_public_assets
     * @since 1.2.02
     * @param
     * @return
     * 
     * 
     */
    public function load_public_assets()
    {
        wp_register_script( THSA_QG_PREFIX.'-public-js', THSA_QG_PLUGIN_URL.'public/assets/js/thsa-qg-public.js', array('jquery') );
        wp_enqueue_script( THSA_QG_PREFIX.'-public-js' );
        wp_enqueue_style( THSA_QG_PREFIX.'-public-css', THSA_QG_PLUGIN_URL.'public/assets/css/thsa-qg-public.css');

        $settings = new qgsettings\thsa_qg_admin_settings_class();
        $sett = $settings->get_settings('general');
        
        $checkout_page_url = site_url().'/checkout?quotation=';
        if(isset($sett['checkout'])){
            $checkout_page_url = get_permalink($sett['checkout']).'?quotation=';
        }
        wp_localize_script( THSA_QG_PREFIX.'-public-js', 'thsaqg_public_vars',
            [
                'thsa_qg_checkout_url'           =>  $checkout_page_url,
                'labels'                         =>  $this->labels()
            ]
        );
    }


    /**
     * 
     * load_items
     * @since 1.2.0
     * @param
     * @return
     * 
     * 
     */
    public function load_items()
    {
        //get settings here
        if(is_page('checkout')){

            if(!isset($_GET['quotation']))
                return;

            $qid = sanitize_text_field($_GET['quotation']);
            $quote = get_post_meta($qid,'thsa_quotation_data',true);

            if(isset($quote['customer'])){

                if(isset($quote['products'])){
                    //clear cart first
                    global $woocommerce;
                    $woocommerce->cart->empty_cart();

                    if($quote['payment_type'] == 'upfront'){
                        //add products to cart
                        foreach($quote['products'] as $pid){    
                            WC()->cart->add_to_cart( $pid[0], $pid[1]);
                        }
                    }else{
                        $plan_id = $quote['plan_product_id'];
                        WC()->cart->add_to_cart( $plan_id, 1);
                        foreach($quote['products'] as $pid){    
                            WC()->cart->add_to_cart( $pid[0], $pid[1]);
                        }
                    }
                    

                    $coupon_code = 'quotation-'.$qid;

                    $args = [
                        'post_type' => 'shop_coupon',
                        'name' => $coupon_code,
                        'post_status' => 'publish',
                        'field' => 'ids'
                    ];
                    $check_c = get_posts($args);
                    if(!empty($check_c)){

                        //apply coupon
                        $coupon = new \WC_Coupon($coupon_code);
                        $cc = new \WC_Discounts($coupon);
                        $coup = $cc->is_coupon_valid( $coupon );

                        if($coup){
                            $woocommerce->cart->add_discount( sanitize_text_field( $coupon_code ) );
                        }
                    }

              
                    WC()->session->set('thsa_on_process_quotation', $quote);
                    
                }
                
            }


            
        }
        
    }

    /**
     * 
     * 
     * add_fee
     * @since 1.2.0
     * @param
     * @return
     * 
     * 
     */
    public function add_fees()
    {

        if(WC()->session->get('thsa_on_process_quotation')){
            //apply fees
            global $woocommerce; 

            if ( is_admin() && ! defined( 'DOING_AJAX' ) ) 
                return;

            $data = WC()->session->get('thsa_on_process_quotation');
            $fees = $data['fees'];
            foreach($fees as $fee){
                $woocommerce->cart->add_fee( $fee['fee_name'], $fee['fee_amount'], true, 'standard' );  
            }

        }
        

    }

    /**
     * 
     * 
     * edit_discount_name
     * @since 1.2.0
     * @param
     * @return
     * 
     */
    public function edit_discount_name( $sprintf, $coupon )
    {

        if(WC()->session->get('thsa_on_process_quotation')){
            _e('Discount', 'thsa-quote-generator');
        }else{
            echo $sprintf;
        }

    }

    /**
     * 
     * 
     * plan_item_prices
     * @since 1.2.0
     * @param obj
     * @return
     * 
     */
    public function plan_item_prices( $cart ){
        // This is necessary for WC 3.0+
        if ( is_admin() && ! defined( 'DOING_AJAX' ) )
            return;

        // Avoiding hook repetition (when using price calculations for example | optional)
        if ( did_action( 'woocommerce_before_calculate_totals' ) >= 2 )
            return;
        
        if(WC()->session->get('thsa_on_process_quotation')){
            // Loop through cart items
            foreach ( $cart->get_cart() as $cart_item ) {
                
                $get_tags = (array) wp_get_object_terms( $cart_item['product_id'], $this->product_tag );
                $get_tags = (array) $get_tags[0];
                $it_has = ( in_array($this->quote_slug_tag, $get_tags) )? true : false;
                if(!$it_has){
                    $cart_item['data']->set_price( 0 );
                }
                
            }
        }
    }
    
    /**
     *
     * 
     * plan_item_prices_display
     * @since 1.2.0
     * @param string //html to display
     * @param obj //cart item data
     * @param string //cart item key
     * @param bool //if override
     * @return string
     * 
     * 
     */

     public function plan_item_prices_display( $price_html, $cart_item, $cart_item_key, $override = false )
     {
        if( WC()->session->get('thsa_on_process_quotation') ) {

            $get_tags = (array) wp_get_object_terms( $cart_item['product_id'], $this->product_tag );

            if(isset($get_tags[0])){
                $get_tags = (array) $get_tags[0];
                $it_has = ( in_array($this->quote_slug_tag, $get_tags) )? true : false;
            }else{
                $it_has = false;
            }
            

            if(!$it_has){
                return 'included';
            }

        }
        return $price_html;
     }


}

?>