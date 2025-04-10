<?php require_once 'views/templates/header.php'; ?>

<h1 class="text-4xl font-extrabold text-center text-indigo-600 mb-8 animate__fadeIn">Gestion des produits</h1>

<?php if (isset($_GET['message'])): ?>
    <div class="p-4 mb-6 rounded-lg shadow-md 
        <?php echo $_GET['type'] === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?> 
        animate__fadeInDown">
        <p class="font-semibold"><?php echo htmlspecialchars($_GET['message']); ?></p>
    </div>
<?php endif; ?>

<a href="/admin/product/add" class="flex items-center justify-center bg-indigo-500 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-indigo-600 transform hover:scale-110 transition-all">
    <i class="fas fa-plus-circle mr-2"></i> Ajouter un produit
</a>

<div class="mt-6 bg-white p-6 rounded-lg shadow-md animate__fadeIn">
    <table class="min-w-full table-auto border border-gray-300">
        <thead class="bg-gray-100 text-gray-800 text-sm uppercase">
            <tr>
                <th class="px-6 py-4 border-b">ID</th>
                <th class="px-6 py-4 border-b">Nom</th>
                <th class="px-6 py-4 border-b">Prix</th>
                <th class="px-6 py-4 border-b">Stock</th>
                <th class="px-6 py-4 border-b">Catégorie</th>
                <th class="px-6 py-4 border-b">Statut</th>
                <th class="px-6 py-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4"><?php echo htmlspecialchars($product['id']); ?></td>
                    <td class="px-6 py-4"><?php echo htmlspecialchars($product['name']); ?></td>
                    <td class="px-6 py-4 text-green-700 font-bold"><?php echo '$' . number_format($product['price'], 2); ?></td>
                    <td class="px-6 py-4"><?php echo htmlspecialchars($product['stock']); ?></td>
                    <td class="px-6 py-4"><?php echo htmlspecialchars($product['category_name']); ?></td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-sm rounded 
                            <?php echo $product['stock'] > 0 ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800'; ?>">
                            <?php echo $product['stock'] > 0 ? 'Disponible' : 'En rupture'; ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 flex space-x-2">
                        <a href="/admin/product/edit?id=<?php echo $product['id']; ?>" class="text-blue-500 hover:text-blue-600 transition transform hover:scale-110 flex items-center">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        <a href="/admin/product/delete?id=<?php echo $product['id']; ?>" class="text-red-500 hover:text-red-600 transition transform hover:scale-110 flex items-center" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">
                            <i class="fas fa-trash-alt"></i> Supprimer
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="flex justify-center mt-6">
    <button class="bg-red-500 text-white px-8 py-3 rounded shadow-md hover:bg-red-600 transition transform hover:scale-110">
        Supprimer les produits sélectionnés
    </button>
</div>

<script>
    // Fonction d'affichage dynamique des succès/erreurs
    document.addEventListener('DOMContentLoaded', () => {
        const messageBox = document.querySelector('.message-box');
        if (messageBox) {
            setTimeout(() => messageBox.classList.add('fade-out'), 3000);
        }
    });
</script>

<?php require_once 'views/templates/footer.php'; ?>
