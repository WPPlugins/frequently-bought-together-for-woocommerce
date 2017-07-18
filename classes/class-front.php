<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	global $product;

	// get meta for current product
	$group  = unserialize(get_post_meta( $product->id, '_fbtw_input_ids', true ));

	if( empty( $group ) || $product->product_type == 'grouped' || $product->product_type == 'external' ) {
		return;
	}

	$product_id = $product->id;

	if( $product->product_type == 'variable' ) {

		$variations = $product->get_children();

		if( empty( $variations ) ) {
			return;
		}
		// get first product variation
		$product_id = array_shift( $variations );
	}

	// merge array
	$group = array_merge( array( $product_id ), $group );
	
	//print_r($group);
	
	//echo freq_brought_plugin_dir_url . 'templates/';
	
	woocommerce_get_template( 'front_form_template.php',$group, 'ph-fbtw', plugin_dir_path( dirname( __FILE__ ) )  . '/templates/' );
		
?>
