<?php
include 'config.php';
session_start();
requireAdmin();

if (isset($_GET['delete'])) {
   $del = (int) $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `message` WHERE id=$del");
   flashMessage('info', 'Message deleted.');
   redirect('admin_contacts.php');
}
?>
<?php include 'admin_header.php'; ?>

<h1 class="page-title"><i class="fas fa-envelope"></i> Messages</h1>

<?php
$messages = mysqli_query($conn, "SELECT * FROM `message` ORDER BY id DESC");
if (mysqli_num_rows($messages) > 0):
   ?>
   <div class="admin-card">
      <div class="admin-card-header">
         <h2>All Messages</h2>
         <span style="font-size:1.3rem;color:var(--gray-500);"><?php echo mysqli_num_rows($messages); ?> messages</span>
      </div>
      <div class="table-wrap">
         <table class="data-table">
            <thead>
               <tr>
                  <th>ID</th>
                  <th>User ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Number</th>
                  <th>Message</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tbody>
               <?php
               mysqli_data_seek($messages, 0);
               while ($m = mysqli_fetch_assoc($messages)):
                  ?>
                  <tr>
                     <td><?php echo $m['id']; ?></td>
                     <td><?php echo $m['user_id']; ?></td>
                     <td><?php echo e($m['name']); ?></td>
                     <td><?php echo e($m['email']); ?></td>
                     <td><?php echo e($m['number']); ?></td>
                     <td style="max-width:30rem;white-space:normal;"><?php echo e($m['message']); ?></td>
                     <td>
                        <a href="admin_contacts.php?delete=<?php echo $m['id']; ?>" class="btn btn-danger btn-sm"
                           data-confirm="Delete this message?">
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
      <i class="fas fa-inbox"></i>
      <h3>No messages yet</h3>
      <p>Customer messages will appear here.</p>
   </div>
<?php endif; ?>

<?php include 'admin_footer.php'; ?>