<?php
// DEVELOPMENT MODE - Relaxed CSP for testing
header("Content-Security-Policy: default-src *; script-src * 'unsafe-inline' 'unsafe-eval'; style-src * 'unsafe-inline'; font-src * data:; img-src * data: blob: https: http:; connect-src *;");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- DEVELOPMENT CSP - Allow all external resources -->
    <meta http-equiv="Content-Security-Policy" content="default-src * 'unsafe-inline' 'unsafe-eval'; script-src * 'unsafe-inline' 'unsafe-eval'; style-src * 'unsafe-inline'; font-src * data:; img-src * data: blob: https: http:; connect-src *;">

    <meta name="description" content="Devycore Blog - Insights on web development, design, and technology.">
    <title>Blog - Devycore</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="/devycore-v2/public/assets/css/base.css">
    <link rel="stylesheet" href="/devycore-v2/public/assets/css/layout.css">
    <link rel="stylesheet" href="/devycore-v2/public/assets/css/components.css">
    <link rel="stylesheet" href="/devycore-v2/public/assets/css/brutalist.css">

    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.4/gsap.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.4/ScrollTrigger.min.js" defer></script>

    <style>
        .article-card {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .article-image {
            width: 100%;
            aspect-ratio: 16/9;
            object-fit: cover;
            margin-bottom: 1rem;
        }

        .article-meta {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }

        .article-category {
            padding: 0.25rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .category-tutorial { background: var(--accent-primary); color: var(--bg-primary); }
        .category-case-study { background: var(--accent-hot); color: var(--bg-primary); }
        .category-opinion { background: var(--bg-secondary); color: var(--text-primary); border: 1px solid var(--accent-primary); }
        .category-guide { background: var(--accent-primary); color: var(--bg-primary); }
        .category-technical { background: var(--accent-hot); color: var(--bg-primary); }
        .category-culture { background: var(--bg-secondary); color: var(--text-primary); border: 1px solid var(--accent-hot); }

        .article-read-time {
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        .article-title {
            font-size: 1.125rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            line-height: 1.3;
        }

        .article-excerpt {
            font-size: 0.85rem;
            color: var(--text-secondary);
            line-height: 1.5;
            margin-bottom: 1rem;
            flex-grow: 1;
        }

        .article-date {
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin-bottom: 1rem;
        }

        .read-more {
            color: var(--accent-primary);
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .read-more:hover {
            color: var(--accent-hot);
        }

        .featured-article {
            grid-column: 1 / -1;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .featured-article .article-image {
            aspect-ratio: 4/3;
        }

        @media (max-width: 768px) {
            .featured-article {
                grid-template-columns: 1fr;
            }
        }

        .newsletter-section {
            background: var(--bg-secondary);
            border: 3px solid var(--accent-primary);
            padding: 3rem;
            margin-top: 4rem;
        }

        .newsletter-form {
            display: flex;
            gap: 1rem;
            max-width: 500px;
            margin: 0 auto;
        }

        .newsletter-input {
            flex: 1;
            padding: 1rem 1.5rem;
            background: var(--bg-primary);
            border: 2px solid var(--border);
            color: var(--text-primary);
            font-size: 1rem;
        }

        .newsletter-input:focus {
            outline: none;
            border-color: var(--accent-primary);
        }

        @media (max-width: 640px) {
            .newsletter-form {
                flex-direction: column;
            }
        }

        /* Blog Stats */
        .blog-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin: 3rem 0;
        }

        .stat-box {
            background: var(--bg-secondary);
            border: 2px solid var(--accent-primary);
            padding: 2rem;
            text-align: center;
            transition: var(--transition-base);
        }

        .stat-box:hover {
            transform: translate(-4px, -4px);
            box-shadow: 4px 4px 0 var(--accent-primary);
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            color: var(--accent-primary);
            font-family: 'Space Grotesk', sans-serif;
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin-top: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Category Filter */
        .category-filter {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 3rem;
            justify-content: center;
        }

        .filter-btn {
            padding: 0.75rem 1.5rem;
            background: var(--bg-secondary);
            border: 2px solid var(--border-color);
            color: var(--text-primary);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
        }

        .filter-btn:hover {
            border-color: var(--accent-primary);
            background: var(--bg-primary);
            color: var(--accent-primary);
            transform: translateY(-2px);
            box-shadow: 0 3px 0 var(--accent-primary);
        }

        .filter-btn.active {
            border-color: var(--accent-primary);
            background: var(--accent-primary);
            color: var(--bg-primary);
            transform: translateY(-2px);
            box-shadow: 0 3px 0 var(--accent-hot);
        }

        /* Floating Code Snippets */
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

        /* Author Box */
        .author-box {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 2px solid var(--border);
        }

        .author-avatar {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--accent-primary), var(--accent-hot));
            border: 2px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .author-name {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.9rem;
        }

        .author-role {
            font-size: 0.75rem;
            color: var(--text-secondary);
        }

        /* Tags */
        .article-tags {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-top: 1rem;
        }

        .tag {
            padding: 0.25rem 0.75rem;
            background: var(--bg-primary);
            border: 1px solid var(--border);
            color: var(--text-secondary);
            font-size: 0.7rem;
            text-transform: uppercase;
            font-family: 'Fira Code', monospace;
        }

        .tag:hover {
            border-color: var(--accent-primary);
            color: var(--accent-primary);
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

    <!-- Header -->
    <header class="site-header">
        <div class="header-inner container">
            <a href="index.php" class="site-logo" style="display: flex; align-items: center;">
                <img src="/devycore-v2/public/assets/images/logo.svg" alt="Devycore Logo" style="height: 55px; width: auto; max-width: 200px;">
            </a>

            <nav class="main-nav" id="mainNav">
                <a href="index.php#services" class="nav-link">Services</a>
                <a href="portfolio.php" class="nav-link">Portfolio</a>
                <a href="about.php" class="nav-link">About</a>
                <a href="blog.php" class="nav-link active">Blog</a>
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
                <span class="badge badge-accent">INSIGHTS</span>
                <span class="badge badge-accent">TUTORIALS</span>
                <span class="badge badge-accent">CASE STUDIES</span>
            </div>

            <h1 class="glitch" data-text="BLOG" style="font-size: clamp(48px, 10vw, 96px);">
                BLOG
            </h1>

            <p style="max-width: 60ch; margin: 2rem 0; font-size: 1.25rem; color: var(--text-secondary);">
                Thoughts on web development, design systems, performance optimization, and building great products.
            </p>
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

    <!-- Blog Stats -->
    <section class="section" style="padding: 40px 0;">
        <div class="container">
            <div class="blog-stats">
                <div class="stat-box">
                    <div class="stat-number counter" data-target="40">0</div>
                    <div class="stat-label">Articles Published</div>
                </div>
                <div class="stat-box">
                    <div class="stat-number counter" data-target="15">0</div>
                    <div class="stat-label">Topics Covered</div>
                </div>
                <div class="stat-box">
                    <div class="stat-number counter" data-target="8">0</div>
                    <div class="stat-label">Tutorial Series</div>
                </div>
                <div class="stat-box">
                    <div class="stat-number counter" data-target="500">0</div>
                    <div class="stat-label">Weekly Readers</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Category Filter -->
    <section class="section" style="padding: 40px 0;">
        <div class="container">
            <h2 style="text-align: center; font-size: 1.5rem; margin-bottom: 2rem; color: var(--accent-primary);">
                FILTER BY CATEGORY
            </h2>
            <div class="category-filter">
                <button class="filter-btn active" data-category="all">All Articles</button>
                <button class="filter-btn" data-category="tutorial">Tutorials</button>
                <button class="filter-btn" data-category="case-study">Case Studies</button>
                <button class="filter-btn" data-category="guide">Guides</button>
                <button class="filter-btn" data-category="technical">Technical</button>
                <button class="filter-btn" data-category="opinion">Opinion</button>
                <button class="filter-btn" data-category="culture">Culture</button>
            </div>
        </div>
    </section>

    <!-- Articles Grid -->
    <section class="section" style="padding: 40px 0 80px;">
        <div class="container">
            <div class="grid-3">
                <!-- Featured Article -->
                <div class="featured-article card article-card" style="padding: 0; overflow: hidden;">
                    <img src="/devycore-v2/public/assets/images/blog/php.svg" alt="PHP" class="article-image" style="width: 100%; height: 250px; object-fit: contain; background: linear-gradient(135deg, #0a0a0a, #1a4d2e); padding: 2rem;">
                    <div style="padding: 2rem;">
                        <div class="article-meta">
                            <span class="article-category category-tutorial">TUTORIAL</span>
                            <span class="article-read-time">12 min read</span>
                        </div>
                        <h2 class="article-title" style="font-size: 2rem;">Building High-Performance APIs with PHP 8.2</h2>
                        <p class="article-date">January 8, 2026</p>
                        <p class="article-excerpt" style="font-size: 1.125rem;">
                            Learn how to build blazing-fast REST APIs using PHP 8.2's latest features, including JIT compilation,
                            union types, and named arguments. We'll cover architecture, caching strategies, and real-world benchmarks.
                        </p>
                        <div class="article-tags">
                            <span class="tag">PHP 8.2</span>
                            <span class="tag">Performance</span>
                            <span class="tag">REST API</span>
                            <span class="tag">Backend</span>
                        </div>
                        <div class="author-box">
                            <div class="author-avatar">▲</div>
                            <div>
                                <div class="author-name">Tech Team</div>
                                <div class="author-role">Senior Backend Developer</div>
                            </div>
                        </div>
                        <a href="https://www.php.net/manual/en/migration82.php" target="_blank" rel="noopener" class="read-more" style="margin-top: 1rem; display: inline-flex;">Read Full Article →</a>
                    </div>
                </div>

                <!-- Regular Articles -->
                <div class="card article-card">
                    <img src="/devycore-v2/public/assets/images/blog/gsap.svg" alt="GSAP" class="article-image" style="width: 100%; height: 200px; object-fit: contain; background: linear-gradient(135deg, #0a0a0a, #2d1a4d); padding: 2rem;">
                    <div style="padding: 1rem; display: flex; flex-direction: column; flex-grow: 1;">
                        <div class="article-meta">
                            <span class="article-category category-guide">GUIDE</span>
                            <span class="article-read-time">8 min read</span>
                        </div>
                        <h3 class="article-title">GSAP 3 Animation Patterns for Web Apps</h3>
                        <p class="article-date">January 5, 2026</p>
                        <p class="article-excerpt">
                            Essential GSAP 3 patterns for creating smooth, performant animations in modern web applications.
                        </p>
                        <div class="article-tags">
                            <span class="tag">GSAP</span>
                            <span class="tag">Animation</span>
                            <span class="tag">JavaScript</span>
                        </div>
                        <a href="https://greensock.com/docs/" target="_blank" rel="noopener" class="read-more">Read More →</a>
                    </div>
                </div>

                <div class="card article-card">
                    <img src="/devycore-v2/public/assets/images/blog/kubernetes.svg" alt="Scaling" class="article-image" style="width: 100%; height: 200px; object-fit: contain; background: linear-gradient(135deg, #0a0a0a, #1a2a4d); padding: 2rem;">
                    <div style="padding: 1rem; display: flex; flex-direction: column; flex-grow: 1;">
                        <div class="article-meta">
                            <span class="article-category category-case-study">CASE STUDY</span>
                            <span class="article-read-time">15 min read</span>
                        </div>
                        <h3 class="article-title">Scaling Web Applications: Real World Example</h3>
                        <p class="article-date">January 3, 2026</p>
                        <p class="article-excerpt">
                            How we helped a startup scale their web application efficiently with modern architecture patterns.
                        </p>
                        <div class="article-tags">
                            <span class="tag">Scaling</span>
                            <span class="tag">Architecture</span>
                            <span class="tag">DevOps</span>
                        </div>
                        <a href="https://web.dev/articles/performance-get-started" target="_blank" rel="noopener" class="read-more">Read More →</a>
                    </div>
                </div>

                <div class="card article-card">
                    <img src="/devycore-v2/public/assets/images/blog/design.svg" alt="Design" class="article-image" style="width: 100%; height: 200px; object-fit: contain; background: linear-gradient(135deg, #1a1a1a, #4d1a1a); padding: 2rem;">
                    <div style="padding: 1rem; display: flex; flex-direction: column; flex-grow: 1;">
                        <div class="article-meta">
                            <span class="article-category category-opinion">OPINION</span>
                            <span class="article-read-time">6 min read</span>
                        </div>
                        <h3 class="article-title">Why Brutalism Is Back in Web Design</h3>
                        <p class="article-date">December 30, 2025</p>
                        <p class="article-excerpt">
                            Exploring the resurgence of brutalist design principles in modern web interfaces.
                        </p>
                        <div class="article-tags">
                            <span class="tag">Design</span>
                            <span class="tag">Brutalism</span>
                            <span class="tag">UI/UX</span>
                        </div>
                        <a href="https://www.smashingmagazine.com/articles/" target="_blank" rel="noopener" class="read-more">Read More →</a>
                    </div>
                </div>

                <div class="card article-card">
                    <img src="/devycore-v2/public/assets/images/blog/security.svg" alt="Security" class="article-image" style="width: 100%; height: 200px; object-fit: contain; background: linear-gradient(135deg, #0a0a0a, #2d1a1a); padding: 2rem;">
                    <div style="padding: 1rem; display: flex; flex-direction: column; flex-grow: 1;">
                        <div class="article-meta">
                            <span class="article-category category-technical">TECHNICAL</span>
                            <span class="article-read-time">10 min read</span>
                        </div>
                        <h3 class="article-title">Security Best Practices for Modern Web Apps (2026)</h3>
                        <p class="article-date">December 28, 2025</p>
                        <p class="article-excerpt">
                            A comprehensive guide to securing web applications against common vulnerabilities.
                        </p>
                        <div class="article-tags">
                            <span class="tag">Security</span>
                            <span class="tag">Best Practices</span>
                            <span class="tag">OWASP</span>
                        </div>
                        <a href="https://owasp.org/www-project-top-ten/" target="_blank" rel="noopener" class="read-more">Read More →</a>
                    </div>
                </div>

                <div class="card article-card">
                    <img src="/devycore-v2/public/assets/images/blog/nodejs.svg" alt="WebSocket" class="article-image" style="width: 100%; height: 200px; object-fit: contain; background: linear-gradient(135deg, #0a0a0a, #1a3d4d); padding: 2rem;">
                    <div style="padding: 1rem; display: flex; flex-direction: column; flex-grow: 1;">
                        <div class="article-meta">
                            <span class="article-category category-tutorial">TUTORIAL</span>
                            <span class="article-read-time">9 min read</span>
                        </div>
                        <h3 class="article-title">WebSocket vs Server-Sent Events: When to Use What</h3>
                        <p class="article-date">December 25, 2025</p>
                        <p class="article-excerpt">
                            Comparing real-time communication protocols with practical examples and benchmarks.
                        </p>
                        <div class="article-tags">
                            <span class="tag">WebSocket</span>
                            <span class="tag">Real-time</span>
                            <span class="tag">Node.js</span>
                        </div>
                        <a href="https://developer.mozilla.org/en-US/docs/Web/API/WebSockets_API" target="_blank" rel="noopener" class="read-more">Read More →</a>
                    </div>
                </div>

                <div class="card article-card">
                    <img src="/devycore-v2/public/assets/images/blog/github.svg" alt="Remote Culture" class="article-image" style="width: 100%; height: 200px; object-fit: contain; background: linear-gradient(135deg, #1a1a1a, #3d2a1a); padding: 2rem; ">
                    <div style="padding: 1rem; display: flex; flex-direction: column; flex-grow: 1;">
                        <div class="article-meta">
                            <span class="article-category category-culture">CULTURE</span>
                            <span class="article-read-time">7 min read</span>
                        </div>
                        <h3 class="article-title">Building a Remote-First Engineering Culture</h3>
                        <p class="article-date">December 22, 2025</p>
                        <p class="article-excerpt">
                            Lessons learned from building and managing a fully distributed engineering team.
                        </p>
                        <div class="article-tags">
                            <span class="tag">Remote Work</span>
                            <span class="tag">Team Culture</span>
                            <span class="tag">Management</span>
                        </div>
                        <a href="https://github.blog/category/engineering/" target="_blank" rel="noopener" class="read-more">Read More →</a>
                    </div>
                </div>

                <!-- Additional Articles -->
                <div class="card article-card">
                    <img src="/devycore-v2/public/assets/images/blog/react.svg" alt="React" class="article-image" style="width: 100%; height: 200px; object-fit: contain; background: linear-gradient(135deg, #0a0a0a, #1a2d4d); padding: 2rem;">
                    <div style="padding: 1rem; display: flex; flex-direction: column; flex-grow: 1;">
                        <div class="article-meta">
                            <span class="article-category category-tutorial">TUTORIAL</span>
                            <span class="article-read-time">11 min read</span>
                        </div>
                        <h3 class="article-title">Advanced React Hooks Patterns</h3>
                        <p class="article-date">December 20, 2025</p>
                        <p class="article-excerpt">
                            Master advanced React Hooks patterns for building scalable and maintainable applications.
                        </p>
                        <div class="article-tags">
                            <span class="tag">React</span>
                            <span class="tag">Hooks</span>
                            <span class="tag">Frontend</span>
                        </div>
                        <a href="https://greensock.com/docs/" target="_blank" rel="noopener" class="read-more">Read More →</a>
                    </div>
                </div>

                <div class="card article-card">
                    <img src="/devycore-v2/public/assets/images/blog/postgresql.svg" alt="Database" class="article-image" style="width: 100%; height: 200px; object-fit: contain; background: linear-gradient(135deg, #0a0a0a, #2a1a4d); padding: 2rem;">
                    <div style="padding: 1rem; display: flex; flex-direction: column; flex-grow: 1;">
                        <div class="article-meta">
                            <span class="article-category category-guide">GUIDE</span>
                            <span class="article-read-time">13 min read</span>
                        </div>
                        <h3 class="article-title">Database Query Optimization Techniques</h3>
                        <p class="article-date">December 18, 2025</p>
                        <p class="article-excerpt">
                            Practical techniques for optimizing database queries and improving application performance.
                        </p>
                        <div class="article-tags">
                            <span class="tag">Database</span>
                            <span class="tag">MySQL</span>
                            <span class="tag">Performance</span>
                        </div>
                        <a href="https://greensock.com/docs/" target="_blank" rel="noopener" class="read-more">Read More →</a>
                    </div>
                </div>

                <div class="card article-card">
                    <img src="/devycore-v2/public/assets/images/blog/docker.svg" alt="CI/CD" class="article-image" style="width: 100%; height: 200px; object-fit: contain; background: linear-gradient(135deg, #0a0a0a, #1a4d3d); padding: 2rem;">
                    <div style="padding: 1rem; display: flex; flex-direction: column; flex-grow: 1;">
                        <div class="article-meta">
                            <span class="article-category category-technical">TECHNICAL</span>
                            <span class="article-read-time">14 min read</span>
                        </div>
                        <h3 class="article-title">Setting Up Modern CI/CD Pipelines</h3>
                        <p class="article-date">December 15, 2025</p>
                        <p class="article-excerpt">
                            Complete guide to setting up continuous integration and deployment for modern web applications.
                        </p>
                        <div class="article-tags">
                            <span class="tag">CI/CD</span>
                            <span class="tag">DevOps</span>
                            <span class="tag">Automation</span>
                        </div>
                        <a href="https://greensock.com/docs/" target="_blank" rel="noopener" class="read-more">Read More →</a>
                    </div>
                </div>
            </div>

            <!-- Load More Button -->
            <div style="text-align: center; margin-top: 3rem;">
                <button class="btn btn-secondary btn-large">LOAD MORE ARTICLES</button>
            </div>

            <!-- Newsletter Signup -->
            <div class="newsletter-section">
                <h2 style="text-align: center; font-size: 2rem; margin-bottom: 1rem;">GET UPDATES</h2>
                <p style="text-align: center; color: var(--text-secondary); margin-bottom: 2rem;">
                    Subscribe to our newsletter for weekly insights on web development and design.
                </p>
                <form class="newsletter-form" onsubmit="return false;">
                    <input type="email" class="newsletter-input" placeholder="Enter your email" required>
                    <button type="submit" class="btn btn-primary">SUBSCRIBE</button>
                </form>
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
        // Counter Animation
        function animateCounters() {
            const counters = document.querySelectorAll('.counter');
            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-target'));
                const duration = 2000;
                const increment = target / (duration / 16);
                let current = 0;

                const updateCounter = () => {
                    current += increment;
                    if (current < target) {
                        counter.textContent = Math.floor(current);
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.textContent = target;
                    }
                };

                updateCounter();
            });
        }

        // Trigger counter animation when stats section is visible
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounters();
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        const statsSection = document.querySelector('.blog-stats');
        if (statsSection) {
            observer.observe(statsSection);
        }

        // Category Filter
        const filterBtns = document.querySelectorAll('.filter-btn');
        const articles = document.querySelectorAll('.article-card');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const category = btn.getAttribute('data-category');

                // Update active state
                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                // Filter articles
                articles.forEach(article => {
                    const articleCategory = article.querySelector('.article-category');
                    if (!articleCategory) return;

                    const articleCategoryText = articleCategory.textContent.toLowerCase().replace(/\s+/g, '-');

                    if (category === 'all' || articleCategoryText === category) {
                        article.style.display = '';
                        article.style.opacity = '1';
                        article.style.transform = 'none';
                    } else {
                        article.style.display = 'none';
                    }
                });
            });
        });

        // Simple GSAP animations
        if (typeof gsap !== 'undefined') {
            gsap.registerPlugin(ScrollTrigger);

            gsap.from('.article-card', {
                opacity: 0,
                y: 40,
                stagger: 0.1,
                duration: 0.6,
                ease: 'power2.out',
                scrollTrigger: {
                    trigger: '.grid-3',
                    start: 'top 80%'
                }
            });

            gsap.from('.stat-box', {
                opacity: 0,
                y: 30,
                stagger: 0.15,
                duration: 0.5,
                ease: 'power2.out',
                scrollTrigger: {
                    trigger: '.blog-stats',
                    start: 'top 80%'
                }
            });

            gsap.from('.filter-btn', {
                opacity: 0,
                y: 20,
                stagger: 0.05,
                duration: 0.4,
                ease: 'power2.out',
                scrollTrigger: {
                    trigger: '.category-filter',
                    start: 'top 80%'
                }
            });
        }
    </script>
</body>
</html>
