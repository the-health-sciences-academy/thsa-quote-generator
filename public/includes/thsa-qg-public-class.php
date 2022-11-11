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

        wp_localize_script( THSA_QG_PREFIX.'-public-js', 'thsaqg_public_vars',
            [
                'thsa_qg_checkout_url'           =>  site_url().'/checkout?quotation=',
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

            $qid = sanitize_text_field($_GET['quotation']);
            $quote = get_post_meta($qid,'thsa_quotation_data',true);

            if(isset($quote['customer'])){

                if(isset($quote['products'])){
                    //clear cart first
                    global $woocommerce;
                    $woocommerce->cart->empty_cart();

                    //add products to cart
                    foreach($quote['products'] as $pid){    
                        WC()->cart->add_to_cart( $pid[0], $pid[1]);
                    }

                    //apply coupon
                    $coupon_code = 'quotation-'.$qid;
                    if (!$woocommerce->cart->add_discount( sanitize_text_field( $coupon_code )))
                        $woocommerce->show_messages();


              
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
    public function edit_discount_name($sprintf, $coupon)
    {

        if(WC()->session->get('thsa_on_process_quotation')){
            echo 'Discount';
        }else{
            echo $sprintf;
        }

    }

}

?>