<?php
/**
 * My Orders - Deprecated
 *
 * @deprecated 2.6.0 this template file is no longer used. My Account shortcode uses orders.php.
 * @package WooCommerce\Templates
 */

defined( 'ABSPATH' ) || exit;

$customer_orders = get_posts(
	apply_filters(
		'woocommerce_my_account_my_orders_query',
		array(
			'numberposts' => $order_count,
			'meta_key'    => '_customer_user',
			'meta_value'  => get_current_user_id(),
			'post_type'   => wc_get_order_types( 'view-orders' ),
			'post_status' => 'wc-completed',
		)
	)
);

if ( $customer_orders ){ ?>
<div class="container order_items">
	<div class="row">
	<?php
	foreach ( $customer_orders as $customer_order ){
		$order      = wc_get_order( $customer_order ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		$item_count = $order->get_item_count();
	?>
	<div class="col-md-12 col-xs-12 order">
		<div class="order_item">
			<div class="order_name">
				<span><?php _e('Name:', 'study-doc'); ?> </span> <?php
		$product_name = array();
		$product_id = array();

		foreach( $order->get_items() as $item ){
			$product_name[] = $item->get_name();
			$product_id[] = $item->get_product_id();

		}

		echo $product_name[0];?>
			</div>
			<div class="order_id">
				<span><?php _e('Order ID:', 'study-doc'); ?> </span> <?php echo $order->get_order_number();?>
			</div>
			<div class="order_time">
				<span><?php _e('Ordered:', 'study-doc'); ?> </span> <time datetime="<?php echo esc_attr( $order->get_date_created()->date( 'c' ) ); ?>"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></time>
			</div>
			<div class="order_status">
				<span><?php _e('Status:', 'study-doc'); ?> </span> <?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?>
			</div>


		</div>
	</div>
		<div class="col-md-12 col-xs-12container product-details-wrapper">
	<?php foreach ( $customer_orders as $customer_order ){ ?>
	<div class="product_details">
		<?php

			$order      = wc_get_order( $customer_order ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			$items = $order->get_items();
			foreach ( $items as $item ) {
				$product_name = $item->get_name();
				$product_id = $item->get_product_id();
				//echo gettype($product_id);
				$product_description = get_post($item['product_id'])->post_content;
				//echo '<h1 class="product_title">'.$product_name.'</h1>';
				echo '<div class="product_details col-md-12">'. $product_description.'</div>';
			}

		?>	
	</div>
	<?php 
		}
	?>
</div>



<?php 
	}
}
?>
		
		
	</div>
</div>

