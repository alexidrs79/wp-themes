<?php
/**
 * Single blog post — Elementor template 908 layout.
 *
 * @package Devotel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post    = isset( $args['post'] ) ? $args['post'] : null;
$content = isset( $args['content'] ) ? (string) $args['content'] : '';
$toc     = isset( $args['toc'] ) && is_array( $args['toc'] ) ? $args['toc'] : array();

if ( ! $post instanceof WP_Post ) {
	return;
}

$categories = devotel_get_post_display_categories( $post->ID );
$author     = get_the_author_meta( 'display_name', (int) $post->post_author );
$author_bio = get_the_author_meta( 'description', (int) $post->post_author );
$excerpt    = devotel_get_blog_single_hero_excerpt( $post );
?>
<div data-elementor-type="single" data-elementor-id="908" class="elementor elementor-908 elementor-location-single">
	<div class="elementor-element elementor-element-9344109 e-flex e-con-boxed e-con e-parent" data-id="9344109" data-element_type="container">
		<div class="e-con-inner">
			<div class="elementor-element elementor-element-47c1414 e-con-full e-flex e-con e-child" data-id="47c1414" data-element_type="container">
				<?php if ( ! empty( $categories ) ) : ?>
					<div class="elementor-element elementor-element-728e256 elementor-widget elementor-widget-post-info" data-id="728e256" data-element_type="widget" data-widget_type="post-info.default">
						<ul class="elementor-inline-items elementor-icon-list-items devotel-blog-categories devotel-blog-categories--inline">
							<?php foreach ( $categories as $category ) : ?>
								<li class="elementor-icon-list-item elementor-inline-item">
									<a href="<?php echo esc_url( get_category_link( $category ) ); ?>">
										<span class="elementor-icon-list-text"><?php echo esc_html( $category->name ); ?></span>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>
				<div class="elementor-element elementor-element-a6c0969 elementor-widget elementor-widget-post-info" data-id="a6c0969" data-element_type="widget" data-widget_type="post-info.default">
					<ul class="elementor-inline-items elementor-icon-list-items">
						<li class="elementor-icon-list-item elementor-inline-item">
							<span class="elementor-icon-list-text"><?php echo esc_html( get_the_date( 'M j, Y', $post ) ); ?></span>
						</li>
						<li class="elementor-icon-list-item elementor-inline-item">
							<span class="elementor-icon-list-text"><?php echo esc_html( get_the_time( 'g:i a', $post ) ); ?></span>
						</li>
					</ul>
				</div>
				<div class="elementor-element elementor-element-062c490 elementor-widget elementor-widget-theme-post-title elementor-page-title elementor-widget-heading" data-id="062c490" data-element_type="widget" data-widget_type="theme-post-title.default">
					<h1 class="elementor-heading-title elementor-size-default"><?php echo esc_html( get_the_title( $post ) ); ?></h1>
				</div>
				<?php if ( '' !== $excerpt ) : ?>
					<div class="elementor-element elementor-element-d97dd2f elementor-widget elementor-widget-theme-post-excerpt" data-id="d97dd2f" data-element_type="widget" data-widget_type="theme-post-excerpt.default">
						<p><?php echo esc_html( $excerpt ); ?></p>
					</div>
				<?php endif; ?>
			</div>
			<?php if ( has_post_thumbnail( $post ) ) : ?>
				<div class="elementor-element elementor-element-232765e e-con-full e-flex e-con e-child" data-id="232765e" data-element_type="container">
					<div class="elementor-element elementor-element-a1361e9 elementor-widget elementor-widget-theme-post-featured-image elementor-widget-image" data-id="a1361e9" data-element_type="widget" data-widget_type="theme-post-featured-image.default">
						<?php echo get_the_post_thumbnail( $post, 'large' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<div class="elementor-element elementor-element-425aac5 e-flex e-con-boxed e-con e-parent" data-id="425aac5" data-element_type="container">
		<div class="e-con-inner">
			<?php if ( ! empty( $toc ) ) : ?>
				<div class="elementor-element elementor-element-7a37905 e-con-full e-flex e-con e-child devotel-blog-toc-sticky" data-id="7a37905" data-element_type="container">
					<div class="elementor-element elementor-element-66fa37e elementor-widget elementor-widget-table-of-contents" data-id="66fa37e" data-element_type="widget" id="elementor-toc__66fa37e" data-widget_type="table-of-contents.default">
						<div class="elementor-widget-container">
							<div class="elementor-toc__header">
								<h4 class="elementor-toc__header-title"><?php esc_html_e( 'Table of contents', 'devotel' ); ?></h4>
							</div>
							<div class="elementor-toc__body">
								<ul class="elementor-toc__list-wrapper devotel-blog-toc-list">
									<?php foreach ( $toc as $item ) : ?>
										<li class="elementor-toc__list-item elementor-toc__list-item-text">
											<a class="elementor-toc__list-item-text" href="#<?php echo esc_attr( $item['id'] ); ?>" data-toc-target="<?php echo esc_attr( $item['id'] ); ?>"><?php echo esc_html( $item['text'] ); ?></a>
										</li>
									<?php endforeach; ?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>
			<div class="elementor-element elementor-element-eebd6da e-con-full e-flex e-con e-child" data-id="eebd6da" data-element_type="container">
				<div class="elementor-element elementor-element-ffb1353 elementor-widget elementor-widget-theme-post-content" data-id="ffb1353" data-element_type="widget" data-widget_type="theme-post-content.default">
					<div class="elementor-widget-container">
						<div id="blogsss" class="entry-content devotel-blog-single-content">
							<?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
					</div>
				</div>
				<div class="elementor-element elementor-element-a314b5d e-grid e-con-full e-flex e-con e-child devotel-blog-author-share" data-id="a314b5d" data-element_type="container">
					<div class="elementor-element elementor-element-79652aa elementor-author-box--align-left elementor-author-box--image-valign-middle elementor-author-box--layout-image-left elementor-author-box--avatar-yes elementor-author-box--name-yes<?php echo $author_bio ? ' elementor-author-box--biography-yes' : ''; ?> elementor-author-box--link-no elementor-widget elementor-widget-author-box" data-id="79652aa" data-element_type="widget" data-widget_type="author-box.default">
						<div class="elementor-author-box">
							<div class="elementor-author-box__avatar">
								<?php echo get_avatar( (int) $post->post_author, 48, '', sprintf( __( 'Picture of %s', 'devotel' ), $author ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</div>
							<div class="elementor-author-box__text">
								<div>
									<h4 class="elementor-author-box__name"><?php echo esc_html( $author ); ?></h4>
								</div>
								<?php if ( $author_bio ) : ?>
									<div class="elementor-author-box__bio"><?php echo esc_html( $author_bio ); ?></div>
								<?php endif; ?>
							</div>
						</div>
					</div>
					<div class="elementor-element elementor-element-f47042b elementor-share-buttons--skin-flat elementor-share-buttons--shape-square elementor-grid-0 elementor-widget elementor-widget-share-buttons" data-id="f47042b" data-element_type="widget" data-widget_type="share-buttons.default">
						<div class="elementor-widget-container">
							<?php devotel_render_blog_share_buttons( get_permalink( $post ), get_the_title( $post ) ); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php get_template_part( 'template-parts/blog/related', 'posts', array( 'post' => $post ) ); ?>
</div>
