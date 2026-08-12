<?php
/** products/sim-based/ota extracted from WPO cache / production */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$markup = devotel_get_product_subpage_snapshot_extract_markup( 'products/sim-based/ota', 7796 );
if ( '' !== trim( $markup ) ) {
	echo $markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
