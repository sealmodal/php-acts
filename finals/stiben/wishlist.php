<?php
/**
 * The Literary Nook - Bookstore Management System
 * File: wishlist.php (Customer Wishlist Page)
 *
 * Shows all books the signed-in customer has saved to their wishlist.
 * Requires login — redirects to login.php if not signed in.
 *
 * Features:
 *   - Grid of saved books with cover, title, author, price
 *   - Move to Cart button (adds to cart, keeps in wishlist)
 *   - Remove from Wishlist button
 *
 * PLACEHOLDER: Wishlist data lives in $_SESSION['wishlist'] for now.
 * In production: SELECT * FROM wishlist WHERE customer_id = ?
 */

session_start();

// -------------------------------------------------------
// LOGIN GATE
// Wishlist is a private, logged-in feature.
// -------------------------------------------------------
if (!isset($_SESSION['customer_id'])) {
    header('Location: login.php');
    exit;
}

// -------------------------------------------------------
// REMOVE FROM WISHLIST HANDLER
// Triggered when the remove button is clicked.
// PLACEHOLDER: In production: DELETE FROM wishlist WHERE customer_id = ? AND book_id = ?
// -------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_wishlist'])) {
    $remove_id = (int)$_POST['remove_wishlist'];
    $_SESSION['wishlist'] = array_filter(
        $_SESSION['wishlist'] ?? [],
        fn($item) => $item['id'] !== $remove_id
    );
    $_SESSION['wishlist'] = array_values($_SESSION['wishlist']);
}

// -------------------------------------------------------
// MOVE TO CART HANDLER
// Adds the wishlist item to the cart session, keeps it in wishlist.
// PLACEHOLDER: In production: INSERT INTO cart_items ... + keep wishlist row
// -------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['move_to_cart'])) {
    $move_id = (int)$_POST['move_to_cart'];

    // Find the item in the wishlist
    $move_item = null;
    foreach ($_SESSION['wishlist'] ?? [] as $witem) {
        if ($witem['id'] === $move_id) {
            $move_item = $witem;
            break;
        }
    }

    if ($move_item) {
        $_SESSION['cart'] = $_SESSION['cart'] ?? [];

        // Check if already in cart
        $in_cart = false;
        foreach ($_SESSION['cart'] as &$citem) {
            if ($citem['id'] === $move_item['id']) {
                $citem['qty']++;
                $in_cart = true;
                break;
            }
        }
        unset($citem);

        if (!$in_cart) {
            $_SESSION['cart'][] = [
                'id'     => $move_item['id'],
                'title'  => $move_item['title'],
                'author' => $move_item['author'],
                'price'  => $move_item['price'],
                'img'    => $move_item['img'],
                'qty'    => 1,
            ];
        }
    }
}

// Get wishlist from session — default to empty array
$wishlist = $_SESSION['wishlist'] ?? [];

// Page title — read by includes/header.php
$page_title = "My Wishlist - The Literary Nook";
?>
<?php require 'includes/header.php'; ?>


<!-- ============================================================
     WISHLIST PAGE CONTENT
     ============================================================ -->
<main class="wishlist-page">
    <div class="container">

        <h1 class="page-title">My Wishlist</h1>

        <?php if (empty($wishlist)): ?>

            <!-- ================================================
                 EMPTY WISHLIST STATE
                 ================================================ -->
            <div class="cart-empty">
                <i class="fas fa-heart"></i>
                <h2>Your wishlist is empty</h2>
                <p>Save books you love and come back to them anytime.</p>
                <a href="books.php" class="btn btn--primary">BROWSE BOOKS</a>
            </div>

        <?php else: ?>

            <!-- ================================================
                 WISHLIST GRID
                 Same card style as books.php for visual consistency.
                 Each card has Move to Cart and Remove buttons.
                 ================================================ -->
            <div class="wishlist-grid">
                <?php foreach ($wishlist as $item): ?>
                    <div class="wishlist-card">

                        <!-- Book cover — links to detail page -->
                        <a href="book-detail.php?id=<?php echo $item['id']; ?>" class="wishlist-card__img-wrap">
                            <img
                                src="assets/<?php echo htmlspecialchars($item['img']); ?>"
                                alt="<?php echo htmlspecialchars($item['title']); ?>"
                                class="wishlist-card__img"
                                onerror="this.src='assets/placeholder_book.jpg'; this.onerror=null;"
                            >
                        </a>

                        <!-- Book info -->
                        <div class="wishlist-card__info">
                            <h3 class="wishlist-card__title">
                                <a href="book-detail.php?id=<?php echo $item['id']; ?>">
                                    <?php echo htmlspecialchars($item['title']); ?>
                                </a>
                            </h3>
                            <p class="wishlist-card__author"><?php echo htmlspecialchars($item['author']); ?></p>
                            <p class="wishlist-card__price">Php <?php echo number_format($item['price'], 2); ?></p>
                        </div>

                        <!-- Action buttons: Move to Cart + Remove -->
                        <div class="wishlist-card__actions">

                            <!-- Move to Cart — adds to $_SESSION['cart'] -->
                            <form method="POST" action="wishlist.php">
                                <input type="hidden" name="move_to_cart" value="<?php echo $item['id']; ?>">
                                <button type="submit" class="btn btn--primary btn--sm">
                                    <i class="fas fa-shopping-cart"></i> Add to Cart
                                </button>
                            </form>

                            <!-- Remove from Wishlist -->
                            <form method="POST" action="wishlist.php">
                                <input type="hidden" name="remove_wishlist" value="<?php echo $item['id']; ?>">
                                <button type="submit" class="btn btn--outline-dark btn--sm">
                                    <i class="fas fa-times"></i> Remove
                                </button>
                            </form>

                        </div>

                    </div><!-- /wishlist-card -->
                <?php endforeach; ?>
            </div><!-- /wishlist-grid -->

            <!-- Link to keep shopping -->
            <div class="wishlist-footer">
                <a href="books.php" class="btn btn--outline-dark">
                    <i class="fas fa-arrow-left fa-xs"></i> Continue Shopping
                </a>
            </div>

        <?php endif; ?>

    </div><!-- /container -->
</main><!-- /wishlist-page -->


<?php require 'includes/footer.php'; ?>

</body>
</html>
