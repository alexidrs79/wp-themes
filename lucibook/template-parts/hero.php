<?php
/**
 * Template part: Hero section.
 * Figma: node 15532:88 ("Section 01 — Hero"), blue panel 1376x749.
 *
 * Text column (headline/body/CTA/note) is normal responsive flow. The
 * illustration cluster is a single flattened image (634x713), not a
 * layered composite of individual SVG elements.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$headline_lines = array_filter( array_map( 'trim', explode( "\n", (string) get_field( 'hero_headline' ) ) ) );
$body_lines      = array_filter( array_map( 'trim', explode( "\n", (string) get_field( 'hero_body' ) ) ) );
$cta_label       = get_field( 'hero_cta_label' );
$cta_url         = get_field( 'hero_cta_url' );
$small_note      = get_field( 'hero_small_note' );
?>
<section class="hero">
	<div class="container">
		<div class="hero__panel" data-animate-onload data-stagger="40">
			<div class="hero__content">
				<h1 class="hero__headline" data-animate="fade">
					<?php foreach ( $headline_lines as $line ) : ?>
						<span class="hero__headline-line"><?php echo esc_html( $line ); ?></span>
					<?php endforeach; ?>
				</h1>
				<div class="hero__content-rest" data-animate="fade">
					<p class="hero__body">
						<?php foreach ( $body_lines as $i => $line ) : ?>
							<?php echo esc_html( $line ); ?><?php echo $i < count( $body_lines ) - 1 ? '<br>' : ''; ?>
						<?php endforeach; ?>
					</p>
					<a class="btn btn--white hero__cta" href="<?php echo esc_url( lucibook_resolve_theme_url( $cta_url ) ); ?>">
						<?php echo lucibook_wrap_trailing_arrow( esc_html( $cta_label ) ); ?>
					</a>
					<p class="hero__small-note"><?php echo esc_html( $small_note ); ?></p>
				</div>
			</div>

			<div class="hero__visual" data-animate="fade">
				<?php lucibook_print_icon( 'LUCIBOOK_HERO_IMAGE_ID', 'hero__image' ); ?>
			</div>
		</div>
	</div>
</section>
