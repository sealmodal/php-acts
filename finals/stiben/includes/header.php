<?php
/**
 * The Literary Nook - Bookstore Management System
 * File: includes/header.php (Shared Site Header)
 *
 * Included at the top of every page.
 * Outputs everything from <!DOCTYPE html> down through the closing </nav>
 * (top bar, main header, and category navbar) — so it doesn't have to be
 * copy-pasted into every file.
 *
 * Expects these OPTIONAL variables to be set by the including page
 * BEFORE requiring this file:
 *   $page_title    - string, used in <title>. Defaults to "The Literary Nook".
 *   $is_logged_in  - bool, whether to show the customer name or Login/Register link.
 *   $customer_name - string, shown in header actions when $is_logged_in is true.
 *
 * NOTE: session_start() is called here so every page automatically has
 * session access without repeating it in each file. The status check makes
 * it safe even if a page (like login.php) already started the session
 * earlier — e.g. because it needed $_SESSION before this include happens.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Defaults so pages that don't set these variables still work correctly.
$page_title    = $page_title    ?? "The Literary Nook";
$is_logged_in  = $is_logged_in  ?? false;
$customer_name = $customer_name ?? "";

// -------------------------------------------------------
// PLACEHOLDER: Hardcoded nav categories.
// In the real system these can be fetched from a 'categories' table.
// -------------------------------------------------------
$nav_links = ["Books", "Non Books", "Bestsellers", "Collections", "Book Reviews", "New!", "Pre-Orders", "Sale"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Page title — changes per page in the real system -->
    <title><?php echo htmlspecialchars($page_title); ?></title>

    <!-- Google Fonts: Orelega One (headings) + Quicksand (body) -->
    <link href="https://fonts.googleapis.com/css2?family=Orelega+One&family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Shared stylesheet — same css/styles.css used across all pages -->
    <link rel="stylesheet" href="css/styles.css">

</head>
<body>

<!-- ============================================================
     TOP BAR
     The thin strip above the main header.
     Shows free shipping info + utility links (Blog, Store Locator, etc.)
     ============================================================ -->
<div class="top-bar">
    <div class="top-bar__left">
        <!-- Promotional message — can be pulled from a CMS/settings table later -->
        Free shipping for minimum order of <strong>Php799</strong>.
    </div>
    <div class="top-bar__right">
        <!-- Utility links — static for now, can become dynamic CMS links -->
        <a href="#">Bulk Purchase</a>
        <a href="#">Discount Card</a>
        <a href="#">Blog</a>
        <a href="#">Store Locator</a>
        <a href="#">Help <i class="fas fa-chevron-down fa-xs"></i></a>
    </div>
</div><!-- /top-bar -->


<!-- ============================================================
     MAIN HEADER
     Contains: Logo | Search Bar | User actions (Login, Wishlist, Cart)
     ============================================================ -->
<header class="header">
    <div class="header__inner">

        <!-- Logo — links to homepage -->
        <a href="index.php" class="header__logo">
            <img src="assets/Literary_Nook.png" alt="The Literary Nook">
        </a>

        <!-- Search bar — form action points to search.php (to be created) -->
        <form class="header__search" action="search.php" method="GET">
            <input type="text" name="q" placeholder="Search The Literary Nook" />
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>

        <!-- Right-side icon actions: Login, Wishlist, Cart -->
        <div class="header__actions">

            <!-- Login / Profile link -->
            <!-- PLACEHOLDER: If logged in, show customer name; if not, show Login/Register -->
            <?php if ($is_logged_in): ?>
                <a href="account.php" class="action-link">
                    <i class="fas fa-user"></i>
                    <span><?php echo htmlspecialchars($customer_name); ?></span>
                </a>
            <?php else: ?>
                <a href="login.php" class="action-link">
                    <i class="fas fa-user"></i>
                    <span>Login/Register</span>
                </a>
            <?php endif; ?>

            <!-- Wishlist link — requires login in the full system -->
            <!-- See: Section 1.2 Customer Profiles > Wishlist -->
            <a href="wishlist.php" class="action-link">
                <i class="fas fa-heart"></i>
                <span>Wishlist</span>
            </a>

            <!-- Cart icon with item count badge -->
            <!-- PLACEHOLDER: Cart count will come from $_SESSION['cart_count'] or DB -->
            <a href="cart.php" class="action-link cart-link">
                <i class="fas fa-shopping-cart"></i>
                <span>Cart</span>
                <!-- Item count badge — 0 for now; will be dynamic -->
                <span class="cart-badge">0</span>
            </a>

        </div><!-- /header__actions -->
    </div><!-- /header__inner -->
</header><!-- /header -->


<!-- ============================================================
     NAVIGATION BAR
     Main category navigation strip — orange background, white text.
     Each link will eventually point to category/filter pages.
     ============================================================ -->
<nav class="navbar">
    <ul class="navbar__list">
        <?php foreach ($nav_links as $link): ?>
            <!-- PLACEHOLDER: href="#" — real links will go to category.php?slug=books etc. -->
            <li class="navbar__item">
                <a href="#" class="navbar__link"><?php echo $link; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav><!-- /navbar -->
