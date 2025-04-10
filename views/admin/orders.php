<?php require_once 'views/templates/header.php'; ?>
<h1 class="text-2xl font-bold mb-4">Gestion des commandes</h1>
<div class="bg-white p-4 rounded shadow">
    <?php if (empty($orders)): ?>
        <p>Aucune commande passée.</p>
    <?php else: ?>
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2">Commande #</th>
                    <th class="p-2">Utilisateur</th>
                    <th class="p-2">Date</th>
                    <th class="p-2">Produit</th>
                    <th class="p-2">Quantité</th>
                    <th class="p-2">Prix unitaire</th>
                    <th class="p-2">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $currentOrderId = null; ?>
                <?php foreach ($orders as $order): ?>
                    <?php if ($currentOrderId !== $order['id']): ?>
                        <tr class="border-t">
                            <td class="p-2"><?php echo $order['id']; ?></td>
                            <td class="p-2"><?php echo $order['username']; ?></td>
                            <td class="p-2"><?php echo $order['created_at']; ?></td>
                    <?php else: ?>
                        <tr>
                            <td class="p-2"></td>
                            <td class="p-2"></td>
                            <td class="p-2"></td>
                    <?php endif; ?>
                            <td class="p-2"><?php echo $order['name']; ?></td>
                            <td class="p-2"><?php echo $order['quantity']; ?></td>
                            <td class="p-2">$<?php echo $order['price']; ?></td>
                            <?php if ($currentOrderId !== $order['id']): ?>
                                <td class="p-2">$<?php echo $order['total']; ?></td>
                            <?php else: ?>
                                <td class="p-2"></td>
                            <?php endif; ?>
                        </tr>
                    <?php $currentOrderId = $order['id']; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<?php require_once 'views/templates/footer.php'; ?>