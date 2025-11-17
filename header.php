<?php
$$cart_count = isset($$ _SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>
<header>
    <nav class="navbar">
        <div class="container">
            <a href="index.php" class="logo"><?php echo STORE_NAME; ?></a>
            <ul class="nav-menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="cart.php">Cart (<?php echo $cart_count; ?>)</a></li>
                <li><a href="admin.php">Admin</a></li>
            </ul>
        </div>
    </nav>
</header>
