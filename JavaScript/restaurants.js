/**
 * CraveExpress - restaurants.js
 * Handles live search, cuisine filters, price filters, grid/list view toggles, and URL param parsing.
 */

document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('restaurant-search-input') || document.querySelector('.nav-search input');
    const cuisineCheckboxes = document.querySelectorAll('.filter-group input[type="checkbox"]');
    const priceButtons = document.querySelectorAll('.price-options button');
    const viewButtons = document.querySelectorAll('.view-toggle button');
    const restaurantGrid = document.querySelector('.restaurant-grid');
    const restaurantCards = document.querySelectorAll('.res-card');
    const resultCountEl = document.getElementById('restaurant-count');
    const claimBtn = document.querySelector('.claim-btn');

    let selectedPrice = null;

    // 1. Parse URL Parameters on Load (?category=... or ?search=...)
    const urlParams = new URLSearchParams(window.location.search);
    const categoryParam = urlParams.get('category');
    const searchParam = urlParams.get('search');

    if (categoryParam) {
        cuisineCheckboxes.forEach(cb => {
            const labelText = cb.parentElement.textContent.trim().toLowerCase();
            const target = categoryParam.toLowerCase();
            if (labelText.includes(target) || target.includes(labelText)) {
                cb.checked = true;
            } else {
                cb.checked = false;
            }
        });
    }

    if (searchParam && searchInput) {
        searchInput.value = searchParam;
    }

    // 2. Filter Function
    function filterRestaurants() {
        const query = searchInput ? searchInput.value.trim().toLowerCase() : '';
        
        // Active cuisines
        const activeCuisines = [];
        cuisineCheckboxes.forEach(cb => {
            if (cb.checked) {
                activeCuisines.push(cb.getAttribute('data-cuisine') || cb.parentElement.textContent.trim().toLowerCase());
            }
        });

        let visibleCount = 0;

        restaurantCards.forEach(card => {
            const title = (card.querySelector('.res-title h3') ? card.querySelector('.res-title h3').textContent : '').toLowerCase();
            const tags = (card.querySelector('.res-info p') ? card.querySelector('.res-info p').textContent : '').toLowerCase();
            const price = (card.querySelector('.price-tag') ? card.querySelector('.price-tag').textContent.trim() : '');
            const cardCuisines = (card.getAttribute('data-cuisine') || tags).toLowerCase();

            // Match search
            const matchesSearch = !query || title.includes(query) || tags.includes(query);

            // Match cuisine (if none selected, show all)
            const matchesCuisine = activeCuisines.length === 0 || activeCuisines.some(c => cardCuisines.includes(c.toLowerCase()));

            // Match price
            const matchesPrice = !selectedPrice || price === selectedPrice;

            if (matchesSearch && matchesCuisine && matchesPrice) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (resultCountEl) {
            resultCountEl.innerText = `${visibleCount} restaurant${visibleCount === 1 ? '' : 's'} available`;
        }

        // Show empty state if nothing found
        let noResults = document.getElementById('no-restaurants-found');
        if (visibleCount === 0) {
            if (!noResults) {
                noResults = document.createElement('div');
                noResults.id = 'no-restaurants-found';
                noResults.style.cssText = 'grid-column: 1 / -1; text-align: center; padding: 60px 20px; background: white; border-radius: 16px; border: 1px solid #eee;';
                noResults.innerHTML = `
                    <span style="font-size: 3rem; display: block; margin-bottom: 10px;">🔍</span>
                    <h3>No restaurants match your filters</h3>
                    <p style="color: #777;">Try clearing some filters or searching for something else.</p>
                    <button id="reset-filters-btn" style="background: var(--primary-orange); color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 600; margin-top: 10px;">Reset All Filters</button>
                `;
                restaurantGrid.appendChild(noResults);
                document.getElementById('reset-filters-btn').addEventListener('click', resetFilters);
            }
            noResults.style.display = 'block';
        } else if (noResults) {
            noResults.style.display = 'none';
        }
    }

    function resetFilters() {
        if (searchInput) searchInput.value = '';
        cuisineCheckboxes.forEach(cb => cb.checked = false);
        priceButtons.forEach(btn => btn.classList.remove('selected'));
        selectedPrice = null;
        filterRestaurants();
    }

    // 3. Event Listeners for Live Filtering
    if (searchInput) {
        searchInput.addEventListener('input', filterRestaurants);
    }

    cuisineCheckboxes.forEach(cb => {
        cb.addEventListener('change', filterRestaurants);
    });

    priceButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            if (btn.classList.contains('selected')) {
                btn.classList.remove('selected');
                selectedPrice = null;
            } else {
                priceButtons.forEach(b => b.classList.remove('selected'));
                btn.classList.add('selected');
                selectedPrice = btn.innerText.trim();
            }
            filterRestaurants();
        });
    });

    // 4. Grid vs List View Toggle
    viewButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            viewButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            if (btn.innerText.toLowerCase().includes('list')) {
                restaurantGrid.classList.add('list-view');
            } else {
                restaurantGrid.classList.remove('list-view');
            }
        });
    });

    // 5. Claim Offer Button
    if (claimBtn) {
        claimBtn.addEventListener('click', () => {
            Cart.setPromo('FREEDEL', 0, 0); // Free delivery
            Cart.showToast('🎉 Free delivery applied to your order!');
            claimBtn.innerText = 'Offer Claimed ✓';
            claimBtn.style.background = '#27ae60';
            claimBtn.disabled = true;
        });
    }

    // Initial filter execution
    filterRestaurants();
});
