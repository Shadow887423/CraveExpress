/**
 * CraveExpress - control1.js
 * Handles landing page interactions, category navigation, search redirection, and hero actions.
 */

document.addEventListener('DOMContentLoaded', () => {
    const searchBtn = document.getElementById('find-food-btn');
    const addressInput = document.getElementById('address-input');
    const categoryCards = document.querySelectorAll('.category-card');

    function getRestaurantRoute() {
        return (typeof Cart !== 'undefined' && Cart.getRoute) ? Cart.getRoute('restaurants') : 
               (window.location.pathname.endsWith('.html') || window.location.protocol === 'file:' || window.location.hostname.endsWith('github.io') ? 'restaurants.html' : 'restaurants.php');
    }

    // 1. Handle Search Button & Enter Key
    function performSearch() {
        const query = addressInput ? addressInput.value.trim() : '';
        const target = getRestaurantRoute();
        if (query) {
            window.location.href = `${target}?search=${encodeURIComponent(query)}`;
        } else {
            window.location.href = target;
        }
    }

    if (searchBtn) {
        searchBtn.addEventListener('click', performSearch);
    }

    if (addressInput) {
        addressInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                performSearch();
            }
        });
    }

    // 2. Handle Category Clicks - Navigate to Restaurants with category filter
    categoryCards.forEach(card => {
        card.addEventListener('click', () => {
            const category = card.getAttribute('data-category');
            if (category) {
                const target = getRestaurantRoute();
                window.location.href = `${target}?category=${encodeURIComponent(category)}`;
            }
        });
    });

    // 3. Nav link active states
    const navLinks = document.querySelectorAll('.nav-links a:not(.cart-icon):not(.profile-icon)');
    const currentPath = window.location.pathname.split('/').pop() || 'index.html';

    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href === currentPath || (currentPath === '' && (href === 'index.html' || href === 'index.php'))) {
            navLinks.forEach(item => item.classList.remove('active'));
            link.classList.add('active');
        }
    });
});