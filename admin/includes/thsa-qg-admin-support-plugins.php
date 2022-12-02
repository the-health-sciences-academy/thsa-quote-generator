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

}



?>