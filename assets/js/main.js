/**
 * ChrisXCreative front-end interactivity.
 * Dependency-free vanilla JS — no jQuery required.
 */
( function () {
	'use strict';

	document.addEventListener( 'DOMContentLoaded', function () {
		cxcStickyHeader();
		cxcMobileMenu();
		cxcSearchOverlay();
		cxcDarkMode();
		cxcBackToTop();
		cxcScrollReveal();
		cxcTestimonialCarousel();
		cxcPortfolioFilter();
		cxcContactForm();
		cxcSmoothAnchors();
	} );

	/**
	 * Add a "stuck" class to the header once the page scrolls, for a subtle
	 * shadow — purely visual, CSS position:sticky already does the work.
	 */
	function cxcStickyHeader() {
		var header = document.getElementById( 'masthead' );
		if ( ! header || 'on' !== header.getAttribute( 'data-sticky' ) ) {
			return;
		}
		var toggle = function () {
			if ( window.scrollY > 12 ) {
				header.classList.add( 'is-stuck' );
			} else {
				header.classList.remove( 'is-stuck' );
			}
		};
		window.addEventListener( 'scroll', toggle, { passive: true } );
		toggle();
	}

	/**
	 * Off-canvas mobile menu open/close + submenu expand/collapse.
	 */
	function cxcMobileMenu() {
		var toggle    = document.querySelector( '.cxc-menu-toggle' );
		var menu      = document.getElementById( 'cxc-mobile-menu' );
		var backdrop  = document.querySelector( '[data-cxc-mobile-backdrop]' );
		var closeBtn  = document.querySelector( '[data-cxc-mobile-close]' );

		if ( ! menu ) {
			return;
		}

		function openMenu() {
			menu.classList.add( 'is-active' );
			backdrop && backdrop.classList.add( 'is-active' );
			menu.setAttribute( 'aria-hidden', 'false' );
			document.body.style.overflow = 'hidden';
			if ( toggle ) {
				toggle.setAttribute( 'aria-expanded', 'true' );
			}
		}

		function closeMenu() {
			menu.classList.remove( 'is-active' );
			backdrop && backdrop.classList.remove( 'is-active' );
			menu.setAttribute( 'aria-hidden', 'true' );
			document.body.style.overflow = '';
			if ( toggle ) {
				toggle.setAttribute( 'aria-expanded', 'false' );
			}
		}

		if ( toggle ) {
			toggle.addEventListener( 'click', function () {
				var expanded = toggle.getAttribute( 'aria-expanded' ) === 'true';
				expanded ? closeMenu() : openMenu();
			} );
		}
		closeBtn && closeBtn.addEventListener( 'click', closeMenu );
		backdrop && backdrop.addEventListener( 'click', closeMenu );

		document.addEventListener( 'keydown', function ( e ) {
			if ( 'Escape' === e.key ) {
				closeMenu();
			}
		} );

		menu.querySelectorAll( '.mobile-submenu-toggle' ).forEach( function ( btn ) {
			btn.addEventListener( 'click', function () {
				var li = btn.closest( 'li' );
				var open = li.classList.toggle( 'submenu-open' );
				btn.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
			} );
		} );
	}

	/**
	 * Full-screen search overlay.
	 */
	function cxcSearchOverlay() {
		var openBtn  = document.querySelector( '.cxc-search-toggle' );
		var overlay  = document.querySelector( '[data-cxc-search-overlay]' );
		var closeBtn = document.querySelector( '[data-cxc-search-close]' );

		if ( ! openBtn || ! overlay ) {
			return;
		}

		function open() {
			overlay.classList.add( 'is-active' );
			openBtn.setAttribute( 'aria-expanded', 'true' );
			var field = overlay.querySelector( 'input[type=search]' );
			field && setTimeout( function () { field.focus(); }, 100 );
		}
		function close() {
			overlay.classList.remove( 'is-active' );
			openBtn.setAttribute( 'aria-expanded', 'false' );
		}

		openBtn.addEventListener( 'click', open );
		closeBtn && closeBtn.addEventListener( 'click', close );
		document.addEventListener( 'keydown', function ( e ) {
			if ( 'Escape' === e.key ) {
				close();
			}
		} );
	}

	/**
	 * Light / dark mode toggle, persisted in localStorage.
	 */
	function cxcDarkMode() {
		var toggle = document.querySelector( '.cxc-theme-toggle' );
		var root   = document.documentElement;
		var stored;

		try {
			stored = window.localStorage.getItem( 'cxc-theme' );
		} catch ( err ) {
			stored = null;
		}

		if ( stored ) {
			root.setAttribute( 'data-cxc-theme', stored );
			document.body && document.body.setAttribute( 'data-cxc-theme', stored );
		}

		if ( ! toggle ) {
			return;
		}

		toggle.addEventListener( 'click', function () {
			var current = root.getAttribute( 'data-cxc-theme' ) === 'dark' ? 'dark' : 'light';
			var next    = 'dark' === current ? 'light' : 'dark';
			root.setAttribute( 'data-cxc-theme', next );
			document.body.setAttribute( 'data-cxc-theme', next );
			try {
				window.localStorage.setItem( 'cxc-theme', next );
			} catch ( err ) {
				/* localStorage unavailable — theme just won't persist */
			}
		} );
	}

	/**
	 * Back-to-top button visibility + click handler.
	 */
	function cxcBackToTop() {
		var btn = document.querySelector( '[data-cxc-back-to-top]' );
		if ( ! btn ) {
			return;
		}
		window.addEventListener(
			'scroll',
			function () {
				btn.classList.toggle( 'is-visible', window.scrollY > 600 );
			},
			{ passive: true }
		);
		btn.addEventListener( 'click', function () {
			window.scrollTo( { top: 0, behavior: 'smooth' } );
		} );
	}

	/**
	 * Fade/slide elements into view on scroll using IntersectionObserver.
	 */
	function cxcScrollReveal() {
		var items = document.querySelectorAll( '.reveal' );
		if ( ! items.length ) {
			return;
		}
		if ( ! ( 'IntersectionObserver' in window ) ) {
			items.forEach( function ( el ) { el.classList.add( 'is-visible' ); } );
			return;
		}
		var observer = new IntersectionObserver(
			function ( entries ) {
				entries.forEach( function ( entry ) {
					if ( entry.isIntersecting ) {
						entry.target.classList.add( 'is-visible' );
						observer.unobserve( entry.target );
					}
				} );
			},
			{ threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
		);
		items.forEach( function ( el, i ) {
			el.style.transitionDelay = Math.min( i % 4, 3 ) * 0.08 + 's';
			observer.observe( el );
		} );
	}

	/**
	 * Scroll-snap testimonial carousel prev/next buttons.
	 */
	function cxcTestimonialCarousel() {
		var track = document.querySelector( '[data-cxc-testimonial-track]' );
		var prev  = document.querySelector( '[data-cxc-testimonial-prev]' );
		var next  = document.querySelector( '[data-cxc-testimonial-next]' );
		if ( ! track ) {
			return;
		}
		function scrollByCard( dir ) {
			var card = track.querySelector( '.testimonial-card' );
			var amount = card ? card.getBoundingClientRect().width + 28 : 340;
			track.scrollBy( { left: dir * amount, behavior: 'smooth' } );
		}
		prev && prev.addEventListener( 'click', function () { scrollByCard( -1 ); } );
		next && next.addEventListener( 'click', function () { scrollByCard( 1 ); } );
	}

	/**
	 * Client-side portfolio category filter (no external library).
	 */
	function cxcPortfolioFilter() {
		var wraps = document.querySelectorAll( '[data-cxc-portfolio-filters]' );
		wraps.forEach( function ( wrap ) {
			var grid = wrap.parentElement.querySelector( '[data-cxc-portfolio-grid]' );
			if ( ! grid ) {
				return;
			}
			wrap.addEventListener( 'click', function ( e ) {
				var btn = e.target.closest( 'button' );
				if ( ! btn ) {
					return;
				}
				wrap.querySelectorAll( 'button' ).forEach( function ( b ) { b.classList.remove( 'is-active' ); } );
				btn.classList.add( 'is-active' );

				var filter = btn.getAttribute( 'data-filter' );
				grid.querySelectorAll( '.portfolio-item' ).forEach( function ( item ) {
					var cats = ( item.getAttribute( 'data-category' ) || '' ).split( ' ' );
					var show = '*' === filter || cats.indexOf( filter ) !== -1;
					item.hidden = ! show;
				} );
			} );
		} );
	}

	/**
	 * AJAX-submit the built-in contact form without a page reload.
	 */
	function cxcContactForm() {
		var form = document.getElementById( 'cxc-contact-form' );
		if ( ! form || 'undefined' === typeof cxcData ) {
			return;
		}

		form.addEventListener( 'submit', function ( e ) {
			e.preventDefault();

			var noticeWrap = form.querySelector( '.cxc-form-notice-wrap' );
			var submitBtn  = form.querySelector( 'button[type=submit]' );
			var formData   = new FormData( form );

			formData.append( 'action', 'cxc_contact_form' );
			formData.append( 'nonce', cxcData.nonce );

			submitBtn.disabled = true;
			submitBtn.classList.add( 'is-loading' );
			noticeWrap.innerHTML = '';

			fetch( cxcData.ajaxUrl, {
				method: 'POST',
				credentials: 'same-origin',
				body: formData,
			} )
				.then( function ( response ) { return response.json(); } )
				.then( function ( data ) {
					var isSuccess = !! data.success;
					var message   = ( data.data && data.data.message ) || '';
					noticeWrap.innerHTML = '<div class="cxc-form-notice ' + ( isSuccess ? 'success' : 'error' ) + '">' + message + '</div>';
					if ( isSuccess ) {
						form.reset();
					}
				} )
				.catch( function () {
					noticeWrap.innerHTML = '<div class="cxc-form-notice error">Something went wrong. Please try again.</div>';
				} )
				.finally( function () {
					submitBtn.disabled = false;
					submitBtn.classList.remove( 'is-loading' );
				} );
		} );
	}

	/**
	 * Smooth-scroll same-page anchor links (e.g. header CTA -> #contact),
	 * accounting for the sticky header height.
	 */
	function cxcSmoothAnchors() {
		document.querySelectorAll( 'a[href^="#"]' ).forEach( function ( link ) {
			var hash = link.getAttribute( 'href' );
			if ( ! hash || hash.length < 2 ) {
				return;
			}
			var target = document.getElementById( hash.slice( 1 ) );
			if ( ! target ) {
				return;
			}
			link.addEventListener( 'click', function ( e ) {
				e.preventDefault();
				var header = document.getElementById( 'masthead' );
				var offset = header ? header.offsetHeight + 20 : 20;
				var top    = target.getBoundingClientRect().top + window.pageYOffset - offset;
				window.scrollTo( { top: top, behavior: 'smooth' } );
			} );
		} );
	}
} )();
