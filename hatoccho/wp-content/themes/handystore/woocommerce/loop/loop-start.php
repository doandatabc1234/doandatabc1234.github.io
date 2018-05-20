<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

// Related products extra class
$new_class = '';
if ( is_product() ) {
	$upsells_qty = (handy_get_option('upsells_qty') != '') ? handy_get_option('upsells_qty') : '2';
	$related_qty = (handy_get_option('related_products_qty') != '') ? handy_get_option('related_products_qty') : '4';
	$new_class = ' related-cols-'.esc_attr($related_qty).' upsells-cols-'.esc_attr($upsells_qty);
	if (class_exists('WCV_Vendors')) {
		$wcv_related_qty = (handy_get_option('wcv_qty') != '') ? handy_get_option('wcv_qty') : '4';
		$new_class .= ' wcv-cols-'.esc_attr($wcv_related_qty);
	}
	// Extra class for lazyload
	if ( handy_get_option('catalog_lazyload')=='on' ) {
		$new_class .= ' lazyload';
	}
}
?>
<ul class="products<?php echo esc_attr($new_class); ?>" data-expand="-100">
