document.addEventListener('DOMContentLoaded', () => {
    // Theme Toggle
const themeToggle = document.getElementById('themeToggle');
const themeIcon = document.getElementById('themeIcon');
const themeText = document.getElementById('themeText');
const html = document.documentElement;

// Check for saved theme preference or default to 'dark'
const currentTheme = localStorage.getItem('theme') || 'dark';
html.setAttribute('data-theme', currentTheme);

// Update icon and text based on current theme
function updateThemeUI(theme) {
    if (theme === 'light') {
        themeIcon.src = 'https://img.icons8.com/ios/50/ffffff/moon-symbol.png';
        themeText.textContent = 'Dark';
    } else {
        themeIcon.src = 'https://img.icons8.com/ios/50/ffffff/sun--v1.png';
        themeText.textContent = 'Light';
    }
}

// Initialize UI
updateThemeUI(currentTheme);

// Toggle theme on click
if (themeToggle) {
    themeToggle.addEventListener('click', () => {
        const newTheme = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
        html.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        updateThemeUI(newTheme);
    });
}

// Scroll Reveal Animation
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

    // Wishlist Toggle
    document.querySelectorAll('.product-card__wishlist').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const img = btn.querySelector('img');
            if (img.src.includes('like--v1')) {
                img.src = 'https://img.icons8.com/ios-filled/50/ff4d4d/like.png';
            } else {
                img.src = 'https://img.icons8.com/ios/50/ffffff/like--v1.png';
            }
        });
    });

    // Sidebar Toggle Logic
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const sidebarClose = document.getElementById('sidebarClose');
    const burgerButtons = document.querySelectorAll('.header__burger');

    const toggleSidebar = () => {
        sidebar.classList.toggle('active');
        sidebarOverlay.classList.toggle('active');
        document.body.classList.toggle('sidebar-open');
    };

    const closeSidebar = () => {
        sidebar.classList.remove('active');
        sidebarOverlay.classList.remove('active');
        document.body.classList.remove('sidebar-open');
    };

    burgerButtons.forEach(btn => {
        btn.addEventListener('click', toggleSidebar);
    });

    sidebarClose.addEventListener('click', closeSidebar);
    sidebarOverlay.addEventListener('click', closeSidebar);

    // Buy Button Toast (Mock)
    document.querySelectorAll('.product-card__buy-btn, .btn-primary, .btn-secondary').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            alert('Действие выполнено!');
        });
    });

    // Product Gallery - Thumbnail Switch
    const mainImage = document.getElementById('mainImage');
    const thumbs = document.querySelectorAll('.thumb');
    
    if (mainImage && thumbs.length > 0) {
        thumbs.forEach(thumb => {
            thumb.addEventListener('mouseenter', () => {
                const newSrc = thumb.querySelector('img').src;
                mainImage.src = newSrc;
                
                thumbs.forEach(t => t.classList.remove('active'));
                thumb.classList.add('active');
            });
        });
    }

    // Product Variants - Switch
    const variants = document.querySelectorAll('.variant');
    if (variants.length > 0) {
        variants.forEach(variant => {
            variant.addEventListener('click', () => {
                const newSrc = variant.querySelector('img').src;
                if (mainImage) mainImage.src = newSrc;
                
                variants.forEach(v => v.classList.remove('active'));
                variant.classList.add('active');
            });
        });
    }

    // Cart Page Logic
    const cartItems = document.querySelectorAll('.cart-card');
    const selectAllCheckbox = document.querySelector('.select-all input[type="checkbox"]');
    
    if (cartItems.length > 0) {
        // Initialize cart data from DOM
        const cartData = Array.from(cartItems).map(card => {
            const priceText = card.querySelector('.current-price').textContent.replace(/[^\d]/g, '');
            const oldPriceText = card.querySelector('.old-price').textContent.replace(/[^\d]/g, '');
            const quantitySpan = card.querySelector('.quantity-control span');
            const buttons = card.querySelectorAll('.quantity-btn');
            
            return {
                element: card,
                price: parseInt(priceText),
                oldPrice: parseInt(oldPriceText),
                quantity: parseInt(quantitySpan.textContent),
                quantitySpan: quantitySpan,
                minusBtn: buttons[0],  // First button is minus
                plusBtn: buttons[1]    // Second button is plus
            };
        });

        // Update totals
        function updateCartTotals() {
            let totalItems = 0;
            let totalPrice = 0;
            let totalOldPrice = 0;

            cartData.forEach(item => {
                totalItems += item.quantity;
                totalPrice += item.price * item.quantity;
                totalOldPrice += item.oldPrice * item.quantity;
            });

            const discount = totalOldPrice - totalPrice;

            // Update summary
            const summaryRows = document.querySelectorAll('.summary-row');
            if (summaryRows.length >= 4) {
                // First row after title (товары)
                summaryRows[0].querySelector('span:first-child').textContent = `Товары (${totalItems})`;
                summaryRows[0].querySelector('span:last-child').textContent = `${totalOldPrice.toLocaleString('ru-RU')} ₽`;
                
                // Second row (скидка)
                summaryRows[1].querySelector('span:last-child').textContent = `-${discount.toLocaleString('ru-RU')} ₽`;
                
                // Total row
                const totalRow = document.querySelector('.summary-row.total span:last-child');
                if (totalRow) totalRow.textContent = `${totalPrice.toLocaleString('ru-RU')} ₽`;
            }
        }

        // Quantity controls
        cartData.forEach(item => {
            item.minusBtn.addEventListener('click', () => {
                if (item.quantity > 1) {
                    item.quantity--;
                    item.quantitySpan.textContent = item.quantity;
                    updateCartTotals();
                }
            });

            item.plusBtn.addEventListener('click', () => {
                item.quantity++;
                item.quantitySpan.textContent = item.quantity;
                updateCartTotals();
            });
        });

        // Select all functionality
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', (e) => {
                const checkboxes = document.querySelectorAll('.cart-card input[type="checkbox"]');
                checkboxes.forEach(cb => cb.checked = e.target.checked);
            });
        }

        // Initial calculation
        updateCartTotals();
    }
});
