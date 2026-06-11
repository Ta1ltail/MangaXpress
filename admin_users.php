<?php
include 'config.php';
session_start();
requireAdmin();

if (isset($_GET['delete'])) {
   $del = (int) $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `users` WHERE id=$del");
   flashMessage('info', 'User deleted.');
   redirect('admin_users.php');
}
?>
<?php include 'admin_header.php'; ?>

<h1 class="page-title"><i class="fas fa-users"></i> User Accounts</h1>

<?php
$users = mysqli_query($conn, "SELECT * FROM `users` ORDER BY id DESC");
if (mysqli_num_rows($users) > 0):
   ?>
   <div class="admin-card">
      <div class="admin-card-header">
         <h2>All Users</h2>
         <span style="font-size:1.3rem;color:var(--gray-500);"><?php echo mysqli_num_rows($users); ?> accounts</span>
      </div>
      <div class="table-wrap">
         <table class="data-table">
            <thead>
               <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Type</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tbody>
               <?php
               mysqli_data_seek($users, 0);
               while ($u = mysqli_fetch_assoc($users)):
                  ?>
                  <tr>
                     <td><?php echo $u['id']; ?></td>
                     <td><?php echo e($u['name']); ?></td>
                     <td><?php echo e($u['email']); ?></td>
                     <td>
                        <span class="badge badge-<?php echo $u['user_type'] === 'admin' ? 'admin' : 'user'; ?>">
                           <?php echo e($u['user_type']); ?>
                        </span>
                     </td>
                     <td>
                        <a href="admin_users.php?delete=<?php echo $u['id']; ?>" class="btn btn-danger btn-sm"
                           data-confirm="Delete this user permanently?">
                           <i class="fas fa-trash"></i> Delete
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
      <i class="fas fa-users"></i>
      <h3>No users found</h3>
   </div>
<?php endif; ?>

<?php include 'admin_footer.php'; ?>