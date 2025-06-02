<!DOCTYPE html>
<html lang="en">
  <meta charset="UTF-8" />
  <title>Limelight Cinema | Terms and Conditions</title>
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta name="description" content="Terms and Conditions for Limelight Cinema" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet" />
  <style>
    :root {
      --primary-purple: #9ca1ed;
      --dark-bg: #0a0a0a;
      --card-bg: rgba(20, 20, 20, 0.8);
      --text-secondary: rgba(255, 255, 255, 0.7);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Open Sans', sans-serif;
      background: var(--dark-bg);
      color: #fff;
      line-height: 1.6;
      overflow-x: hidden;
    }

    .radial-gradient {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: radial-gradient(circle at 50% 20%, rgba(156, 161, 237, 0.15) 0%, transparent 50%);
      pointer-events: none;
      z-index: -1;
    }

    .content-body {
      position: relative;
      z-index: 1;
      min-height: 100vh;
      padding: 2rem 1rem;
      max-width: 1200px;
      margin: 0 auto;
    }

    .hero-card {
      margin-bottom: 4rem;
      text-align: center;
    }

    .card.hero {
      background: var(--card-bg);
      border-radius: 20px;
      padding: 3rem 2rem;
      backdrop-filter: blur(10px);
      border: 1px solid rgba(156, 161, 237, 0.2);
      position: relative;
      overflow: hidden;
    }

    .animate-spotlight {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(45deg, transparent, rgba(156, 161, 237, 0.3), transparent);
      opacity: 0;
    }

    .title {
      font-family: 'Montserrat', sans-serif;
      font-size: clamp(2rem, 5vw, 3.5rem);
      font-weight: 700;
      margin-bottom: 1rem;
      background: linear-gradient(135deg, #fff, var(--primary-purple));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .hero-paragraph {
      font-size: 1.2rem;
      color: var(--text-secondary);
      max-width: 600px;
      margin: 0 auto;
    }

    .terms-section {
      padding: 2.5rem;
      margin-bottom: 2rem;
      backdrop-filter: blur(10px);
    }

    .section-title {
      font-family: 'Montserrat', sans-serif;
      font-size: 1.8rem;
      font-weight: 600;
      color: var(--primary-purple);
      margin-bottom: 1.5rem;
      border-bottom: 2px solid rgba(156, 161, 237, 0.3);
      padding-bottom: 0.5rem;
    }

    .terms-content p {
      margin-bottom: 1rem;
      color: var(--text-secondary);
      font-size: 1rem;
    }

    .terms-content ul {
      margin: 1rem 0;
      padding-left: 1.5rem;
    }

    .terms-content li {
      margin-bottom: 0.5rem;
      color: var(--text-secondary);
    }

    .terms-content strong {
      color: #fff;
      font-weight: 600;
    }

    .highlight-box {
      background: rgba(156, 161, 237, 0.1);
      border: 1px solid rgba(156, 161, 237, 0.3);
      border-radius: 10px;
      padding: 1.5rem;
      margin: 1.5rem 0;
    }

    .last-updated {
      text-align: center;
      color: var(--text-secondary);
      font-style: italic;
      margin: 2rem 0;
      font-size: 0.9rem;
    }

    footer {
      background: rgba(10, 10, 10, 0.95);
      border-top: 1px solid rgba(156, 161, 237, 0.2);
      margin-top: 4rem;
    }

    @media (max-width: 768px) {
      .content-body {
        padding: 1rem;
      }
      
      .terms-section {
        padding: 1.5rem;
      }
      
      .card.hero {
        padding: 2rem 1rem;
      }
    }
  </style>
</head>

<body>
  <div class="radial-gradient"></div>
  <div class="content-body">
    <section class="hero-card">
      <div class="card hero">
        <svg class="animate-spotlight" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" fill="none"
          preserveAspectRatio="none"></svg>
        <h1 class="title">Terms & Conditions</h1>
        <p class="hero-paragraph">Please read these terms carefully before using our services and facilities.</p>
      </div>
    </section>

    <div class="last-updated">
      <p>Last updated: June 2, 2025</p>
    </div>

    <section class="terms-section">
      <h2 class="section-title">1. Acceptance of Terms</h2>
      <div class="terms-content">
        <p>By accessing and using Limelight Cinema's services, facilities, or website, you agree to be bound by these Terms and Conditions. If you do not agree to these terms, please do not use our services.</p>
        <div class="highlight-box">
          <p><strong>Important:</strong> These terms constitute a legally binding agreement between you and Limelight Cinema.</p>
        </div>
      </div>
    </section>

    <section class="terms-section">
      <h2 class="section-title">2. Ticket Purchases and Reservations</h2>
      <div class="terms-content">
        <p><strong>Booking Process:</strong></p>
        <ul>
          <li>All ticket purchases are subject to availability</li>
          <li>Tickets must be purchased in advance through our website or at the venue</li>
          <li>Payment must be completed at the time of booking</li>
          <li>Confirmation will be provided via email or SMS</li>
        </ul>
        <p><strong>Pricing:</strong></p>
        <ul>
          <li>All prices are displayed in GBP and include applicable taxes</li>
          <li>Special pricing may apply for students, seniors, and groups</li>
          <li>Prices are subject to change without notice</li>
        </ul>
      </div>
    </section>

    <section class="terms-section">
      <h2 class="section-title">3. Cancellation and Refund Policy</h2>
      <div class="terms-content">
        <p><strong>Customer Cancellations:</strong></p>
        <ul>
          <li>Tickets may be cancelled up to 2 hours before showtime for a full refund</li>
          <li>Cancellations within 2 hours of showtime are non-refundable</li>
          <li>Refunds will be processed within 5-7 business days</li>
        </ul>
        <p><strong>Cinema Cancellations:</strong></p>
        <ul>
          <li>If we cancel a screening, full refunds will be automatically processed</li>
          <li>Alternative showings may be offered when available</li>
          <li>We are not responsible for travel costs or other expenses</li>
        </ul>
        <div class="highlight-box">
          <p><strong>No-Show Policy:</strong> Tickets for missed screenings are non-refundable and non-transferable.</p>
        </div>
      </div>
    </section>

    <section class="terms-section">
      <h2 class="section-title">4. Cinema Rules and Conduct</h2>
      <div class="terms-content">
        <p><strong>Prohibited Activities:</strong></p>
        <ul>
          <li>Recording, photographing, or streaming any part of the screening</li>
          <li>Disruptive behavior including loud talking, use of mobile phones during screenings</li>
          <li>Bringing outside food or beverages (except for medical requirements)</li>
          <li>Smoking or vaping anywhere on the premises</li>
          <li>Consumption of alcohol by persons under 18</li>
        </ul>
        <p><strong>Age Restrictions:</strong></p>
        <ul>
          <li>Film age ratings will be strictly enforced</li>
          <li>Photo ID may be required for age verification</li>
          <li>Children under 12 must be accompanied by an adult for all screenings</li>
        </ul>
      </div>
    </section>

    <section class="terms-section">
      <h2 class="section-title">5. Liability and Safety</h2>
      <div class="terms-content">
        <p><strong>Limited Liability:</strong></p>
        <p>Limelight Cinema's liability is limited to the price of your ticket. We are not responsible for:</p>
        <ul>
          <li>Personal injury or property damage unless caused by our negligence</li>
          <li>Lost or stolen personal items</li>
          <li>Technical issues affecting screening quality</li>
          <li>Third-party actions or weather-related cancellations</li>
        </ul>
        <p><strong>Safety Requirements:</strong></p>
        <ul>
          <li>Customers must follow all safety instructions and emergency procedures</li>
          <li>Emergency exits must remain clear at all times</li>
          <li>Report any safety concerns to staff immediately</li>
        </ul>
      </div>
    </section>

    <section class="terms-section">
      <h2 class="section-title">6. Privacy and Data Protection</h2>
      <div class="terms-content">
        <p>Your privacy is important to us. Our collection and use of personal information is governed by our Privacy Policy, which forms part of these terms.</p>
        <p><strong>Data Collection:</strong></p>
        <ul>
          <li>We collect information necessary to process bookings and improve our services</li>
          <li>CCTV is in operation for security purposes</li>
          <li>Marketing communications are opt-in only</li>
        </ul>
        <div class="highlight-box">
          <p><strong>GDPR Compliance:</strong> You have the right to access, modify, or delete your personal data. Contact us for data requests.</p>
        </div>
      </div>
    </section>

    <section class="terms-section">
      <h2 class="section-title">7. Intellectual Property</h2>
      <div class="terms-content">
        <p>All content displayed at Limelight Cinema, including films, promotional materials, and our website content, is protected by copyright and other intellectual property laws.</p>
        <p><strong>Restrictions:</strong></p>
        <ul>
          <li>No reproduction or distribution of copyrighted content</li>
          <li>Our logo and branding materials are trademarked</li>
          <li>User-generated content may be used for promotional purposes</li>
        </ul>
      </div>
    </section>

    <section class="terms-section">
      <h2 class="section-title">8. Website Terms</h2>
      <div class="terms-content">
        <p><strong>Website Use:</strong></p>
        <ul>
          <li>Our website is provided "as is" without warranties</li>
          <li>We may update or modify the website without notice</li>
          <li>Users are responsible for maintaining account security</li>
          <li>Automated booking systems or bots are prohibited</li>
        </ul>
        <p><strong>Cookies:</strong> Our website uses cookies to enhance user experience and analyze usage patterns.</p>
      </div>
    </section>

    <section class="terms-section">
      <h2 class="section-title">9. Force Majeure</h2>
      <div class="terms-content">
        <p>Limelight Cinema is not liable for failure to perform due to circumstances beyond our reasonable control, including but not limited to:</p>
        <ul>
          <li>Natural disasters, severe weather conditions</li>
          <li>Government regulations or public health emergencies</li>
          <li>Power outages, technical failures, or equipment breakdown</li>
          <li>Labor disputes or supplier issues</li>
        </ul>
        <div class="highlight-box">
          <p><strong>COVID-19:</strong> Additional health and safety measures may be implemented as required by government guidelines.</p>
        </div>
      </div>
    </section>

    <section class="terms-section">
      <h2 class="section-title">10. Modifications and Termination</h2>
      <div class="terms-content">
        <p><strong>Changes to Terms:</strong></p>
        <p>We reserve the right to modify these terms at any time. Changes will be posted on our website and take effect immediately upon posting.</p>
        <p><strong>Account Termination:</strong></p>
        <p>We may suspend or terminate user accounts for violation of these terms or inappropriate behavior.</p>
      </div>
    </section>

    <section class="terms-section">
      <h2 class="section-title">11. Governing Law and Disputes</h2>
      <div class="terms-content">
        <p>These terms are governed by Scottish law and subject to the jurisdiction of Scottish courts.</p>
        <p><strong>Dispute Resolution:</strong></p>
        <ul>
          <li>We encourage resolution through direct communication</li>
          <li>Formal complaints should be submitted in writing</li>
          <li>Mediation may be required before legal proceedings</li>
        </ul>
      </div>
    </section>

    <section class="terms-section">
      <h2 class="section-title">12. Contact Information</h2>
      <div class="terms-content">
        <p>For questions about these Terms and Conditions, please contact us:</p>
        <div class="highlight-box">
          <p><strong>Limelight Cinema</strong><br>
          Email: legal@limelightcinema.co.uk<br>
          Phone: +44 (0) 131 XXX XXXX<br>
          Address: [Cinema Address], Scotland</p>
        </div>
        <p>Customer service hours: Monday-Sunday, 10:00 AM - 10:00 PM</p>
      </div>
    </section>
  </div>

  <footer>
    <div class="mx-auto max-w-screen-xl space-y-8 px-4 py-16 sm:px-6 lg:space-y-16 lg:px-8">
      <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
        <div>
          <p class="font-bold" style="color: #9ca1ed;">Links</p>
          <ul class="mt-6 space-y-4 text-sm">
            <li>
              <a href="/" class="text-white transition"
                  style="opacity: 0.5; transition: opacity 0.3s ease;"
                  onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.5'">
                  Home
              </a>
            </li>
            <li>
              <a href="/venues.php" class="text-white transition"
                  style="opacity: 0.5; transition: opacity 0.3s ease;"
                  onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.5'">
                  Venues
              </a>
            </li>
            <li>
              <a href="/contact.php" class="text-white transition"
                  style="opacity: 0.5; transition: opacity 0.3s ease;"
                  onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.5'">
                  Contact
              </a>
            </li>
            <li>
              <a href="/about.php" class="text-white transition"
                  style="opacity: 0.5; transition: opacity 0.3s ease;"
                  onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.5'">
                  About
              </a>
            </li>
          </ul>
        </div>

        <div>
          <p class="font-bold" style="color: #9ca1ed;">Account</p>
          <ul class="mt-6 space-y-4 text-sm">
            <li>
              <a href="/profile.php" class="text-white transition"
                  style="opacity: 0.5; transition: opacity 0.3s ease;"
                  onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.5'">
                  My Account
              </a>
            </li>
            <li>
              <a href="/bookings.php" class="text-white transition"
                  style="opacity: 0.5; transition: opacity 0.3s ease;"
                  onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.5'">
                  My Bookings
              </a>
            </li>
          </ul>
        </div>

        <div>
          <p class="font-bold" style="color: #9ca1ed;">Entertainment</p>
          <ul class="mt-6 space-y-4 text-sm">
            <li>
              <a href="/games.php" class="text-white transition"
                  style="opacity: 0.5; transition: opacity 0.3s ease;"
                  onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.5'">
                  Games
              </a>
            </li>
          </ul>
        </div>

        <div>
          <p class="font-bold" style="color: #9ca1ed;">Legal</p>
          <ul class="mt-6 space-y-4 text-sm">
            <li>
              <a href="/terms" class="text-white transition"
                  style="opacity: 0.5; transition: opacity 0.3s ease;"
                  onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.5'">
                  Terms and Conditions
              </a>
            </li>
            <li>
              <a href="/privacy" class="text-white transition"
                  style="opacity: 0.5; transition: opacity 0.3s ease;"
                  onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.5'">
                  Privacy Policy
              </a>
            </li>
          </ul>
        </div>
      </div>

      <p class="text-xs text-gray-500 dark:text-gray-400">
          &copy; 2025 Limelight Cinemas. All rights reserved.
      </p>
    </div>
  </footer>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
  <script>
    gsap.registerPlugin(ScrollTrigger);

    gsap.fromTo(".animate-spotlight",
      {
        width: "0%",
        opacity: 0,
      },
      {
        width: "100%",
        opacity: 0.6,
        filter: "blur(50px) grayscale(0)",
        duration: 5,
        ease: "power2.out",
        scrollTrigger: {
          trigger: ".hero-card",
          start: "top 80%",
          end: "bottom 20%",
          toggleActions: "play none none reverse",
          markers: false,
        },
      }
    );

    gsap.to(".card.hero", {
      opacity: 1,
      duration: 2,
      ease: "power2.out",
      scrollTrigger: {
        trigger: ".hero-card",
        start: "top 70%",
        toggleActions: "play none none none",
      },
    });

    // Smooth scrolling for any internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        }
      });
    });
  </script>
</body>
</html>