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
        wp_enqueue_style( THSA_QG_PREFIX.'-public-css', THSA_QG_PLUGIN_URL.'public/assets/css/thsa-qg-public.css');
    }

}

?>