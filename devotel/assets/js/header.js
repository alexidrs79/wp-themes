/**
 * Header interactions from reference header.html (mega menu + mobile menu).
 */
(function () {
	'use strict';

	document.addEventListener('DOMContentLoaded', function () {
    (function() {
        'use strict';
        
			// Tab order for direction detection (removed header-resources-parent)
			const tabOrder = ['header-products-parent', 'header-telco-parent', 'header-company-parent'];
			let currentActiveTab = null;
			let previousActiveTab = null;

			// Get all elements
			const productsParent = document.querySelector('.header-products-parent');
			const telcoParent = document.querySelector('.header-telco-parent');
			const companyParent = document.querySelector('.header-company-parent');
			const resourcesParent = document.querySelector('.header-resources-parent');
			const platform = document.querySelector('.header-platform');
			const telco = document.querySelector('.header-telco');
			const company = document.querySelector('.header-company');
			const resources = document.querySelector('.header-resources');

			if (!productsParent || !platform) return;

			// Map parents to dropdowns (removed resources)
			const dropdownMap = {
				'header-products-parent': platform,
				'header-telco-parent': telco,
				'header-company-parent': company
			};

			// Function to force align all dropdowns to Products position
			function forceAlignDropdowns() {
				// Get Products parent bounding box
				const productsRect = productsParent.getBoundingClientRect();
				const productsLeft = productsRect.left;
				
				// Align each dropdown (removed resources)
				const dropdowns = [
					{ el: telco, parent: telcoParent },
					{ el: company, parent: companyParent }
				];
				
				dropdowns.forEach(({ el, parent }) => {
					if (!el || !parent) return;
					
					const parentRect = parent.getBoundingClientRect();
					const offset = productsLeft - parentRect.left;
					
					// Force the position
					el.style.cssText = el.style.cssText.replace(/left\s*:\s*[^;]+;?/gi, '');
					el.style.cssText += `left: ${offset}px !important;`;
				});
				
				// Ensure Products is at 0
				platform.style.cssText = platform.style.cssText.replace(/left\s*:\s*[^;]+;?/gi, '');
				platform.style.cssText += 'left: 0px !important;';
			}

			// Function to get tab index
			function getTabIndex(element) {
				if (!element) return -1;
				for (let i = 0; i < tabOrder.length; i++) {
					if (element.classList.contains(tabOrder[i])) {
						return i;
					}
				}
				return -1;
			}

			// Function to determine slide direction
			function getSlideDirection(fromTab, toTab) {
				const fromIndex = getTabIndex(fromTab);
				const toIndex = getTabIndex(toTab);
				if (fromIndex === -1 || toIndex === -1) return 'right';
				return toIndex > fromIndex ? 'right' : 'left';
			}

			// Function to handle dropdown animation
			function handleDropdownHover(parentElement, dropdownElement) {
				// Determine direction based on which tab we're coming from
				let direction = 'right'; // default
				
				// Use currentActiveTab as the "from" tab (the one we're leaving)
				if (currentActiveTab && currentActiveTab !== parentElement) {
					direction = getSlideDirection(currentActiveTab, parentElement);
				}
				
				// Remove all animation classes first
				dropdownElement.classList.remove('header-slide-from-left', 'header-slide-from-right');
				
				// Force reflow to reset any previous transforms
				void dropdownElement.offsetWidth;
				
				// Add the appropriate animation class BEFORE hover state applies
				const slideClass = direction === 'left' ? 'header-slide-from-left' : 'header-slide-from-right';
				dropdownElement.classList.add(slideClass);
				
				// Small delay to ensure class is applied before CSS transition
				setTimeout(() => {
					// The hover state CSS will handle animating to translateX(0)
				}, 0);
				
				// Update tracking - move current to previous, set new current
				previousActiveTab = currentActiveTab;
				currentActiveTab = parentElement;
			}

			// Add event listeners - order must match tabOrder (removed resourcesParent)
			[productsParent, telcoParent, companyParent].forEach((parent, index) => {
				if (!parent) return;
				const parentClass = tabOrder[index];
				const dropdown = dropdownMap[parentClass];
				if (!dropdown) return;

				parent.addEventListener('mouseenter', () => {
					forceAlignDropdowns();
					setTimeout(forceAlignDropdowns, 0);
					setTimeout(forceAlignDropdowns, 10);
					handleDropdownHover(parent, dropdown);
				});
			});

			// Initialize
			if (productsParent) {
				currentActiveTab = productsParent;
				previousActiveTab = productsParent;
			}

			// Continuous alignment - run every few frames
			let frameCount = 0;
			function alignmentLoop() {
				frameCount++;
				// Run every 3 frames to balance performance and accuracy
				if (frameCount % 3 === 0) {
					forceAlignDropdowns();
				}
				requestAnimationFrame(alignmentLoop);
			}

			// Start alignment loop
			alignmentLoop();

			// Also align on events
			window.addEventListener('load', forceAlignDropdowns);
			window.addEventListener('resize', forceAlignDropdowns);
			window.addEventListener('scroll', forceAlignDropdowns);
			
			// Initial alignment
			setTimeout(forceAlignDropdowns, 0);
			setTimeout(forceAlignDropdowns, 100);
			setTimeout(forceAlignDropdowns, 300);

			const headerWrapper = document.querySelector('.header-navbar-wrapper');
			if (headerWrapper) {
				const headerClassObserver = new MutationObserver(function () {
					forceAlignDropdowns();
					if (typeof window.devotelSyncMobileMenuPanel === 'function') {
						window.devotelSyncMobileMenuPanel();
					}
				});
				headerClassObserver.observe(headerWrapper, {
					attributes: true,
					attributeFilter: ['class'],
				});
			}
		})();

		// Mobile Menu Toggle
  (function() {
			function getHeaderWrapper() {
				if (typeof window.devotelGetHeaderWrapper === 'function') {
					return window.devotelGetHeaderWrapper();
				}
				return (
					document.querySelector('.header-navbar-wrapper.devotel-header-elevated') ||
					document.querySelector('#site-header .header-navbar-wrapper') ||
					document.querySelector('.header-navbar-wrapper')
				);
			}

			function getMenuButton() {
				const wrapper = getHeaderWrapper();
				return wrapper ? wrapper.querySelector('.header-mobile-menu-button') : null;
			}

			function getMenuOverlay() {
				const wrapper = getHeaderWrapper();
				return wrapper
					? wrapper.querySelector('#mobileMenuOverlay')
					: document.getElementById('mobileMenuOverlay');
			}

			const mobileMenuItems = document.querySelectorAll(
				'.header-navbar-wrapper .mobile-menu-item[data-dropdown]'
			);
			let scrollPosition = 0;

			function syncPanelPosition() {
				const mobileMenuOverlay = getMenuOverlay();
				if (
					!mobileMenuOverlay ||
					!mobileMenuOverlay.classList.contains("active")
				) {
					return;
				}
				if (typeof window.devotelSyncMobileMenuPanel === "function") {
					window.devotelSyncMobileMenuPanel();
				}
			}

			function setMenuOpenState(isOpen) {
				document.body.classList.toggle("devotel-mobile-menu-open", isOpen);
				setMenuButtonOpen(isOpen);
			}

			function setMenuButtonOpen(isOpen) {
				const mobileMenuButton = getMenuButton();
				if (!mobileMenuButton) {
					return;
				}
				mobileMenuButton.classList.toggle('is-open', isOpen);
				mobileMenuButton.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
				mobileMenuButton.setAttribute('aria-label', isOpen ? 'Close menu' : 'Open menu');
			}
			
			function lockBodyScroll() {
				if (typeof window.devotelLockBodyScroll === "function") {
					window.devotelLockBodyScroll();
					return;
				}
				scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
				document.body.style.position = "fixed";
				document.body.style.top = "-" + scrollPosition + "px";
				document.body.style.width = "100%";
				document.documentElement.style.overflow = "hidden";
				document.body.style.overflow = "hidden";
			}
			
			function unlockBodyScroll() {
				if (typeof window.devotelUnlockBodyScroll === "function") {
					window.devotelUnlockBodyScroll();
					return;
				}
				document.documentElement.style.overflow = "";
				document.body.style.overflow = "";
				document.body.style.position = "";
				document.body.style.top = "";
				document.body.style.width = "";
				var y = scrollPosition || 0;
				if (y > 0) {
					requestAnimationFrame(function() {
						window.scrollTo(0, y);
					});
				}
			}

			function openMobileMenu() {
				const mobileMenuOverlay = getMenuOverlay();
				if (!mobileMenuOverlay) {
					return;
				}
				mobileMenuOverlay.classList.remove("devotel-menu-closing");
					lockBodyScroll();
				requestAnimationFrame(function() {
					mobileMenuOverlay.classList.add("active");
					setMenuOpenState(true);
					if (typeof window.devotelSyncMobileMenuHeaderLayout === "function") {
						window.devotelSyncMobileMenuHeaderLayout();
					}
					requestAnimationFrame(function() {
						syncPanelPosition();
						setTimeout(syncPanelPosition, 360);
					});
				});
			}
			
			function closeMobileMenu() {
				const mobileMenuOverlay = getMenuOverlay();
				if (!mobileMenuOverlay || !mobileMenuOverlay.classList.contains("active")) {
					return;
				}

				const menuCloseDuration = 320;

				if (typeof window.devotelSyncMobileMenuPanel === "function") {
					window.devotelSyncMobileMenuPanel();
				}

				mobileMenuOverlay.classList.remove("active");
				mobileMenuOverlay.classList.add("devotel-menu-closing");
					document.querySelectorAll('.mobile-menu-dropdown').forEach(dropdown => {
						dropdown.classList.remove('active');
					});
					const mobileLoginDropdown = document.getElementById('mobileLoginDropdown');
					if (mobileLoginDropdown) {
						mobileLoginDropdown.classList.remove('active');
					}
					document.querySelectorAll('.mobile-menu-chevron').forEach(chevron => {
						chevron.style.transform = 'rotate(0deg)';
					});
				window.devotelMenuClosing = true;
					setTimeout(function() {
					setMenuOpenState(false);
					mobileMenuOverlay.classList.remove("devotel-menu-closing");
					if (typeof window.devotelClearMobileMenuPanel === "function") {
						window.devotelClearMobileMenuPanel();
					}
						unlockBodyScroll();
					window.devotelMenuClosing = false;
				}, menuCloseDuration);
			}
			
			if (getMenuButton() && getMenuOverlay()) {
				const mobileMenuButton = getMenuButton();
				const mobileMenuOverlay = getMenuOverlay();
				mobileMenuButton.addEventListener('click', function(e) {
					e.preventDefault();
					e.stopPropagation();
					if (mobileMenuOverlay.classList.contains('active')) {
					closeMobileMenu();
					} else {
						openMobileMenu();
					}
				});
			}

			document.addEventListener('keydown', function(e) {
				if (e.key === 'Escape') {
					closeMobileMenu();
				}
			});

			document.addEventListener("click", function(e) {
				const mobileMenuOverlay = getMenuOverlay();
				if (!mobileMenuOverlay || !mobileMenuOverlay.classList.contains("active")) {
					return;
				}
				const headerWrapper = getHeaderWrapper();
				const navbarMain = headerWrapper
					? headerWrapper.querySelector(".header-navbar-main")
					: null;
				const menuButton = getMenuButton();
				if (menuButton && menuButton.contains(e.target)) {
					return;
				}
				if (navbarMain && navbarMain.contains(e.target)) {
					return;
				}
				if (mobileMenuOverlay.contains(e.target)) {
					return;
				}
				closeMobileMenu();
			});

			window.addEventListener("resize", syncPanelPosition);
			window.addEventListener("scroll", syncPanelPosition, { passive: true });

			window.devotelCloseMobileMenu = closeMobileMenu;
			
			// Close menu when tapping backdrop (outside panel content/footer)
			const mobileMenuOverlayEl = getMenuOverlay();
			if (mobileMenuOverlayEl) {
				mobileMenuOverlayEl.addEventListener('click', function(e) {
					if (e.target === mobileMenuOverlayEl) {
						closeMobileMenu();
					}
				});
			}
			
			// Toggle dropdowns when tapped
			mobileMenuItems.forEach(item => {
				item.addEventListener('click', function(e) {
					e.preventDefault();
					e.stopPropagation();
					const dropdownName = this.getAttribute('data-dropdown');
					const dropdown = document.getElementById('mobileDropdown-' + dropdownName);
					const chevron = this.querySelector('.mobile-menu-chevron');
					
					if (dropdown) {
						const isActive = dropdown.classList.contains('active');
						
						// Close all other dropdowns and reset their chevrons
						document.querySelectorAll('.mobile-menu-dropdown').forEach(d => {
							if (d !== dropdown) {
								d.classList.remove('active');
							}
						});
						document.querySelectorAll('.mobile-menu-chevron').forEach(c => {
							if (c !== chevron) {
								c.style.transform = 'rotate(0deg)';
							}
						});
						
						// Toggle current dropdown
						if (isActive) {
							// Close it
							dropdown.classList.remove('active');
							if (chevron) {
								chevron.style.transform = 'rotate(0deg)';
							}
        } else {
							// Open it
							dropdown.classList.add('active');
							if (chevron) {
								chevron.style.transform = 'rotate(180deg)';
							}
							// Smooth scroll to menu item to keep it in view
							setTimeout(() => {
								this.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
							}, 50);
						}
					}
				});
			});
			
			// Prevent body scroll when menu is open, but allow scrolling in content area
			const mobileMenuContent = document.getElementById('mobileMenuContent');
			const mobileMenuOverlayForTouch = getMenuOverlay();
			if (mobileMenuOverlayForTouch && mobileMenuContent) {
				// Prevent scrolling on overlay background
				mobileMenuOverlayForTouch.addEventListener('touchmove', function(e) {
					if (mobileMenuOverlayForTouch.classList.contains('active')) {
						// Allow clicks on buttons and interactive elements
						if (e.target.closest('button') || e.target.closest('a')) {
							return;
						}
						// Only allow scrolling if touching the content area
						if (!mobileMenuContent.contains(e.target)) {
							e.preventDefault();
						}
					}
				}, { passive: false });
				
				// Prevent body scroll when touching outside content
				document.addEventListener('touchmove', function(e) {
					const mobileMenuOverlay = getMenuOverlay();
					if (mobileMenuOverlay && mobileMenuOverlay.classList.contains('active')) {
						// Allow clicks on buttons and interactive elements
						if (e.target.closest('button') || e.target.closest('a')) {
							return;
						}
						// If not touching the menu overlay or content, prevent scroll
						if (!mobileMenuOverlay.contains(e.target)) {
							e.preventDefault();
						}
					}
				}, { passive: false });
			}
			
			// Mobile Login Dropdown Toggle
			const mobileLoginButton = document.getElementById('mobileLoginButton');
			const mobileLoginDropdown = document.getElementById('mobileLoginDropdown');
			const mobileLoginWrapper = document.querySelector('.mobile-login-wrapper');
			
			if (mobileLoginButton && mobileLoginDropdown) {
				function toggleLoginDropdown(e) {
					if (e) {
						e.preventDefault();
						e.stopPropagation();
					}
					
					// Toggle dropdown
					const isActive = mobileLoginDropdown.classList.contains('active');
					
					if (isActive) {
						mobileLoginDropdown.classList.remove('active');
					} else {
						mobileLoginDropdown.classList.add('active');
					}
				}
				
				mobileLoginButton.addEventListener('click', toggleLoginDropdown);
				
				// Also handle touch events for mobile
				mobileLoginButton.addEventListener('touchend', function(e) {
					e.preventDefault();
					e.stopPropagation();
					toggleLoginDropdown(e);
				});
				
				// Close dropdown when clicking outside
				document.addEventListener('click', function(e) {
					if (mobileLoginDropdown && mobileLoginWrapper) {
						if (!mobileLoginWrapper.contains(e.target)) {
							mobileLoginDropdown.classList.remove('active');
						}
					}
				});
				
				// Force remove #cc3366 color from mobile login button
				function preventPinkColor() {
					if (mobileLoginButton) {
						const computedStyle = window.getComputedStyle(mobileLoginButton);
						if (computedStyle.backgroundColor === 'rgb(204, 51, 102)' || 
						    computedStyle.backgroundColor === '#cc3366' ||
						    mobileLoginButton.style.backgroundColor === '#cc3366' ||
						    mobileLoginButton.style.backgroundColor === 'rgb(204, 51, 102)') {
							mobileLoginButton.style.backgroundColor = 'transparent';
							mobileLoginButton.style.background = 'transparent';
						}
					}
				}
				
				// Check on hover
				mobileLoginButton.addEventListener('mouseenter', preventPinkColor);
				mobileLoginButton.addEventListener('mouseleave', preventPinkColor);
				mobileLoginButton.addEventListener('click', preventPinkColor);
				
				// Use MutationObserver to watch for style changes
				if (mobileLoginButton) {
					const observer = new MutationObserver(function(mutations) {
						mutations.forEach(function(mutation) {
							if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
								preventPinkColor();
							}
						});
					});
					observer.observe(mobileLoginButton, { attributes: true, attributeFilter: ['style'] });
				}
			}
    })();
	});
    })();
