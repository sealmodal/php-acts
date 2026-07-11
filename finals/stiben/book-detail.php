<?php
/**
 * The Literary Nook - Bookstore Management System
 * File: book-detail.php (Single Book Detail Page)
 *
 * Displays full details of one book.
 * Reached by clicking a book card: book-detail.php?id=1
 *
 * Features:
 *   - Book cover (placeholder), title, author, price, format, stock status
 *   - Lorem ipsum description
 *   - Quantity selector
 *   - Add to Cart button — requires login, redirects to login.php if not signed in
 *   - Add to Wishlist button — same login requirement
 *   - Breadcrumb navigation: Home > Books > [Title]
 *
 * PLACEHOLDER: Book data comes from includes/books-data.php.
 * In production: SELECT * FROM books WHERE id = ?
 */

session_start();

// Load centralized book data
require 'includes/books-data.php';

// -------------------------------------------------------
// LOOK UP THE BOOK
// Reads ?id= from the URL and finds the matching book.
// If the ID is missing or invalid, redirects to books.php.
// -------------------------------------------------------
$book_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$book    = find_book_by_id($books, $book_id);

// If no book found, send the user back to the catalog
if (!$book) {
    header('Location: books.php');
    exit;
}

// -------------------------------------------------------
// ADD TO CART HANDLER
// Triggered when the Add to Cart form is submitted.
// LOGIN GATE: if not signed in, redirect to login.php
// PLACEHOLDER: Stores item in $_SESSION['cart'] as an array.
// In production: INSERT INTO cart_items (customer_id, book_id, qty) VALUES (?, ?, ?)
// -------------------------------------------------------
$cart_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {

    // Check if user is logged in — if not, send to login page
    if (!isset($_SESSION['customer_id'])) {
        header('Location: login.php?redirect=book-detail.php?id=' . $book_id);
        exit;
    }

    // User is logged in — add to session cart
    $qty = max(1, (int)($_POST['quantity'] ?? 1));

    // Initialize cart array if it doesn't exist yet
    $_SESSION['cart'] = $_SESSION['cart'] ?? [];

    // Check if this book is already in the cart — if so, increase qty
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] === $book['id']) {
            $item['qty'] += $qty;
            $found = true;
            break;
        }
    }
    unset($item); // clean up reference from foreach

    // Book not in cart yet — add as a new entry
    if (!$found) {
        $_SESSION['cart'][] = [
            'id'     => $book['id'],
            'title'  => $book['title'],
            'author' => $book['author'],
            'price'  => $book['price'],
            'img'    => $book['img'],
            'qty'    => $qty,
        ];
    }

    $cart_message = 'added_to_cart';
}

// -------------------------------------------------------
// ADD TO WISHLIST HANDLER
// Same login gate as Add to Cart.
// PLACEHOLDER: Stores in $_SESSION['wishlist'].
// In production: INSERT INTO wishlist (customer_id, book_id) VALUES (?, ?)
// -------------------------------------------------------
$wishlist_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_wishlist'])) {

    // Check if user is logged in — if not, send to login page
    if (!isset($_SESSION['customer_id'])) {
        header('Location: login.php?redirect=book-detail.php?id=' . $book_id);
        exit;
    }

    // Initialize wishlist array if it doesn't exist yet
    $_SESSION['wishlist'] = $_SESSION['wishlist'] ?? [];

    // Check if this book is already in the wishlist
    $already_in_wishlist = false;
    foreach ($_SESSION['wishlist'] as $witem) {
        if ($witem['id'] === $book['id']) {
            $already_in_wishlist = true;
            break;
        }
    }

    if (!$already_in_wishlist) {
        $_SESSION['wishlist'][] = [
            'id'     => $book['id'],
            'title'  => $book['title'],
            'author' => $book['author'],
            'price'  => $book['price'],
            'img'    => $book['img'],
        ];
        $wishlist_message = 'added_to_wishlist';
    } else {
        $wishlist_message = 'already_in_wishlist';
    }
}

// Page title — read by includes/header.php
$page_title = htmlspecialchars($book['title']) . " - The Literary Nook";
?>
<?php require 'includes/header.php'; ?>


<!-- ============================================================
     BOOK DETAIL PAGE CONTENT
     ============================================================ -->
<main class="detail-page">
    <div class="container">

        <!-- ====================================================
             BREADCRUMB NAVIGATION
             Home > Books > [Book Title]
             Helps users know where they are and navigate back.
             ==================================================== -->
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="index.php" class="breadcrumb__link">Home</a>
            <span class="breadcrumb__sep">/</span>
            <a href="books.php" class="breadcrumb__link">Books</a>
            <span class="breadcrumb__sep">/</span>
            <span class="breadcrumb__current">
                <?php
                // Truncate long titles in the breadcrumb so it doesn't overflow
                $short_title = strlen($book['title']) > 40
                    ? substr($book['title'], 0, 40) . '...'
                    : $book['title'];
                echo htmlspecialchars($short_title);
                ?>
            </span>
        </nav>

        <!-- ====================================================
             MAIN DETAIL LAYOUT
             Left: cover image | Right: book info + actions
             ==================================================== -->
        <div class="detail-layout">

            <!-- LEFT: Book Cover Image -->
            <div class="detail-cover">
                <!-- PLACEHOLDER: placeholder_book.jpg used until real covers are uploaded via admin CRUD -->
                <img
                    src="assets/<?php echo htmlspecialchars($book['img']); ?>"
                    alt="<?php echo htmlspecialchars($book['title']); ?>"
                    class="detail-cover__img"
                    onerror="this.src='assets/placeholder_book.jpg'; this.onerror=null;"
                >

                <!-- Thumbnail strip — placeholder for multiple cover images -->
                <!-- PLACEHOLDER: In production these would be additional uploaded images -->
                <div class="detail-cover__thumbs">
                    <div class="detail-cover__thumb detail-cover__thumb--active">
                        <img src="assets/<?php echo htmlspecialchars($book['img']); ?>"
                             alt="Cover front"
                             onerror="this.src='assets/placeholder_book.jpg'; this.onerror=null;">
                    </div>
                    <div class="detail-cover__thumb">
                        <img src="assets/<?php echo htmlspecialchars($book['img']); ?>"
                             alt="Cover back"
                             onerror="this.src='assets/placeholder_book.jpg'; this.onerror=null;">
                    </div>
                </div>
            </div>

            <!-- RIGHT: Book Info and Action Forms -->
            <div class="detail-info">

                <!-- Badge -->
                <?php if (!empty($book['badge'])): ?>
                    <span class="book-card__badge book-card__badge--<?php echo strtolower($book['badge']); ?> detail-badge">
                        <?php echo $book['badge']; ?>
                    </span>
                <?php endif; ?>

                <!-- Title and Author -->
                <h1 class="detail-title"><?php echo htmlspecialchars($book['title']); ?></h1>
                <p class="detail-author">By <?php echo htmlspecialchars($book['author']); ?></p>

                <!-- Book metadata row: format, publisher, year -->
                <div class="detail-meta">
                    <span><strong>Format:</strong> <?php echo htmlspecialchars($book['format']); ?></span>
                    <span><strong>Publisher:</strong> <?php echo htmlspecialchars($book['publisher']); ?></span>
                    <span><strong>Year:</strong> <?php echo $book['year']; ?></span>
                    <span><strong>ISBN:</strong> <?php echo htmlspecialchars($book['isbn']); ?></span>
                </div>

                <!-- Price -->
                <p class="detail-price">Php <?php echo number_format($book['price'], 2); ?></p>

                <!-- Stock status indicator -->
                <?php if ($book['stock'] > 5): ?>
                    <p class="detail-stock detail-stock--in">
                        <i class="fas fa-check-circle"></i> In Stock
                    </p>
                <?php elseif ($book['stock'] > 0): ?>
                    <p class="detail-stock detail-stock--low">
                        <i class="fas fa-exclamation-circle"></i> Only <?php echo $book['stock']; ?> left!
                    </p>
                <?php else: ?>
                    <p class="detail-stock detail-stock--out">
                        <i class="fas fa-times-circle"></i> Out of Stock
                    </p>
                <?php endif; ?>

                <!-- ============================================
                     FEEDBACK MESSAGES
                     Shown after Add to Cart or Add to Wishlist.
                     ============================================ -->
                <?php if ($cart_message === 'added_to_cart'): ?>
                    <div class="detail-feedback detail-feedback--success">
                        <i class="fas fa-check-circle"></i>
                        Added to your cart! <a href="cart.php">View Cart</a>
                    </div>
                <?php endif; ?>

                <?php if ($wishlist_message === 'added_to_wishlist'): ?>
                    <div class="detail-feedback detail-feedback--success">
                        <i class="fas fa-heart"></i>
                        Added to your wishlist! <a href="wishlist.php">View Wishlist</a>
                    </div>
                <?php elseif ($wishlist_message === 'already_in_wishlist'): ?>
                    <div class="detail-feedback detail-feedback--info">
                        <i class="fas fa-info-circle"></i>
                        This book is already in your <a href="wishlist.php">wishlist</a>.
                    </div>
                <?php endif; ?>

                <!-- ============================================
                     ADD TO CART FORM
                     Quantity selector + Add to Cart button.
                     If not logged in: redirects to login.php
                     If logged in: adds to $_SESSION['cart']
                     ============================================ -->
                <?php if ($book['stock'] > 0): ?>
                    <form method="POST" action="book-detail.php?id=<?php echo $book['id']; ?>" class="detail-actions">

                        <!-- Quantity selector: minus / number input / plus -->
                        <div class="qty-selector">
                            <button type="button" class="qty-selector__btn" id="qtyMinus" aria-label="Decrease quantity">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input
                                type="number"
                                name="quantity"
                                id="qtyInput"
                                value="1"
                                min="1"
                                max="<?php echo $book['stock']; ?>"
                                class="qty-selector__input"
                            >
                            <button type="button" class="qty-selector__btn" id="qtyPlus" aria-label="Increase quantity">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>

                        <!-- Add to Cart button -->
                        <!-- If not logged in, PHP handler above redirects to login.php -->
                        <button type="submit" name="add_to_cart" class="btn btn--primary btn--lg">
                            <i class="fas fa-shopping-cart"></i> ADD TO CART
                        </button>

                    </form>
                <?php endif; ?>

                <!-- ============================================
                     ADD TO WISHLIST FORM
                     Separate form so it submits independently from cart.
                     Same login gate as Add to Cart above.
                     ============================================ -->
                <form method="POST" action="book-detail.php?id=<?php echo $book['id']; ?>" class="detail-wishlist-form">
                    <button type="submit" name="add_to_wishlist" class="btn btn--outline-dark btn--wishlist">
                        <i class="fas fa-heart"></i> Add to Wishlist
                    </button>
                </form>

                <!-- Divider -->
                <hr class="detail-divider">

                <!-- ============================================
                     BOOK DESCRIPTION
                     Lorem ipsum placeholder — will be real copy
                     once admin CRUD is built and books are edited.
                     ============================================ -->
                <div class="detail-description">
                    <h2 class="detail-description__title">About this Book</h2>
                    <p><?php echo htmlspecialchars($book['description']); ?></p>
                </div>

            </div><!-- /detail-info -->
        </div><!-- /detail-layout -->

    </div><!-- /container -->
</main><!-- /detail-page -->


<?php require 'includes/footer.php'; ?>


<!-- ============================================================
     JS: Quantity selector +/- buttons
     Increments or decrements the number input.
     Respects the min=1 and max=stock limits.
     ============================================================ -->
<script>
    const qtyInput = document.getElementById('qtyInput');
    const qtyMinus = document.getElementById('qtyMinus');
    const qtyPlus  = document.getElementById('qtyPlus');

    if (qtyInput && qtyMinus && qtyPlus) {
        const max = parseInt(qtyInput.getAttribute('max')) || 99;

        qtyMinus.addEventListener('click', function () {
            const current = parseInt(qtyInput.value) || 1;
            if (current > 1) qtyInput.value = current - 1;
        });

        qtyPlus.addEventListener('click', function () {
            const current = parseInt(qtyInput.value) || 1;
            if (current < max) qtyInput.value = current + 1;
        });
    }

    // Thumbnail switcher — clicking a thumb highlights it (cosmetic only for now)
    document.querySelectorAll('.detail-cover__thumb').forEach(function(thumb) {
        thumb.addEventListener('click', function() {
            document.querySelectorAll('.detail-cover__thumb').forEach(t => t.classList.remove('detail-cover__thumb--active'));
            thumb.classList.add('detail-cover__thumb--active');
        });
    });
</script>

</body>
</html>
