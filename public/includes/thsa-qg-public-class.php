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
                    
                }
                
            }

            
        }
        
    }

}

?>