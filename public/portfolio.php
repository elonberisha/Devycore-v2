<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Devycore Portfolio - View our featured projects and client work.">
    <title>Portfolio - Devycore</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&family=Fira+Code:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="/devycore-v2/public/assets/css/base.css">
    <link rel="stylesheet" href="/devycore-v2/public/assets/css/layout.css">
    <link rel="stylesheet" href="/devycore-v2/public/assets/css/components.css">
    <link rel="stylesheet" href="/devycore-v2/public/assets/css/brutalist.css">

    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.4/gsap.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.4/ScrollTrigger.min.js" defer></script>

    <style>
        .filter-buttons {
            display: flex;
            gap: 1rem;
            margin-bottom: 3rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .filter-btn {
            padding: 0.75rem 1.5rem;
            background: var(--bg-secondary);
            border: 2px solid var(--border);
            color: var(--text-primary);
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
        }

        .filter-btn::before {
            content: '';
            position: absolute;
            inset: -2px;
            background: linear-gradient(45deg, var(--accent-primary), var(--accent-hot));
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: -1;
        }

        .filter-btn:hover,
        .filter-btn.active {
            color: var(--bg-primary);
            border-color: var(--accent-primary);
            transform: translateY(-2px);
        }

        .filter-btn:hover::before,
        .filter-btn.active::before {
            opacity: 1;
        }

        .project-card {
            position: relative;
            overflow: hidden;
            aspect-ratio: 16/10;
            cursor: pointer;
            background: var(--bg-secondary);
            border: 3px solid var(--border);
            transition: all 0.4s ease;
        }

        .project-card:hover {
            border-color: var(--accent-primary);
            transform: translateY(-8px);
            box-shadow: 0 12px 0 var(--accent-primary);
        }

        .project-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease, filter 0.4s ease;
            filter: grayscale(30%);
        }

        .project-card:hover img {
            transform: scale(1.1);
            filter: grayscale(0%);
        }

        .project-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(10,10,10,0.7) 0%, rgba(10,10,10,0.95) 100%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 2rem;
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .project-card:hover .project-overlay {
            opacity: 1;
        }

        .project-title {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: var(--accent-primary);
        }

        .project-description {
            font-size: 1rem;
            color: var(--text-secondary);
            margin-bottom: 1rem;
            line-height: 1.6;
        }

        .project-tech {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-bottom: 1.5rem;
        }

        .tech-tag {
            padding: 0.35rem 0.85rem;
            background: var(--bg-primary);
            border: 1px solid var(--accent-primary);
            color: var(--accent-primary);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            font-family: 'Fira Code', monospace;
        }

        .project-link {
            color: var(--accent-primary);
            text-decoration: none;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .project-link:hover {
            color: var(--accent-hot);
            transform: translateX(5px);
        }

        .featured-badge {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            padding: 0.5rem 1.25rem;
            background: var(--accent-hot);
            color: var(--bg-primary);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            z-index: 2;
            box-shadow: 0 4px 0 rgba(255, 0, 85, 0.3);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-bottom: 4rem;
        }

        .stat-card {
            background: var(--bg-secondary);
            border: 3px solid var(--border);
            padding: 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--accent-primary) 0%, var(--accent-hot) 100%);
        }

        .stat-number {
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1;
            background: linear-gradient(135deg, var(--accent-primary) 0%, var(--accent-hot) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-label {
            font-size: 1rem;
            color: var(--text-secondary);
            margin-top: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .category-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            background: var(--bg-primary);
            border: 1px solid var(--accent-primary);
            color: var(--accent-primary);
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            margin-left: 0.5rem;
        }

        .floating-code {
            position: absolute;
            font-family: 'Fira Code', monospace;
            font-size: 0.8rem;
            color: var(--accent-primary);
            opacity: 0.2;
            pointer-events: none;
            white-space: nowrap;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        .client-logos {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .client-logo {
            height: 80px;
            background: var(--bg-secondary);
            border: 2px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            transition: all 0.3s ease;
            opacity: 0.7;
        }

        .client-logo:hover {
            opacity: 1;
            border-color: var(--accent-primary);
            transform: translateY(-5px);
        }

        @media (max-width: 768px) {
            .filter-buttons {
                justify-content: flex-start;
            }

            .project-title {
                font-size: 1.25rem;
            }
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
    <div class="floating-code" style="top: 10%; left: 3%; animation: float 6s ease-in-out infinite;">import { Project } from './portfolio';</div>
    <div class="floating-code" style="top: 25%; right: 5%; animation: float 8s ease-in-out infinite;">const projects = await fetchAll();</div>
    <div class="floating-code" style="top: 50%; left: 8%; animation: float 7s ease-in-out infinite;">&lt;Portfolio filter="featured" /&gt;</div>
    <div class="floating-code" style="top: 70%; right: 12%; animation: float 9s ease-in-out infinite;">{ deployed: "production", status: "live" }</div>

    <!-- Header -->
    <header class="site-header">
        <div class="header-inner container">
            <a href="index.php" class="site-logo" style="display: flex; align-items: center;">
                <img src="/devycore-v2/public/assets/images/logo.svg" alt="Devycore Logo" style="height: 75px; width: auto; max-width: 280px;">
            </a>

            <nav class="main-nav" id="mainNav">
                <a href="index.php#services" class="nav-link">Services</a>
                <a href="portfolio.php" class="nav-link active">Portfolio</a>
                <a href="about.php" class="nav-link">About</a>
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
    <section class="section-hero" style="padding: 120px 0 60px;">
        <div class="container">
            <div class="split-layout" style="gap: 4rem; align-items: center;">
                <div>
                    <div class="badge-row" style="margin-bottom: 2rem; justify-content: center;">
                <span class="badge badge-accent">QUALITY WORK</span>
                <span class="badge badge-accent">HAPPY CLIENTS</span>
                <span class="badge badge-accent">MODERN TECH</span>
                <span class="badge badge-accent">FAST DELIVERY</span>
            </div>

            <h1 class="glitch" data-text="OUR WORK" style="font-size: clamp(48px, 10vw, 96px); text-align: center;">
                OUR WORK
            </h1>

            <p style="max-width: 60ch; margin: 2rem auto 0; font-size: 1.25rem; color: var(--text-secondary); text-align: center;">
                A curated selection of our <span style="color: var(--accent-primary); font-weight: 600;">best projects</span>.
                From startups to Fortune 500 companies, we build digital products that
                <span style="color: var(--accent-hot); font-weight: 600;">scale</span>,
                <span style="color: var(--accent-primary); font-weight: 600;">perform</span>, and
                <span style="color: var(--accent-hot); font-weight: 600;">deliver results</span>.
            </p>
                </div>
                
<!-- 3D Animated Robot -->
                <div style="display: flex; align-items: center; justify-content: center; position: relative;">
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

    <!-- Stats Section -->
    <section class="section" style="padding: 60px 0;">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number counter" data-target="50">0</div>
                    <div class="stat-label">Projects Delivered</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number counter" data-target="35">0</div>
                    <div class="stat-label">Happy Clients</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number counter" data-target="20">0</div>
                    <div class="stat-label">Technologies</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">100<span style="font-size: 2rem;">%</span></div>
                    <div class="stat-label">Quality Focus</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Filter Section -->
    <section class="section section-numbered" data-number="01" style="padding: 40px 0;">
        <div class="container">
            <h2 style="font-size: clamp(28px, 5vw, 48px); margin-bottom: 2rem; text-align: center;">
                FILTER BY CATEGORY
            </h2>

            <div class="filter-buttons">
                <button class="filter-btn active" data-filter="all">
                    All Projects <span class="category-badge" id="count-all">0</span>
                </button>
                <button class="filter-btn" data-filter="featured">
                    Featured <span class="category-badge" id="count-featured">0</span>
                </button>
                <button class="filter-btn" data-filter="web-app">
                    Web Apps <span class="category-badge" id="count-web-app">0</span>
                </button>
                <button class="filter-btn" data-filter="ecommerce">
                    E-Commerce <span class="category-badge" id="count-ecommerce">0</span>
                </button>
                <button class="filter-btn" data-filter="enterprise">
                    Enterprise <span class="category-badge" id="count-enterprise">0</span>
                </button>
            </div>
        </div>
    </section>

    <!-- Projects Grid -->
    <section class="section section-numbered" data-number="02" style="padding: 0 0 80px;">
        <div class="container">
            <div class="grid-3" id="projectsGrid">
                <!-- Projects will be loaded here dynamically -->
                <div style="grid-column: 1/-1; text-align: center; padding: 4rem;">
                    <div class="status-dot online" style="width: 60px; height: 60px; margin: 0 auto 1rem;"></div>
                    <p style="color: var(--text-secondary); font-size: 1.125rem;">Loading amazing projects...</p>
                </div>
            </div>

            <!-- Load More -->
            <div style="text-align: center; margin-top: 4rem; display: none;" id="loadMoreSection">
                <button class="btn btn-secondary btn-large" id="loadMoreBtn">
                    LOAD MORE PROJECTS
                </button>
            </div>
        </div>
    </section>

    <!-- Client Logos Section -->
    <section class="section section-numbered" data-number="03" style="padding: 80px 0; background: var(--bg-secondary);">
        <div class="container">
            <h2 style="font-size: clamp(28px, 5vw, 48px); margin-bottom: 1rem; text-align: center;">
                TRUSTED BY INDUSTRY LEADERS
            </h2>
            <p style="text-align: center; color: var(--text-secondary); margin-bottom: 3rem;">
                Companies that trust us to build their digital future
            </p>

            <div id="partnersContainer">
                <!-- Partners will be loaded dynamically from admin panel -->
                <div style="text-align: center; padding: 3rem; color: var(--text-secondary); font-size: 1.125rem;">
                    No partners published
                </div>
            </div>
        </div>
    </section>

    <!-- Technologies Used -->
    <section class="section section-numbered" data-number="04" style="padding: 80px 0;">
        <div class="container">
            <h2 style="font-size: clamp(28px, 5vw, 48px); margin-bottom: 3rem; text-align: center;">
                TECHNOLOGIES WE USE
            </h2>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
                <div class="card" style="padding: 2rem;">
                    <h3 style="color: var(--accent-primary); margin-bottom: 1rem; font-size: 1.25rem;">FRONTEND</h3>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                        <span class="tech-tag">React</span>
                        <span class="tech-tag">Next.js</span>
                        <span class="tech-tag">Vue.js</span>
                        <span class="tech-tag">Nuxt.js</span>
                        <span class="tech-tag">Angular</span>
                        <span class="tech-tag">Svelte</span>
                        <span class="tech-tag">SvelteKit</span>
                        <span class="tech-tag">Solid.js</span>
                        <span class="tech-tag">Qwik</span>
                        <span class="tech-tag">Astro</span>
                        <span class="tech-tag">TypeScript</span>
                        <span class="tech-tag">JavaScript</span>
                        <span class="tech-tag">HTML5</span>
                        <span class="tech-tag">CSS3</span>
                        <span class="tech-tag">Tailwind CSS</span>
                        <span class="tech-tag">GSAP</span>
                        <span class="tech-tag">Three.js</span>
                        <span class="tech-tag">WebGL</span>
                        <span class="tech-tag">Canvas API</span>
                        <span class="tech-tag">Framer Motion</span>
                        <span class="tech-tag">Redux</span>
                        <span class="tech-tag">Zustand</span>
                        <span class="tech-tag">Vite</span>
                        <span class="tech-tag">Webpack</span>
                    </div>
                </div>

                <div class="card" style="padding: 2rem;">
                    <h3 style="color: var(--accent-hot); margin-bottom: 1rem; font-size: 1.25rem;">BACKEND</h3>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                        <span class="tech-tag">Node.js</span>
                        <span class="tech-tag">PHP 8+</span>
                        <span class="tech-tag">Python</span>
                        <span class="tech-tag">Java</span>
                        <span class="tech-tag">C#</span>
                        <span class="tech-tag">.NET Core</span>
                        <span class="tech-tag">Go</span>
                        <span class="tech-tag">Rust</span>
                        <span class="tech-tag">Ruby</span>
                        <span class="tech-tag">Scala</span>
                        <span class="tech-tag">Kotlin</span>
                        <span class="tech-tag">Elixir</span>
                        <span class="tech-tag">GraphQL</span>
                        <span class="tech-tag">REST API</span>
                        <span class="tech-tag">gRPC</span>
                        <span class="tech-tag">Websockets</span>
                        <span class="tech-tag">Spring Boot</span>
                        <span class="tech-tag">Django</span>
                        <span class="tech-tag">FastAPI</span>
                        <span class="tech-tag">Laravel</span>
                        <span class="tech-tag">Express</span>
                        <span class="tech-tag">NestJS</span>
                    </div>
                </div>

                <div class="card" style="padding: 2rem;">
                    <h3 style="color: var(--accent-primary); margin-bottom: 1rem; font-size: 1.25rem;">DATABASE</h3>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                        <span class="tech-tag">PostgreSQL</span>
                        <span class="tech-tag">MongoDB</span>
                        <span class="tech-tag">Redis</span>
                        <span class="tech-tag">MySQL</span>
                        <span class="tech-tag">Elasticsearch</span>
                    </div>
                </div>

                <div class="card" style="padding: 2rem;">
                    <h3 style="color: var(--accent-hot); margin-bottom: 1rem; font-size: 1.25rem;">DEVOPS</h3>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                        <span class="tech-tag">AWS</span>
                        <span class="tech-tag">Docker</span>
                        <span class="tech-tag">Kubernetes</span>
                        <span class="tech-tag">CI/CD</span>
                        <span class="tech-tag">Nginx</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section" style="padding: 100px 0;">
        <div class="container">
            <div class="card" style="padding: 5rem 3rem; text-align: center; background: linear-gradient(135deg, var(--bg-secondary) 0%, var(--bg-primary) 100%); border: 4px solid var(--accent-primary); position: relative; overflow: hidden;">
                <div class="floating-code" style="top: 10%; left: 10%; animation: float 5s ease-in-out infinite;">const nextProject = yourIdea;</div>
                <div class="floating-code" style="bottom: 15%; right: 10%; animation: float 7s ease-in-out infinite;">&lt;Build amazing="true" /&gt;</div>

                <h2 style="font-size: clamp(32px, 6vw, 64px); margin-bottom: 1.5rem; position: relative; z-index: 1;">
                    HAVE A PROJECT<br>IN <span style="color: var(--accent-primary);">MIND</span>?
                </h2>
                <p style="font-size: 1.25rem; color: var(--text-secondary); margin-bottom: 3rem; max-width: 60ch; margin-left: auto; margin-right: auto; position: relative; z-index: 1;">
                    Let's discuss your vision and build something extraordinary together.
                    From concept to launch, we're with you every step.
                </p>
                <div style="display: flex; gap: 1.5rem; justify-content: center; flex-wrap: wrap; position: relative; z-index: 1;">
                    <a href="about.php" class="btn btn-secondary btn-large">LEARN ABOUT US</a>
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
        // Load projects from API
        let allProjects = [];
        let currentFilter = 'all';
        let displayCount = 9;

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
                        counter.textContent = target + '+';
                        clearInterval(timer);
                    } else {
                        counter.textContent = Math.floor(current);
                    }
                }, 16);
            });
        }

        async function loadProjects() {
            try {
                const response = await fetch('/devycore-v2/public/api/projects.php');
                const data = await response.json();

                if (data.success) {
                    allProjects = data.data || [];
                    updateFilterCounts();
                    renderProjects(allProjects);
                } else {
                    showError('Failed to load projects');
                }
            } catch (error) {
                console.error('Error loading projects:', error);
                showError('Error loading projects. Please try again later.');
            }
        }

        function updateFilterCounts() {
            const counts = {
                all: allProjects.length,
                featured: allProjects.filter(p => p.featured == 1 || p.featured === true).length,
                'web-app': allProjects.filter(p => (p.category || 'web-app') === 'web-app').length,
                ecommerce: allProjects.filter(p => (p.category || 'web-app') === 'ecommerce').length,
                enterprise: allProjects.filter(p => (p.category || 'web-app') === 'enterprise').length
            };

            Object.keys(counts).forEach(key => {
                const el = document.getElementById(`count-${key}`);
                if (el) el.textContent = counts[key];
            });
        }

        function renderProjects(projects) {
            const grid = document.getElementById('projectsGrid');
            const displayProjects = projects.slice(0, displayCount);

            if (displayProjects.length === 0) {
                grid.innerHTML = `
                    <div style="grid-column: 1/-1; text-align: center; padding: 4rem;">
                        <p style="color: var(--text-secondary); font-size: 1.125rem;">No projects found for this category.</p>
                    </div>
                `;
                document.getElementById('loadMoreSection').style.display = 'none';
                return;
            }

            grid.innerHTML = displayProjects.map(project => {
                const tech = Array.isArray(project.technologies) ? project.technologies : JSON.parse(project.technologies || '[]');
                const isFeatured = project.featured == 1 || project.featured === true;

                return `
                    <div class="card project-card" data-category="${project.category || 'web-app'}" data-featured="${isFeatured}">
                        ${isFeatured ? '<div class="featured-badge">★ FEATURED</div>' : ''}
                        <img src="${project.image_path || 'https://via.placeholder.com/800x500/0a0a0a/00ff88?text=' + encodeURIComponent(project.title)}"
                             alt="${project.title}"
                             onerror="this.src='https://via.placeholder.com/800x500/0a0a0a/00ff88?text=Project'">
                        <div class="project-overlay">
                            <h3 class="project-title">${project.title}</h3>
                            <p class="project-description">${project.description || 'High-performance web application built with cutting-edge technology'}</p>
                            <div class="project-tech">
                                ${tech.slice(0, 4).map(t => `<span class="tech-tag">${t}</span>`).join('')}
                            </div>
                            <a href="${project.url}" target="_blank" class="project-link">
                                View Project →
                            </a>
                        </div>
                    </div>
                `;
            }).join('');

            // Show/hide load more button
            const loadMoreSection = document.getElementById('loadMoreSection');
            if (projects.length > displayCount) {
                loadMoreSection.style.display = 'block';
            } else {
                loadMoreSection.style.display = 'none';
            }

            // Animate cards
            if (typeof gsap !== 'undefined') {
                gsap.from('.project-card', {
                    opacity: 0,
                    y: 60,
                    stagger: 0.1,
                    duration: 0.6,
                    ease: 'power2.out'
                });
            }
        }

        function showError(message) {
            const grid = document.getElementById('projectsGrid');
            grid.innerHTML = `
                <div style="grid-column: 1/-1; text-align: center; padding: 4rem;">
                    <p style="color: var(--accent-hot); font-size: 1.125rem;">${message}</p>
                </div>
            `;
        }

        function filterProjects(category) {
            currentFilter = category;
            displayCount = 9;

            let filtered = allProjects;
            if (category !== 'all') {
                if (category === 'featured') {
                    filtered = allProjects.filter(p => p.featured == 1 || p.featured === true);
                } else {
                    filtered = allProjects.filter(p => (p.category || 'web-app') === category);
                }
            }

            renderProjects(filtered);
        }

        // Filter button handlers
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                filterProjects(btn.dataset.filter);
            });
        });

        // Load more button
        document.getElementById('loadMoreBtn').addEventListener('click', () => {
            displayCount += 6;
            let filtered = allProjects;
            if (currentFilter !== 'all') {
                if (currentFilter === 'featured') {
                    filtered = allProjects.filter(p => p.featured == 1 || p.featured === true);
                } else {
                    filtered = allProjects.filter(p => (p.category || 'web-app') === currentFilter);
                }
            }
            renderProjects(filtered);
        });

        // GSAP Animations
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
                        toggleActions: 'play none none reverse'
                    }
                });
            });

            // Animate counters
            ScrollTrigger.create({
                trigger: '.stat-card',
                start: 'top 75%',
                onEnter: animateCounters,
                once: true
            });

            // Animate client logos
            gsap.from('.client-logo', {
                scale: 0,
                rotation: 180,
                stagger: 0.05,
                duration: 0.5,
                ease: 'back.out(1.7)',
                scrollTrigger: {
                    trigger: '.client-logo',
                    start: 'top 85%'
                }
            });
        }

        // Load projects on page load
        loadProjects();
    </script>
</body>
</html>
