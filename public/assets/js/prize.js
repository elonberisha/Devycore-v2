/**
 * Prize Balloon Game
 * Interactive discount game with explosion animation
 */

(function() {
  'use strict';

  const COOLDOWN_MINUTES = 5;
  const STORAGE_KEY = 'devy_prize_last';
  const RESULT_KEY = 'devy_prize_result';

  // Prize distribution (weighted random)
  const PRIZES = [
    { code: 'NO_WIN', percentage: 0, label: 'Better Luck!', weight: 1 },
    { code: 'DISC_20', percentage: 20, label: '20% OFF', weight: 38 },
    { code: 'DISC_30', percentage: 30, label: '30% OFF', weight: 26 },
    { code: 'DISC_40', percentage: 40, label: '40% OFF', weight: 18 },
    { code: 'DISC_50', percentage: 50, label: '50% OFF', weight: 10 },
    { code: 'DISC_60', percentage: 60, label: '60% OFF', weight: 7 }
  ];

  let balloonElement = null;
  let resultElement = null;
  let lastPrize = null;

  /**
   * Initialize prize balloon
   */
  function init() {
    // Check if balloon element exists
    balloonElement = document.getElementById('prizeBalloon');
    if (!balloonElement) {
      createBalloon();
    }

    // Setup click handler
    balloonElement?.addEventListener('click', handleBalloonClick);

    // Check if cooldown is active
    updateCooldownDisplay();

    console.log('✓ Prize balloon initialized');
  }

  /**
   * Create balloon element
   */
  function createBalloon() {
    const container = document.querySelector('.corner-brackets');
    if (!container) return;

    // Replace placeholder
    container.innerHTML = `
      <div id="prizeBalloon" class="prize-balloon">
        <div class="balloon-inner">
          <span class="balloon-text">POP IT!</span>
          <div class="balloon-shine"></div>
        </div>
        <div class="balloon-string"></div>
      </div>
      <div id="prizeResult" class="prize-result"></div>
      <div id="cooldownTimer" class="cooldown-timer"></div>
    `;

    balloonElement = document.getElementById('prizeBalloon');
    resultElement = document.getElementById('prizeResult');

    // Add CSS styles dynamically
    addBalloonStyles();
  }

  /**
   * Add balloon CSS styles
   */
  function addBalloonStyles() {
    const style = document.createElement('style');
    style.textContent = `
      .prize-balloon {
        position: relative;
        width: 200px;
        height: 240px;
        cursor: pointer;
        transition: transform 0.3s ease;
      }

      .prize-balloon:hover {
        transform: scale(1.05) translateY(-5px);
      }

      .balloon-inner {
        position: relative;
        width: 200px;
        height: 200px;
        background: linear-gradient(135deg, var(--accent-primary), var(--accent-hot));
        border: 3px solid var(--border-color);
        border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow:
          0 0 0 2px rgba(255, 255, 255, 0.2) inset,
          0 10px 30px -10px rgba(0, 255, 136, 0.5);
        animation: float 3s ease-in-out infinite;
      }

      @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
      }

      .balloon-text {
        font-family: var(--font-display);
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--bg-primary);
        text-transform: uppercase;
        letter-spacing: 0.1em;
        z-index: 2;
      }

      .balloon-shine {
        position: absolute;
        top: 20%;
        left: 20%;
        width: 40px;
        height: 50px;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        filter: blur(8px);
      }

      .balloon-string {
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 2px;
        height: 40px;
        background: var(--border-color);
      }

      .balloon-string::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 50%;
        transform: translateX(-50%);
        width: 8px;
        height: 8px;
        background: var(--border-color);
        border-radius: 50%;
      }

      .prize-balloon.exploding .balloon-inner {
        animation: explode 0.6s cubic-bezier(0.55, 0.2, 0.4, 1) forwards;
      }

      @keyframes explode {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.3); opacity: 1; }
        100% { transform: scale(0); opacity: 0; }
      }

      .prize-result {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
      }

      .prize-result.visible {
        opacity: 1;
        pointer-events: auto;
      }

      .prize-result h3 {
        font-size: 2.5rem;
        color: var(--accent-primary);
        margin-bottom: 0.5rem;
        animation: prizeReveal 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
      }

      @keyframes prizeReveal {
        0% { transform: scale(0) rotate(-10deg); }
        100% { transform: scale(1) rotate(0); }
      }

      .prize-result p {
        font-size: 1rem;
        color: var(--text-secondary);
        margin-bottom: 1rem;
      }

      .cooldown-timer {
        position: absolute;
        bottom: -40px;
        left: 50%;
        transform: translateX(-50%);
        font-family: var(--font-mono);
        font-size: 0.875rem;
        color: var(--accent-hot);
        white-space: nowrap;
      }
    `;
    document.head.appendChild(style);
  }

  /**
   * Handle balloon click
   */
  function handleBalloonClick() {
    // Check cooldown
    if (isCooldownActive()) {
      showCooldownMessage();
      return;
    }

    // Play balloon
    playBalloon();
  }

  /**
   * Play balloon (explosion + prize reveal)
   */
  function playBalloon() {
    // Disable further clicks
    balloonElement.style.pointerEvents = 'none';

    // Explosion animation
    balloonElement.classList.add('exploding');

    // Create particle burst (if WebGL is available)
    setTimeout(() => {
      const rect = balloonElement.getBoundingClientRect();
      const centerX = rect.left + rect.width / 2;
      const centerY = rect.top + rect.height / 2;

      if (typeof createParticleBurst === 'function') {
        createParticleBurst(centerX, centerY, 50);
      }
    }, 300);

    // Generate prize
    const prize = getRandomPrize();
    lastPrize = prize;

    // Save to localStorage
    savePrizeResult(prize);

    // Show result after explosion
    setTimeout(() => {
      balloonElement.style.display = 'none';
      showPrizeResult(prize);
    }, 600);
  }

  /**
   * Get random prize (weighted)
   */
  function getRandomPrize() {
    const totalWeight = PRIZES.reduce((sum, p) => sum + p.weight, 0);
    let random = Math.random() * totalWeight;

    for (const prize of PRIZES) {
      random -= prize.weight;
      if (random <= 0) {
        return prize;
      }
    }

    return PRIZES[0]; // Fallback
  }

  /**
   * Show prize result
   */
  function showPrizeResult(prize) {
    if (!resultElement) return;

    const isWin = prize.code !== 'NO_WIN';

    resultElement.innerHTML = `
      <h3>${prize.label}</h3>
      <p>${isWin ? 'Congratulations! You won a discount!' : 'Try again in 5 minutes!'}</p>
      ${isWin ? `
        <div style="font-family: var(--font-mono); font-size: 1.5rem; color: var(--accent-primary); margin: 1rem 0; padding: 1rem; border: 2px solid var(--accent-primary); background: var(--bg-secondary);">
          ${prize.percentage}% OFF
        </div>
        <p style="font-size: 0.875rem; color: var(--text-secondary); margin-bottom: 1rem;">
          Code: <strong>${prize.code}</strong>
        </p>
        <a href="claim-discount.php?discount=${prize.percentage}&code=${prize.code}" class="btn btn-primary" style="display: inline-block;">
          CLAIM DISCOUNT
        </a>
      ` : `
        <button class="btn btn-secondary" onclick="location.reload()">
          TRY AGAIN LATER
        </button>
      `}
    `;

    resultElement.classList.add('visible');

    // Store prize info for discount page
    if (isWin) {
      localStorage.setItem('prizeBalloonDiscount', prize.percentage.toString());
      localStorage.setItem('prizeBalloonCode', prize.code);
    }

    // Start cooldown
    updateCooldownDisplay();
  }

  /**
   * Save prize result to localStorage
   */
  function savePrizeResult(prize) {
    const now = Date.now();
    localStorage.setItem(STORAGE_KEY, now.toString());
    localStorage.setItem(RESULT_KEY, JSON.stringify(prize));
  }

  /**
   * Check if cooldown is active
   */
  function isCooldownActive() {
    const lastTime = localStorage.getItem(STORAGE_KEY);
    if (!lastTime) return false;

    const elapsed = Date.now() - parseInt(lastTime);
    const cooldownMs = COOLDOWN_MINUTES * 60 * 1000;

    return elapsed < cooldownMs;
  }

  /**
   * Get remaining cooldown time
   */
  function getRemainingCooldown() {
    const lastTime = localStorage.getItem(STORAGE_KEY);
    if (!lastTime) return 0;

    const elapsed = Date.now() - parseInt(lastTime);
    const cooldownMs = COOLDOWN_MINUTES * 60 * 1000;
    const remaining = cooldownMs - elapsed;

    return Math.max(0, remaining);
  }

  /**
   * Update cooldown display
   */
  function updateCooldownDisplay() {
    const timerElement = document.getElementById('cooldownTimer');
    if (!timerElement) return;

    const remaining = getRemainingCooldown();

    if (remaining > 0) {
      const minutes = Math.floor(remaining / 60000);
      const seconds = Math.floor((remaining % 60000) / 1000);
      timerElement.textContent = `Cooldown: ${minutes}:${seconds.toString().padStart(2, '0')}`;

      // Update every second
      setTimeout(updateCooldownDisplay, 1000);
    } else {
      timerElement.textContent = '';

      // Re-enable balloon if hidden
      if (balloonElement && balloonElement.style.display === 'none') {
        balloonElement.style.display = 'block';
        balloonElement.style.pointerEvents = 'auto';
        balloonElement.classList.remove('exploding');

        if (resultElement) {
          resultElement.classList.remove('visible');
        }
      }
    }
  }

  /**
   * Show cooldown message
   */
  function showCooldownMessage() {
    const remaining = getRemainingCooldown();
    const minutes = Math.ceil(remaining / 60000);

    alert(`Please wait ${minutes} more minute(s) before playing again!`);
  }

  /**
   * Fill discount form with prize code
   */
  window.fillDiscountForm = function(prizeCode) {
    const discountForm = document.getElementById('discountForm');
    if (!discountForm) {
      // Scroll to contact form instead
      document.getElementById('contact')?.scrollIntoView({ behavior: 'smooth' });
      return;
    }

    // Fill prize field
    const prizeField = discountForm.querySelector('[name="prize"]');
    if (prizeField) {
      prizeField.value = prizeCode;
    }

    // Scroll to form
    discountForm.scrollIntoView({ behavior: 'smooth' });
  };

  /**
   * Reset prize (for testing)
   */
  window.resetPrize = function() {
    localStorage.removeItem(STORAGE_KEY);
    localStorage.removeItem(RESULT_KEY);
    location.reload();
  };

  // Initialize when DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

  console.log('✓ Prize balloon ready');

})();
