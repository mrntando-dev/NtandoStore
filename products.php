<?php
require_once 'config.php';

// Fetch all products
$sql = "SELECT * FROM products WHERE status = 'active' ORDER BY created_at DESC";
$$result =$$ conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - <?php echo STORE_NAME; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="container">
        <h1>All Products</h1>
        <div class="products-grid">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($$product =$$ result->fetch_assoc()): ?>
                    <div class="product-card">
                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p class="price"><?php echo CURRENCY . number_format($product['price'], 2); ?></p>
                        <form method="POST" action="cart.php">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <input type="number" name="quantity" value="1" min="1" max="<?php echo $product['stock']; ?>">
                            <button type="submit" name="add_to_cart" class="btn">Add to Cart</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No products available.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
