<?php
/**
 * Homepage section: blog-insights (converted from Elementor widgets).
 *
 * @package Devotel
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$kicker = function_exists( 'get_field' ) ? (string) get_field( 'devotel_home_blog_kicker' ) : '';
$title  = function_exists( 'get_field' ) ? (string) get_field( 'devotel_home_blog_title' ) : '';
$text   = function_exists( 'get_field' ) ? (string) get_field( 'devotel_home_blog_text' ) : '';

$kicker = $kicker ? $kicker : 'Our blog';
$title  = $title ? $title : 'Insights from the Telecom Industry';
$text   = $text ? $text : 'Stay informed with expert analysis, industry trends, and technical guides.';
?>
<section class="devotel-section devotel-section--blog-insights devotel-blog-insights" aria-label="blog-insights">
	<div class="devotel-container">
		<p class="devotel-blog-insights__kicker"><?php echo esc_html( $kicker ); ?></p>
		<h2 class="devotel-blog-insights__title"><?php echo esc_html( $title ); ?></h2>
		<p class="devotel-blog-insights__text"><?php echo esc_html( $text ); ?></p>
		<p class="devotel-blog-insights__action">
			<a class="devotel-btn devotel-btn--secondary" href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">
				<?php esc_html_e( 'View all posts', 'devotel' ); ?>
			</a>
		</p>
	</div>
</section>
