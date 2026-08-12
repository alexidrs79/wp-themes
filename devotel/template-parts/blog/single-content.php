<?php
/**
 * Single blog post content + optional TOC.
 *
 * @package Devotel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$content = isset( $args['content'] ) ? (string) $args['content'] : '';
$toc     = isset( $args['toc'] ) && is_array( $args['toc'] ) ? $args['toc'] : array();
?>
<div class="devotel-blog-single-body">
	<?php if ( ! empty( $toc ) ) : ?>
		<aside class="devotel-blog-single-toc" aria-label="<?php esc_attr_e( 'Table of contents', 'devotel' ); ?>">
			<h4 class="devotel-blog-single-toc__title"><?php esc_html_e( 'Table of contents', 'devotel' ); ?></h4>
			<ol class="devotel-blog-single-toc__list">
				<?php foreach ( $toc as $item ) : ?>
					<li class="devotel-blog-single-toc__item devotel-blog-single-toc__item--h<?php echo esc_attr( (string) $item['level'] ); ?>">
						<a href="#<?php echo esc_attr( $item['id'] ); ?>"><?php echo esc_html( $item['text'] ); ?></a>
					</li>
				<?php endforeach; ?>
			</ol>
		</aside>
	<?php endif; ?>
	<div class="entry-content devotel-blog-single-content">
		<?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</div>
</div>
