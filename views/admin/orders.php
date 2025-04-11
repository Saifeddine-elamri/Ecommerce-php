<?php require_once 'views/templates/header.php'; ?>

<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- En-tête avec animation et dégradé -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 bg-gradient-to-r from-blue-600 to-indigo-700 p-6 rounded-lg shadow-lg text-white animate-fade-in">
        <h1 class="text-3xl font-bold mb-4 md:mb-0">Gestion des Commandes</h1>
        <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 w-full md:w-auto">
            <div class="relative w-full md:w-64 transition-all duration-300 ease-in-out hover:scale-105">
                <input type="text" placeholder="Rechercher une commande..." class="w-full pl-10 pr-4 py-3 border-0 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white/90 text-gray-800 shadow-md" 
                       onFocus="this.classList.add('ring-2', 'ring-blue-400', 'shadow-lg')"
                       onBlur="this.classList.remove('ring-2', 'ring-blue-400', 'shadow-lg')">
                <svg class="absolute left-3 top-3.5 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <select class="w-full md:w-auto border-0 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white/90 text-gray-800 shadow-md cursor-pointer transition-all duration-300 ease-in-out hover:shadow-lg">
                <option>Toutes les commandes</option>
                <option>En attente</option>
                <option>Expédiées</option>
                <option>Annulées</option>
                <option>Complétées</option>
            </select>
        </div>
    </div>

    <!-- Carte principale avec ombre et animation -->
    <div class="bg-white rounded-xl shadow-xl overflow-hidden transform transition-all duration-500 hover:shadow-2xl border border-gray-100">
        <?php if (empty($orders)): ?>
            <!-- État vide amélioré -->
            <div class="p-12 text-center animate-pulse">
                <div class="rounded-full bg-indigo-100 p-6 inline-flex mx-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h3 class="mt-6 text-2xl font-medium text-gray-900">Aucune commande trouvée</h3>
                <p class="mt-3 text-lg text-gray-500 max-w-md mx-auto">Aucune commande n'a été passée pour le moment. Les nouvelles commandes apparaîtront ici.</p>
                <button class="mt-6 px-6 py-3 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 transition-colors duration-300 font-medium">Créer une commande</button>
            </div>
        <?php else: ?>
            <!-- Tableau des commandes amélioré -->
            <div class="overflow-x-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 sticky top-0 z-10">
                        <tr>
                            <?php 
                            $headers = ['Commande #', 'Utilisateur', 'Date', 'Produit', 'Qté', 'Prix Unitaire', 'Total', 'Statut', 'Actions'];
                            foreach($headers as $header): 
                            ?>
                            <th scope="col" class="<?php echo $header === 'Actions' ? 'text-right' : 'text-left'; ?> px-6 py-4 text-xs font-medium text-gray-500 uppercase tracking-wider bg-gradient-to-b from-gray-50 to-gray-100">
                                <?php echo $header; ?>
                            </th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php 
                        $currentOrderId = null;
                        $orderGroupCount = 0;
                        ?>
                        
                        <?php foreach ($orders as $order): ?>
                            <?php if ($currentOrderId !== $order['id']): ?>
                                <?php 
                                $orderGroupCount++;
                                $rowClass = $orderGroupCount % 2 === 0 ? 'bg-gray-50 hover:bg-blue-50' : 'bg-white hover:bg-blue-50';
                                ?>
                                <tr class="<?php echo $rowClass; ?> transition-colors duration-150 cursor-pointer group">
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <span class="font-semibold text-gray-900 bg-blue-100 text-blue-800 group-hover:bg-blue-200 px-3 py-1 rounded-full">#<?php echo $order['id']; ?></span>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-12 w-12">
                                                <div class="h-12 w-12 rounded-full bg-gradient-to-br from-blue-400 to-indigo-600 flex items-center justify-center text-white font-bold text-lg shadow-md">
                                                    <?php echo strtoupper(substr($order['username'], 0, 1)); ?>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-base font-medium text-gray-900"><?php echo $order['username']; ?></div>
                                                <div class="text-sm text-gray-500 flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                    </svg>
                                                    <?php echo $order['email'] ?? ''; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span class="text-gray-700"><?php echo date('d/m/Y', strtotime($order['created_at'])); ?></span>
                                            <span class="ml-2 text-xs text-gray-500"><?php echo date('H:i', strtotime($order['created_at'])); ?></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-md bg-gray-100 flex items-center justify-center mr-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                </svg>
                                            </div>
                                            <span class="text-gray-700 font-medium"><?php echo $order['name']; ?></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-medium rounded-full bg-gray-100"><?php echo $order['quantity']; ?></span>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <span class="text-gray-700"><?php echo number_format($order['price'], 2, ',', ' '); ?> €</span>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap font-semibold">
                                        <span class="text-gray-900 text-lg"><?php echo number_format($order['total'], 2, ',', ' '); ?> €</span>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <?php 
                                        $status = $order['status'] ?? 'completed';
                                        $statusClasses = match($status) {
                                            'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                            'shipped' => 'bg-blue-100 text-blue-800 border-blue-200',
                                            'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                                            default => 'bg-green-100 text-green-800 border-green-200'
                                        };
                                        $statusIcons = [
                                            'pending' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
                                            'shipped' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>',
                                            'cancelled' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>',
                                            'completed' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>'
                                        ];
                                        $icon = $statusIcons[$status] ?? $statusIcons['completed'];
                                        ?>
                                        <span class="px-3 py-1.5 inline-flex items-center text-sm font-medium rounded-full border <?php echo $statusClasses; ?>">
                                            <?php echo $icon; ?>
                                            <?php echo ucfirst($status); ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap text-right">
                                        <div class="flex justify-end space-x-3">
                                            <a href="/admin/orders/<?php echo $order['id']; ?>" 
                                               class="p-2 text-blue-600 hover:text-white hover:bg-blue-600 rounded-full transition-colors duration-200" 
                                               title="Voir détails">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="#" 
                                               class="p-2 text-gray-600 hover:text-white hover:bg-gray-600 rounded-full transition-colors duration-200" 
                                               title="Modifier statut">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <a href="#" 
                                               class="p-2 text-red-600 hover:text-white hover:bg-red-600 rounded-full transition-colors duration-200" 
                                               title="Annuler commande"
                                               onclick="return confirm('Êtes-vous sûr de vouloir annuler cette commande?')">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <tr class="<?php echo $rowClass; ?> transition-colors duration-150 group">
                                    <td class="px-6 py-4 text-sm text-gray-500"></td>
                                    <td class="px-6 py-4 text-sm text-gray-500"></td>
                                    <td class="px-6 py-4 text-sm text-gray-500"></td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-md bg-gray-100 flex items-center justify-center mr-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                </svg>
                                            </div>
                                            <span class="text-gray-700 font-medium"><?php echo $order['name']; ?></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-medium rounded-full bg-gray-100"><?php echo $order['quantity']; ?></span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                        <?php echo number_format($order['price'], 2, ',', ' '); ?> €
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500"></td>
                                    <td class="px-6 py-4 text-sm text-gray-500"></td>
                                    <td class="px-6 py-4 text-sm text-gray-500"></td>
                                </tr>
                            <?php endif; ?>
                            
                            <?php $currentOrderId = $order['id']; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination améliorée -->
            <div class="bg-gray-50 px-6 py-4 flex flex-col md:flex-row items-center justify-between border-t border-gray-200">
                <div class="text-sm text-gray-700 mb-4 md:mb-0">
                    Affichage de <span class="font-medium">1</span> à <span class="font-medium"><?php echo min(10, count($orders)); ?></span> sur <span class="font-medium"><?php echo count($orders); ?></span> résultats
                </div>
                <div class="flex items-center space-x-4">
                    <div class="hidden md:flex space-x-1 mr-4">
                        <?php for($i = 1; $i <= ceil(count($orders) / 10); $i++): ?>
                            <a href="#" class="<?php echo $i === 1 ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100'; ?> w-8 h-8 flex items-center justify-center rounded-full text-sm font-medium transition-colors duration-200">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>
                    </div>
                    <div class="flex space-x-2">
                        <button class="px-4 py-2 flex items-center border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200" disabled>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Précédent
                        </button>
                        <button class="px-4 py-2 flex items-center border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                            Suivant
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- JavaScript pour les animations et interactions -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation des lignes au survol
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.classList.add('transform', 'scale-[1.01]', 'shadow-sm', 'z-10');
        });
        row.addEventListener('mouseleave', function() {
            this.classList.remove('transform', 'scale-[1.01]', 'shadow-sm', 'z-10');
        });
    });
    
    // Animation de l'en-tête
    const header = document.querySelector('.bg-gradient-to-r');
    if (header) {
        setTimeout(() => {
            header.classList.add('opacity-100');
            header.classList.remove('opacity-0');
        }, 100);
    }
});
</script>

<style>
/* Animations personnalisées */
.animate-fade-in {
    animation: fadeIn 0.6s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Scrollbar personnalisée */
.scrollbar-thin::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}

.scrollbar-thin::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.scrollbar-thin::-webkit-scrollbar-thumb {
    background: #cdcdcd;
    border-radius: 10px;
}

.scrollbar-thin::-webkit-scrollbar-thumb:hover {
    background: #a0a0a0;
}
</style>

<?php require_once 'views/templates/footer.php'; ?>