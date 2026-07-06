<?php
/**
 * The Literary Nook - Bookstore Management System
 * File: notifications.php (Customer Notifications Page)
 *
 * Shows a signed-in customer's notifications — e.g. "you registered!",
 * order/shipping updates, promotional alerts (those last two will be
 * wired up once orders.php and newsletter.php exist).
 *
 * NOTE: session_start() is called here for the same reason as
 * account.php — the login gate below must run before any HTML output.
 *
 * PLACEHOLDER: Notifications are stored in $_SESSION only, so they
 * reset whenever the browser session ends (closing the browser, etc).
 * In production these would be rows in a 'notifications' table tied to
 * the customer's ID: SELECT * FROM notifications WHERE customer_id = ?
 */

session_start();

// -------------------------------------------------------
// LOGIN GATE — same pattern as account.php.
// -------------------------------------------------------
if (!isset($_SESSION['customer_id'])) {
    header('Location: login.php');
    exit;
}

// Grab whatever notifications have been queued so far (e.g. by
// register.php). Defaults to an empty array so the page still works
// correctly for a customer who has none yet.
$notifications = $_SESSION['notifications'] ?? [];

// -------------------------------------------------------
// PLACEHOLDER: Mark everything as read now that the person is viewing
// this page — mirrors how most notification inboxes behave. This
// updates $_SESSION for NEXT time; $notifications above still holds
// the original read/unread state so this visit displays correctly.
// In production this would be an UPDATE query instead.
// -------------------------------------------------------
if (!empty($_SESSION['notifications'])) {
    foreach ($_SESSION['notifications'] as $index => $notification) {
        $_SESSION['notifications'][$index]['read'] = true;
    }
}

// Page title for this page — read by includes/header.php
$page_title = "Notifications - The Literary Nook";
?>
<?php require 'includes/header.php'; ?>


<!-- ============================================================
     NOTIFICATIONS CONTENT AREA
     Same card layout as account.php / register.php for consistency.
     ============================================================ -->
<main class="auth-wrapper">
    <div class="register-card">

        <h2 class="register-card__title">Notifications</h2>
        <p class="register-card__subtitle">Updates about your account, orders, and promotions.</p>

        <?php if (empty($notifications)): ?>

            <!-- ================================================
                 EMPTY STATE
                 Shown when there are no notifications yet.
                 ================================================ -->
            <div class="notifications-empty">
                <i class="fas fa-bell-slash"></i>
                <p>You don't have any notifications yet.</p>
            </div>

        <?php else: ?>

            <!-- ================================================
                 NOTIFICATIONS LIST
                 Newest notification shown first (array_reverse).
                 Unread ones get a highlighted left border.
                 ================================================ -->
            <div class="notifications-list">
                <?php foreach (array_reverse($notifications) as $notification): ?>
                    <?php
                        // Adds the --unread modifier class only if this
                        // notification hadn't been read before this page load.
                        $unread_class = empty($notification['read']) ? 'notification-item--unread' : '';
                    ?>
                    <div class="notification-item <?php echo $unread_class; ?>">
                        <div class="notification-item__icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="notification-item__body">
                            <p class="notification-item__message"><?php echo htmlspecialchars($notification['message']); ?></p>
                            <p class="notification-item__time"><?php echo htmlspecialchars($notification['time']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php endif; ?>

        <div class="form-footer">
            <p class="form-footer__note"><a href="account.php">&larr; Back to My Profile</a></p>
        </div>

    </div><!-- /register-card -->
</main><!-- /auth-wrapper -->


<?php require 'includes/footer.php'; ?>

</body>
</html>
