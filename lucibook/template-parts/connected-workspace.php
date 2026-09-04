<?php
/**
 * Template part: One Connected Workspace section.
 * Figma: node 15532:356 ("Section 05 — One Connected Workspace").
 *
 * The diagram (dashed orbit + Snap/Lucibook-dashboard/Luci product
 * callouts) is a single flattened mockup image (791x735), not a
 * layered composite of individual SVG elements.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$eyebrow  = get_field( 'ws_eyebrow' );
$headline_lines = array_filter( array_map( 'trim', explode( "\n", (string) get_field( 'ws_headline' ) ) ) );
$body     = get_field( 'ws_body' );
$closing  = get_field( 'ws_closing' );
$cta_label = get_field( 'ws_cta_label' );
$cta_url   = get_field( 'ws_cta_url' );
$tagline_lines = array_filter( array_map( 'trim', explode( "\n", (string) get_field( 'ws_tagline' ) ) ) );
?>
<section class="workspace">
	<div class="container workspace__inner">
		<div class="workspace__content" data-animate="fade">
			<p class="workspace__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
			<h2 class="workspace__headline">
				<?php foreach ( $headline_lines as $line ) : ?>
					<span class="workspace__headline-line"><?php echo esc_html( $line ); ?></span>
				<?php endforeach; ?>
			</h2>
			<p class="workspace__body"><?php echo esc_html( $body ); ?></p>
			<p class="workspace__closing"><?php echo esc_html( $closing ); ?></p>
			<a class="btn btn--primary workspace__cta" href="<?php echo esc_url( lucibook_resolve_theme_url( $cta_url ) ); ?>">
				<?php echo esc_html( $cta_label ); ?>
			</a>
			<p class="workspace__tagline">
				<?php foreach ( $tagline_lines as $line ) : ?>
					<span class="workspace__tagline-line"><?php echo esc_html( $line ); ?></span>
				<?php endforeach; ?>
			</p>
		</div>

		<div class="workspace__visual" data-animate="fade">
			<?php lucibook_print_icon( 'LUCIBOOK_WS_DIAGRAM_IMAGE_ID', 'workspace__diagram-image' ); ?>
		</div>
	</div>
</section>
