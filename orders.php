<?php
include 'config.php';
session_start();
requireLogin();

$user_id = (int) $_SESSION['user_id'];
?>
<?php include 'header.php'; ?>

<div class="page-banner">
   <h2>My Orders</h2>
   <p class="breadcrumb"><a href="home.php">Home</a> / Orders</p>
</div>

<section class="section">
   <div class="container">
      <div class="section-header">
         <p class="section-eyebrow">Order History</p>
         <h2 class="section-title">Placed Orders</h2>
      </div>

      <?php
      $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id='$user_id' ORDER BY id DESC") or die('query failed');
      if (mysqli_num_rows($order_query) > 0):
         ?>
         <div class="orders-grid">
            <?php while ($o = mysqli_fetch_assoc($order_query)): ?>
               <div class="order-card">
                  <div class="order-row">
                     <span class="label">Placed On</span>
                     <span class="value"><?php echo e($o['placed_on']); ?></span>
                  </div>
                  <div class="order-row">
                     <span class="label">Name</span>
                     <span class="value"><?php echo e($o['name']); ?></span>
                  </div>
                  <div class="order-row">
                     <span class="label">Number</span>
                     <span class="value"><?php echo e($o['number']); ?></span>
                  </div>
                  <div class="order-row">
                     <span class="label">Email</span>
                     <span class="value"><?php echo e($o['email']); ?></span>
                  </div>
                  <div class="order-row">
                     <span class="label">Address</span>
                     <span class="value"><?php echo e($o['address']); ?></span>
                  </div>
                  <div class="order-row">
                     <span class="label">Payment</span>
                     <span class="value"><?php echo e($o['method']); ?></span>
                  </div>
                  <div class="order-row">
                     <span class="label">Items</span>
                     <span class="value"><?php echo e($o['total_products']); ?></span>
                  </div>
                  <div class="order-row">
                     <span class="label">Total</span>
                     <span class="value" style="color:var(--crimson);">₱<?php echo number_format($o['total_price']); ?></span>
                  </div>
                  <div class="order-row">
                     <span class="label">Status</span>
                     <span class="value">
                        <span class="badge badge-<?php echo e($o['payment_status']); ?>">
                           <?php echo e($o['payment_status']); ?>
                        </span>
                     </span>
                  </div>
               </div>
            <?php endwhile; ?>
         </div>

      <?php else: ?>
         <div class="empty-state">
            <i class="fas fa-box-open"></i>
            <h3>No orders yet</h3>
            <p>You haven't placed any orders.</p>
            <a href="shop.php" class="btn mt-2"><i class="fas fa-store"></i> Start Shopping</a>
         </div>
      <?php endif; ?>
   </div>
</section>

<?php include 'footer.php'; ?>