<?php
include 'config.php';
session_start();
requireLogin();

$user_id = (int) $_SESSION['user_id'];

// Fetch data
$profile_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `user_profile` WHERE user_id='$user_id'")) ?? ['number' => '', 'address' => '', 'profile_image' => ''];
$user_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `users` WHERE id='$user_id'"));

// Handle update
if (isset($_POST['update_profile'])) {
    $user_updates = [];
    if (!empty($_POST['name'])) {
        $name = sanitize($conn, $_POST['name']);
        $user_updates[] = "name='$name'";
    }
    if (!empty($_POST['email'])) {
        $email = sanitize($conn, $_POST['email']);
        $user_updates[] = "email='$email'";
    }
    if (!empty($user_updates)) {
        mysqli_query($conn, "UPDATE `users` SET " . implode(", ", $user_updates) . " WHERE id='$user_id'");
        if (!empty($_POST['name']))
            $_SESSION['user_name'] = $_POST['name'];
        if (!empty($_POST['email']))
            $_SESSION['user_email'] = $_POST['email'];
    }

    $check = mysqli_query($conn, "SELECT user_id FROM `user_profile` WHERE user_id='$user_id'");
    if (mysqli_num_rows($check) == 0) {
        mysqli_query($conn, "INSERT INTO `user_profile` (user_id) VALUES ('$user_id')");
    }

    $profile_updates = [];
    if (!empty($_POST['number'])) {
        $number = sanitize($conn, $_POST['number']);
        $profile_updates[] = "number='$number'";
    }
    if (!empty($_POST['address'])) {
        $address = sanitize($conn, $_POST['address']);
        $profile_updates[] = "address='$address'";
    }
    if (!empty($_FILES['profile_image']['name'])) {
        $profile_image = time() . "_" . $_FILES['profile_image']['name'];
        $profile_tmp = $_FILES['profile_image']['tmp_name'];
        move_uploaded_file($profile_tmp, "uploaded_img/$profile_image");
        $profile_updates[] = "profile_image='$profile_image'";
    }
    if (!empty($profile_updates)) {
        mysqli_query($conn, "UPDATE `user_profile` SET " . implode(", ", $profile_updates) . " WHERE user_id='$user_id'");
    }

    flashMessage('success', 'Profile updated successfully!');
    redirect('profile.php');
}
?>
<?php include 'header.php'; ?>

<div class="page-banner">
    <h2>My Profile</h2>
    <p class="breadcrumb"><a href="home.php">Home</a> / Profile</p>
</div>

<section class="section">
    <div class="container">
        <div class="profile-layout">

            <div class="profile-header-section">
                <div class="profile-pic-wrap">
                    <img id="profilePicPreview"
                        src="<?php echo !empty($profile_data['profile_image']) ? 'uploaded_img/' . e($profile_data['profile_image']) : 'images/user.png'; ?>"
                        alt="Profile Picture">
                </div>
                <h3 style="font-size:2rem;font-weight:700;"><?php echo e($user_data['name'] ?? ''); ?></h3>
                <p style="color:var(--gray-500);font-size:1.4rem;"><?php echo e($user_data['email'] ?? ''); ?></p>
            </div>

            <form action="" method="post" enctype="multipart/form-data">
                <div class="profile-form-grid">
                    <div class="form-group">
                        <label class="form-label">Profile Picture</label>
                        <input type="file" name="profile_image" id="profilePicInput" accept="image/*"
                            class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control"
                            value="<?php echo e($user_data['name'] ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control"
                            value="<?php echo e($user_data['email'] ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Phone Number</label>
                        <input type="number" name="number" class="form-control"
                            value="<?php echo e($profile_data['number'] ?? ''); ?>">
                    </div>
                    <div class="form-group full-col">
                        <label class="form-label">Address</label>
                        <textarea name="address"
                            class="form-control"><?php echo e($profile_data['address'] ?? ''); ?></textarea>
                    </div>
                    <div class="full-col">
                        <button type="submit" name="update_profile" class="btn btn-lg btn-block">
                            <i class="fas fa-save"></i> Update Profile
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</section>

<?php include 'footer.php'; ?>