<?php
/*
Plugin Name: Frequently Bought Together For Woocommerce
Plugin URI: http://www.phoeniixx.com
Description: This plugin lets you display (on a product page) additional products that are frequently bought together, along with the given product.
Version: 1.5
Text Domain: ph-fbtw
Domain Path: /i18n/languages/
Author: phoeniixx
Author URI: http://www.phoeniixx.com
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
* Check if WooCommerce is active
**/

	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) 
	{
	 
		define("freq_brought_plugin_dir_url", esc_url( plugin_dir_url( __FILE__ ) ) );
		
		function freq_brought_plugin_settings_link($links) { 
	
		  $settings_link = '<a href="admin.php?page=freq_brought_together_setting">Settings</a>'; 
		  
		  array_unshift($links, $settings_link); 
		  
		  return $links; 
		  
		}
		 
	$plugin = plugin_basename(__FILE__);
	
	add_filter("plugin_action_links_$plugin", 'freq_brought_plugin_settings_link' );

		//echo freq_brought_plugin_dir_url;
		class Freq_brought_together {
			
				public function __construct() {

					if ( is_admin() ) {

						add_action( 'woocommerce_product_write_panel_tabs', array( $this, 'freq_brought_together_tab' ) );

						add_action( 'woocommerce_product_write_panels', array( $this, 'freq_brought_together_tab_options' ) );

						add_action( 'woocommerce_process_product_meta', array( $this, 'freq_brought_together_meta_custom_tab' ) );
						
						include_once( 'classes/class-admin.php' );

					}
					
					$fbtw_check  = get_option( '_fbtw_check' );
					
					if( $fbtw_check == 1 )
					{
						add_action( 'woocommerce_after_single_product_summary', array( $this, 'freq_brought_together_form_front' ), 1 );
					
						add_action( 'wp_loaded', array( $this, 'freq_brought_together_show_pro' ), 20 );
						
						add_action( 'wp_enqueue_scripts', array( $this, 'freq_brought_together_enqueue_scripts' ) );
						
					}
					
					register_activation_hook(__FILE__, array( $this, 'freq_brought_together_activation') );
					
				}
				
	
				function freq_brought_together_activation() {
					
					$fbtw_check  = get_option( '_fbtw_check' );

					$fbtw_title  = get_option( '_fbtw_title' );

					$fbtw_alabel  = get_option( '_fbtw_alabel' );

					$fbtw_tplabel  = get_option( '_fbtw_tplabel' );
					
					if($fbtw_check == '')
					{
						update_option( '_fbtw_check', 1 );
					}
					
					if($fbtw_title == '')
					{
						update_option( '_fbtw_title','Frequently Bought Together' );
					}
					
					if($fbtw_alabel == '')
					{
						update_option( '_fbtw_alabel', 'Add to cart' );
					}
					
					if($fbtw_tplabel == '')
					{
						update_option( '_fbtw_tplabel', 'Total price' );
					}
				
				}
				
				function freq_brought_together_tab() {
				
					?>
		
						<li class="fbtw_tab"><a href="#fbtw_tab_data"><?php _e('Frequently Bought Together', 'ph-fbtw'); ?></a></li>
					
					<?php
				
				}

				function freq_brought_together_tab_options() {
			
					global $post;

					?>

					<div id="fbtw_tab_data" class="panel woocommerce_options_panel">

						<div class="options_group">

							<p class="form-field"><label for="fbtw_input"><?php _e( 'Select products', 'ph-fbtw' ); ?></label>
								
								<select style="width: 50%;" id="fbtw_input" name="fbtw_input[]" class="wc-product-search" multiple="multiple" data-placeholder="<?php _e( 'Search for a product&hellip;','ph-fbtw' ); ?>">
								<?php
									$product_field_type_ids = unserialize(get_post_meta( $post->ID, '_fbtw_input_ids', true ));
									$product_ids = ! empty( $product_field_type_ids ) ? array_map( 'absint',  $product_field_type_ids ) : null;
									if ( $product_ids ) {
										foreach ( $product_ids as $product_id ) {
											$product      = get_product( $product_id );
											$product_name = woocommerce_get_formatted_product_name( $product );
											echo '<option value="' . esc_attr( $product_id ) . '" selected="selected">' . esc_html( $product_name ) . '</option>';
										}
									}
								?>
							</select> 
								<img class="help_tip" data-tip='<?php _e( 'Select products for "Frequently bought together" group', 'ywbt' ) ?>' src="<?php echo WC()->plugin_url(); ?>/assets/images/help.png" height="16" width="16" />
							
							</p>

						</div>

					</div>

					<?php

				}
				
				function freq_brought_together_meta_custom_tab( $post_id ) {

					//print_r($_POST['fbtw_input']);
					
					$products = $_POST['fbtw_input'];
					if( !empty( $products ) ){
						$products = serialize($products);
						update_post_meta( $post_id, '_fbtw_input_ids', $products);
					}
						
				}
				
				function freq_brought_together_form_front() {
					
					ob_start();

					require_once( 'classes/class-front.php' );
						
				}
				
				public function freq_brought_together_show_pro(){
					
					ob_start();
					
					require_once( 'classes/class-front-add-to-cart.php' );
				
				}
			
			
				public function freq_brought_together_enqueue_scripts() {

					$title_color       = get_option( "_fbtw_t_color" );
					$button_color   = get_option( "_fbtw_atc_color" );
					$label_color     = get_option( "_fbtw_tpl_color" );
					?>
						<style>
						 .fbtw-pro-section h3{ color:<?php echo $title_color; ?>;}
						 .fbtw-pro-section  .total_price_label{color:<?php echo $label_color; ?>;}
						 .fbtw-pro-section  .fbtw-submit-button{background:<?php echo $button_color; ?>;border: medium none;}
						 .fbtw-pro-section  .fbtw-submit-button:hover{background:<?php echo $button_color; ?>;border: medium none;}
						</style>
					<?php

				}
		
		}

		$Freq_brought_together_obj = new Freq_brought_together();
		
	}
	else 
	{
		
		add_action('admin_notices', 'freq_brought_admin_notice');

		function freq_brought_admin_notice() {
			global $current_user ;
				$user_id = $current_user->ID;
				/* Check that the user hasn't already clicked to ignore the message */
			if ( ! get_user_meta($user_id, 'freq_brought_ignore_notice') ) {
				echo '<div class="error"><p>'; 
				printf(__('Frequent brought together could not detect an active Woocommerce plugin. Make sure you have activated it. | <a href="%1$s">Hide Notice</a>'), '?freq_brought_nag_ignore=0');
				echo "</p></div>";
			}
		}

		add_action('admin_init', 'freq_brought_nag_ignore');

		function freq_brought_nag_ignore() {
			global $current_user;
				$user_id = $current_user->ID;
				/* If user clicks to ignore the notice, add that to their user meta */
				if ( isset($_GET['freq_brought_nag_ignore']) && '0' == $_GET['freq_brought_nag_ignore'] ) {
					 add_user_meta($user_id, 'freq_brought_ignore_notice', 'true', true);
			}
		}
	}
?>
