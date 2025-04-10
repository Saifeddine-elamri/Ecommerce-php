<?php require_once 'views/templates/header.php'; ?>
<h1 class="text-2xl font-bold mb-4">Modifier un produit</h1>
<?php if (isset($error)): ?>
    <p class="bg-red-100 text-red-800 p-2 rounded mb-4"><?php echo $error; ?></p>
<?php endif; ?>
<form method="POST" action="/admin/product/edit?id=<?php echo $product['id']; ?>" class="bg-white p-6 rounded shadow max-w-md mx-auto">
    <div class="mb-4">
        <label class="block text-gray-700">Nom</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" class="w-full p-2 border rounded" required>
    </div>
    <div class="mb-4">
        <label class="block text-gray-700">Prix</label>
        <input type="number" name="price" step="0.01" value="<?php echo $product['price']; ?>" class="w-full p-2 border rounded" required>
    </div>
    <div class="mb-4">
        <label class="block text-gray-700">Stock</label>
        <input type="number" name="stock" value="<?php echo $product['stock']; ?>" class="w-full p-2 border rounded" required>
    </div>
    <div class="mb-4">
        <label class="block text-gray-700">Catégorie</label>
        <select name="category_id" class="w-full p-2 border rounded" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category['id']; ?>" <?php echo $product['category_id'] == $category['id'] ? 'selected' : ''; ?>><?php echo $category['name']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-4">
        <label class="block text-gray-700">Description</label>
        <textarea name="description" class="w-full p-2 border rounded"><?php echo htmlspecialchars($product['description']); ?></textarea>
    </div>
    <div class="mb-4">
        <label class="block text-gray-700">Image (nom du fichier)</label>
        <input type="text" name="image" value="<?php echo htmlspecialchars($product['image']); ?>" class="w-full p-2 border rounded">
    </div>
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <button type="submit" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600 w-full">Mettre à jour</button>
</form>
<?php require_once 'views/templates/footer.php'; ?>