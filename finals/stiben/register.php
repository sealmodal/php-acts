<?php
/**
 * The Literary Nook - Bookstore Management System
 * File: register.php (New Customer Registration Page)
 *
 * Form for new customers to create an account.
 * Collects: first name, last name, email, phone, address, password, confirm password.
 *
 * NOTE: No real DB insertion yet. Submission handling is placeholder only.
 * In production, validated data will be inserted into the customers table via XAMPP MySQL.
 * Use password_hash() before storing the password — never store plain text.
 *
 * NOTE: session_start() is called here because this page now writes to
 * $_SESSION during form handling below (auto-login + queuing a welcome
 * notification), which happens before includes/header.php gets required
 * further down the file.
 */

session_start();

// -------------------------------------------------------
// PLACEHOLDER: Redirect if already logged in.
// In production: if (isset($_SESSION['customer_id'])) header('Location: account.php');
// -------------------------------------------------------

// -------------------------------------------------------
// PLACEHOLDER: Registration form handler.
// In production this will:
//   1. Sanitize and validate all inputs server-side
//   2. Check if email already exists: SELECT * FROM customers WHERE email = ?
//   3. Hash the password: password_hash($password, PASSWORD_DEFAULT)
//   4. Insert into customers table
//   5. Send confirmation email (placeholder idk how to yet)
//   6. Set session and redirect to account.php
// -------------------------------------------------------
$errors  = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {

    // Grab and trim all form fields
    $first_name      = trim($_POST['first_name']      ?? '');
    $last_name       = trim($_POST['last_name']       ?? '');
    $email           = trim($_POST['email']           ?? '');
    $phone           = trim($_POST['phone']           ?? '');
    $address         = trim($_POST['address']         ?? '');
    $password        = trim($_POST['password']        ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');

    // PLACEHOLDER: Basic validation — expand with regex checks in production
    if (empty($first_name))   $errors[] = "First name is required.";
    if (empty($last_name))    $errors[] = "Last name is required.";
    if (empty($email))        $errors[] = "Email address is required.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Please enter a valid email address.";
    if (empty($password))     $errors[] = "Password is required.";
    if (strlen($password) < 8) $errors[] = "Password must be at least 8 characters.";
    if ($password !== $confirm_password) $errors[] = "Passwords do not match.";

    // If no validation errors, simulate a successful registration
    if (empty($errors)) {
        // PLACEHOLDER: This is where DB insertion goes in production.
        // Example: $stmt = $pdo->prepare("INSERT INTO customers (first_name, ...) VALUES (?, ...)");

        // -------------------------------------------------------
        // PLACEHOLDER: Auto sign-in the new customer.
        // In production, customer_id would be the new row's real ID
        // from the INSERT above instead of a fixed placeholder value.
        // -------------------------------------------------------
        $_SESSION['customer_id']    = 1;
        $_SESSION['customer_name']  = trim($first_name . ' ' . $last_name);
        $_SESSION['customer_email'] = $email;

        // -------------------------------------------------------
        // PLACEHOLDER: Queue a "you registered!" notification.
        // In production this would be an INSERT into a notifications
        // table tied to the new customer_id, not a session array.
        // -------------------------------------------------------
        $_SESSION['notifications']   = $_SESSION['notifications'] ?? [];
        $_SESSION['notifications'][] = [
            'message' => "You've successfully registered! Welcome to The Literary Nook, " . $first_name . ".",
            'time'    => date('F j, Y g:i A'),
            'read'    => false,
        ];

        $success = true;
    }
}

// Page title for this page — read by includes/header.php
$page_title = "Create Account - The Literary Nook";
?>
<?php require 'includes/header.php'; ?>


<!-- ============================================================
     REGISTER CONTENT AREA
     Single centered card with the full registration form.
     ============================================================ -->
<main class="auth-wrapper auth-wrapper--top">
    <div class="register-card">

        <?php if ($success): ?>
        <!-- ====================================================
             SUCCESS STATE
             Shown after a successful (placeholder) registration.
             In production, this will only show after DB insert confirms.
             ==================================================== -->
        <div class="success-box">
            <i class="fas fa-check-circle"></i>
            <h3>Account Created!</h3>
            <p>
                Welcome to The Literary Nook! You're now signed in, and a confirmation
                email has been sent to your inbox.
                <br>(Placeholder - email sending not yet implemented.)
            </p>
            <a href="account.php" class="btn btn--primary">GO TO YOUR PROFILE</a>
        </div>

        <?php else: ?>
        <!-- ====================================================
             REGISTRATION FORM
             Shown by default (or when there are validation errors).
             ==================================================== -->

        <h2 class="register-card__title">Create an Account</h2>
        <p class="register-card__subtitle">Join The Literary Nook and enjoy a better shopping experience.</p>

        <!-- Validation errors — shown if $errors array is not empty -->
        <?php if (!empty($errors)): ?>
            <div class="error-list">
                <p><i class="fas fa-exclamation-triangle"></i> Please fix the following:</p>
                <ul>
                    <?php foreach ($errors as $err): ?>
                        <li><?php echo htmlspecialchars($err); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="register.php">

            <!-- ------------------------------------------------
                 SECTION 1: PERSONAL INFORMATION
                 Fields: First Name, Last Name, Email, Phone, Address
                 See: Section 1.1 > Registration fields
                 ------------------------------------------------ -->
            <p class="form-section-title">Personal Information</p>

            <!-- First Name + Last Name side by side -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="first_name">
                        First Name <span class="required">*</span>
                    </label>
                    <input
                        class="form-input"
                        type="text"
                        id="first_name"
                        name="first_name"
                        placeholder="e.g. Maria"
                        value="<?php echo htmlspecialchars($_POST['first_name'] ?? ''); ?>"
                        required
                    >
                </div>
                <div class="form-group">
                    <label class="form-label" for="last_name">
                        Last Name <span class="required">*</span>
                    </label>
                    <input
                        class="form-input"
                        type="text"
                        id="last_name"
                        name="last_name"
                        placeholder="e.g. Santos"
                        value="<?php echo htmlspecialchars($_POST['last_name'] ?? ''); ?>"
                        required
                    >
                </div>
            </div>

            <!-- Email + Phone side by side -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="email">
                        Email Address <span class="required">*</span>
                    </label>
                    <input
                        class="form-input"
                        type="email"
                        id="email"
                        name="email"
                        placeholder="you@example.com"
                        value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                        required
                        autocomplete="email"
                    >
                </div>
                <div class="form-group">
                    <label class="form-label" for="phone">Phone Number</label>
                    <input
                        class="form-input"
                        type="tel"
                        id="phone"
                        name="phone"
                        placeholder="e.g. 09XX XXX XXXX"
                        value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>"
                    >
                </div>
            </div>

            <!-- Full address — single wide field -->
            <div class="form-group">
                <label class="form-label" for="address">Address</label>
                <input
                    class="form-input"
                    type="text"
                    id="address"
                    name="address"
                    placeholder="Street, Barangay, City, Province"
                    value="<?php echo htmlspecialchars($_POST['address'] ?? ''); ?>"
                >
            </div>


            <!-- ------------------------------------------------
                 SECTION 2: ACCOUNT SECURITY
                 Password + Confirm Password fields.
                 PLACEHOLDER: In production, enforce stronger rules and
                 hash with password_hash() before storing.
                 ------------------------------------------------ -->
            <p class="form-section-title">Account Security</p>

            <div class="form-row">
                <!-- Password field -->
                <div class="form-group">
                    <label class="form-label" for="password">
                        Password <span class="required">*</span>
                    </label>
                    <div class="input-password-wrap">
                        <input
                            class="form-input"
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Min. 8 characters"
                            required
                            autocomplete="new-password"
                        >
                        <button type="button" class="password-toggle" id="togglePassword" aria-label="Show or hide password">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                    <p class="form-hint">At least 8 characters. Use a mix of letters and numbers.</p>
                </div>

                <!-- Confirm Password field -->
                <div class="form-group">
                    <label class="form-label" for="confirm_password">
                        Confirm Password <span class="required">*</span>
                    </label>
                    <div class="input-password-wrap">
                        <input
                            class="form-input"
                            type="password"
                            id="confirm_password"
                            name="confirm_password"
                            placeholder="Re-enter your password"
                            required
                            autocomplete="new-password"
                        >
                        <button type="button" class="password-toggle" id="toggleConfirm" aria-label="Show or hide password">
                            <i class="fas fa-eye" id="toggleIconConfirm"></i>
                        </button>
                    </div>
                </div>
            </div>


            <!-- ------------------------------------------------
                 FORM FOOTER
                 Submit button on the right, back to login on the left.
                 ------------------------------------------------ -->
            <div class="form-footer">
                <p class="form-footer__note">
                    Already have an account? <a href="login.php">Sign in here</a>
                </p>
                <button type="submit" name="register" class="btn btn--primary">
                    CREATE ACCOUNT
                </button>
            </div>

        </form>
        <?php endif; ?>

    </div><!-- /register-card -->
</main><!-- /auth-wrapper -->


<?php require 'includes/footer.php'; ?>


<!-- ============================================================
     JS: Password show/hide toggles
     Same pattern as login.php — one for each password field.
     ============================================================ -->
<script>
    // Toggle for the main password field
    const toggleBtn = document.getElementById('togglePassword');
    const passInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');

    if (toggleBtn) {
        toggleBtn.addEventListener('click', function () {
            const isHidden = passInput.type === 'password';
            passInput.type = isHidden ? 'text' : 'password';
            toggleIcon.classList.toggle('fa-eye',       !isHidden);
            toggleIcon.classList.toggle('fa-eye-slash',  isHidden);
        });
    }

    // Toggle for the confirm password field
    const toggleConfirm     = document.getElementById('toggleConfirm');
    const confirmInput      = document.getElementById('confirm_password');
    const toggleIconConfirm = document.getElementById('toggleIconConfirm');

    if (toggleConfirm) {
        toggleConfirm.addEventListener('click', function () {
            const isHidden = confirmInput.type === 'password';
            confirmInput.type = isHidden ? 'text' : 'password';
            toggleIconConfirm.classList.toggle('fa-eye',       !isHidden);
            toggleIconConfirm.classList.toggle('fa-eye-slash',  isHidden);
        });
    }
</script>

</body>
</html>
