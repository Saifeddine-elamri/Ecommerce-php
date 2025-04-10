<?php require_once 'views/templates/header.php'; ?>
<h1 class="text-2xl font-bold mb-4">Gestion des produits</h1>
<?php if (isset($_GET['success'])): ?>
    <p class="bg-green-100 text-green-800 p-2 rounded mb-4"><?php echo $_GET['success'] === 'product_added' ? 'Produit ajouté !' : 'Produit mis à jour !'; ?></p>
<?php endif; ?>
<a href="/admin/product/add" class="bg-green-500 text-white p-2 rounded hover:bg-green-600 mb-4 inline-block">Ajouter un produit</a>
<div class="bg-white p-4 rounded shadow">
    <table class="w-full text-left">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2">ID</th>
                <th class="p-2">Nom</th>
                <th class="p-2">Prix</th>
                <th class="p-2">Stock</th>
                <th class="p-2">Catégorie</th>
                <th class="p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr class="border-t">
                    <td class="p-2"><?php echo $product['id']; ?></td>
                    <td class="p-2"><?php echo $product['name']; ?></td>
                    <td class="p-2">$<?php echo $product['price']; ?></td>
                    <td class="p-2"><?php echo $product['stock']; ?></td>
                    <td class="p-2"><?php echo $product['category_name']; ?></td>
                    <td class="p-2">
                        <a href="/admin/product/edit?id=<?php echo $product['id']; ?>" class="text-blue-500 hover:underline">Modifier</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require_once 'views/templates/footer.php'; ?>