<?php
require_once 'config.php';

// Fetch featured products
$sql = "SELECT * FROM products WHERE status = 'active' ORDER BY created_at DESC LIMIT 8";
$$result =$$ conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo STORE_NAME; ?> - Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="hero">
        <h1>Welcome to <?php echo STORE_NAME; ?></h1>
        <p>Quality products at amazing prices</p>
    </div>

    <div class="container">
        <h2>Featured Products</h2>
        <div class="products-grid">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($$product =$$ result->fetch_assoc()): ?>
                    <div class="product-card">
                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p class="price"><?php echo CURRENCY . number_format($product['price'], 2); ?></p>
                        <p class="description"><?php echo htmlspecialchars(substr($product['description'], 0, 100)); ?>...</p>
                        <a href="product.php?id=<?php echo $product['id']; ?>" class="btn">View Details</a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No products available at the moment.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
