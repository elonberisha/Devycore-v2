/**
 * Page Transitions & Section Animations
 * Extravagant animations for all sections with scroll-based effects
 */

(function() {
  'use strict';

  let sections = [];
  let currentSection = 0;
  let isAnimating = false;

  function init() {
    // Get all sections
    sections = document.querySelectorAll('section');

    if (sections.length === 0) return;

    // Add scroll-based section transitions
    setupSectionTransitions();

    // Add particle effects to section dividers
    setupParticleEffects();

    // Add animated borders to cards
    setupCardAnimations();

    // Add glitch effects on scroll
    setupGlitchEffects();

    // Add floating elements
    setupFloatingElements();

    // Listen for scroll events
    window.addEventListener('scroll', handleScroll, { passive: true });

    console.log('✓ Page transitions initialized');
  }

  function setupSectionTransitions() {
    sections.forEach((section, index) => {
      // Add initial state
      section.style.opacity = '0';
      section.style.transform = 'translateY(100px)';
      section.style.transition = 'opacity 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94), transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94)';

      // Create intersection observer for each section
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting && !isAnimating) {
            animateSectionEntrance(entry.target, index);
          }
        });
      }, {
        threshold: 0.15,
        rootMargin: '-50px'
      });

      observer.observe(section);
    });
  }

  function animateSectionEntrance(section, index) {
    isAnimating = true;

    // Fade and slide up
    section.style.opacity = '1';
    section.style.transform = 'translateY(0)';

    // Create particle burst at section entrance
    createSectionBurst(section);

    // Add ripple effect
    createRippleEffect(section);

    // Animate section number if it exists
    const sectionNumber = section.querySelector('.section-numbered::before');
    if (section.classList.contains('section-numbered')) {
      animateSectionNumber(section);
    }

    // Stagger animate children
    const children = section.querySelectorAll('.card, .grid > *, h1, h2, h3, p, .btn');
    children.forEach((child, i) => {
      setTimeout(() => {
        child.style.opacity = '0';
        child.style.transform = 'translateY(30px) scale(0.95)';

        setTimeout(() => {
          child.style.transition = 'all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1)';
          child.style.opacity = '1';
          child.style.transform = 'translateY(0) scale(1)';
        }, 50);
      }, i * 80);
    });

    setTimeout(() => {
      isAnimating = false;
    }, 1000);
  }

  function createSectionBurst(section) {
    const rect = section.getBoundingClientRect();
    const centerX = rect.left + rect.width / 2;
    const centerY = rect.top + window.scrollY + 100;

    for (let i = 0; i < 30; i++) {
      const particle = document.createElement('div');
      const angle = (Math.PI * 2 * i) / 30;
      const distance = 100 + Math.random() * 150;
      const size = 2 + Math.random() * 4;

      particle.style.cssText = `
        position: absolute;
        width: ${size}px;
        height: ${size}px;
        background: ${Math.random() > 0.5 ? 'var(--accent-primary)' : 'var(--accent-hot)'};
        border-radius: 50%;
        top: ${centerY}px;
        left: ${centerX}px;
        pointer-events: none;
        z-index: 9999;
        box-shadow: 0 0 10px currentColor;
      `;

      document.body.appendChild(particle);

      const endX = centerX + Math.cos(angle) * distance;
      const endY = centerY + Math.sin(angle) * distance;

      particle.animate([
        {
          transform: 'translate(-50%, -50%) scale(0)',
          opacity: 1
        },
        {
          transform: `translate(${endX - centerX}px, ${endY - centerY}px) scale(1)`,
          opacity: 1
        },
        {
          transform: `translate(${(endX - centerX) * 1.5}px, ${(endY - centerY) * 1.5}px) scale(0)`,
          opacity: 0
        }
      ], {
        duration: 1200 + Math.random() * 400,
        easing: 'cubic-bezier(0.25, 0.46, 0.45, 0.94)'
      }).onfinish = () => particle.remove();
    }
  }

  function createRippleEffect(section) {
    const ripple = document.createElement('div');
    const rect = section.getBoundingClientRect();

    ripple.style.cssText = `
      position: absolute;
      top: ${rect.top + window.scrollY}px;
      left: ${rect.left}px;
      width: ${rect.width}px;
      height: ${rect.height}px;
      border: 3px solid var(--accent-primary);
      pointer-events: none;
      z-index: 9998;
      opacity: 0.8;
    `;

    document.body.appendChild(ripple);

    ripple.animate([
      {
        transform: 'scale(0.8)',
        opacity: 0.8,
        borderWidth: '3px'
      },
      {
        transform: 'scale(1.05)',
        opacity: 0,
        borderWidth: '0px'
      }
    ], {
      duration: 800,
      easing: 'ease-out'
    }).onfinish = () => ripple.remove();
  }

  function animateSectionNumber(section) {
    // Animate the large background number
    const animation = section.animate([
      {
        opacity: 0,
        transform: 'scale(0.5) rotate(-10deg)'
      },
      {
        opacity: 0.3,
        transform: 'scale(1) rotate(0deg)'
      }
    ], {
      duration: 1000,
      easing: 'cubic-bezier(0.34, 1.56, 0.64, 1)',
      fill: 'forwards',
      pseudoElement: '::before'
    });
  }

  function setupParticleEffects() {
    // Add floating particles to the page
    const particleContainer = document.createElement('div');
    particleContainer.id = 'floatingParticles';
    particleContainer.style.cssText = `
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
      z-index: 1;
      overflow: hidden;
    `;
    document.body.appendChild(particleContainer);

    // Create 15 floating particles
    for (let i = 0; i < 15; i++) {
      createFloatingParticle(particleContainer, i);
    }
  }

  function createFloatingParticle(container, index) {
    const particle = document.createElement('div');
    const size = 3 + Math.random() * 5;
    const startX = Math.random() * window.innerWidth;
    const startY = Math.random() * window.innerHeight;

    particle.style.cssText = `
      position: absolute;
      width: ${size}px;
      height: ${size}px;
      background: ${Math.random() > 0.5 ? 'var(--accent-primary)' : 'var(--accent-hot)'};
      border-radius: 50%;
      top: ${startY}px;
      left: ${startX}px;
      box-shadow: 0 0 10px currentColor;
      opacity: 0.6;
    `;

    container.appendChild(particle);

    // Animate particle floating
    const duration = 20000 + Math.random() * 15000;
    const endX = Math.random() * window.innerWidth;
    const endY = Math.random() * window.innerHeight;

    function animateParticle() {
      particle.animate([
        {
          transform: `translate(0, 0) scale(1)`,
          opacity: 0.6
        },
        {
          transform: `translate(${endX - startX}px, ${endY - startY}px) scale(1.5)`,
          opacity: 0.3
        },
        {
          transform: `translate(0, 0) scale(1)`,
          opacity: 0.6
        }
      ], {
        duration: duration,
        iterations: Infinity,
        easing: 'ease-in-out',
        delay: index * 1000
      });
    }

    animateParticle();
  }

  function setupCardAnimations() {
    const cards = document.querySelectorAll('.card');

    cards.forEach(card => {
      // Add animated border on hover
      card.addEventListener('mouseenter', (e) => {
        const border = document.createElement('div');
        border.className = 'animated-border';
        border.style.cssText = `
          position: absolute;
          inset: -3px;
          background: linear-gradient(45deg, var(--accent-primary), var(--accent-hot), var(--accent-primary));
          background-size: 300% 300%;
          z-index: -1;
          opacity: 0;
          animation: gradientShift 3s ease infinite;
        `;

        card.style.position = 'relative';
        card.appendChild(border);

        border.animate([
          { opacity: 0 },
          { opacity: 1 }
        ], {
          duration: 300,
          fill: 'forwards'
        });
      });

      card.addEventListener('mouseleave', (e) => {
        const border = card.querySelector('.animated-border');
        if (border) {
          border.animate([
            { opacity: 1 },
            { opacity: 0 }
          ], {
            duration: 300
          }).onfinish = () => border.remove();
        }
      });

      // Add click ripple effect
      card.addEventListener('click', (e) => {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        const ripple = document.createElement('div');
        ripple.style.cssText = `
          position: absolute;
          top: ${y}px;
          left: ${x}px;
          width: 10px;
          height: 10px;
          background: var(--accent-primary);
          border-radius: 50%;
          transform: translate(-50%, -50%);
          pointer-events: none;
          z-index: 100;
        `;

        card.style.position = 'relative';
        card.style.overflow = 'hidden';
        card.appendChild(ripple);

        ripple.animate([
          {
            transform: 'translate(-50%, -50%) scale(0)',
            opacity: 0.8
          },
          {
            transform: 'translate(-50%, -50%) scale(50)',
            opacity: 0
          }
        ], {
          duration: 600,
          easing: 'ease-out'
        }).onfinish = () => ripple.remove();
      });
    });
  }

  function setupGlitchEffects() {
    const headings = document.querySelectorAll('h1, h2.text-outline-accent');

    window.addEventListener('scroll', () => {
      headings.forEach(heading => {
        const rect = heading.getBoundingClientRect();
        const isVisible = rect.top < window.innerHeight && rect.bottom > 0;

        if (isVisible && Math.random() > 0.98) {
          // Trigger random glitch effect
          heading.animate([
            {
              transform: 'translate(0, 0)',
              filter: 'none'
            },
            {
              transform: 'translate(-2px, 2px)',
              filter: 'hue-rotate(90deg)'
            },
            {
              transform: 'translate(2px, -2px)',
              filter: 'hue-rotate(-90deg)'
            },
            {
              transform: 'translate(0, 0)',
              filter: 'none'
            }
          ], {
            duration: 100,
            easing: 'steps(2, end)'
          });
        }
      });
    });
  }

  function setupFloatingElements() {
    // Add geometric shapes that float around
    const shapesContainer = document.createElement('div');
    shapesContainer.id = 'floatingShapes';
    shapesContainer.style.cssText = `
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
      z-index: 0;
      overflow: hidden;
    `;
    document.body.appendChild(shapesContainer);

    // Create 5 geometric shapes
    const shapes = ['square', 'triangle', 'circle', 'diamond', 'hexagon'];

    shapes.forEach((shape, i) => {
      const element = document.createElement('div');
      const size = 80 + Math.random() * 60;

      element.style.cssText = `
        position: absolute;
        width: ${size}px;
        height: ${size}px;
        border: 2px solid var(--accent-primary);
        opacity: 0.1;
        top: ${Math.random() * 100}%;
        left: ${Math.random() * 100}%;
      `;

      // Different shapes
      switch(shape) {
        case 'circle':
          element.style.borderRadius = '50%';
          break;
        case 'triangle':
          element.style.clipPath = 'polygon(50% 0%, 0% 100%, 100% 100%)';
          break;
        case 'diamond':
          element.style.transform = 'rotate(45deg)';
          break;
        case 'hexagon':
          element.style.clipPath = 'polygon(25% 0%, 75% 0%, 100% 50%, 75% 100%, 25% 100%, 0% 50%)';
          break;
      }

      shapesContainer.appendChild(element);

      // Animate shape
      element.animate([
        {
          transform: `translate(0, 0) rotate(0deg) ${shape === 'diamond' ? 'rotate(45deg)' : ''}`,
          opacity: 0.1
        },
        {
          transform: `translate(${(Math.random() - 0.5) * 200}px, ${(Math.random() - 0.5) * 200}px) rotate(180deg) ${shape === 'diamond' ? 'rotate(45deg)' : ''}`,
          opacity: 0.2
        },
        {
          transform: `translate(0, 0) rotate(360deg) ${shape === 'diamond' ? 'rotate(45deg)' : ''}`,
          opacity: 0.1
        }
      ], {
        duration: 30000 + i * 5000,
        iterations: Infinity,
        easing: 'ease-in-out'
      });
    });
  }

  function handleScroll() {
    // Parallax effect for background elements
    const scrollY = window.scrollY;
    const particles = document.getElementById('floatingParticles');
    const shapes = document.getElementById('floatingShapes');

    if (particles) {
      particles.style.transform = `translateY(${scrollY * 0.3}px)`;
    }

    if (shapes) {
      shapes.style.transform = `translateY(${scrollY * 0.15}px) rotate(${scrollY * 0.05}deg)`;
    }
  }

  // Initialize when DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

  console.log('✓ Page transitions script loaded');

})();
