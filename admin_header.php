<?php
// admin_header.php
if (session_status() === PHP_SESSION_NONE)
   session_start();
$_aflash = getFlash();
$_aname = $_SESSION['admin_name'] ?? 'Admin';
$_aemail = $_SESSION['admin_email'] ?? '';
$_currentAdminPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>MangaXpress Admin</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   <link rel="stylesheet" href="css/admin_style.css">
</head>

<body>
   <div class="admin-layout">

      <?php if ($_aflash): ?>
         <div class="flash-msg alert-<?php echo e($_aflash['type']); ?>">
            <span><?php echo e($_aflash['text']); ?></span>
            <span class="close-flash">&times;</span>
         </div>
      <?php endif; ?>

      <!-- Sidebar -->
      <aside class="admin-sidebar" id="adminSidebar">
         <div class="sidebar-logo">Manga<span>X</span> <small
               style="font-size:1.2rem;color:rgba(255,255,255,.4);font-family:Inter,sans-serif;">Admin</small></div>
         <nav class="sidebar-nav">
            <?php
            $adminNav = [
               'admin_page.php' => ['fa-gauge', 'Dashboard'],
               'admin_products.php' => ['fa-book-open', 'Products'],
               'admin_orders.php' => ['fa-clipboard-list', 'Orders'],
               'admin_users.php' => ['fa-users', 'Users'],
               'admin_contacts.php' => ['fa-envelope', 'Messages'],
            ];
            foreach ($adminNav as $href => [$icon, $label]) {
               $active = ($_currentAdminPage === $href) ? ' active' : '';
               echo "<a href=\"$href\" class=\"$active\"><i class=\"fas $icon\"></i>$label</a>";
            }
            ?>
         </nav>
         <div class="sidebar-footer">
            <a href="home.php"><i class="fas fa-arrow-left"></i> Back to Site</a>
         </div>
      </aside>

      <!-- Main -->
      <div class="admin-main">
         <header class="admin-topbar">
            <div style="display:flex;align-items:center;gap:1rem;">
               <button class="sidebar-toggle-btn" id="sidebarToggle" aria-label="Toggle sidebar">
                  <i class="fas fa-bars"></i>
               </button>
               <span class="topbar-title">
                  <?php echo $adminNav[$_currentAdminPage][1] ?? 'Admin Panel'; ?>
               </span>
            </div>
            <div class="topbar-actions">
               <a href="home.php" class="btn btn-secondary btn-sm" style="font-size:1.3rem;">
                  <i class="fas fa-external-link-alt"></i> View Site
               </a>
               <div class="topbar-admin">
                  <img src="images/user.png" alt="admin">
                  <div>
                     <div style="font-weight:700;font-size:1.4rem;"><?php echo e($_aname); ?></div>
                     <div style="font-size:1.2rem;color:#8a8a8a;"><?php echo e($_aemail); ?></div>
                  </div>
               </div>
               <a href="logout.php" class="btn btn-danger btn-sm">
                  <i class="fas fa-sign-out-alt"></i> Logout
               </a>
            </div>
         </header>
         <div class="admin-content">