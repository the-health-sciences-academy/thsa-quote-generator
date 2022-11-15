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
namespace thsa\qg\admin;
use thsa\qg\common\thsa_qg_common_class;
use thsa\qg\admin\settings as qgsettings;
use thsa\qg\admin\shortcodes  as qgshortcodes;

defined( 'ABSPATH' ) or die( 'No access area' );

class thsa_qg_admin_class extends thsa_qg_common_class{

    private $product_post_type = 'product';

    private $product_category = 'product_cat';

    private $product_tag = 'product_tag';


    public $setting_class = null;

    /**
     * 
     * 
     * qg admin flag
     * @since 1.2.0
     * 
     */
    private $admin_page = '';

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
        $this->setting_class = new qgsettings\thsa_qg_admin_settings_class();

        //load common js
        add_action('admin_enqueue_scripts', [$this, 'load_admin_assets']);

        //register post type
        add_action('init', [$this, 'register_post_type']);

        //register meta
        add_action('add_meta_boxes', [$this, 'meta_box']);

        $this->load_ajax();

        //save data
        add_action('save_post_thsa-quote-generator', [$this, 'save_quote']);


    }

    /**
     * 
     * 
     * load_admin_assets
     * @since 1.2.0
     * 
     */
    public function load_admin_assets()
    {

        $this->load_js();
        wp_register_script( THSA_QG_PREFIX.'-admin-js', THSA_QG_PLUGIN_URL.'admin/assets/js/thsa-qg-admin.js', array('jquery') );
        wp_enqueue_script( THSA_QG_PREFIX.'-admin-js' );
        wp_enqueue_style( THSA_QG_PREFIX.'-admin-css', THSA_QG_PLUGIN_URL.'admin/assets/css/thsa-qg-admin.css');

        
        $general_settings = $this->setting_class->get_settings('general');

        $default_round = ['round' => 'off', 'decimal' => 0];
        if(isset($general_settings)){
            $default_round = [
                'round' => $general_settings['round'],
                'decimal' => $general_settings['decimal']
            ];
        }

        //load thsa js global variables
        wp_localize_script( THSA_QG_PREFIX.'-admin-js', 'thsaqgvars', 
            [
                'ajaxurl'           =>  admin_url( 'admin-ajax.php' ),
                'nonce'             =>  wp_create_nonce( 'thsa-quotation-generator' ),
                'customer_action'   =>  'thsa_qg_customer_list',
                'customer_details'  =>  'thsa_qg_customer_details',
                'product_options'   =>  'thsa_qg_product_select_options',
                'product_from_cat'  =>  'thsa_qg_product_from_cat',
                'labels'            =>  $this->labels(),
                'save_settings'     => 'thsa_qg_save_settings',
                'round_settings'    => json_encode($default_round)
            ]
        );

        //load woo's select2
        wp_enqueue_script('selectWoo');
        //load woos admin styling
        wp_enqueue_style('woocommerce_admin_styles');
        
    }
    

    /**
     * 
     * 
     * load_ajax
     * @since 1.2.0
     * @param
     * @return
     * 
     * 
     */
    public function load_ajax()
    {
        add_action('wp_ajax_thsa_qg_customer_list', [$this, 'thsa_qg_customer_list']);
        add_action('wp_ajax_thsa_qg_customer_details', [$this, 'thsa_qg_customer_details']);
        add_action('wp_ajax_thsa_qg_product_select_options', [$this, 'thsa_qg_product_select_options']);
        add_action('wp_ajax_thsa_qg_product_from_cat', [$this, 'thsa_qg_product_from_cat']);
    }


    /**
     * 
     * 
     * register_post_type
     * @since 1.2.0
     * @param
     * @return
     * 
     * 
     */
    function register_post_type() {
		$labels = array(
			'name'               => _x( 'Quotation Generator', 'Quotation Generator', 'thsa-quote-generator' ),
			'singular_name'      => _x( 'Quotation Generator', 'Quotation Generator', 'thsa-quote-generator' ),
			'menu_name'          => _x( 'Quotation Generator', 'thsa-quote-generator', 'thsa-quote-generator' ),
			'name_admin_bar'     => _x( 'Quotation Generator', 'Quotation Generator', 'thsa-quote-generator' ),
			'add_new'            => _x( 'Add New', 'Add New Quotation Generator', 'thsa-quote-generator' ),
			'add_new_item'       => __( 'Add New Quotation Generator', 'thsa-quote-generator' ),
			'new_item'           => __( 'New Quotation Generator', 'thsa-quote-generator' ),
			'edit_item'          => __( 'Edit Quotation Generator', 'thsa-quote-generator' ),
			'view_item'          => __( 'View Quotation Generator', 'thsa-quote-generator' ),
			'all_items'          => __( 'All Quotation Generator', 'thsa-quote-generator' ),
			'search_items'       => __( 'Search Quotation Generator', 'thsa-quote-generator' ),
			'parent_item_colon'  => __( 'Parent Quotation Generator', 'thsa-quote-generator' ),
			'not_found'          => __( 'No Quotation Generator found.', 'thsa-quote-generator' ),
			'not_found_in_trash' => __( 'No Quotation Generator found in Trash.', 'thsa-quote-generator' )
		);

		$args = array(
			'labels'             => $labels,
	        'description'        => __( 'Description.', 'thsa-quote-generator' ),
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => false,
			'rewrite'            => array( 'slug' => 'thsa-quote-generator' ),
			'menu_icon'			 => 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxNS4xLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB3aWR0aD0iNTAwcHgiIGhlaWdodD0iNTAwcHgiIHZpZXdCb3g9IjAgMCA1MDAgNTAwIiBlbmFibGUtYmFja2dyb3VuZD0ibmV3IDAgMCA1MDAgNTAwIiB4bWw6c3BhY2U9InByZXNlcnZlIj4NCjxwYXRoIGZpbGw9IiNBN0FBQUQiIGQ9Ik0yNTAsMi44NzNDMTEzLjUxNiwyLjg3MywyLjg3MywxMTMuNTE2LDIuODczLDI0OS45OTljMCwxMzYuNDg0LDExMC42NDMsMjQ3LjEyNywyNDcuMTI3LDI0Ny4xMjcNCglzMjQ3LjEyNi0xMTAuNjQzLDI0Ny4xMjYtMjQ3LjEyN0M0OTcuMTI2LDExMy41MTYsMzg2LjQ4NCwyLjg3MywyNTAsMi44NzN6IE0yMDksMTcyLjU5OEMxOTAsMTgwLjg3LDE3OS43ODEsMjAwLDE3OS43ODEsMjI4SDIwOQ0KCXYxMjFoLTgxdi04Ni43MzljMC04Ni40ODEsMjctMTMyLjExLDgxLTEzNi44OFYxNzIuNTk4eiBNMzU3LDE3Mi41OThDMzM4LDE4MC44NywzMjguMjA1LDIwMCwzMjguMjA1LDIyOEgzNTd2MTIxaC04MXYtODYuNzM5DQoJYzAtODYuNDgxLDI3LTEzMi4xMSw4MS0xMzYuODhWMTcyLjU5OHoiLz4NCjwvc3ZnPg0K',
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => 25,
			'supports'           => array( 'title', 'thumbnail' )
		);
		register_post_type( 'thsa-quote-generator', $args );
	}


    /**
     * 
     * 
     * client_meta
     * @since 1.2.0
     * @param
     * @return
     * 
     * 
     */

    public function meta_box()
    {
        add_meta_box(
            'thsa_qg_client_meta',
            __('Quotation Builder', 'thsa_quote_generator'),
            [$this, 'quote_meta_section'],
            'thsa-quote-generator',
            'normal',
            'high'
        );

        add_meta_box(
            'thsa_qg_currency',
            __('Currency', 'thsa_quote_generator'),
            [$this, 'currency_options'],
            'thsa-quote-generator',
            'side',
            'high'
        );

        add_meta_box(
            'thsa_qg_action',
            __('Action', 'thsa_quote_generator'),
            [$this, 'customer_action'],
            'thsa-quote-generator',
            'side',
            'high'
        );

        add_meta_box(
            'thsa_qg_expiry',
            __('Expiry', 'thsa_quote_generator'),
            [$this, 'customer_expiry'],
            'thsa-quote-generator',
            'side',
            'high'
        );

        add_meta_box(
            'thsa_qg_shortcode',
            __('Shortcode', 'thsa_quote_generator'),
            [$this, 'customer_shortcode'],
            'thsa-quote-generator',
            'side',
            'high'
        );

    }

    /**
     * 
     * quote_meta_section
     * @since 1.2.0
     * @param
     * @return
     * 
     * 
     */
    public function quote_meta_section($post)
    {
        $data = get_post_meta($post->ID,'thsa_quotation_data',true);
        
        //get student details
        $customer = [];
        $tab = 'new';
        $customer_ = (isset($data['customer']))? $data['customer'] : null;

        
        
        if(!is_array($customer_) && $customer_){
            $user_id = $data['customer'];
            $customer_details = get_userdata($user_id);
            $billing =  get_user_meta( $user_id, 'billing_address_1', true ); 
            $billing_city = get_user_meta( $user_id, 'billing_city', true ); 
            $billing_postcode = get_user_meta( $user_id, 'billing_postcode', true ); 
            $billing_country = get_user_meta( $user_id, 'billing_country', true ); 
            $billing_state = get_user_meta( $user_id, 'billing_state', true ); 
            $billing = $billing.'<br/>'.$billing_postcode.', '.$billing_city.'<br/>'.$billing_state.', '.$billing_country;
            $customer = [ 
                'fullname' => $customer_details->first_name.' '.$customer_details->last_name,
                'email_address' => $customer_details->user_email,
                'billing_address' => $billing
            ];
            $tab = 'exist';
        
        }elseif(isset($data['customer'])){
            $customer = [
                'firstname' => $data['customer']['firstname'],
                'lastname' => $data['customer']['lastname'],
                'email' => $data['customer']['email']
            ];
        }

        //get products
        $products = [];
        if(!empty($data['products'])){
            foreach($data['products'] as $product){
                $product_details = wc_get_product($product[0]);
                $products[$product[0]] = [
                    'id' => $product_details->get_id(),
                    'text' => $product_details->get_id().' - '.$product_details->get_title(),
                    'price_html' => $product_details->get_price_html(),
                    'price_number' => $product_details->get_price(),
                    'price_regular_number' => $product_details->get_regular_price(),
                    'price_sale_number' => $product_details->get_sale_price(),
                    'qty' => $product[1],
                    'amount' => $product_details->get_price() * $product[1]
                ];
                
            }
        }

       

        $this->set_template('customer-details',['path' => 'admin', 'post' => $post, 'data' => $customer, 'tab' =>  $tab]);
        $this->set_template('products',['path' => 'admin', 'products' => $products]);
        $this->set_template('discounts',['path' => 'admin','data' => $data]);
        $this->set_template('fees',['path' => 'admin', 'data' => $data]);
        $this->set_template('summary',['path' => 'admin', 'data' => $data]);
    }

    /**
     * 
     * 
     * currency_options
     * @since 1.2.0
     * @param
     * @return
     * 
     * 
     */
    public function currency_options($post)
    {
        $currency = get_post_meta($post->ID,'thsa_quotation_data',true);
        if(!empty($currency['currency'])){
            //do nothing
            $current = $currency['currency'];
        }else{
            $current = get_woocommerce_currency();
        }
        $currencies = get_woocommerce_currencies();
        
        $this->set_template('currency',['path' => 'admin', 'currency' => $currencies, 'current' => $current]);
    }


    /**
     * 
     * customer_action
     * @since 1.2,0
     * @param
     * @return
     * 
     */
    public function customer_action()
    {
        $this->set_template('action',['path' => 'admin']);
    }

    /**
     * 
     * 
     * customer_expiry
     * @since 1.2.0
     * @param
     * @return
     * 
     * 
     */
    public function customer_expiry()
    {
        $this->set_template('expiry',['path' => 'admin']);
    }


    /**
     * 
     * 
     * customer_shortcode
     * @since 1.2.0
     * @param
     * @return
     * 
     * 
     */
    public function customer_shortcode($post)
    {
        $data = get_post_meta($post->ID,'thsa_quotation_data',true);
        $shortcode = null;
        if(isset($data['customer'])){
            $shortcode = htmlentities('[thsa-quotation id="'.$post->ID.'"]');
        }
        $this->set_template('shortcode',['path' => 'admin','shortcode' => $shortcode]);
    }


    /**
     * 
     * 
     * thsa_qg_customer_list
     * @since 1.2.0
     * @param
     * @return
     * 
     * 
     */
    public function thsa_qg_customer_list()
    {
        if ( ! wp_verify_nonce( $_GET['nonce'], 'thsa-quotation-generator' ) ) {
            echo json_encode([
                'status' => 'failed',
                'message' => 'Error 105: Invalid Nonce'
            ]);
            exit();
        }

        $user_s = sanitize_text_field($_GET['search']);

        $users = get_users( [ 'search' => $user_s ] );
        $data = [];

        if($users){
            foreach($users as $user){
                $data[] = [
                    'id' => $user->ID,
                    'text' => $user->display_name
                ];
            }
        }

        echo json_encode($data);
        exit();

    }


    /**
     * 
     * 
     * thsa_qg_customer_details
     * @since 1.2.0
     * @param
     * @return
     * 
     * 
     * 
     */
    public function thsa_qg_customer_details()
    {
        if ( ! wp_verify_nonce( $_POST['nonce'], 'thsa-quotation-generator' ) ) {
            echo json_encode([
                'status' => 'failed',
                'message' => 'Error 105: Invalid Nonce'
            ]);
            exit();
        }

        $id = sanitize_text_field($_POST['id']);
        $details = get_userdata($id);
        if($details){
            $billing = get_user_meta( $id, 'billing_address_1', true ); 
            $billing_city = get_user_meta( $id, 'billing_city', true ); 
            $billing_postcode = get_user_meta( $id, 'billing_postcode', true ); 
            $billing_country = get_user_meta( $id, 'billing_country', true ); 
            $billing_state = get_user_meta( $id, 'billing_state', true ); 
            $billing = $billing.'<br/>'.$billing_postcode.', '.$billing_city.'<br/>'.$billing_state.', '.$billing_country;
            echo json_encode(
                [
                    'ID' => $details->ID,
                    'fullname' => $details->first_name.' '.$details->last_name,
                    'email_address' => $details->user_email,
                    'billing_address' => $billing
                ]
            );
        }
        exit();
    }

    /**
     * 
     * 
     * thsa_qg_product_select_options
     * @since 1.2.0
     * @param
     * @return
     * 
     * 
     */
    public function thsa_qg_product_select_options()
    {
        if ( ! wp_verify_nonce( $_GET['nonce'], 'thsa-quotation-generator' ) ) {
            echo json_encode([
                'status' => 'failed',
                'message' => 'Error 105: Invalid Nonce'
            ]);
            exit();
        }
        
        $s = sanitize_text_field($_GET['search']);
        $type = sanitize_text_field($_GET['filter']);

        switch($type){
            case 'product':
                echo $this->product_filter($s);
                break;
            case 'category':
                echo $this->category_filter($s);
                break;
            case 'tag':
                echo $this->tag_filter($s);
                break;
        }

        exit();
       
    }

    /**
     * 
     * 
     * product_filter
     * @since 1.2.0
     * @param string
     * @return json
     * 
     * 
     * 
     */
    public function product_filter($s)
    {
        $args = [
            'posts_per_page' => -1,
            'post_type' => $this->product_post_type,
            's' => $s,
            'order' => 'ASC',
            'orderby' => 'post_title',
            'post_status' => 'publish'
        ];

        $args = apply_filters('thsa_product_select_arg', $args);
        $products = get_posts($args);

        $data = [];
        if($products){
            foreach($products as $product){

                //extract details
                $product_ = wc_get_product($product->ID);

                $data[] = [
                    'id' => $product->ID,
                    'text' => $product->ID.' - '.$product->post_title,
                    'price_html' => $product_->get_price_html(),
                    'price_number' => $product_->get_price(),
                    'price_regular_number' => $product_->get_regular_price(),
                    'price_sale_number' => $product_->get_sale_price()
                ];
            }

            return json_encode($data);
        }

    }

    /**
     * 
     * 
     * thsa_qg_category_select_options
     * @since 1.2.0
     * @param
     * @return
     * 
     * 
     */

    public function category_filter($s)
    {

        $args = [
            'taxonomy' => $this->product_category,
            'hide_empty' => false,
            'search' => $s,
            'order' => 'ASC',
            'orderby' => 'name'
        ];

        $cats_ = [];
        $cats = get_terms($args);
        if($cats){
            foreach($cats as $cat){
                $cats_[] = [
                    'id' => $cat->term_id,
                    'text' => $cat->name
                ];
            }

            echo json_encode($cats_);
        }
        exit();
    }

     /**
     * 
     * 
     * thsa_qg_category_select_options
     * @since 1.2.0
     * @param
     * @return
     * 
     * 
     */

    public function tag_filter($s)
    {

        $args = [
            'taxonomy' => $this->product_tag,
            'hide_empty' => false,
            'search' => $s,
            'order' => 'ASC',
            'orderby' => 'name'
        ];

        $cats_ = [];
        $cats = get_terms($args);
        if($cats){
            foreach($cats as $cat){
                $cats_[] = [
                    'id' => $cat->term_id,
                    'text' => $cat->name
                ];
            }

            echo json_encode($cats_);
        }
        exit();
    }


    /**
     * 
     * 
     * thsa_qg_product_from_cat
     * @since 1.2.0
     * @param
     * @return json
     * 
     */
    public function thsa_qg_product_from_cat()
    {
        if ( ! wp_verify_nonce( $_POST['nonce'], 'thsa-quotation-generator' ) ) {
            echo json_encode([
                'status' => 'failed',
                'message' => 'Error 105: Invalid Nonce'
            ]);
            exit();
        }

        $cat = sanitize_text_field($_POST['term']);

        $taxon = ($_POST['type'] == 'category')? $this->product_category : $this->product_tag;

        if($cat){
            $args = [
                'posts_per_page' => -1,
                'post_type' => 'product',
                'tax_query' => [
                    [
                        'taxonomy' => $taxon,
                        'field' => 'term_id',
                        'terms' => $cat 
                    ]
                    ],
                'order' => 'ASC',
                'orderby' => 'post_title',
                'post_status' => 'publish'
            ];

            $products = get_posts($args);
            $data = [];
            if($products){
                foreach($products as $product){
                    $product_ = wc_get_product($product->ID);
                    $data[] = [
                        'id' => $product->ID,
                        'text' => $product->ID.' - '.$product->post_title,
                        'price_html' => $product_->get_price_html(),
                        'price_number' => $product_->get_price(),
                        'price_regular_number' => $product_->get_regular_price(),
                        'price_sale_number' => $product_->get_sale_price()
                    ];
                }

                echo json_encode($data);
            }
        }
        exit();
    }


    /**
     * 
     * save_quote
     * @since 1.2.0
     * @param int
     * @return
     * 
     */
    public function save_quote($post_id){
        
        $quote_data = [];

        //customer details
        $customer_type = (isset($_POST['thsa_qg_customer_type']))? $_POST['thsa_qg_customer_type'] : null;
        $customer_details = null;
        if($customer_type == 1){
            $customer_details = [
                'firstname' => sanitize_text_field($_POST['thsa_qg_customer_name']),
                'lastname'  => sanitize_text_field($_POST['thsa_qg_customer_lastname']),
                'email'     => sanitize_text_field($_POST['thsa_qg_customer_email'])  
            ];
        }else{
            $customer_id = (isset($_POST['thsa_qg_customer_select']))? $_POST['thsa_qg_customer_select'] : null;
            $customer_details = sanitize_text_field($customer_id);
        }

        if($customer_details){
            $quote_data['customer'] = $customer_details;
        }

        //currency
        $currency_ = (isset($_POST['thsa_qg_currency']))? $_POST['thsa_qg_currency'] : null;
        $quote_data['currency'] = sanitize_text_field($currency_);

        //products
        //sanitize product id
        $saved_products = [];
        if(!empty($_POST['thsa_qg_added_product'])){
            foreach($_POST['thsa_qg_added_product'] as $index => $product_id){
                $qty = sanitize_text_field($_POST['thsa_qg_added_product_qty'][$index]);
                $saved_products[] = [sanitize_text_field($product_id), $qty];
            }
            $quote_data['products'] = $saved_products;
        }

        $expiry = (!empty($_POST['thsa_qg_expiry']))? sanitize_text_field($_POST['thsa_qg_expiry']) : null;
        if($expiry){
            $quote_data['expiry'] = $expiry;
        }

        //discounts
        $payment_type = (!empty($_POST['thsa_qg_payment_type']))? sanitize_text_field($_POST['thsa_qg_payment_type']) : null;
        if($payment_type){
            $quote_data['payment_type'] = $payment_type;
        }

        $payment_type_edit = (!empty($_POST['allow_payment_type_edit']))? sanitize_text_field($_POST['allow_payment_type_edit']) : null;
        if($payment_type_edit){
            $quote_data['allow_payment_type_edit'] = $payment_type_edit;
        }

        $discount_amount = (!empty($_POST['thsa_qg_fix_amount']))? sanitize_text_field($_POST['thsa_qg_fix_amount']) : null; 
        if($discount_amount){
            $quote_data['fixed_amount_discount'] = $discount_amount;
        }

        $percent_discount = (!empty($_POST['thsa_qg_percent_amount']))? sanitize_text_field($_POST['thsa_qg_percent_amount']) : null;
        if($percent_discount){
            $quote_data['percent_amount_discount'] = $percent_discount;
        }

        $term_number = (!empty($_POST['thsa_qg_term_number']))? sanitize_text_field($_POST['thsa_qg_term_number']) : null;
        if($term_number){
            $quote_data['term_number'] = $term_number;
        }

        $plan_type = (!empty($_POST['thsa_qg_plan_term']))? sanitize_text_field($_POST['thsa_qg_plan_term']) : null;
        if($plan_type){
            $quote_data['term_plan_type'] = $plan_type;
        }

        $term_edit = (!empty($_POST['thsa_allow_term_edit']))? sanitize_text_field($_POST['thsa_allow_term_edit']) : null;
        if($term_edit){
            $quote_data['allow_term_edit'] = $term_edit;
        }

        //fees
        $fee_data = [];
        if(!empty($_POST['thsa_qg_added_fee'])){
            foreach($_POST['thsa_qg_added_fee'] as $fee){
                $fee_ = $this->sanitize_json($fee);
                $fee_data[] = $fee_;
            }
        }
        $quote_data['fees'] = (!empty($fee_data))? $fee_data : null;


        if(!empty($quote_data)){
            update_post_meta($post_id, 'thsa_quotation_data', $quote_data);
        }else{
            delete_post_meta($post_id, 'thsa_quotation_data');
        }

        //create coupon for quotation
        $code = 'quotation-'.$post_id;
        $this->generate_coupon($code, $discount_amount);

    }

    /**
     * 
     * 
     * generate_coupon
     * @since 1.2.0
     * @param $code string - name of coupon
     * @param $amount string - amount of coupon
     * @param $type string - type of coupon
     * @return
     * 
     * 
     */
    public function generate_coupon($code = null, $amount = null, $type = 'fixed_cart')
    {
        if(!$code || !$code)
            return;

        //check of code exist
        $code_id = wc_get_coupon_id_by_code($code);
        if($code_id > 0){
            //update instead
            update_post_meta( $code_id, 'coupon_amount', $amount );
            return;
        }
            

        $coupon_code = $code; // Code - perhaps generate this from the user ID + the order ID
        $amount = $amount; // Amount
        $discount_type = $type; // Type: fixed_cart, percent, fixed_product, percent_product

        $coupon = array(
            'post_title' => $coupon_code,
            'post_content' => '',
            'post_status' => 'publish',
            'post_author' => 1,
            'post_type'     => 'shop_coupon'
        );    

        $new_coupon_id = wp_insert_post( $coupon );

        // Add meta
        update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
        update_post_meta( $new_coupon_id, 'coupon_amount', $amount );
        update_post_meta( $new_coupon_id, 'individual_use', 'no' );
        update_post_meta( $new_coupon_id, 'product_ids', '' );
        update_post_meta( $new_coupon_id, 'exclude_product_ids', '' );
        update_post_meta( $new_coupon_id, 'usage_limit', '1' );
        update_post_meta( $new_coupon_id, 'expiry_date', '' );
        update_post_meta( $new_coupon_id, 'apply_before_tax', 'yes' );
        update_post_meta( $new_coupon_id, 'free_shipping', 'no' );

        return $new_coupon_id;
    }

}

?>