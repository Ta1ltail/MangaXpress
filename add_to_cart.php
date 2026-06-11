<?php
include 'config.php';
session_start();
requireLogin();

$user_id = (int) $_SESSION['user_id'];

if (isset($_POST['add_to_cart'])) {
    $pname = sanitize($conn, $_POST['product_name'] ?? '');
    $pprice = (int) ($_POST['product_price'] ?? 0);
    $pimage = sanitize($conn, $_POST['product_image'] ?? '');
    $pqty = max(1, (int) ($_POST['product_quantity'] ?? 1));

    $check = mysqli_query($conn, "SELECT id FROM cart WHERE name='$pname' AND user_id=$user_id");
    if (mysqli_num_rows($check) > 0) {
        flashMessage('info', 'Already in your cart!');
    } else {
        mysqli_query($conn, "INSERT INTO cart(user_id,name,price,quantity,image) VALUES($user_id,'$pname',$pprice,$pqty,'$pimage')");
        flashMessage('success', 'Added to cart!');
    }
}

redirect('home.php');