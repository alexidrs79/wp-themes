<?php
/**
 * Template part: Luci AI section.
 * Figma: node 15532:302 ("Section 04 — Luci AI").
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$eyebrow      = get_field( 'luci_eyebrow' );
$headline_lines = array_filter( array_map( 'trim', explode( "\n", (string) get_field( 'luci_headline' ) ) ) );
$challenge    = get_field( 'luci_challenge' );
$positioning  = get_field( 'luci_positioning' );
$placeholder  = get_field( 'luci_input_placeholder' );
$input_note   = get_field( 'luci_input_note' );
$photo_id     = get_field( 'luci_character_photo' );
$name_badge   = get_field( 'luci_name_badge' );
?>
<section class="luci-ai" id="luci-ai">
	<div class="container luci-ai__inner">
		<div class="luci-ai__visual" data-animate>
			<div class="luci-ai__stage">
				<?php lucibook_print_icon( 'LUCIBOOK_LUCI_GLOW_ID', 'luci-ai__glow' ); ?>

				<?php if ( $photo_id ) : ?>
					<?php
					echo wp_get_attachment_image(
						$photo_id,
						'full',
						false,
						array( 'class' => 'luci-ai__photo' )
					);
					?>
				<?php endif; ?>

				<div class="luci-ai__pill luci-ai__pill--tax">
					<?php lucibook_print_icon( 'LUCIBOOK_LUCI_FLAG_ICON_ID', 'luci-ai__pill-icon' ); ?>
					<span>UK tax rules</span>
				</div>

				<div class="luci-ai__pill luci-ai__pill--standards">
					<?php lucibook_print_icon( 'LUCIBOOK_LUCI_ICON_STANDARDS_ID', 'luci-ai__pill-icon' ); ?>
					<span>Accounting standards</span>
				</div>

				<div class="luci-ai__pill luci-ai__pill--legislation">
					<?php lucibook_print_icon( 'LUCIBOOK_LUCI_ICON_LEGISLATION_ID', 'luci-ai__pill-icon' ); ?>
					<span>Legislation</span>
				</div>

				<div class="luci-ai__pill luci-ai__pill--compliance">
					<?php lucibook_print_icon( 'LUCIBOOK_LUCI_ICON_COMPLIANCE_ID', 'luci-ai__pill-icon' ); ?>
					<span>Compliance</span>
				</div>

				<div class="luci-ai__badge">
					<?php echo esc_html( $name_badge ); ?>
				</div>
			</div>
		</div>

		<div class="luci-ai__content" data-animate>
			<p class="luci-ai__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
			<h2 class="luci-ai__headline">
				<?php foreach ( $headline_lines as $line ) : ?>
					<span class="luci-ai__headline-line"><?php echo esc_html( $line ); ?></span>
				<?php endforeach; ?>
			</h2>
			<p class="luci-ai__challenge"><?php echo esc_html( $challenge ); ?></p>
			<p class="luci-ai__positioning"><?php echo esc_html( $positioning ); ?></p>

			<form class="luci-ai__ask" onsubmit="return false;">
				<input type="text" class="luci-ai__ask-input" placeholder="<?php echo esc_attr( $placeholder ); ?>">
				<button type="submit" class="luci-ai__ask-send" aria-label="Ask">
					<?php lucibook_print_icon( 'LUCIBOOK_LUCI_SEND_ICON_ID', 'luci-ai__ask-send-icon' ); ?>
					<span aria-hidden="true">→</span>
				</button>
			</form>
			<p class="luci-ai__input-note"><?php echo esc_html( $input_note ); ?></p>
		</div>
	</div>
</section>
