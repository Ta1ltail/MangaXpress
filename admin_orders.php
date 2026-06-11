<?php
include 'config.php';
session_start();
requireAdmin();

if (isset($_POST['update_order'])) {
   $oid = (int) $_POST['order_id'];
   $status = sanitize($conn, $_POST['update_payment']);
   mysqli_query($conn, "UPDATE `orders` SET payment_status='$status' WHERE id=$oid");
   flashMessage('success', 'Payment status updated.');
   redirect('admin_orders.php');
}

if (isset($_GET['delete'])) {
   $del = (int) $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `orders` WHERE id=$del");
   flashMessage('info', 'Order deleted.');
   redirect('admin_orders.php');
}
?>
<?php include 'admin_header.php'; ?>

<h1 class="page-title"><i class="fas fa-clipboard-list"></i> Orders</h1>

<?php
$orders = mysqli_query($conn, "SELECT * FROM `orders` ORDER BY id DESC");
if (mysqli_num_rows($orders) > 0):
   ?>
   <div class="admin-card">
      <div class="admin-card-header">
         <h2>All Orders</h2>
         <span style="font-size:1.3rem;color:var(--gray-500);"><?php echo mysqli_num_rows($orders); ?> total</span>
      </div>
      <div class="table-wrap">
         <table class="data-table">
            <thead>
               <tr>
                  <th>#ID</th>
                  <th>Placed On</th>
                  <th>Customer</th>
                  <th>Contact</th>
                  <th>Address</th>
                  <th>Items</th>
                  <th>Total</th>
                  <th>Method</th>
                  <th>Status</th>
                  <th>Actions</th>
               </tr>
            </thead>
            <tbody>
               <?php
               // reset pointer
               mysqli_data_seek($orders, 0);
               while ($o = mysqli_fetch_assoc($orders)):
                  ?>
                  <tr>
                     <td><?php echo $o['id']; ?></td>
                     <td><?php echo e($o['placed_on']); ?></td>
                     <td>
                        <div style="font-weight:600;"><?php echo e($o['name']); ?></div>
                        <div style="font-size:1.2rem;color:var(--gray-500);"><?php echo e($o['email']); ?></div>
                     </td>
                     <td><?php echo e($o['number']); ?></td>
                     <td style="max-width:18rem;white-space:normal;"><?php echo e($o['address']); ?></td>
                     <td style="max-width:20rem;white-space:normal;"><?php echo e($o['total_products']); ?></td>
                     <td style="color:var(--crimson);font-weight:700;">₱<?php echo number_format($o['total_price']); ?></td>
                     <td><?php echo e($o['method']); ?></td>
                     <td>
                        <span class="badge badge-<?php echo e($o['payment_status']); ?>">
                           <?php echo e($o['payment_status']); ?>
                        </span>
                     </td>
                     <td>
                        <form method="post" style="display:flex;gap:.5rem;align-items:center;flex-wrap:wrap;">
                           <input type="hidden" name="order_id" value="<?php echo $o['id']; ?>">
                           <select name="update_payment" class="form-control"
                              style="width:auto;padding:.6rem 1rem;font-size:1.3rem;">
                              <option value="pending" <?php if ($o['payment_status'] === 'pending')
                                 echo 'selected'; ?>>Pending
                              </option>
                              <option value="completed" <?php if ($o['payment_status'] === 'completed')
                                 echo 'selected'; ?>>
                                 Completed</option>
                              <option value="cancelled" <?php if ($o['payment_status'] === 'cancelled')
                                 echo 'selected'; ?>>
                                 Cancelled</option>
                           </select>
                           <button type="submit" name="update_order" class="btn btn-gold btn-sm">Update</button>
                        </form>
                        <a href="admin_orders.php?delete=<?php echo $o['id']; ?>" class="btn btn-danger btn-sm"
                           style="margin-top:.4rem;" data-confirm="Delete this order?">
                           <i class="fas fa-trash"></i>
                        </a>
                     </td>
                  </tr>
               <?php endwhile; ?>
            </tbody>
         </table>
      </div>
   </div>
<?php else: ?>
   <div class="empty-state">
      <i class="fas fa-clipboard"></i>
      <h3>No orders yet</h3>
      <p>Orders will appear here once customers start purchasing.</p>
   </div>
<?php endif; ?>

<?php include 'admin_footer.php'; ?>