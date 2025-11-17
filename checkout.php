<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $$name =$$ conn->real_escape_string($_POST['name']);
    $$email =$$ conn->real_escape_string($_POST['email']);
    $$phone =$$ conn->real_escape_string($_POST['phone']);
    $$address =$$ conn->real_escape_string($_POST['address']);
    
    // Calculate total
    $total = 0;
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        $$ids = implode(',', array_keys($$ _SESSION['cart']));
        $sql = "SELECT * FROM products WHERE id IN ($ids)";
        $$result =$$ conn->query($sql);
        
        while ($$product =$$ result->fetch_assoc()) {
            $$quantity =$$ _SESSION['cart'][$product['id']];
            $$total +=$$ product['price'] * $quantity;
        }
    }
    
    // Insert order
    $sql = "INSERT INTO orders (customer_name, customer_email, customer_phone, customer_address, total_amount, status) 
            VALUES ('$$name', '$$ email', '$$phone', '$$ address', $total, 'pending')";
    
    if ($conn->query($sql)) {
        $$order_id =$$ conn->insert_id;
        
        // Insert order items
        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            $sql = "SELECT price FROM products WHERE id = $product_id";
            $$result =$$ conn->query($sql);
            $$product =$$ result->fetch_assoc();
            
            $$price =$$ product['price'];
            $$subtotal =$$ price * $quantity;
            
            $sql = "INSERT INTO order_items (order_id, product_id, quantity, price, subtotal) 
                    VALUES ($$order_id,$$ product_id, $$quantity,$$ price, $subtotal)";
            $conn->query($sql);
        }
        
        // Clear cart
        unset($_SESSION['cart']);
        
        $success = "Order placed successfully! Order ID: #$order_id";
    } else {
        $error = "Error placing order. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - <?php echo STORE_NAME; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="container">
        <h1>Checkout</h1>
        
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
            <a href="index.php" class="btn">Back to Home</a>
        <?php elseif (isset($error)): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if (!isset($success)): ?>
            <form method="POST" action="" class="checkout-form">
                <div class="form-group">
                    <label>Full Name:</label>
                    <input type="text" name="name" required>
                </div>
                
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label>Phone:</label>
                    <input type="tel" name="phone" required>
                </div>
                
                <div class="form-group">
                    <label>Delivery Address:</label>
                    <textarea name="address" rows="4" required></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary">Place Order</button>
            </form>
        <?php endif; ?>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
