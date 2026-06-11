<?php
include 'config.php';
session_start();
requireLogin();

$user_id = $_SESSION['user_id'];

if (isset($_POST['send'])) {
   $name = sanitize($conn, $_POST['name'] ?? '');
   $email = sanitize($conn, $_POST['email'] ?? '');
   $number = $_POST['number'];
   $msg = sanitize($conn, $_POST['message'] ?? '');

   $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name='$name' AND email='$email' AND number='$number' AND message='$msg'") or die('query failed');

   if (mysqli_num_rows($select_message) > 0) {
      flashMessage('info', 'Message already sent!');
   } else {
      mysqli_query($conn, "INSERT INTO `message`(user_id, name, email, number, message) VALUES('$user_id', '$name', '$email', '$number', '$msg')") or die('query failed');
      flashMessage('success', 'Message sent successfully!');
   }
   redirect('contact.php');
}
?>
<?php include 'header.php'; ?>

<div class="page-banner">
   <h2>Contact Us</h2>
   <p class="breadcrumb"><a href="home.php">Home</a> / Contact</p>
</div>

<section class="section">
   <div class="container">
      <div class="contact-wrap">
         <h3>Say Something!</h3>
         <p>We'd love to hear from you. Drop us a quick message!</p>
         <form action="" method="post">
            <div class="form-group">
               <label class="form-label">Your Name</label>
               <input type="text" name="name" required placeholder="Enter your name" class="form-control">
            </div>
            <div class="form-group">
               <label class="form-label">Email Address</label>
               <input type="email" name="email" required placeholder="Enter your email" class="form-control">
            </div>
            <div class="form-group">
               <label class="form-label">Phone Number</label>
               <input type="number" name="number" required placeholder="Enter your number" class="form-control">
            </div>
            <div class="form-group">
               <label class="form-label">Message</label>
               <textarea name="message" class="form-control" placeholder="Enter your message" required></textarea>
            </div>
            <button type="submit" name="send" class="btn btn-block btn-lg">
               <i class="fas fa-paper-plane"></i> Send Message
            </button>
         </form>
      </div>
   </div>
</section>

<?php include 'footer.php'; ?>