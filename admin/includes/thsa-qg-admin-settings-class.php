<?php 
/**
 * 
 * 
 * thsa_qg_settings
 * @since 1.2.0
 * @author thsa
 * 
 * 
 */
namespace thsa\qg\admin\settings;
use thsa\qg\common\thsa_qg_common_class;

defined( 'ABSPATH' ) or die( 'No access area' );

class thsa_qg_admin_settings_class extends thsa_qg_common_class
{ 

    /**
     * 
     * default email message
     * 
     */
    public $default_email_text = null;

    /**
     * 
     * default admin email
     * 
     */
    public $default_admin_email = null;

    /**
     * 
     * default email title
     * 
     */
    public $default_email_title = null;


    /**
     * 
     * shortcodes
     * 
     */
    public $shortcodes = [
        '[thsa_qg_customer_name]',
        '[thsa_qg_quotation_holder]'
    ];

    public function __construct()
    {
        //add custom menu
        add_action('admin_menu',[$this, 'submenu']);

        wp_register_script( THSA_QG_PREFIX.'-admin-settings-js', THSA_QG_PLUGIN_URL.'admin/assets/js/thsa-qg-settings.js', array('jquery') );
        wp_enqueue_script( THSA_QG_PREFIX.'-admin-settings-js' );
        wp_enqueue_style( THSA_QG_PREFIX.'-admin-settings-css', THSA_QG_PLUGIN_URL.'admin/assets/css/thsa-qg-settings.css');


        $this->default_email_text = "Hi ".$this->shortcodes[0].",\n\nKindly find below the quotation you requested \n\n".$this->shortcodes[1]."\n\n Any questions or concerns please contact us through this email ".get_bloginfo('admin_email')."\n\nRegards,\n".get_bloginfo('site_name');

        $this->defaul_admin_email = get_bloginfo('admin_email');

        $this->default_email_title = get_bloginfo('site_title').__(' - Quotation','thsa_quote_generator');

        add_action('wp_ajax_thsa_qg_save_settings', [$this, 'thsa_qg_save_settings']);
    }

    /**
     * 
     * 
     * submenu
     * @since 1.2.0
     * @param
     * @return
     * 
     * 
     */
    public function submenu()
    {
        add_submenu_page(
            'edit.php?post_type=thsa-quote-generator',
            __( 'Settings', 'thsa_quote_generator' ),
            __( 'Settings', 'thsa_quote_generator' ),
            'manage_options',
            'thsaqgettings',
            [$this, 'settings']
        );

        add_submenu_page(
            'edit.php?post_type=thsa-quote-generator',
            __( 'About', 'thsa_quote_generator' ),
            __( 'About', 'thsa_quote_generator' ),
            'manage_options',
            'thsaqgabout',
            [$this, 'about']
        );
    }

    /**
     * 
     * get_settings
     * @since 1.2.0
     * @param string - type of settings
     * @return - array
     * 
     */
    public function get_settings($type = null)
    {   
        if(!$type)
            return;

        $settings = get_option('thsa_quotation_settings');

        if(isset($settings[$type])){
            return $settings[$type];
        }else{
            return;
        }
    }

    /**
     * 
     * settings
     * @since 1.2.0
     * @param
     * @return
     * 
     * 
     */
    public function settings()
    {
        $this->set_template('settings',['path' => 'admin']);
    }

    /**
     * 
     * about
     * @since 1.2.0
     * @param
     * @return
     * 
     * 
     */
    public function about()
    {
        $this->set_template('about',['path' => 'admin']);
    }

    /**
     * 
     * general_settings
     * @since 1.2.0
     * @param
     * @return
     * 
     */
    public function general_settings()
    {
        $args = [
            'posts_per_page' => -1,
            'post_type' => 'page',
            'post_status' => 'publish'
        ];
        $pages = get_posts($args);
        $settings = $this->get_settings('general');
        $this->set_template('part-settings/part-general',['path' => 'admin', 'pages' => $pages, 'settings' => $settings]);
    }

    /**
     * 
     * 
     * email_settings
     * @since 1.2.0
     * @param
     * @return
     * 
     * 
     */
    public function email_settings()
    {
        $this->set_template('part-settings/part-email',
            [
                'path' => 'admin', 
                'message' => $this->default_email_text, 
                'email' => $this->defaul_admin_email,
                'title' => $this->default_email_title,
                'shortcodes' => $this->shortcodes
            ]
        );
    }

    /**
     * 
     * quote_settings
     * @since 1.2.0
     * @param
     * @return
     * 
     */
    public function quote_settings()
    {
        $this->set_template('part-settings/part-quotation',
        [
            'path' => 'admin'
        ]   
        );
    }

    /**
     * 
     * thsa_qg_save_settings
     * @since 1.2.0
     * @param
     * @return
     * 
     * 
     */
    public function thsa_qg_save_settings()
    {
        if ( ! wp_verify_nonce( $_POST['nonce'], 'thsa-quotation-generator' ) ) {
            echo json_encode([
                'status' => 'failed',
                'message' => 'Error 105: Invalid Nonce'
            ]);
            exit();
        }

        if(isset($_POST['type'])){
            $general = [];
            if(isset($_POST['checkout'])){
                $general['checkout'] = sanitize_text_field($_POST['checkout']);
            }

            if(isset($_POST['round'])){
                $general['round'] = sanitize_text_field($_POST['round']);
            }

            if(isset($_POST['decimal'])){
                $general['decimal'] = sanitize_text_field($_POST['decimal']);
            }

            $settings = get_option('thsa_quotation_settings');
            if(!empty($general)){
                //get exists
                if(isset($settings)){
                    $settings['general'] = $general;
                    update_option('thsa_quotation_settings', $settings);
                }
            }else{
                $settings['general'] = null;
                update_option('thsa_quotation_settings', $settings);
            }

            echo json_encode([
                'status' => 'success',
                'message' => ''
            ]);
            exit();

        }else{
            echo json_encode([
                'status' => 'failed',
                'message' => 'Error 106: No type found'
            ]);
            exit();
        }
        exit();
    }
}

?>