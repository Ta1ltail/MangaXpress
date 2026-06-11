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
   redirect('search_page.php' . (!empty($_POST['search']) ? '?q=' . urlencode($_POST['search']) : ''));
}

$search_item = sanitize($conn, $_GET['q'] ?? ($_POST['search'] ?? ''));
$search_results = [];
$did_search = false;

if (!empty($search_item)) {
   $did_search = true;
   $res = mysqli_query($conn, "SELECT * FROM `products` WHERE name LIKE '%$search_item%'") or die('query failed');
   while ($row = mysqli_fetch_assoc($res)) {
      $search_results[] = $row;
   }
}
?>
<?php include 'header.php'; ?>

<div class="page-banner">
   <h2>Search</h2>
   <p class="breadcrumb"><a href="home.php">Home</a> / Search</p>
</div>

<section class="section">
   <div class="container">
      <div class="search-wrap">
         <form action="" method="post" style="display:flex;gap:1rem;width:100%;">
            <input type="text" name="search" placeholder="Search manga titles..." class="form-control"
               value="<?php echo e($search_item); ?>" style="flex:1;font-size:1.6rem;padding:1.3rem 1.8rem;">
            <button type="submit" name="submit" class="btn btn-lg">
               <i class="fas fa-search"></i> Search
            </button>
         </form>
      </div>

      <?php if ($did_search && count($search_results) > 0): ?>
         <div class="section-header">
            <p class="section-eyebrow"><?php echo count($search_results); ?> result(s) for "<?php echo e($search_item); ?>"
            </p>
         </div>
         <div class="product-grid">
            <?php foreach ($search_results as $p): ?>
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
                           <input type="hidden" name="product_quantity" id="cart_qty_<?php echo $p['id']; ?>" value="1">
                           <input type="hidden" name="search" value="<?php echo e($search_item); ?>">
                           <button type="submit" name="add_to_cart" class="btn btn-block">
                              <i class="fas fa-cart-plus"></i> Add to Cart
                           </button>
                        </form>
                        <form method="post" action="checkout.php">
                           <input type="hidden" name="buy_now_name" value="<?php echo e($p['name']); ?>">
                           <input type="hidden" name="buy_now_price" value="<?php echo (int) $p['price']; ?>">
                           <input type="hidden" name="buy_now_image" value="<?php echo e($p['image']); ?>">
                           <input type="hidden" name="buy_now_quantity" id="buy_now_qty_<?php echo $p['id']; ?>" value="1">
                           <input type="hidden" name="buy_now" value="1">
                           <button type="submit" class="btn btn-gold btn-block">
                              <i class="fas fa-bolt"></i> Buy Now
                           </button>
                        </form>
                     </div>
                  </div>
               </div>
            <?php endforeach; ?>
         </div>

      <?php elseif ($did_search): ?>
         <div class="empty-state">
            <i class="fas fa-search"></i>
            <h3>No results found</h3>
            <p>Try a different search term.</p>
         </div>

      <?php else: ?>
         <div class="empty-state">
            <i class="fas fa-book-open"></i>
            <h3>Search for manga</h3>
            <p>Type a title above to find what you're looking for.</p>
         </div>
      <?php endif; ?>
   </div>
</section>

<?php include 'footer.php'; ?>