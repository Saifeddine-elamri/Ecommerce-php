<?php require_once 'views/templates/header.php'; ?>
<h1>Mes Commandes</h1>
<div class="cart">
    <?php if (empty($orders)): ?>
        <p>Aucune commande passée.</p>
    <?php else: ?>
        <?php $currentOrderId = null; ?>
        <?php foreach ($orders as $order): ?>
            <?php if ($currentOrderId !== $order['id']): ?>
                <?php if ($currentOrderId !== null): ?>
                    </div>
                <?php endif; ?>
                <div class="order">
                    <h2>Commande #<?php echo $order['id']; ?> - $<?php echo $order['total']; ?> (<?php echo $order['created_at']; ?>)</h2>
                <?php $currentOrderId = $order['id']; ?>
            <?php endif; ?>
            <p><?php echo $order['name']; ?> - $<?php echo $order['price']; ?> x <?php echo $order['quantity']; ?></p>
        <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<?php require_once 'views/templates/footer.php'; ?>