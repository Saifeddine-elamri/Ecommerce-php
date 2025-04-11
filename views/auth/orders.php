<?php require_once 'views/templates/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Mes Commandes</h1>
        <div class="text-sm text-gray-500"><?php echo count($orders) > 0 ? count(array_unique(array_column($orders, 'id'))) . ' commande(s)' : 'Aucune commande'; ?></div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <?php if (empty($orders)): ?>
            <div class="p-8 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">Aucune commande passée</h3>
                <p class="mt-1 text-gray-500">Vous n'avez pas encore passée de commande.</p>
                <div class="mt-6">
                    <a href="/products" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Voir nos produits
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Commande #</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produit</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix unitaire</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php 
                        $currentOrderId = null;
                        $orderGroupCount = 0;
                        ?>
                        
                        <?php foreach ($orders as $index => $order): ?>
                            <?php if ($currentOrderId !== $order['id']): ?>
                                <?php 
                                $orderGroupCount++;
                                $rowClass = $orderGroupCount % 2 === 0 ? 'bg-gray-50' : 'bg-white';
                                ?>
                                <tr class="<?php echo $rowClass; ?>">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        #<?php echo $order['id']; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            <?php echo ucfirst($order['status'] ?? 'complété'); ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo $order['name']; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo $order['quantity']; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo number_format($order['price'], 2, ',', ' '); ?> €
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <?php echo number_format($order['total'], 2, ',', ' '); ?> €
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="/orders/<?php echo $order['id']; ?>" class="text-indigo-600 hover:text-indigo-900 mr-3">Détails</a>
                                        <a href="#" class="text-indigo-600 hover:text-indigo-900">Facture</a>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <tr class="<?php echo $rowClass; ?>">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo $order['name']; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo $order['quantity']; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo number_format($order['price'], 2, ',', ' '); ?> €
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"></td>
                                </tr>
                            <?php endif; ?>
                            
                            <?php $currentOrderId = $order['id']; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="bg-gray-50 px-6 py-4 flex items-center justify-between border-t border-gray-200">
                <div class="text-sm text-gray-500">
                    Affichage de <span class="font-medium">1</span> à <span class="font-medium"><?php echo min(10, count($orders)); ?></span> sur <span class="font-medium"><?php echo count($orders); ?></span> résultats
                </div>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Précédent
                    </button>
                    <button class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Suivant
                    </button>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once 'views/templates/footer.php'; ?>