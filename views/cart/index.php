<?php require_once 'views/templates/header.php'; ?>
<h1>Shopping Cart</h1>
<div class="cart">
    <?php if (empty($products)): ?>
        <p>Votre panier est vide.</p>
    <?php else: ?>
        <?php foreach ($products as $item): ?>
            <div class="cart-item">
                <p><?php echo $item['name']; ?> - $<?php echo $item['price']; ?> x <?php echo $item['quantity']; ?></p>
                <form method="POST" action="/cart/remove">
                    <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                    <button type="submit" class="btn-delete">Supprimer</button>
                </form>
            </div>
        <?php endforeach; ?>
        <p><strong>Total: $<?php echo number_format($total, 2); ?></strong></p>
        <a href="/order" class="btn">Passer la commande</a>
    <?php endif; ?>
</div>
<?php require_once 'views/templates/footer.php'; ?>