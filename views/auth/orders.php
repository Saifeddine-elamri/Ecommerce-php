<?php require_once 'views/templates/header.php'; ?>

<div class="container mx-auto px-4 py-12 max-w-7xl">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-10">
        <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight">🛒 Mes Commandes</h1>
        <span class="text-gray-500 dark:text-gray-400 text-lg">
            <?php echo count($orders) > 0 ? count(array_unique(array_column($orders, 'id'))) . ' commande(s)' : 'Aucune commande'; ?>
        </span>
    </div>

    <?php if (empty($orders)): ?>
        <div class="bg-white/60 dark:bg-gray-800/50 backdrop-blur-md shadow-xl rounded-2xl p-10 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <h2 class="mt-4 text-xl font-semibold text-gray-800 dark:text-white">Pas encore de commande</h2>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Allez voir nos produits, il y a sûrement quelque chose qui vous plaira 😄</p>
            <a href="/products" class="mt-6 inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md transition">
                Voir les produits
            </a>
        </div>
    <?php else: ?>

        <?php
        $groupedOrders = [];
        foreach ($orders as $order) {
            $groupedOrders[$order['id']][] = $order;
        }
        ?>

        <div class="space-y-8">
            <?php foreach ($groupedOrders as $orderId => $items): ?>
                <?php $first = $items[0]; ?>
                <div class="bg-white/60 dark:bg-gray-800/40 backdrop-blur-lg rounded-3xl shadow-lg p-6 transition hover:shadow-2xl border border-gray-100 dark:border-gray-700">
                    <div class="flex flex-col md:flex-row justify-between md:items-center mb-4">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Commande #<?php echo $orderId; ?></h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Passée le <?php echo date('d M Y à H:i', strtotime($first['created_at'])); ?></p>
                        </div>
                        <div class="flex flex-wrap items-center gap-3 mt-4 md:mt-0">
                            <?php
                            $status = ucfirst($first['status'] ?? 'Complété');
                            $statusIcons = [
                                'En attente' => ['🕒', 'bg-yellow-100 text-yellow-800'],
                                'Expédié' => ['🚚', 'bg-blue-100 text-blue-800'],
                                'Annulé' => ['❌', 'bg-red-100 text-red-800'],
                                'Complété' => ['✅', 'bg-green-100 text-green-800'],
                            ];
                            [$icon, $classes] = $statusIcons[$status] ?? ['✅', 'bg-green-100 text-green-800'];
                            ?>
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-medium <?php echo $classes; ?>">
                                <?php echo $icon . ' ' . $status; ?>
                            </span>
                            <a href="/orders/<?php echo $orderId; ?>" class="text-indigo-600 hover:underline text-sm">📄 Détails</a>
                            <a href="#" class="text-indigo-600 hover:underline text-sm">🧾 Facture</a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php foreach ($items as $item): ?>
                            <div class="bg-white dark:bg-gray-900 border dark:border-gray-800 rounded-xl p-4 flex flex-col shadow-sm">
                                <span class="font-semibold text-gray-800 dark:text-white"><?php echo $item['name']; ?></span>
                                <span class="text-sm text-gray-500 dark:text-gray-400 mt-1">Quantité : <?php echo $item['quantity']; ?></span>
                                <span class="text-sm text-gray-500 dark:text-gray-400">Prix : <?php echo number_format($item['price'], 2, ',', ' '); ?> €</span>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="mt-6 text-right text-xl font-bold text-gray-800 dark:text-white">
                        Total : <?php echo number_format(array_sum(array_column($items, 'total')), 2, ',', ' '); ?> €
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="mt-10 flex justify-between items-center text-sm text-gray-500 dark:text-gray-400">
            <span>Affichage de <strong>1</strong> à <strong><?php echo min(10, count($groupedOrders)); ?></strong> sur <strong><?php echo count($groupedOrders); ?></strong> commandes</span>
            <div class="flex gap-2">
                <button class="px-4 py-1.5 rounded-md border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition">← Précédent</button>
                <button class="px-4 py-1.5 rounded-md border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition">Suivant →</button>
            </div>
        </div>

    <?php endif; ?>
</div>

<?php require_once 'views/templates/footer.php'; ?>
