<?php
include 'config.php';
session_start();
requireAdmin();

$message = [];

// ADD PRODUCT
if (isset($_POST['add_product'])) {
    $name        = sanitize($conn, $_POST['name']);
    $price       = (int)$_POST['price'];
    $description = sanitize($conn, $_POST['description']);
    $image       = $_FILES['image']['name'];
    $image_size  = $_FILES['image']['size'];
    $image_tmp   = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/' . $image;

    $check = mysqli_query($conn, "SELECT name FROM `products` WHERE name='$name'");
    if (mysqli_num_rows($check) > 0) {
        $message[] = ['danger', 'Product name already exists.'];
    } else {
        $ins = mysqli_query($conn, "INSERT INTO `products`(name, price, description, image) VALUES('$name', $price, '$description', '$image')");
        if ($ins) {
            if ($image_size > 2000000) {
                $message[] = ['danger', 'Image size is too large (max 2MB).'];
            } else {
                move_uploaded_file($image_tmp, $image_folder);
                $message[] = ['success', 'Product added successfully!'];
            }
        } else {
            $message[] = ['danger', 'Could not add product.'];
        }
    }
}

// DELETE PRODUCT
if (isset($_GET['delete'])) {
    $del_id = (int)$_GET['delete'];
    $img_q  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT image FROM `products` WHERE id=$del_id"));
    if ($img_q) @unlink('uploaded_img/' . $img_q['image']);
    mysqli_query($conn, "DELETE FROM `products` WHERE id=$del_id");
    flashMessage('info', 'Product deleted.');
    redirect('admin_products.php');
}

// UPDATE PRODUCT
if (isset($_POST['update_product'])) {
    $uid   = (int)$_POST['update_p_id'];
    $uname = sanitize($conn, $_POST['update_name']);
    $uprce = (int)$_POST['update_price'];
    $udesc = sanitize($conn, $_POST['update_description']);

    mysqli_query($conn, "UPDATE `products` SET name='$uname', price=$uprce, description='$udesc' WHERE id=$uid");

    $uimg      = $_FILES['update_image']['name'];
    $uimg_tmp  = $_FILES['update_image']['tmp_name'];
    $uimg_size = $_FILES['update_image']['size'];
    $old_img   = $_POST['update_old_image'];

    if (!empty($uimg)) {
        if ($uimg_size > 2000000) {
            flashMessage('danger', 'Image too large.');
        } else {
            mysqli_query($conn, "UPDATE `products` SET image='$uimg' WHERE id=$uid");
            move_uploaded_file($uimg_tmp, 'uploaded_img/' . $uimg);
            @unlink('uploaded_img/' . $old_img);
        }
    }
    flashMessage('success', 'Product updated.');
    redirect('admin_products.php');
}
?>
<?php include 'admin_header.php'; ?>

<h1 class="page-title"><i class="fas fa-book-open"></i> Products</h1>

<?php foreach ($message as [$type, $text]): ?>
    <div class="alert alert-<?php echo $type; ?>"><i class="fas fa-info-circle"></i> <?php echo e($text); ?></div>
<?php endforeach; ?>

<!-- Add Product -->
<div class="admin-card" style="margin-bottom:2.4rem;">
    <div class="admin-card-header">
        <h2><i class="fas fa-plus"></i> Add Product</h2>
    </div>
    <div class="admin-card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Product Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter product name" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Price (₱)</label>
                    <input type="number" min="0" name="price" class="form-control" placeholder="Enter price" required>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" placeholder="Enter product description" required></textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Product Image</label>
                <input type="file" name="image" accept="image/jpg,image/jpeg,image/png" class="form-control" required
                    id="addProductImg">
                <img id="addProductImgPreview" src="" alt="" style="display:none;margin-top:1rem;max-width:120px;border-radius:8px;">
            </div>
            <button type="submit" name="add_product" class="btn">
                <i class="fas fa-plus"></i> Add Product
            </button>
        </form>
    </div>
</div>

<!-- Products Grid -->
<div class="admin-card">
    <div class="admin-card-header">
        <h2>All Products</h2>
    </div>
    <div class="admin-card-body">
        <?php
        $products = mysqli_query($conn, "SELECT * FROM `products` ORDER BY id DESC");
        if (mysqli_num_rows($products) > 0):
        ?>
        <div class="admin-product-grid">
            <?php while ($p = mysqli_fetch_assoc($products)): ?>
            <div class="admin-product-card">
                <img src="uploaded_img/<?php echo e($p['image']); ?>" alt="<?php echo e($p['name']); ?>">
                <div class="admin-product-info">
                    <div class="admin-product-name" title="<?php echo e($p['name']); ?>"><?php echo e($p['name']); ?></div>
                    <div class="admin-product-price">₱<?php echo number_format($p['price']); ?></div>
                    <div class="admin-product-actions">
                        <a href="admin_products.php?update=<?php echo $p['id']; ?>" class="btn btn-gold btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="admin_products.php?delete=<?php echo $p['id']; ?>"
                           class="btn btn-danger btn-sm"
                           data-confirm="Delete this product?">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-book"></i>
            <h3>No products yet</h3>
            <p>Add your first product above.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Edit Modal -->
<?php if (isset($_GET['update'])):
    $upd_id = (int)$_GET['update'];
    $upd_q  = mysqli_query($conn, "SELECT * FROM `products` WHERE id=$upd_id");
    if ($upd_q && mysqli_num_rows($upd_q) > 0):
    $upd = mysqli_fetch_assoc($upd_q);
?>
<div class="modal-overlay open" id="editProductModal">
    <div class="modal-box" style="position:relative;">
        <h3><i class="fas fa-edit"></i> Edit Product</h3>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="update_p_id"    value="<?php echo $upd['id']; ?>">
            <input type="hidden" name="update_old_image" value="<?php echo e($upd['image']); ?>">
            <div style="text-align:center;margin-bottom:1.6rem;">
                <img src="uploaded_img/<?php echo e($upd['image']); ?>" alt=""
                    style="max-width:140px;border-radius:10px;box-shadow:0 4px 12px rgba(0,0,0,.15);">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Name</label>
                    <input type="text" name="update_name" class="form-control"
                        value="<?php echo e($upd['name']); ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Price (₱)</label>
                    <input type="number" name="update_price" class="form-control"
                        value="<?php echo (int)$upd['price']; ?>" min="0" required>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="update_description" class="form-control"><?php echo e($upd['description']); ?></textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Replace Image (optional)</label>
                <input type="file" name="update_image" class="form-control" accept="image/jpg,image/jpeg,image/png">
            </div>
            <div style="display:flex;gap:1rem;">
                <button type="submit" name="update_product" class="btn">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                <a href="admin_products.php" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
<?php endif; endif; ?>

<?php include 'admin_footer.php'; ?>