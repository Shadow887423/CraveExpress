<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $_SESSION['user_name'] ?? 'John Doe';
$userEmail = $_SESSION['user_email'] ?? 'john@example.com';
$userPhone = $_SESSION['user_phone'] ?? '+63 912 345 6789';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | CraveExpress</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Design/design1.css">
    <link rel="stylesheet" href="Design/common.css">
    <link rel="stylesheet" href="Design/checkout.css">
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

    <main class="checkout-container">
        <!-- Breadcrumbs -->
        <div style="font-size: 0.85rem; color: #888; margin-bottom: 15px;">
            <a href="index.php" style="color: inherit; text-decoration: none;">Home</a> › 
            <a href="restaurants.php" style="color: inherit; text-decoration: none;">Restaurants</a> › 
            <span style="color: var(--primary-orange); font-weight: 600;">Checkout</span>
        </div>

        <h1 style="font-size: 2rem; margin: 0 0 5px 0;">Finalize Your Order</h1>
        <p style="color: #666; margin: 0 0 25px 0;">Review your delivery location and payment to complete your craving.</p>

        <form id="checkoutForm" onsubmit="handlePlaceOrder(event)">
            <div class="checkout-layout">
                
                <!-- Left: Order Steps -->
                <div class="checkout-steps-col">
                    
                    <!-- Step 1: Delivery Address -->
                    <div class="checkout-step">
                        <div class="step-header">
                            <span class="step-num">1</span>
                            <h2>Delivery Details</h2>
                        </div>
                        
                        <div class="input-group" style="margin-bottom: 15px;">
                            <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 0.9rem;">Street Address</label>
                            <input type="text" id="chk-address" placeholder="123 Ayala Avenue, Makati City" value="123 Ayala Avenue, Makati City" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box;">
                        </div>

                        <div class="form-grid-2" style="margin-bottom: 15px;">
                            <div class="input-group">
                                <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 0.9rem;">Apartment / Suite / Floor</label>
                                <input type="text" id="chk-apt" placeholder="Unit 4B, Tower 2" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box;">
                            </div>
                            <div class="input-group">
                                <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 0.9rem;">City / Postal Code</label>
                                <input type="text" id="chk-city" placeholder="Metro Manila, 1226" value="Metro Manila, 1226" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box;">
                            </div>
                        </div>

                        <div class="input-group">
                            <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 0.9rem;">Drop-off Note for Driver</label>
                            <input type="text" id="chk-notes" placeholder="e.g. Leave at lobby reception, ring buzzer #4" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box;">
                        </div>
                    </div>

                    <!-- Step 2: Delivery Speed -->
                    <div class="checkout-step">
                        <div class="step-header">
                            <span class="step-num">2</span>
                            <h2>Delivery Speed</h2>
                        </div>

                        <div class="delivery-options-grid">
                            <div class="delivery-option-card active" onclick="selectDeliverySpeed(this, 0)">
                                <div>
                                    <strong style="display: block; font-size: 1rem; margin-bottom: 4px;">⚡ Standard Delivery</strong>
                                    <span style="color: #666; font-size: 0.85rem;">25 - 35 mins</span>
                                </div>
                                <span style="font-weight: 700; color: #27ae60; margin-top: 10px; font-size: 0.9rem;">Included / Free</span>
                            </div>

                            <div class="delivery-option-card" onclick="selectDeliverySpeed(this, 1.99)">
                                <div>
                                    <strong style="display: block; font-size: 1rem; margin-bottom: 4px;">🚀 Priority Express</strong>
                                    <span style="color: #666; font-size: 0.85rem;">15 - 20 mins (Direct to you)</span>
                                </div>
                                <span style="font-weight: 700; color: var(--primary-orange); margin-top: 10px; font-size: 0.9rem;">+$1.99</span>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Contact Info -->
                    <div class="checkout-step">
                        <div class="step-header">
                            <span class="step-num">3</span>
                            <h2>Recipient Contact</h2>
                        </div>

                        <div class="form-grid-2">
                            <div class="input-group">
                                <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 0.9rem;">Full Name</label>
                                <input type="text" id="chk-name" value="<?php echo htmlspecialchars($userName); ?>" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box;">
                            </div>
                            <div class="input-group">
                                <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 0.9rem;">Mobile Phone</label>
                                <input type="tel" id="chk-phone" value="<?php echo htmlspecialchars($userPhone); ?>" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box;">
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Payment Method -->
                    <div class="checkout-step">
                        <div class="step-header">
                            <span class="step-num">4</span>
                            <h2>Payment Method</h2>
                        </div>

                        <div class="payment-methods-grid">
                            <div class="payment-tab active" onclick="switchPayment('card', this)">💳 Credit Card</div>
                            <div class="payment-tab" onclick="switchPayment('cod', this)">💵 Cash on Delivery</div>
                            <div class="payment-tab" onclick="switchPayment('gcash', this)">📱 GCash / E-Wallet</div>
                            <div class="payment-tab" onclick="switchPayment('paypal', this)">🅿️ PayPal</div>
                        </div>

                        <!-- Card Panel -->
                        <div id="panel-card" class="payment-panel active">
                            <div class="input-group" style="margin-bottom: 12px;">
                                <label style="font-size: 0.85rem; font-weight: 600; color: #555;">Card Number</label>
                                <input type="text" placeholder="4242 •••• •••• 4242" value="4242 •••• •••• 4242" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box;">
                            </div>
                            <div class="form-grid-2">
                                <div class="input-group">
                                    <label style="font-size: 0.85rem; font-weight: 600; color: #555;">Expiry Date</label>
                                    <input type="text" placeholder="MM/YY" value="08/28" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box;">
                                </div>
                                <div class="input-group">
                                    <label style="font-size: 0.85rem; font-weight: 600; color: #555;">CVV / CVC</label>
                                    <input type="password" placeholder="•••" value="888" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box;">
                                </div>
                            </div>
                        </div>

                        <!-- COD Panel -->
                        <div id="panel-cod" class="payment-panel">
                            <p style="margin: 0; font-size: 0.9rem; color: #555;">💵 Please prepare the exact cash amount for our rider upon arrival. Change can be provided upon request in order notes.</p>
                        </div>

                        <!-- GCash Panel -->
                        <div id="panel-gcash" class="payment-panel">
                            <p style="margin: 0 0 10px 0; font-size: 0.9rem; color: #555;">📱 Instant QR payment will be generated upon pressing Place Order, or enter your mobile wallet number:</p>
                            <input type="tel" placeholder="09XX XXX XXXX" value="<?php echo htmlspecialchars($userPhone); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box;">
                        </div>

                        <!-- PayPal Panel -->
                        <div id="panel-paypal" class="payment-panel">
                            <p style="margin: 0; font-size: 0.9rem; color: #555;">🅿️ You will be redirected securely to PayPal to approve your transaction after clicking Place Order.</p>
                        </div>
                    </div>
                </div>

                <!-- Right: Order Summary -->
                <div class="checkout-summary-col">
                    <div class="order-summary-card">
                        <h3>Order Summary</h3>

                        <!-- Items in cart -->
                        <div class="summary-items-list" id="checkout-items-list">
                            <!-- Populated via JS -->
                        </div>

                        <!-- Coupon Promo Code -->
                        <div class="coupon-box">
                            <input type="text" id="chk-coupon-input" placeholder="Promo code (e.g. CRAVEFIRST)">
                            <button type="button" onclick="applyCheckoutCoupon()">Apply</button>
                        </div>
                        <div id="coupon-feedback" style="font-size: 0.85rem; margin-top: -12px; margin-bottom: 15px; display: none;"></div>

                        <!-- Calculation Rows -->
                        <div class="calculation-lines">
                            <div class="calc-row">
                                <span>Subtotal</span>
                                <span id="chk-subtotal">$0.00</span>
                            </div>
                            <div class="calc-row">
                                <span>Delivery Fee</span>
                                <span id="chk-delivery">FREE</span>
                            </div>
                            <div class="calc-row" id="chk-priority-row" style="display: none;">
                                <span>Priority Speed</span>
                                <span id="chk-priority-fee">+$1.99</span>
                            </div>
                            <div class="calc-row" id="chk-discount-row" style="display: none; color: #27ae60;">
                                <span>Promo Voucher</span>
                                <span id="chk-discount">-$0.00</span>
                            </div>
                            <div class="calc-row">
                                <span>Estimated Taxes (8%)</span>
                                <span id="chk-tax">$0.00</span>
                            </div>
                            <div class="calc-row total-price-row">
                                <span>Total Due</span>
                                <span id="chk-grand-total">$0.00</span>
                            </div>
                        </div>

                        <button type="submit" class="btn-place-order" id="place-order-btn">Place Order Now →</button>

                        <div style="text-align: center; margin-top: 15px; font-size: 0.8rem; color: #888;">
                            🔒 Safe & Secure 256-bit SSL Encrypted Payment
                        </div>
                    </div>
                </div>

            </div>
        </form>
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
    <script>
        let priorityFee = 0;
        let selectedPaymentMethod = 'Credit Card';

        document.addEventListener('DOMContentLoaded', () => {
            renderCheckoutSummary();
        });

        function renderCheckoutSummary() {
            const items = Cart.get();
            const listEl = document.getElementById('checkout-items-list');
            const subtotalEl = document.getElementById('chk-subtotal');
            const deliveryEl = document.getElementById('chk-delivery');
            const taxEl = document.getElementById('chk-tax');
            const discountRow = document.getElementById('chk-discount-row');
            const discountEl = document.getElementById('chk-discount');
            const totalEl = document.getElementById('chk-grand-total');
            const placeBtn = document.getElementById('place-order-btn');

            if (!items || items.length === 0) {
                listEl.innerHTML = `
                    <div style="text-align: center; padding: 30px 10px; color: #888;">
                        <span style="font-size: 2.5rem; display: block; margin-bottom: 10px;">🛒</span>
                        <p style="margin: 0 0 15px 0;">No items in your cart.</p>
                        <a href="restaurants.php" style="color: var(--primary-orange); font-weight: 600; text-decoration: none;">Browse Menu →</a>
                    </div>
                `;
                placeBtn.disabled = true;
                placeBtn.style.opacity = '0.5';
                return;
            }

            placeBtn.disabled = false;
            placeBtn.style.opacity = '1';

            listEl.innerHTML = items.map(item => `
                <div class="summary-item-row">
                    <div class="summary-item-info">
                        <img src="${item.image}" alt="${item.name}">
                        <div>
                            <strong style="display: block; font-size: 0.9rem;">${item.name}</strong>
                            <span style="color: #888; font-size: 0.8rem;">Qty: ${item.quantity}</span>
                        </div>
                    </div>
                    <strong>$${(item.price * item.quantity).toFixed(2)}</strong>
                </div>
            `).join('');

            const subtotal = Cart.getSubtotal();
            const baseDelivery = Cart.getDeliveryFee();
            const discount = Cart.getDiscount();
            const tax = Cart.getTax();
            const grandTotal = Math.max(0, subtotal + baseDelivery + priorityFee + tax - discount);

            subtotalEl.innerText = `$${subtotal.toFixed(2)}`;
            deliveryEl.innerText = baseDelivery === 0 ? 'FREE' : `$${baseDelivery.toFixed(2)}`;
            taxEl.innerText = `$${tax.toFixed(2)}`;

            if (discount > 0) {
                discountRow.style.display = 'flex';
                discountEl.innerText = `-$${discount.toFixed(2)}`;
            } else {
                discountRow.style.display = 'none';
            }

            totalEl.innerText = `$${grandTotal.toFixed(2)}`;
        }

        function selectDeliverySpeed(card, fee) {
            document.querySelectorAll('.delivery-option-card').forEach(c => c.classList.remove('active'));
            card.classList.add('active');
            priorityFee = fee;

            const priorityRow = document.getElementById('chk-priority-row');
            if (fee > 0) {
                priorityRow.style.display = 'flex';
            } else {
                priorityRow.style.display = 'none';
            }
            renderCheckoutSummary();
        }

        function switchPayment(type, tab) {
            document.querySelectorAll('.payment-tab').forEach(t => t.classList.remove('active'));
            tab.classList.add('active');

            document.querySelectorAll('.payment-panel').forEach(p => p.classList.remove('active'));
            const targetPanel = document.getElementById(`panel-${type}`);
            if (targetPanel) targetPanel.classList.add('active');

            selectedPaymentMethod = tab.innerText.replace(/[^\w\s]/gi, '').trim();
        }

        function applyCheckoutCoupon() {
            const input = document.getElementById('chk-coupon-input');
            const feedback = document.getElementById('coupon-feedback');
            const code = input.value.trim().toUpperCase();

            feedback.style.display = 'block';

            if (code === 'CRAVEFIRST') {
                Cart.setPromo(code, 0, 10.00); // $10 fixed off
                feedback.style.color = '#27ae60';
                feedback.innerText = '✓ Promo applied: $10.00 discount!';
            } else if (code === 'SAVE5') {
                Cart.setPromo(code, 0, 5.00);
                feedback.style.color = '#27ae60';
                feedback.innerText = '✓ Promo applied: $5.00 discount!';
            } else if (code === 'FREEDEL') {
                Cart.setPromo(code, 0, 0);
                feedback.style.color = '#27ae60';
                feedback.innerText = '✓ Promo applied: Free delivery unlocked!';
            } else {
                feedback.style.color = '#e74c3c';
                feedback.innerText = '✕ Invalid promo code. Try CRAVEFIRST or SAVE5';
            }

            renderCheckoutSummary();
        }

        function handlePlaceOrder(e) {
            e.preventDefault();
            const items = Cart.get();
            if (!items || items.length === 0) {
                alert('Please add items to your cart before placing an order.');
                return;
            }

            const orderId = 'CRV-' + Math.floor(100000 + Math.random() * 900000);
            const address = document.getElementById('chk-address').value;
            const city = document.getElementById('chk-city').value;
            const fullAddress = address + ', ' + city;
            const name = document.getElementById('chk-name').value;
            const phone = document.getElementById('chk-phone').value;
            const notes = document.getElementById('chk-notes').value;

            const subtotal = Cart.getSubtotal();
            const baseDelivery = Cart.getDeliveryFee();
            const discount = Cart.getDiscount();
            const tax = Cart.getTax();
            const grandTotal = Math.max(0, subtotal + baseDelivery + priorityFee + tax - discount);

            const orderData = {
                orderId: orderId,
                date: new Date().toISOString(),
                status: 'Preparing',
                estimatedMinutes: priorityFee > 0 ? 18 : 25,
                customer: { name, phone, address: fullAddress, notes },
                items: items,
                paymentMethod: selectedPaymentMethod,
                pricing: {
                    subtotal: subtotal.toFixed(2),
                    delivery: baseDelivery.toFixed(2),
                    tax: tax.toFixed(2),
                    discount: discount.toFixed(2),
                    total: grandTotal.toFixed(2)
                }
            };

            // Save to active order and history
            localStorage.setItem('crave_active_order', JSON.stringify(orderData));

            let history = [];
            try {
                history = JSON.parse(localStorage.getItem('crave_orders_history')) || [];
            } catch(e) {}
            history.unshift(orderData);
            localStorage.setItem('crave_orders_history', JSON.stringify(history));

            // Clear current cart
            Cart.clear();

            // Redirect to live order tracking page
            const target = (typeof Cart !== 'undefined' && Cart.getRoute) ? Cart.getRoute('orders') : 'orders.html';
            window.location.href = `${target}?order_id=${orderId}&status=confirmed`;
        }
    </script>
</body>
</html>
