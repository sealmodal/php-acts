<?php
/**
 * The Literary Nook - Bookstore Management System
 * File: books.php (Book Catalog / Browsing Page)
 *
 * Shows all available books in a filterable grid.
 * Linked from the "Books" item in the main navbar.
 *
 * Features:
 *   - Genre filter buttons at the top (All, Fiction, Fantasy, etc.)
 *   - Book cards that link to book-detail.php?id=X
 *   - Active genre is highlighted and persists via ?genre= in the URL
 *
 * PLACEHOLDER: All book data comes from includes/books-data.php (hardcoded array).
 * In production, this will be replaced by a MySQL query via XAMPP.
 * Genre filter will also move to a DB query:
 *   SELECT * FROM books WHERE genre = ? (or all if no filter)
 */

// Load the centralized book data and helper functions
require 'includes/books-data.php';

// -------------------------------------------------------
// GENRE FILTER
// Reads ?genre= from the URL to filter the displayed books.
// If no genre param is set, shows all books.
// PLACEHOLDER: In production this becomes a WHERE clause in the SQL query.
// -------------------------------------------------------
$active_genre = $_GET['genre'] ?? 'All';
$genres       = get_genres($books); // get unique genres from the data

// Filter the books array if a specific genre is selected
if ($active_genre !== 'All') {
    $filtered_books = array_filter($books, fn($b) => $b['genre'] === $active_genre);
} else {
    $filtered_books = $books;
}

// Page title — read by includes/header.php
$page_title = "Books - The Literary Nook";
?>
<?php require 'includes/header.php'; ?>


<!-- ============================================================
     CATALOG PAGE CONTENT
     ============================================================ -->
<main class="catalog-page">
    <div class="container">

        <!-- Page heading + book count -->
        <div class="catalog-header">
            <div>
                <h1 class="catalog-title">Books</h1>
                <p class="catalog-count">
                    <?php echo count($filtered_books); ?> title<?php echo count($filtered_books) !== 1 ? 's' : ''; ?>
                    <?php echo $active_genre !== 'All' ? 'in ' . htmlspecialchars($active_genre) : 'available'; ?>
                </p>
            </div>
        </div>

        <!-- ====================================================
             GENRE FILTER BAR
             Pill-style buttons for each genre + an "All" button.
             Clicking one reloads the page with ?genre=X in the URL.
             Active genre is visually highlighted.
             ==================================================== -->
        <div class="genre-filter">
            <!-- "All" button always shown first -->
            <a
                href="books.php"
                class="genre-filter__btn <?php echo $active_genre === 'All' ? 'genre-filter__btn--active' : ''; ?>"
            >All</a>

            <?php foreach ($genres as $genre): ?>
                <a
                    href="books.php?genre=<?php echo urlencode($genre); ?>"
                    class="genre-filter__btn <?php echo $active_genre === $genre ? 'genre-filter__btn--active' : ''; ?>"
                ><?php echo htmlspecialchars($genre); ?></a>
            <?php endforeach; ?>
        </div>

        <!-- ====================================================
             BOOK GRID
             Reuses the same .book-grid and .book-card styles from
             index.php so the homepage and catalog look consistent.
             Each card links to book-detail.php?id=X
             ==================================================== -->
        <?php if (empty($filtered_books)): ?>
            <!-- Empty state — shown if a genre filter returns no results -->
            <div class="catalog-empty">
                <i class="fas fa-book-open"></i>
                <p>No books found in this category.</p>
                <a href="books.php" class="btn btn--primary">View All Books</a>
            </div>
        <?php else: ?>
            <div class="book-grid">
                <?php foreach ($filtered_books as $book): ?>
                    <!-- Entire card is a link to the book detail page -->
                    <a href="book-detail.php?id=<?php echo $book['id']; ?>" class="book-card book-card--link">

                        <div class="book-card__image-wrap">
                            <!-- PLACEHOLDER: All covers use placeholder_book.jpg until
                                 admin CRUD is built and real images are uploaded. -->
                            <img
                                src="assets/<?php echo htmlspecialchars($book['img']); ?>"
                                alt="<?php echo htmlspecialchars($book['title']); ?>"
                                class="book-card__image"
                                onerror="this.src='assets/placeholder_book.jpg'; this.onerror=null;"
                            >

                            <!-- Badge — Bestseller / New / Sale -->
                            <?php if (!empty($book['badge'])): ?>
                                <span class="book-card__badge book-card__badge--<?php echo strtolower($book['badge']); ?>">
                                    <?php echo $book['badge']; ?>
                                </span>
                            <?php endif; ?>

                            <!-- Out of stock overlay -->
                            <?php if ($book['stock'] === 0): ?>
                                <div class="book-card__sold-out">Out of Stock</div>
                            <?php endif; ?>
                        </div>

                        <div class="book-card__info">
                            <h3 class="book-card__title"><?php echo htmlspecialchars($book['title']); ?></h3>
                            <p class="book-card__author"><?php echo htmlspecialchars($book['author']); ?></p>
                            <p class="book-card__format"><?php echo htmlspecialchars($book['format']); ?></p>
                            <p class="book-card__price">Php <?php echo number_format($book['price'], 2); ?></p>
                        </div>

                    </a><!-- /book-card -->
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div><!-- /container -->
</main><!-- /catalog-page -->


<?php require 'includes/footer.php'; ?>

</body>
</html>
