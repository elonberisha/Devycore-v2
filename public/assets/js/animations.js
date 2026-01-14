/**
 * Animations JS - GSAP + ScrollTrigger
 * Entrance animations and scroll-based reveals
 */

(function() {
  'use strict';

  // Check if GSAP is loaded
  if (typeof gsap === 'undefined') {
    console.warn('GSAP not loaded. Loading from CDN...');
    loadGSAP();
    return;
  }

  init();

  /**
   * Load GSAP from CDN
   */
  function loadGSAP() {
    const script1 = document.createElement('script');
    script1.src = 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js';
    script1.onload = () => {
      const script2 = document.createElement('script');
      script2.src = 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js';
      script2.onload = init;
      document.head.appendChild(script2);
    };
    document.head.appendChild(script1);
  }

  /**
   * Initialize animations
   */
  function init() {
    console.log('✓ Animations initialized');

    // Register ScrollTrigger plugin
    if (typeof ScrollTrigger !== 'undefined') {
      gsap.registerPlugin(ScrollTrigger);
    }

    // Run animations
    heroAnimation();
    sectionsAnimation();
    cardsAnimation();
    setupParallax();
    setupTextSplitHover();
  }

  /**
   * Hero entrance animation
   */
  function heroAnimation() {
    const tl = gsap.timeline({
      defaults: { ease: 'power3.out' }
    });

    // Animate hero elements
    tl.from('.site-header', {
      y: -100,
      opacity: 0,
      duration: 0.8
    })
    .from('.badge', {
      scale: 0,
      opacity: 0,
      stagger: 0.05,
      duration: 0.5
    }, '-=0.4')
    .from('.section-hero h1', {
      y: 80,
      opacity: 0,
      duration: 1,
      ease: 'power4.out'
    }, '-=0.3')
    .from('.section-hero p', {
      y: 40,
      opacity: 0,
      duration: 0.8
    }, '-=0.6')
    .from('.section-hero .btn', {
      y: 30,
      opacity: 0,
      stagger: 0.1,
      duration: 0.6
    }, '-=0.5')
    .from('.corner-brackets', {
      scale: 0.8,
      opacity: 0,
      rotation: -10,
      duration: 1,
      ease: 'back.out(1.5)'
    }, '-=0.8');

    // Glitch effect on hero title
    const heroTitle = document.querySelector('.section-hero h1');
    if (heroTitle) {
      heroTitle.addEventListener('mouseenter', () => {
        gsap.to(heroTitle, {
          x: '+=3',
          duration: 0.05,
          yoyo: true,
          repeat: 5,
          ease: 'none'
        });
      });
    }
  }

  /**
   * Section reveals on scroll
   */
  function sectionsAnimation() {
    // Animate section numbers
    gsap.utils.toArray('.section-numbered').forEach(section => {
      gsap.from(section, {
        scrollTrigger: {
          trigger: section,
          start: 'top 80%',
          end: 'top 20%',
          toggleActions: 'play none none reverse'
        },
        opacity: 0,
        y: 50,
        duration: 1,
        ease: 'power3.out'
      });
    });

    // Animate section titles
    gsap.utils.toArray('section h2').forEach(title => {
      gsap.from(title, {
        scrollTrigger: {
          trigger: title,
          start: 'top 85%',
          toggleActions: 'play none none none'
        },
        y: 60,
        opacity: 0,
        duration: 0.8,
        ease: 'power3.out'
      });
    });

    // Animate accent lines
    gsap.utils.toArray('.accent-line::before').forEach(line => {
      gsap.from(line, {
        scrollTrigger: {
          trigger: line,
          start: 'top 85%',
          toggleActions: 'play none none none'
        },
        scaleY: 0,
        transformOrigin: 'top',
        duration: 0.6,
        ease: 'power2.out'
      });
    });
  }

  /**
   * Card animations on scroll
   */
  function cardsAnimation() {
    gsap.utils.toArray('.card').forEach((card, index) => {
      gsap.from(card, {
        scrollTrigger: {
          trigger: card,
          start: 'top 90%',
          toggleActions: 'play none none none'
        },
        y: 60,
        opacity: 0,
        scale: 0.95,
        duration: 0.8,
        delay: (index % 4) * 0.1, // Stagger within grid
        ease: 'power3.out'
      });

      // Hover animation enhancement
      card.addEventListener('mouseenter', () => {
        gsap.to(card, {
          scale: 1.02,
          duration: 0.3,
          ease: 'power2.out'
        });
      });

      card.addEventListener('mouseleave', () => {
        gsap.to(card, {
          scale: 1,
          duration: 0.3,
          ease: 'power2.out'
        });
      });
    });
  }

  /**
   * Parallax effects
   */
  function setupParallax() {
    // Parallax for section numbers
    gsap.utils.toArray('.section-numbered::before').forEach(number => {
      gsap.to(number, {
        scrollTrigger: {
          trigger: number,
          start: 'top bottom',
          end: 'bottom top',
          scrub: 1
        },
        y: -100,
        ease: 'none'
      });
    });

    // Parallax for floating shapes (if they exist)
    gsap.utils.toArray('.floating-shape').forEach(shape => {
      gsap.to(shape, {
        scrollTrigger: {
          trigger: 'body',
          start: 'top top',
          end: 'bottom bottom',
          scrub: 2
        },
        y: -200,
        rotation: 360,
        ease: 'none'
      });
    });
  }

  /**
   * Text split hover effect
   */
  function setupTextSplitHover() {
    const glitchElements = document.querySelectorAll('.glitch');

    glitchElements.forEach(el => {
      const text = el.textContent;
      el.setAttribute('data-text', text);

      // Add glitch animation on hover
      el.addEventListener('mouseenter', () => {
        // Trigger glitch effect
        gsap.fromTo(el, {
          x: 0
        }, {
          x: '+=2',
          duration: 0.05,
          yoyo: true,
          repeat: 6,
          ease: 'none',
          onComplete: () => {
            gsap.set(el, { x: 0 });
          }
        });
      });
    });
  }

  /**
   * Button click animation
   */
  gsap.utils.toArray('.btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
      // Only animate if not a form submit
      if (btn.type !== 'submit') {
        gsap.to(btn, {
          scale: 0.95,
          duration: 0.1,
          yoyo: true,
          repeat: 1,
          ease: 'power2.inOut'
        });
      }
    });
  });

  /**
   * Form shake on error
   */
  window.shakeForm = function(formId) {
    const form = document.getElementById(formId);
    if (!form) return;

    gsap.to(form, {
      x: '+=10',
      duration: 0.1,
      yoyo: true,
      repeat: 5,
      ease: 'none'
    });
  };

  /**
   * Counter animation for stats
   */
  window.animateCounter = function(element, target, duration = 2) {
    const obj = { value: 0 };
    gsap.to(obj, {
      value: target,
      duration: duration,
      ease: 'power1.out',
      onUpdate: () => {
        element.textContent = Math.round(obj.value);
      }
    });
  };

  /**
   * Stagger animation for lists
   */
  gsap.utils.toArray('.list-brutal li').forEach((item, index) => {
    gsap.from(item, {
      scrollTrigger: {
        trigger: item,
        start: 'top 90%',
        toggleActions: 'play none none none'
      },
      x: -30,
      opacity: 0,
      duration: 0.5,
      delay: index * 0.05,
      ease: 'power2.out'
    });
  });

  /**
   * Badge pulse animation
   */
  gsap.utils.toArray('.badge-accent').forEach(badge => {
    gsap.to(badge, {
      scale: 1.05,
      duration: 2,
      yoyo: true,
      repeat: -1,
      ease: 'sine.inOut'
    });
  });

  /**
   * Status dot pulse
   */
  gsap.utils.toArray('.status-dot.online').forEach(dot => {
    gsap.to(dot, {
      scale: 1.2,
      opacity: 0.6,
      duration: 1.5,
      yoyo: true,
      repeat: -1,
      ease: 'sine.inOut'
    });
  });

  /**
   * Progress bar animation
   */
  window.animateProgressBar = function(selector, percentage) {
    const bar = document.querySelector(selector + ' .progress-bar');
    if (!bar) return;

    gsap.to(bar, {
      width: percentage + '%',
      duration: 1.5,
      ease: 'power2.out'
    });
  };

  /**
   * Modal entrance/exit animations
   */
  window.showModal = function(modalId) {
    const overlay = document.querySelector('.modal-overlay');
    const modal = document.getElementById(modalId);

    if (!overlay || !modal) return;

    overlay.classList.add('active');
    gsap.from(modal, {
      scale: 0.8,
      opacity: 0,
      duration: 0.3,
      ease: 'back.out(1.5)'
    });
  };

  window.hideModal = function() {
    const overlay = document.querySelector('.modal-overlay');
    const modal = overlay?.querySelector('.modal');

    if (!modal) return;

    gsap.to(modal, {
      scale: 0.8,
      opacity: 0,
      duration: 0.2,
      ease: 'power2.in',
      onComplete: () => {
        overlay.classList.remove('active');
      }
    });
  };

  /**
   * Scroll-triggered counter
   */
  gsap.utils.toArray('[data-count]').forEach(el => {
    const target = parseInt(el.getAttribute('data-count'));

    ScrollTrigger.create({
      trigger: el,
      start: 'top 85%',
      once: true,
      onEnter: () => {
        const obj = { value: 0 };
        gsap.to(obj, {
          value: target,
          duration: 2,
          ease: 'power2.out',
          onUpdate: () => {
            el.textContent = Math.round(obj.value);
          }
        });
      }
    });
  });

  /**
   * Smooth scroll behavior
   */
  if (typeof ScrollTrigger !== 'undefined') {
    ScrollTrigger.config({
      limitCallbacks: true,
      syncInterval: 150
    });

    // Refresh ScrollTrigger after images load
    window.addEventListener('load', () => {
      ScrollTrigger.refresh();
    });
  }

  console.log('✓ GSAP animations ready');

})();
