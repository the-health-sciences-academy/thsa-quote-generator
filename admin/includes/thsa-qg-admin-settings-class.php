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
        $email = $this->get_settings('email');
        $this->set_template('part-settings/part-email',
            [
                'path' => 'admin', 
                'message' => (isset($email['content']))? $email['content'] : $this->default_email_text, 
                'email' => (isset($email['from_email']))? $email['from_email'] : $this->defaul_admin_email,
                'title' => (isset($email['title']))? $email['title'] : $this->default_email_title,
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
     * 
     * subscription_settings
     * @since 1.2.0
     * @param
     * @return
     * 
     * 
     */
    public function subscription_settings()
    {
        $this->set_template('part-settings/part-subscription',
        [
            'path' => 'admin'
        ]   
        );
    }

    /**
     * 
     * 
     * coupon_settings
     * @since 1.2.0
     * @param
     * @return
     * 
     */
    public function coupon_settings()
    {
        $args = [
            'posts_per_page' => -1,
            'post_type' => 'product',
            'order' => 'ASC',
            'orderby' => 'post_title',
            'post_status' => 'publish'
        ];
        $products = get_posts($args);
        $products_ = [];
        if(!empty($products)){
            foreach($products as $prod){
                $products_[] = [
                    'id' => $prod->ID,
                    'title'=> $prod->post_title
                ];
            }
        }

        $settings = get_option('thsa_quotation_settings');
        $this->set_template('part-settings/part-coupon',
        [
            'path' => 'admin',
            'products' => $products_,
            'settings' => $settings['coupon']
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


            switch($_POST['type']){
                case 'general':
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

                    break;
                case 'coupon':
                    $coupon = [];

                    if(isset($_POST['individual_usage'])){
                        $coupon['individual_usage'] = sanitize_text_field($_POST['individual_usage']);
                    }
                    if(isset($_POST['product_ids'])){
                        $coupon['product_ids'] = sanitize_text_field($_POST['product_ids']);
                    }
                    if(isset($_POST['exclude_ids'])){
                        $coupon['exclude_ids'] = sanitize_text_field($_POST['exclude_ids']);
                    }
                    if(isset($_POST['usage_limit'])){
                        $coupon['usage_limit'] = sanitize_text_field($_POST['usage_limit']);
                    }
                    if(isset($_POST['expiry_date'])){
                        $coupon['expiry_date'] = sanitize_text_field($_POST['expiry_date']);
                    }
                    if(isset($_POST['before_tax'])){
                        $coupon['before_tax'] = sanitize_text_field($_POST['before_tax']);
                    }
                    if(isset($_POST['free_shipping'])){
                        $coupon['free_shipping'] = sanitize_text_field($_POST['free_shipping']);
                    }

                    $settings = get_option('thsa_quotation_settings');
                    if(!empty($coupon)){
                        $settings['coupon'] = $coupon;
                    }else{
                        $settings['coupon'] = null;
                    }
                    update_option('thsa_quotation_settings', $settings);
                    

                    break;
                case 'email':

                    $email_data = [];
                    if(isset($_POST['from_email'])){
                        $email_data['from_email'] =  sanitize_text_field($_POST['from_email']);
                    }

                    if(isset($_POST['title'])){
                        $email_data['title'] =  sanitize_text_field($_POST['title']);
                    }

                    if(isset($_POST['content'])){
                        $_POST['content'] = stripslashes($_POST['content']);
                        $email_data['content'] =  sanitize_text_field(htmlentities($_POST['content']));
                    }


                    $settings = get_option('thsa_quotation_settings');
                    if(!empty($email_data)){
                        //get exists
                        if(isset($settings)){
                            $settings['email'] = $email_data;
                            update_option('thsa_quotation_settings', $settings);
                        }
                    }else{
                        $settings['email'] = null;
                        update_option('thsa_quotation_settings', $settings);
                    } 

                    break;
                default:
                    break;
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