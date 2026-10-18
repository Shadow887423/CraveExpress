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
    <title>CraveExpress | Food Delivery</title>
    <!-- External Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Link to CSS -->
    <link rel="stylesheet" href="Design/design1.css">
    <link rel="stylesheet" href="Design/common.css">
</head>
<body>

    <nav>
        <div class="logo"><a href="index.php" style="text-decoration: none; color: inherit;">CraveExpress</a></div>
        <div class="nav-links">
            <a href="index.php" class="active">Offers</a>
            <a href="restaurants.php">Restaurants</a>
            <a href="orders.php">Orders</a>
            <a href="help.php">Help</a>
            <a href="#" class="cart-icon" id="cart-icon-btn" title="View Cart">🛒 <span id="cart-count">0</span></a>
            <a href="profile_settings.php" class="profile-icon" title="<?php echo htmlspecialchars($userName); ?>">👤</a>
        </div>
    </nav>

    <header class="hero">
        <div class="hero-content">
            <span class="badge">⚡ Lightning fast delivery in 20 mins</span>
            <h1>Crave the best. <br><span>Delivered</span> to your door.</h1>
            <p>Discover local culinary favorites, artisanal kitchens, and trending restaurants.</p>
            <div class="search-bar">
                <input type="text" id="address-input" placeholder="Enter your delivery address or craving">
                <button id="find-food-btn">Find Food →</button>
            </div>
        </div>
    </header>

    <!-- Categories Section -->
    <section class="section-container">
        <div class="section-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 style="font-size: 1.8rem; margin: 0;">Popular Categories</h2>
            <a href="restaurants.php" class="view-all" style="color: var(--primary-orange); text-decoration: none; font-weight: 600;">View All ›</a>
        </div>
        <div class="category-grid">
            <div class="category-card" data-category="Burgers">
                <img src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=300" alt="Burgers">
                <p>Burgers</p>
            </div>
            <div class="category-card" data-category="Pizza">
                <img src="https://images.unsplash.com/photo-1513104890138-7c749659a591?w=300" alt="Pizza">
                <p>Pizza</p>
            </div>
            <div class="category-card" data-category="Sushi">
                <img src="https://images.unsplash.com/photo-1579871494447-9811cf80d66c?w=300" alt="Sushi">
                <p>Sushi</p>
            </div>
            <div class="category-card" data-category="Vegan">
                <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=300" alt="Vegan">
                <p>Vegan & Healthy</p>
            </div>
            <div class="category-card" data-category="Desserts">
                <img src="https://images.unsplash.com/photo-1551024506-0bccd828d307?w=300" alt="Desserts">
                <p>Desserts</p>
            </div>
            <div class="category-card" data-category="Thai">
                <img src="https://images.unsplash.com/photo-1559339352-11d035aa65de?w=300" alt="Thai">
                <p>Thai & Asian</p>
            </div>
        </div>
    </section>

    <!-- Featured Spotlight Restaurants -->
    <section class="section-container" style="padding-top: 0;">
        <div class="section-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
            <div>
                <h2 style="font-size: 1.8rem; margin: 0 0 5px 0;">Trending Near You</h2>
                <p style="color: #666; margin: 0;">Top rated dining experiences delivered fresh</p>
            </div>
            <a href="restaurants.php" style="color: var(--primary-orange); text-decoration: none; font-weight: 600;">Explore All (8+) ›</a>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 25px;">
            <!-- Spot 1 -->
            <a href="urbangrillmenu.php" style="text-decoration: none; color: inherit;">
                <div style="border-radius: 16px; overflow: hidden; background: white; border: 1px solid #eee; box-shadow: var(--shadow-soft); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="height: 180px; position: relative;">
                        <img src="https://images.unsplash.com/photo-1550547660-d9450f859349?w=500" alt="The Urban Grill" style="width: 100%; height: 100%; object-fit: cover;">
                        <span style="position: absolute; top: 12px; left: 12px; background: white; padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: bold;">⭐ 4.8</span>
                        <span style="position: absolute; bottom: 12px; right: 12px; background: var(--primary-orange); color: white; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: bold;">Free Delivery</span>
                    </div>
                    <div style="padding: 16px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                            <h3 style="margin: 0; font-size: 1.15rem;">The Urban Grill</h3>
                            <span style="color: #666; font-weight: 600;">$$</span>
                        </div>
                        <p style="margin: 0 0 10px 0; color: #777; font-size: 0.85rem;">Gourmet Burgers • Truffle Fries • American</p>
                        <div style="display: flex; gap: 15px; color: #555; font-size: 0.8rem;">
                            <span>🕒 20-30 min</span>
                            <span>🚲 Free</span>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Spot 2 -->
            <a href="restaurants.php?search=sushi" style="text-decoration: none; color: inherit;">
                <div style="border-radius: 16px; overflow: hidden; background: white; border: 1px solid #eee; box-shadow: var(--shadow-soft); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="height: 180px; position: relative;">
                        <img src="https://images.unsplash.com/photo-1579871494447-9811cf80d66c?w=500" alt="Zen Sushi Bar" style="width: 100%; height: 100%; object-fit: cover;">
                        <span style="position: absolute; top: 12px; left: 12px; background: white; padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: bold;">⭐ 4.9</span>
                        <span style="position: absolute; bottom: 12px; right: 12px; background: #27ae60; color: white; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: bold;">Popular</span>
                    </div>
                    <div style="padding: 16px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                            <h3 style="margin: 0; font-size: 1.15rem;">Zen Sushi Bar</h3>
                            <span style="color: #666; font-weight: 600;">$$$</span>
                        </div>
                        <p style="margin: 0 0 10px 0; color: #777; font-size: 0.85rem;">Japanese • Salmon Sashimi • Tonkotsu Ramen</p>
                        <div style="display: flex; gap: 15px; color: #555; font-size: 0.8rem;">
                            <span>🕒 30-45 min</span>
                            <span>🚲 $3.99</span>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Spot 3 -->
            <a href="restaurants.php?category=Italian" style="text-decoration: none; color: inherit;">
                <div style="border-radius: 16px; overflow: hidden; background: white; border: 1px solid #eee; box-shadow: var(--shadow-soft); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="height: 180px; position: relative;">
                        <img src="https://images.unsplash.com/photo-1513104890138-7c749659a591?w=500" alt="Bella Italia" style="width: 100%; height: 100%; object-fit: cover;">
                        <span style="position: absolute; top: 12px; left: 12px; background: white; padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: bold;">⭐ 4.7</span>
                    </div>
                    <div style="padding: 16px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                            <h3 style="margin: 0; font-size: 1.15rem;">Bella Italia Trattoria</h3>
                            <span style="color: #666; font-weight: 600;">$$</span>
                        </div>
                        <p style="margin: 0 0 10px 0; color: #777; font-size: 0.85rem;">Woodfired Pizza • Creamy Carbonara • Italian</p>
                        <div style="display: flex; gap: 15px; color: #555; font-size: 0.8rem;">
                            <span>🕒 25-40 min</span>
                            <span>🚲 $2.49</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </section>

    <!-- Why CraveExpress Section -->
    <section class="why-section">
        <div class="section-title">
            <h2>Why CraveExpress?</h2>
            <p>We're not just a delivery service. We're your gateway to the city's best dining experiences, reimagined for your home.</p>
        </div>

        <div class="features-grid">
            <!-- Left Side: Tall White Box -->
            <div class="feature-card large-white">
                <div class="icon-circle orange-tint">🍕</div>
                <h3>Ultra-Fast Deliveries</h3>
                <p>Our proprietary routing technology ensures your food arrives hot, fresh, and within an average of 20 minutes from the chef's pan to your hands.</p>
                <div class="scooter-bg">🛵</div>
            </div>

            <!-- Right Side: Top Yellow Box -->
            <div class="feature-card yellow-box">
                <div class="box-content">
                    <h3>Curated Culinary Quality</h3>
                    <p>Only the highest-rated kitchens in your neighborhood make it onto our platform after rigorous taste tests.</p>
                </div>
                <span class="star-icon">⭐</span>
            </div>

            <!-- Right Side: Bottom Red Box -->
            <div class="feature-card red-box">
                <div class="icon-small" style="font-size: 1.5rem; margin-bottom: 10px;">📍</div>
                <h4>Real-Time Live Tracking</h4>
                <p>Follow every turn of your delivery courier on our live GPS map with minute-by-minute ETA updates.</p>
            </div>

            <!-- Right Side: Bottom Dark Box -->
            <div class="feature-card dark-box">
                <div class="icon-small" style="font-size: 1.5rem; margin-bottom: 10px;">🏷️</div>
                <h4>Crave Rewards Points</h4>
                <p>Earn reward points with every single order and unlock free sides, desserts, and exclusive discounts.</p>
            </div>
        </div>
    </section>

    <!-- Promo Banner -->
    <div class="promo-banner" id="offers">
        <div class="promo-text">
            <h2>Join the CraveExpress family today</h2>
            <p>Get $10 off your first three orders. Use code: <strong>CRAVEFIRST</strong> at checkout!</p>
            <div class="promo-actions">
                <a href="restaurants.php" class="btn-white">Order Food Now</a>
                <a href="partner.php" class="btn-outline">Partner With Us</a>
            </div>
        </div>
        <div class="promo-image">
            <img src="https://images.unsplash.com/photo-1526367790999-0150786686a2?w=600&auto=format&fit=crop&q=80" alt="Fast Food Delivery" style="width: 280px; height: 200px; object-fit: cover; border-radius: 16px;">
        </div>
    </div>

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
    <script src="JavaScript/control1.js"></script>
</body>
</html>