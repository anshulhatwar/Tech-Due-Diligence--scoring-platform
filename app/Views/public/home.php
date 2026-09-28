<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Credence — Know Before You Trust</title>
  <meta name="description" content="Credence Tech Due-Diligence & Trust Score Platform — verify, assess and trust companies with data-driven insights.">

  <!-- Modern Font Stack -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">

  <!-- Design System & Styles -->
  <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">

  <style>
    .home-navbar {
  position: sticky; top: 0; z-index: 50;
  display: flex; align-items: center; justify-content: space-between;
  padding: 1rem 2.5rem;
  background: #fff;
  border-bottom: 1px solid var(--light-border);
}
    .home-navbar .brand-logo { height: 30px; }
    .home-nav-links { display: flex; align-items: center; gap: 2rem; }
    .home-nav-links a { color: var(--ink-soft); font-size: 0.9rem; font-weight: 500; }
    .home-nav-links a:hover, .home-nav-links a.active { color: var(--navy-900); }
    .home-nav-links a.active { border-bottom: 2px solid var(--primary); padding-bottom: 4px; }
    .home-cta-btn {
      background: var(--primary); color: #fff; font-weight: 600; font-size: 0.88rem;
      padding: 10px 20px; border-radius: var(--radius-sm); border: none;
    }
    .home-cta-btn:hover { background: var(--primary-dark); }

    .hero-section {
      background:
        linear-gradient(180deg, rgba(11,23,48,0.55), rgba(11,23,48,0.85)),
        url('<?= base_url("images/hero-bg.jpg") ?>');
      background-size: cover;
      background-position: center;
      padding: 4.5rem 2.5rem 5rem;
      color: #fff;
    }
    .hero-grid {
      display: grid; grid-template-columns: 1.15fr 0.85fr; gap: 3rem;
      max-width: 1180px; margin: 0 auto; align-items: center;
    }
    .hero-eyebrow { color: #7FD9C4; font-size: 0.78rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; margin-bottom: 0.9rem; }
    .hero-title { font-family: var(--font-display); font-size: 2.6rem; font-weight: 800; line-height: 1.15; color: #fff; margin-bottom: 1rem; }
    .hero-title span { color: #4FD1B3; }
    .hero-desc { color: rgba(255,255,255,0.75); font-size: 1rem; line-height: 1.6; margin-bottom: 1.75rem; max-width: 480px; }
    .hero-btn {
      display: inline-flex; align-items: center; gap: 8px;
      background: var(--primary); color: #fff; font-weight: 600; font-size: 0.95rem;
      padding: 13px 22px; border-radius: var(--radius-sm);
    }
    .hero-btn:hover { background: var(--primary-dark); }
    .hero-stats { display: flex; gap: 2.5rem; margin-top: 2.5rem; }
    .hero-stat-val { font-family: var(--font-display); font-size: 1.6rem; font-weight: 800; color: #fff; }
    .hero-stat-label { font-size: 0.78rem; color: rgba(255,255,255,0.6); }

    .trust-card {
      background: rgba(16,30,60,0.9);
      border: 1px solid rgba(255,255,255,0.12);
      border-radius: var(--radius-lg);
      padding: 1.5rem;
      backdrop-filter: blur(6px);
    }
    .trust-card-title { font-size: 0.78rem; font-weight: 700; letter-spacing: 0.04em; text-transform: uppercase; color: rgba(255,255,255,0.6); margin-bottom: 1rem; }
    .trust-score-ring {
      width: 140px; height: 140px; border-radius: 50%;
      background: conic-gradient(#4FD1B3 0deg 280deg, rgba(255,255,255,0.12) 280deg 360deg);
      display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;
    }
    .trust-score-inner {
      width: 110px; height: 110px; border-radius: 50%; background: var(--navy-900);
      display: flex; flex-direction: column; align-items: center; justify-content: center;
    }
    .trust-score-num { font-family: var(--font-display); font-size: 2.1rem; font-weight: 800; color: #fff; line-height: 1; }
    .trust-score-of { font-size: 0.72rem; color: rgba(255,255,255,0.55); }
    .trust-risk-pill {
      display: flex; align-items: center; justify-content: center; gap: 6px;
      background: rgba(79,209,179,0.15); color: #4FD1B3; font-weight: 600; font-size: 0.85rem;
      padding: 8px; border-radius: var(--radius-sm);
    }
    .trust-checklist { list-style: none; padding: 0; margin: 1.25rem 0 0; display: flex; flex-direction: column; gap: 8px; }
    .trust-checklist li { display: flex; align-items: center; gap: 8px; font-size: 0.85rem; color: rgba(255,255,255,0.8); }
    .trust-checklist li::before { content: "✓"; color: #4FD1B3; font-weight: 700; }

    .section { padding: 4rem 2.5rem; max-width: 1180px; margin: 0 auto; }
    .section-eyebrow { color: var(--primary); font-size: 0.78rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; margin-bottom: 0.6rem; }
    .section-title { font-size: 2rem; font-weight: 700; margin-bottom: 1rem; }
    .section-title span { color: var(--primary); }

    .about-grid { display: grid; grid-template-columns: 1fr 1.1fr 1fr; gap: 2.5rem; align-items: center; }
    .about-copy p { color: var(--ink-soft); font-size: 0.95rem; line-height: 1.65; margin-bottom: 1.5rem; }
    .about-img { border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-card); }
    .about-img img { width: 100%; display: block; }
    .about-features { display: flex; flex-direction: column; gap: 1.25rem; }
    .about-feature { display: flex; gap: 12px; align-items: flex-start; }
    .about-feature-icon {
      width: 40px; height: 40px; border-radius: 50%; background: var(--primary-light);
      display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 1.1rem;
    }
    .about-feature-title { font-weight: 700; font-size: 0.92rem; margin-bottom: 2px; }
    .about-feature-desc { font-size: 0.8rem; color: var(--ink-faint); }

    .services-section { background: var(--paper); }
    .services-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(190px, 1fr)); gap: 1.25rem; margin-top: 2rem; }
    .service-card {
      background: #fff; border: 1px solid var(--light-border); border-radius: var(--radius-md);
      padding: 1.5rem; text-align: left;
    }
    .service-icon { font-size: 1.6rem; margin-bottom: 0.8rem; }
    .service-title { font-weight: 700; font-size: 0.95rem; margin-bottom: 4px; }
    .service-desc { font-size: 0.82rem; color: var(--ink-faint); line-height: 1.5; }

    .register-band {
      background: var(--navy-900); color: #fff;
      display: grid; grid-template-columns: 1fr 1fr; gap: 2.5rem; align-items: center;
      padding: 3.5rem 2.5rem;
    }
    .register-mock {
      background: #0f1e3d; border-radius: var(--radius-lg); border: 1px solid rgba(255,255,255,0.1);
      padding: 1.75rem; max-width: 380px;
    }
    .register-mock-title { font-family: var(--font-display); font-weight: 700; font-size: 1.2rem; margin-bottom: 1rem; }
    .register-mock-bar { height: 8px; background: rgba(255,255,255,0.12); border-radius: 999px; margin-bottom: 10px; }
    .register-eyebrow { color: #7FD9C4; font-size: 0.78rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; margin-bottom: 0.6rem; }
    .register-title { font-family: var(--font-display); font-size: 1.8rem; font-weight: 800; margin-bottom: 0.75rem; }
    .register-desc { color: rgba(255,255,255,0.7); font-size: 0.92rem; margin-bottom: 1.25rem; max-width: 420px; }
    .register-list { list-style: none; padding: 0; margin: 0 0 1.5rem; display: flex; flex-direction: column; gap: 8px; }
    .register-list li { display: flex; align-items: center; gap: 8px; font-size: 0.88rem; color: rgba(255,255,255,0.85); }
    .register-list li::before { content: "✓"; color: #4FD1B3; font-weight: 700; }

    .contact-section { display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; padding: 3.5rem 2.5rem; max-width: 1180px; margin: 0 auto; }
    .contact-eyebrow { color: var(--primary); font-size: 0.78rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; margin-bottom: 0.6rem; }
    .contact-title { font-size: 1.7rem; font-weight: 700; margin-bottom: 1rem; }
    .contact-title span { color: var(--primary); }
    .contact-desc { color: var(--ink-soft); font-size: 0.9rem; margin-bottom: 1.5rem; }
    .contact-info-item { display: flex; align-items: center; gap: 10px; margin-bottom: 1rem; font-size: 0.9rem; color: var(--ink); }

    .home-footer {
      background: var(--navy-900); color: rgba(255,255,255,0.6);
      padding: 2.5rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;
    }
    .home-footer-brand { display: flex; align-items: center; gap: 10px; color: #fff; font-weight: 700; }
    .home-footer-links { display: flex; gap: 1.5rem; font-size: 0.85rem; }
    .home-footer-links a { color: rgba(255,255,255,0.6); }
    .home-footer-links a:hover { color: #fff; }

    @media (max-width: 900px) {
      .hero-grid, .about-grid, .register-band, .contact-section { grid-template-columns: 1fr; }
      .home-nav-links { display: none; }
    }
  </style>
</head>
<body>

  <!-- ============ NAVBAR ============ -->
  <header class="home-navbar">
    <a href="<?= base_url('/') ?>" class="brand-logo" style="display:flex; align-items:center; gap:10px;">
      <img src="<?= base_url('images/logo.png') ?>" alt="Credence" style="height:64px;">
    </a>
    <nav class="home-nav-links">
      <a href="#" class="active">Home</a>
      <a href="#about">About</a>
      <a href="#services">Services</a>
      <a href="<?= base_url('login') ?>">Register</a>
      <a href="#contact">Contact Us</a>
    </nav>
    <a href="<?= base_url('login') ?>" class="home-cta-btn">Get Started</a>
  </header>

  <!-- ============ HERO ============ -->
  <section class="hero-section">
    <div class="hero-grid">
      <div>
        <div class="hero-eyebrow">Tech Due-Diligence & Trust Score Platform</div>
        <h1 class="hero-title">Know Before <br>You <span>Trust.</span></h1>
        <p class="hero-desc">Credence helps you verify, assess and trust companies with data-driven insights, risk analysis and a transparent trust score.</p>
        <a href="<?= base_url('login') ?>" class="hero-btn">Verify a Company →</a>

        <div class="hero-stats">
          <div>
            <div class="hero-stat-val">100+</div>
            <div class="hero-stat-label">Companies Analyzed</div>
          </div>
          <div>
            <div class="hero-stat-val">95%</div>
            <div class="hero-stat-label">Risk Detection Accuracy</div>
          </div>
          <div>
            <div class="hero-stat-val">Trusted</div>
            <div class="hero-stat-label">By Investors & Businesses</div>
          </div>
        </div>
      </div>

      <div class="trust-card">
        <div class="trust-card-title">Credence Trust Score</div>
        <div class="trust-score-ring">
          <div class="trust-score-inner">
            <div class="trust-score-num">78</div>
            <div class="trust-score-of">/ 100</div>
          </div>
        </div>
        <div class="trust-risk-pill">🛡️ Low Risk</div>
        <ul class="trust-checklist">
          <li>Financial Health</li>
          <li>Technology Stack</li>
          <li>Legal Compliance</li>
          <li>Reputation Check</li>
        </ul>
      </div>
    </div>
  </section>

  <!-- ============ ABOUT ============ -->
  <section class="section" id="about">
    <div class="about-grid">
      <div class="about-copy">
        <div class="section-eyebrow">About Credence</div>
        <h2 class="section-title">Making Business <br><span>Trustworthy.</span></h2>
        <p>Credence is a tech-driven due-diligence platform that helps individuals, investors and businesses verify the credibility of companies. We combine technology, data analysis and risk intelligence to give you a clear Trust Score.</p>
        <a href="#services" class="hero-btn" style="background:var(--primary);">Learn More</a>
      </div>

      <div class="about-img">
        <img src="<?= base_url('images/logo.png') ?>" alt="Credence" style="width:100%; display:block;">
      </div>

      <div class="about-features">
        <div class="about-feature">
          <div class="about-feature-icon">📊</div>
          <div>
            <div class="about-feature-title">Data-Driven Insights</div>
            <div class="about-feature-desc">Real and verified information</div>
          </div>
        </div>
        <div class="about-feature">
          <div class="about-feature-icon">🎯</div>
          <div>
            <div class="about-feature-title">Unbiased Analysis</div>
            <div class="about-feature-desc">Objective and transparent</div>
          </div>
        </div>
        <div class="about-feature">
          <div class="about-feature-icon">🔒</div>
          <div>
            <div class="about-feature-title">Trusted Results</div>
            <div class="about-feature-desc">Make informed decisions</div>
          </div>
        </div>
        <div class="about-feature">
          <div class="about-feature-icon">🌐</div>
          <div>
            <div class="about-feature-title">Safer Business Ecosystem</div>
            <div class="about-feature-desc">For a better tomorrow</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============ SERVICES ============ -->
  <section class="section services-section" id="services">
    <div class="section-eyebrow">Our Services</div>
    <h2 class="section-title">Comprehensive Due-Diligence <span>Solutions</span></h2>

    <div class="services-grid">
      <div class="service-card">
        <div class="service-icon">🏢</div>
        <div class="service-title">Company Verification</div>
        <div class="service-desc">Verify legal, financial and operational details.</div>
      </div>
      <div class="service-card">
        <div class="service-icon">🛡️</div>
        <div class="service-title">Risk Analysis</div>
        <div class="service-desc">Identify potential risks before you invest or partner.</div>
      </div>
      <div class="service-card">
        <div class="service-icon">📈</div>
        <div class="service-title">Trust Score</div>
        <div class="service-desc">Get a reliable score based on multiple data points.</div>
      </div>
      <div class="service-card">
        <div class="service-icon">📄</div>
        <div class="service-title">Detailed Reports</div>
        <div class="service-desc">In-depth insights for better decision making.</div>
      </div>
      <div class="service-card">
        <div class="service-icon">🔗</div>
        <div class="service-title">Public Verification</div>
        <div class="service-desc">Share and verify via unique QR certificates.</div>
      </div>
    </div>
  </section>

  <!-- ============ REGISTER CTA ============ -->
  <section class="register-band">
    <div class="register-mock">
      <div class="register-mock-title">Start Verifying Today.</div>
      <div class="register-mock-bar" style="width:70%;"></div>
      <div class="register-mock-bar" style="width:45%;"></div>
      <div class="register-mock-bar" style="width:85%;"></div>
    </div>
    <div>
      <div class="register-eyebrow">Register</div>
      <h2 class="register-title">Create Your Account</h2>
      <p class="register-desc">Join Credence to access powerful due-diligence tools, company insights and trust scores.</p>
      <ul class="register-list">
        <li>Quick Registration</li>
        <li>Access to Reports</li>
        <li>Save & Track Companies</li>
        <li>Be Part of a Safer Ecosystem</li>
      </ul>
      <a href="<?= base_url('login') ?>" class="hero-btn">Sign Up Now</a>
    </div>
  </section>

  <!-- ============ CONTACT ============ -->
  <section class="contact-section" id="contact">
    <div>
      <div class="contact-eyebrow">Contact Us</div>
      <h2 class="contact-title">Let's Build a <br>More <span>Transparent</span> Future.</h2>
      <p class="contact-desc">Have questions or need support? We'd love to hear from you. Reach out to our team and we'll get back to you soon.</p>

      <div class="contact-info-item">✉️ support@credence.com</div>
      <div class="contact-info-item">📞 +91 98765 43210</div>
      <div class="contact-info-item">📍 Nagpur, India</div>
      <div class="contact-info-item">🕒 Mon - Sat, 9:00 AM - 6:00 PM</div>
    </div>

    <form class="auth-form">
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Your Name" required>
      </div>
      <div class="form-group">
        <input type="email" class="form-control" placeholder="Your Email" required>
      </div>
      <div class="form-group">
        <textarea class="form-control" placeholder="Your Message" required></textarea>
      </div>
      <button type="submit" class="auth-submit-btn">Send Message</button>
    </form>
  </section>

  <!-- ============ FOOTER ============ -->
  <footer class="home-footer">
    <div class="home-footer-brand">
      <img src="<?= base_url('images/logo.png') ?>" alt="Credence" style="height:26px; background:#fff; padding:3px 6px; border-radius:6px;">
      <span>Credence</span>
      <span style="font-weight:400; color:rgba(255,255,255,0.4); font-size:0.8rem; margin-left:8px;">Know · Verify · Trust</span>
    </div>
    <div class="home-footer-links">
      <a href="#">Home</a>
      <a href="#about">About</a>
      <a href="#services">Services</a>
      <a href="<?= base_url('login') ?>">Register</a>
      <a href="#contact">Contact Us</a>
    </div>
    <div style="font-size:0.8rem;">© 2026 Credence. All rights reserved.</div>
  </footer>

</body>
</html>