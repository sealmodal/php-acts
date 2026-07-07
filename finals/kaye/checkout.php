<?php
$page_title = "Checkout | The Literary Nook";
require_once 'includes/header.php';

$cart_items = [
    ['name' => 'Solo Leveling', 'price' => 1200],
    ['name' => 'Like Wind on a Dry Branch', 'price' => 1300]
];
$subtotal = 2500;
$shipping = 50;
?>

<main class="container" style="padding: 40px 0;">
    <h1 style="font-family: var(--font-heading); color: var(--color-text); margin-bottom: 30px;">Checkout</h1>

    <form action="process_checkout.php" method="POST" style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 40px; align-items: start;">
        
        <div style="display: flex; flex-direction: column; gap: 30px;">
            
            <section style="background: white; padding: 30px; border-radius: 8px; border: 1px solid var(--color-border);">
                <h3 style="font-family: var(--font-heading); margin-bottom: 20px;">Shipping Details</h3>
                
                <div style="margin-bottom: 15px;">
                    <input type="text" name="full_name" placeholder="Full Name" required style="width: 100%; padding: 12px; 
                    border: 1px solid var(--color-border); border-radius: 4px; font-family: var(--font-body);">
                </div>

                <div style="margin-bottom: 15px;">
                    <input type="tel" name="phone" placeholder="Phone Number" required style="width: 100%; padding: 12px; 
                    border: 1px solid var(--color-border); border-radius: 4px; font-family: var(--font-body);">
                </div>

                <div style="margin-bottom: 15px;">
                    <input type="text" name="street_address" placeholder="House No. / Street Address" required style="width: 100%;
                     padding: 12px; border: 1px solid var(--color-border); border-radius: 4px; font-family: var(--font-body);">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <input type="text" name="barangay" placeholder="Barangay" required style="padding: 12px; 
                    border: 1px solid var(--color-border); border-radius: 4px; font-family: var(--font-body);">

                    <input type="text" name="city" placeholder="City / Municipality" required style="padding: 12px; 
                    border: 1px solid var(--color-border); border-radius: 4px; font-family: var(--font-body);">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <input type="text" name="province" placeholder="Province" required style="padding: 12px; 
                    border: 1px solid var(--color-border); border-radius: 4px; font-family: var(--font-body);">

                    <input type="text" name="postal_code" placeholder="Postal Code" required style="padding: 12px; 
                    border: 1px solid var(--color-border); border-radius: 4px; font-family: var(--font-body);">
                </div>
            </section>

            <section style="background: white; padding: 30px; border-radius: 8px; border: 1px solid var(--color-border);">
    <h3 style="font-family: var(--font-heading); margin-bottom: 20px;">Payment Method</h3>
    
    <div style="display: flex; flex-direction: column; gap: 10px; font-family: var(--font-body);">
        <label style="display: flex; align-items: center; gap: 10px;">
            <input type="radio" name="payment" value="card" checked> <i class="fas fa-credit-card"></i> Credit/Debit Card
        </label>
        <label style="display: flex; align-items: center; gap: 10px;">
            <input type="radio" name="payment" value="paypal"> <i class="fab fa-paypal"></i> PayPal
        </label>
        <label style="display: flex; align-items: center; gap: 10px;">
            <input type="radio" name="payment" value="gcash"> <i class="fas fa-wallet"></i> GCash
        </label>
    </div>

    <p style="margin-top: 20px; font-size: 12px; color: var(--color-text-light); font-family: var(--font-body); font-style: italic;">
        * For Credit/Debit Card and E-Wallets, you will be redirected to a secure payment page to complete your purchase.
    </p>
</section>
        </div>

        <aside style="background: var(--color-bg-soft); padding: 30px; border-radius: 8px; border: 1px solid var(--color-border);">
            <h3 style="font-family: var(--font-heading); margin-bottom: 20px;">Review Items</h3>
            <?php foreach ($cart_items as $item): ?>
                <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 15px; font-family: var(--font-body);">
                    <div style="width: 50px; height: 70px; background: white; border: 1px solid var(--color-border); display: flex; align-items: center; 
                    justify-content: center; font-size: 20px; color: var(--color-border);">

                        <i class="fas fa-book"></i>
                    </div>
                    <div style="flex: 1; display: flex; justify-content: space-between;">
                        <span><?php echo $item['name']; ?></span>
                        <span>₱<?php echo number_format($item['price'], 2); ?></span>
                    </div>
                </div>
            <?php endforeach; ?>

            <div style="margin: 30px 0;">
                <label style="display: block; margin-bottom: 10px; font-family: var(--font-heading);">Promo Code</label>
                <div style="display: flex; gap: 10px;">
                    <input type="text" name="promo_code" placeholder="Enter code" style="flex: 1; padding: 10px; border: 1px solid var(--color-border); 
                    border-radius: 4px;">

                    <button type="button" class="btn btn--primary" style="padding: 10px 15px; border: none; cursor: pointer;">Apply</button>
                </div>
            </div>

            <div style="border-top: 1px solid var(--color-border); padding-top: 20px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-family: var(--font-body);">
                    <span>Subtotal</span><span>₱<?php echo number_format($subtotal, 2); ?></span>
                </div>
                <div style="display: flex; justify-content: space-between; font-weight: bold; font-family: var(--font-body);">
                    <span>Total</span>
                    <span style="color: var(--color-primary); font-size: 1.2em;">₱<?php echo number_format($subtotal + $shipping, 2); ?></span>
                </div>
            </div>
            
            <button type="submit" class="btn btn--primary" style="width: 100%; margin-top: 20px; 
            padding: 15px; cursor: pointer; border: none; font-family: var(--font-body);">

                Place Order
            </button>
        </aside>
    </form>
</main>

<?php require_once 'includes/footer.php'; ?>