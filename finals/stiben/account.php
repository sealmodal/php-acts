<?php
/**
 * The Literary Nook - Bookstore Management System
 * File: account.php (Customer Profile / "Portfolio" Page)
 *
 * Shows a signed-in customer's basic profile info and quick links to
 * other account-related pages.
 *
 * NOTE: session_start() is called here (not just in includes/header.php)
 * because the login gate below must run — and possibly redirect — before
 * any HTML output happens, which is before includes/header.php gets
 * required further down this file.
 *
 * PLACEHOLDER: All data below comes from $_SESSION for now. In production
 * this will be fetched from the customers table using $_SESSION['customer_id']
 * as the lookup key, e.g. SELECT * FROM customers WHERE id = ?
 */

session_start();

// -------------------------------------------------------
// LOGIN GATE
// If nobody is signed in, bounce them to the login page instead.
// This MUST happen before includes/header.php outputs any HTML,
// or header() below would fail with a "headers already sent" error.
// -------------------------------------------------------
if (!isset($_SESSION['customer_id'])) {
    header('Location: login.php');
    exit;
}

// PLACEHOLDER: Falls back to generic text if a field isn't in the session
// (e.g. if someone lands here via the hardcoded test login instead of
// registering fresh). In production these would just be real DB columns.
$customer_name  = $_SESSION['customer_name']  ?? 'Valued Customer';
$customer_email = $_SESSION['customer_email'] ?? 'Not provided';
$member_since   = $_SESSION['member_since']   ?? date('F Y'); // PLACEHOLDER: fake join date

// -------------------------------------------------------
// Count unread notifications so the "Notifications" quick-link
// button below can show a little count badge, same as the header.
// -------------------------------------------------------
$unread_count = 0;
if (!empty($_SESSION['notifications'])) {
    foreach ($_SESSION['notifications'] as $notification) {
        if (empty($notification['read'])) {
            $unread_count++;
        }
    }
}

// Page title for this page — read by includes/header.php
$page_title = "My Account - The Literary Nook";
?>
<?php require 'includes/header.php'; ?>


<!-- ============================================================
     ACCOUNT / PROFILE CONTENT AREA
     Reuses the same wide single-card layout as register.php
     (.auth-wrapper + .register-card) for visual consistency.
     ============================================================ -->
<main class="auth-wrapper">
    <div class="register-card">

        <h2 class="register-card__title">My Profile</h2>
        <p class="register-card__subtitle">Welcome back, <?php echo htmlspecialchars($customer_name); ?>!</p>

        <!-- ====================================================
             ACCOUNT DETAILS
             Read-only display of the customer's basic info.
             PLACEHOLDER: replace with real DB fields later —
             this isn't an editable form yet, just a display.
             ==================================================== -->
        <p class="form-section-title">Account Details</p>

        <div class="profile-detail-row">
            <span class="profile-detail-row__label">Full Name</span>
            <span class="profile-detail-row__value"><?php echo htmlspecialchars($customer_name); ?></span>
        </div>
        <div class="profile-detail-row">
            <span class="profile-detail-row__label">Email</span>
            <span class="profile-detail-row__value"><?php echo htmlspecialchars($customer_email); ?></span>
        </div>
        <div class="profile-detail-row">
            <span class="profile-detail-row__label">Member Since</span>
            <span class="profile-detail-row__value"><?php echo htmlspecialchars($member_since); ?></span>
        </div>

        <!-- ====================================================
             QUICK LINKS
             Shortcuts to other account-related pages.
             PLACEHOLDER: orders.php and wishlist.php don't exist
             yet — these links are here so the layout is ready
             once those pages get built.
             ==================================================== -->
        <p class="form-section-title">Quick Links</p>

        <div class="profile-actions">
            <a href="notifications.php" class="btn btn--primary">
                NOTIFICATIONS
                <?php if ($unread_count > 0): ?>
                    <span class="count-badge"><?php echo $unread_count; ?></span>
                <?php endif; ?>
            </a>
            <a href="orders.php" class="btn btn--outline-dark">ORDER HISTORY</a>
            <a href="wishlist.php" class="btn btn--outline-dark">WISHLIST</a>
        </div>

        <!-- ====================================================
             LOG OUT
             PLACEHOLDER: destroys the session (see logout.php) so
             the login/registration flow can be tested again from
             a clean, signed-out state.
             ==================================================== -->
        <div class="form-footer">
            <p class="form-footer__note">Not you? <a href="logout.php">Log out</a></p>
        </div>

    </div><!-- /register-card -->
</main><!-- /auth-wrapper -->


<?php require 'includes/footer.php'; ?>

</body>
</html>
