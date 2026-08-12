<?php
/** about - bottom CTA */
if (!defined('ABSPATH')) exit;
?>
<div class="elementor elementor-12"><div class="elementor-element elementor-element-1dd90da e-con-full e-flex e-con e-parent" data-id="1dd90da" data-element_type="container" data-e-type="container">
				<div class="elementor-element elementor-element-7d33934 elementor-invisible elementor-widget elementor-widget-html" data-id="7d33934" data-element_type="widget" data-e-type="widget" data-settings="{&quot;_animation&quot;:&quot;fadeIn&quot;}" data-widget_type="html.default">
					<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="initial-scale=1, width=device-width">
	<title>Devotel CTA Section</title>
	
<!-- Tailwind CSS CDN -->
<script src="https://cdn.tailwindcss.com"></script>
	
	<!-- Custom Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

<style>
		/* Override Elementor colors - Remove #c94577 */
		.button2,
		.button2:hover,
		.button2:active,
		.button2:focus,
		.button2:visited {
			background-color: #325fec !important;
			color: #fff !important;
			border-color: transparent !important;
		}
		
		.button2 *,
		.button2:hover *,
		.button2:active *,
		.button2:focus * {
			color: #fff !important;
		}
		
		/* Remove any Elementor pink color */
		.button2[style*="#c94577"],
		.button2[style*="rgb(201, 69, 119)"],
		.button2:hover[style*="#c94577"],
		.button2:active[style*="#c94577"] {
			background-color: #325fec !important;
			color: #fff !important;
		}
		
		/* Override Elementor colors for secondary button - Remove #c94577 */
		.try-it-for-free-wrapper,
		.try-it-for-free-wrapper:hover,
		.try-it-for-free-wrapper:active,
		.try-it-for-free-wrapper:focus,
		.try-it-for-free-wrapper:visited {
			background-color: transparent !important;
			color: #fff !important;
			border-color: #94bdfd !important;
		}
		
		.try-it-for-free-wrapper *,
		.try-it-for-free-wrapper:hover *,
		.try-it-for-free-wrapper:active *,
		.try-it-for-free-wrapper:focus * {
			color: #fff !important;
		}
		
		/* Remove any Elementor pink color from secondary button */
		.try-it-for-free-wrapper[style*="#c94577"],
		.try-it-for-free-wrapper[style*="rgb(201, 69, 119)"],
		.try-it-for-free-wrapper:hover[style*="#c94577"],
		.try-it-for-free-wrapper:active[style*="#c94577"] {
			background-color: transparent !important;
			color: #fff !important;
			border-color: #94bdfd !important;
		}
		
		@import url('https://fonts.googleapis.com/css2?family=Inter:wght@600&display=swap');
		
		@font-face {
			font-family: 'Duplet';
			src: local('Inter'), local('Inter-SemiBold');
			font-weight: 600;
			font-style: normal;
		}
		
		.font-duplet {
			font-family: 'Duplet', 'Inter', sans-serif;
			font-weight: 600;
		}
		
		/* Smooth transitions for all interactive elements */
		* {
			transition-property: color, background-color, border-color, transform, opacity;
			transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
			transition-duration: 300ms;
		}
		
		/* Video container - gradient is on the section background */
		.video-wrapper .video-gradient-container video {
			z-index: 2;
			mix-blend-mode: screen;
		}
		
		/* Button styles - matching exact specifications */
		.button {
			position: relative;
            display: flex;
        align-items: center;
        justify-content: center;
            gap: 12px;
			text-align: center;
			font-size: 16px;
			color: #fff;
			font-family: Inter;
		}
		
		:root {
			--Components-Button-Component-paddingInlineLG: 15px;
		}
		
		.button2 {
			border-radius: 10px;
			background-color: #325fec;
        display: flex;
        flex-direction: row;
            align-items: center;
        justify-content: center;
			padding: 0 var(--Components-Button-Component-paddingInlineLG, 15px);
            position: relative;
			overflow: hidden;
			cursor: pointer;
			width: 186px;
			height: 40px;
			box-sizing: border-box;
			text-align: center;
			text-decoration: none;
		}
		
		/* Ensure anchor tags with button2 class are styled correctly */
		a.button2 {
			text-decoration: none !important;
			color: inherit;
		}
		
		.content {
			height: 40px;
            display: flex;
			flex-direction: row;
			align-items: center;
            justify-content: center;
			gap: 4px;
		}
		
		.talk-to-an {
            position: relative;
			line-height: 24px;
			font-weight: 500;
			padding: 0;
			transition: transform 0.3s ease;
        text-align: center;
    }
    
		.button2:hover .talk-to-an {
			transform: translateX(-6px);
		}
		
		
		.icon {
			height: 20px;
			width: 0;
			opacity: 0;
            flex-shrink: 0;
			transform: translateX(-8px);
			transition: width 0.3s ease, opacity 0.3s ease, transform 0.3s ease;
			overflow: hidden;
		}
		
		.button2:hover .icon {
			width: 20px;
			opacity: 1;
			transform: translateX(0);
		}
		
		.button2:hover {
			background-color: #1e4fd9 !important;
		}
		
		.button2:active {
			background-color: #325fec !important;
		}
		
		.button2:focus {
			background-color: #325fec !important;
			outline: none !important;
		}
		
		.button-secondary {
			background-color: transparent !important;
			border-radius: 10px;
			border: 1px solid var(--Border-border-primary, #CAD5E2) !important;
			border-color: var(--Border-border-primary, #CAD5E2) !important;
			width: 158px !important;
			padding: 0 var(--Components-Button-Component-paddingInlineLG, 15px) !important;
			height: 40px !important;
			box-sizing: border-box !important;
		}
		
		.button-secondary:hover {
			background-color: transparent !important;
			border-color: var(--Border-border-primary, #CAD5E2) !important;
		}
		
		.button-secondary:active {
			background-color: transparent !important;
			border-color: var(--Border-border-primary, #CAD5E2) !important;
		}
		
		.button-secondary:focus {
			background-color: transparent !important;
			border-color: var(--Border-border-primary, #CAD5E2) !important;
			outline: none !important;
		}
		
		/* Override Elementor colors for heading - Force white color */
		.content-wrapper h2,
		.content-wrapper h2 *,
		.content-wrapper h2:hover,
		.content-wrapper h2:active,
		.content-wrapper h2:focus,
		.content-wrapper h2:visited {
			color: #fff !important;
		}
		
		/* Remove any Elementor pink color from heading */
		.content-wrapper h2[style*="#c94577"],
		.content-wrapper h2[style*="rgb(201, 69, 119)"] {
			color: #fff !important;
		}
		
		
		/* Video positioning and styling - fully covers container, positioned to the right */
		.video-wrapper {
			position: absolute;
			inset: 0;
			width: 100%;
			height: 100%;
			pointer-events: none;
			overflow: hidden;
		}

		/* Mobile-only video wrapper (hidden by default) */
		.video-wrapper-mobile {
			display: none;
		}
		
		.video-wrapper .video-gradient-container {
			position: absolute;
			inset: 0;
            width: 100%;
			height: 100%;
			background: transparent;
		}
		
		.video-wrapper .video-gradient-container video {
			position: absolute;
			width: 100%;
			height: 100%;
			object-fit: contain;
			object-position: right center;
			right: 0;
			top: 50%;
			transform: translate(-25%, -50%) scale(1.6);
		}
		
		/* Section container - 1440px max width, centered */
		.cta-section-container {
			max-width: 1440px;
			width: 100%;
			margin: 0 auto;
            position: relative;
			height: 100%;
			min-height: 450px;
		}
		
		/* Content positioning adjustments */
		.content-wrapper {
			position: absolute;
			top: 50%;
			left: calc((100% - 1440px) / 2 + 80px);
			transform: translateY(-50%);
			width: 647px;
			max-width: calc(100% - 160px);
		}
		
		@media (max-width: 1440px) {
			.cta-section-container {
				padding: 0 24px;
			}
			
			.content-wrapper {
				left: 80px;
			}
		}
		
		@media (max-width: 1024px) {
			.content-wrapper {
				left: 40px;
				max-width: calc(100% - 80px);
			}
		}
		
		@media (max-width: 768px) {
			/* Section - mobile: adjust padding and height */
			section {
				min-height: auto;
				padding-bottom: 48px;
				background: linear-gradient(164deg, #1E318A 22.26%, #266DF0 79.12%) !important;
			}
			
			/* Section container - mobile layout */
			.cta-section-container {
				padding: 48px 16px 0 16px;
				min-height: auto;
				height: auto;
            display: flex;
            flex-direction: column;
				gap: 32px;
				align-items: center;
            justify-content: flex-start;
            position: relative;
        }
        
			/* Hide desktop video on mobile */
			.video-wrapper {
				display: none;
			}

			/* Mobile video wrapper - show, positioned at bottom, order 4 */
			.video-wrapper-mobile {
				display: block;
				position: relative;
				width: 100%;
				height: 390px;
				order: 4;
				flex-shrink: 0;
				inset: auto;
				pointer-events: none;
				overflow: visible;
			}
			
			.video-wrapper-mobile .video-gradient-container {
				position: relative;
				width: 100%;
				height: 100%;
				inset: auto;
				background: transparent;
			}
			
			.video-wrapper-mobile .video-gradient-container video {
				position: relative;
				width: 100%;
				height: 100%;
				object-fit: contain;
				object-position: center center;
				right: auto;
				top: auto;
				transform: none;
				/* Keep black pixels "transparent" against the gradient */
				mix-blend-mode: screen;
				background-color: transparent;
			}
			
			/* Content wrapper - mobile: relative positioning, full width, stacked, order 1 */
			.content-wrapper {
				position: relative;
				top: auto;
				left: auto;
				transform: none;
				width: 100%;
				max-width: 100%;
				order: 1;
				z-index: 1;
			}
			
			/* Content flex container - mobile: stack vertically */
			.content-wrapper > div {
				display: flex;
				flex-direction: column;
                gap: 32px;
				align-items: flex-start;
				width: 100%;
			}
			
			/* Heading - mobile: smaller font, order 1 */
			.content-wrapper h2,
			.content-wrapper h2.font-duplet {
				color: var(--Text-text-white, #FFF) !important;
				font-family: 'Duplet', 'Inter', sans-serif !important;
				font-size: var(--Font-Size-4xl, 36px) !important;
				font-style: normal !important;
				font-weight: 600 !important;
				line-height: 44px !important;
				letter-spacing: -0.72px !important;
				order: 1;
				width: 100%;
			}
			
			/* Override Tailwind font classes in mobile */
			.content-wrapper h2.font-semibold {
				font-weight: 600 !important;
			}
			
			/* Buttons container - mobile: stack vertically, order 2 */
			.content-wrapper .button {
				flex-direction: column;
				gap: 12px;
				width: 100%;
				order: 2;
			}
			
			/* Primary button - mobile: full width */
			.content-wrapper .button .button2:first-child {
				width: 100% !important;
				align-self: stretch;
			}
			
			/* Secondary button - mobile: full width */
			.content-wrapper .button .button-secondary {
				width: 100% !important;
				align-self: stretch;
			}
			
			/* All buttons in mobile - full width */
			.content-wrapper .button .button2 {
				width: 100% !important;
            }
        }
</style>
</head>
<body>
	<!-- CTA Section -->
	<section class="relative w-full min-h-[450px] bg-gradient-to-r from-[#1e318a] to-[#266df0] overflow-hidden">
		<div class="cta-section-container">
			<!-- Video Background - Fully covers container, positioned to the right -->
			<div class="video-wrapper">
				<div class="video-gradient-container">
					<video 
						autoplay 
						loop 
						muted 
						playsinline
					>
						<source src="https://devotel.com/wp-content/uploads/2025/11/logo-alpha.webm" type="video/webm">
						Your browser does not support the video tag.
					</video>
                </div>
            </div>

			<!-- Video Background (Mobile only) -->
			<div class="video-wrapper-mobile">
				<div class="video-gradient-container">
					<video
						autoplay
						loop
						muted
						playsinline
					>
						<source src="https://devotel.com/wp-content/uploads/2026/01/logo-alpha-mobile.webm" type="video/webm">
						Your browser does not support the video tag.
					</video>
				</div>
			</div>
            
			<!-- Content Container - Left aligned, positioned like image -->
			<div class="content-wrapper relative z-10">
			<div class="flex flex-col items-start gap-8">
				<!-- Heading -->
				<h2 class="text-4xl md:text-5xl lg:text-[48px] font-duplet font-semibold text-white leading-[60px] tracking-[-0.02em] text-left">
					Instantly Everywhere, Always Connected
				</h2>
				
				<!-- Buttons Container -->
				<div class="button">
					<!-- Primary Button -->
					<a href="https://devotel.com/contact-us/" class="button2">
						<div class="content">
							<span class="talk-to-an">Talk to an expert</span>
							<svg 
								class="icon" 
								xmlns="http://www.w3.org/2000/svg" 
								viewBox="0 0 20 20" 
								fill="none"
							>
								<path 
									d="M4.16406 10H15.8307" 
									stroke="currentColor" 
									stroke-width="1.66566" 
									stroke-linecap="round" 
									stroke-linejoin="round"
								/>
								<path 
									d="M10 4.16699L15.8333 10.0003L10 15.8337" 
									stroke="currentColor" 
									stroke-width="1.66566" 
									stroke-linecap="round" 
									stroke-linejoin="round"
								/>
                    </svg>
                </div>
					</a>
					
				 
                </div>
            </div>
                </div>
            </div>
        </div>
	</section>
</body>
</html>
				</div></div>
