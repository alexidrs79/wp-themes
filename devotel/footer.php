<?php
/**
 * Footer template.
 *
 * @package Devotel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
</main>

<footer id="site-footer" class="site-footer" role="contentinfo">
	<?php
	$footer_markup = devotel_get_extracted_markup( 'footer/site-footer-html' );
	$has_extracted_footer = devotel_markup_is_substantial( $footer_markup, 200 )
		&& false !== stripos( $footer_markup, 'devotel-footer-wrapper' );
	if ( $has_extracted_footer ) :
		echo $footer_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	else :
		?>
		<div class="devotel-fallback-footer">
			<p><?php echo esc_html( get_bloginfo( 'name' ) ); ?> &copy; <?php echo esc_html( gmdate( 'Y' ) ); ?></p>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer',
					'container'      => 'nav',
					'menu_class'     => 'devotel-fallback-footer__menu',
					'fallback_cb'    => false,
				)
			);
			?>
		</div>
	<?php endif; ?>
</footer>

<?php wp_footer(); ?>
</body>
</html>

