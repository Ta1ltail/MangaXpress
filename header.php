<?php
// header.php – included in every user-facing page
if (session_status() === PHP_SESSION_NONE)
    session_start();

$_flash = getFlash();
$_uid = $_SESSION['user_id'] ?? null;
$_uname = $_SESSION['user_name'] ?? 'Guest';
$_uemail = $_SESSION['user_email'] ?? '';

// Profile image
$_avatar = 'images/user.png';
if ($_uid && isset($conn)) {
    $ar = mysqli_fetch_assoc(mysqli_query(
        $conn,
        "SELECT profile_image FROM user_profile WHERE user_id='" . (int) $_uid . "' LIMIT 1"
    ));
    if (!empty($ar['profile_image']))
        $_avatar = 'uploaded_img/' . e($ar['profile_image']);
}

// Cart count
$_cartCount = 0;
if ($_uid && isset($conn)) {
    $cr = mysqli_fetch_assoc(mysqli_query(
        $conn,
        "SELECT SUM(quantity) AS t FROM cart WHERE user_id='" . (int) $_uid . "'"
    ));
    $_cartCount = (int) ($cr['t'] ?? 0);
}

$_currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MangaXpress</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <?php if ($_flash): ?>
        <div class="flash-msg alert-<?php echo e($_flash['type']); ?>">
            <span><?php echo e($_flash['text']); ?></span>
            <span class="close-flash">&times;</span>
        </div>
    <?php endif; ?>

    <header class="site-header">
        <div class="inner">

            <!-- Left Nav: Home, Shop, About, Contact, Orders -->
            <nav class="main-nav main-nav-left" aria-label="Main navigation">
                <?php
                $leftLinks = [
                    'home.php' => 'Home',
                    'shop.php' => 'Shop',
                    'about.php' => 'About',
                    'contact.php' => 'Contact',
                    'orders.php' => 'Orders',
                ];
                foreach ($leftLinks as $href => $label) {
                    $active = ($_currentPage === $href) ? ' active' : '';
                    echo "<a href=\"$href\" class=\"$active\">" . e($label) . "</a>";
                }
                ?>
            </nav>

            <!-- Center Logo -->
            <a href="home.php" class="site-logo-center" title="MangaXpress Home">
                <img src="images/logo.gif" alt="MangaXpress"
                    onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                <span class="site-logo-text" style="display:none;">Manga<span>X</span>press</span>
            </a>

            <!-- Right Actions: Search, Cart, User dropdown, Hamburger -->
            <div class="header-actions-right">

                <!-- Search -->
                <a href="search_page.php" class="header-icon-btn" title="Search">
                    <i class="fas fa-search"></i>
                </a>

                <!-- Cart -->
                <a href="cart.php" class="header-icon-btn cart-icon-wrap" title="Cart">
                    <i class="fas fa-shopping-cart"></i>
                    <?php if ($_cartCount > 0): ?>
                        <span class="cart-badge"><?php echo $_cartCount; ?></span>
                    <?php endif; ?>
                </a>

                <!-- User dropdown -->
                <div class="user-dropdown">
                    <button class="user-dropdown-toggle" id="userDropdownToggle" aria-haspopup="true">
                        <img src="<?php echo e($_avatar); ?>" alt="avatar" class="user-avatar">
                        <span><?php echo e($_uname); ?></span>
                        <i class="fas fa-chevron-down" style="font-size:1rem;opacity:.55;flex-shrink:0;"></i>
                    </button>
                    <div class="user-dropdown-menu" id="userDropdownMenu" role="menu">
                        <div class="dropdown-info">
                            <div class="d-name"><?php echo e($_uname); ?></div>
                            <div class="d-email"><?php echo e($_uemail); ?></div>
                        </div>
                        <?php if ($_uid): ?>
                            <a href="profile.php" class="dropdown-menu-item"><i class="fas fa-user"></i> My Profile</a>
                            <a href="orders.php" class="dropdown-menu-item"><i class="fas fa-box"></i> My Orders</a>
                            <a href="cart.php" class="dropdown-menu-item">
                                <i class="fas fa-shopping-cart"></i> Cart
                                <?php if ($_cartCount > 0)
                                    echo "<span class='badge badge-pending' style='margin-left:auto;'>$_cartCount</span>"; ?>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="logout.php" class="dropdown-menu-item dropdown-logout">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        <?php else: ?>
                            <a href="login.php" class="dropdown-menu-item"><i class="fas fa-sign-in-alt"></i> Login</a>
                            <a href="register.php" class="dropdown-menu-item"><i class="fas fa-user-plus"></i> Register</a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Mobile hamburger -->
                <button class="hamburger" id="hamburger" aria-label="Toggle menu" aria-expanded="false">
                    <span></span><span></span><span></span>
                </button>
            </div>

        </div>
    </header>

    <!-- Mobile Nav (all links) -->
    <nav class="mobile-nav" id="mobileNav" aria-label="Mobile navigation">
        <?php
        $allNavLinks = [
            'home.php' => 'Home',
            'shop.php' => 'Shop',
            'about.php' => 'About',
            'contact.php' => 'Contact',
            'orders.php' => 'Orders',
        ];
        foreach ($allNavLinks as $href => $label) {
            $active = ($_currentPage === $href) ? ' active' : '';
            echo "<a href=\"$href\" class=\"$active\">" . e($label) . "</a>";
        }
        if ($_uid) {
            echo '<a href="profile.php"><i class="fas fa-user" style="margin-right:.8rem;color:#e8192c;"></i>Profile</a>';
            echo '<a href="cart.php"><i class="fas fa-shopping-cart" style="margin-right:.8rem;color:#e8192c;"></i>Cart (' . $_cartCount . ')</a>';
            echo '<a href="logout.php" style="color:#ff6b6b;"><i class="fas fa-sign-out-alt" style="margin-right:.8rem;"></i>Logout</a>';
        } else {
            echo '<a href="login.php"><i class="fas fa-sign-in-alt" style="margin-right:.8rem;color:#e8192c;"></i>Login</a>';
            echo '<a href="register.php"><i class="fas fa-user-plus" style="margin-right:.8rem;color:#e8192c;"></i>Register</a>';
        }
        ?>
    </nav>