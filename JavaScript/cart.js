/**
 * CraveExpress - Universal Cart Engine
 * Handles persistent cart storage across all pages, drawer UI, quantity changes, and checkout preparation.
 */

const Cart = {
    KEY: 'crave_cart',
    PROMO_KEY: 'crave_promo',

    get() {
        try {
            return JSON.parse(localStorage.getItem(this.KEY)) || [];
        } catch (e) {
            return [];
        }
    },

    save(items) {
        localStorage.setItem(this.KEY, JSON.stringify(items));
        this.render();
    },

    getPromo() {
        try {
            return JSON.parse(localStorage.getItem(this.PROMO_KEY)) || null;
        } catch (e) {
            return null;
        }
    },

    setPromo(code, discountPercent, fixedDiscount) {
        localStorage.setItem(this.PROMO_KEY, JSON.stringify({ code, discountPercent, fixedDiscount }));
        this.render();
    },

    clearPromo() {
        localStorage.removeItem(this.PROMO_KEY);
        this.render();
    },

    add(item) {
        const items = this.get();
        // Match by name if id is not unique
        const id = item.id || item.name.toLowerCase().replace(/[^a-z0-9]/g, '-');
        const existing = items.find(i => i.id === id);

        if (existing) {
            existing.quantity = (existing.quantity || 1) + (item.quantity || 1);
        } else {
            items.push({
                id: id,
                name: item.name,
                price: parseFloat(item.price),
                image: item.image || 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=150',
                restaurant: item.restaurant || 'CraveExpress Restaurant',
                quantity: item.quantity || 1
            });
        }

        this.save(items);
        this.showToast(`Added "${item.name}" to cart! 🍔`);
        this.pulseCartIcon();
    },

    updateQty(id, delta) {
        let items = this.get();
        const item = items.find(i => i.id === id);
        if (item) {
            item.quantity += delta;
            if (item.quantity <= 0) {
                items = items.filter(i => i.id !== id);
            }
            this.save(items);
        }
    },

    remove(id) {
        let items = this.get();
        items = items.filter(i => i.id !== id);
        this.save(items);
        this.showToast('Item removed from cart');
    },

    clear() {
        localStorage.removeItem(this.KEY);
        this.clearPromo();
        this.render();
    },

    getCount() {
        const items = this.get();
        return items.reduce((sum, item) => sum + (item.quantity || 1), 0);
    },

    getSubtotal() {
        const items = this.get();
        return items.reduce((sum, item) => sum + (item.price * (item.quantity || 1)), 0);
    },

    getDeliveryFee() {
        const subtotal = this.getSubtotal();
        if (subtotal <= 0) return 0;
        return subtotal >= 25 ? 0 : 2.99;
    },

    getDiscount() {
        const subtotal = this.getSubtotal();
        const promo = this.getPromo();
        if (!promo || subtotal <= 0) return 0;

        if (promo.fixedDiscount) {
            return Math.min(subtotal, promo.fixedDiscount);
        }
        if (promo.discountPercent) {
            return (subtotal * promo.discountPercent) / 100;
        }
        return 0;
    },

    getTax() {
        const subtotal = this.getSubtotal();
        return subtotal > 0 ? subtotal * 0.08 : 0; // 8% sales tax
    },

    getTotal() {
        const subtotal = this.getSubtotal();
        if (subtotal <= 0) return 0;
        const delivery = this.getDeliveryFee();
        const discount = this.getDiscount();
        const tax = this.getTax();
        return Math.max(0, subtotal + delivery + tax - discount);
    },

    render() {
        const count = this.getCount();
        const subtotal = this.getSubtotal();
        const delivery = this.getDeliveryFee();
        const discount = this.getDiscount();
        const total = this.getTotal();
        const items = this.get();

        // 1. Update all nav cart badges across the page
        document.querySelectorAll('#cart-count, .cart-count-badge').forEach(badge => {
            badge.innerText = count;
            badge.style.display = count > 0 ? 'inline-block' : 'inline-block';
        });

        // 2. Update page-specific sidebar if present (like on urbangrillmenu.php)
        const sidebarCount = document.getElementById('sidebar-count');
        const sidebarItems = document.getElementById('cart-items-container');
        const subtotalEl = document.getElementById('subtotal');
        const totalEl = document.getElementById('total-price');

        if (sidebarCount) sidebarCount.innerText = count;
        if (subtotalEl) subtotalEl.innerText = `$${subtotal.toFixed(2)}`;
        if (totalEl) totalEl.innerText = `$${total.toFixed(2)}`;

        if (sidebarItems) {
            if (items.length === 0) {
                sidebarItems.innerHTML = `
                    <div style="text-align: center; padding: 25px 10px; color: #888;">
                        <span style="font-size: 2.5rem; display: block; margin-bottom: 8px;">🛒</span>
                        <p style="font-size: 0.95rem; margin: 0;">Your basket is empty</p>
                        <small style="color: #aaa;">Click + on any delicious dish to order</small>
                    </div>
                `;
            } else {
                sidebarItems.innerHTML = items.map(item => `
                    <div class="cart-item" data-id="${item.id}">
                        <img src="${item.image}" alt="${item.name}">
                        <div class="cart-item-info">
                            <h4>${item.name}</h4>
                            <div class="qty-controls">
                                <button class="qty-btn" onclick="Cart.updateQty('${item.id}', -1)">-</button>
                                <span>${item.quantity}x</span>
                                <button class="qty-btn" onclick="Cart.updateQty('${item.id}', 1)">+</button>
                            </div>
                        </div>
                        <div class="cart-item-right">
                            <span class="cart-price">$${(item.price * item.quantity).toFixed(2)}</span>
                            <button class="cart-del-btn" onclick="Cart.remove('${item.id}')" title="Remove">✕</button>
                        </div>
                    </div>
                `).join('');
            }
        }

        // 3. Update Global Cart Drawer (if rendered)
        const drawerItems = document.getElementById('drawer-cart-items');
        const drawerSubtotal = document.getElementById('drawer-subtotal');
        const drawerDelivery = document.getElementById('drawer-delivery');
        const drawerDiscount = document.getElementById('drawer-discount');
        const drawerTotal = document.getElementById('drawer-total');

        if (drawerSubtotal) drawerSubtotal.innerText = `$${subtotal.toFixed(2)}`;
        if (drawerDelivery) drawerDelivery.innerText = delivery === 0 ? 'FREE' : `$${delivery.toFixed(2)}`;
        if (drawerDiscount) {
            if (discount > 0) {
                drawerDiscount.parentElement.style.display = 'flex';
                drawerDiscount.innerText = `-$${discount.toFixed(2)}`;
            } else {
                drawerDiscount.parentElement.style.display = 'none';
            }
        }
        if (drawerTotal) drawerTotal.innerText = `$${total.toFixed(2)}`;

        if (drawerItems) {
            if (items.length === 0) {
                drawerItems.innerHTML = `
                    <div class="empty-drawer-cart">
                        <span style="font-size: 3.5rem; display: block; margin-bottom: 12px;">🛍️</span>
                        <h3>Your cart is empty</h3>
                        <p>Explore our menu and add your favorite dishes to get started.</p>
                        <a href="restaurants.php" class="btn-drawer-browse">Browse Restaurants</a>
                    </div>
                `;
            } else {
                drawerItems.innerHTML = items.map(item => `
                    <div class="drawer-item">
                        <img src="${item.image}" alt="${item.name}">
                        <div class="drawer-item-details">
                            <h4>${item.name}</h4>
                            <small class="drawer-item-restaurant">${item.restaurant || 'CraveExpress'}</small>
                            <span class="drawer-item-price">$${(item.price * item.quantity).toFixed(2)}</span>
                        </div>
                        <div class="drawer-qty-group">
                            <button onclick="Cart.updateQty('${item.id}', -1)">-</button>
                            <span>${item.quantity}</span>
                            <button onclick="Cart.updateQty('${item.id}', 1)">+</button>
                        </div>
                    </div>
                `).join('');
            }
        }
    },

    pulseCartIcon() {
        document.querySelectorAll('.cart-icon').forEach(icon => {
            icon.classList.add('cart-bounce');
            setTimeout(() => icon.classList.remove('cart-bounce'), 600);
        });
    },

    showToast(message) {
        let toast = document.getElementById('crave-toast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'crave-toast';
            document.body.appendChild(toast);
        }
        toast.innerText = message;
        toast.className = 'crave-toast show';
        clearTimeout(this._toastTimeout);
        this._toastTimeout = setTimeout(() => {
            toast.className = 'crave-toast';
        }, 3000);
    },

    openDrawer() {
        const drawer = document.getElementById('cart-drawer-overlay');
        if (drawer) {
            drawer.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    },

    closeDrawer() {
        const drawer = document.getElementById('cart-drawer-overlay');
        if (drawer) {
            drawer.classList.remove('active');
            document.body.style.overflow = '';
        }
    },

    setupDrawerUI() {
        if (document.getElementById('cart-drawer-overlay')) return;

        const drawerHtml = `
            <div id="cart-drawer-overlay" class="cart-drawer-overlay">
                <div class="cart-drawer-backdrop" onclick="Cart.closeDrawer()"></div>
                <div class="cart-drawer">
                    <div class="drawer-header">
                        <div class="drawer-title">
                            <h3>Your Crave Cart</h3>
                            <span class="drawer-item-badge"><span id="cart-drawer-count">0</span> items</span>
                        </div>
                        <button class="drawer-close-btn" onclick="Cart.closeDrawer()">✕</button>
                    </div>

                    <div class="drawer-body" id="drawer-cart-items">
                        <!-- Dynamic Cart Items -->
                    </div>

                    <div class="drawer-footer">
                        <div class="drawer-summary">
                            <div class="summary-row">
                                <span>Subtotal</span>
                                <span id="drawer-subtotal">$0.00</span>
                            </div>
                            <div class="summary-row">
                                <span>Estimated Delivery</span>
                                <span id="drawer-delivery">FREE</span>
                            </div>
                            <div class="summary-row promo-row" style="display: none; color: #27ae60;">
                                <span>Promo Discount</span>
                                <span id="drawer-discount">-$0.00</span>
                            </div>
                            <div class="summary-row total-row">
                                <span>Total</span>
                                <span id="drawer-total">$0.00</span>
                            </div>
                        </div>
                        <div class="drawer-actions">
                            <a href="checkout.php" class="btn-drawer-checkout">Proceed to Checkout →</a>
                        </div>
                    </div>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', drawerHtml);

        // Bind clicks on cart icons
        document.querySelectorAll('.cart-icon').forEach(icon => {
            icon.addEventListener('click', (e) => {
                e.preventDefault();
                Cart.openDrawer();
            });
        });
    },

    getRoute(pageName) {
        const isStatic = window.location.pathname.endsWith('.html') ||
                         window.location.protocol === 'file:' ||
                         window.location.hostname.endsWith('github.io') ||
                         window.location.hostname.endsWith('vercel.app') ||
                         window.location.hostname.endsWith('netlify.app');
        return isStatic ? `${pageName}.html` : `${pageName}.php`;
    }
};

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', () => {
    Cart.setupDrawerUI();
    Cart.render();

    // Auto-adapt links for static / GitHub Pages environments
    const isStaticEnv = window.location.pathname.endsWith('.html') ||
                        window.location.protocol === 'file:' ||
                        window.location.hostname.endsWith('github.io');

    if (isStaticEnv) {
        document.querySelectorAll('a[href]').forEach(a => {
            const href = a.getAttribute('href');
            if (href && href.includes('.php')) {
                a.setAttribute('href', href.replace(/\.php(\?|#|$)/, '.html$1'));
            }
        });

        const drawerCheckout = document.querySelector('.btn-drawer-checkout');
        if (drawerCheckout) {
            drawerCheckout.setAttribute('href', 'checkout.html');
        }
    }

    // Hook checkout buttons
    document.querySelectorAll('.checkout-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            if (Cart.get().length === 0) {
                alert('Your cart is empty! Please add some delicious items first.');
                return;
            }
            window.location.href = Cart.getRoute('checkout');
        });
    });
});

