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
    <title>Help Center & Support | CraveExpress</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Design/design1.css">
    <link rel="stylesheet" href="Design/common.css">
    <style>
        .help-hero {
            background: linear-gradient(135deg, #1f1f1f 0%, #2d130a 100%);
            color: white;
            padding: 60px 10%;
            text-align: center;
        }
        .help-search-box {
            max-width: 600px;
            margin: 25px auto 0;
            position: relative;
        }
        .help-search-box input {
            width: 100%;
            padding: 16px 20px 16px 50px;
            border-radius: 30px;
            border: none;
            font-size: 1rem;
            outline: none;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            box-sizing: border-box;
        }
        .help-search-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.2rem;
            color: #888;
        }
        .help-container {
            padding: 50px 10%;
            max-width: 1100px;
            margin: 0 auto;
        }
        .help-topics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 50px;
        }
        .help-topic-card {
            background: white;
            border: 1px solid #eee;
            border-radius: 16px;
            padding: 25px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: var(--shadow-soft);
        }
        .help-topic-card:hover {
            transform: translateY(-4px);
            border-color: var(--primary-orange);
        }
        .help-topic-icon {
            font-size: 2.2rem;
            margin-bottom: 12px;
            display: block;
        }
        .faq-accordion-item {
            background: white;
            border: 1px solid #eee;
            border-radius: 12px;
            margin-bottom: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        }
        .faq-question {
            padding: 20px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 600;
            font-size: 1rem;
            color: #222;
        }
        .faq-question:hover {
            color: var(--primary-orange);
        }
        .faq-answer {
            display: none;
            padding: 0 20px 20px 20px;
            color: #555;
            line-height: 1.6;
            font-size: 0.95rem;
            border-top: 1px solid #f9f9f9;
        }
        .faq-accordion-item.open .faq-answer {
            display: block;
        }
        .faq-accordion-item.open .faq-arrow {
            transform: rotate(180deg);
        }
        .faq-arrow {
            transition: transform 0.2s;
        }
        .contact-support-split {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-top: 50px;
            background: white;
            border-radius: 20px;
            padding: 35px;
            border: 1px solid #eee;
            box-shadow: var(--shadow-soft);
        }
        .chat-sim-messages {
            height: 220px;
            overflow-y: auto;
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 12px;
            background: #fafafa;
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 12px;
        }
        .chat-msg {
            padding: 8px 14px;
            border-radius: 12px;
            font-size: 0.85rem;
            max-width: 80%;
            line-height: 1.4;
        }
        .chat-bot {
            background: #fff;
            border: 1px solid #eee;
            align-self: flex-start;
        }
        .chat-user {
            background: var(--primary-orange);
            color: white;
            align-self: flex-end;
        }
        @media (max-width: 768px) {
            .contact-support-split {
                grid-template-columns: 1fr;
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
            <a href="help.php" class="active">Help</a>
            <a href="#" class="cart-icon" id="cart-icon-btn" title="View Cart">🛒 <span id="cart-count">0</span></a>
            <a href="profile_settings.php" class="profile-icon" title="<?php echo htmlspecialchars($userName); ?>">👤</a>
        </div>
    </nav>

    <!-- Hero Search -->
    <header class="help-hero">
        <span style="color: var(--accent-yellow); font-weight: 700; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1px;">24/7 Customer Care</span>
        <h1 style="font-size: 2.6rem; margin: 10px 0 15px 0;">How can we assist you today?</h1>
        <p style="color: #bbb; max-width: 550px; margin: 0 auto; font-size: 1rem;">Find instant answers to common questions about your orders, deliveries, and payment.</p>
        
        <div class="help-search-box">
            <span class="help-search-icon">🔍</span>
            <input type="text" id="faq-search-input" placeholder="Search keywords: 'refund', 'courier', 'cancel', 'promo'...">
        </div>
    </header>

    <main class="help-container">
        <!-- Topic Categories -->
        <div class="help-topics-grid">
            <div class="help-topic-card" onclick="filterFaqByTopic('delivery')">
                <span class="help-topic-icon">🚚</span>
                <strong style="display: block; font-size: 1rem; margin-bottom: 4px;">Deliveries & Speed</strong>
                <small style="color: #777;">ETAs, couriers, address changes</small>
            </div>

            <div class="help-topic-card" onclick="filterFaqByTopic('payments')">
                <span class="help-topic-icon">💳</span>
                <strong style="display: block; font-size: 1rem; margin-bottom: 4px;">Payments & Refunds</strong>
                <small style="color: #777;">Receipts, vouchers, chargebacks</small>
            </div>

            <div class="help-topic-card" onclick="filterFaqByTopic('orders')">
                <span class="help-topic-icon">🍔</span>
                <strong style="display: block; font-size: 1rem; margin-bottom: 4px;">Orders & Menus</strong>
                <small style="color: #777;">Missing items, dietary notes, prep</small>
            </div>

            <div class="help-topic-card" onclick="filterFaqByTopic('account')">
                <span class="help-topic-icon">👤</span>
                <strong style="display: block; font-size: 1rem; margin-bottom: 4px;">Account & Points</strong>
                <small style="color: #777;">Passwords, rewards, security</small>
            </div>
        </div>

        <!-- FAQ Section -->
        <div style="margin-bottom: 40px;">
            <h2 style="font-size: 1.8rem; margin: 0 0 8px 0;">Frequently Asked Questions</h2>
            <p style="color: #666; margin: 0 0 25px 0;">Click on a question to reveal answers from our support knowledge base.</p>

            <div class="faq-list" id="faq-items-list">
                <!-- FAQ 1 -->
                <div class="faq-accordion-item" data-topic="delivery">
                    <div class="faq-question">
                        <span>How fast is CraveExpress food delivery?</span>
                        <span class="faq-arrow">▼</span>
                    </div>
                    <div class="faq-answer">
                        Our smart routing algorithm pairs you with the closest courier and kitchen. Average delivery times range from <strong>15 to 30 minutes</strong> depending on kitchen prep time and proximity. You can track your rider in real time on our <a href="orders.php" style="color: var(--primary-orange);">Live Order Tracking</a> page.
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="faq-accordion-item" data-topic="payments">
                    <div class="faq-question">
                        <span>How do I redeem promo vouchers like CRAVEFIRST?</span>
                        <span class="faq-arrow">▼</span>
                    </div>
                    <div class="faq-answer">
                        At the <a href="checkout.php" style="color: var(--primary-orange);">Checkout Page</a>, locate the "Promo code" input in the right Order Summary box. Enter <strong>CRAVEFIRST</strong> and click <strong>Apply</strong> to immediately enjoy $10 off your first order! Other valid codes include <strong>SAVE5</strong> ($5 off) and <strong>FREEDEL</strong> (Free Delivery).
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="faq-accordion-item" data-topic="orders">
                    <div class="faq-question">
                        <span>What should I do if an item is missing or incorrect?</span>
                        <span class="faq-arrow">▼</span>
                    </div>
                    <div class="faq-answer">
                        We apologize if an item was left out or prepared incorrectly. Please reach out immediately through our 24/7 Live Chat below or call our support hotline. We will either arrange an express redelivery or issue a full instant credit to your account.
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="faq-accordion-item" data-topic="orders">
                    <div class="faq-question">
                        <span>Can I cancel or modify my order after placing it?</span>
                        <span class="faq-arrow">▼</span>
                    </div>
                    <div class="faq-answer">
                        Because kitchens begin cooking fresh ingredients right away, cancellations are permitted within <strong>2 minutes</strong> of placing your order. After the kitchen accepts the ticket, modifications should be made directly through the courier or via live support chat.
                    </div>
                </div>

                <!-- FAQ 5 -->
                <div class="faq-accordion-item" data-topic="payments">
                    <div class="faq-question">
                        <span>What payment methods are supported?</span>
                        <span class="faq-arrow">▼</span>
                    </div>
                    <div class="faq-answer">
                        We accept all major Credit and Debit cards (Visa, Mastercard, American Express), Cash on Delivery (COD), GCash / Mobile Wallets, and PayPal. All payments are encrypted with bank-level SSL security.
                    </div>
                </div>

                <!-- FAQ 6 -->
                <div class="faq-accordion-item" data-topic="account">
                    <div class="faq-question">
                        <span>How do I update my delivery address or phone number?</span>
                        <span class="faq-arrow">▼</span>
                    </div>
                    <div class="faq-answer">
                        You can update your personal information and add multiple delivery addresses anytime in your <a href="profile_settings.php" style="color: var(--primary-orange);">Account Settings</a> under the Profile and Addresses tabs.
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Support & Live Chat Simulator -->
        <div class="contact-support-split">
            <!-- Left: Contact Form -->
            <div>
                <h3 style="margin: 0 0 8px 0; font-size: 1.3rem;">Send us a Message</h3>
                <p style="color: #666; font-size: 0.9rem; margin: 0 0 20px 0;">Our priority support team responds within 15 minutes.</p>

                <form onsubmit="handleSupportSubmit(event)">
                    <div class="input-group" style="margin-bottom: 12px;">
                        <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:4px;">Your Name</label>
                        <input type="text" value="<?php echo htmlspecialchars($userName); ?>" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; box-sizing:border-box;">
                    </div>
                    <div class="input-group" style="margin-bottom: 12px;">
                        <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:4px;">Order ID (optional)</label>
                        <input type="text" placeholder="e.g. CRV-492108" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; box-sizing:border-box;">
                    </div>
                    <div class="input-group" style="margin-bottom: 15px;">
                        <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:4px;">How can we help?</label>
                        <textarea rows="4" placeholder="Describe the issue with your meal, courier, or payment..." required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; box-sizing:border-box; font-family:inherit;"></textarea>
                    </div>
                    <button type="submit" style="background:var(--primary-orange); color:white; border:none; padding:12px 25px; border-radius:8px; font-weight:700; cursor:pointer;">Submit Ticket</button>
                </form>
            </div>

            <!-- Right: Interactive Live Chat Bot Simulator -->
            <div style="display: flex; flex-direction: column;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                    <div>
                        <h3 style="margin: 0; font-size: 1.3rem;">Live CraveBot</h3>
                        <small style="color: #27ae60; font-weight: 600;">● Online & ready to assist</small>
                    </div>
                    <span style="font-size: 1.8rem;">🤖</span>
                </div>

                <div class="chat-sim-messages" id="chat-messages-container">
                    <div class="chat-msg chat-bot">
                        Hello! 👋 I'm CraveBot, your 24/7 assistant. How can I assist you with your CraveExpress order today?
                    </div>
                </div>

                <form onsubmit="handleChatSubmit(event)" style="display: flex; gap: 8px;">
                    <input type="text" id="chat-input" placeholder="Type a message (e.g. 'Where is my food?')..." style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 6px; outline: none;">
                    <button type="submit" style="background: #333; color: white; border: none; padding: 0 18px; border-radius: 6px; cursor: pointer; font-weight: 600;">Send</button>
                </form>
            </div>
        </div>
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
        // Accordion Toggle
        document.querySelectorAll('.faq-question').forEach(q => {
            q.addEventListener('click', () => {
                const item = q.parentElement;
                item.classList.toggle('open');
            });
        });

        // Search in FAQ
        const faqSearch = document.getElementById('faq-search-input');
        const faqItems = document.querySelectorAll('.faq-accordion-item');

        if (faqSearch) {
            faqSearch.addEventListener('input', () => {
                const query = faqSearch.value.trim().toLowerCase();
                faqItems.forEach(item => {
                    const text = item.textContent.toLowerCase();
                    if (!query || text.includes(query)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        }

        function filterFaqByTopic(topic) {
            faqItems.forEach(item => {
                if (item.getAttribute('data-topic') === topic) {
                    item.style.display = 'block';
                    item.classList.add('open');
                } else {
                    item.style.display = 'none';
                    item.classList.remove('open');
                }
            });
            document.getElementById('faq-items-list').scrollIntoView({ behavior: 'smooth' });
        }

        function handleSupportSubmit(e) {
            e.preventDefault();
            alert('Support Ticket Submitted! Our agent Carlos has received your message and will update you via email within 15 minutes.');
            e.target.reset();
        }

        function handleChatSubmit(e) {
            e.preventDefault();
            const input = document.getElementById('chat-input');
            const container = document.getElementById('chat-messages-container');
            const message = input.value.trim();
            if (!message) return;

            // Add user message
            const userMsg = document.createElement('div');
            userMsg.className = 'chat-msg chat-user';
            userMsg.innerText = message;
            container.appendChild(userMsg);
            input.value = '';

            container.scrollTop = container.scrollHeight;

            // Bot response after short delay
            setTimeout(() => {
                const botMsg = document.createElement('div');
                botMsg.className = 'chat-msg chat-bot';

                const lower = message.toLowerCase();
                if (lower.includes('where') || lower.includes('track') || lower.includes('food')) {
                    botMsg.innerHTML = 'You can track your active courier live on our <a href="orders.php" style="color:var(--primary-orange);font-weight:bold;">Live Orders Map</a>! Estimated arrival is ~18 minutes.';
                } else if (lower.includes('promo') || lower.includes('voucher') || lower.includes('discount')) {
                    botMsg.innerHTML = 'You can use promo code <strong>CRAVEFIRST</strong> on the checkout page for $10 off your order!';
                } else if (lower.includes('refund') || lower.includes('cancel')) {
                    botMsg.innerHTML = 'Orders can be modified or cancelled within 2 minutes of placement. For missing items, we will credit your balance instantly!';
                } else {
                    botMsg.innerHTML = "Thanks for asking! I've noted down your query regarding: '" + message + "'. A representative is also monitoring this thread.";
                }

                container.appendChild(botMsg);
                container.scrollTop = container.scrollHeight;
            }, 600);
        }
    </script>
</body>
</html>
