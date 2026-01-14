<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="About Devycore - Learn about our team, values, and mission to build high-performance digital solutions.">
    <title>About Us - Devycore</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&family=Fira+Code:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="/devycore-v2/public/assets/css/base.css">
    <link rel="stylesheet" href="/devycore-v2/public/assets/css/layout.css">
    <link rel="stylesheet" href="/devycore-v2/public/assets/css/components.css">
    <link rel="stylesheet" href="/devycore-v2/public/assets/css/brutalist.css">

    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.4/gsap.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.4/ScrollTrigger.min.js" defer></script>

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">

    <style>
        .code-block {
            background: var(--bg-primary);
            border: 2px solid var(--accent-primary);
            padding: 0.75rem;
            font-family: 'Fira Code', monospace;
            font-size: 0.75rem;
            line-height: 1.4;
            overflow-x: auto;
            position: relative;
        }

        .code-block::before {
            content: '// ' attr(data-lang);
            position: absolute;
            top: 0.5rem;
            right: 1rem;
            font-size: 0.75rem;
            color: var(--accent-hot);
            text-transform: uppercase;
        }

        .code-line {
            display: block;
            padding-left: 1.5rem;
            position: relative;
        }

        .code-line::before {
            content: attr(data-line);
            position: absolute;
            left: 0;
            color: var(--text-secondary);
            opacity: 0.5;
            width: 2rem;
            text-align: right;
        }

        .code-keyword { color: var(--accent-hot); }
        .code-function { color: var(--accent-primary); }
        .code-string { color: #ffd700; }
        .code-comment { color: var(--text-secondary); opacity: 0.7; }

        .timeline {
            position: relative;
            padding-left: 4rem;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 1rem;
            top: 0;
            bottom: 0;
            width: 3px;
            background: linear-gradient(180deg, var(--accent-primary) 0%, var(--accent-hot) 100%);
        }

        .timeline-item {
            position: relative;
            margin-bottom: 3rem;
            padding: 2rem;
            background: var(--bg-secondary);
            border: 2px solid var(--border);
            transition: all 0.3s ease;
        }

        .timeline-item:hover {
            border-color: var(--accent-primary);
            transform: translateX(10px);
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -3.5rem;
            top: 2rem;
            width: 20px;
            height: 20px;
            background: var(--accent-primary);
            border: 3px solid var(--bg-primary);
            transform: rotate(45deg);
        }

        .timeline-year {
            font-size: 2rem;
            font-weight: 700;
            color: var(--accent-primary);
            margin-bottom: 0.5rem;
        }

        .metric-card {
            background: var(--bg-secondary);
            border: 3px solid var(--border);
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        .metric-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--accent-primary) 0%, var(--accent-hot) 100%);
        }

        .metric-number {
            font-size: 4rem;
            font-weight: 700;
            line-height: 1;
            background: linear-gradient(135deg, var(--accent-primary) 0%, var(--accent-hot) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .skill-bar {
            height: 40px;
            background: var(--bg-secondary);
            border: 2px solid var(--border);
            position: relative;
            overflow: hidden;
            margin-bottom: 1rem;
        }

        .skill-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--accent-primary) 0%, var(--accent-hot) 100%);
            display: flex;
            align-items: center;
            padding: 0 1rem;
            font-weight: 600;
            font-size: 0.9rem;
            transition: width 2s ease;
        }

        .tech-logo {
            width: 80px;
            height: 80px;
            background: var(--bg-secondary);
            border: 2px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            transition: all 0.3s ease;
        }

        .tech-logo:hover {
            border-color: var(--accent-primary);
            transform: translateY(-5px) rotate(5deg);
            box-shadow: 0 10px 0 var(--accent-primary);
        }

        .tech-logo-text {
            padding: 1rem 1.5rem;
            background: var(--bg-primary);
            border: 2px solid var(--border);
            font-family: var(--font-display);
            font-size: 0.875rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-align: center;
            color: var(--text-primary);
            transition: all 0.3s ease;
            text-transform: uppercase;
        }

        .tech-logo-text:hover {
            border-color: var(--accent-primary);
            color: var(--accent-primary);
            transform: translateY(-3px);
            box-shadow: 0 6px 0 var(--accent-primary);
        }

        .stack-card {
            padding: 2rem;
            background: var(--bg-primary);
            border: 2px solid var(--border);
            transition: all 0.3s ease;
        }

        .stack-card:hover {
            border-color: var(--accent-primary);
            transform: translateY(-5px);
        }

        .stack-card h4 {
            font-size: 0.875rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 1.5rem;
            color: var(--accent-primary);
        }

        .stack-items {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .stack-items li {
            padding: 0.5rem 1rem;
            background: var(--bg-secondary);
            border: 1px solid var(--border);
            font-size: 0.75rem;
            font-weight: 500;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            color: var(--text-secondary);
            transition: all 0.2s ease;
        }

        .stack-items li:hover {
            color: var(--accent-primary);
            border-color: var(--accent-primary);
        }

        .floating-code {
            position: absolute;
            font-family: 'Fira Code', monospace;
            font-size: 0.8rem;
            color: var(--accent-primary);
            opacity: 0.3;
            pointer-events: none;
            white-space: nowrap;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        .achievement-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: var(--bg-secondary);
            border: 2px solid var(--accent-primary);
            margin: 0.5rem;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .achievement-badge::before {
            content: '✓';
            color: var(--accent-primary);
            font-size: 1.2rem;
        }
    </style>
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

    <!-- Floating Code Snippets -->
    <div class="floating-code" style="top: 15%; left: 5%; animation: float 6s ease-in-out infinite;">const build = () => amazing();</div>
    <div class="floating-code" style="top: 30%; right: 10%; animation: float 8s ease-in-out infinite;">function innovate() { return future; }</div>
    <div class="floating-code" style="top: 60%; left: 15%; animation: float 7s ease-in-out infinite;">&lt;WebGL&gt; magic &lt;/WebGL&gt;</div>
    <div class="floating-code" style="top: 80%; right: 20%; animation: float 9s ease-in-out infinite;">{ performance: "99.9%" }</div>

    <!-- Header -->
    <header class="site-header">
        <div class="header-inner container">
            <a href="index.php" class="site-logo" style="display: flex; align-items: center;">
                <img src="/devycore-v2/public/assets/images/logo.svg" alt="Devycore Logo" style="height: 75px; width: auto; max-width: 280px;">
            </a>

            <nav class="main-nav" id="mainNav">
                <a href="index.php#services" class="nav-link">Services</a>
                <a href="portfolio.php" class="nav-link">Portfolio</a>
                <a href="about.php" class="nav-link active">About</a>
                <a href="blog.php" class="nav-link">Blog</a>
                <a href="index.php#contact" class="nav-link">Contact</a>
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
    <section class="section-hero" style="padding: 120px 0 60px; position: relative;">
        <div class="container">
            <div class="split-layout" style="gap: 4rem; align-items: center;">
                <div>
                    <div class="badge-row" style="margin-bottom: 2rem;">
                        <span class="badge badge-accent">EST. 2023</span>
                        <span class="badge badge-accent">EXPERT TEAM</span>
                        <span class="badge badge-accent">QUALITY DRIVEN</span>
                        <span class="badge badge-accent">INNOVATIVE</span>
                    </div>

                    <h1 class="glitch" data-text="WHO WE ARE" style="font-size: clamp(48px, 10vw, 96px);">
                        WHO<br>WE ARE
                    </h1>

                    <p style="max-width: 50ch; margin: 2rem 0; font-size: 1.25rem; line-height: 1.6; color: var(--text-secondary);">
                        A team of <span style="color: var(--accent-primary); font-weight: 600;">engineers</span>,
                        <span style="color: var(--accent-hot); font-weight: 600;">designers</span>, and
                        <span style="color: var(--accent-primary); font-weight: 600;">strategists</span> building
                        the future of web technology with code, creativity, and caffeine.
                    </p>

                    <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                        <a href="portfolio.php" class="btn btn-primary btn-large">VIEW OUR WORK</a>
                        <a href="index.php#contact" class="btn btn-secondary btn-large">START A PROJECT</a>
                    </div>
                </div>

                <!-- 3D Animated Robot Component -->
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

    <!-- Metrics Section -->
    <section class="section section-numbered" data-number="01" style="padding: 80px 0;">
        <div class="container">
            <h2 style="font-size: clamp(32px, 6vw, 56px); margin-bottom: 3rem; text-align: center;">BY THE NUMBERS</h2>

            <div class="grid-4">
                <div class="metric-card">
                    <div class="metric-number counter" data-target="25">0</div>
                    <div style="font-size: 1.25rem; font-weight: 600; margin-top: 1rem;">Projects</div>
                    <p style="color: var(--text-secondary); margin-top: 0.5rem;">Successfully Delivered</p>
                </div>

                <div class="metric-card">
                    <div class="metric-number counter" data-target="15">0</div>
                    <div style="font-size: 1.25rem; font-weight: 600; margin-top: 1rem;">Clients</div>
                    <p style="color: var(--text-secondary); margin-top: 0.5rem;">Happy Partners</p>
                </div>

                <div class="metric-card">
                    <div class="metric-number counter" data-target="5">0</div>
                    <div style="font-size: 1.25rem; font-weight: 600; margin-top: 1rem;">Team</div>
                    <p style="color: var(--text-secondary); margin-top: 0.5rem;">Expert Developers</p>
                </div>

                <div class="metric-card">
                    <div class="metric-number">100<span style="font-size: 2rem;">%</span></div>
                    <div style="font-size: 1.25rem; font-weight: 600; margin-top: 1rem;">Quality</div>
                    <p style="color: var(--text-secondary); margin-top: 0.5rem;">Client Satisfaction</p>
                </div>
            </div>

            <!-- Core Focus -->
            <div style="margin-top: 4rem; text-align: center;">
                <h3 style="font-size: 1.5rem; margin-bottom: 2rem; color: var(--accent-primary);">OUR FOCUS</h3>
                <div style="display: flex; flex-wrap: wrap; justify-content: center;">
                    <div class="achievement-badge">Modern Web Apps</div>
                    <div class="achievement-badge">Performance Optimization</div>
                    <div class="achievement-badge">Clean Code</div>
                    <div class="achievement-badge">Responsive Design</div>
                    <div class="achievement-badge">Best Practices</div>
                    <div class="achievement-badge">Fast Delivery</div>
                    <div class="achievement-badge">Client Communication</div>
                    <div class="achievement-badge">Quality Assurance</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Timeline Section -->
    <section class="section section-numbered" data-number="02" style="padding: 80px 0;">
        <div class="container">
            <h2 style="font-size: clamp(32px, 6vw, 56px); margin-bottom: 3rem;">OUR JOURNEY</h2>

            <div class="timeline">
                <div class="timeline-item" style="border-color: var(--accent-primary);">
                    <div class="timeline-year">2023</div>
                    <h3 style="font-size: 1.25rem; margin-bottom: 0.75rem; color: var(--accent-primary);">The Beginning</h3>
                    <p style="color: var(--text-secondary); line-height: 1.5; font-size: 0.9rem;">
                        Founded with a vision to create exceptional web experiences. Started with modern tech stack
                        including React, Node.js, and cutting-edge animation libraries.
                    </p>
                    <div style="margin-top: 0.75rem; display: flex; gap: 0.4rem; flex-wrap: wrap;">
                        <span class="badge badge-accent" style="font-size: 0.7rem;">Fresh Start</span>
                        <span class="badge badge-accent" style="font-size: 0.7rem;">Modern Stack</span>
                        <span class="badge badge-accent" style="font-size: 0.7rem;">Quality Focus</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-year">2024</div>
                    <h3 style="font-size: 1.25rem; margin-bottom: 0.75rem; color: var(--accent-primary);">Growing Portfolio</h3>
                    <p style="color: var(--text-secondary); line-height: 1.5; font-size: 0.9rem;">
                        Successfully delivered projects with exceptional results. Established brutalist design system
                        and began working with clients across different industries.
                    </p>
                    <div style="margin-top: 0.75rem; display: flex; gap: 0.4rem; flex-wrap: wrap;">
                        <span class="badge" style="font-size: 0.7rem;">Happy Clients</span>
                        <span class="badge" style="font-size: 0.7rem;">Design System</span>
                        <span class="badge" style="font-size: 0.7rem;">15+ Projects</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-year">2025</div>
                    <h3 style="font-size: 1.25rem; margin-bottom: 0.75rem; color: var(--accent-primary);">Advanced Technologies</h3>
                    <p style="color: var(--text-secondary); line-height: 1.5; font-size: 0.9rem;">
                        Integrated WebGL and Three.js for immersive experiences. Building complex web applications
                        with real-time features and optimal performance.
                    </p>
                    <div style="margin-top: 0.75rem; display: flex; gap: 0.4rem; flex-wrap: wrap;">
                        <span class="badge" style="font-size: 0.7rem;">WebGL</span>
                        <span class="badge" style="font-size: 0.7rem;">Advanced Tech</span>
                        <span class="badge" style="font-size: 0.7rem;">Performance</span>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-year">2026</div>
                    <h3 style="font-size: 1.25rem; margin-bottom: 0.75rem; color: var(--accent-primary);">Future Vision</h3>
                    <p style="color: var(--text-secondary); line-height: 1.5; font-size: 0.9rem;">
                        Pushing boundaries with AI-assisted development, edge computing, and cutting-edge
                        web technologies. Building the future of digital experiences.
                    </p>
                    <div style="margin-top: 0.75rem; display: flex; gap: 0.4rem; flex-wrap: wrap;">
                        <span class="badge" style="font-size: 0.7rem;">Innovation</span>
                        <span class="badge" style="font-size: 0.7rem;">AI Integration</span>
                        <span class="badge" style="font-size: 0.7rem;">Future Tech</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tech Stack Section -->
    <section class="section section-numbered" data-number="03" style="padding: 80px 0; background: var(--bg-secondary);">
        <div class="container">
            <h2 style="font-size: clamp(32px, 6vw, 56px); margin-bottom: 1rem; text-align: center;">TECHNOLOGY STACK</h2>
            <p style="text-align: center; color: var(--text-secondary); margin-bottom: 4rem; font-size: 1.125rem;">
                A curated ecosystem of tools for performance & reliability
            </p>

            <!-- Stack Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 4rem;">
                <div class="stack-card">
                    <h4>Frontend Experience</h4>
                    <ul class="stack-items">
                        <li>React</li>
                        <li>Next.js 15</li>
                        <li>Vue.js 3</li>
                        <li>Nuxt 3</li>
                        <li>Vite</li>
                        <li>Astro</li>
                        <li>SvelteKit</li>
                        <li>Remix</li>
                        <li>Qwik</li>
                        <li>Solid.js</li>
                    </ul>
                </div>

                <div class="stack-card">
                    <h4>Backend Languages</h4>
                    <ul class="stack-items">
                        <li>Node.js</li>
                        <li>Python</li>
                        <li>PHP 8+</li>
                        <li>Java</li>
                        <li>C# / .NET</li>
                        <li>Go (Golang)</li>
                        <li>Rust</li>
                        <li>Ruby</li>
                        <li>Kotlin</li>
                        <li>Scala</li>
                        <li>Deno</li>
                        <li>Bun</li>
                    </ul>
                </div>

                <div class="stack-card">
                    <h4>Backend Frameworks</h4>
                    <ul class="stack-items">
                        <li>Express.js</li>
                        <li>NestJS</li>
                        <li>Django</li>
                        <li>Flask</li>
                        <li>FastAPI</li>
                        <li>Laravel</li>
                        <li>Symfony</li>
                        <li>Spring Boot</li>
                        <li>ASP.NET Core</li>
                        <li>Ruby on Rails</li>
                        <li>Gin (Go)</li>
                        <li>Actix (Rust)</li>
                    </ul>
                </div>

                <div class="stack-card">
                    <h4>Styling & UI</h4>
                    <ul class="stack-items">
                        <li>Tailwind CSS</li>
                        <li>CSS Modules</li>
                        <li>SCSS/SASS</li>
                        <li>Styled Components</li>
                        <li>Emotion</li>
                        <li>Vanilla Extract</li>
                        <li>UnoCSS</li>
                        <li>Panda CSS</li>
                    </ul>
                </div>

                <div class="stack-card">
                    <h4>Data & Storage</h4>
                    <ul class="stack-items">
                        <li>PostgreSQL</li>
                        <li>MySQL</li>
                        <li>MongoDB</li>
                        <li>Redis</li>
                        <li>Elasticsearch</li>
                        <li>Supabase</li>
                        <li>PlanetScale</li>
                        <li>Neon</li>
                        <li>Turso</li>
                        <li>Cassandra</li>
                        <li>DynamoDB</li>
                    </ul>
                </div>

                <div class="stack-card">
                    <h4>API & Integration</h4>
                    <ul class="stack-items">
                        <li>REST</li>
                        <li>GraphQL</li>
                        <li>tRPC</li>
                        <li>WebSockets</li>
                        <li>gRPC</li>
                    </ul>
                </div>

                <div class="stack-card">
                    <h4>Infra / DevOps</h4>
                    <ul class="stack-items">
                        <li>Docker</li>
                        <li>Kubernetes</li>
                        <li>AWS</li>
                        <li>Google Cloud</li>
                        <li>Azure</li>
                        <li>Cloudflare</li>
                        <li>Vercel</li>
                        <li>Netlify</li>
                        <li>Railway</li>
                        <li>Fly.io</li>
                        <li>GitHub Actions</li>
                        <li>GitLab CI/CD</li>
                        <li>Terraform</li>
                        <li>Ansible</li>
                    </ul>
                </div>

                <div class="stack-card">
                    <h4>Animations & 3D</h4>
                    <ul class="stack-items">
                        <li>GSAP</li>
                        <li>Three.js</li>
                        <li>WebGL</li>
                        <li>Framer Motion</li>
                        <li>React Spring</li>
                        <li>Motion One</li>
                        <li>Lottie</li>
                        <li>Spline</li>
                        <li>R3F (React Three Fiber)</li>
                    </ul>
                </div>

                <div class="stack-card">
                    <h4>Quality & Testing</h4>
                    <ul class="stack-items">
                        <li>Jest</li>
                        <li>Vitest</li>
                        <li>Playwright</li>
                        <li>Cypress</li>
                        <li>ESLint</li>
                    </ul>
                </div>

                <div class="stack-card">
                    <h4>Observability</h4>
                    <ul class="stack-items">
                        <li>OpenTelemetry</li>
                        <li>Prometheus</li>
                        <li>Grafana</li>
                        <li>Sentry</li>
                        <li>Datadog</li>
                        <li>New Relic</li>
                    </ul>
                </div>

                <div class="stack-card">
                    <h4>AI & Machine Learning</h4>
                    <ul class="stack-items">
                        <li>OpenAI API</li>
                        <li>Claude API</li>
                        <li>Langchain</li>
                        <li>TensorFlow</li>
                        <li>PyTorch</li>
                        <li>Hugging Face</li>
                        <li>Vercel AI SDK</li>
                    </ul>
                </div>

                <div class="stack-card">
                    <h4>Mobile Development</h4>
                    <ul class="stack-items">
                        <li>React Native</li>
                        <li>Flutter</li>
                        <li>Expo</li>
                        <li>Ionic</li>
                        <li>Capacitor</li>
                        <li>Swift</li>
                        <li>Kotlin</li>
                    </ul>
                </div>

                <div class="stack-card">
                    <h4>Blockchain & Web3</h4>
                    <ul class="stack-items">
                        <li>Ethereum</li>
                        <li>Solidity</li>
                        <li>Web3.js</li>
                        <li>Ethers.js</li>
                        <li>Hardhat</li>
                        <li>Solana</li>
                        <li>Smart Contracts</li>
                    </ul>
                </div>

                <div class="stack-card">
                    <h4>Real-time & Messaging</h4>
                    <ul class="stack-items">
                        <li>WebSockets</li>
                        <li>Socket.io</li>
                        <li>Pusher</li>
                        <li>Ably</li>
                        <li>Apache Kafka</li>
                        <li>RabbitMQ</li>
                        <li>NATS</li>
                    </ul>
                </div>

                <div class="stack-card">
                    <h4>CMS & Headless</h4>
                    <ul class="stack-items">
                        <li>Sanity</li>
                        <li>Contentful</li>
                        <li>Strapi</li>
                        <li>Payload CMS</li>
                        <li>WordPress</li>
                        <li>Ghost</li>
                        <li>Prismic</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="section section-numbered" data-number="04" style="padding: 80px 0;">
        <div class="container">
            <h2 style="font-size: clamp(32px, 6vw, 56px); margin-bottom: 3rem; text-align: center;">CORE VALUES</h2>

            <div class="grid-3">
                <div class="card" style="padding: 0.85rem; text-align: center;">
                    <span class="material-symbols-outlined" style="font-size: 40px; color: var(--accent-primary); margin-bottom: 0.75rem; display: block;">bolt</span>
                    <h3 style="font-size: 1.125rem; margin-bottom: 0.5rem;">Speed First</h3>
                    <p style="color: var(--text-secondary); line-height: 1.4; margin-bottom: 0.5rem; font-size: 0.85rem;">
                        Every millisecond counts. We optimize for <span style="color: var(--accent-primary); font-weight: 600;">sub-second load times</span>
                        and 60fps animations across all devices.
                    </p>
                    <div class="code-block" data-lang="performance" style="text-align: left; font-size: 0.75rem;">
                        <span class="code-line" data-line="1"><span class="code-comment">// Our targets</span></span>
                        <span class="code-line" data-line="2">FCP &lt; 0.8s</span>
                        <span class="code-line" data-line="3">LCP &lt; 1.2s</span>
                        <span class="code-line" data-line="4">TTI &lt; 1.5s</span>
                    </div>
                </div>

                <div class="card" style="padding: 0.85rem; text-align: center;">
                    <span class="material-symbols-outlined" style="font-size: 40px; color: var(--accent-primary); margin-bottom: 0.75rem; display: block;">target</span>
                    <h3 style="font-size: 1.125rem; margin-bottom: 0.5rem;">Pixel Perfect</h3>
                    <p style="color: var(--text-secondary); line-height: 1.4; margin-bottom: 0.5rem; font-size: 0.85rem;">
                        Designs that match <span style="color: var(--accent-primary); font-weight: 600;">1:1 with mockups</span>.
                        No compromises on visual quality or user experience.
                    </p>
                    <div class="code-block" data-lang="quality" style="text-align: left; font-size: 0.75rem;">
                        <span class="code-line" data-line="1"><span class="code-comment">// QA Standards</span></span>
                        <span class="code-line" data-line="2">browserTesting: <span class="code-string">"All"</span></span>
                        <span class="code-line" data-line="3">responsive: <span class="code-string">"100%"</span></span>
                        <span class="code-line" data-line="4">accessibility: <span class="code-string">"WCAG AA"</span></span>
                    </div>
                </div>

                <div class="card" style="padding: 0.85rem; text-align: center;">
                    <span class="material-symbols-outlined" style="font-size: 40px; color: var(--accent-primary); margin-bottom: 0.75rem; display: block;">lock</span>
                    <h3 style="font-size: 1.125rem; margin-bottom: 0.5rem;">Security Built-In</h3>
                    <p style="color: var(--text-secondary); line-height: 1.4; margin-bottom: 0.5rem; font-size: 0.85rem;">
                        Security from day one. <span style="color: var(--accent-primary); font-weight: 600;">Zero-trust architecture</span>,
                        encrypted everything, regular audits.
                    </p>
                    <div class="code-block" data-lang="security" style="text-align: left; font-size: 0.75rem;">
                        <span class="code-line" data-line="1"><span class="code-comment">// Security first</span></span>
                        <span class="code-line" data-line="2">SSL: <span class="code-string">"Required"</span></span>
                        <span class="code-line" data-line="3">2FA: <span class="code-string">"Enabled"</span></span>
                        <span class="code-line" data-line="4">audits: <span class="code-string">"Monthly"</span></span>
                    </div>
                </div>

                <div class="card" style="padding: 0.85rem; text-align: center;">
                    <span class="material-symbols-outlined" style="font-size: 40px; color: var(--accent-primary); margin-bottom: 0.75rem; display: block;">auto_awesome</span>
                    <h3 style="font-size: 1.125rem; margin-bottom: 0.5rem;">Innovation Driven</h3>
                    <p style="color: var(--text-secondary); line-height: 1.4; font-size: 0.85rem;">
                        Always exploring new tech. Early adopters of WebGL, AI, edge computing, and real-time systems.
                    </p>
                </div>

                <div class="card" style="padding: 0.85rem; text-align: center;">
                    <span class="material-symbols-outlined" style="font-size: 40px; color: var(--accent-primary); margin-bottom: 0.75rem; display: block;">analytics</span>
                    <h3 style="font-size: 1.125rem; margin-bottom: 0.5rem;">Data Transparency</h3>
                    <p style="color: var(--text-secondary); line-height: 1.4; font-size: 0.85rem;">
                        Real-time dashboards, honest timelines, clear communication. No surprises, ever.
                    </p>
                </div>

                <div class="card" style="padding: 0.85rem; text-align: center;">
                    <span class="material-symbols-outlined" style="font-size: 40px; color: var(--accent-primary); margin-bottom: 0.75rem; display: block;">trending_up</span>
                    <h3 style="font-size: 1.125rem; margin-bottom: 0.5rem;">Built to Scale</h3>
                    <p style="color: var(--text-secondary); line-height: 1.4; font-size: 0.85rem;">
                        Architecture designed to grow from 100 to 100 million users without breaking.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="section section-numbered" data-number="05" style="padding: 80px 0; background: var(--bg-secondary);">
        <div class="container">
            <h2 style="font-size: clamp(32px, 6vw, 56px); margin-bottom: 1rem; text-align: center;">MEET THE TEAM</h2>
            <p style="text-align: center; color: var(--text-secondary); margin-bottom: 4rem; font-size: 1.125rem;">
                Expert team focused on delivering quality solutions
            </p>

            <div class="grid-4">
                <div class="card" style="padding: 0.85rem; text-align: center;">
                    <div style="width: 80px; height: 80px; margin: 0 auto 1rem; background: linear-gradient(135deg, var(--accent-primary) 0%, var(--accent-hot) 100%); border: 3px solid var(--border); display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined" style="font-size: 36px; color: var(--bg-primary);">engineering</span>
                    </div>
                    <h3 style="font-size: 1rem; margin-bottom: 0.35rem;">Lead Engineer</h3>
                    <p style="color: var(--accent-primary); font-size: 0.75rem; margin-bottom: 0.5rem; font-weight: 600;">Full-Stack Architect</p>
                    <p style="color: var(--text-secondary); font-size: 0.825rem; line-height: 1.4; margin-bottom: 0.75rem;">
                        10+ years building scalable systems. Expert in React, Node.js, and cloud architecture.
                    </p>
                    <div style="display: flex; gap: 0.5rem; justify-content: center; flex-wrap: wrap;">
                        <span class="badge" style="font-size: 0.75rem;">React</span>
                        <span class="badge" style="font-size: 0.75rem;">Node.js</span>
                        <span class="badge" style="font-size: 0.75rem;">AWS</span>
                    </div>
                </div>

                <div class="card" style="padding: 0.85rem; text-align: center;">
                    <div style="width: 80px; height: 80px; margin: 0 auto 1rem; background: linear-gradient(135deg, var(--accent-hot) 0%, var(--accent-primary) 100%); border: 3px solid var(--border); display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined" style="font-size: 36px; color: var(--bg-primary);">palette</span>
                    </div>
                    <h3 style="font-size: 1rem; margin-bottom: 0.35rem;">Design Lead</h3>
                    <p style="color: var(--accent-hot); font-size: 0.75rem; margin-bottom: 0.5rem; font-weight: 600;">UX/UI & Product Design</p>
                    <p style="color: var(--text-secondary); font-size: 0.825rem; line-height: 1.4; margin-bottom: 0.75rem;">
                        8+ years crafting user experiences. Specializes in brutalist and modern design systems.
                    </p>
                    <div style="display: flex; gap: 0.5rem; justify-content: center; flex-wrap: wrap;">
                        <span class="badge" style="font-size: 0.75rem;">Figma</span>
                        <span class="badge" style="font-size: 0.75rem;">UX</span>
                        <span class="badge" style="font-size: 0.75rem;">Design Systems</span>
                    </div>
                </div>

                <div class="card" style="padding: 0.85rem; text-align: center;">
                    <div style="width: 80px; height: 80px; margin: 0 auto 1rem; background: linear-gradient(135deg, var(--accent-primary) 0%, var(--accent-hot) 100%); border: 3px solid var(--border); display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined" style="font-size: 36px; color: var(--bg-primary);">engineering</span>
                    </div>
                    <h3 style="font-size: 1rem; margin-bottom: 0.35rem;">DevOps Lead</h3>
                    <p style="color: var(--accent-primary); font-size: 0.75rem; margin-bottom: 0.5rem; font-weight: 600;">Infrastructure & Security</p>
                    <p style="color: var(--text-secondary); font-size: 0.825rem; line-height: 1.4; margin-bottom: 0.75rem;">
                        12+ years managing cloud infrastructure. Kubernetes expert with 99.9% uptime record.
                    </p>
                    <div style="display: flex; gap: 0.5rem; justify-content: center; flex-wrap: wrap;">
                        <span class="badge" style="font-size: 0.75rem;">K8s</span>
                        <span class="badge" style="font-size: 0.75rem;">Docker</span>
                        <span class="badge" style="font-size: 0.75rem;">GCP</span>
                    </div>
                </div>

                <div class="card" style="padding: 0.85rem; text-align: center;">
                    <div style="width: 80px; height: 80px; margin: 0 auto 1rem; background: linear-gradient(135deg, var(--accent-hot) 0%, var(--accent-primary) 100%); border: 3px solid var(--border); display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined" style="font-size: 36px; color: var(--bg-primary);">smartphone</span>
                    </div>
                    <h3 style="font-size: 1rem; margin-bottom: 0.35rem;">Mobile Lead</h3>
                    <p style="color: var(--accent-hot); font-size: 0.75rem; margin-bottom: 0.5rem; font-weight: 600;">iOS & Android Expert</p>
                    <p style="color: var(--text-secondary); font-size: 0.825rem; line-height: 1.4; margin-bottom: 0.75rem;">
                        7+ years building native and cross-platform apps. React Native and Flutter specialist.
                    </p>
                    <div style="display: flex; gap: 0.5rem; justify-content: center; flex-wrap: wrap;">
                        <span class="badge" style="font-size: 0.75rem;">React Native</span>
                        <span class="badge" style="font-size: 0.75rem;">Flutter</span>
                        <span class="badge" style="font-size: 0.75rem;">Swift</span>
                    </div>
                </div>

                <div class="card" style="padding: 0.85rem; text-align: center;">
                    <div style="width: 80px; height: 80px; margin: 0 auto 1rem; background: linear-gradient(135deg, var(--accent-primary) 0%, var(--accent-hot) 100%); border: 3px solid var(--border); display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined" style="font-size: 36px; color: var(--bg-primary);">view_in_ar</span>
                    </div>
                    <h3 style="font-size: 1rem; margin-bottom: 0.35rem;">WebGL Specialist</h3>
                    <p style="color: var(--accent-primary); font-size: 0.75rem; margin-bottom: 0.5rem; font-weight: 600;">3D & Animation Expert</p>
                    <p style="color: var(--text-secondary); font-size: 0.825rem; line-height: 1.4; margin-bottom: 0.75rem;">
                        6+ years creating immersive web experiences with Three.js, GSAP, and custom shaders.
                    </p>
                    <div style="display: flex; gap: 0.5rem; justify-content: center; flex-wrap: wrap;">
                        <span class="badge" style="font-size: 0.75rem;">Three.js</span>
                        <span class="badge" style="font-size: 0.75rem;">WebGL</span>
                        <span class="badge" style="font-size: 0.75rem;">GLSL</span>
                    </div>
                </div>

                <div class="card" style="padding: 0.85rem; text-align: center;">
                    <div style="width: 80px; height: 80px; margin: 0 auto 1rem; background: linear-gradient(135deg, var(--accent-hot) 0%, var(--accent-primary) 100%); border: 3px solid var(--border); display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined" style="font-size: 36px; color: var(--bg-primary);">storage</span>
                    </div>
                    <h3 style="font-size: 1rem; margin-bottom: 0.35rem;">Data Engineer</h3>
                    <p style="color: var(--accent-hot); font-size: 0.75rem; margin-bottom: 0.5rem; font-weight: 600;">Database & Analytics</p>
                    <p style="color: var(--text-secondary); font-size: 0.825rem; line-height: 1.4; margin-bottom: 0.75rem;">
                        9+ years optimizing databases and building real-time analytics pipelines.
                    </p>
                    <div style="display: flex; gap: 0.5rem; justify-content: center; flex-wrap: wrap;">
                        <span class="badge" style="font-size: 0.75rem;">PostgreSQL</span>
                        <span class="badge" style="font-size: 0.75rem;">MongoDB</span>
                        <span class="badge" style="font-size: 0.75rem;">Redis</span>
                    </div>
                </div>

                <div class="card" style="padding: 0.85rem; text-align: center;">
                    <div style="width: 80px; height: 80px; margin: 0 auto 1rem; background: linear-gradient(135deg, var(--accent-primary) 0%, var(--accent-hot) 100%); border: 3px solid var(--border); display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined" style="font-size: 36px; color: var(--bg-primary);">psychology</span>
                    </div>
                    <h3 style="font-size: 1rem; margin-bottom: 0.35rem;">AI Engineer</h3>
                    <p style="color: var(--accent-primary); font-size: 0.75rem; margin-bottom: 0.5rem; font-weight: 600;">Machine Learning & AI</p>
                    <p style="color: var(--text-secondary); font-size: 0.825rem; line-height: 1.4; margin-bottom: 0.75rem;">
                        5+ years integrating AI into web apps. LLM integration and ML model deployment.
                    </p>
                    <div style="display: flex; gap: 0.5rem; justify-content: center; flex-wrap: wrap;">
                        <span class="badge" style="font-size: 0.75rem;">TensorFlow</span>
                        <span class="badge" style="font-size: 0.75rem;">GPT API</span>
                        <span class="badge" style="font-size: 0.75rem;">Python</span>
                    </div>
                </div>

                <div class="card" style="padding: 0.85rem; text-align: center;">
                    <div style="width: 80px; height: 80px; margin: 0 auto 1rem; background: linear-gradient(135deg, var(--accent-hot) 0%, var(--accent-primary) 100%); border: 3px solid var(--border); display: flex; align-items: center; justify-content: center;">
                        <div style="font-size: 4rem;">◉</div>
                    </div>
                    <h3 style="font-size: 1rem; margin-bottom: 0.35rem;">Product Manager</h3>
                    <p style="color: var(--accent-hot); font-size: 0.75rem; margin-bottom: 0.5rem; font-weight: 600;">Strategy & Execution</p>
                    <p style="color: var(--text-secondary); font-size: 0.825rem; line-height: 1.4; margin-bottom: 0.75rem;">
                        11+ years managing products from concept to scale. Ex-FAANG product lead.
                    </p>
                    <div style="display: flex; gap: 0.5rem; justify-content: center; flex-wrap: wrap;">
                        <span class="badge" style="font-size: 0.75rem;">Agile</span>
                        <span class="badge" style="font-size: 0.75rem;">Strategy</span>
                        <span class="badge" style="font-size: 0.75rem;">Growth</span>
                    </div>
                </div>
            </div>

            <div style="margin-top: 3rem; text-align: center;">
                <p style="color: var(--text-secondary); font-size: 1rem;">
                    Working together to deliver exceptional results
                </p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section" style="padding: 100px 0;">
        <div class="container">
            <div class="card" style="padding: 5rem 3rem; text-align: center; background: linear-gradient(135deg, var(--bg-secondary) 0%, var(--bg-primary) 100%); border: 4px solid var(--accent-primary); position: relative; overflow: hidden;">
                <div class="floating-code" style="top: 10%; left: 10%; animation: float 5s ease-in-out infinite;">console.log("Let's build!");</div>
                <div class="floating-code" style="bottom: 15%; right: 10%; animation: float 7s ease-in-out infinite;">&lt;Innovation /&gt;</div>

                <h2 style="font-size: clamp(32px, 6vw, 64px); margin-bottom: 1.5rem; position: relative; z-index: 1;">
                    READY TO BUILD<br>SOMETHING <span style="color: var(--accent-primary);">AMAZING</span>?
                </h2>
                <p style="font-size: 1.25rem; color: var(--text-secondary); margin-bottom: 3rem; max-width: 60ch; margin-left: auto; margin-right: auto; position: relative; z-index: 1;">
                    Let's discuss your project and create a solution that scales,
                    performs, and delivers results.
                </p>
                <div style="display: flex; gap: 1.5rem; justify-content: center; flex-wrap: wrap; position: relative; z-index: 1;">
                    <a href="portfolio.php" class="btn btn-secondary btn-large">VIEW OUR WORK</a>
                    <a href="index.php#contact" class="btn btn-primary btn-large" style="padding: 1.25rem 3rem;">START YOUR PROJECT →</a>
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
                        <a href="index.php#contact" class="footer-link">Get in Touch</a>
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
                <p>&copy; 2026 Devycore. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="/devycore-v2/public/assets/js/main.js"></script>
    <script>
        // Counter animation
        function animateCounters() {
            document.querySelectorAll('.counter').forEach(counter => {
                const target = parseInt(counter.dataset.target);
                const duration = 2000;
                const step = target / (duration / 16);
                let current = 0;

                const timer = setInterval(() => {
                    current += step;
                    if (current >= target) {
                        counter.textContent = target + (counter.textContent.includes('.') ? '.9%' : '+');
                        clearInterval(timer);
                    } else {
                        counter.textContent = Math.floor(current);
                    }
                }, 16);
            });
        }

        // Skill bars animation
        function animateSkillBars() {
            document.querySelectorAll('.skill-bar-fill').forEach(bar => {
                const width = bar.dataset.width;
                setTimeout(() => {
                    bar.style.width = width;
                }, 100);
            });
        }

        // Trigger animations on scroll
        if (typeof gsap !== 'undefined') {
            gsap.registerPlugin(ScrollTrigger);

            // Animate sections
            gsap.utils.toArray('.section').forEach(section => {
                gsap.from(section, {
                    opacity: 0,
                    y: 60,
                    duration: 0.8,
                    scrollTrigger: {
                        trigger: section,
                        start: 'top 80%',
                        end: 'top 20%',
                        toggleActions: 'play none none reverse'
                    }
                });
            });

            // Animate timeline items
            gsap.utils.toArray('.timeline-item').forEach((item, i) => {
                gsap.from(item, {
                    opacity: 0,
                    x: -60,
                    duration: 0.6,
                    scrollTrigger: {
                        trigger: item,
                        start: 'top 85%',
                        toggleActions: 'play none none none'
                    }
                });
            });

            // Animate counters on scroll
            ScrollTrigger.create({
                trigger: '.metric-card',
                start: 'top 75%',
                onEnter: animateCounters,
                once: true
            });

            // Animate skill bars on scroll
            ScrollTrigger.create({
                trigger: '.skill-bar',
                start: 'top 75%',
                onEnter: animateSkillBars,
                once: true
            });

            // Animate tech logos
            gsap.from('.tech-logo', {
                scale: 0,
                rotation: 45,
                stagger: 0.05,
                duration: 0.5,
                ease: 'back.out(1.7)',
                scrollTrigger: {
                    trigger: '.tech-logo',
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                }
            });
        }
    </script>
</body>
</html>
