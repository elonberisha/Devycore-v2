/**
 * WebGL JS - Three.js Optimized Particles
 * Lazy-loaded, mobile-disabled, auto-paused
 */

let THREE;
let scene, camera, renderer, particles, particleSystem;
let mouse = { x: 0, y: 0 };
let targetRotation = { x: 0, y: 0 };
let currentRotation = { x: 0, y: 0 };
let isVisible = true;
let animationId = null;

/**
 * Initialize WebGL scene
 */
export async function initWebGL() {
  console.log('⚡ Initializing WebGL...');

  try {
    // Load Three.js from CDN
    if (typeof window.THREE === 'undefined') {
      await loadThreeJS();
    }
    THREE = window.THREE;

    // Setup scene
    setupScene();
    setupCamera();
    setupRenderer();
    createParticles();
    setupEventListeners();
    setupIntersectionObserver();

    // Start animation loop
    animate();

    console.log('✓ WebGL initialized with', particles.length, 'particles');
  } catch (error) {
    console.error('✗ WebGL initialization failed:', error);
    console.log('✦ WebGL disabled - site will work without particles');
    // Gracefully fail - site continues to work without WebGL
  }
}

/**
 * Load Three.js from CDN
 */
function loadThreeJS() {
  return new Promise((resolve, reject) => {
    const script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/three@0.160.0/build/three.min.js';
    script.onload = () => {
      console.log('✓ Three.js loaded from CDN');
      resolve();
    };
    script.onerror = (error) => {
      console.error('✗ Failed to load Three.js:', error);
      // Try fallback CDN
      console.log('⚡ Trying fallback CDN...');
      const fallbackScript = document.createElement('script');
      fallbackScript.src = 'https://unpkg.com/three@0.160.0/build/three.min.js';
      fallbackScript.onload = () => {
        console.log('✓ Three.js loaded from fallback CDN');
        resolve();
      };
      fallbackScript.onerror = () => {
        console.error('✗ All CDN attempts failed. WebGL disabled.');
        reject(new Error('Failed to load Three.js from any CDN'));
      };
      document.head.appendChild(fallbackScript);
    };
    document.head.appendChild(script);
  });
}

/**
 * Setup Three.js scene
 */
function setupScene() {
  scene = new THREE.Scene();
  scene.fog = new THREE.FogExp2(0x0a0a0a, 0.001);
}

/**
 * Setup camera
 */
function setupCamera() {
  camera = new THREE.PerspectiveCamera(
    75,
    window.innerWidth / window.innerHeight,
    0.1,
    1000
  );
  camera.position.z = 50;
}

/**
 * Setup renderer
 */
function setupRenderer() {
  renderer = new THREE.WebGLRenderer({
    alpha: true,
    antialias: window.innerWidth > 768, // Disable antialiasing on mobile
    powerPreference: 'high-performance'
  });

  renderer.setSize(window.innerWidth, window.innerHeight);
  renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2)); // Limit pixel ratio
  renderer.setClearColor(0x0a0a0a, 0); // Transparent background

  // Add canvas to page
  const canvas = renderer.domElement;
  canvas.style.position = 'fixed';
  canvas.style.top = '0';
  canvas.style.left = '0';
  canvas.style.width = '100%';
  canvas.style.height = '100%';
  canvas.style.zIndex = '-1';
  canvas.style.pointerEvents = 'none';
  document.body.insertBefore(canvas, document.body.firstChild);
}

/**
 * Create particle system (optimized count)
 */
function createParticles() {
  const particleCount = window.innerWidth > 768 ? 150 : 0; // No particles on mobile

  if (particleCount === 0) {
    console.log('⚠ Skipping particles on mobile');
    return;
  }

  const geometry = new THREE.BufferGeometry();
  const positions = [];
  const velocities = [];
  const colors = [];

  // Create particles
  for (let i = 0; i < particleCount; i++) {
    // Random position in cube
    positions.push(
      (Math.random() - 0.5) * 100,
      (Math.random() - 0.5) * 100,
      (Math.random() - 0.5) * 100
    );

    // Random velocity
    velocities.push(
      (Math.random() - 0.5) * 0.02,
      (Math.random() - 0.5) * 0.02,
      (Math.random() - 0.5) * 0.02
    );

    // Color (electric green or hot pink)
    const isGreen = Math.random() > 0.5;
    colors.push(
      isGreen ? 0 / 255 : 255 / 255,
      isGreen ? 255 / 255 : 0 / 255,
      isGreen ? 136 / 255 : 85 / 255
    );
  }

  geometry.setAttribute('position', new THREE.Float32BufferAttribute(positions, 3));
  geometry.setAttribute('color', new THREE.Float32BufferAttribute(colors, 3));

  // Store velocities
  particles = velocities;

  // Material
  const material = new THREE.PointsMaterial({
    size: 2,
    vertexColors: true,
    transparent: true,
    opacity: 0.6,
    blending: THREE.AdditiveBlending,
    depthWrite: false
  });

  // Create particle system
  particleSystem = new THREE.Points(geometry, material);
  scene.add(particleSystem);
}

/**
 * Setup event listeners
 */
function setupEventListeners() {
  // Mouse move for parallax
  document.addEventListener('mousemove', onMouseMove, { passive: true });

  // Window resize
  window.addEventListener('resize', onWindowResize, { passive: true });

  // Visibility change (pause when tab hidden)
  document.addEventListener('visibilitychange', () => {
    isVisible = !document.hidden;
  });
}

/**
 * Setup Intersection Observer to pause when off-screen
 */
function setupIntersectionObserver() {
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      isVisible = entry.isIntersecting;
    });
  }, {
    threshold: 0
  });

  // Observe the hero section
  const hero = document.querySelector('.section-hero');
  if (hero) {
    observer.observe(hero);
  }
}

/**
 * Mouse move handler
 */
function onMouseMove(event) {
  mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
  mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;

  targetRotation.x = mouse.y * 0.05;
  targetRotation.y = mouse.x * 0.05;
}

/**
 * Window resize handler
 */
function onWindowResize() {
  camera.aspect = window.innerWidth / window.innerHeight;
  camera.updateProjectionMatrix();
  renderer.setSize(window.innerWidth, window.innerHeight);
}

/**
 * Animation loop
 */
function animate() {
  if (!isVisible) {
    // Pause animation when not visible
    animationId = requestAnimationFrame(animate);
    return;
  }

  // Update particle positions
  if (particleSystem) {
    const positions = particleSystem.geometry.attributes.position.array;

    for (let i = 0; i < particles.length; i += 3) {
      // Update position
      positions[i] += particles[i];
      positions[i + 1] += particles[i + 1];
      positions[i + 2] += particles[i + 2];

      // Boundary check (wrap around)
      if (Math.abs(positions[i]) > 50) {
        positions[i] = -positions[i];
      }
      if (Math.abs(positions[i + 1]) > 50) {
        positions[i + 1] = -positions[i + 1];
      }
      if (Math.abs(positions[i + 2]) > 50) {
        positions[i + 2] = -positions[i + 2];
      }
    }

    particleSystem.geometry.attributes.position.needsUpdate = true;

    // Smooth rotation based on mouse (parallax effect)
    currentRotation.x += (targetRotation.x - currentRotation.x) * 0.05;
    currentRotation.y += (targetRotation.y - currentRotation.y) * 0.05;

    particleSystem.rotation.x = currentRotation.x;
    particleSystem.rotation.y = currentRotation.y;

    // Slow auto-rotation
    particleSystem.rotation.z += 0.0005;
  }

  // Render scene
  renderer.render(scene, camera);

  // Continue animation loop
  animationId = requestAnimationFrame(animate);
}

/**
 * Cleanup function (if needed)
 */
export function destroyWebGL() {
  if (animationId) {
    cancelAnimationFrame(animationId);
  }

  if (renderer) {
    renderer.dispose();
    renderer.domElement.remove();
  }

  if (particleSystem) {
    scene.remove(particleSystem);
    particleSystem.geometry.dispose();
    particleSystem.material.dispose();
  }

  console.log('✓ WebGL cleaned up');
}

/**
 * Create particle burst effect (for prize balloon)
 */
export function createParticleBurst(x, y, count = 50) {
  if (!THREE || !scene) return;

  const geometry = new THREE.BufferGeometry();
  const positions = [];
  const velocities = [];
  const colors = [];

  // Create burst particles
  for (let i = 0; i < count; i++) {
    // Starting position (2D to 3D)
    const screenX = (x / window.innerWidth) * 2 - 1;
    const screenY = -(y / window.innerHeight) * 2 + 1;

    positions.push(
      screenX * 40,
      screenY * 40,
      0
    );

    // Random velocity (burst outward)
    const angle = (i / count) * Math.PI * 2;
    const speed = Math.random() * 2 + 1;

    velocities.push(
      Math.cos(angle) * speed,
      Math.sin(angle) * speed,
      (Math.random() - 0.5) * speed
    );

    // Color (mix of green and pink)
    colors.push(
      Math.random(),
      Math.random() > 0.5 ? 1 : 0,
      Math.random() > 0.5 ? 1 : 0
    );
  }

  geometry.setAttribute('position', new THREE.Float32BufferAttribute(positions, 3));
  geometry.setAttribute('color', new THREE.Float32BufferAttribute(colors, 3));

  const material = new THREE.PointsMaterial({
    size: 4,
    vertexColors: true,
    transparent: true,
    opacity: 1,
    blending: THREE.AdditiveBlending
  });

  const burst = new THREE.Points(geometry, material);
  scene.add(burst);

  // Animate burst
  let frame = 0;
  const maxFrames = 60; // 1 second at 60fps

  function animateBurst() {
    frame++;

    const positions = burst.geometry.attributes.position.array;
    const opacity = 1 - (frame / maxFrames);

    for (let i = 0; i < velocities.length; i += 3) {
      positions[i] += velocities[i];
      positions[i + 1] += velocities[i + 1];
      positions[i + 2] += velocities[i + 2];

      // Gravity
      velocities[i + 1] -= 0.02;
    }

    burst.geometry.attributes.position.needsUpdate = true;
    burst.material.opacity = opacity;

    if (frame < maxFrames) {
      requestAnimationFrame(animateBurst);
    } else {
      // Cleanup
      scene.remove(burst);
      burst.geometry.dispose();
      burst.material.dispose();
    }
  }

  animateBurst();
}

// Auto-initialize if module is imported
// initWebGL();
