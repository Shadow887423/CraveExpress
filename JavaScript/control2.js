/**
 * CraveExpress - control2.js
 * Handles menu item addition, category tab filtering/scrolling, restaurant customization, and sidebar sync.
 */

document.addEventListener('DOMContentLoaded', () => {
    // 1. Hook up all "+ Add" buttons to Cart engine
    const addButtons = document.querySelectorAll('.add-btn');

    addButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            const itemCard = button.closest('.menu-item');
            if (!itemCard) return;

            const name = itemCard.querySelector('h3') ? itemCard.querySelector('h3').innerText.trim() : 'Menu Item';
            const priceText = itemCard.querySelector('.price') ? itemCard.querySelector('.price').innerText : '$0';
            const price = parseFloat(priceText.replace(/[^0-9.]/g, '')) || 0;
            const imgEl = itemCard.querySelector('img');
            const image = imgEl ? imgEl.src : '';
            const restaurantTitle = document.querySelector('.banner-overlay h1') ? document.querySelector('.banner-overlay h1').innerText.trim() : 'The Urban Grill';

            Cart.add({
                name,
                price,
                image,
                restaurant: restaurantTitle,
                quantity: 1
            });
        });
    });

    // 2. Category Tab Switching
    const categoryTabs = document.querySelectorAll('.category-tabs button:not(.filters-btn)');
    const menuSections = document.querySelectorAll('.menu-section');

    categoryTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const category = tab.innerText.trim();

            // If it's a direct link to slides or another page, let default or handle:
            if (tab.hasAttribute('data-category')) {
                const targetCat = tab.getAttribute('data-category');
                
                categoryTabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');

                if (targetCat === 'all') {
                    menuSections.forEach(s => s.style.display = '');
                } else {
                    menuSections.forEach(s => {
                        const secCat = s.getAttribute('data-category');
                        if (secCat === targetCat) {
                            s.style.display = '';
                            s.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        } else {
                            s.style.display = 'none';
                        }
                    });
                }
            }
        });
    });

    // 3. Checkout button redirection
    const checkoutBtn = document.querySelector('.checkout-btn');
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', () => {
            if (Cart.getCount() === 0) {
                alert('Your order basket is empty! Please add some delicious items first.');
                return;
            }
            window.location.href = 'checkout.php';
        });
    }

    // Initial render of cart sidebar
    Cart.render();
});