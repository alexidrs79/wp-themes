<?php
/**
 * Template part: Site footer.
 *
 * The Figma design (node 15532:79) has no dedicated footer section — the
 * page ends after the Founding Offer panel (Section 07). This is a
 * minimal copyright bar, standard practice for a real site rather than a
 * gap in the design.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings_id  = LUCIBOOK_THEME_SETTINGS_PAGE_ID;
$rights_text  = get_field( 'footer_rights_text', $settings_id );
?>
<footer class="site-footer">
	<div class="site-footer__inner container">
		<p class="site-footer__rights">&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( $rights_text ); ?></p>
	</div>
</footer>
