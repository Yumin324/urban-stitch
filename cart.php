<?php
$pageTitle = 'Shopping Cart';
include 'includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <h1>Your Shopping Cart</h1>
        <p>Review your items before checkout</p>
    </div>
</section>

<section class="cart-section">
    <div class="container">
        <div class="cart-content">
            <div class="cart-items" id="cartItems">
                <p class="empty-cart">Your cart is empty. <a href="shop.php">Continue Shopping</a></p>
            </div>

            <div class="cart-summary" id="cartSummary" style="display: none;">
                <h2>Order Summary</h2>
                <div class="summary-row">
                    <span>Subtotal:</span>
                    <span id="subtotal">LKR 0.00</span>
                </div>
                <div class="summary-row">
                    <span>Shipping:</span>
                    <span>LKR 500.00</span>
                </div>
                <div class="summary-row total">
                    <span>Total:</span>
                    <span id="total">LKR 0.00</span>
                </div>
                <button class="btn btn-primary btn-block" onclick="checkout()">Proceed to Checkout</button>
                <button class="btn btn-secondary btn-block" onclick="clearCart()">Clear Cart</button>
            </div>
        </div>
    </div>
</section>

<div id="checkoutModal" class="modal">
    <div class="modal-content">
        <span class="modal-close" onclick="closeCheckoutModal()">&times;</span>
        <h2>Checkout</h2>
        <form id="checkoutForm" class="checkout-form">
            <div class="form-group">
                <label for="customerName">Full Name *</label>
                <input type="text" id="customerName" required>
            </div>
            <div class="form-group">
                <label for="customerEmail">Email *</label>
                <input type="email" id="customerEmail" required>
            </div>
            <div class="form-group">
                <label for="customerPhone">Phone *</label>
                <input type="tel" id="customerPhone" required>
            </div>
            <div class="form-group">
                <label for="customerAddress">Delivery Address *</label>
                <textarea id="customerAddress" rows="3" required></textarea>
            </div>
            <div class="checkout-summary">
                <p><strong>Total Amount: <span id="checkoutTotal">LKR 0.00</span></strong></p>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Place Order</button>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
