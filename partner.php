<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $_SESSION['user_name'] ?? 'Account';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partner With Us | CraveExpress</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Design/design1.css">
    <link rel="stylesheet" href="Design/common.css">
    <style>
        .partner-hero {
            background: linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)), 
                        url('https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=1500') center/cover;
            color: white;
            padding: 80px 10%;
            text-align: center;
        }
        .partner-hero h1 {
            font-size: 3.2rem;
            margin: 10px 0 20px 0;
            line-height: 1.1;
        }
        .partner-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin: 50px 10% 0;
            text-align: center;
        }
        .stat-card {
            background: white;
            padding: 30px 20px;
            border-radius: 16px;
            border: 1px solid #eee;
            box-shadow: var(--shadow-soft);
        }
        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary-orange);
            display: block;
            margin-bottom: 5px;
        }
        .stat-desc {
            color: #666;
            font-size: 0.95rem;
        }
        .partner-form-section {
            padding: 60px 10%;
            max-width: 900px;
            margin: 0 auto;
        }
        .partner-tabs {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-bottom: 30px;
        }
        .p-tab-btn {
            padding: 14px 28px;
            border-radius: 30px;
            border: 2px solid #ddd;
            background: white;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        .p-tab-btn.active {
            border-color: var(--primary-orange);
            background: var(--primary-orange);
            color: white;
        }
        .partner-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            border: 1px solid #eee;
            box-shadow: var(--shadow-soft);
        }
        @media (max-width: 768px) {
            .partner-stats {
                grid-template-columns: 1fr;
            }
            .partner-hero h1 {
                font-size: 2.2rem;
            }
        }
    </style>
</head>
<body style="background-color: #fcfcfc;">

    <nav>
        <div class="logo"><a href="index.php" style="text-decoration: none; color: inherit;">CraveExpress</a></div>
        <div class="nav-links">
            <a href="index.php">Offers</a>
            <a href="restaurants.php">Restaurants</a>
            <a href="orders.php">Orders</a>
            <a href="help.php">Help</a>
            <a href="#" class="cart-icon" id="cart-icon-btn" title="View Cart">🛒 <span id="cart-count">0</span></a>
            <a href="profile_settings.php" class="profile-icon" title="<?php echo htmlspecialchars($userName); ?>">👤</a>
        </div>
    </nav>

    <!-- Partner Hero -->
    <header class="partner-hero">
        <span class="badge" style="background: rgba(255,255,255,0.2); color: white; padding: 6px 16px; border-radius: 20px; font-size: 0.85rem;">GROW WITH CRAVEEXPRESS</span>
        <h1>Scale Your Kitchen.<br>Reach Thousands of Hungry Diners.</h1>
        <p style="max-width: 650px; margin: 0 auto; font-size: 1.1rem; color: #ddd;">Join our premier food delivery network. We handle the routing, couriers, and marketing while you focus on cooking culinary masterpieces.</p>
    </header>

    <!-- Partner Key Stats -->
    <div class="partner-stats">
        <div class="stat-card">
            <span class="stat-number">+38%</span>
            <span class="stat-desc">Average monthly revenue increase for partner restaurants</span>
        </div>
        <div class="stat-card">
            <span class="stat-number">&lt; 20 min</span>
            <span class="stat-desc">Average courier pickup to dropoff delivery time</span>
        </div>
        <div class="stat-card">
            <span class="stat-number">50,000+</span>
            <span class="stat-desc">Active foodies craving high quality meals every day</span>
        </div>
    </div>

    <!-- Partner Application Tabs -->
    <section class="partner-form-section">
        <div class="partner-tabs">
            <button class="p-tab-btn active" id="btn-tab-res" onclick="switchPartnerRole('res')">🍽️ Restaurant Partner</button>
            <button class="p-tab-btn" id="btn-tab-courier" onclick="switchPartnerRole('courier')">🛵 Delivery Driver</button>
        </div>

        <!-- FORM 1: RESTAURANT APPLICATION -->
        <div id="panel-res" class="partner-card">
            <div style="text-align: center; margin-bottom: 30px;">
                <h2 style="font-size: 1.8rem; margin: 0 0 8px 0;">Restaurant Partnership Application</h2>
                <p style="color: #666; margin: 0;">Fill out your details below and our merchant onboarding manager will contact you within 24 hours.</p>
            </div>

            <form onsubmit="handlePartnerSubmit(event, 'Restaurant')">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div class="input-group">
                        <label style="display:block; font-weight:600; font-size:0.9rem; margin-bottom:6px;">Restaurant Name</label>
                        <input type="text" placeholder="e.g. Bella Roma Bistro" required style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px; box-sizing:border-box;">
                    </div>
                    <div class="input-group">
                        <label style="display:block; font-weight:600; font-size:0.9rem; margin-bottom:6px;">Owner / Contact Name</label>
                        <input type="text" placeholder="Johnathan Doe" required style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px; box-sizing:border-box;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div class="input-group">
                        <label style="display:block; font-weight:600; font-size:0.9rem; margin-bottom:6px;">Business Email</label>
                        <input type="email" placeholder="contact@restaurant.com" required style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px; box-sizing:border-box;">
                    </div>
                    <div class="input-group">
                        <label style="display:block; font-weight:600; font-size:0.9rem; margin-bottom:6px;">Phone Number</label>
                        <input type="tel" placeholder="+63 9XX XXX XXXX" required style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px; box-sizing:border-box;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div class="input-group">
                        <label style="display:block; font-weight:600; font-size:0.9rem; margin-bottom:6px;">Cuisine Type</label>
                        <select style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px; box-sizing:border-box; background:white;">
                            <option>Gourmet Burgers / American</option>
                            <option>Italian / Pizza / Pasta</option>
                            <option>Japanese / Sushi / Ramen</option>
                            <option>Healthy / Vegan / Bowls</option>
                            <option>Thai / Asian Fusion</option>
                            <option>Mexican / Tacos</option>
                            <option>Bakery / Desserts</option>
                            <option>Other Specialties</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label style="display:block; font-weight:600; font-size:0.9rem; margin-bottom:6px;">Number of Locations</label>
                        <input type="number" value="1" min="1" max="100" style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px; box-sizing:border-box;">
                    </div>
                </div>

                <div class="input-group" style="margin-bottom: 25px;">
                    <label style="display:block; font-weight:600; font-size:0.9rem; margin-bottom:6px;">Restaurant Address & City</label>
                    <input type="text" placeholder="e.g. 45 Greenbelt Drive, Makati City" required style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px; box-sizing:border-box;">
                </div>

                <button type="submit" style="width:100%; padding:16px; background:var(--primary-orange); color:white; border:none; border-radius:10px; font-weight:700; font-size:1.1rem; cursor:pointer;">Submit Merchant Application →</button>
            </form>
        </div>

        <!-- FORM 2: COURIER DRIVER ONBOARDING -->
        <div id="panel-courier" class="partner-card" style="display: none;">
            <div style="text-align: center; margin-bottom: 30px;">
                <h2 style="font-size: 1.8rem; margin: 0 0 8px 0;">Drive with CraveExpress</h2>
                <p style="color: #666; margin: 0;">Be your own boss. Earn competitive rates, instant payouts, and flexible work hours.</p>
            </div>

            <form onsubmit="handlePartnerSubmit(event, 'Courier Driver')">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div class="input-group">
                        <label style="display:block; font-weight:600; font-size:0.9rem; margin-bottom:6px;">Full Name</label>
                        <input type="text" placeholder="Johnathan Doe" required style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px; box-sizing:border-box;">
                    </div>
                    <div class="input-group">
                        <label style="display:block; font-weight:600; font-size:0.9rem; margin-bottom:6px;">Mobile Phone</label>
                        <input type="tel" placeholder="+63 9XX XXX XXXX" required style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px; box-sizing:border-box;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div class="input-group">
                        <label style="display:block; font-weight:600; font-size:0.9rem; margin-bottom:6px;">Vehicle Type</label>
                        <select style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px; box-sizing:border-box; background:white;">
                            <option>Motorcycle / Scooter</option>
                            <option>Electric Bicycle / Bicycle</option>
                            <option>Car / Sedan</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label style="display:block; font-weight:600; font-size:0.9rem; margin-bottom:6px;">Operating City</label>
                        <input type="text" placeholder="e.g. Makati / BGC / Manila" required style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px; box-sizing:border-box;">
                    </div>
                </div>

                <div class="input-group" style="margin-bottom: 25px;">
                    <label style="display:block; font-weight:600; font-size:0.9rem; margin-bottom:6px;">Driver's License Number</label>
                    <input type="text" placeholder="N01-XX-XXXXXX" required style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px; box-sizing:border-box;">
                </div>

                <button type="submit" style="width:100%; padding:16px; background:#27ae60; color:white; border:none; border-radius:10px; font-weight:700; font-size:1.1rem; cursor:pointer;">Start Driving & Earning →</button>
            </form>
        </div>
    </section>

    <!-- Complete Site Footer -->
    <footer class="crave-footer">
        <div class="footer-top">
            <div class="footer-col">
                <h4 style="color: var(--accent-red); font-weight: 800; font-size: 1.4rem;">CraveExpress</h4>
                <p>Satisfying your deepest cravings with fast, reliable, and delightful food delivery from the finest kitchens in the city.</p>
                <div class="footer-socials">
                    <a href="#" class="social-circle">📘</a>
                    <a href="#" class="social-circle">📸</a>
                    <a href="#" class="social-circle">🐦</a>
                    <a href="#" class="social-circle">▶️</a>
                </div>
            </div>
            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="index.php">Home / Offers</a></li>
                    <li><a href="restaurants.php">Explore Restaurants</a></li>
                    <li><a href="orders.php">Track Orders</a></li>
                    <li><a href="profile_settings.php">Account Settings</a></li>
                    <li><a href="help.php">Help Center</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>For Partners</h4>
                <ul>
                    <li><a href="partner.php">Become a Restaurant Partner</a></li>
                    <li><a href="partner.php#driver">Deliver with CraveExpress</a></li>
                    <li><a href="partner.php#enterprise">Corporate Catering</a></li>
                    <li><a href="login.html">Partner Login</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Stay in the Crave Loop</h4>
                <p>Receive exclusive vouchers, weekly chef specials, and flash sales.</p>
                <form class="footer-newsletter" onsubmit="event.preventDefault(); alert('Subscribed! Check your inbox for your 15% discount code.');">
                    <input type="email" placeholder="Enter your email" required>
                    <button type="submit">Subscribe</button>
                </form>
            </div>
        </div>
        <div class="footer-bottom">
            <div>© 2026 CraveExpress Inc. All rights reserved.</div>
            <div class="footer-bottom-links">
                <a href="help.php#privacy">Privacy Policy</a>
                <a href="help.php#terms">Terms of Service</a>
                <a href="help.php#cookies">Cookie Policy</a>
                <a href="help.php">Security</a>
            </div>
        </div>
    </footer>

    <!-- Universal Logic Scripts -->
    <script src="JavaScript/cart.js"></script>
    <script>
        function switchPartnerRole(role) {
            const btnRes = document.getElementById('btn-tab-res');
            const btnCourier = document.getElementById('btn-tab-courier');
            const panelRes = document.getElementById('panel-res');
            const panelCourier = document.getElementById('panel-courier');

            if (role === 'res') {
                btnRes.classList.add('active');
                btnCourier.classList.remove('active');
                panelRes.style.display = 'block';
                panelCourier.style.display = 'none';
            } else {
                btnRes.classList.remove('active');
                btnCourier.classList.add('active');
                panelRes.style.display = 'none';
                panelCourier.style.display = 'block';
            }
        }

        function handlePartnerSubmit(e, type) {
            e.preventDefault();
            alert(`🎉 Thank you! Your ${type} application has been received. Our partner team will reach out within 24 hours to finalize your onboarding.`);
            e.target.reset();
        }
    </script>
</body>
</html>
