<?php
/**
 * The Literary Nook - Bookstore Management System
 * File: cart.php (Shopping Cart Page)
 *
 * Displays all items the customer has added to their cart.
 * Requires login — redirects to login.php if not signed in.
 *
 * Features:
 *   - Lists cart items with title, author, price, quantity
 *   - Running subtotal
 *   - Remove item button
 *   - Proceed to Checkout button (links to checkout.php — to be built)
 *
 * PLACEHOLDER: Cart data lives in $_SESSION['cart'] for now.
 * In production: SELECT * FROM cart_items WHERE customer_id = ?
 */

session_start();

// -------------------------------------------------------
// LOGIN GATE
// Cart requires a signed-in customer. If not logged in, redirect.
// -------------------------------------------------------
if (!isset($_SESSION['customer_id'])) {
    header('Location: login.php');
    exit;
}

// -------------------------------------------------------
// REMOVE ITEM HANDLER
// Triggered when a "Remove" button is clicked on a cart item.
// Removes the item from $_SESSION['cart'] by its book ID.
// PLACEHOLDER: In production: DELETE FROM cart_items WHERE customer_id = ? AND book_id = ?
// -------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_item'])) {
    $remove_id = (int)$_POST['remove_item'];
    $_SESSION['cart'] = array_filter(
        $_SESSION['cart'] ?? [],
        fn($item) => $item['id'] !== $remove_id
    );
    // Re-index after filter so the array stays clean
    $_SESSION['cart'] = array_values($_SESSION['cart']);
}

// -------------------------------------------------------
// UPDATE QUANTITY HANDLER
// Triggered when quantity is changed inline on the cart page.
// PLACEHOLDER: In production: UPDATE cart_items SET qty = ? WHERE ...
// -------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_qty'])) {
    $update_id  = (int)$_POST['update_id'];
    $update_qty = max(1, (int)$_POST['update_qty']);

    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] === $update_id) {
            $item['qty'] = $update_qty;
            break;
        }
    }
    unset($item);
}

// Get the current cart — default to empty array if nothing added yet
$cart  = $_SESSION['cart'] ?? [];

// Calculate the subtotal across all cart items
$subtotal = 0;
foreach ($cart as $item) {
    $subtotal += $item['price'] * $item['qty'];
}

// PLACEHOLDER: Shipping fee — will be calculated based on address in production
$shipping = $subtotal >= 799 ? 0 : 99;
$total    = $subtotal + $shipping;

// Page title — read by includes/header.php
$page_title = "My Cart - The Literary Nook";
?>
<?php require 'includes/header.php'; ?>


<!-- ============================================================
     CART PAGE CONTENT
     ============================================================ -->
<main class="cart-page">
    <div class="container">

        <h1 class="page-title">My Cart</h1>

        <?php if (empty($cart)): ?>

            <!-- ================================================
                 EMPTY CART STATE
                 ================================================ -->
            <div class="cart-empty">
                <i class="fas fa-shopping-cart"></i>
                <h2>Your cart is empty</h2>
                <p>Browse our collection and add books you love!</p>
                <a href="books.php" class="btn btn--primary">BROWSE BOOKS</a>
            </div>

        <?php else: ?>

            <!-- ================================================
                 CART LAYOUT
                 Left: item list | Right: order summary
                 ================================================ -->
            <div class="cart-layout">

                <!-- LEFT: Cart Items List -->
                <div class="cart-items">

                    <?php foreach ($cart as $item): ?>
                        <div class="cart-item">

                            <!-- Book cover thumbnail -->
                            <div class="cart-item__img">
                                <img
                                    src="assets/<?php echo htmlspecialchars($item['img']); ?>"
                                    alt="<?php echo htmlspecialchars($item['title']); ?>"
                                    onerror="this.src='assets/placeholder_book.jpg'; this.onerror=null;"
                                >
                            </div>

                            <!-- Book title and author -->
                            <div class="cart-item__info">
                                <h3 class="cart-item__title">
                                    <a href="book-detail.php?id=<?php echo $item['id']; ?>">
                                        <?php echo htmlspecialchars($item['title']); ?>
                                    </a>
                                </h3>
                                <p class="cart-item__author"><?php echo htmlspecialchars($item['author']); ?></p>
                                <p class="cart-item__unit-price">Php <?php echo number_format($item['price'], 2); ?> each</p>
                            </div>

                            <!-- Quantity update form -->
                            <form method="POST" action="cart.php" class="cart-item__qty-form">
                                <input type="hidden" name="update_id" value="<?php echo $item['id']; ?>">
                                <div class="qty-selector qty-selector--sm">
                                    <button type="button" class="qty-selector__btn qty-minus" aria-label="Decrease">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input
                                        type="number"
                                        name="update_qty"
                                        value="<?php echo $item['qty']; ?>"
                                        min="1"
                                        class="qty-selector__input"
                                    >
                                    <button type="button" class="qty-selector__btn qty-plus" aria-label="Increase">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <button type="submit" name="update_qty" class="cart-item__update-btn">Update</button>
                            </form>

                            <!-- Line total (price × qty) -->
                            <div class="cart-item__total">
                                Php <?php echo number_format($item['price'] * $item['qty'], 2); ?>
                            </div>

                            <!-- Remove item form -->
                            <form method="POST" action="cart.php" class="cart-item__remove-form">
                                <input type="hidden" name="remove_item" value="<?php echo $item['id']; ?>">
                                <button type="submit" class="cart-item__remove" aria-label="Remove item">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>

                        </div><!-- /cart-item -->
                    <?php endforeach; ?>

                </div><!-- /cart-items -->


                <!-- RIGHT: Order Summary -->
                <div class="cart-summary">
                    <h2 class="cart-summary__title">Order Summary</h2>

                    <div class="cart-summary__row">
                        <span>Subtotal</span>
                        <span>Php <?php echo number_format($subtotal, 2); ?></span>
                    </div>
                    <div class="cart-summary__row">
                        <span>Shipping</span>
                        <span>
                            <?php if ($shipping === 0): ?>
                                <span class="cart-summary__free">FREE</span>
                            <?php else: ?>
                                Php <?php echo number_format($shipping, 2); ?>
                            <?php endif; ?>
                        </span>
                    </div>

                    <?php if ($shipping > 0): ?>
                        <!-- Remind the customer how close they are to free shipping -->
                        <p class="cart-summary__shipping-note">
                            Add Php <?php echo number_format(799 - $subtotal, 2); ?> more for free shipping!
                        </p>
                    <?php endif; ?>

                    <div class="cart-summary__divider"></div>

                    <div class="cart-summary__row cart-summary__row--total">
                        <span>Total</span>
                        <span>Php <?php echo number_format($total, 2); ?></span>
                    </div>

                    <!-- PLACEHOLDER: checkout.php to be built next -->
                    <a href="checkout.php" class="btn btn--primary cart-summary__checkout">
                        PROCEED TO CHECKOUT
                    </a>

                    <a href="books.php" class="cart-summary__continue">
                        <i class="fas fa-arrow-left fa-xs"></i> Continue Shopping
                    </a>
                </div><!-- /cart-summary -->

            </div><!-- /cart-layout -->

        <?php endif; ?>

    </div><!-- /container -->
</main><!-- /cart-page -->


<?php require 'includes/footer.php'; ?>


<!-- ============================================================
     JS: Quantity +/- buttons on cart items
     Same pattern as book-detail.php but for multiple items.
     Auto-submits the form when quantity changes.
     ============================================================ -->
<script>
    // Attach +/- handlers to every qty selector on the page
    document.querySelectorAll('.cart-item__qty-form').forEach(function(form) {
        const input  = form.querySelector('.qty-selector__input');
        const minus  = form.querySelector('.qty-minus');
        const plus   = form.querySelector('.qty-plus');

        if (!input || !minus || !plus) return;

        minus.addEventListener('click', function() {
            const val = parseInt(input.value) || 1;
            if (val > 1) {
                input.value = val - 1;
                form.submit(); // auto-submit to update the session
            }
        });

        plus.addEventListener('click', function() {
            const val = parseInt(input.value) || 1;
            input.value = val + 1;
            form.submit(); // auto-submit to update the session
        });
    });
</script>

</body>
</html>
