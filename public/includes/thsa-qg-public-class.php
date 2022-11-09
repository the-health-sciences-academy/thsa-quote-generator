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
    }

}

?>