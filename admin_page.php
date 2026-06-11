<?php
include 'config.php';
session_start();
requireAdmin();
?>
<?php include 'admin_header.php'; ?>

<h1 class="page-title"><i class="fas fa-gauge"></i> Dashboard</h1>

<?php
$total_pendings = 0;
$total_completed = 0;

$rp = mysqli_query($conn, "SELECT total_price FROM `orders` WHERE payment_status='pending'");
while ($row = mysqli_fetch_assoc($rp))
   $total_pendings += $row['total_price'];

$rc = mysqli_query($conn, "SELECT total_price FROM `orders` WHERE payment_status='completed'");
while ($row = mysqli_fetch_assoc($rc))
   $total_completed += $row['total_price'];

$num_orders = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM `orders`"));
$num_products = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM `products`"));
$num_users = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM `users` WHERE user_type='user'"));
$num_admins = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM `users` WHERE user_type='admin'"));
$num_accounts = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM `users`"));
$num_messages = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM `message`"));
?>

<div class="stat-grid">
   <div class="stat-card">
      <div class="stat-icon gold"><i class="fas fa-clock"></i></div>
      <div class="stat-info">
         <div class="value">₱<?php echo number_format($total_pendings); ?></div>
         <div class="label">Total Pending</div>
      </div>
   </div>
   <div class="stat-card">
      <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
      <div class="stat-info">
         <div class="value">₱<?php echo number_format($total_completed); ?></div>
         <div class="label">Completed Payments</div>
      </div>
   </div>
   <div class="stat-card">
      <div class="stat-icon blue"><i class="fas fa-clipboard-list"></i></div>
      <div class="stat-info">
         <div class="value"><?php echo $num_orders; ?></div>
         <div class="label">Orders Placed</div>
      </div>
   </div>
   <div class="stat-card">
      <div class="stat-icon red"><i class="fas fa-book-open"></i></div>
      <div class="stat-info">
         <div class="value"><?php echo $num_products; ?></div>
         <div class="label">Products Added</div>
      </div>
   </div>
   <div class="stat-card">
      <div class="stat-icon blue"><i class="fas fa-users"></i></div>
      <div class="stat-info">
         <div class="value"><?php echo $num_users; ?></div>
         <div class="label">Normal Users</div>
      </div>
   </div>
   <div class="stat-card">
      <div class="stat-icon purple"><i class="fas fa-user-shield"></i></div>
      <div class="stat-info">
         <div class="value"><?php echo $num_admins; ?></div>
         <div class="label">Admin Users</div>
      </div>
   </div>
   <div class="stat-card">
      <div class="stat-icon gold"><i class="fas fa-user-circle"></i></div>
      <div class="stat-info">
         <div class="value"><?php echo $num_accounts; ?></div>
         <div class="label">Total Accounts</div>
      </div>
   </div>
   <div class="stat-card">
      <div class="stat-icon red"><i class="fas fa-envelope"></i></div>
      <div class="stat-info">
         <div class="value"><?php echo $num_messages; ?></div>
         <div class="label">New Messages</div>
      </div>
   </div>
</div>

<?php include 'admin_footer.php'; ?>