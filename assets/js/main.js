let cart = [];

function loadCart() {
    const savedCart = localStorage.getItem('urbanStitchCart');
    if(savedCart) {
        cart = JSON.parse(savedCart);
    }
    updateCartCount();
    if(window.location.pathname.includes('cart.php')) {
        displayCart();
    }
}

function saveCart() {
    localStorage.setItem('urbanStitchCart', JSON.stringify(cart));
    updateCartCount();
}

function updateCartCount() {
    const count = cart.reduce((total, item) => total + item.quantity, 0);
    const cartCountElements = document.querySelectorAll('.cart-count');
    cartCountElements.forEach(el => {
        el.textContent = count;
        el.style.display = count > 0 ? 'inline-block' : 'none';
    });
}

function addToCart(id, name, price, imageUrl) {
    const existingItem = cart.find(item => item.id === id);
    
    if(existingItem) {
        existingItem.quantity++;
    } else {
        cart.push({
            id: id,
            name: name,
            price: price,
            imageUrl: imageUrl,
            quantity: 1
        });
    }
    
    saveCart();
    showNotification('Product added to cart!');
}

function removeFromCart(id) {
    cart = cart.filter(item => item.id !== id);
    saveCart();
    displayCart();
    showNotification('Product removed from cart');
}

function updateQuantity(id, quantity) {
    const item = cart.find(item => item.id === id);
    if(item) {
        item.quantity = parseInt(quantity);
        if(item.quantity <= 0) {
            removeFromCart(id);
        } else {
            saveCart();
            displayCart();
        }
    }
}

function displayCart() {
    const cartItemsDiv = document.getElementById('cartItems');
    const cartSummaryDiv = document.getElementById('cartSummary');
    
    if(cart.length === 0) {
        cartItemsDiv.innerHTML = '<p class="empty-cart">Your cart is empty. <a href="shop.php">Continue Shopping</a></p>';
        cartSummaryDiv.style.display = 'none';
        return;
    }
    
    cartSummaryDiv.style.display = 'block';
    
    let html = '';
    let subtotal = 0;
    
    cart.forEach(item => {
        const itemTotal = item.price * item.quantity;
        subtotal += itemTotal;
        
        html += `
            <div class="cart-item">
                <img src="${item.imageUrl}" alt="${item.name}">
                <div class="cart-item-details">
                    <h3>${item.name}</h3>
                    <p class="cart-item-price">LKR ${item.price.toFixed(2)}</p>
                </div>
                <div class="cart-item-quantity">
                    <button onclick="updateQuantity(${item.id}, ${item.quantity - 1})">-</button>
                    <input type="number" value="${item.quantity}" onchange="updateQuantity(${item.id}, this.value)" min="1">
                    <button onclick="updateQuantity(${item.id}, ${item.quantity + 1})">+</button>
                </div>
                <div class="cart-item-total">
                    <p>LKR ${itemTotal.toFixed(2)}</p>
                    <button class="btn-remove" onclick="removeFromCart(${item.id})">Remove</button>
                </div>
            </div>
        `;
    });
    
    cartItemsDiv.innerHTML = html;
    
    const shipping = 500;
    const total = subtotal + shipping;
    
    document.getElementById('subtotal').textContent = 'LKR ' + subtotal.toFixed(2);
    document.getElementById('total').textContent = 'LKR ' + total.toFixed(2);
}

function clearCart() {
    if(confirm('Are you sure you want to clear your cart?')) {
        cart = [];
        saveCart();
        displayCart();
        showNotification('Cart cleared');
    }
}

function checkout() {
    if(cart.length === 0) {
        alert('Your cart is empty');
        return;
    }
    
    const subtotal = cart.reduce((total, item) => total + (item.price * item.quantity), 0);
    const shipping = 500;
    const total = subtotal + shipping;
    
    document.getElementById('checkoutTotal').textContent = 'LKR ' + total.toFixed(2);
    document.getElementById('checkoutModal').style.display = 'flex';
}

function closeCheckoutModal() {
    document.getElementById('checkoutModal').style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function() {
    loadCart();
    
    const checkoutForm = document.getElementById('checkoutForm');
    if(checkoutForm) {
        checkoutForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const orderData = {
                customer_name: document.getElementById('customerName').value,
                customer_email: document.getElementById('customerEmail').value,
                customer_phone: document.getElementById('customerPhone').value,
                customer_address: document.getElementById('customerAddress').value,
                items: cart
            };
            
            fetch('api/place_order.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(orderData)
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    alert('Order placed successfully! Order ID: #' + data.order_id);
                    cart = [];
                    saveCart();
                    closeCheckoutModal();
                    window.location.href = 'index.php';
                } else {
                    alert('Error placing order: ' + data.message);
                }
            })
            .catch(error => {
                alert('Error placing order. Please try again.');
            });
        });
    }
    
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    if(mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function() {
            const navMenu = document.querySelector('.nav-menu');
            navMenu.classList.toggle('active');
        });
    }
});

function showNotification(message) {
    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.add('show');
    }, 100);
    
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 2000);
}

window.onclick = function(event) {
    const modal = document.getElementById('checkoutModal');
    if (event.target == modal) {
        closeCheckoutModal();
    }
}

// Newsletter Form Handler
document.addEventListener('DOMContentLoaded', function() {
    const newsletterForm = document.getElementById('newsletterForm');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = this.querySelector('input[type="email"]').value;
            
            // Add smooth animation
            const button = this.querySelector('button');
            const originalText = button.textContent;
            button.textContent = '? Subscribed!';
            button.style.background = 'var(--success)';
            button.style.color = 'white';
            
            showNotification('Thank you for subscribing to our newsletter!');
            
            // Reset form after delay
            setTimeout(() => {
                this.reset();
                button.textContent = originalText;
                button.style.background = '';
                button.style.color = '';
            }, 3000);
        });
    }
});

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Add scroll animation to elements
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('fade-in-visible');
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

document.querySelectorAll('.feature-card, .testimonial-card, .category-card, .product-card').forEach(el => {
    observer.observe(el);
});

// Scroll to Top Button
const scrollTopBtn = document.getElementById('scrollTop');
if (scrollTopBtn) {
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            scrollTopBtn.classList.add('visible');
        } else {
            scrollTopBtn.classList.remove('visible');
        }
    });
    
    scrollTopBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

// Add loading animation to images
document.querySelectorAll('img').forEach(img => {
    img.addEventListener('load', function() {
        this.style.opacity = '1';
    });
});

// Mobile menu toggle enhancement
const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
const navMenu = document.querySelector('.nav-menu');

if (mobileMenuToggle && navMenu) {
    mobileMenuToggle.addEventListener('click', function() {
        navMenu.classList.toggle('active');
        this.classList.toggle('active');
    });
    
    // Close mobile menu when clicking outside
    document.addEventListener('click', function(e) {
        if (!navMenu.contains(e.target) && !mobileMenuToggle.contains(e.target)) {
            navMenu.classList.remove('active');
            mobileMenuToggle.classList.remove('active');
        }
    });
}
