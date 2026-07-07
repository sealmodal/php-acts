<?php
$page_title = "Order Confirmed | The Literary Nook";

require_once 'includes/header.php'; 
?>

<main class="container">
    <div class="confirmation-page" style="padding: 64px 0; text-align: center;">
        <div style="font-size: 64px; color: var(--color-success); margin-bottom: 24px;">
            <i class="fas fa-check-circle"></i>
        </div>
        
        <h1 style="font-family: var(--font-heading); font-size: 40px; color: var(--color-text); margin-bottom: 16px;">
            Order Confirmed!
        </h1>

       <p style="font-family: var(--font-body); color: var(--color-text-light); margin-bottom: 48px;">
    Thank you for your purchase! Your order has been placed and a receipt has been sent to your email.
</p>
        <div style="width: 100%; max-width: 600px; margin: 0 auto; border: 2px solid var(--color-border); 
        padding: 32px; border-radius: var(--radius-md); background: #fff; text-align: left;">
            <div style="display: flex; justify-content: space-between; align-items: center; 
            border-bottom: 1px dashed var(--color-border); padding-bottom: 16px; margin-bottom: 16px;">

                <strong style="font-family: var(--font-body);">ORD-2026-001</strong>
                <span style="background: #fff3cd; color: #856404; padding: 4px 10px; font-size: 11px; font-weight: 700; border-radius: 4px; 
                text-transform: uppercase;">Pending</span>
            </div>
            
            <div style="font-family: var(--font-body); margin-bottom: 12px;">
                <span style="color: var(--color-text-light);">Shipping to</span><br>
                <strong>Manila, Quezon City</strong>
            </div>
            
            <div style="font-family: var(--font-body); margin-bottom: 12px;">
                <span style="color: var(--color-text-light);">Estimated Delivery</span><br>
                <strong>Jul 1 – Jul 2, 2026</strong>
            </div>
            
            <div style="font-family: var(--font-body); border-top: 1px dashed var(--color-border); padding-top: 16px; display: flex; 
            justify-content: space-between;">
                <span>Total Charged</span>
                <strong style="color: var(--color-primary);">₱2,500</strong>
            </div>
        </div>

        <div style="margin-top: 40px;">
            <a href="index.php" class="btn btn--primary">Continue Shopping</a>
        </div>
    </div>
</main>

<?php
require_once 'includes/footer.php'; 
?>