<?php
include 'config.php';
session_start();
requireLogin();

$user_id = (int) $_SESSION['user_id'];

if (isset($_POST['add_to_cart'])) {
    $pname = sanitize($conn, $_POST['product_name'] ?? '');
    $pprice = (int) ($_POST['product_price'] ?? 0);
    $pimage = sanitize($conn, $_POST['product_image'] ?? '');
    $pqty = max(1, (int) ($_POST['product_quantity'] ?? 1));

    $check = mysqli_query($conn, "SELECT id FROM cart WHERE name='$pname' AND user_id=$user_id");
    if (mysqli_num_rows($check) > 0) {
        flashMessage('info', 'Already in your cart!');
    } else {
        mysqli_query($conn, "INSERT INTO cart(user_id,name,price,quantity,image) VALUES($user_id,'$pname',$pprice,$pqty,'$pimage')");
        flashMessage('success', 'Added to cart!');
    }
    redirect('product.php?id=' . (int) ($_GET['id'] ?? 0));
}

// Fetch product
$id = (int) ($_GET['id'] ?? 0);
if (!$id)
    redirect('shop.php');

$qr = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
if (!$qr || mysqli_num_rows($qr) === 0)
    redirect('shop.php');
$p = mysqli_fetch_assoc($qr);

// Recommended
$recs = mysqli_query($conn, "SELECT * FROM products WHERE id != $id ORDER BY RAND() LIMIT 10");
?>
<?php include 'header.php'; ?>

<div class="page-banner">
    <h2><?php echo e($p['name']); ?></h2>
    <p class="breadcrumb"><a href="home.php">Home</a> / <a href="shop.php">Shop</a> / <?php echo e($p['name']); ?></p>
</div>

<section class="section">
    <div class="product-detail-layout">
        <!-- Image -->
        <div class="product-detail-img">
            <img src="uploaded_img/<?php echo e($p['image']); ?>" alt="<?php echo e($p['name']); ?>">
        </div>

        <!-- Info -->
        <div class="product-detail-info">
            <h1><?php echo e($p['name']); ?></h1>
            <div class="ratings">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                <i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                <span style="font-size:1.4rem;color:#8a8a8a;margin-left:.5rem;">(4.5 / 5) &bull; 123 ratings</span>
            </div>
            <div class="price-large">₱<?php echo number_format($p['price']); ?></div>

            <div class="product-qty-row">
                <label for="main-qty" style="font-weight:600;font-size:1.5rem;">Qty:</label>
                <input type="number" id="main-qty" class="qty-input" value="1" min="1">
            </div>

            <div style="display:flex;gap:1rem;flex-wrap:wrap;">
                <!-- Add to Cart -->
                <form method="post">
                    <input type="hidden" name="product_name" value="<?php echo e($p['name']); ?>">
                    <input type="hidden" name="product_price" value="<?php echo (int) $p['price']; ?>">
                    <input type="hidden" name="product_image" value="<?php echo e($p['image']); ?>">
                    <input type="hidden" name="product_quantity" id="cart_quantity" value="1">
                    <button type="submit" name="add_to_cart" class="btn btn-lg">
                        <i class="fas fa-cart-plus"></i> Add to Cart
                    </button>
                </form>

                <!-- Buy Now -->
                <form method="post" action="checkout.php">
                    <input type="hidden" name="buy_now_name" value="<?php echo e($p['name']); ?>">
                    <input type="hidden" name="buy_now_price" value="<?php echo (int) $p['price']; ?>">
                    <input type="hidden" name="buy_now_image" value="<?php echo e($p['image']); ?>">
                    <input type="hidden" name="buy_now_quantity" id="buy_now_quantity" value="1">
                    <input type="hidden" name="buy_now" value="1">
                    <button type="submit" class="btn btn-gold btn-lg">
                        <i class="fas fa-bolt"></i> Buy Now
                    </button>
                </form>
            </div>

            <div class="description">
                <h3 style="font-size:1.8rem;font-weight:700;margin-bottom:1rem;">Description</h3>
                <p><?php echo nl2br(e($p['description'])); ?></p>
            </div>
        </div>

        <!-- Recommended -->
        <div class="recommended-sidebar">
            <h3>You May Also Like</h3>
            <?php while ($rec = mysqli_fetch_assoc($recs)): ?>
                <a href="product.php?id=<?php echo (int) $rec['id']; ?>" class="rec-item">
                    <img src="uploaded_img/<?php echo e($rec['image']); ?>" alt="<?php echo e($rec['name']); ?>">
                    <div>
                        <div class="rec-item-name"><?php echo e($rec['name']); ?></div>
                        <div class="rec-item-price">₱<?php echo number_format($rec['price']); ?></div>
                    </div>
                </a>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<script>
    const mainQtyInput = document.getElementById('main-qty');
    const buyNowQtyInput = document.getElementById('buy_now_quantity');
    const cartQtyInput = document.getElementById('cart_quantity');
    if (mainQtyInput) {
        mainQtyInput.addEventListener('input', function () {
            if (buyNowQtyInput) buyNowQtyInput.value = this.value;
            if (cartQtyInput) cartQtyInput.value = this.value;
        });
    }
</script>

<?php include 'footer.php'; ?>