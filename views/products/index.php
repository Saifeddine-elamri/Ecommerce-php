<?php require_once 'views/templates/header.php'; ?>
<h1>Products</h1>
<?php if (isset($_GET['error']) && $_GET['error'] === 'stock_insuffisant'): ?>
    <p style="color: red;">Stock insuffisant pour cet article.</p>
<?php endif; ?>
<div class="products">
    <?php foreach ($products as $product): ?>
        <div class="product">
            <h2><?php echo $product['name']; ?></h2>
            <p>$<?php echo $product['price']; ?></p>
            <p>Stock: <?php echo $product['stock']; ?></p>
            <form method="POST" action="/cart/add">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <input type="number" name="quantity" min="1" max="<?php echo $product['stock']; ?>" value="1" required>
                <button type="submit">Ajouter au panier</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>
<?php require_once 'views/templates/footer.php'; ?>