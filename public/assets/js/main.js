/**
 * Main JS - Core Application
 * Initialization and utility functions
 */

(function() {
  'use strict';

  // App state
  const App = {
    initialized: false,
    webglLoaded: false,
    isMobile: window.innerWidth < 768,
    scrollY: 0
  };

  /**
   * Initialize application
   */
  function init() {
    if (App.initialized) return;
    App.initialized = true;

    console.log('%c⚡ Devycore V2', 'font-size: 20px; font-weight: bold; color: #00ff88;');
    console.log('%cBrutalist Tech Design System', 'color: #ff0055;');

    // Setup event listeners
    setupNavigation();
    setupScrollEffects();
    setupFormHandling();
    setupLazyLoading();

    // Load projects dynamically
    loadProjects();

    // Lazy load WebGL after delay or scroll
    if (!App.isMobile) {
      scheduleLazyWebGL();
    }

    // Update mobile flag on resize
    window.addEventListener('resize', debounce(() => {
      App.isMobile = window.innerWidth < 768;
    }, 250));
  }

  /**
   * Setup navigation interactions
   */
  function setupNavigation() {
    // Hamburger menu
    const hamburger = document.getElementById('hamburger');
    const mainNav = document.getElementById('mainNav');

    hamburger?.addEventListener('click', () => {
      hamburger.classList.toggle('active');
      mainNav.classList.toggle('open');
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', (e) => {
        const href = anchor.getAttribute('href');
        if (href === '#') return;

        e.preventDefault();
        const target = document.querySelector(href);

        if (target) {
          // Close mobile menu if open
          mainNav?.classList.remove('open');
          hamburger?.classList.remove('active');

          // Smooth scroll
          const headerHeight = 80;
          const targetPosition = target.offsetTop - headerHeight;

          window.scrollTo({
            top: targetPosition,
            behavior: 'smooth'
          });
        }
      });
    });

    // Active nav on scroll
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.nav-link');

    window.addEventListener('scroll', throttle(() => {
      const scrollY = window.scrollY;
      App.scrollY = scrollY;

      sections.forEach(section => {
        const sectionTop = section.offsetTop - 100;
        const sectionHeight = section.offsetHeight;
        const sectionId = section.getAttribute('id');

        if (scrollY >= sectionTop && scrollY < sectionTop + sectionHeight) {
          navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === `#${sectionId}`) {
              link.classList.add('active');
            }
          });
        }
      });
    }, 100));
  }

  /**
   * Setup scroll effects
   */
  function setupScrollEffects() {
    // Fade-in elements on scroll
    const observerOptions = {
      threshold: 0.1,
      rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.style.opacity = '1';
          entry.target.style.transform = 'translateY(0)';
        }
      });
    }, observerOptions);

    // Observe cards and sections
    document.querySelectorAll('.card, section').forEach(el => {
      el.style.opacity = '0';
      el.style.transform = 'translateY(20px)';
      el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
      observer.observe(el);
    });
  }

  /**
   * Setup form handling
   */
  function setupFormHandling() {
    const contactForm = document.getElementById('contactForm');
    const formMessage = document.getElementById('formMessage');

    if (!contactForm) return;

    contactForm.addEventListener('submit', async (e) => {
      e.preventDefault();

      // Get form data
      const formData = new FormData(contactForm);
      const data = Object.fromEntries(formData.entries());

      // Client-side validation
      if (!data.name || data.name.length < 2) {
        showFormMessage('Name must be at least 2 characters', 'error');
        return;
      }

      if (!data.email || !isValidEmail(data.email)) {
        showFormMessage('Please enter a valid email address', 'error');
        return;
      }

      if (!data.message || data.message.length < 10) {
        showFormMessage('Message must be at least 10 characters', 'error');
        return;
      }

      // Show loading
      formMessage.innerHTML = '<div class="flex items-center gap-2"><div class="spinner spinner-small"></div> Sending...</div>';

      try {
        const response = await fetch('/devycore-v2/public/api/contact.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(data)
        });

        const result = await response.json();

        if (result.success) {
          showFormMessage(result.message || 'Thank you! We will contact you soon.', 'success');
          contactForm.reset();

          // Add success animation
          contactForm.style.transform = 'scale(0.98)';
          setTimeout(() => {
            contactForm.style.transform = 'scale(1)';
          }, 200);
        } else {
          const errorMsg = result.error || 'Failed to send message';
          const errors = result.errors ? Object.values(result.errors).join(', ') : '';
          showFormMessage(errorMsg + (errors ? ': ' + errors : ''), 'error');
        }
      } catch (error) {
        console.error('Form submission error:', error);
        showFormMessage('Network error. Please try again.', 'error');
      }
    });
  }

  /**
   * Show form message
   */
  function showFormMessage(message, type) {
    const formMessage = document.getElementById('formMessage');
    if (!formMessage) return;

    const alertClass = type === 'success' ? 'alert-success' : 'alert-error';
    formMessage.innerHTML = `<div class="alert ${alertClass}">${message}</div>`;

    // Auto-hide after 5 seconds for success messages
    if (type === 'success') {
      setTimeout(() => {
        formMessage.innerHTML = '';
      }, 5000);
    }
  }

  /**
   * Setup lazy loading for images
   */
  function setupLazyLoading() {
    if ('loading' in HTMLImageElement.prototype) {
      // Browser supports native lazy loading
      const images = document.querySelectorAll('img[loading="lazy"]');
      images.forEach(img => {
        img.src = img.dataset.src || img.src;
      });
    } else {
      // Fallback to Intersection Observer
      const imageObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const img = entry.target;
            img.src = img.dataset.src || img.src;
            img.classList.add('loaded');
            imageObserver.unobserve(img);
          }
        });
      });

      document.querySelectorAll('img[data-src]').forEach(img => {
        imageObserver.observe(img);
      });
    }
  }

  /**
   * Load projects from API
   */
  async function loadProjects() {
    const projectsGrid = document.getElementById('projectsGrid');
    if (!projectsGrid) return;

    try {
      const response = await fetch('/devycore-v2/public/api/projects.php');
      const result = await response.json();

      if (result.success && result.data.projects.length > 0) {
        const projects = result.data.projects.slice(0, 4); // Show first 4

        // Clear placeholder cards
        projectsGrid.innerHTML = '';

        projects.forEach(project => {
          const card = createProjectCard(project);
          projectsGrid.appendChild(card);
        });

        // Re-observe new cards for scroll animation
        projectsGrid.querySelectorAll('.card').forEach(card => {
          card.style.opacity = '0';
          card.style.transform = 'translateY(20px)';
          card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';

          const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
              if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
              }
            });
          }, { threshold: 0.1 });

          observer.observe(card);
        });
      }
    } catch (error) {
      console.error('Failed to load projects:', error);
    }
  }

  /**
   * Create project card HTML
   */
  function createProjectCard(project) {
    const card = document.createElement('div');
    card.className = 'card hover-brutal' + (project.featured ? ' card-featured' : '');

    const imagePath = project.image_path || 'https://via.placeholder.com/600x400/0a0a0a/00ff88?text=PROJECT';
    const technologies = Array.isArray(project.technologies) ? project.technologies : [];

    card.innerHTML = `
      ${imagePath ? `<img src="${imagePath}" alt="${escapeHtml(project.title)}" class="card-image" loading="lazy">` : ''}
      <div class="card-title">${escapeHtml(project.title)}</div>
      <p class="card-description">${escapeHtml(project.description || 'No description available.')}</p>
      ${technologies.length > 0 ? `
        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap; margin: 1rem 0;">
          ${technologies.slice(0, 3).map(tech => `<span class="badge">${escapeHtml(tech)}</span>`).join('')}
        </div>
      ` : ''}
      <div class="card-footer">
        ${project.featured ? '<span class="badge badge-hot">FEATURED</span>' : '<span class="badge">PROJECT</span>'}
        <a href="${escapeHtml(project.url)}" target="_blank" rel="noopener" class="btn btn-small">VIEW LIVE</a>
      </div>
    `;

    return card;
  }

  /**
   * Schedule lazy loading of WebGL
   */
  function scheduleLazyWebGL() {
    let webglTriggered = false;

    const triggerWebGL = () => {
      if (webglTriggered) return;
      webglTriggered = true;

      // Load WebGL module
      import('./webgl.js')
        .then(module => {
          console.log('✓ WebGL loaded');
          module.initWebGL();
          App.webglLoaded = true;
        })
        .catch(err => {
          console.warn('WebGL failed to load:', err);
        });
    };

    // Trigger on scroll (after 50vh)
    let scrolled = false;
    window.addEventListener('scroll', () => {
      if (!scrolled && window.scrollY > window.innerHeight * 0.5) {
        scrolled = true;
        triggerWebGL();
      }
    }, { passive: true });

    // Trigger after 2 seconds idle
    setTimeout(() => {
      if (!scrolled) {
        triggerWebGL();
      }
    }, 2000);
  }

  /**
   * Utility: Validate email
   */
  function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  }

  /**
   * Utility: Escape HTML
   */
  function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
  }

  /**
   * Utility: Debounce
   */
  function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
      const later = () => {
        clearTimeout(timeout);
        func(...args);
      };
      clearTimeout(timeout);
      timeout = setTimeout(later, wait);
    };
  }

  /**
   * Utility: Throttle
   */
  function throttle(func, limit) {
    let inThrottle;
    return function(...args) {
      if (!inThrottle) {
        func.apply(this, args);
        inThrottle = true;
        setTimeout(() => inThrottle = false, limit);
      }
    };
  }

  // Initialize when DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

  // Expose App to global scope for debugging
  window.DevycoreApp = App;

})();
