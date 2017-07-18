<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $product;

$index  = 0;
$thumbs = '';
$checks = '';
$total  = 0;

if( ! isset( $args ) ) {
	return;
}

// set query
$url = add_query_arg( 'freq_brought_together' , $product->id, get_permalink( $product->id ) );
$url = wp_nonce_url( $url, 'freq_brought_together_nonce' );

//echo $url;

// set button label
$label       = get_option( '_fbtw_alabel' );
$label_total = get_option( '_fbtw_tplabel' );
$title       = get_option( '_fbtw_title' );

?>

<div class="fbtw-pro-section">
	<?php if( $title != '' ) {
		echo '<h3>' . esc_html( $title ) . '</h3>';
	}
	?>

	<form class="fbtw-form-class" method="post" action="<?php echo esc_url( $url ) ?>">
	
		<ul class="fbtw-form-ul">
		<?php
					
			foreach( $args as $arg ) {

			if( get_post_type( $arg ) != 'product' && get_post_type( $arg ) != 'product_variation' ) {
				continue;
			}

			$current = wc_get_product( $arg );

			if( ! $current || ! $current->is_in_stock() ) {
				continue;
			}

			// get correct id if product is variation
			$id = $current->product_type == 'variation' ? $current->variation_id : $current->id;
			
			if( $index > 0 )
				$thumbs .= '<td class="plus-sign" >+</td>';
				$thumbs .= '<td class="image-class" ><a href="' . get_permalink( $current->id ) . '">' . $current->get_image( 'shop_thumbnail' ) . '</a></td>';

			?>
			<li class="fbtw-pro-item">
				<label>

					<input type="hidden" name="pro_id[]" id="pro_id_<?php echo $index ?>" class="active" value="<?php echo $id ?>" />

					<span class="product-name">
						<?php echo ! $index ? esc_html( $current->get_title() ) : esc_html( $current->get_title() ); ?>
					</span>

					<?php

					if( $current->product_type == 'variation' ) {
						$attributes = $current->get_variation_attributes();
						$variations = array();

						foreach( $attributes as $key => $attribute ) {
							$key = str_replace( 'attribute_', '', $key );

							$terms = get_terms( sanitize_title( $key ), array(
								'menu_order' => 'ASC',
								'hide_empty' => false
							) );

							foreach ( $terms as $term ) {
								if ( ! is_object( $term ) || ! in_array( $term->slug, array( $attribute ) ) ) {
									continue;
								}
								$variations[] = $term->name;
							}
						}

						if( ! empty( $variations ) )
							echo '<span class="product-attributes"> &ndash; ' . implode( ', ', $variations ) . '</span>';
					}

					// echo product price
					echo ' &ndash; <span class="price">' . $current->get_price_html() . '</span>';
					?>

				</label>
			</li>
			<?php
			// increment total
			$total += floatval( $current->get_display_price() );

			// increment index
			$index++;
		}
		
		if( $index < 2 ) {
			return; // exit if only available product is current
		}
		?>
		</ul>
		
		<table class="fbtw-form-table">
			<tbody>
				<tr>
					<?php echo $thumbs; ?>
				</tr>
			</tbody>
		</table>

		<div class="fbtw-price_div">
			<div class="price_text">
				<span class="total_price_label">
					<?php echo esc_html( $label_total ); ?>:
				</span>
				&nbsp;
				<span class="total_price" data-total="<?php echo $total; ?>">
					<?php echo wc_price( $total ); ?>
				</span>
			</div>
			<input type="submit" class="fbtw-submit-button" value="<?php echo esc_html( $label ); ?>">
		</div>

	</form>
</div>