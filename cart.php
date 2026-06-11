<?php
include 'config.php';
session_start();
requireLogin();

$user_id = (int) $_SESSION['user_id'];

// Update quantity
if (isset($_POST['update_cart'])) {
   $cart_id = (int) $_POST['cart_id'];
   $cart_qty = max(1, (int) $_POST['cart_quantity']);
   mysqli_query($conn, "UPDATE cart SET quantity=$cart_qty WHERE id=$cart_id AND user_id=$user_id");
   flashMessage('success', 'Cart updated.');
   redirect('cart.php');
}

// Delete one item
if (isset($_GET['delete'])) {
   $del = (int) $_GET['delete'];
   mysqli_query($conn, "DELETE FROM cart WHERE id=$del AND user_id=$user_id");
   flashMessage('info', 'Item removed.');
   redirect('cart.php');
}

// Delete all
if (isset($_GET['delete_all'])) {
   mysqli_query($conn, "DELETE FROM cart WHERE user_id=$user_id");
   flashMessage('info', 'Cart cleared.');
   redirect('cart.php');
}

$cartItems = mysqli_query($conn, "SELECT * FROM cart WHERE user_id=$user_id");
$grandTotal = 0;
$items = [];
if ($cartItems) {
   while ($item = mysqli_fetch_assoc($cartItems)) {
      $item['subtotal'] = $item['price'] * $item['quantity'];
      $grandTotal += $item['subtotal'];
      $items[] = $item;
   }
}
?>
<?php include 'header.php'; ?>

<div class="page-banner">
   <h2>Shopping Cart</h2>
   <p class="breadcrumb"><a href="home.php">Home</a> / Cart</p>
</div>

<section class="section">
   <div class="container">
      <?php if (count($items) > 0): ?>

         <div class="cart-grid">
            <?php foreach ($items as $item): ?>
               <div class="cart-item-card">
                  <a href="cart.php?delete=<?php echo $item['id']; ?>" class="remove-btn"
                     data-confirm="Remove this item from your cart?">
                     <i class="fas fa-times"></i>
                  </a>
                  <img src="uploaded_img/<?php echo e($item['image']); ?>" alt="<?php echo e($item['name']); ?>">
                  <div class="cart-item-name"><?php echo e($item['name']); ?></div>
                  <div class="cart-item-price">₱<?php echo number_format($item['price']); ?></div>
                  <form method="post"
                     style="display:flex;align-items:center;gap:.8rem;justify-content:center;margin-top:.8rem;">
                     <input type="hidden" name="cart_id" value="<?php echo $item['id']; ?>">
                     <input class="form-control" type="number" name="cart_quantity" value="<?php echo $item['quantity']; ?>"
                        min="1" style="width:8rem;text-align:center;font-size:1.6rem;">
                     <button type="submit" name="update_cart" class="btn btn-secondary btn-sm">Update</button>
                  </form>
                  <div class="cart-item-sub">
                     Subtotal: <span>₱<?php echo number_format($item['subtotal']); ?></span>
                  </div>
               </div>
            <?php endforeach; ?>
         </div>

         <div class="cart-summary">
            <div style="font-size:1.6rem;color:var(--gray-500);">Grand Total</div>
            <div class="total-price">₱<?php echo number_format($grandTotal); ?></div>
            <div class="cart-summary-actions">
               <a href="shop.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Continue Shopping</a>
               <a href="cart.php?delete_all" class="btn btn-danger" data-confirm="Clear your entire cart?">
                  <i class="fas fa-trash"></i> Clear Cart
               </a>
               <a href="checkout.php" class="btn"><i class="fas fa-credit-card"></i> Checkout</a>
            </div>
         </div>

      <?php else: ?>
         <div class="empty-state">
            <i class="fas fa-shopping-cart"></i>
            <h3>Your cart is empty</h3>
            <p>Add some manga to get started!</p>
            <a href="shop.php" class="btn mt-2"><i class="fas fa-store"></i> Browse Shop</a>
         </div>
      <?php endif; ?>
   </div>
</section>

<?php include 'footer.php'; ?>