<?php require_once 'views/templates/header.php'; ?>

<!-- Conteneur des commandes de l'utilisateur -->
<section class="orders-container py-12">
    <div class="container mx-auto px-6 bg-white rounded-lg shadow-xl">
        <h1 class="text-3xl font-bold text-center text-blue-600 mb-6">Vos Commandes</h1>

        <!-- Si des commandes existent, afficher un tableau -->
        <?php if (isset($orders) && is_array($orders) && !empty($orders)): ?>
            <table class="table-auto w-full text-left mb-6">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b text-gray-600">ID Commande</th>
                        <th class="py-2 px-4 border-b text-gray-600">Date</th>
                        <th class="py-2 px-4 border-b text-gray-600">Total</th>
                        <th class="py-2 px-4 border-b text-gray-600">Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($order['id']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo number_format($order['total'], 2, ',', ' ') . ' €'; ?></td>
                            <td class="py-2 px-4 border-b"><?php echo ucfirst($order['status']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center text-gray-600">Vous n'avez encore passé aucune commande.</p>
        <?php endif; ?>

        <!-- Bouton retour aux produits -->
        <div class="text-center mt-6">
            <a href="/products" class="btn bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition duration-200">
                Retour aux produits
            </a>
        </div>
    </div>
</section>

<?php require_once 'views/templates/footer.php'; ?>
