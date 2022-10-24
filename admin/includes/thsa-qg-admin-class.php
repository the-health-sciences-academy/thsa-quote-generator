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

class thsa_qg_admin_class extends thsa_qg_common_class{

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
        //load common js
        add_action('admin_enqueue_scripts', [$this, 'load_admin_assets']);

        //register post type
        add_action('init', [$this, 'register_post_type']);

        //register meta
        add_action('add_meta_boxes', [$this, 'meta_box']);

        $this->load_ajax();
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

        //load thsa js global variables
        wp_localize_script( THSA_QG_PREFIX.'-admin-js', 'thsaqgvars', 
            [
                'ajaxurl' => admin_url( 'admin-ajax.php' ),
                'nonce' => wp_create_nonce( 'thsa-quotation-generator' ),
                'customer_action' => 'thsa_qg_customer_list'
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
            'Client Details',
            [$this, 'customer_details'],
            'thsa-quote-generator',
            'normal',
            'high'
        );
    }


    /**
     * 
     * client_details
     * @since 1.2.0
     * @param
     * @return
     * 
     * 
     */
    public function customer_details($post)
    {
        $this->set_template('customer-details',['path' => 'admin']);
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

}

?>