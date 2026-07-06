<?php
/**
 * The Literary Nook - Bookstore Management System
 * File: logout.php (Log Out Handler)
 *
 * No page content — this file just clears the session and sends the
 * person back to the homepage. Linked from account.php.
 *
 * PLACEHOLDER: In production this might also clear a "remember me"
 * cookie or invalidate a server-side auth token. For now it just wipes
 * the PHP session, which is all the placeholder login system uses.
 */

session_start();

// Wipe all session data (login state, notifications, etc.) and destroy
// the session itself, so the next visit starts from a clean slate.
session_unset();
session_destroy();

header('Location: index.php');
exit;
