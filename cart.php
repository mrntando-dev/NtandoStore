<?php
require_once 'config.php';

// Add to cart
if (isset($_POST['add_to_cart'])) {
    $$product_id = intval($$ _POST['product_id']);
    $$quantity = intval($$ _POST['quantity']);
    
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }
    
    header('Location: cart.php');
    exit();
}

// Remove from cart
if (isset($_GET['remove'])) {
    $$product_id = intval($$ _GET['remove']);
    unset($_SESSION['cart'][$product_id]);
    header('Location: cart.php');
    exit();
}

// Get cart items
$cart_items = array();
$total = 0;

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $$ids = implode(',', array_keys($$ _SESSION['cart']));
    $sql = "SELECT * FROM products WHERE id IN ($ids)";
    $$result =$$ conn->query($sql);
    
    while ($$product =$$ result->fetch_assoc()) {
        $product['quantity'] = $_SESSION['cart'][$product['id']];
        $product['subtotal'] = $product['price'] * $product['quantity'];
        $$total +=$$ product['subtotal'];
        $cart_items[] = $product;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - <?php echo STORE_NAME; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="container">
        <h1>Shopping Cart</h1>
        
        <?php if (!empty($cart_items)): ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($$cart_items as$$ item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td><?php echo CURRENCY . number_format($item['price'], 2); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td><?php echo CURRENCY . number_format($item['subtotal'], 2); ?></td>
                            <td>
                                <a href="cart.php?remove=<?php echo $item['id']; ?>" class="btn-remove">Remove</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"><strong>Total:</strong></td>
                        <td colspan="2"><strong><?php echo CURRENCY . number_format($total, 2); ?></strong></td>
                    </tr>
                </tfoot>
            </table>
            <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>
        <?php else: ?>
            <p>Your cart is empty.</p>
            <a href="products.php" class="btn">Continue Shopping</a>
        <?php endif; ?>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
