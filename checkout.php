<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$grand_total = 0;
$buy_now_mode = false;
$buy_now_item = [];
$message = [];

// Fetch user info
$user_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id, name, email FROM `users` WHERE id='$user_id'")) ?? [];
$profile_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT number, address FROM `user_profile` WHERE user_id='$user_id'")) ?? [];

// Detect Buy Now
if (!empty($_POST['buy_now'])) {
    $buy_now_mode = true;
    $buy_now_item = [
        'name' => $_POST['buy_now_name'] ?? '',
        'price' => (float) ($_POST['buy_now_price'] ?? 0),
        'quantity' => max(1, (int) ($_POST['buy_now_quantity'] ?? 1)),
        'image' => $_POST['buy_now_image'] ?? ''
    ];
    $grand_total = $buy_now_item['price'] * $buy_now_item['quantity'];
}

// Handle Order Submission
if (!empty($_POST['order_btn'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $number = $_POST['number'];
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $address = mysqli_real_escape_string($conn, $_POST['street'] . ', ' . $_POST['country'] . ' - ' . $_POST['pin_code']);
    $placed_on = date('d-M-Y');

    if ($buy_now_mode) {
        $total_products = $buy_now_item['name'] . ' (' . $buy_now_item['quantity'] . ')';
        $cart_total = $grand_total;
    } else {
        $cart_products = [];
        $cart_total = 0;
        $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id='$user_id'");
        while ($cart_item = mysqli_fetch_assoc($cart_query)) {
            $cart_products[] = $cart_item['name'] . ' (' . $cart_item['quantity'] . ')';
            $cart_total += $cart_item['price'] * $cart_item['quantity'];
        }
        $total_products = implode(', ', $cart_products);
    }

    if ($cart_total <= 0) {
        $message[] = 'Your cart is empty.';
    } else {
        $dup = mysqli_query($conn, "SELECT * FROM `orders` WHERE name='$name' AND number='$number' AND email='$email' AND method='$method' AND address='$address' AND total_products='$total_products' AND total_price='$cart_total'");
        if (mysqli_num_rows($dup) == 0) {
            mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES ('$user_id','$name','$number','$email','$method','$address','$total_products','$cart_total','$placed_on')");
            if (!$buy_now_mode) {
                mysqli_query($conn, "DELETE FROM `cart` WHERE user_id='$user_id'");
            }
            echo "<script>alert('🎉 Order placed successfully!'); window.location.href='orders.php';</script>";
            exit();
        }
    }
}
?>
<?php include 'header.php'; ?>

<div class="page-banner">
    <h2>Checkout</h2>
    <p class="breadcrumb"><a href="home.php">Home</a> / Checkout</p>
</div>

<section class="section">
    <div class="container">
        <?php if (!empty($message)): ?>
            <?php foreach ($message as $msg): ?>
                <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> <?php echo e($msg); ?></div>
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="checkout-layout">

            <!-- Order Summary -->
            <div class="checkout-form-card">
                <h3><i class="fas fa-receipt" style="color:var(--crimson);margin-right:.8rem;"></i>Order Summary</h3>

                <?php
                $items_html = '';
                $item_count = 0;

                if ($buy_now_mode) {
                    $item_count = 1;
                    ob_start(); ?>
                    <div class="checkout-item-card">
                        <img src="uploaded_img/<?php echo e($buy_now_item['image']); ?>"
                            alt="<?php echo e($buy_now_item['name']); ?>">
                        <div class="ci-name"><?php echo e($buy_now_item['name']); ?></div>
                        <div class="ci-price">₱<?php echo number_format($buy_now_item['price']); ?></div>
                        <div class="ci-qty">× <?php echo $buy_now_item['quantity']; ?></div>
                    </div>
                    <?php $items_html = ob_get_clean();
                } else {
                    $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id='$user_id'");
                    $item_count = mysqli_num_rows($select_cart);
                    if ($item_count > 0) {
                        ob_start();
                        while ($fc = mysqli_fetch_assoc($select_cart)) {
                            $sub = $fc['price'] * $fc['quantity'];
                            $grand_total += $sub; ?>
                            <div class="checkout-item-card">
                                <img src="uploaded_img/<?php echo e($fc['image']); ?>" alt="<?php echo e($fc['name']); ?>">
                                <div class="ci-name"><?php echo e($fc['name']); ?></div>
                                <div class="ci-price">₱<?php echo number_format($fc['price']); ?></div>
                                <div class="ci-qty">× <?php echo $fc['quantity']; ?></div>
                            </div>
                            <?php
                        }
                        $items_html = ob_get_clean();
                    }
                }
                ?>

                <?php if ($item_count > 0): ?>
                    <div class="checkout-items-grid">
                        <?php echo $items_html; ?>
                    </div>
                    <div class="checkout-total-bar">
                        <span>Grand Total</span>
                        <span>₱<?php echo number_format($grand_total); ?></span>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-shopping-cart"></i>
                        <h3>Cart is empty</h3>
                        <p><a href="shop.php" class="btn mt-2">Browse Shop</a></p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Checkout Form -->
            <div class="checkout-summary-card">
                <h3><i class="fas fa-map-marker-alt" style="color:var(--crimson);margin-right:.8rem;"></i>Delivery
                    Details</h3>

                <form action="" method="post">
                    <div class="form-group">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" required
                            value="<?php echo e($user_data['name'] ?? ''); ?>">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Phone Number</label>
                            <input type="number" name="number" class="form-control" required
                                value="<?php echo e($profile_data['number'] ?? ''); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" required
                                value="<?php echo e($user_data['email'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Payment Method</label>
                        <select name="method" class="form-control">
                            <option value="cash on delivery">Cash on Delivery</option>
                            <option value="credit card">Credit Card</option>
                            <option value="paypal">PayPal</option>
                            <option value="atm">ATM</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Street / Barangay</label>
                        <input type="text" name="street" class="form-control" required
                            value="<?php echo e($profile_data['address'] ?? ''); ?>"
                            placeholder="e.g. BLK 25 LOT 13 Lapaz Ave">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Country</label>
                            <input type="text" name="country" class="form-control" required value="Philippines">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Postal Code</label>
                            <input type="number" name="pin_code" class="form-control" required placeholder="e.g. 4109">
                        </div>
                    </div>

                    <?php if ($buy_now_mode): ?>
                        <input type="hidden" name="buy_now" value="1">
                        <input type="hidden" name="buy_now_name" value="<?php echo e($buy_now_item['name']); ?>">
                        <input type="hidden" name="buy_now_price" value="<?php echo $buy_now_item['price']; ?>">
                        <input type="hidden" name="buy_now_quantity" value="<?php echo $buy_now_item['quantity']; ?>">
                        <input type="hidden" name="buy_now_image" value="<?php echo e($buy_now_item['image']); ?>">
                    <?php endif; ?>

                    <?php if ($item_count > 0): ?>
                        <button type="submit" name="order_btn" class="btn btn-block btn-lg" style="margin-top:1rem;">
                            <i class="fas fa-check-circle"></i> Place Order — ₱<?php echo number_format($grand_total); ?>
                        </button>
                    <?php endif; ?>
                </form>
            </div>

        </div>
    </div>
</section>

<?php include 'footer.php'; ?>