<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Claim your exclusive discount on Devycore services">
    <meta name="robots" content="noindex, nofollow">
    <title>Claim Your Discount - Devycore</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="/devycore-v2/public/assets/css/base.css">
    <link rel="stylesheet" href="/devycore-v2/public/assets/css/layout.css">
    <link rel="stylesheet" href="/devycore-v2/public/assets/css/components.css">
    <link rel="stylesheet" href="/devycore-v2/public/assets/css/brutalist.css">

    <style>
        body {
            overflow-x: hidden;
        }

        .claim-hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
        }

        .claim-container {
            max-width: 800px;
            width: 100%;
            position: relative;
            z-index: 2;
        }

        .discount-card {
            background: var(--bg-secondary);
            border: 3px solid var(--accent-primary);
            padding: 3rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .discount-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(0, 212, 255, 0.1) 0%, transparent 70%);
            animation: pulse 4s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }

        .discount-badge {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: var(--accent-primary);
            color: var(--bg-primary);
            font-weight: 700;
            font-size: 0.875rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 2rem;
            position: relative;
            z-index: 1;
        }

        .discount-percentage {
            font-size: clamp(80px, 15vw, 160px);
            font-weight: 700;
            line-height: 1;
            background: linear-gradient(135deg, var(--accent-primary) 0%, var(--accent-hot) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
        }

        .discount-label {
            font-size: 2rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 2rem;
            position: relative;
            z-index: 1;
        }

        .discount-description {
            font-size: 1.125rem;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 3rem;
            position: relative;
            z-index: 1;
        }

        .claim-form {
            margin-top: 3rem;
            position: relative;
            z-index: 1;
        }

        .form-group {
            margin-bottom: 1.5rem;
            text-align: left;
        }

        .form-label {
            display: block;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
        }

        .form-input {
            width: 100%;
            padding: 1.25rem 1.5rem;
            background: var(--bg-primary);
            border: 2px solid var(--border);
            color: var(--text-primary);
            font-size: 1rem;
            font-family: inherit;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--accent-primary);
            box-shadow: 0 0 0 3px rgba(0, 212, 255, 0.1);
        }

        .form-input::placeholder {
            color: var(--text-tertiary);
        }

        .form-textarea {
            min-height: 120px;
            resize: vertical;
        }

        .form-select {
            width: 100%;
            padding: 1.25rem 1.5rem;
            background: var(--bg-primary);
            border: 2px solid var(--border);
            color: var(--text-primary);
            font-size: 1rem;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .form-select:focus {
            outline: none;
            border-color: var(--accent-primary);
        }

        .success-message {
            display: none;
            padding: 2rem;
            background: var(--accent-primary);
            color: var(--bg-primary);
            margin-bottom: 2rem;
            font-weight: 600;
            font-size: 1.125rem;
            border: 3px solid var(--accent-primary);
        }

        .success-message.show {
            display: block;
            animation: slideDown 0.5s ease;
        }

        @keyframes slideDown {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .error-message {
            display: none;
            padding: 1.5rem;
            background: var(--accent-hot);
            color: var(--text-primary);
            margin-bottom: 2rem;
            font-weight: 600;
            border: 3px solid var(--accent-hot);
        }

        .error-message.show {
            display: block;
            animation: slideDown 0.5s ease;
        }

        .discount-details {
            margin-top: 3rem;
            padding-top: 3rem;
            border-top: 2px solid var(--border);
            text-align: left;
            position: relative;
            z-index: 1;
        }

        .detail-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .detail-icon {
            width: 24px;
            height: 24px;
            background: var(--accent-primary);
            color: var(--bg-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .detail-text {
            color: var(--text-secondary);
            line-height: 1.6;
            font-size: 0.9rem;
        }

        .detail-text strong {
            color: var(--text-primary);
            font-weight: 600;
        }

        .confetti {
            position: fixed;
            width: 10px;
            height: 10px;
            background: var(--accent-primary);
            animation: confetti-fall 3s linear infinite;
            pointer-events: none;
            z-index: 9999;
        }

        @keyframes confetti-fall {
            0% {
                transform: translateY(-100vh) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(100vh) rotate(720deg);
                opacity: 0;
            }
        }

        .floating-shape {
            position: absolute;
            border: 2px solid var(--accent-primary);
            opacity: 0.1;
            pointer-events: none;
        }

        .shape-1 { width: 80px; height: 80px; top: 10%; left: 5%; animation: float 8s ease-in-out infinite; }
        .shape-2 { width: 60px; height: 60px; top: 70%; right: 10%; animation: float 6s ease-in-out infinite 1s; }
        .shape-3 { width: 100px; height: 100px; bottom: 15%; left: 15%; animation: float 7s ease-in-out infinite 2s; }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(180deg); }
        }

        @media (max-width: 768px) {
            .discount-card {
                padding: 2rem;
            }

            .discount-percentage {
                font-size: 64px;
            }

            .discount-label {
                font-size: 1.5rem;
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

    <!-- Floating Shapes -->
    <div class="floating-shape shape-1"></div>
    <div class="floating-shape shape-2"></div>
    <div class="floating-shape shape-3"></div>

    <!-- Claim Hero Section -->
    <section class="claim-hero">
        <div class="claim-container">
            <div class="discount-card">
                <div class="discount-badge">EXCLUSIVE OFFER</div>

                <div class="discount-percentage" id="discountPercentage">25%</div>
                <div class="discount-label">DISCOUNT UNLOCKED</div>

                <div id="discountCodeDisplay" style="display: none; margin: 1.5rem 0;">
                    <p style="font-size: 0.875rem; color: var(--text-secondary); margin-bottom: 0.5rem;">Your discount code:</p>
                    <div style="font-family: var(--font-mono); font-size: 1.25rem; color: var(--accent-primary); padding: 1rem; border: 2px solid var(--accent-primary); background: var(--bg-primary); letter-spacing: 2px;">
                        <span id="discountCodeText">DISC_20</span>
                    </div>
                </div>

                <p class="discount-description">
                    Congratulations! You've been selected for an exclusive discount on your next project with Devycore.
                    Fill out the form below to claim your discount and get started.
                </p>

                <div class="success-message" id="successMessage">
                    ✓ Your discount has been claimed successfully! We'll contact you shortly to discuss your project.
                </div>

                <div class="error-message" id="errorMessage">
                    Something went wrong. Please try again or contact us directly.
                </div>

                <form class="claim-form" id="claimForm">
                    <div class="form-group">
                        <label class="form-label" for="name">Full Name *</label>
                        <input type="text"
                               id="name"
                               name="name"
                               class="form-input"
                               placeholder="John Doe"
                               required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email">Email Address *</label>
                        <input type="email"
                               id="email"
                               name="email"
                               class="form-input"
                               placeholder="john@example.com"
                               required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="phone">Phone Number</label>
                        <input type="tel"
                               id="phone"
                               name="phone"
                               class="form-input"
                               placeholder="+1 234 567 890">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="company">Company Name</label>
                        <input type="text"
                               id="company"
                               name="company"
                               class="form-input"
                               placeholder="Your Company Ltd.">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="projectType">Project Type *</label>
                        <select id="projectType" name="project_type" class="form-select" required>
                            <option value="">Select Project Type</option>
                            <option value="web-app">Web Application</option>
                            <option value="ecommerce">E-Commerce Platform</option>
                            <option value="enterprise">Enterprise System</option>
                            <option value="mobile">Mobile App</option>
                            <option value="design">UI/UX Design</option>
                            <option value="consulting">Consulting Services</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="projectDescription">Project Description *</label>
                        <textarea id="projectDescription"
                                  name="project_description"
                                  class="form-input form-textarea"
                                  placeholder="Tell us about your project requirements..."
                                  required></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="budget">Estimated Budget</label>
                        <select id="budget" name="budget" class="form-select">
                            <option value="">Select Budget Range</option>
                            <option value="under-5k">Under $5,000</option>
                            <option value="5k-10k">$5,000 - $10,000</option>
                            <option value="10k-25k">$10,000 - $25,000</option>
                            <option value="25k-50k">$25,000 - $50,000</option>
                            <option value="50k-plus">$50,000+</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary btn-large" style="width: 100%; margin-top: 1rem;" id="submitBtn">
                        CLAIM MY DISCOUNT
                    </button>
                </form>

                <div class="discount-details">
                    <h3 style="font-size: 1.125rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1.5rem; text-align: center;">
                        OFFER DETAILS
                    </h3>

                    <div class="detail-item">
                        <div class="detail-icon">✓</div>
                        <div class="detail-text">
                            <strong>Valid for 30 days</strong> from the date you receive this offer
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-icon">✓</div>
                        <div class="detail-text">
                            <strong>Applicable to all services</strong> including web development, design, and consulting
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-icon">✓</div>
                        <div class="detail-text">
                            <strong>One-time use only</strong> per customer or company
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-icon">✓</div>
                        <div class="detail-text">
                            <strong>No minimum project value</strong> required to redeem this discount
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-icon">✓</div>
                        <div class="detail-text">
                            <strong>Priority support</strong> and dedicated project manager included
                        </div>
                    </div>
                </div>

                <p style="margin-top: 3rem; font-size: 0.75rem; color: var(--text-tertiary); text-align: center; position: relative; z-index: 1;">
                    By submitting this form, you agree to our
                    <a href="privacy.php" style="color: var(--accent-primary); text-decoration: underline;">Privacy Policy</a> and
                    <a href="terms.php" style="color: var(--accent-primary); text-decoration: underline;">Terms of Service</a>.
                </p>
            </div>

            <div style="text-align: center; margin-top: 2rem;">
                <a href="index.php" class="btn btn-secondary">BACK TO HOME</a>
            </div>
        </div>
    </section>

    <!-- Scripts -->
    <script>
        // Get discount percentage from URL parameter
        const urlParams = new URLSearchParams(window.location.search);
        const discount = urlParams.get('discount') || urlParams.get('prize') || '25';
        const code = urlParams.get('code') || '';

        // Update discount percentage display
        document.getElementById('discountPercentage').textContent = discount + '%';

        // Show discount code if available
        if (code) {
            document.getElementById('discountCodeDisplay').style.display = 'block';
            document.getElementById('discountCodeText').textContent = code;
        }

        // Create confetti effect
        function createConfetti() {
            const colors = ['var(--accent-primary)', 'var(--accent-hot)', '#ffffff'];
            const confettiCount = 30;

            for (let i = 0; i < confettiCount; i++) {
                const confetti = document.createElement('div');
                confetti.className = 'confetti';
                confetti.style.left = Math.random() * 100 + '%';
                confetti.style.animationDelay = Math.random() * 3 + 's';
                confetti.style.animationDuration = (2 + Math.random() * 2) + 's';
                confetti.style.background = colors[Math.floor(Math.random() * colors.length)];
                document.body.appendChild(confetti);

                // Remove confetti after animation
                setTimeout(() => confetti.remove(), 5000);
            }
        }

        // Trigger confetti on page load
        setTimeout(createConfetti, 500);

        // Handle form submission
        document.getElementById('claimForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);

            // Add discount info
            formData.append('prize', code || `DISC_${discount}`);
            formData.append('source', 'claim_page');

            const submitBtn = document.getElementById('submitBtn');
            const originalText = submitBtn.textContent;

            // Disable button and show loading state
            submitBtn.disabled = true;
            submitBtn.textContent = 'SUBMITTING...';

            try {
                const response = await fetch('/devycore-v2/public/api/discount.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    // Show success message
                    document.getElementById('successMessage').classList.add('show');
                    document.getElementById('errorMessage').classList.remove('show');

                    // Hide form
                    form.style.display = 'none';

                    // Trigger confetti celebration
                    createConfetti();

                    // Update button
                    submitBtn.textContent = 'CLAIMED ✓';
                    submitBtn.style.background = 'var(--accent-primary)';

                    // Redirect to contact or thank you page after 3 seconds
                    setTimeout(() => {
                        window.location.href = 'index.php#contact';
                    }, 3000);
                } else {
                    throw new Error(data.error || 'Submission failed');
                }
            } catch (error) {
                console.error('Form submission error:', error);

                // Show error message
                document.getElementById('errorMessage').classList.add('show');
                document.getElementById('errorMessage').textContent =
                    'Error: ' + (error.message || 'Failed to submit. Please try again or contact us directly.');
                document.getElementById('successMessage').classList.remove('show');

                // Re-enable button
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }
        });

        // Form validation
        const form = document.getElementById('claimForm');
        const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');

        inputs.forEach(input => {
            input.addEventListener('blur', () => {
                if (!input.value.trim()) {
                    input.style.borderColor = 'var(--accent-hot)';
                } else {
                    input.style.borderColor = 'var(--border)';
                }
            });

            input.addEventListener('input', () => {
                if (input.value.trim()) {
                    input.style.borderColor = 'var(--accent-primary)';
                }
            });
        });

        // Email validation
        const emailInput = document.getElementById('email');
        emailInput.addEventListener('blur', () => {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (emailInput.value && !emailRegex.test(emailInput.value)) {
                emailInput.style.borderColor = 'var(--accent-hot)';
            }
        });
    </script>
</body>
</html>
