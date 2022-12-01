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
    
    public function __construct()
    {
        add_action('admin_init', [$this, 'set_temp_currency'] );
    }

    /**
     * 
     * 
     * set_temp_currency
     * @since 1.2.0
     * @param
     * @return
     * 
     */
    public function set_temp_currency()
    {
        if(isset($_GET['temp_currency'])){
            
            $tem_cur = sanitize_text_field($_GET['temp_currency']);
            $screen = get_current_screen();
            if ( isset($screen->parent_base) ) {
                if($screen->parent_base == 'edit' ){
                    $get_id = $_POST['post'];
                    if(get_post_type($get_id) != 'thsa-quote-generator'){
                        delete_option('thsa_qg_temp_currency');
                        return;
                    } 
                }else{
                    delete_option('thsa_qg_temp_currency');
                    return;
                }
                
            }else{
                $post_type = isset( $_GET['post_type'] )? $_GET['post_type'] : null;
                if($post_type != 'thsa-quote-generator'){
                    delete_option('thsa_qg_temp_currency');
                    return;
                }
               
            }
            update_option('thsa_qg_temp_currency', $tem_cur);

        }else{
            
            delete_option('thsa_qg_temp_currency');
        
        }

        /**
         * 
         * Plugin Name: aelia currency switcher
         * @since 1.2.0
         * 
         */
        if ( is_plugin_active( 'woocommerce-aelia-currencyswitcher/woocommerce-aelia-currencyswitcher.php' ) ) {
            add_filter('wc_aelia_cs_selected_currency', [$this, 'change_currency'], 10, 1);
        } 
    }

    /**
     * 
     * 
     * change_currency
     * @since 1.2.0
     * @param
     * @return
     * 
     * 
     */
    public function change_currency( $selected_currency )
    {   
        $get_temp_currency = get_option('thsa_qg_temp_currency');
        $selected_currency = ($get_temp_currency != '')? $get_temp_currency : $selected_currency;
        return $selected_currency;
    }

}



?>