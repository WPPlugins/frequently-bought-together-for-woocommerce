<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if( ! ( isset( $_REQUEST[ 'freq_brought_together' ] ) && is_numeric( $_REQUEST[ 'freq_brought_together' ] ) && wp_verify_nonce( $_REQUEST[ '_wpnonce' ], 'freq_brought_together_nonce' ) ) ) {
	return;
}

if( ! isset( $_POST['pro_id'] ) ) {
	return;
}

$messages = array();

$pro_id = isset( $_POST['pro_id'] ) ? 
                          wp_unslash( $_POST['pro_id'] ) :
                          array();

if ( is_array( $pro_id ) ) {
	
	foreach( $pro_id as $id ) {

		$product = wc_get_product( $id );

		$attr = array();
		$variation_id = '';
		$product_id = $product->id;

		if( $product->product_type == 'variation' ) {
			$attr           = $product->get_variation_attributes();
			$variation_id   = $product->variation_id;
		}

		if( WC()->cart->add_to_cart( $product_id, 1, $variation_id, $attr ) ) {
			$messages[] = $product_id;
		}
	}
}

if( ! empty( $messages ) ) {
	wc_add_to_cart_message( $messages );
}

if( get_option( 'woocommerce_cart_redirect_after_add' ) == 'yes' ) {
	wp_safe_redirect( WC()->cart->get_cart_url() );
	exit;
}
else {
	//redirect to product page
	$dest = remove_query_arg( array( 'freq_brought_together', '_wpnonce' ) );
	wp_redirect( esc_url( $dest ) );
	exit;
}
?>