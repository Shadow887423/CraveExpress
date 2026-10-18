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
    <title>Explore Restaurants | CraveExpress</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Design/design1.css">
    <link rel="stylesheet" href="Design/design2.css">
    <link rel="stylesheet" href="Design/common.css">
</head>
<body>

    <nav>
        <div class="logo"><a href="index.php" style="text-decoration: none; color: inherit;">CraveExpress</a></div>
        <div class="nav-links">
            <a href="index.php">Offers</a>
            <a href="restaurants.php" class="active">Restaurants</a>
            <a href="orders.php">Orders</a>
            <a href="help.php">Help</a>
            <div class="nav-search">
                <input type="text" id="restaurant-search-input" placeholder="Search food, cuisines, or restaurants...">
            </div>
            <a href="#" class="cart-icon" id="cart-icon-btn" title="View Cart">🛒 <span id="cart-count">0</span></a>
            <a href="profile_settings.php" class="profile-icon" title="<?php echo htmlspecialchars($userName); ?>">👤</a>
        </div>
    </nav>

    <main class="restaurant-container">
        <!-- Sidebar Filters -->
        <aside class="filters-sidebar">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2 style="margin: 0; font-size: 1.3rem;">Filters</h2>
                <button onclick="location.href='restaurants.php'" style="background: none; border: none; color: var(--primary-orange); cursor: pointer; font-size: 0.85rem; font-weight: 600;">Clear All</button>
            </div>
            
            <div class="filter-group">
                <h4>CUISINE TYPE</h4>
                <label><input type="checkbox" data-cuisine="Burgers"> Burgers</label>
                <label><input type="checkbox" data-cuisine="Pizza"> Pizza</label>
                <label><input type="checkbox" data-cuisine="Italian"> Italian & Pasta</label>
                <label><input type="checkbox" data-cuisine="Asian Fusion"> Asian Fusion</label>
                <label><input type="checkbox" data-cuisine="Sushi"> Japanese & Sushi</label>
                <label><input type="checkbox" data-cuisine="Healthy"> Healthy & Bowls</label>
                <label><input type="checkbox" data-cuisine="American Classic"> American Classic</label>
                <label><input type="checkbox" data-cuisine="Thai"> Thai Specialties</label>
                <label><input type="checkbox" data-cuisine="Mexican"> Mexican & Tacos</label>
                <label><input type="checkbox" data-cuisine="Desserts"> Desserts & Bakery</label>
            </div>

            <div class="filter-group">
                <h4>PRICE RANGE</h4>
                <div class="price-options">
                    <button>$</button>
                    <button>$$</button>
                    <button>$$$</button>
                    <button>$$$$</button>
                </div>
            </div>

            <div class="promo-card-mini">
                <span style="font-size: 1.8rem; display: block; margin-bottom: 8px;">🎁</span>
                <strong style="color: #111; display: block; margin-bottom: 5px;">Exclusive Perk</strong>
                <p style="margin: 0 0 12px 0; font-size: 0.85rem; color: #555;">Free Delivery on orders above $25</p>
                <button class="claim-btn">Claim Offer</button>
            </div>
        </aside>

        <!-- Main Content -->
        <section class="restaurant-list">
            <div class="list-header">
                <div>
                    <h1 style="margin: 0 0 5px 0; font-size: 1.8rem;">Top Restaurants Near You</h1>
                    <span id="restaurant-count" style="color: #777; font-size: 0.9rem;">8 restaurants available</span>
                </div>
                <div class="view-toggle">
                    <button class="active">Grid</button>
                    <button>List</button>
                </div>
            </div>

            <!-- START OF GRID -->
            <div class="restaurant-grid">
                
                <!-- Restaurant 1: The Urban Grill -->
                <div class="res-card" data-cuisine="Burgers American Classic">
                    <div class="res-image">
                        <a href="urbangrillmenu.php">
                            <img src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=500" alt="The Urban Grill">
                        </a>
                        <span class="rating-badge">⭐ 4.8</span>
                        <span class="featured-label">Featured</span>
                    </div>
                    <div class="res-info">
                        <div class="res-title">
                            <h3><a href="urbangrillmenu.php">The Urban Grill</a></h3>
                            <span class="price-tag">$$</span>
                        </div>
                        <p>Gourmet Burgers • American Classic • Loaded Fries</p>
                        <div class="res-meta">
                            <span>🕒 20-30 min</span>
                            <span>🚲 Free</span>
                        </div>
                    </div>
                </div>

                <!-- Restaurant 2: Zen Sushi Bar -->
                <div class="res-card" data-cuisine="Asian Fusion Sushi">
                    <div class="res-image">
                        <a href="urbangrillmenu.php?restaurant=zen-sushi">
                            <img src="https://images.unsplash.com/photo-1579871494447-9811cf80d66c?w=500" alt="Zen Sushi Bar">
                        </a>
                        <span class="rating-badge">⭐ 4.9</span>
                        <span class="featured-label" style="background: #27ae60;">Top Rated</span>
                    </div>
                    <div class="res-info">
                        <div class="res-title">
                            <h3><a href="urbangrillmenu.php?restaurant=zen-sushi">Zen Sushi Bar</a></h3>
                            <span class="price-tag">$$$</span>
                        </div>
                        <p>Japanese • Sushi Rolls • Tonkotsu Ramen</p>
                        <div class="res-meta">
                            <span>🕒 35-50 min</span>
                            <span>🚲 $3.99</span>
                        </div>
                    </div>
                </div>

                <!-- Restaurant 3: Bella Italia Trattoria -->
                <div class="res-card" data-cuisine="Italian Pizza">
                    <div class="res-image">
                        <a href="urbangrillmenu.php?restaurant=bella-italia">
                            <img src="https://images.unsplash.com/photo-1513104890138-7c749659a591?w=500" alt="Bella Italia Trattoria">
                        </a>
                        <span class="rating-badge">⭐ 4.7</span>
                    </div>
                    <div class="res-info">
                        <div class="res-title">
                            <h3><a href="urbangrillmenu.php?restaurant=bella-italia">Bella Italia Trattoria</a></h3>
                            <span class="price-tag">$$</span>
                        </div>
                        <p>Italian • Woodfired Pizza • Handcrafted Pasta</p>
                        <div class="res-meta">
                            <span>🕒 25-40 min</span>
                            <span>🚲 $2.49</span>
                        </div>
                    </div>
                </div>

                <!-- Restaurant 4: Green Bowl Co. -->
                <div class="res-card" data-cuisine="Healthy Vegan">
                    <div class="res-image">
                        <a href="urbangrillmenu.php?restaurant=green-bowl">
                            <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=500" alt="Green Bowl Co.">
                        </a>
                        <span class="rating-badge">⭐ 4.8</span>
                    </div>
                    <div class="res-info">
                        <div class="res-title">
                            <h3><a href="urbangrillmenu.php?restaurant=green-bowl">Green Bowl Co.</a></h3>
                            <span class="price-tag">$$</span>
                        </div>
                        <p>Healthy • Superfood Bowls • Fresh Smoothies</p>
                        <div class="res-meta">
                            <span>🕒 15-25 min</span>
                            <span>🚲 Free</span>
                        </div>
                    </div>
                </div>

                <!-- Restaurant 5: Bangkok Street Spice -->
                <div class="res-card" data-cuisine="Thai Asian Fusion">
                    <div class="res-image">
                        <a href="urbangrillmenu.php?restaurant=bangkok-spice">
                            <img src="https://images.unsplash.com/photo-1559339352-11d035aa65de?w=500" alt="Bangkok Street Spice">
                        </a>
                        <span class="rating-badge">⭐ 4.9</span>
                        <span class="featured-label" style="background: #e67e22;">Spicy Pick</span>
                    </div>
                    <div class="res-info">
                        <div class="res-title">
                            <h3><a href="urbangrillmenu.php?restaurant=bangkok-spice">Bangkok Street Spice</a></h3>
                            <span class="price-tag">$</span>
                        </div>
                        <p>Thai • Pad Thai • Green Curry • Mango Sticky Rice</p>
                        <div class="res-meta">
                            <span>🕒 20-35 min</span>
                            <span>🚲 Free</span>
                        </div>
                    </div>
                </div>

                <!-- Restaurant 6: Taco Fiesta Mexicana -->
                <div class="res-card" data-cuisine="Mexican American Classic">
                    <div class="res-image">
                        <a href="urbangrillmenu.php?restaurant=taco-fiesta">
                            <img src="https://images.unsplash.com/photo-1565299585323-38d6b0865b47?w=500" alt="Taco Fiesta">
                        </a>
                        <span class="rating-badge">⭐ 4.6</span>
                    </div>
                    <div class="res-info">
                        <div class="res-title">
                            <h3><a href="urbangrillmenu.php?restaurant=taco-fiesta">Taco Fiesta Mexicana</a></h3>
                            <span class="price-tag">$</span>
                        </div>
                        <p>Mexican • Birria Tacos • Cheesy Quesadillas</p>
                        <div class="res-meta">
                            <span>🕒 20-30 min</span>
                            <span>🚲 $1.99</span>
                        </div>
                    </div>
                </div>

                <!-- Restaurant 7: Sweet Delights Artisan Bakery -->
                <div class="res-card" data-cuisine="Desserts">
                    <div class="res-image">
                        <a href="urbangrillmenu.php?restaurant=sweet-delights">
                            <img src="https://images.unsplash.com/photo-1551024506-0bccd828d307?w=500" alt="Sweet Delights Bakery">
                        </a>
                        <span class="rating-badge">⭐ 4.8</span>
                    </div>
                    <div class="res-info">
                        <div class="res-title">
                            <h3><a href="urbangrillmenu.php?restaurant=sweet-delights">Sweet Delights Bakery</a></h3>
                            <span class="price-tag">$</span>
                        </div>
                        <p>Desserts • French Pastries • Belgian Waffles</p>
                        <div class="res-meta">
                            <span>🕒 15-25 min</span>
                            <span>🚲 $1.49</span>
                        </div>
                    </div>
                </div>

                <!-- Restaurant 8: The Golden Prime Steakhouse -->
                <div class="res-card" data-cuisine="American Classic">
                    <div class="res-image">
                        <a href="urbangrillmenu.php?restaurant=golden-steakhouse">
                            <img src="https://images.unsplash.com/photo-1544025162-d76694265947?w=500" alt="The Golden Prime">
                        </a>
                        <span class="rating-badge">⭐ 4.9</span>
                        <span class="featured-label" style="background: #2c3e50;">Fine Dining</span>
                    </div>
                    <div class="res-info">
                        <div class="res-title">
                            <h3><a href="urbangrillmenu.php?restaurant=golden-steakhouse">The Golden Prime</a></h3>
                            <span class="price-tag">$$$$</span>
                        </div>
                        <p>American Classic • Dry Aged Steaks • Wine Pairings</p>
                        <div class="res-meta">
                            <span>🕒 35-50 min</span>
                            <span>🚲 $4.99</span>
                        </div>
                    </div>
                </div>

            </div> <!-- End Grid -->
        </section>
    </main>

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
    <script src="JavaScript/restaurants.js"></script>
</body>
</html>