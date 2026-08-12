<?php
/**
 * Dynamic ACF-driven sections.
 *
 * @package Devotel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Determine whether current page should use dynamic section builder.
 *
 * @param int|null $post_id Post ID.
 * @return bool
 */
function devotel_use_dynamic_builder( $post_id = null ) {
	if ( ! function_exists( 'get_field' ) ) {
		return false;
	}

	$post_id = $post_id ? $post_id : get_the_ID();

	if ( (bool) get_field( 'devotel_enable_dynamic_builder', $post_id ) ) {
		return true;
	}

	// Keep editing friction low: if rows exist, render them by default.
	if ( function_exists( 'have_rows' ) && have_rows( 'devotel_dynamic_sections', $post_id ) ) {
		return true;
	}

	return false;
}

/**
 * Render a single dynamic section layout.
 *
 * @param string $layout Layout key.
 * @return void
 */
function devotel_render_dynamic_layout( $layout ) {
	if ( 'hero' === $layout ) {
		$kicker         = (string) get_sub_field( 'kicker' );
		$title          = (string) get_sub_field( 'title' );
		$description    = (string) get_sub_field( 'description' );
		$primary_label  = (string) get_sub_field( 'primary_button_label' );
		$primary_url    = (string) get_sub_field( 'primary_button_url' );
		$secondary_label = (string) get_sub_field( 'secondary_button_label' );
		$secondary_url   = (string) get_sub_field( 'secondary_button_url' );
		?>
		<section class="devotel-dyn devotel-dyn--hero">
			<div class="devotel-container">
				<?php if ( $kicker ) : ?>
					<p class="devotel-dyn__kicker"><?php echo esc_html( $kicker ); ?></p>
				<?php endif; ?>
				<?php if ( $title ) : ?>
					<h2 class="devotel-dyn__title"><?php echo esc_html( $title ); ?></h2>
				<?php endif; ?>
				<?php if ( $description ) : ?>
					<p class="devotel-dyn__description"><?php echo esc_html( $description ); ?></p>
				<?php endif; ?>
				<div class="devotel-dyn__actions">
					<?php if ( $primary_label && $primary_url ) : ?>
						<a class="devotel-btn" href="<?php echo esc_url( $primary_url ); ?>"><?php echo esc_html( $primary_label ); ?></a>
					<?php endif; ?>
					<?php if ( $secondary_label && $secondary_url ) : ?>
						<a class="devotel-btn devotel-btn--secondary" href="<?php echo esc_url( $secondary_url ); ?>"><?php echo esc_html( $secondary_label ); ?></a>
					<?php endif; ?>
				</div>
			</div>
		</section>
		<?php
		return;
	}

	if ( 'cards' === $layout ) {
		$title       = (string) get_sub_field( 'section_title' );
		$description = (string) get_sub_field( 'section_description' );
		?>
		<section class="devotel-dyn devotel-dyn--cards">
			<div class="devotel-container">
				<?php if ( $title ) : ?>
					<h2 class="devotel-dyn__title"><?php echo esc_html( $title ); ?></h2>
				<?php endif; ?>
				<?php if ( $description ) : ?>
					<p class="devotel-dyn__description"><?php echo esc_html( $description ); ?></p>
				<?php endif; ?>
				<?php if ( function_exists( 'have_rows' ) && have_rows( 'cards' ) ) : ?>
					<div class="devotel-dyn-cards">
						<?php
						while ( have_rows( 'cards' ) ) :
							the_row();
							$card_title       = (string) get_sub_field( 'card_title' );
							$card_description = (string) get_sub_field( 'card_description' );
							$card_link_label  = (string) get_sub_field( 'card_link_label' );
							$card_link_url    = (string) get_sub_field( 'card_link_url' );
							$card_icon        = get_sub_field( 'card_icon' );
							?>
							<article class="devotel-dyn-card">
								<?php if ( is_array( $card_icon ) && ! empty( $card_icon['ID'] ) ) : ?>
									<div class="devotel-dyn-card__icon">
										<?php echo wp_get_attachment_image( (int) $card_icon['ID'], 'thumbnail' ); ?>
									</div>
								<?php endif; ?>
								<?php if ( $card_title ) : ?>
									<h3><?php echo esc_html( $card_title ); ?></h3>
								<?php endif; ?>
								<?php if ( $card_description ) : ?>
									<p><?php echo esc_html( $card_description ); ?></p>
								<?php endif; ?>
								<?php if ( $card_link_label && $card_link_url ) : ?>
									<a href="<?php echo esc_url( $card_link_url ); ?>"><?php echo esc_html( $card_link_label ); ?></a>
								<?php endif; ?>
							</article>
							<?php
						endwhile;
						?>
					</div>
				<?php endif; ?>
			</div>
		</section>
		<?php
		return;
	}

	if ( 'faq' === $layout ) {
		$title = (string) get_sub_field( 'section_title' );
		?>
		<section class="devotel-dyn devotel-dyn--faq">
			<div class="devotel-container">
				<?php if ( $title ) : ?>
					<h2 class="devotel-dyn__title"><?php echo esc_html( $title ); ?></h2>
				<?php endif; ?>
				<?php if ( function_exists( 'have_rows' ) && have_rows( 'faqs' ) ) : ?>
					<div class="devotel-dyn-faqs">
						<?php
						while ( have_rows( 'faqs' ) ) :
							the_row();
							$question = (string) get_sub_field( 'question' );
							$answer   = (string) get_sub_field( 'answer' );
							?>
							<details class="devotel-dyn-faq">
								<summary><?php echo esc_html( $question ); ?></summary>
								<p><?php echo esc_html( $answer ); ?></p>
							</details>
							<?php
						endwhile;
						?>
					</div>
				<?php endif; ?>
			</div>
		</section>
		<?php
		return;
	}

	if ( 'cta' === $layout ) {
		$title        = (string) get_sub_field( 'title' );
		$description  = (string) get_sub_field( 'description' );
		$button_label = (string) get_sub_field( 'button_label' );
		$button_url   = (string) get_sub_field( 'button_url' );
		?>
		<section class="devotel-dyn devotel-dyn--cta">
			<div class="devotel-container">
				<?php if ( $title ) : ?>
					<h2 class="devotel-dyn__title"><?php echo esc_html( $title ); ?></h2>
				<?php endif; ?>
				<?php if ( $description ) : ?>
					<p class="devotel-dyn__description"><?php echo esc_html( $description ); ?></p>
				<?php endif; ?>
				<?php if ( $button_label && $button_url ) : ?>
					<a class="devotel-btn" href="<?php echo esc_url( $button_url ); ?>"><?php echo esc_html( $button_label ); ?></a>
				<?php endif; ?>
			</div>
		</section>
		<?php
		return;
	}

	if ( 'rich_text' === $layout ) {
		$content = (string) get_sub_field( 'content' );
		?>
		<section class="devotel-dyn devotel-dyn--rich-text">
			<div class="devotel-container">
				<?php echo wp_kses_post( $content ); ?>
			</div>
		</section>
		<?php
	}
}

/**
 * Render ACF flexible dynamic sections for current post.
 *
 * @param int|null $post_id Post ID.
 * @return bool True when sections were rendered.
 */
function devotel_render_dynamic_sections( $post_id = null ) {
	if ( ! function_exists( 'have_rows' ) ) {
		return false;
	}

	$post_id = $post_id ? $post_id : get_the_ID();

	if ( ! have_rows( 'devotel_dynamic_sections', $post_id ) ) {
		return false;
	}

	echo '<div class="devotel-dyn-sections">';
	while ( have_rows( 'devotel_dynamic_sections', $post_id ) ) {
		the_row();
		devotel_render_dynamic_layout( get_row_layout() );
	}
	echo '</div>';

	return true;
}

