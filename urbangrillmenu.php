<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $_SESSION['user_name'] ?? 'Account';

// Detect restaurant parameter for dynamic menu support
$resParam = $_GET['restaurant'] ?? 'urban-grill';

$restaurantsData = [
    'urban-grill' => [
        'name' => 'The Urban Grill',
        'badge' => '⭐ 4.8 (500+ reviews)',
        'meta' => '20-30 min • Free Delivery • Gourmet Burgers & Steaks',
        'banner' => 'https://images.unsplash.com/photo-1550547660-d9450f859349?w=1200',
        'categories' => ['Burgers', 'Sides', 'Drinks', 'Desserts', 'Vegan']
    ],
    'zen-sushi' => [
        'name' => 'Zen Sushi Bar',
        'badge' => '⭐ 4.9 (420+ reviews)',
        'meta' => '35-50 min • $3.99 Delivery • Japanese, Sushi & Ramen',
        'banner' => 'https://images.unsplash.com/photo-1579871494447-9811cf80d66c?w=1200',
        'categories' => ['Sushi Rolls', 'Ramen', 'Sides', 'Drinks', 'Desserts']
    ],
    'bella-italia' => [
        'name' => 'Bella Italia Trattoria',
        'badge' => '⭐ 4.7 (380+ reviews)',
        'meta' => '25-40 min • $2.49 Delivery • Woodfired Pizza & Handcrafted Pasta',
        'banner' => 'https://images.unsplash.com/photo-1513104890138-7c749659a591?w=1200',
        'categories' => ['Pizza', 'Pasta', 'Sides', 'Drinks', 'Desserts']
    ],
    'green-bowl' => [
        'name' => 'Green Bowl Co.',
        'badge' => '⭐ 4.8 (310+ reviews)',
        'meta' => '15-25 min • Free Delivery • Organic Superfood Bowls & Vegan',
        'banner' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=1200',
        'categories' => ['Bowls', 'Smoothies', 'Sides', 'Drinks', 'Vegan']
    ],
    'bangkok-spice' => [
        'name' => 'Bangkok Street Spice',
        'badge' => '⭐ 4.9 (480+ reviews)',
        'meta' => '20-35 min • Free Delivery • Thai Curries & Street Noodles',
        'banner' => 'https://images.unsplash.com/photo-1559339352-11d035aa65de?w=1200',
        'categories' => ['Noodles', 'Curries', 'Sides', 'Drinks', 'Desserts']
    ],
    'taco-fiesta' => [
        'name' => 'Taco Fiesta Mexicana',
        'badge' => '⭐ 4.6 (290+ reviews)',
        'meta' => '20-30 min • $1.99 Delivery • Authentic Tacos & Quesadillas',
        'banner' => 'https://images.unsplash.com/photo-1565299585323-38d6b0865b47?w=1200',
        'categories' => ['Tacos', 'Burritos', 'Sides', 'Drinks', 'Desserts']
    ],
    'sweet-delights' => [
        'name' => 'Sweet Delights Bakery',
        'badge' => '⭐ 4.8 (520+ reviews)',
        'meta' => '15-25 min • $1.49 Delivery • French Pastries & Cakes',
        'banner' => 'https://images.unsplash.com/photo-1551024506-0bccd828d307?w=1200',
        'categories' => ['Pastries', 'Cakes', 'Waffles', 'Drinks', 'Desserts']
    ],
    'golden-steakhouse' => [
        'name' => 'The Golden Prime',
        'badge' => '⭐ 4.9 (210+ reviews)',
        'meta' => '35-50 min • $4.99 Delivery • Dry Aged Steaks & Fine Dining',
        'banner' => 'https://images.unsplash.com/photo-1544025162-d76694265947?w=1200',
        'categories' => ['Steaks', 'Seafood', 'Sides', 'Drinks', 'Desserts']
    ]
];

$activeRes = $restaurantsData[$resParam] ?? $restaurantsData['urban-grill'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($activeRes['name']); ?> | CraveExpress</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Design/design1.css">
    <link rel="stylesheet" href="Design/design3.css">
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
                <input type="text" id="menu-search-input" placeholder="Search menu items...">
            </div>
            <a href="#" class="cart-icon" id="cart-icon-btn" title="View Cart">🛒 <span id="cart-count">0</span></a>
            <a href="profile_settings.php" class="profile-icon" title="<?php echo htmlspecialchars($userName); ?>">👤</a>
        </div>
    </nav>

    <!-- Category Tabs -->
    <div class="category-tabs">
        <button class="active" data-category="all">All Items</button>
        <button data-category="burgers">Main Dishes</button>
        <button onclick="window.location.href='urbangrillmenuslides.php'" data-category="sides">Sides</button>
        <button data-category="drinks">Drinks</button>
        <button data-category="desserts">Desserts</button>
        <button data-category="vegan">Vegan</button>
        <button class="filters-btn" onclick="alert('Dietary filters: All items meet our strict freshness standard.');">⠿ Filters</button>
    </div>

    <main class="menu-layout">
        <section class="menu-content">
            <div class="restaurant-banner">
                <img src="<?php echo htmlspecialchars($activeRes['banner']); ?>" alt="<?php echo htmlspecialchars($activeRes['name']); ?>">
                <div class="banner-overlay">
                    <h1><?php echo htmlspecialchars($activeRes['name']); ?></h1>
                    <div class="banner-meta">
                        <span class="rating"><?php echo htmlspecialchars($activeRes['badge']); ?></span>
                        <span><?php echo htmlspecialchars($activeRes['meta']); ?></span>
                    </div>
                </div>
            </div>

            <!-- SECTION 1: Burgers / Main Dishes -->
            <div class="menu-section" data-category="burgers">
                <div class="section-header">
                    <h2>Signature Mains</h2>
                    <span class="best-seller">Best Sellers</span>
                </div>
                
                <!-- Item 1 -->
                <div class="menu-item">
                    <div class="item-details">
                        <h3>The Urban Classic</h3>
                        <p>Signature flame-grilled prime beef patty, melted Wisconsin cheddar, house secret sauce, crisp butter lettuce on a toasted brioche bun.</p>
                        <span class="price">$12.99</span>
                        <button class="add-btn">+</button>
                    </div>
                    <img src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=300" alt="Classic Burger">
                </div>

                <!-- Item 2 -->
                <div class="menu-item">
                    <div class="item-details">
                        <h3>Smoky BBQ Bacon Grill</h3>
                        <p>Double smashed beef patties with hardwood smoked bacon, golden crispy onion rings, and our signature hickory BBQ glaze.</p>
                        <span class="price">$15.50</span>
                        <button class="add-btn">+</button>
                    </div>
                    <img src="https://images.unsplash.com/photo-1594212699903-ec8a3eca50f5?w=300" alt="BBQ Burger">
                </div>

                <!-- Item 3 -->
                <div class="menu-item">
                    <div class="item-details">
                        <h3>Truffle Mushroom Angus</h3>
                        <p>100% Black Angus beef patty smothered in garlic butter sautéed wild mushrooms, aged Swiss cheese, and fragrant white truffle aioli.</p>
                        <span class="price">$16.25</span>
                        <button class="add-btn">+</button>
                    </div>
                    <img src="https://images.unsplash.com/photo-1586190848861-99aa4a171e90?w=300" alt="Mushroom Burger">
                </div>

                <!-- Item 4 -->
                <div class="menu-item">
                    <div class="item-details">
                        <h3>Spicy Firecracker Crunch</h3>
                        <p>Crispy buttermilk fried chicken breast, Nashville hot dust, jalapeño slaw, dill pickles, and chipotle ranch on potato bun.</p>
                        <span class="price">$13.99</span>
                        <button class="add-btn">+</button>
                    </div>
                    <img src="https://images.unsplash.com/photo-1625813506062-0aeb1d7a094b?w=300" alt="Spicy Chicken">
                </div>
            </div>

            <!-- SECTION 2: Sides -->
            <div class="menu-section" data-category="sides">
                <div class="section-header">
                    <h2>Sides & Appetizers</h2>
                    <span class="best-seller"><a href="urbangrillmenuslides.php" style="color: inherit; text-decoration: none;">View All Sides ›</a></span>
                </div>

                <div class="menu-item">
                    <div class="item-details">
                        <h3>Truffle Parmesan Fries</h3>
                        <p>Hand-cut Idaho russet potatoes tossed in white truffle oil, freshly grated aged parmesan, and chopped Italian parsley.</p>
                        <span class="price">$6.50</span>
                        <button class="add-btn">+</button>
                    </div>
                    <img src="https://images.unsplash.com/photo-1573080496219-bb080dd4f877?w=300" alt="Truffle Fries">
                </div>

                <div class="menu-item">
                    <div class="item-details">
                        <h3>Crispy Beer-Battered Onion Rings</h3>
                        <p>Thick-cut jumbo sweet Spanish onions dunked in craft beer batter, fried to golden perfection with smoky chipotle mayo.</p>
                        <span class="price">$5.99</span>
                        <button class="add-btn">+</button>
                    </div>
                    <img src="https://images.unsplash.com/photo-1639024471283-035188835118?w=300" alt="Onion Rings">
                </div>

                <div class="menu-item">
                    <div class="item-details">
                        <h3>Loaded Sweet Potato Wedges</h3>
                        <p>Roasted sweet potato wedges topped with crumbled Greek feta, toasted pumpkin seeds, and zesty cilantro lime crema.</p>
                        <span class="price">$7.25</span>
                        <button class="add-btn">+</button>
                    </div>
                    <img src="https://images.unsplash.com/photo-1596097635121-14b63b7a0c19?w=300" alt="Sweet Potato Wedges">
                </div>
            </div>

            <!-- SECTION 3: Drinks -->
            <div class="menu-section" data-category="drinks">
                <div class="section-header">
                    <h2>Artisanal Drinks</h2>
                    <span class="best-seller">Refreshing</span>
                </div>

                <div class="menu-item">
                    <div class="item-details">
                        <h3>Craft Salted Caramel Shake</h3>
                        <p>Hand-spun Madagascar vanilla bean ice cream, fleur de sel sea salt caramel drizzle, topped with real whipped cream.</p>
                        <span class="price">$5.50</span>
                        <button class="add-btn">+</button>
                    </div>
                    <img src="https://images.unsplash.com/photo-1572490122747-3968b75cc699?w=300" alt="Caramel Shake">
                </div>

                <div class="menu-item">
                    <div class="item-details">
                        <h3>Sparkling Strawberry Mint Lemonade</h3>
                        <p>Freshly squeezed lemons, muddled ripe organic strawberries, sparkling mineral water, and garden mint sprigs.</p>
                        <span class="price">$4.25</span>
                        <button class="add-btn">+</button>
                    </div>
                    <img src="https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?w=300" alt="Lemonade">
                </div>
            </div>

            <!-- SECTION 4: Desserts -->
            <div class="menu-section" data-category="desserts">
                <div class="section-header">
                    <h2>Decadent Desserts</h2>
                </div>

                <div class="menu-item">
                    <div class="item-details">
                        <h3>Warm Molten Lava Cake</h3>
                        <p>Rich Belgian dark chocolate sponge cake with a warm flowing ganache center, served with a scoop of Madagascar vanilla gelato.</p>
                        <span class="price">$7.50</span>
                        <button class="add-btn">+</button>
                    </div>
                    <img src="https://images.unsplash.com/photo-1606313564200-e75d5e30476c?w=300" alt="Lava Cake">
                </div>
            </div>

            <!-- SECTION 5: Vegan -->
            <div class="menu-section" data-category="vegan">
                <div class="section-header">
                    <h2>100% Plant-Based</h2>
                    <span class="best-seller" style="background: #27ae60; color: white;">🌱 Vegan</span>
                </div>

                <div class="menu-item">
                    <div class="item-details">
                        <h3>Beyond Urban Plant Burger</h3>
                        <p>Plant-based patty with dairy-free smoked provolone, avocado mash, baby arugula, and roasted garlic vegan mayo on pretzel bun.</p>
                        <span class="price">$14.50</span>
                        <button class="add-btn">+</button>
                    </div>
                    <img src="https://images.unsplash.com/photo-1520072959219-c595dc870360?w=300" alt="Vegan Burger">
                </div>
            </div>
        </section>

        <!-- Sidebar: Dynamic Basket -->
        <aside class="order-sidebar">
            <div class="sidebar-card">
                <h3>Your Order <span class="order-count" id="sidebar-count">0</span></h3>
                
                <!-- Container for dynamic items -->
                <div class="order-items" id="cart-items-container">
                    <!-- Populated dynamically via Cart.render() -->
                </div>
                
                <div class="order-summary">
                    <div class="summary-line"><span>Subtotal</span><span id="subtotal">$0.00</span></div>
                    <div class="summary-line"><span>Delivery Fee</span><span class="free-text">FREE</span></div>
                    <div class="summary-line total"><span>Total</span><span id="total-price">$0.00</span></div>
                </div>
                <button class="checkout-btn">Go to Checkout →</button>
            </div>
        </aside>
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
    <script src="JavaScript/control2.js"></script>
</body>
</html>