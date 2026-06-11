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
    redirect('shop.php?page=' . (int) ($_GET['page'] ?? 1));
}

// Pagination
$limit = 15;
$page = max(1, (int) ($_GET['page'] ?? 1));
$offset = ($page - 1) * $limit;
$total = (int) (mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM products"))['c'] ?? 0);
$totalPages = (int) ceil($total / $limit);

$products = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC LIMIT $offset, $limit");
?>
<?php include 'header.php'; ?>

<div class="page-banner">
    <h2>Shop</h2>
    <p class="breadcrumb"><a href="home.php">Home</a> / Shop</p>
</div>

<section class="section">
    <div class="container">
        <div class="section-header">
            <p class="section-eyebrow"><?php echo $total; ?> Products Available</p>
            <h2 class="section-title">All Manga &amp; Manhwa</h2>
        </div>

        <div class="product-grid">
            <?php if ($products && mysqli_num_rows($products) > 0): ?>
                <?php while ($p = mysqli_fetch_assoc($products)): ?>
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
                                <form method="post">
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
                    <i class="fas fa-book-open"></i>
                    <h3>No products yet</h3>
                    <p>Check back soon for new arrivals.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="shop.php?page=<?php echo $page - 1; ?>">&laquo;</a>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <?php if ($i === $page): ?>
                        <span class="active"><?php echo $i; ?></span>
                    <?php else: ?>
                        <a href="shop.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    <?php endif; ?>
                <?php endfor; ?>
                <?php if ($page < $totalPages): ?>
                    <a href="shop.php?page=<?php echo $page + 1; ?>">&raquo;</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include 'footer.php'; ?>