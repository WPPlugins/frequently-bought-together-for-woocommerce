<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

	add_action('admin_menu', 'freq_brought_together_submenu_page',99);
		
	function freq_brought_together_submenu_page() {

		add_menu_page( 'phoeniixx', __( 'Phoeniixx', 'phe' ), 'nosuchcapability', 'phoeniixx', NULL, freq_brought_plugin_dir_url.'/images/logo-wp.png', 57 );

		add_submenu_page( 'phoeniixx', 'Frequently Bought together', 'Frequently Bought Together', 'manage_options', 'freq_brought_together_setting', 'freq_brought_together_setting' ); 

	}

	function freq_brought_together_setting() {
		

	$tab = sanitize_text_field( $_GET['tab'] );
	
	?>
	<div class="wrap">
		<h2 class="nav-tab-wrapper woo-nav-tab-wrapper">
		<a class="nav-tab <?php if($tab == 'set' || $tab == ''){ echo esc_html( "nav-tab-active" ); } ?>" href="?page=freq_brought_together_setting&amp;tab=set">Settings</a>
		<a class="nav-tab <?php if($tab == 'premium'){ echo esc_html( "nav-tab-active" ); } ?>" href="?page=freq_brought_together_setting&amp;tab=premium">Premium Version</a>
		
		</h2>
		
	<?php
	
	if($tab == 'set' || $tab == '')
	{
		
		wp_enqueue_script('wp-color-picker'); 

		wp_enqueue_style('wp-color-picker');

		if($_POST['submit']) {
			
			if ( ! isset( $_POST['fre_boug_tog_setting_nonce'] ) || ! wp_verify_nonce( $_POST['fre_boug_tog_setting_nonce'], 'fre_boug_tog_setting_submit' ) ) 
			{

			   print 'Sorry, your nonce did not verify.';
			   exit;

			} 
			else {
				
				$fbtw_check =  sanitize_text_field( $_POST['fbtw_check'] );
			
				$fbtw_title  =  sanitize_text_field( $_POST['fbtw_title'] );
				
				$fbtw_alabel  =  sanitize_text_field( $_POST['fbtw_alabel'] );
				
				$fbtw_tplabel =  sanitize_text_field( $_POST['fbtw_tplabel'] );
				
				$fbtw_t_color =  sanitize_text_field( $_POST['fbtw_t_color'] );
				
				$fbtw_atc_color  =  sanitize_text_field( $_POST['fbtw_atc_color'] );
				
				$fbtw_tpl_color =  sanitize_text_field( $_POST['fbtw_tpl_color'] );
					
				$fbtw_check =  ($fbtw_check == '' ? '0' : '1'); 
				
				update_option( '_fbtw_check', $fbtw_check );
				
				update_option( '_fbtw_title', $fbtw_title );
				
				update_option( '_fbtw_alabel', $fbtw_alabel );
				
				update_option( '_fbtw_tplabel', $fbtw_tplabel );
				
				update_option( '_fbtw_t_color', $fbtw_t_color );
				
				update_option( '_fbtw_atc_color', $fbtw_atc_color );
				
				update_option( '_fbtw_tpl_color', $fbtw_tpl_color );
				
			}
			
			
			
		}

				
			$plugin_dir_url = plugin_dir_url(dirname(__FILE__));
			
			$fbtw_check  = get_option( '_fbtw_check' );

			$fbtw_title  = get_option( '_fbtw_title' );

			$fbtw_alabel  = get_option( '_fbtw_alabel' );

			$fbtw_tplabel  = get_option( '_fbtw_tplabel' );

			$fbtw_t_color  = get_option( '_fbtw_t_color' );

			$fbtw_atc_color  = get_option( '_fbtw_atc_color' );

			$fbtw_tpl_color  = get_option( '_fbtw_tpl_color' );
					
				?>
				<div id="normal-sortables" class="meta-box-sortables">
				<div id="pho_wcpc_box" class="postbox ">
					<h3><span class="upgrade-setting">Upgrade to the PREMIUM VERSION</span></h3>
					<div class="inside">
						<div class="pho_check_pin">

							<div class="column two">
								<!----<h2>Get access to Pro Features</h2>----->

								<p>Switch to the premium version of Custom My Account Plugin Options  to get the benefit of all features!</p>

									<div class="pho-upgrade-btn">
										<a target="_blank" href="http://www.phoeniixx.com/product/frequently-bought-together-for-woocommerce/?utm_source=Free%20Plugin&utm_medium=Promotion&utm_campaign=Free%20Plugin"><img src="<?php echo $plugin_dir_url.'assets/images/premium-btn.png'; ?>" /></a>
									</div>
							</div>
						</div>
					</div>
				</div>
			</div>
				
				
				<h2>
					Frequently Bought Together - Plugin Options
				</h2>
				
					<form novalidate="novalidate" method="post" action="">
					
						<?php wp_nonce_field( 'fre_boug_tog_setting_submit', 'fre_boug_tog_setting_nonce' ); ?>
						
							<table class="form-table">

								<tbody>

									<h3>General Options</h3>
									
									<tr class="user-nickname-wrap">

										<th><label for="fbtw_check">Enable Frequently Bought Together</label></th>

										<td><input type="checkbox" value="1" <?php if($fbtw_check == 1){ echo "checked"; }  ?> id="fbtw_check" name="fbtw_check" ></label></td>

									</tr>
									
									<tr class="user-nickname-wrap">

										<th><label for="fbtw_title">Title</label></th>

											<td><input type="text" class="regular-text" value="<?php echo $fbtw_title; ?>" id="fbtw_title" name="fbtw_title"></td>

									</tr>
									
									<tr class="user-nickname-wrap">

										<th><label for="fbtw_alabel">"Add to cart" button label</label></th>

											<td><input type="text" class="regular-text" value="<?php echo $fbtw_alabel; ?>" id="fbtw_alabel" name="fbtw_alabel"></td>

									</tr>
									
									<tr class="user-nickname-wrap">

										<th><label for="fbtw_tplabel">Total price label</label></th>

											<td><input type="text" class="regular-text" value="<?php echo $fbtw_tplabel; ?>" id="fbtw_tplabel" name="fbtw_tplabel"></td>

									</tr>
									
								</tbody>	

							</table>
							
							<table class="form-table">

								<tbody>

									<h3>Styling Options</h3>
									
									<tr class="user-user-login-wrap">

										<th><label for="fbtw_t_color">Title color</label></th>

											<td><input type="text" class="regular-text" value="<?php echo $fbtw_t_color; ?>" id="fbtw_t_color" name="fbtw_t_color"></td>

									</tr>
									
									<tr class="user-user-login-wrap">

										<th><label for="fbtw_atc_color">"Add to cart" button color</label></th>

											<td><input type="text" class="regular-text" value="<?php echo $fbtw_atc_color; ?>" id="fbtw_atc_color" name="fbtw_atc_color"></td>

									</tr>
									
									<tr class="user-user-login-wrap">

										<th><label for="fbtw_tpl_color">Total price label color</label></th>

											<td><input type="text" class="regular-text" value="<?php echo $fbtw_tpl_color; ?>" id="fbtw_tpl_color" name="fbtw_tpl_color"></td>

									</tr>
									
								</tbody>	

							</table>
							
							<p class="submit"><input type="submit" value="Save" class="button button-primary" id="submit" name="submit"></p>
							
					</form>
			</div>
			<style>
				.form-table th {
					width: 270px;
					padding: 25px;
				}
				.form-table td {
					
					padding: 20px 10px;
				}
				.form-table {
					background-color: #fff;
				}
				h3 {
					padding: 10px;
				}

				.px-multiply{ color:#ccc; vertical-align:bottom;}

				.long{ display:inline-block; vertical-align:middle; }

				.wid{ display:inline-block; vertical-align:middle;}

				.up{ display:block;}

				.grey{ color:#b0adad;}
				#pho_wcpc_box.postbox {
					background: #fff none repeat scroll 0 0;
					border: 1px solid #e5e5e5;
					box-shadow: 0 1px 1px rgba(0, 0, 0, 0.04);
					min-width: 255px;
				}
				#pho_wcpc_box.postbox h3 {
					padding: 0 0 0 10px;
				}
				#pho_wcpc_box.postbox .inside {
					margin: 11px 0;
					position: relative;
}

</style>
<script>

jQuery(document).ready(function($)
{
	jQuery("#fbtw_t_color").wpColorPicker();

	jQuery("#fbtw_atc_color").wpColorPicker();

	jQuery("#fbtw_tpl_color").wpColorPicker();
});

</script>
		<?php
	}
if($tab == 'premium')
{ 	
	require_once(dirname(__FILE__).'/premium-setting.php');

}
/* if($tab == 'allp')
{
	
	
	?>
		<style>
		iframe.more-plugin {
			min-height: 1000px;
			width: 100%;
		}

		.wrap{
			margin:0;
		}
		</style>
			<iframe class="more-plugin" src="http://plugins.snapppy.com/plugins.php"></iframe> 
			<?php

} */

}

?>