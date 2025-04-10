<?php require_once 'views/templates/header.php'; ?>

<h1 class="text-4xl font-extrabold text-center text-indigo-800 mb-8 animate__animated animate__fadeInUp">Gestion des produits</h1>

<?php if (isset($_GET['success'])): ?>
    <div class="bg-green-100 text-green-800 p-4 rounded-xl mb-6 shadow-lg animate__animated animate__fadeInUp">
        <p class="font-semibold"><?php echo $_GET['success'] === 'product_added' ? 'Produit ajouté avec succès !' : 'Produit mis à jour avec succès !'; ?></p>
    </div>
<?php endif; ?>

<a href="/admin/product/add" class="bg-green-600 text-white p-3 rounded-lg hover:bg-green-700 shadow-md transition duration-300 hover:shadow-xl mb-6 inline-block transform hover:scale-105">
    Ajouter un produit
</a>

<div class="bg-white p-6 rounded-lg shadow-lg mb-6 animate__animated animate__fadeInUp">
    <table class="w-full text-left table-auto shadow-md">
        <thead class="bg-gray-200 text-gray-700">
            <tr class="transition duration-300 hover:bg-gray-300">
                <th class="p-4 font-medium">ID</th>
                <th class="p-4 font-medium">Nom</th>
                <th class="p-4 font-medium">Prix</th>
                <th class="p-4 font-medium">Stock</th>
                <th class="p-4 font-medium">Catégorie</th>
                <th class="p-4 font-medium">Statut</th>
                <th class="p-4 font-medium">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr class="border-t transition duration-300 hover:bg-gray-100">
                    <td class="p-4"><?php echo $product['id']; ?></td>
                    <td class="p-4"><?php echo $product['name']; ?></td>
                    <td class="p-4 text-green-500 font-semibold">$<?php echo number_format($product['price'], 2, '.', ','); ?></td>
                    <td class="p-4"><?php echo $product['stock']; ?></td>
                    <td class="p-4"><?php echo $product['category_name']; ?></td>
                    <td class="p-4">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full <?php echo $product['stock'] > 0 ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800'; ?>">
                            <?php echo $product['stock'] > 0 ? 'Disponible' : 'En rupture'; ?>
                        </span>
                    </td>
                    <td class="p-4 flex space-x-4">
                        <!-- Modifier -->
                        <a href="/admin/product/edit?id=<?php echo $product['id']; ?>" class="text-blue-500 hover:text-blue-700 font-semibold transition duration-300 transform hover:scale-105 flex items-center space-x-2">
                            <i class="fas fa-edit"></i> 
                            <span>Modifier</span>
                        </a>
                        <!-- Supprimer -->
                        <a href="/admin/product/delete?id=<?php echo $product['id']; ?>" class="text-red-500 hover:text-red-700 font-semibold transition duration-300 transform hover:scale-105 flex items-center space-x-2" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">
                            <i class="fas fa-trash-alt"></i>
                            <span>Supprimer</span>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="flex justify-center mt-6">
    <button class="bg-red-500 text-white px-6 py-2 rounded-lg shadow-md hover:bg-red-600 hover:shadow-xl transition duration-300 transform hover:scale-105">
        Supprimer les produits sélectionnés
    </button>
</div>

<!-- Ajout du lien Font Awesome pour les icônes -->

<?php require_once 'views/templates/footer.php'; ?>
