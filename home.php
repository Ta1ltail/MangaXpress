<?php
include 'config.php';
session_start();
requireLogin();

$user_id = $_SESSION['user_id'];

// Add to cart
if (isset($_POST['add_to_cart'])) {
    $pname = sanitize($conn, $_POST['product_name'] ?? '');
    $pprice = (int) ($_POST['product_price'] ?? 0);
    $pimage = sanitize($conn, $_POST['product_image'] ?? '');
    $pqty = max(1, (int) ($_POST['product_quantity'] ?? 1));
    $uid = (int) $user_id;

    $check = mysqli_query($conn, "SELECT id FROM cart WHERE name='$pname' AND user_id=$uid");
    if (mysqli_num_rows($check) > 0) {
        flashMessage('info', 'Already in your cart!');
    } else {
        mysqli_query($conn, "INSERT INTO cart(user_id,name,price,quantity,image) VALUES($uid,'$pname',$pprice,$pqty,'$pimage')");
        flashMessage('success', 'Added to cart!');
    }
    redirect('home.php');
}

$latestProducts = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC LIMIT 5");
?>
<?php include 'header.php'; ?>

<!-- Hero Slider -->
<section class="hero">
    <div class="hero-slides">
        <div class="hero-slide"><img src="images/home_img-3.webp" alt="Manga collection"></div>
        <div class="hero-slide"><img src="images/home_img-2.jpg" alt="Manga collection"></div>
        <div class="hero-slide"><img src="images/home_img-4.png" alt="Manga collection"></div>
        <div class="hero-slide"><img src="images/home_img-5.png" alt="Manga collection"></div>
    </div>
    <div class="hero-overlay">
        <div class="hero-content">
            <p class="hero-eyebrow">Your Manga Destination</p>
            <h1 class="hero-title">Read. Collect.<br><span>Experience.</span></h1>
            <div class="hero-actions">
                <a href="shop.php" class="btn btn-lg"><i class="fas fa-store"></i> Shop Now</a>
                <a href="about.php" class="btn btn-lg btn-outline"><i class="fas fa-compass"></i> Discover More</a>
            </div>
        </div>
    </div>
</section>

<!-- Latest Manga -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <p class="section-eyebrow">Just Added</p>
            <h2 class="section-title">Latest Manga</h2>
        </div>
        <div class="product-grid">
            <?php if ($latestProducts && mysqli_num_rows($latestProducts) > 0): ?>
                <?php while ($p = mysqli_fetch_assoc($latestProducts)): ?>
                    <div class="product-card">
                        <div class="product-img-wrap">
                            <a href="product.php?id=<?php echo (int) $p['id']; ?>">
                                <img src="uploaded_img/<?php echo e($p['image']); ?>" alt="<?php echo e($p['name']); ?>"
                                    loading="lazy">
                            </a>
                            <span class="product-price-tag">₱<?php echo number_format($p['price']); ?></span>
                        </div>
                        <div class="product-info">
                            <div class="product-name">
                                <a href="product.php?id=<?php echo (int) $p['id']; ?>"><?php echo e($p['name']); ?></a>
                            </div>
                            <input type="number" min="1" value="1" id="qty_<?php echo $p['id']; ?>" class="product-qty qty-sync"
                                data-id="<?php echo $p['id']; ?>">
                            <div class="product-actions">
                                <form method="post" action="">
                                    <input type="hidden" name="product_name" value="<?php echo e($p['name']); ?>">
                                    <input type="hidden" name="product_price" value="<?php echo (int) $p['price']; ?>">
                                    <input type="hidden" name="product_image" value="<?php echo e($p['image']); ?>">
                                    <input type="hidden" name="product_quantity" id="cart_qty_<?php echo $p['id']; ?>"
                                        value="1">
                                    <button type="submit" name="add_to_cart" class="btn btn-block">
                                        <i class="fas fa-cart-plus"></i> Add to Cart
                                    </button>
                                </form>
                                <form method="post" action="checkout.php">
                                    <input type="hidden" name="buy_now_name" value="<?php echo e($p['name']); ?>">
                                    <input type="hidden" name="buy_now_price" value="<?php echo (int) $p['price']; ?>">
                                    <input type="hidden" name="buy_now_image" value="<?php echo e($p['image']); ?>">
                                    <input type="hidden" name="buy_now_quantity" id="buy_now_qty_<?php echo $p['id']; ?>"
                                        value="1">
                                    <input type="hidden" name="buy_now" value="1">
                                    <button type="submit" class="btn btn-gold btn-block">
                                        <i class="fas fa-bolt"></i> Buy Now
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-state" style="grid-column:1/-1;">
                    <i class="fas fa-book"></i>
                    <h3>No products yet</h3>
                    <p>Check back soon!</p>
                </div>
            <?php endif; ?>
        </div>
        <div class="load-more">
            <a href="shop.php" class="btn btn-outline"><i class="fas fa-th-large"></i> View All Products</a>
        </div>
    </div>
</section>

<!-- About Snippet -->
<section class="section section-light">
    <div class="container">
        <div class="about-flex">
            <img src="images/about_us.webp" alt="About MangaXpress">
            <div class="about-content">
                <h3>About MangaXpress</h3>
                <p>At MangaXpress, we know the excitement that comes with diving into your favorite manga and manhwa.
                    That's why we're dedicated to bringing you authentic, high-quality products—from the latest releases
                    to must-have collectibles.</p>
                <p>We carefully select our items so every fan, whether a casual reader or a passionate collector, can
                    find something special.</p>
                <a href="about.php" class="btn mt-2"><i class="fas fa-info-circle"></i> Read More</a>
            </div>
        </div>
    </div>
</section>

<!-- CTA Banner -->
<section class="cta-banner">
    <div class="container">
        <h3>Have Any Questions?</h3>
        <p>Our team is standing by to help you.</p>
        <a href="contact.php" class="btn btn-lg"
            style="background:var(--white);color:var(--crimson);border-color:var(--white);">
            <i class="fas fa-envelope"></i> Contact Us
        </a>
    </div>
</section>

<?php include 'footer.php'; ?>