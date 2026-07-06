<!-- ============================================================
     FOOTER
     Contains: logo, nav columns, copyright
     PLACEHOLDER: Newsletter form will tie into email notifications (Section 5)
     ============================================================ -->
<footer class="footer">
    <div class="footer__top">
        <div class="container footer__grid">

            <!-- Footer brand column -->
            <div class="footer__col footer__col--brand">
                <span class="logo-text logo-text--footer">THE LITERARY NOOK</span>
                <p class="footer__tagline">Your cozy corner for every story.</p>
                <!-- Social icons — PLACEHOLDER: links to social pages -->
                <div class="footer__socials">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                </div>
            </div>

            <!-- Footer nav column: Shop -->
            <div class="footer__col">
                <h4 class="footer__col-title">Shop</h4>
                <ul class="footer__col-links">
                    <li><a href="#">Books</a></li>
                    <li><a href="#">Non Books</a></li>
                    <li><a href="#">New Arrivals</a></li>
                    <li><a href="#">Bestsellers</a></li>
                    <li><a href="#">Sale</a></li>
                </ul>
            </div>

            <!-- Footer nav column: Account -->
            <div class="footer__col">
                <h4 class="footer__col-title">My Account</h4>
                <ul class="footer__col-links">
                    <!-- These pages will be built in later sprints -->
                    <li><a href="login.php">Login / Register</a></li>
                    <li><a href="account.php">My Profile</a></li>
                    <li><a href="orders.php">Order History</a></li>
                    <li><a href="wishlist.php">Wishlist</a></li>
                </ul>
            </div>

            <!-- Footer nav column: Help -->
            <div class="footer__col">
                <h4 class="footer__col-title">Help</h4>
                <ul class="footer__col-links">
                    <li><a href="#">FAQs</a></li>
                    <li><a href="#">Shipping Policy</a></li>
                    <li><a href="#">Returns</a></li>
                    <li><a href="#">Store Locator</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul>
            </div>

            <!-- Newsletter signup — ties into Section 5: Email Notifications -->
            <div class="footer__col footer__col--newsletter">
                <h4 class="footer__col-title">Stay in the Loop</h4>
                <p>Get notified about new arrivals and exclusive deals.</p>
                <!-- PLACEHOLDER: This form will POST to newsletter.php or an email handler -->
                <form class="newsletter-form" action="newsletter.php" method="POST">
                    <input type="email" name="email" placeholder="Enter your email" required>
                    <button type="submit" class="btn btn--primary">Subscribe</button>
                </form>
            </div>

        </div><!-- /footer__grid -->
    </div><!-- /footer__top -->

    <!-- Bottom bar with copyright -->
    <div class="footer__bottom">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> The Literary Nook. All rights reserved.</p>
        </div>
    </div>
</footer><!-- /footer -->
