
//DEFAULT/Static parameters
		//update_post_meta( $new_product_id, '_tax_status', 'taxable' );//If needed
		update_post_meta( $new_product_id, '_manage_stock', 'no' );
		update_post_meta( $new_product_id, '_sold_individually', 'yes' );
		update_post_meta( $new_product_id, '_virtual', 'yes' );
		update_post_meta( $new_product_id, '_downloadable', 'no' );
		update_post_meta( $new_product_id, '_download_limit', "-1" );
		update_post_meta( $new_product_id, '_download_expiry', "-1" );
		update_post_meta( $new_product_id, '_stock', NULL );
		update_post_meta( $new_product_id, '_stock_status', 'instock' );
		update_post_meta( $new_product_id, 'woo_limit_one_select_dropdown', "1" );
		update_post_meta( $new_product_id, 'woo_limit_one_time_dropdown', 'all' );
		update_post_meta( $new_product_id, '_dependency_type', '3' );
		update_post_meta( $new_product_id, '_dependency_selection_type', 'new_product_ids' );
		//update_post_meta( $new_product_id, '_subscription_limit', 'active' );
		update_post_meta( $new_product_id, '_subscription_limit', 'no' );
		update_post_meta( $new_product_id, '_subscription_one_time_shipping', 'no' );