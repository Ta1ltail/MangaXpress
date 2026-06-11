<?php
include 'config.php';
session_start();

if (isLoggedIn())
   redirect('home.php');
if (isAdmin())
   redirect('admin_page.php');

if (isset($_POST['submit'])) {
   $name = sanitize($conn, $_POST['name'] ?? '');
   $email = sanitize($conn, $_POST['email'] ?? '');
   $pass = md5($_POST['password'] ?? '');
   $cpass = md5($_POST['cpassword'] ?? '');
   $user_type = 'user';

   if (empty($name) || empty($email)) {
      $error = 'Please fill in all fields.';
   } elseif ($pass !== $cpass) {
      $error = 'Passwords do not match.';
   } else {
      $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email' LIMIT 1");
      if (mysqli_num_rows($check) > 0) {
         $error = 'An account with that email already exists.';
      } else {
         mysqli_query($conn, "INSERT INTO users(name,email,password,user_type) VALUES('$name','$email','$cpass','$user_type')");
         flashMessage('success', 'Account created! Please sign in.');
         redirect('login.php');
      }
   }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register – MangaXpress</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
   <style>
      body {
         padding-top: 0;
         background: #0a0a14;
      }

      body::before {
         display: none;
      }
   </style>
</head>

<body>

   <!-- Video Background -->
   <video autoplay muted loop playsinline class="auth-video-bg">
      <source src="images/video.mp4" type="video/mp4">
   </video>
   <div class="auth-bg-overlay"></div>

   <div class="auth-page">
      <!-- Left panel -->
      <div class="auth-left">
         <a href="home.php" style="display:block;margin-bottom:3rem;">
            <img src="images/logo.gif" alt="MangaXpress"
               style="height:56px;filter:drop-shadow(0 0 12px rgba(232,25,44,.6));"
               onerror="this.style.display='none';">
         </a>
         <h1>Join<br><span>Us</span></h1>
         <p>Create your account and unlock the full MangaXpress experience – exclusive deals, order tracking, and more.
         </p>
         <div class="auth-social">
            <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
            <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
         </div>
      </div>

      <!-- Right panel -->
      <div class="auth-right">
         <div class="auth-box">
            <h2>Create Account</h2>
            <p class="auth-subtitle">Already have one? <a href="login.php">Sign in</a></p>

            <?php if (!empty($error)): ?>
               <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> <?php echo e($error); ?></div>
            <?php endif; ?>

            <form method="post" action="" novalidate>
               <div class="form-group">
                  <label class="form-label" for="name">Full Name</label>
                  <input class="form-control" type="text" id="name" name="name" placeholder="Your name" required
                     value="<?php echo e($_POST['name'] ?? ''); ?>">
               </div>
               <div class="form-group">
                  <label class="form-label" for="email">Email Address</label>
                  <input class="form-control" type="email" id="email" name="email" placeholder="you@example.com"
                     required value="<?php echo e($_POST['email'] ?? ''); ?>">
               </div>
               <div class="form-group">
                  <label class="form-label" for="password">Password</label>
                  <input class="form-control" type="password" id="password" name="password"
                     placeholder="Choose a password" required>
               </div>
               <div class="form-group">
                  <label class="form-label" for="cpassword">Confirm Password</label>
                  <input class="form-control" type="password" id="cpassword" name="cpassword"
                     placeholder="Repeat your password" required>
               </div>
               <button type="submit" name="submit" class="btn btn-block btn-lg mt-2">
                  <i class="fas fa-user-plus"></i> Create Account
               </button>
            </form>

            <p class="auth-footer">
               Already registered? <a href="login.php">Sign in here</a>
            </p>
         </div>
      </div>
   </div>

</body>

</html>