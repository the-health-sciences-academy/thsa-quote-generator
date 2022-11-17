<?php 
/**
 * 
 * 
 * thsa_qg_admin
 * @since 1.2.0
 * @author thsa
 * 
 * 
 */
namespace thsa\qg\public\shortcodes;
use thsa\qg\common\thsa_qg_common_class;

defined( 'ABSPATH' ) or die( 'No access area' );

class thsa_qg_public_shortcodes extends thsa_qg_common_class
{
    public function __construct()
    {
        add_shortcode('thsa_qg_customer_name', [$this, 'customer_name']);
        add_shortcode('thsa-quotation', [$this, 'quotation']);
    }

    /**
     * 
     * customer_name
     * @since 1.2.0
     * @param array
     * @return string
     * 
     * 
     */
    public function customer_name($attr)
    {
        $content = null;

        if(empty($attr))
            $content = __('#Error: No customer ID were found','thsa_quote_generator');

        if(isset($attr['id'])){
            $details = get_userdata($attr['id']);
            $content = $details->first_name.' '.$details->last_name;
        }

        ob_start();
            echo $content;
        return ob_get_clean();
    }

    /**
     * 
     * 
     * quotation
     * @since 1.2.0
     * @param array
     * @return html
     * 
     * 
     */
    public function quotation($attr)
    {
        $content = null;
        if(empty($attr))
            $content = __('#Error: No quotation ID were found','thsa_quote_generator');


        if(isset($_GET['q_id'])){
            $attr = [];
            $attr['id'] = sanitize_text_field($_GET['q_id']);
        }

        if(isset($attr['id'])){
            $quote = get_post_meta($attr['id'],'thsa_quotation_data',true);
            if($quote){
                //get products
                $products = [];
                $total = 0;
                if(!empty($quote['products'])){
                    foreach($quote['products'] as $product){
                        $product_details = wc_get_product($product[0]);

                        $total = $total + ($product_details->get_price() * $product[1]);
                        $products[$product[0]] = [
                            'id' => $product_details->get_id(),
                            'text' => $product_details->get_title(),
                            'price_html' => $product_details->get_price_html(),
                            'price_number' => $product_details->get_price(),
                            'price_regular_number' => $product_details->get_regular_price(),
                            'price_sale_number' => $product_details->get_sale_price(),
                            'qty' => $product[1],
                            'amount' => $product_details->get_price() * $product[1]
                        ];
                    }
                }

                $discount = ($quote['fixed_amount_discount'])? $quote['fixed_amount_discount'] : 0;
                $discounted_total = $total - $discount;

                //fees
                $fees = 0;
                if(isset($quote['fees'])){
                    foreach($quote['fees'] as $fee){
                        $fee_ = ($fee['fee_amount'])? $fee['fee_amount'] : 0;
                        $fees += $fee_;
                    }
                }
                $quote['fees'];
                $grand_total = $discounted_total + $fees;

                ob_start();
                    $this->set_template('shortcodes/quotation', [
                        'path' => 'public', 
                        'products' => $products, 
                        'data' => $quote,
                        'grand_total' => $grand_total, 
                        'undiscounted' => $total,
                        'qid' => $attr['id']
                    ]
                );
                return ob_get_clean();
            }else{
                ob_start();
                    echo __('#Error: No quotation were found','thsa_quote_generator');
                return ob_get_clean();
            }
        }else{
            ob_start();
                echo $content;
            return ob_get_clean();
        }
        
    }
}
?>