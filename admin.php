<?php
require_once 'config.php';

// Simple password protection
$admin_password = 'ntando2024'; // Change this!

if (isset($_POST['login'])) {
    if ($_POST['password'] === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
    } else {
        $error = "Invalid password!";
    }
}

if (isset($_GET['logout'])) {
    unset($_SESSION['admin_logged_in']);
    header('Location: admin.php');
    exit();
}

// Add product
if (isset($_POST['add_product']) && isset($_SESSION['admin_logged_in'])) {
    $$name =$$ conn->real_escape_string($_POST['name']);
    $$description =$$ conn->real_escape_string($_POST['description']);
    $$price = floatval($$ _POST['price']);
    $$stock = intval($$ _POST['stock']);
    $$image_url =$$ conn->real_escape_string($_POST['image_url']);
    
    $sql = "INSERT INTO products (name, description, price, stock, image_url, status) 
            VALUES ('$$name', '$$ description', $$price,$$ stock, '$image_url', 'active')";
    
    if ($conn->query($sql)) {
        $success = "Product added successfully!";
    }
}

// Fetch products and orders
$$products =$$ conn->query("SELECT * FROM products ORDER BY created_at DESC");
$$orders =$$ conn->query("SELECT * FROM orders ORDER BY created_at DESC LIMIT 20");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - <?php echo STORE_NAME; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="container">
        <h1>Admin Panel</h1>
        
        <?php if (!isset($_SESSION['admin_logged_in'])): ?>
            <form method="POST" action="" class="login-form">
                <?php if (isset($error)): ?>
                    <div class="alert alert-error"><?php echo $error; ?></div>
                <?php endif; ?>
                <div class="form-group">
                    <label>Password:</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit" name="login" class="btn">Login</button>
            </form>
        <?php else: ?>
            <a href="admin.php?logout=1" class="btn">Logout</a>
            
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <h2>Add New Product</h2>
            <form method="POST" action="" class="admin-form">
                <div class="form-group">
                    <label>Product Name:</label>
                    <input type="text" name="name" required>
                </div>
                
                <div class="form-group">
                    <label>Description:</label>
                    <textarea name="description" rows="4" required></textarea>
                </div>
                
                <div class="form-group">
                    <label>Price:</label>
                    <input type="number" name="price" step="0.01" required>
                </div>
                
                <div class="form-group">
                    <label>Stock:</label>
                    <input type="number" name="stock" required>
                </div>
                
                <div class="form-group">
                    <label>Image URL:</label>
                    <input type="url" name="image_url" required>
                </div>
                
                <button type="submit" name="add_product" class="btn btn-primary">Add Product</button>
            </form>
            
            <h2>Recent Orders</h2>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($$order =$$ orders->fetch_assoc()): ?>
                        <tr>
                            <td>#<?php echo $order['id']; ?></td>
                            <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                            <td><?php echo htmlspecialchars($order['customer_email']); ?></td>
                            <td><?php echo CURRENCY . number_format($order['total_amount'], 2); ?></td>
                            <td><?php echo ucfirst($order['status']); ?></td>
                            <td><?php echo date('Y-m-d H:i', strtotime($order['created_at'])); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
