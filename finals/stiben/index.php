<?php
/**
 * The Literary Nook - Bookstore Management System
 * File: index.php (Homepage / Landing Page)
 * 
 * This is the main entry point of the website.
 * It displays the homepage with navigation, hero banner, featured books, and footer.
 * 
 * NOTE: Database connection is handled via XAMPP's MySQL (localhost).
 * To change DB settings later, go to /includes/db.php (to be created).
 * For now, all data below is hardcoded as placeholder content.
 */

// -------------------------------------------------------
// PLACEHOLDER: Simulated "is user logged in?" check.
// In the real system, this will check the session after DB login.
// Replace this with: $is_logged_in = isset($_SESSION['customer_id']);
// -------------------------------------------------------
$is_logged_in = false;
$customer_name = ""; // Will come from $_SESSION['customer_name'] later

// -------------------------------------------------------
// PLACEHOLDER: Hardcoded featured books for display.
// In the real system, this will be fetched from the books table in MySQL.
// SQL example: SELECT * FROM books WHERE is_featured = 1 LIMIT 8;
// -------------------------------------------------------
$featured_books = [
    ["title" => "The Midnight Library", "author" => "Matt Haig",         "price" => 549.00, "badge" => "Bestseller", "img" => "placeholder_book.jpg"],
    ["title" => "Lessons in Chemistry", "author" => "Bonnie Garmus",     "price" => 620.00, "badge" => "New",        "img" => "placeholder_book.jpg"],
    ["title" => "Tomorrow, and Tomorrow", "author" => "Gabrielle Zevin", "price" => 590.00, "badge" => "",           "img" => "placeholder_book.jpg"],
    ["title" => "Iron Flame",            "author" => "Rebecca Yarros",   "price" => 750.00, "badge" => "Sale",       "img" => "placeholder_book.jpg"],
    ["title" => "Happy Place",           "author" => "Emily Henry",      "price" => 480.00, "badge" => "",           "img" => "placeholder_book.jpg"],
    ["title" => "Fourth Wing",           "author" => "Rebecca Yarros",   "price" => 720.00, "badge" => "Bestseller", "img" => "placeholder_book.jpg"],
    ["title" => "Demon Copperhead",      "author" => "Barbara Kingsolver","price" => 610.00, "badge" => "",           "img" => "placeholder_book.jpg"],
    ["title" => "Intermezzo",            "author" => "Sally Rooney",     "price" => 530.00, "badge" => "New",        "img" => "placeholder_book.jpg"],
];

// Page title for this page — read by includes/header.php
$page_title = "The Literary Nook";
?>
<?php require 'includes/header.php'; ?>


<!-- ============================================================
     HERO BANNER
     Large promotional carousel area.
     For now it's a single static banner.
     PLACEHOLDER: Add JS slideshow or PHP-driven CMS banners later.
     See: Section 6 Reporting > Promotional Alerts for tie-in
     ============================================================ -->
<section class="hero">
    <div class="hero__slide">
        <!-- PLACEHOLDER: Replace hero__bg with a real banner image -->
        <!-- img src="assets/placeholder_banner.jpg" would go inside .hero__image -->
        <div class="hero__image">
            <img src="assets/placeholder_banner.jpg" alt="Featured Collection Banner" onerror="this.style.display='none'">
        </div>
        <div class="hero__content">
            <span class="hero__eyebrow">Featured Collection</span>
            <h1 class="hero__title">Summer<br>Reads</h1>
            <p class="hero__subtitle">Collection</p>
            <a href="collections.php" class="btn btn--dark">SHOP NOW</a>
        </div>
    </div>

    <!-- Carousel nav dots — will need JS to become functional -->
    <div class="hero__dots">
        <?php for ($i = 0; $i < 6; $i++): ?>
            <span class="hero__dot <?php echo $i === 0 ? 'hero__dot--active' : ''; ?>"></span>
        <?php endfor; ?>
    </div>

    <!-- Carousel arrow buttons — wired to JS later -->
    <button class="hero__arrow hero__arrow--prev" aria-label="Previous slide">&#10094;</button>
    <button class="hero__arrow hero__arrow--next" aria-label="Next slide">&#10095;</button>
</section><!-- /hero -->


<!-- ============================================================
     FEATURED BOOKS SECTION
     Displays a grid of featured/highlighted books.
     Pulled from $featured_books array above (hardcoded for now).
     In the real system: fetched from 'books' table WHERE is_featured = 1
     See: Section 2.1 Book Catalog > Book management
     ============================================================ -->
<section class="section featured-books">
    <div class="container">
        <div class="section__header">
            <h2 class="section__title">Featured Books</h2>
            <a href="books.php" class="section__link">View All <i class="fas fa-chevron-right fa-xs"></i></a>
        </div>

        <div class="book-grid">
            <?php foreach ($featured_books as $book): ?>
                <!-- Individual book card -->
                <div class="book-card">

                    <!-- Book cover image -->
                    <div class="book-card__image-wrap">
                        <!-- PLACEHOLDER: src points to a placeholder image -->
                        <!-- In production: src="assets/covers/<?= $book['img'] ?>" -->
                        <img
                            src="assets/<?php echo htmlspecialchars($book['img']); ?>"
                            alt="<?php echo htmlspecialchars($book['title']); ?>"
                            class="book-card__image"
                            onerror="this.src='assets/placeholder_book.jpg'; this.onerror=null;"
                        >

                        <!-- Badge (Bestseller / New / Sale) — conditionally shown -->
                        <?php if (!empty($book['badge'])): ?>
                            <span class="book-card__badge book-card__badge--<?php echo strtolower($book['badge']); ?>">
                                <?php echo $book['badge']; ?>
                            </span>
                        <?php endif; ?>

                        <!-- Quick-add overlay button -->
                        <!-- PLACEHOLDER: Will POST to cart.php with book_id in the real system -->
                        <div class="book-card__overlay">
                            <button class="btn btn--primary btn--sm">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Book info below the cover -->
                    <div class="book-card__info">
                        <h3 class="book-card__title"><?php echo htmlspecialchars($book['title']); ?></h3>
                        <p class="book-card__author"><?php echo htmlspecialchars($book['author']); ?></p>
                        <p class="book-card__price">Php <?php echo number_format($book['price'], 2); ?></p>
                    </div>

                </div><!-- /book-card -->
            <?php endforeach; ?>
        </div><!-- /book-grid -->
    </div><!-- /container -->
</section><!-- /featured-books -->


<!-- ============================================================
     PROMOTIONAL BANNER STRIP
     A full-width strip for highlighting a campaign or category.
     PLACEHOLDER: Image and text will come from a CMS or settings table.
     ============================================================ -->
<section class="promo-strip">
    <div class="promo-strip__inner">
        <div class="promo-strip__text">
            <h2 class="promo-strip__title">New Arrivals</h2>
            <p class="promo-strip__sub">Fresh titles added every week</p>
            <a href="new.php" class="btn btn--outline">Explore Now</a>
        </div>
        <!-- PLACEHOLDER: background image set via CSS class or inline style later -->
    </div>
</section><!-- /promo-strip -->


<!-- ============================================================
     BESTSELLERS SECTION
     Same structure as featured books but filtered by bestseller flag.
     PLACEHOLDER: In production — SELECT * FROM books WHERE is_bestseller = 1
     ============================================================ -->
<section class="section bestsellers">
    <div class="container">
        <div class="section__header">
            <h2 class="section__title">Bestsellers</h2>
            <a href="bestsellers.php" class="section__link">View All <i class="fas fa-chevron-right fa-xs"></i></a>
        </div>

        <!-- Reusing the same book-grid layout for consistency -->
        <div class="book-grid">
            <?php
            // PLACEHOLDER: Showing first 4 from the same array as a demo.
            // In production this will be a separate DB query for bestsellers.
            $bestsellers_display = array_slice($featured_books, 0, 4);
            foreach ($bestsellers_display as $book): ?>
                <div class="book-card">
                    <div class="book-card__image-wrap">
                        <img
                            src="assets/<?php echo htmlspecialchars($book['img']); ?>"
                            alt="<?php echo htmlspecialchars($book['title']); ?>"
                            class="book-card__image"
                            onerror="this.src='assets/placeholder_book.jpg'; this.onerror=null;"
                        >
                        <div class="book-card__overlay">
                            <button class="btn btn--primary btn--sm">Add to Cart</button>
                        </div>
                    </div>
                    <div class="book-card__info">
                        <h3 class="book-card__title"><?php echo htmlspecialchars($book['title']); ?></h3>
                        <p class="book-card__author"><?php echo htmlspecialchars($book['author']); ?></p>
                        <p class="book-card__price">Php <?php echo number_format($book['price'], 2); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section><!-- /bestsellers -->


<?php require 'includes/footer.php'; ?>


<!-- ============================================================
     SIMPLE INLINE JAVASCRIPT
     Bare-bones cart interaction placeholder.
     In production: cart.js will handle AJAX add-to-cart with session/DB sync.
     ============================================================ -->
<script>
    // PLACEHOLDER: Add-to-cart button click handler
    // In production this will POST to cart.php via fetch() or form submit
    document.querySelectorAll('.btn--primary').forEach(function(btn) {
        if (btn.textContent.trim() === 'Add to Cart') {
            btn.addEventListener('click', function() {
                // Temporary visual feedback — replace with real cart logic later
                btn.textContent = 'Added!';
                btn.style.background = '#28a745';
                setTimeout(function() {
                    btn.textContent = 'Add to Cart';
                    btn.style.background = '';
                }, 1200);
            });
        }
    });

    // PLACEHOLDER: Hero carousel dot interaction (cosmetic only for now)
    document.querySelectorAll('.hero__dot').forEach(function(dot, i) {
        dot.addEventListener('click', function() {
            document.querySelectorAll('.hero__dot').forEach(d => d.classList.remove('hero__dot--active'));
            dot.classList.add('hero__dot--active');
            // Real slide switching will go here once multiple slides are added
        });
    });
</script>

</body>
</html>
