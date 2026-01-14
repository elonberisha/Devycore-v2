<?php
// DEVELOPMENT MODE - Relaxed CSP for testing
// TODO: Tighten this for production!
header("Content-Security-Policy: default-src *; script-src * 'unsafe-inline' 'unsafe-eval'; style-src * 'unsafe-inline'; font-src * data:; img-src * data: blob: http: https:; connect-src *;");
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: SAMEORIGIN");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Devycore - Digital Craft & Intelligent Systems. High-performance web applications with cutting-edge technology.">

    <!-- DEVELOPMENT CSP - Allow all external resources -->
    <meta http-equiv="Content-Security-Policy" content="default-src * 'unsafe-inline' 'unsafe-eval'; script-src * 'unsafe-inline' 'unsafe-eval'; style-src * 'unsafe-inline'; font-src * data:; img-src * data: blob: http: https:; connect-src *;">

    <title>Devycore - Digital Craft & Intelligent Systems</title>

    <!-- Preconnect to fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="/devycore-v2/public/assets/css/base.css">
    <link rel="stylesheet" href="/devycore-v2/public/assets/css/layout.css">
    <link rel="stylesheet" href="/devycore-v2/public/assets/css/components.css">
    <link rel="stylesheet" href="/devycore-v2/public/assets/css/brutalist.css">

    <!-- Favicon (placeholder) -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E⚛%3C/text%3E%3C/svg%3E">
</head>
<body>
    <!-- ============================================
         ENHANCED ANIMATED BACKGROUND SYSTEM
         ============================================ -->
    <!-- Animated gradient base -->
    <div class="animated-bg"></div>

    <!-- Aurora effect -->
    <div class="aurora-bg"></div>

    <!-- Floating particles -->
    <div class="particles-bg">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <!-- Glowing orbs -->
    <div class="glow-orb glow-orb-1"></div>
    <div class="glow-orb glow-orb-2"></div>
    <div class="glow-orb glow-orb-3"></div>

    <!-- Scanline overlay -->
    <div class="scanline-overlay"></div>

    <!-- Moving scan beam -->
    <div class="scan-beam"></div>

    <!-- Geometric shapes -->
    <div class="geo-shapes">
        <div class="geo-shape geo-shape-1"></div>
        <div class="geo-shape geo-shape-2"></div>
        <div class="geo-shape geo-shape-3"></div>
        <div class="geo-shape geo-shape-4"></div>
    </div>

    <!-- Noise texture -->
    <div class="noise-bg"></div>

    <!-- Corner accents -->
    <div class="corner-accent corner-accent-tl"></div>
    <div class="corner-accent corner-accent-tr"></div>
    <div class="corner-accent corner-accent-bl"></div>
    <div class="corner-accent corner-accent-br"></div>

    <!-- Grid Background (on top of effects) -->
    <div class="grid-background"></div>

    <!-- Header -->
    <header class="site-header">
        <div class="header-inner container">
            <a href="index.php" class="site-logo" style="display: flex; align-items: center;">
                <img src="/devycore-v2/public/assets/images/logo.svg" alt="Devycore Logo" style="height: 95px; width: auto; max-width: 350px;">
            </a>

            <nav class="main-nav" id="mainNav">
                <a href="#services" class="nav-link">Services</a>
                <a href="portfolio.php" class="nav-link">Portfolio</a>
                <a href="about.php" class="nav-link">About</a>
                <a href="blog.php" class="nav-link">Blog</a>
                <a href="#contact" class="nav-link">Contact</a>
            </nav>

            <!-- Hamburger menu -->
            <button class="hamburger" id="hamburger" aria-label="Toggle menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="section-hero section-numbered" data-number="01">
        <div class="container">
            <div class="split-layout">
                <div>
                    <div class="badge-row" style="margin-bottom: 2rem; display: flex; flex-wrap: wrap; gap: 0.5rem;">
                        <span class="badge badge-accent">WEBGL</span>
                        <span class="badge badge-accent">AI ASSISTED</span>
                        <span class="badge badge-accent">REAL-TIME</span>
                        <span class="badge badge-accent">EDGE COMPUTE</span>
                        <span class="badge badge-accent">DESIGN SYSTEMS</span>
                    </div>

                    <h1 class="glitch" data-text="DIGITAL CRAFT">
                        DIGITAL CRAFT<br>
                        & INTELLIGENT<br>
                        SYSTEMS
                    </h1>

                    <p style="max-width: 50ch; margin: 2rem 0 3rem; font-size: 1.25rem; color: var(--text-secondary);">
                        Building high-performance web applications with cutting-edge technology.
                        From concept to deployment, we deliver measurable results.
                    </p>

                    <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                        <a href="#contact" class="btn btn-primary btn-large">START PROJECT</a>
                        <a href="#work" class="btn btn-secondary btn-large">VIEW WORK</a>
                    </div>
                </div>

                <div style="display: flex; align-items: center; justify-content: center; position: relative;">
                    <!-- 3D Animated Robot -->
                    <div id="heroRobot" style="width: 400px; height: 400px; position: relative; transform-style: preserve-3d; animation: float 6s ease-in-out infinite;">
                        <!-- Robot container with 3D transform -->
                        <div style="position: absolute; inset: 0; transform-style: preserve-3d; animation: rotate3d 20s linear infinite;">
                            <!-- Head -->
                            <div style="position: absolute; top: 20%; left: 50%; transform: translateX(-50%); width: 120px; height: 100px; background: linear-gradient(135deg, var(--accent-primary), #00d470); border: 3px solid var(--accent-primary); box-shadow: 0 0 40px var(--accent-primary); animation: headTilt 3s ease-in-out infinite;">
                                <!-- Eyes -->
                                <div style="position: absolute; top: 30px; left: 20px; width: 25px; height: 25px; background: #000; border: 2px solid var(--accent-primary); animation: blink 4s infinite;"></div>
                                <div style="position: absolute; top: 30px; right: 20px; width: 25px; height: 25px; background: #000; border: 2px solid var(--accent-primary); animation: blink 4s 0.1s infinite;"></div>
                                <!-- Antenna -->
                                <div style="position: absolute; top: -30px; left: 50%; transform: translateX(-50%); width: 3px; height: 30px; background: var(--accent-primary); box-shadow: 0 0 10px var(--accent-primary);">
                                    <div style="position: absolute; top: -8px; left: 50%; transform: translateX(-50%); width: 15px; height: 15px; background: var(--accent-hot); border-radius: 50%; animation: pulse 1.5s infinite; box-shadow: 0 0 20px var(--accent-hot);"></div>
                                </div>
                            </div>

                            <!-- Body -->
                            <div style="position: absolute; top: 38%; left: 50%; transform: translateX(-50%); width: 140px; height: 160px; background: linear-gradient(135deg, #1a1a1a, #0a0a0a); border: 3px solid var(--accent-primary); box-shadow: 0 0 30px rgba(0,255,136,0.3);">
                                <!-- Chest panel -->
                                <div style="position: absolute; top: 20px; left: 50%; transform: translateX(-50%); width: 80px; height: 100px; border: 2px solid var(--accent-primary); background: repeating-linear-gradient(0deg, transparent, transparent 8px, var(--accent-primary) 8px, var(--accent-primary) 9px); opacity: 0.3;"></div>
                                <!-- Power core -->
                                <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 40px; height: 40px; background: var(--accent-primary); clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%); animation: pulse 2s infinite; box-shadow: 0 0 30px var(--accent-primary);"></div>
                            </div>

                            <!-- Left Arm -->
                            <div style="position: absolute; top: 42%; left: 18%; width: 20px; height: 120px; background: linear-gradient(180deg, var(--accent-primary), #00a060); border: 2px solid var(--accent-primary); transform-origin: top; animation: armWave 3s ease-in-out infinite; box-shadow: 0 0 15px var(--accent-primary);">
                                <!-- Hand -->
                                <div style="position: absolute; bottom: -15px; left: 50%; transform: translateX(-50%); width: 30px; height: 15px; background: var(--accent-primary); border: 2px solid var(--accent-primary); box-shadow: 0 0 10px var(--accent-primary);"></div>
                            </div>

                            <!-- Right Arm -->
                            <div style="position: absolute; top: 42%; right: 18%; width: 20px; height: 120px; background: linear-gradient(180deg, var(--accent-primary), #00a060); border: 2px solid var(--accent-primary); transform-origin: top; animation: armWave 3s ease-in-out infinite reverse; box-shadow: 0 0 15px var(--accent-primary);">
                                <!-- Hand -->
                                <div style="position: absolute; bottom: -15px; left: 50%; transform: translateX(-50%); width: 30px; height: 15px; background: var(--accent-primary); border: 2px solid var(--accent-primary); box-shadow: 0 0 10px var(--accent-primary);"></div>
                            </div>

                            <!-- Left Leg -->
                            <div style="position: absolute; bottom: 8%; left: 38%; width: 25px; height: 100px; background: linear-gradient(180deg, #1a1a1a, var(--accent-primary)); border: 2px solid var(--accent-primary); animation: legWalk 2s ease-in-out infinite; box-shadow: 0 0 15px rgba(0,255,136,0.3);"></div>

                            <!-- Right Leg -->
                            <div style="position: absolute; bottom: 8%; right: 38%; width: 25px; height: 100px; background: linear-gradient(180deg, #1a1a1a, var(--accent-primary)); border: 2px solid var(--accent-primary); animation: legWalk 2s ease-in-out infinite reverse; box-shadow: 0 0 15px rgba(0,255,136,0.3);"></div>

                            <!-- Particles -->
                            <div style="position: absolute; top: 50%; left: 50%; width: 200%; height: 200%; transform: translate(-50%, -50%); animation: particleRotate 15s linear infinite;">
                                <div style="position: absolute; top: 10%; left: 10%; width: 5px; height: 5px; background: var(--accent-primary); box-shadow: 0 0 10px var(--accent-primary);"></div>
                                <div style="position: absolute; top: 20%; right: 15%; width: 4px; height: 4px; background: var(--accent-hot); box-shadow: 0 0 10px var(--accent-hot);"></div>
                                <div style="position: absolute; bottom: 15%; left: 20%; width: 6px; height: 6px; background: var(--accent-primary); box-shadow: 0 0 10px var(--accent-primary);"></div>
                                <div style="position: absolute; bottom: 25%; right: 10%; width: 4px; height: 4px; background: var(--accent-hot); box-shadow: 0 0 10px var(--accent-hot);"></div>
                            </div>
                        </div>

                        <!-- Scan lines effect -->
                        <div style="position: absolute; inset: 0; background: repeating-linear-gradient(0deg, transparent, transparent 4px, rgba(0,255,136,0.03) 4px, rgba(0,255,136,0.03) 5px); pointer-events: none; animation: scanlines 3s linear infinite;"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="section-numbered section-divider" data-number="02">
        <div class="container">
            <h2 class="text-center" style="margin-bottom: 3rem;">
                <span class="text-outline-accent">WHAT WE DO</span>
            </h2>

            <div class="grid grid-cols-4" style="gap: 1rem;">
                <div class="card hover-brutal" style="padding: 1rem;">
                    <div class="card-title" style="font-size: 0.95rem; margin-bottom: 0.5rem;">WEB DEVELOPMENT</div>
                    <p class="card-description" style="font-size: 0.8rem; line-height: 1.4; margin-bottom: 0.5rem;">
                        Full-stack web applications with React, Next.js, Vue, Node.js, PHP.
                    </p>
                    <div class="badge" style="font-size: 0.65rem; padding: 0.15rem 0.5rem;">FULLSTACK</div>
                </div>

                <div class="card hover-brutal" style="padding: 1rem;">
                    <div class="card-title" style="font-size: 0.95rem; margin-bottom: 0.5rem;">MOBILE APPS</div>
                    <p class="card-description" style="font-size: 0.8rem; line-height: 1.4; margin-bottom: 0.5rem;">
                        Native iOS & Android with React Native, Flutter. Cross-platform.
                    </p>
                    <div class="badge" style="font-size: 0.65rem; padding: 0.15rem 0.5rem;">MOBILE</div>
                </div>

                <div class="card hover-brutal" style="padding: 1rem;">
                    <div class="card-title" style="font-size: 0.95rem; margin-bottom: 0.5rem;">DESKTOP APPS</div>
                    <p class="card-description" style="font-size: 0.8rem; line-height: 1.4; margin-bottom: 0.5rem;">
                        Cross-platform desktop with Electron, Tauri, .NET for all OS.
                    </p>
                    <div class="badge" style="font-size: 0.65rem; padding: 0.15rem 0.5rem;">DESKTOP</div>
                </div>

                <div class="card hover-brutal" style="padding: 1rem;">
                    <div class="card-title" style="font-size: 0.95rem; margin-bottom: 0.5rem;">UX/UI DESIGN</div>
                    <p class="card-description" style="font-size: 0.8rem; line-height: 1.4; margin-bottom: 0.5rem;">
                        Design systems, prototypes, wireframes. Figma, Adobe XD.
                    </p>
                    <div class="badge" style="font-size: 0.65rem; padding: 0.15rem 0.5rem;">DESIGN</div>
                </div>

                <div class="card hover-brutal" style="padding: 1rem;">
                    <div class="card-title" style="font-size: 0.95rem; margin-bottom: 0.5rem;">E-COMMERCE</div>
                    <p class="card-description" style="font-size: 0.8rem; line-height: 1.4; margin-bottom: 0.5rem;">
                        Custom stores, Shopify, WooCommerce, headless commerce.
                    </p>
                    <div class="badge" style="font-size: 0.65rem; padding: 0.15rem 0.5rem;">COMMERCE</div>
                </div>

                <div class="card hover-brutal" style="padding: 1rem;">
                    <div class="card-title" style="font-size: 0.95rem; margin-bottom: 0.5rem;">API DEVELOPMENT</div>
                    <p class="card-description" style="font-size: 0.8rem; line-height: 1.4; margin-bottom: 0.5rem;">
                        RESTful & GraphQL APIs, microservices, third-party integrations.
                    </p>
                    <div class="badge" style="font-size: 0.65rem; padding: 0.15rem 0.5rem;">BACKEND</div>
                </div>

                <div class="card hover-brutal" style="padding: 1rem;">
                    <div class="card-title" style="font-size: 0.95rem; margin-bottom: 0.5rem;">DATABASE DESIGN</div>
                    <p class="card-description" style="font-size: 0.8rem; line-height: 1.4; margin-bottom: 0.5rem;">
                        MySQL, PostgreSQL, MongoDB, Redis. Schema & optimization.
                    </p>
                    <div class="badge" style="font-size: 0.65rem; padding: 0.15rem 0.5rem;">DATA</div>
                </div>

                <div class="card hover-brutal" style="padding: 1rem;">
                    <div class="card-title" style="font-size: 0.95rem; margin-bottom: 0.5rem;">DEVOPS & CLOUD</div>
                    <p class="card-description" style="font-size: 0.8rem; line-height: 1.4; margin-bottom: 0.5rem;">
                        AWS, Azure, GCP. Docker, Kubernetes, CI/CD pipelines.
                    </p>
                    <div class="badge" style="font-size: 0.65rem; padding: 0.15rem 0.5rem;">INFRASTRUCTURE</div>
                </div>

                <div class="card hover-brutal" style="padding: 1rem;">
                    <div class="card-title" style="font-size: 0.95rem; margin-bottom: 0.5rem;">AI INTEGRATION</div>
                    <p class="card-description" style="font-size: 0.8rem; line-height: 1.4; margin-bottom: 0.5rem;">
                        ChatGPT, Claude API, AI chatbots, NLP, automation.
                    </p>
                    <div class="badge" style="font-size: 0.65rem; padding: 0.15rem 0.5rem;">AI/ML</div>
                </div>

                <div class="card hover-brutal" style="padding: 1rem;">
                    <div class="card-title" style="font-size: 0.95rem; margin-bottom: 0.5rem;">BLOCKCHAIN</div>
                    <p class="card-description" style="font-size: 0.8rem; line-height: 1.4; margin-bottom: 0.5rem;">
                        Smart contracts, DApps, Web3, Ethereum, Solana, crypto.
                    </p>
                    <div class="badge" style="font-size: 0.65rem; padding: 0.15rem 0.5rem;">WEB3</div>
                </div>

                <div class="card hover-brutal" style="padding: 1rem;">
                    <div class="card-title" style="font-size: 0.95rem; margin-bottom: 0.5rem;">GAME DEVELOPMENT</div>
                    <p class="card-description" style="font-size: 0.8rem; line-height: 1.4; margin-bottom: 0.5rem;">
                        2D/3D games with Unity, Unreal, WebGL. Browser & mobile.
                    </p>
                    <div class="badge" style="font-size: 0.65rem; padding: 0.15rem 0.5rem;">GAMING</div>
                </div>

                <div class="card hover-brutal" style="padding: 1rem;">
                    <div class="card-title" style="font-size: 0.95rem; margin-bottom: 0.5rem;">CMS SOLUTIONS</div>
                    <p class="card-description" style="font-size: 0.8rem; line-height: 1.4; margin-bottom: 0.5rem;">
                        WordPress, Strapi, Contentful, custom CMS. Easy management.
                    </p>
                    <div class="badge" style="font-size: 0.65rem; padding: 0.15rem 0.5rem;">CMS</div>
                </div>

                <div class="card hover-brutal" style="padding: 1rem;">
                    <div class="card-title" style="font-size: 0.95rem; margin-bottom: 0.5rem;">AUTOMATION</div>
                    <p class="card-description" style="font-size: 0.8rem; line-height: 1.4; margin-bottom: 0.5rem;">
                        Business automation, web scraping, data extraction, workflows.
                    </p>
                    <div class="badge" style="font-size: 0.65rem; padding: 0.15rem 0.5rem;">AUTOMATION</div>
                </div>

                <div class="card hover-brutal" style="padding: 1rem;">
                    <div class="card-title" style="font-size: 0.95rem; margin-bottom: 0.5rem;">REAL-TIME APPS</div>
                    <p class="card-description" style="font-size: 0.8rem; line-height: 1.4; margin-bottom: 0.5rem;">
                        WebSocket, Socket.io, live chat, notifications, dashboards.
                    </p>
                    <div class="badge" style="font-size: 0.65rem; padding: 0.15rem 0.5rem;">REAL-TIME</div>
                </div>

                <div class="card hover-brutal" style="padding: 1rem;">
                    <div class="card-title" style="font-size: 0.95rem; margin-bottom: 0.5rem;">SECURITY & QA</div>
                    <p class="card-description" style="font-size: 0.8rem; line-height: 1.4; margin-bottom: 0.5rem;">
                        Penetration testing, security audits, automated testing, compliance.
                    </p>
                    <div class="badge" style="font-size: 0.65rem; padding: 0.15rem 0.5rem;">SECURITY</div>
                </div>

                <div class="card hover-brutal" style="padding: 1rem;">
                    <div class="card-title" style="font-size: 0.95rem; margin-bottom: 0.5rem;">CUSTOM SOFTWARE</div>
                    <p class="card-description" style="font-size: 0.8rem; line-height: 1.4; margin-bottom: 0.5rem;">
                        Bespoke solutions, MVP development, prototypes, enterprise tools.
                    </p>
                    <div class="badge" style="font-size: 0.65rem; padding: 0.15rem 0.5rem;">CUSTOM</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Work Section -->
    <section id="work" class="section-numbered section-divider" data-number="03">
        <div class="container">
            <h2 class="text-center" style="margin-bottom: 3rem;">
                <span class="text-shadow-brutal">FEATURED WORK</span>
            </h2>

            <div class="grid grid-cols-2" id="projectsGrid">
                <!-- Projects will be loaded dynamically via JavaScript -->
                <div class="card card-featured hover-brutal">
                    <img src="https://via.placeholder.com/600x400/0a0a0a/00ff88?text=PROJECT" alt="Project" class="card-image">
                    <div class="card-title">FINTECH DASHBOARD</div>
                    <p class="card-description">
                        Real-time analytics platform with 50ms latency. React + WebSocket + Redis.
                    </p>
                    <div class="card-footer">
                        <span class="badge badge-hot">FEATURED</span>
                        <a href="#" class="btn btn-small">VIEW CASE</a>
                    </div>
                </div>

                <div class="card hover-brutal">
                    <img src="https://via.placeholder.com/600x400/0a0a0a/ff0055?text=PROJECT" alt="Project" class="card-image">
                    <div class="card-title">LOGISTICS PLATFORM</div>
                    <p class="card-description">
                        Fleet management system with GPS tracking. Node.js + PostgreSQL.
                    </p>
                    <div class="card-footer">
                        <span class="badge">SAAS</span>
                        <a href="#" class="btn btn-small">VIEW CASE</a>
                    </div>
                </div>
            </div>

            <div class="text-center" style="margin-top: 3rem;">
                <a href="#" class="btn btn-large">VIEW ALL PROJECTS</a>
            </div>
        </div>
    </section>

    <!-- Tech Stack Section -->
    <section id="stack" class="section-numbered section-divider" data-number="04">
        <div class="container">
            <h2 class="text-center accent-line-top" style="margin-bottom: 3rem;">
                TECHNOLOGY STACK
            </h2>

            <div class="grid grid-cols-3">
                <div class="accent-line">
                    <h4 style="color: var(--accent-primary); margin-bottom: 1rem;">FRONTEND</h4>
                    <ul class="list-brutal">
                        <li>React / Next.js</li>
                        <li>Vue / Nuxt</li>
                        <li>TypeScript</li>
                        <li>GSAP / Three.js</li>
                        <li>Tailwind CSS</li>
                    </ul>
                </div>

                <div class="accent-line">
                    <h4 style="color: var(--accent-primary); margin-bottom: 1rem;">BACKEND</h4>
                    <ul class="list-brutal">
                        <li>Node.js / Express</li>
                        <li>PHP 8+ / Laravel</li>
                        <li>Python / FastAPI</li>
                        <li>GraphQL / REST</li>
                        <li>WebSockets</li>
                    </ul>
                </div>

                <div class="accent-line">
                    <h4 style="color: var(--accent-primary); margin-bottom: 1rem;">DATABASE</h4>
                    <ul class="list-brutal">
                        <li>PostgreSQL</li>
                        <li>MySQL</li>
                        <li>MongoDB</li>
                        <li>Redis</li>
                        <li>Elasticsearch</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Process Section -->
    <section id="process" class="section-numbered section-divider" data-number="05">
        <div class="container">
            <h2 class="text-center" style="margin-bottom: 1rem;">
                <span class="text-shadow-brutal">HOW WE WORK</span>
            </h2>
            <p class="text-center" style="color: #888; margin-bottom: 3rem; max-width: 700px; margin-left: auto; margin-right: auto;">
                We adapt our workflow methodology to match your project needs - Agile for flexibility, Waterfall for precision, or Hybrid for the best of both worlds
            </p>

            <!-- Methodology Selector -->
            <div style="display: flex; justify-content: center; gap: 1rem; margin-bottom: 4rem; flex-wrap: wrap;">
                <button class="methodology-tab active" data-methodology="agile" style="padding: 1rem 2rem; background: var(--bg-secondary); border: 2px solid var(--accent-primary); color: var(--accent-primary); font-family: var(--font-display); font-weight: 600; cursor: pointer; text-transform: uppercase; letter-spacing: 1px; transition: all 0.3s;">
                    AGILE / SCRUM
                </button>
                <button class="methodology-tab" data-methodology="waterfall" style="padding: 1rem 2rem; background: var(--bg-secondary); border: 2px solid var(--border-color); color: var(--text-secondary); font-family: var(--font-display); font-weight: 600; cursor: pointer; text-transform: uppercase; letter-spacing: 1px; transition: all 0.3s;">
                    WATERFALL
                </button>
                <button class="methodology-tab" data-methodology="hybrid" style="padding: 1rem 2rem; background: var(--bg-secondary); border: 2px solid var(--border-color); color: var(--text-secondary); font-family: var(--font-display); font-weight: 600; cursor: pointer; text-transform: uppercase; letter-spacing: 1px; transition: all 0.3s;">
                    HYBRID
                </button>
            </div>

            <!-- Agile/Scrum Methodology -->
            <div class="methodology-content active" id="agile-content">
                <div style="text-align: center; margin-bottom: 3rem;">
                    <h3 style="color: var(--accent-primary); margin-bottom: 1rem; font-size: 1.5rem;">AGILE / SCRUM METHODOLOGY</h3>
                    <p style="color: var(--text-secondary); max-width: 700px; margin: 0 auto;">Iterative development with 2-week sprints, daily standups, and continuous client feedback</p>
                </div>

                <!-- Agile Sprint Cycle Visualization -->
                <div style="margin-bottom: 2rem; padding: 1.5rem; border: 3px solid var(--accent-primary); position: relative; background: linear-gradient(135deg, transparent 0%, rgba(0,255,136,0.05) 100%);">
                    <div style="position: absolute; top: -12px; left: 1.5rem; background: var(--bg-primary); padding: 0 0.75rem; color: var(--accent-primary); font-weight: 700; font-size: 0.75rem; letter-spacing: 1.5px;">2-WEEK SPRINT CYCLE</div>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 1.25rem;">
                        <!-- Sprint Planning -->
                        <div style="text-align: center;">
                            <div style="width: 60px; height: 60px; margin: 0 auto 0.75rem; border: 2px solid var(--accent-primary); display: flex; align-items: center; justify-content: center; animation: pulse 2s infinite;">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--accent-primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                    <line x1="16" y1="13" x2="8" y2="13"/>
                                    <line x1="16" y1="17" x2="8" y2="17"/>
                                    <line x1="10" y1="9" x2="8" y2="9"/>
                                </svg>
                            </div>
                            <h4 style="color: var(--accent-primary); margin-bottom: 0.35rem; font-size: 0.85rem;">DAY 1: PLANNING</h4>
                            <p style="color: var(--text-secondary); font-size: 0.75rem; line-height: 1.3;">Define goals, break tasks, estimate</p>
                        </div>

                        <!-- Daily Development -->
                        <div style="text-align: center;">
                            <div style="width: 60px; height: 60px; margin: 0 auto 0.75rem; border: 2px solid var(--accent-primary); display: flex; align-items: center; justify-content: center; animation: pulse 2s 0.5s infinite;">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--accent-primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="16 18 22 12 16 6"/>
                                    <polyline points="8 6 2 12 8 18"/>
                                </svg>
                            </div>
                            <h4 style="color: var(--accent-primary); margin-bottom: 0.35rem; font-size: 0.85rem;">DAY 2-9: DEVELOPMENT</h4>
                            <p style="color: var(--text-secondary); font-size: 0.75rem; line-height: 1.3;">Standups, code review, CI/CD</p>
                        </div>

                        <!-- Testing & QA -->
                        <div style="text-align: center;">
                            <div style="width: 60px; height: 60px; margin: 0 auto 0.75rem; border: 2px solid var(--accent-primary); display: flex; align-items: center; justify-content: center; animation: pulse 2s 1s infinite;">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--accent-primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                    <polyline points="22 4 12 14.01 9 11.01"/>
                                </svg>
                            </div>
                            <h4 style="color: var(--accent-primary); margin-bottom: 0.35rem; font-size: 0.85rem;">DAY 10-12: TESTING</h4>
                            <p style="color: var(--text-secondary); font-size: 0.75rem; line-height: 1.3;">Tests, QA, bug fixes, refine</p>
                        </div>

                        <!-- Demo & Retrospective -->
                        <div style="text-align: center;">
                            <div style="width: 60px; height: 60px; margin: 0 auto 0.75rem; border: 2px solid var(--accent-primary); display: flex; align-items: center; justify-content: center; animation: pulse 2s 1.5s infinite;">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--accent-primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                                    <line x1="9" y1="9" x2="15" y2="15"/>
                                    <line x1="15" y1="9" x2="9" y2="15"/>
                                </svg>
                            </div>
                            <h4 style="color: var(--accent-primary); margin-bottom: 0.35rem; font-size: 0.85rem;">DAY 13-14: REVIEW</h4>
                            <p style="color: var(--text-secondary); font-size: 0.75rem; line-height: 1.3;">Demo, feedback, retrospective</p>
                        </div>
                    </div>
                </div>

                <!-- Agile Benefits -->
                <div class="grid grid-cols-3" style="gap: 1.5rem;">
                    <div class="card" style="border-left: 4px solid var(--accent-primary);">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--accent-primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem; display: block;">
                            <path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/>
                            <path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"/>
                            <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"/>
                            <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"/>
                        </svg>
                        <h4 style="color: var(--accent-primary); margin-bottom: 0.5rem;">FAST DELIVERY</h4>
                        <p style="color: var(--text-secondary); font-size: 0.875rem;">Working features every 2 weeks, immediate value</p>
                    </div>
                    <div class="card" style="border-left: 4px solid var(--accent-primary);">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--accent-primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem; display: block;">
                            <path d="M21.5 2v6h-6M2.5 22v-6h6M2 11.5a10 10 0 0 1 18.8-4.3M22 12.5a10 10 0 0 1-18.8 4.2"/>
                        </svg>
                        <h4 style="color: var(--accent-primary); margin-bottom: 0.5rem;">FLEXIBILITY</h4>
                        <p style="color: var(--text-secondary); font-size: 0.875rem;">Adapt to changes, pivot based on feedback</p>
                    </div>
                    <div class="card" style="border-left: 4px solid var(--accent-primary);">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--accent-primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem; display: block;">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                        <h4 style="color: var(--accent-primary); margin-bottom: 0.5rem;">COLLABORATION</h4>
                        <p style="color: var(--text-secondary); font-size: 0.875rem;">Constant communication, transparency, alignment</p>
                    </div>
                </div>
            </div>

            <!-- Waterfall Methodology -->
            <div class="methodology-content" id="waterfall-content" style="display: none;">
                <div style="text-align: center; margin-bottom: 3rem;">
                    <h3 style="color: var(--accent-primary); margin-bottom: 1rem; font-size: 1.5rem;">WATERFALL METHODOLOGY</h3>
                    <p style="color: var(--text-secondary); max-width: 700px; margin: 0 auto;">Sequential phases with clear milestones, perfect for well-defined projects with fixed requirements</p>
                </div>

                <!-- Waterfall Flow Visualization -->
                <div style="margin-bottom: 3rem;">
                    <div style="display: flex; flex-direction: column; gap: 1rem; max-width: 800px; margin: 0 auto;">
                        <!-- Phase 1 -->
                        <div style="padding: 2rem; border: 3px solid var(--accent-primary); position: relative; background: linear-gradient(90deg, rgba(0,255,136,0.1) 0%, transparent 100%);">
                            <div style="position: absolute; left: -15px; top: 50%; transform: translateY(-50%); background: var(--accent-primary); color: var(--bg-primary); width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700;">1</div>
                            <h4 style="color: var(--accent-primary); margin-bottom: 0.5rem;">REQUIREMENTS GATHERING</h4>
                            <p style="color: var(--text-secondary); font-size: 0.875rem;">Complete documentation of all requirements, features, and technical specifications</p>
                        </div>

                        <!-- Arrow -->
                        <div style="text-align: center; color: var(--accent-primary); font-size: 2rem; margin: -0.5rem 0;">↓</div>

                        <!-- Phase 2 -->
                        <div style="padding: 2rem; border: 3px solid var(--accent-primary); position: relative; background: linear-gradient(90deg, rgba(0,255,136,0.1) 0%, transparent 100%);">
                            <div style="position: absolute; left: -15px; top: 50%; transform: translateY(-50%); background: var(--accent-primary); color: var(--bg-primary); width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700;">2</div>
                            <h4 style="color: var(--accent-primary); margin-bottom: 0.5rem;">SYSTEM DESIGN</h4>
                            <p style="color: var(--text-secondary); font-size: 0.875rem;">Architecture, database design, UI/UX mockups, technical stack decisions</p>
                        </div>

                        <div style="text-align: center; color: var(--accent-primary); font-size: 2rem; margin: -0.5rem 0;">↓</div>

                        <!-- Phase 3 -->
                        <div style="padding: 2rem; border: 3px solid var(--accent-primary); position: relative; background: linear-gradient(90deg, rgba(0,255,136,0.1) 0%, transparent 100%);">
                            <div style="position: absolute; left: -15px; top: 50%; transform: translateY(-50%); background: var(--accent-primary); color: var(--bg-primary); width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700;">3</div>
                            <h4 style="color: var(--accent-primary); margin-bottom: 0.5rem;">IMPLEMENTATION</h4>
                            <p style="color: var(--text-secondary); font-size: 0.875rem;">Full development phase following the approved design and specifications</p>
                        </div>

                        <div style="text-align: center; color: var(--accent-primary); font-size: 2rem; margin: -0.5rem 0;">↓</div>

                        <!-- Phase 4 -->
                        <div style="padding: 2rem; border: 3px solid var(--accent-primary); position: relative; background: linear-gradient(90deg, rgba(0,255,136,0.1) 0%, transparent 100%);">
                            <div style="position: absolute; left: -15px; top: 50%; transform: translateY(-50%); background: var(--accent-primary); color: var(--bg-primary); width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700;">4</div>
                            <h4 style="color: var(--accent-primary); margin-bottom: 0.5rem;">TESTING & VERIFICATION</h4>
                            <p style="color: var(--text-secondary); font-size: 0.875rem;">Comprehensive testing, UAT, performance optimization, bug fixes</p>
                        </div>

                        <div style="text-align: center; color: var(--accent-primary); font-size: 2rem; margin: -0.5rem 0;">↓</div>

                        <!-- Phase 5 -->
                        <div style="padding: 2rem; border: 3px solid var(--accent-primary); position: relative; background: linear-gradient(90deg, rgba(0,255,136,0.1) 0%, transparent 100%);">
                            <div style="position: absolute; left: -15px; top: 50%; transform: translateY(-50%); background: var(--accent-primary); color: var(--bg-primary); width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700;">5</div>
                            <h4 style="color: var(--accent-primary); margin-bottom: 0.5rem;">DEPLOYMENT & MAINTENANCE</h4>
                            <p style="color: var(--text-secondary); font-size: 0.875rem;">Production launch, monitoring, support, and maintenance</p>
                        </div>
                    </div>
                </div>

                <!-- Waterfall Benefits -->
                <div class="grid grid-cols-3" style="gap: 1.5rem;">
                    <div class="card" style="border-left: 4px solid var(--accent-primary);">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--accent-primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem; display: block;">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                            <line x1="3" y1="9" x2="21" y2="9"/>
                            <line x1="9" y1="21" x2="9" y2="9"/>
                        </svg>
                        <h4 style="color: var(--accent-primary); margin-bottom: 0.5rem;">CLEAR STRUCTURE</h4>
                        <p style="color: var(--text-secondary); font-size: 0.875rem;">Defined phases, clear milestones, predictable timeline</p>
                    </div>
                    <div class="card" style="border-left: 4px solid var(--accent-primary);">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--accent-primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem; display: block;">
                            <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/>
                            <rect x="8" y="2" width="8" height="4" rx="1" ry="1"/>
                            <path d="M9 12h6"/>
                            <path d="M9 16h6"/>
                        </svg>
                        <h4 style="color: var(--accent-primary); margin-bottom: 0.5rem;">DOCUMENTATION</h4>
                        <p style="color: var(--text-secondary); font-size: 0.875rem;">Comprehensive docs, easier knowledge transfer</p>
                    </div>
                    <div class="card" style="border-left: 4px solid var(--accent-primary);">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--accent-primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem; display: block;">
                            <line x1="12" y1="1" x2="12" y2="23"/>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                        </svg>
                        <h4 style="color: var(--accent-primary); margin-bottom: 0.5rem;">BUDGET CONTROL</h4>
                        <p style="color: var(--text-secondary); font-size: 0.875rem;">Fixed scope, predictable costs, no surprises</p>
                    </div>
                </div>
            </div>

            <!-- Hybrid Methodology -->
            <div class="methodology-content" id="hybrid-content" style="display: none;">
                <div style="text-align: center; margin-bottom: 3rem;">
                    <h3 style="color: var(--accent-primary); margin-bottom: 1rem; font-size: 1.5rem;">HYBRID METHODOLOGY</h3>
                    <p style="color: var(--text-secondary); max-width: 700px; margin: 0 auto;">Combines Waterfall planning with Agile execution - structure where needed, flexibility where it matters</p>
                </div>

                <!-- Hybrid Approach Visualization -->
                <div style="margin-bottom: 3rem; display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                    <!-- Waterfall Planning Phase -->
                    <div style="padding: 2rem; border: 3px solid var(--accent-primary);">
                        <h4 style="color: var(--accent-primary); margin-bottom: 1.5rem; text-align: center; font-size: 1.25rem;">WATERFALL PLANNING</h4>
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            <div style="padding: 1rem; border: 2px solid var(--border-color); background: var(--bg-secondary);">
                                <div style="color: var(--accent-primary); font-weight: 600; margin-bottom: 0.25rem;">✦ Requirements</div>
                                <div style="color: var(--text-secondary); font-size: 0.875rem;">Fixed scope & goals</div>
                            </div>
                            <div style="padding: 1rem; border: 2px solid var(--border-color); background: var(--bg-secondary);">
                                <div style="color: var(--accent-primary); font-weight: 600; margin-bottom: 0.25rem;">✦ Architecture</div>
                                <div style="color: var(--text-secondary); font-size: 0.875rem;">System design upfront</div>
                            </div>
                            <div style="padding: 1rem; border: 2px solid var(--border-color); background: var(--bg-secondary);">
                                <div style="color: var(--accent-primary); font-weight: 600; margin-bottom: 0.25rem;">✦ Timeline</div>
                                <div style="color: var(--text-secondary); font-size: 0.875rem;">Milestone planning</div>
                            </div>
                        </div>
                    </div>

                    <!-- Agile Execution Phase -->
                    <div style="padding: 2rem; border: 3px solid var(--accent-hot);">
                        <h4 style="color: var(--accent-hot); margin-bottom: 1.5rem; text-align: center; font-size: 1.25rem;">AGILE EXECUTION</h4>
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            <div style="padding: 1rem; border: 2px solid var(--border-color); background: var(--bg-secondary);">
                                <div style="color: var(--accent-hot); font-weight: 600; margin-bottom: 0.25rem;">▸ Sprints</div>
                                <div style="color: var(--text-secondary); font-size: 0.875rem;">Iterative development</div>
                            </div>
                            <div style="padding: 1rem; border: 2px solid var(--border-color); background: var(--bg-secondary);">
                                <div style="color: var(--accent-hot); font-weight: 600; margin-bottom: 0.25rem;">▸ Feedback</div>
                                <div style="color: var(--text-secondary); font-size: 0.875rem;">Regular client reviews</div>
                            </div>
                            <div style="padding: 1rem; border: 2px solid var(--border-color); background: var(--bg-secondary);">
                                <div style="color: var(--accent-hot); font-weight: 600; margin-bottom: 0.25rem;">▸ Adaptation</div>
                                <div style="color: var(--text-secondary); font-size: 0.875rem;">Adjust implementation</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hybrid Benefits -->
                <div class="grid grid-cols-3" style="gap: 1.5rem;">
                    <div class="card" style="border-left: 4px solid var(--accent-primary);">
                        <span class="material-symbols-outlined" style="font-size: 48px; color: var(--accent-primary); margin-bottom: 1rem; display: block;">hub</span>
                        <h4 style="color: var(--accent-primary); margin-bottom: 0.5rem;">BEST OF BOTH</h4>
                        <p style="color: var(--text-secondary); font-size: 0.875rem;">Structure + flexibility, planning + adaptation</p>
                    </div>
                    <div class="card" style="border-left: 4px solid var(--accent-primary);">
                        <span class="material-symbols-outlined" style="font-size: 48px; color: var(--accent-primary); margin-bottom: 1rem; display: block;">shield</span>
                        <h4 style="color: var(--accent-primary); margin-bottom: 0.5rem;">RISK REDUCTION</h4>
                        <p style="color: var(--text-secondary); font-size: 0.875rem;">Early planning minimizes surprises</p>
                    </div>
                    <div class="card" style="border-left: 4px solid var(--accent-primary);">
                        <span class="material-symbols-outlined" style="font-size: 48px; color: var(--accent-primary); margin-bottom: 1rem; display: block;">tune</span>
                        <h4 style="color: var(--accent-primary); margin-bottom: 0.5rem;">CUSTOMIZABLE</h4>
                        <p style="color: var(--text-secondary); font-size: 0.875rem;">Tailored to your project's unique needs</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .methodology-tab:hover {
            background: var(--bg-primary) !important;
            border-color: var(--accent-primary) !important;
            color: var(--accent-primary) !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 0 var(--accent-primary);
        }

        .methodology-tab.active {
            background: var(--bg-primary) !important;
            border-color: var(--accent-primary) !important;
            color: var(--accent-primary) !important;
            box-shadow: 0 4px 0 var(--accent-primary);
        }

        .methodology-content {
            transition: opacity 0.3s ease;
        }
    </style>

    <script>
        // Methodology tab switching
        document.addEventListener('DOMContentLoaded', () => {
            const tabs = document.querySelectorAll('.methodology-tab');
            const contents = document.querySelectorAll('.methodology-content');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    const methodology = tab.dataset.methodology;

                    // Update tabs
                    tabs.forEach(t => {
                        t.classList.remove('active');
                        t.style.borderColor = 'var(--border-color)';
                        t.style.color = 'var(--text-secondary)';
                        t.style.boxShadow = 'none';
                    });

                    tab.classList.add('active');

                    // Update content
                    contents.forEach(c => {
                        c.style.display = 'none';
                        c.classList.remove('active');
                    });

                    const activeContent = document.getElementById(`${methodology}-content`);
                    if (activeContent) {
                        activeContent.style.display = 'block';
                        setTimeout(() => activeContent.classList.add('active'), 10);
                    }
                });
            });
        });
    </script>

    <!-- FAQ Section -->
    <section id="faq" class="section-numbered section-divider" data-number="07">
        <div class="container">
            <h2 class="text-center" style="margin-bottom: 1rem;">
                <span class="text-shadow-brutal">FREQUENTLY ASKED</span>
            </h2>
            <p class="text-center" style="color: #888; margin-bottom: 4rem;">
                Common questions about our services
            </p>

            <div style="max-width: 800px; margin: 0 auto;">
                <div class="card border-brutal" style="margin-bottom: 1.5rem;">
                    <div class="card-title" style="color: #00ff88; font-size: 18px; margin-bottom: 1rem;">
                        How long does a typical project take?
                    </div>
                    <p class="card-description">
                        Simple websites: 2-4 weeks. Web applications: 6-12 weeks. Enterprise systems: 3-6 months. We provide detailed timelines during the discovery phase and deliver in agile sprints for faster time-to-market.
                    </p>
                </div>

                <div class="card border-brutal" style="margin-bottom: 1.5rem;">
                    <div class="card-title" style="color: #00ff88; font-size: 18px; margin-bottom: 1rem;">
                        What technologies do you use?
                    </div>
                    <p class="card-description">
                        We're technology-agnostic and choose the best stack for your needs. Common choices: React/Vue for frontend, Node.js/PHP for backend, PostgreSQL/MySQL for databases, AWS/DigitalOcean for hosting. We prioritize maintainability and scalability.
                    </p>
                </div>

                <div class="card border-brutal" style="margin-bottom: 1.5rem;">
                    <div class="card-title" style="color: #00ff88; font-size: 18px; margin-bottom: 1rem;">
                        Do you provide ongoing support?
                    </div>
                    <p class="card-description">
                        Yes! We offer comprehensive maintenance packages including bug fixes, security updates, performance optimization, and feature development. All projects include 30 days of free support after launch.
                    </p>
                </div>

                <div class="card border-brutal" style="margin-bottom: 1.5rem;">
                    <div class="card-title" style="color: #00ff88; font-size: 18px; margin-bottom: 1rem;">
                        What's your pricing model?
                    </div>
                    <p class="card-description">
                        We provide flexible engagement models tailored to your project needs. We offer detailed quotes after an initial discovery call to understand your requirements. No hidden fees, transparent communication throughout.
                    </p>
                </div>

                <div class="card border-brutal">
                    <div class="card-title" style="color: #00ff88; font-size: 18px; margin-bottom: 1rem;">
                        Can you work with our existing team?
                    </div>
                    <p class="card-description">
                        Absolutely! We integrate seamlessly with in-house teams, other agencies, or work independently. We use GitHub, Jira, Slack, and other collaboration tools. Code reviews and knowledge transfer included.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="section-numbered" data-number="08">
        <div class="container">
            <h2 class="text-center" style="margin-bottom: 3rem;">
                LET'S BUILD SOMETHING
            </h2>

            <div class="split-layout">
                <div>
                    <form id="contactForm" class="scanline">
                        <div class="form-group">
                            <label for="name" class="form-label">Name *</label>
                            <input type="text" id="name" name="name" class="form-input" placeholder="Your full name" required>
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" id="email" name="email" class="form-input" placeholder="your@email.com" required>
                        </div>

                        <div class="form-group">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" id="phone" name="phone" class="form-input" placeholder="+1 (123) 456-7890">
                        </div>

                        <div class="form-group">
                            <label for="company" class="form-label">Company</label>
                            <input type="text" id="company" name="company" class="form-input" placeholder="Your company name">
                        </div>

                        <div class="form-group">
                            <label for="project_type" class="form-label">Project Type *</label>
                            <select id="project_type" name="project_type" class="form-select" required>
                                <option value="">Select project type...</option>
                                <option value="Web Application">Web Application</option>
                                <option value="E-Commerce">E-Commerce</option>
                                <option value="Business System">Business System</option>
                                <option value="Mobile App">Mobile App</option>
                                <option value="Design">UI/UX Design</option>
                                <option value="Consulting">Consulting</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="message" class="form-label">Message *</label>
                            <textarea id="message" name="message" class="form-textarea" placeholder="Tell us about your project..." rows="5" required></textarea>
                        </div>

                        <!-- Honeypot -->
                        <input type="text" name="website" style="display: none;" tabindex="-1" autocomplete="off">

                        <button type="submit" class="btn btn-primary btn-large w-full">
                            SEND MESSAGE
                        </button>

                        <div id="formMessage" style="margin-top: 1rem;"></div>
                    </form>
                </div>

                <div>
                    <!-- Why Devycore -->
                    <div style="margin-bottom: 2rem; padding: var(--space-6); border: 2px solid var(--border-color);">
                        <div style="color: var(--accent-primary); font-size: 0.75rem; font-weight: 600; letter-spacing: 1px; margin-bottom: 0.5rem;">WHY DEVYCORE</div>
                        <h4 style="margin-bottom: 1.5rem;">Excellence in Every Line of Code</h4>
                        <div style="display: grid; gap: 0.75rem;">
                            <div style="display: flex; justify-content: space-between; padding-bottom: 0.5rem; border-bottom: 1px solid var(--border-color);">
                                <span style="color: var(--text-secondary);">Average Load Time</span>
                                <span style="color: var(--accent-primary); font-weight: 600;">< 1.2s</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding-bottom: 0.5rem; border-bottom: 1px solid var(--border-color);">
                                <span style="color: var(--text-secondary);">Lighthouse Score</span>
                                <span style="color: var(--accent-primary); font-weight: 600;">95+</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding-bottom: 0.5rem; border-bottom: 1px solid var(--border-color);">
                                <span style="color: var(--text-secondary);">Project Kickoff</span>
                                <span style="color: var(--accent-primary); font-weight: 600;">48h</span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span style="color: var(--text-secondary);">Code Quality</span>
                                <span style="color: var(--accent-primary); font-weight: 600;">A+</span>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Info -->
                    <div id="contactInfoContainer" style="margin-bottom: 2rem; padding: var(--space-6); border: 2px solid var(--border-color);">
                        <div style="color: var(--accent-primary); font-size: 0.75rem; font-weight: 600; letter-spacing: 1px; margin-bottom: 0.5rem;">CONTACT INFO</div>
                        <h4 style="margin-bottom: 1.5rem;">Get in Touch</h4>
                        <div id="dynamicContactInfo" style="display: grid; gap: 1rem;">
                            <!-- Will be populated dynamically -->
                            <div style="text-align: center; padding: 2rem; color: var(--text-secondary);">
                                Loading contact information...
                            </div>
                        </div>
                    </div>

                    <!-- Follow Us -->
                    <div id="socialNetworksContainer" style="padding: var(--space-6); border: 2px solid var(--border-color);">
                        <div style="color: var(--accent-primary); font-size: 0.75rem; font-weight: 600; letter-spacing: 1px; margin-bottom: 0.5rem;">FOLLOW US</div>
                        <h4 style="margin-bottom: 1.5rem;">Connect on Social Media</h4>

                        <style>
                            .social-link {
                                display: flex;
                                flex-direction: column;
                                align-items: center;
                                justify-content: center;
                                gap: 0.5rem;
                                padding: 1.25rem;
                                border: 2px solid var(--border-color);
                                text-decoration: none;
                                transition: all 0.3s ease;
                                background: var(--bg-primary);
                            }
                            .social-link:hover {
                                border-color: var(--accent-primary);
                                transform: translateY(-3px);
                                box-shadow: 0 4px 0 var(--accent-primary);
                            }
                            .social-link .material-symbols-outlined {
                                color: var(--accent-primary);
                                font-size: 32px;
                            }
                            .social-link span.social-label {
                                font-size: 0.7rem;
                                color: var(--text-secondary);
                                text-align: center;
                                font-weight: 600;
                                text-transform: uppercase;
                                letter-spacing: 0.5px;
                            }
                        </style>

                        <div id="dynamicSocialNetworks" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;">
                            <!-- Will be populated dynamically -->
                            <div style="grid-column: 1 / -1; text-align: center; padding: 2rem; color: var(--text-secondary);">
                                Loading social networks...
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-column">
                    <h4>QUICK LINKS</h4>
                    <div class="footer-links">
                        <a href="index.php" class="footer-link">Home</a>
                        <a href="about.php" class="footer-link">About</a>
                        <a href="portfolio.php" class="footer-link">Portfolio</a>
                        <a href="blog.php" class="footer-link">Blog</a>
                    </div>
                </div>

                <div class="footer-column">
                    <h4>CONTACT</h4>
                    <div class="footer-links">
                        <a href="#contact" class="footer-link">Get in Touch</a>
                        <a href="mailto:info@devycore.com" class="footer-link">info@devycore.com</a>
                        <a href="tel:+1234567890" class="footer-link">+123 456 7890</a>
                    </div>
                </div>

                <div class="footer-column">
                    <h4>SOCIAL</h4>
                    <div class="footer-links">
                        <a href="https://linkedin.com" target="_blank" class="footer-link">LinkedIn</a>
                        <a href="https://github.com" target="_blank" class="footer-link">GitHub</a>
                        <a href="https://twitter.com" target="_blank" class="footer-link">Twitter</a>
                    </div>
                </div>

                <div class="footer-column">
                    <h4>LEGAL</h4>
                    <div class="footer-links">
                        <a href="privacy.php" class="footer-link">Privacy Policy</a>
                        <a href="terms.php" class="footer-link">Terms of Service</a>
                        <a href="admin/login.php" class="footer-link">Admin</a>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <div>&copy; <?php echo date('Y'); ?> Devycore. All rights reserved.</div>
                <div>
                    <span class="status-dot online"></span>
                    <span style="margin-left: 0.5rem; font-size: var(--text-xs);">SYSTEMS OPERATIONAL</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Load GSAP from CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

    <!-- Load Web Animations API polyfill -->
    <script src="/devycore-v2/public/assets/js/web-animations.js"></script>

    <!-- Load custom scripts -->
    <script src="/devycore-v2/public/assets/js/main.js"></script>
    <script src="/devycore-v2/public/assets/js/animations.js"></script>
    <script src="/devycore-v2/public/assets/js/hero-robot.js"></script>
    <script src="/devycore-v2/public/assets/js/page-transitions.js"></script>
    <!-- webgl.js will be lazy-loaded by main.js -->

    <!-- Load dynamic site settings -->
    <script>
        // Fetch and display contact info and social networks
        async function loadSiteSettings() {
            try {
                const response = await fetch('/devycore-v2/public/api/site-settings.php');
                const result = await response.json();

                if (result.success) {
                    // Load contact info
                    loadContactInfo(result.data.contact_info);

                    // Load social networks
                    loadSocialNetworks(result.data.social_networks);
                }
            } catch (error) {
                console.error('Failed to load site settings:', error);
            }
        }

        function loadContactInfo(contactInfo) {
            const container = document.getElementById('dynamicContactInfo');
            if (!container) return;

            if (!contactInfo || contactInfo.length === 0) {
                container.innerHTML = '<div style="text-align: center; padding: 2rem; color: var(--text-secondary);">No contact information available</div>';
                return;
            }

            container.innerHTML = contactInfo.map(info => {
                const key = info.info_key;
                const value = info.info_value;
                const label = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());

                // Format based on type
                let displayValue = value;
                if (key === 'email') {
                    displayValue = `<a href="mailto:${value}" style="color: var(--accent-primary); text-decoration: none; font-weight: 600;">${value}</a>`;
                } else if (key === 'phone') {
                    displayValue = `<a href="tel:${value}" style="color: var(--accent-primary); text-decoration: none; font-weight: 600;">${value}</a>`;
                } else {
                    displayValue = `<div style="color: var(--text-primary); font-weight: 600;">${value}</div>`;
                }

                return `
                    <div>
                        <div style="color: var(--text-secondary); font-size: 0.875rem; margin-bottom: 0.25rem;">${label}</div>
                        ${displayValue}
                    </div>
                `;
            }).join('');
        }

        function loadSocialNetworks(socialNetworks) {
            const container = document.getElementById('dynamicSocialNetworks');
            if (!container) return;

            if (!socialNetworks || socialNetworks.length === 0) {
                container.innerHTML = '<div style="grid-column: 1 / -1; text-align: center; padding: 2rem; color: var(--text-secondary);">No social networks available</div>';
                return;
            }

            container.innerHTML = socialNetworks.map(social => {
                const iconName = social.icon_name || 'link';
                return `
                    <a href="${social.url}" target="_blank" rel="noopener" class="social-link">
                        <span class="material-symbols-outlined">${iconName}</span>
                        <span class="social-label">${social.platform}</span>
                    </a>
                `;
            }).join('');
        }

        // Load when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', loadSiteSettings);
        } else {
            loadSiteSettings();
        }
    </script>

    <!-- Console message -->
    <script>
        console.log('%c⚡ Devycore V2 ', 'background: #00ff88; color: #0a0a0a; font-size: 16px; padding: 8px 16px; font-weight: bold;');
        console.log('%cBrutalist Tech Design System', 'color: #ff0055; font-size: 14px;');
        console.log('%cFor debug: window.DevycoreApp', 'color: #666;');
    </script>
</body>
</html>
