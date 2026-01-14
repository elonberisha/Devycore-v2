/**
 * Hero Robot Advanced Animations
 * Using Web Animations API for extravagant effects
 */

(function() {
  'use strict';

  let robot = null;
  let isScrolling = false;

  function init() {
    robot = document.getElementById('heroRobot');
    if (!robot) return;

    // Add scroll-based parallax animation
    window.addEventListener('scroll', handleScroll);

    // Add interactive hover animations
    robot.addEventListener('mouseenter', handleMouseEnter);
    robot.addEventListener('mouseleave', handleMouseLeave);

    // Add click interaction
    robot.addEventListener('click', handleClick);

    // Start ambient particle animations
    startParticleEffects();

    console.log('✓ Hero robot animations initialized');
  }

  function handleScroll() {
    if (!robot || isScrolling) return;

    isScrolling = true;
    requestAnimationFrame(() => {
      const scrollY = window.scrollY;
      const heroSection = robot.closest('section');
      const heroHeight = heroSection ? heroSection.offsetHeight : 800;

      // Calculate scroll progress (0 to 1)
      const progress = Math.min(scrollY / heroHeight, 1);

      // Apply 3D parallax based on scroll
      const rotateY = progress * 30;
      const rotateX = progress * -15;
      const scale = 1 - (progress * 0.3);
      const opacity = 1 - (progress * 0.8);

      robot.style.transform = `
        rotateY(${rotateY}deg)
        rotateX(${rotateX}deg)
        scale(${scale})
      `;
      robot.style.opacity = opacity;

      isScrolling = false;
    });
  }

  function handleMouseEnter() {
    if (!robot) return;

    // Speed up all animations on hover
    const innerContainer = robot.querySelector('[style*="animation: rotate3d"]');
    if (innerContainer) {
      innerContainer.style.animationDuration = '5s';
    }

    // Make antenna glow intensely
    const antenna = robot.querySelector('[style*="pulse"]');
    if (antenna) {
      antenna.animate([
        { transform: 'scale(1)', boxShadow: '0 0 20px var(--accent-hot)' },
        { transform: 'scale(1.5)', boxShadow: '0 0 60px var(--accent-hot), 0 0 100px var(--accent-primary)' },
        { transform: 'scale(1)', boxShadow: '0 0 20px var(--accent-hot)' }
      ], {
        duration: 800,
        iterations: 3,
        easing: 'ease-in-out'
      });
    }

    // Make eyes glow
    const eyes = robot.querySelectorAll('[style*="blink"]');
    eyes.forEach(eye => {
      eye.animate([
        { background: '#000', boxShadow: '0 0 5px var(--accent-primary)' },
        { background: 'var(--accent-primary)', boxShadow: '0 0 30px var(--accent-primary)' },
        { background: '#000', boxShadow: '0 0 5px var(--accent-primary)' }
      ], {
        duration: 1000,
        iterations: Infinity,
        easing: 'ease-in-out'
      });
    });
  }

  function handleMouseLeave() {
    if (!robot) return;

    // Reset animation speed
    const innerContainer = robot.querySelector('[style*="animation: rotate3d"]');
    if (innerContainer) {
      innerContainer.style.animationDuration = '20s';
    }
  }

  function handleClick() {
    if (!robot) return;

    // Explosive burst animation
    const powerCore = robot.querySelector('[style*="clip-path: polygon"]');
    if (powerCore) {
      powerCore.animate([
        { transform: 'translate(-50%, -50%) scale(1) rotate(0deg)', boxShadow: '0 0 30px var(--accent-primary)' },
        { transform: 'translate(-50%, -50%) scale(3) rotate(360deg)', boxShadow: '0 0 100px var(--accent-primary), 0 0 200px var(--accent-hot)', opacity: 0.3 },
        { transform: 'translate(-50%, -50%) scale(1) rotate(720deg)', boxShadow: '0 0 30px var(--accent-primary)', opacity: 1 }
      ], {
        duration: 1200,
        easing: 'cubic-bezier(0.68, -0.55, 0.265, 1.55)'
      });
    }

    // Shake the robot
    robot.animate([
      { transform: 'translate(0, 0) rotate(0deg)' },
      { transform: 'translate(-10px, -10px) rotate(-5deg)' },
      { transform: 'translate(10px, -5px) rotate(5deg)' },
      { transform: 'translate(-5px, 10px) rotate(-3deg)' },
      { transform: 'translate(5px, -5px) rotate(3deg)' },
      { transform: 'translate(0, 0) rotate(0deg)' }
    ], {
      duration: 500,
      easing: 'ease-in-out'
    });

    // Create burst particles
    createBurstParticles();
  }

  function startParticleEffects() {
    if (!robot) return;

    const particles = robot.querySelectorAll('[style*="particleRotate"] > div');

    particles.forEach((particle, index) => {
      // Random orbiting animation
      particle.animate([
        { transform: 'scale(1)', opacity: 1 },
        { transform: 'scale(1.5)', opacity: 0.5 },
        { transform: 'scale(1)', opacity: 1 }
      ], {
        duration: 2000 + (index * 500),
        iterations: Infinity,
        easing: 'ease-in-out',
        delay: index * 200
      });
    });
  }

  function createBurstParticles() {
    if (!robot) return;

    const particleCount = 20;
    const container = robot.parentElement;

    for (let i = 0; i < particleCount; i++) {
      const particle = document.createElement('div');
      const angle = (Math.PI * 2 * i) / particleCount;
      const distance = 150 + Math.random() * 100;
      const size = 3 + Math.random() * 5;

      particle.style.cssText = `
        position: absolute;
        width: ${size}px;
        height: ${size}px;
        background: ${Math.random() > 0.5 ? 'var(--accent-primary)' : 'var(--accent-hot)'};
        border-radius: 50%;
        top: 50%;
        left: 50%;
        box-shadow: 0 0 10px currentColor;
        pointer-events: none;
        z-index: 1000;
      `;

      container.appendChild(particle);

      const endX = Math.cos(angle) * distance;
      const endY = Math.sin(angle) * distance;

      particle.animate([
        { transform: 'translate(-50%, -50%) scale(0)', opacity: 1 },
        { transform: `translate(${endX}px, ${endY}px) scale(1)`, opacity: 1 },
        { transform: `translate(${endX * 1.5}px, ${endY * 1.5}px) scale(0)`, opacity: 0 }
      ], {
        duration: 800 + Math.random() * 400,
        easing: 'cubic-bezier(0.25, 0.46, 0.45, 0.94)'
      }).onfinish = () => particle.remove();
    }
  }

  // Initialize when DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

  console.log('✓ Hero robot script loaded');

})();
