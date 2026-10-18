<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $_SESSION['user_name'] ?? 'Account';
$orderIdQuery = $_GET['order_id'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Orders | CraveExpress</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Design/design1.css">
    <link rel="stylesheet" href="Design/common.css">
    <link rel="stylesheet" href="Design/orders.css">
</head>
<body style="background-color: #fcfcfc;">

    <nav>
        <div class="logo"><a href="index.php" style="text-decoration: none; color: inherit;">CraveExpress</a></div>
        <div class="nav-links">
            <a href="index.php">Offers</a>
            <a href="restaurants.php">Restaurants</a>
            <a href="orders.php" class="active">Orders</a>
            <a href="help.php">Help</a>
            <a href="#" class="cart-icon" id="cart-icon-btn" title="View Cart">🛒 <span id="cart-count">0</span></a>
            <a href="profile_settings.php" class="profile-icon" title="<?php echo htmlspecialchars($userName); ?>">👤</a>
        </div>
    </nav>

    <main class="orders-container">
        <!-- Page Title -->
        <div style="margin-bottom: 25px;">
            <h1 style="font-size: 2rem; margin: 0 0 5px 0;">Your Orders</h1>
            <p style="color: #666; margin: 0;">Follow real-time progress of your food and browse your dining history.</p>
        </div>

        <!-- Navigation Tabs -->
        <div class="orders-tabs">
            <button class="orders-tab-btn active" id="tab-live-btn" onclick="switchOrdersTab('live')">🛵 Live Order Tracking</button>
            <button class="orders-tab-btn" id="tab-history-btn" onclick="switchOrdersTab('history')">📜 Order History</button>
        </div>

        <!-- TAB 1: LIVE TRACKING -->
        <div id="section-live-tracking">
            <div id="active-order-content">
                <!-- Dynamically Populated or Fallback -->
            </div>
        </div>

        <!-- TAB 2: ORDER HISTORY -->
        <div id="section-order-history" style="display: none;">
            <div id="order-history-list">
                <!-- Dynamically populated via JS -->
            </div>
        </div>
    </main>

    <!-- Receipt Modal -->
    <div id="receipt-modal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:99999; justify-content:center; align-items:center;">
        <div style="background:white; border-radius:16px; width:90%; max-width:480px; padding:30px; position:relative; box-shadow:0 10px 40px rgba(0,0,0,0.2);">
            <button onclick="closeReceipt()" style="position:absolute; top:20px; right:20px; border:none; background:#eee; width:30px; height:30px; border-radius:50%; cursor:pointer;">✕</button>
            <div id="receipt-modal-body"></div>
            <button onclick="window.print()" style="width:100%; margin-top:20px; padding:12px; background:var(--primary-orange); color:white; border:none; border-radius:8px; font-weight:700; cursor:pointer;">Print Receipt 🖨️</button>
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
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            loadActiveOrder();
            loadOrderHistory();
        });

        function switchOrdersTab(tab) {
            const liveTab = document.getElementById('section-live-tracking');
            const histTab = document.getElementById('section-order-history');
            const liveBtn = document.getElementById('tab-live-btn');
            const histBtn = document.getElementById('tab-history-btn');

            if (tab === 'live') {
                liveTab.style.display = 'block';
                histTab.style.display = 'none';
                liveBtn.classList.add('active');
                histBtn.classList.remove('active');
            } else {
                liveTab.style.display = 'none';
                histTab.style.display = 'block';
                liveBtn.classList.remove('active');
                histBtn.classList.add('active');
            }
        }

        function loadActiveOrder() {
            const container = document.getElementById('active-order-content');
            let activeOrder = null;

            try {
                activeOrder = JSON.parse(localStorage.getItem('crave_active_order'));
            } catch(e) {}

            // Demo default active order if none in storage
            if (!activeOrder) {
                activeOrder = {
                    orderId: '<?php echo $orderIdQuery ? htmlspecialchars($orderIdQuery) : "CRV-492108"; ?>',
                    date: new Date().toISOString(),
                    status: 'On the way',
                    estimatedMinutes: 19,
                    customer: {
                        name: '<?php echo htmlspecialchars($userName); ?>',
                        phone: '+63 912 345 6789',
                        address: '123 Ayala Avenue, Unit 4B, Makati City',
                        notes: 'Leave with concierge'
                    },
                    items: [
                        { name: 'The Urban Classic', price: 12.99, quantity: 2, image: 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=150', restaurant: 'The Urban Grill' },
                        { name: 'Truffle Parmesan Fries', price: 6.50, quantity: 1, image: 'https://images.unsplash.com/photo-1573080496219-bb080dd4f877?w=150', restaurant: 'The Urban Grill' }
                    ],
                    paymentMethod: 'Credit Card (••4242)',
                    pricing: {
                        subtotal: '32.48',
                        delivery: '0.00',
                        tax: '2.60',
                        discount: '0.00',
                        total: '35.08'
                    }
                };
            }

            container.innerHTML = `
                <div class="tracking-card">
                    <div class="tracking-header">
                        <div>
                            <span style="font-size: 0.85rem; color: #888; text-transform: uppercase; font-weight: 700;">Order ID: #${activeOrder.orderId}</span>
                            <h2 style="margin: 4px 0 0 0; font-size: 1.6rem;">Courier is on the way!</h2>
                        </div>
                        <div class="eta-badge">
                            <span>⏱️</span>
                            <span>Estimated Arrival: <strong id="countdown-timer">${activeOrder.estimatedMinutes} mins</strong></span>
                        </div>
                    </div>

                    <!-- Visual Status Stepper -->
                    <div class="status-stepper">
                        <div class="status-step completed">
                            <div class="step-icon-circle">✓</div>
                            <span>Order Confirmed</span>
                        </div>
                        <div class="status-step completed">
                            <div class="step-icon-circle">🍳</div>
                            <span>Kitchen Prepping</span>
                        </div>
                        <div class="status-step current">
                            <div class="step-icon-circle">🛵</div>
                            <span>On The Way</span>
                        </div>
                        <div class="status-step">
                            <div class="step-icon-circle">🏠</div>
                            <span>Delivered</span>
                        </div>
                    </div>

                    <!-- Simulated Live Delivery Route Map -->
                    <div class="live-map-container">
                        <!-- Clean Map Grid SVG -->
                        <svg class="map-svg" viewBox="0 0 800 260" xmlns="http://www.w3.org/2000/svg">
                            <!-- Background Map blocks -->
                            <rect width="800" height="260" fill="#eef2f7" />
                            <path d="M 0,60 L 800,60 M 0,130 L 800,130 M 0,200 L 800,200" stroke="#d5dde8" stroke-width="12" />
                            <path d="M 120,0 L 120,260 M 300,0 L 300,260 M 520,0 L 520,260 M 700,0 L 700,260" stroke="#d5dde8" stroke-width="12" />
                            <circle cx="220" cy="90" r="35" fill="#d2e3fc" />
                            <circle cx="600" cy="170" r="40" fill="#d4edda" />
                            
                            <!-- Delivery Route Line -->
                            <path d="M 120,195 Q 300,130 520,90 T 700,65" fill="none" stroke="var(--primary-orange)" stroke-width="5" stroke-dasharray="8 6" />

                            <!-- Restaurant Pin -->
                            <g transform="translate(110, 180)">
                                <circle cx="10" cy="10" r="14" fill="#333" />
                                <text x="5" y="15" fill="white" font-size="12">🍔</text>
                                <text x="-25" y="32" font-weight="bold" font-size="11" fill="#333">Restaurant</text>
                            </g>

                            <!-- Destination Pin -->
                            <g transform="translate(690, 50)">
                                <circle cx="10" cy="10" r="14" fill="#E31818" />
                                <text x="5" y="15" fill="white" font-size="12">📍</text>
                                <text x="-15" y="32" font-weight="bold" font-size="11" fill="#E31818">Your Door</text>
                            </g>
                        </svg>

                        <!-- Moving Scooter -->
                        <div class="scooter-marker">🛵</div>
                    </div>

                    <!-- Courier Card -->
                    <div class="courier-card">
                        <div class="courier-info">
                            <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=100" class="courier-avatar" alt="Courier Driver">
                            <div>
                                <h4 style="margin: 0; font-size: 1.05rem;">Carlos Mendoza</h4>
                                <small style="color: #666;">CraveExpress Express Rider • Yamaha NMAX</small>
                                <div style="font-size: 0.85rem; color: #f39c12; font-weight: bold; margin-top: 2px;">⭐ 4.96 (1,240 deliveries)</div>
                            </div>
                        </div>
                        <div class="courier-actions">
                            <a href="tel:09123456789" class="btn-courier-action">📞 Call Driver</a>
                            <button class="btn-courier-action" onclick="alert('Driver: Hello! I have picked up your warm food and am navigating to you now. Estimated in 15 mins!')">💬 Send Note</button>
                        </div>
                    </div>

                    <!-- Order Summary Dropdown -->
                    <div style="border-top: 1px solid #eee; padding-top: 20px;">
                        <h4 style="margin: 0 0 15px 0; font-size: 1.1rem;">Delivery & Items Breakdown</h4>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; font-size: 0.9rem; margin-bottom: 20px;">
                            <div>
                                <strong style="color: #555; display: block; margin-bottom: 4px;">Delivering To:</strong>
                                <span>${activeOrder.customer.address}</span>
                                <small style="display: block; color: #888; margin-top: 2px;">Note: ${activeOrder.customer.notes || 'None'}</small>
                            </div>
                            <div>
                                <strong style="color: #555; display: block; margin-bottom: 4px;">Payment Method:</strong>
                                <span>${activeOrder.paymentMethod || 'Credit Card'}</span>
                            </div>
                        </div>

                        <div style="background: #fafafa; border-radius: 8px; padding: 15px;">
                            ${activeOrder.items.map(item => `
                                <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 0.9rem;">
                                    <span>${item.quantity}x ${item.name}</span>
                                    <strong>$${(item.price * item.quantity).toFixed(2)}</strong>
                                </div>
                            `).join('')}
                            <hr style="border: none; border-top: 1px solid #ddd; margin: 10px 0;">
                            <div style="display: flex; justify-content: space-between; font-weight: 700; font-size: 1.05rem;">
                                <span>Total Paid</span>
                                <span style="color: var(--primary-orange);">$${activeOrder.pricing.total}</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            // Countdown simulation
            let mins = activeOrder.estimatedMinutes || 20;
            const timerEl = document.getElementById('countdown-timer');
            if (timerEl) {
                setInterval(() => {
                    if (mins > 1 && Math.random() > 0.6) {
                        mins--;
                        timerEl.innerText = `${mins} mins`;
                    }
                }, 10000);
            }
        }

        function loadOrderHistory() {
            const listContainer = document.getElementById('order-history-list');
            let history = [];

            try {
                history = JSON.parse(localStorage.getItem('crave_orders_history')) || [];
            } catch(e) {}

            // Populate sample history if empty
            if (history.length === 0) {
                history = [
                    {
                        orderId: 'CRV-938201',
                        date: '2026-10-16T19:30:00Z',
                        restaurant: 'The Urban Grill',
                        items: [
                            { name: 'The Urban Classic', price: 12.99, quantity: 1, image: 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=150' },
                            { name: 'Truffle Parmesan Fries', price: 6.50, quantity: 1, image: 'https://images.unsplash.com/photo-1573080496219-bb080dd4f877?w=150' }
                        ],
                        total: '19.49',
                        status: 'Delivered'
                    },
                    {
                        orderId: 'CRV-871142',
                        date: '2026-10-12T13:15:00Z',
                        restaurant: 'Zen Sushi Bar',
                        items: [
                            { name: 'Salmon Sashimi Deluxe', price: 18.50, quantity: 1, image: 'https://images.unsplash.com/photo-1579871494447-9811cf80d66c?w=150' },
                            { name: 'Tonkotsu Ramen Bowl', price: 14.00, quantity: 1, image: 'https://images.unsplash.com/photo-1559339352-11d035aa65de?w=150' }
                        ],
                        total: '36.49',
                        status: 'Delivered'
                    }
                ];
            }

            listContainer.innerHTML = history.map(order => {
                const formattedDate = new Date(order.date).toLocaleDateString('en-US', {
                    month: 'short', day: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit'
                });
                const summary = order.items.map(i => `${i.quantity}x ${i.name}`).join(', ');
                const orderTotal = order.total || (order.pricing ? order.pricing.total : '24.99');
                const restaurantName = order.restaurant || (order.items[0] ? order.items[0].restaurant : 'The Urban Grill');

                return `
                    <div class="history-item-card">
                        <div>
                            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 5px;">
                                <h3 style="margin: 0; font-size: 1.15rem;">${restaurantName}</h3>
                                <span class="history-badge badge-delivered">✓ Delivered</span>
                            </div>
                            <span style="color: #888; font-size: 0.85rem; display: block; margin-bottom: 8px;">Order #${order.orderId} • ${formattedDate}</span>
                            <p style="margin: 0; font-size: 0.9rem; color: #555;">${summary}</p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <strong style="font-size: 1.2rem; color: #111;">$${orderTotal}</strong>
                            <button class="btn-reorder" onclick="reorderItems('${order.orderId}')">Reorder ↺</button>
                            <button style="border: 1px solid #ddd; background: white; padding: 8px 12px; border-radius: 6px; cursor: pointer;" onclick="openReceipt('${order.orderId}')">Receipt</button>
                        </div>
                    </div>
                `;
            }).join('');
        }

        function reorderItems(orderId) {
            let history = [];
            try {
                history = JSON.parse(localStorage.getItem('crave_orders_history')) || [];
            } catch(e) {}

            const order = history.find(o => o.orderId === orderId);
            if (order && order.items) {
                order.items.forEach(item => {
                    Cart.add(item);
                });
                Cart.openDrawer();
            } else {
                alert('Added items to basket!');
            }
        }

        function openReceipt(orderId) {
            let history = [];
            try {
                history = JSON.parse(localStorage.getItem('crave_orders_history')) || [];
            } catch(e) {}

            const order = history.find(o => o.orderId === orderId) || {
                orderId: orderId,
                date: new Date().toISOString(),
                total: '35.08',
                items: [{ name: 'The Urban Classic', price: 12.99, quantity: 2 }]
            };

            const body = document.getElementById('receipt-modal-body');
            body.innerHTML = `
                <div style="text-align: center; margin-bottom: 20px;">
                    <h2 style="color: var(--primary-orange); margin: 0;">CraveExpress</h2>
                    <span style="font-size: 0.85rem; color: #777;">Official Customer Order Receipt</span>
                </div>
                <div style="border-bottom: 1px dashed #ddd; padding-bottom: 15px; margin-bottom: 15px; font-size: 0.85rem;">
                    <div><strong>Order ID:</strong> #${order.orderId}</div>
                    <div><strong>Date:</strong> ${new Date(order.date).toLocaleString()}</div>
                    <div><strong>Customer:</strong> <?php echo htmlspecialchars($userName); ?></div>
                </div>
                <div style="margin-bottom: 20px;">
                    ${order.items.map(i => `
                        <div style="display: flex; justify-content: space-between; font-size: 0.9rem; margin-bottom: 6px;">
                            <span>${i.quantity}x ${i.name}</span>
                            <span>$${(i.price * i.quantity).toFixed(2)}</span>
                        </div>
                    `).join('')}
                </div>
                <div style="border-top: 2px solid #222; padding-top: 10px; display: flex; justify-content: space-between; font-weight: bold; font-size: 1.15rem;">
                    <span>Total Paid</span>
                    <span>$${order.total || (order.pricing ? order.pricing.total : '35.08')}</span>
                </div>
            `;

            document.getElementById('receipt-modal').style.display = 'flex';
        }

        function closeReceipt() {
            document.getElementById('receipt-modal').style.display = 'none';
        }
    </script>
</body>
</html>
