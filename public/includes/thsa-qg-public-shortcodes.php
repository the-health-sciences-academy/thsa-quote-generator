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
            $content = __('#Error: No quotation ID available','thsa_quote_generator');


        if(isset($_GET['q_id'])){
            $attr = [];
            $attr['id'] = sanitize_text_field($_GET['q_id']);
        }

        if(isset($attr['id'])){

            $res = $this->render_quotation($attr['id']);

            if( is_array($res) ){
                ob_start();
                    $this->set_template('shortcodes/quotation', $res );
                return ob_get_clean();
            }else{
                ob_start();
                    echo $res;
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