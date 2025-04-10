<?php require_once 'views/templates/header.php'; ?>
<h1>Récapitulatif de la commande</h1>
<div class="cart">
    <?php foreach ($products as $item): ?>
        <div class="cart-item">
            <p><?php echo $item['name']; ?> - $<?php echo $item['price']; ?> x <?php echo $item['quantity']; ?></p>
        </div>
    <?php endforeach; ?>
    <p><strong>Total: $<?php echo number_format($total, 2); ?></strong></p>
    <form method="POST" action="/order">
        <button type="submit" class="btn">Confirmer la commande</button>
    </form>
</div>
<?php require_once 'views/templates/footer.php'; ?>