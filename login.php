<?php
include 'config.php';
session_start();

if (isLoggedIn())
    redirect('home.php');
if (isAdmin())
    redirect('admin_page.php');

if (isset($_POST['submit'])) {
    $email = sanitize($conn, $_POST['email'] ?? '');
    $pass = md5($_POST['password'] ?? '');

    $q = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND password='$pass' LIMIT 1");

    if ($q && mysqli_num_rows($q) > 0) {
        $row = mysqli_fetch_assoc($q);
        if ($row['user_type'] === 'admin') {
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_name'] = $row['name'];
            $_SESSION['admin_email'] = $row['email'];
            redirect('admin_page.php');
        } else {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            redirect('home.php');
        }
    } else {
        $error = 'Incorrect email or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login – MangaXpress</title>
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
            <h1>Welcome<br><span>Back</span></h1>
            <p>Your favorite manga and manhwa, delivered straight to your door. Sign in to continue your journey.</p>
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
                <h2>Sign In</h2>
                <p class="auth-subtitle">New here? <a href="register.php">Create an account</a></p>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> <?php echo e($error); ?></div>
                <?php endif; ?>

                <form method="post" action="" novalidate>
                    <div class="form-group">
                        <label class="form-label" for="email">Email Address</label>
                        <input class="form-control" type="email" id="email" name="email" placeholder="you@example.com"
                            required value="<?php echo e($_POST['email'] ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <input class="form-control" type="password" id="password" name="password"
                            placeholder="Your password" required>
                    </div>
                    <button type="submit" name="submit" class="btn btn-block btn-lg mt-2">
                        <i class="fas fa-sign-in-alt"></i> Sign In
                    </button>
                </form>

                <p class="auth-footer">
                    Don't have an account? <a href="register.php">Register now</a>
                </p>
            </div>
        </div>
    </div>

</body>

</html>