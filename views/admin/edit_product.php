<?php require_once 'views/templates/header.php'; ?>

<h1 class="text-3xl font-bold text-center text-indigo-800 mb-6 animate__animated animate__fadeInUp">Modifier un produit</h1>

<?php if (isset($error)): ?>
    <div class="bg-red-100 text-red-800 p-4 rounded-lg mb-6 shadow-md animate__animated animate__fadeInUp">
        <i class="fas fa-exclamation-circle mr-2"></i>
        <span><?php echo $error; ?></span>
    </div>
<?php endif; ?>

<form method="POST" action="/admin/product/edit?id=<?php echo $product['id']; ?>" class="bg-white p-8 rounded-xl shadow-lg max-w-3xl mx-auto space-y-6">
    <div class="mb-6">
        <label class="block text-gray-700 font-semibold">Nom du produit</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" class="w-full p-3 border rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300" required>
    </div>
    
    <div class="mb-6">
        <label class="block text-gray-700 font-semibold">Prix</label>
        <input type="number" name="price" step="0.01" value="<?php echo $product['price']; ?>" class="w-full p-3 border rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300" required>
    </div>

    <div class="mb-6">
        <label class="block text-gray-700 font-semibold">Stock</label>
        <input type="number" name="stock" value="<?php echo $product['stock']; ?>" class="w-full p-3 border rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300" required>
    </div>

    <div class="mb-6">
        <label class="block text-gray-700 font-semibold">Catégorie</label>
        <select name="category_id" class="w-full p-3 border rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category['id']; ?>" <?php echo $product['category_id'] == $category['id'] ? 'selected' : ''; ?>><?php echo $category['name']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-6">
        <label class="block text-gray-700 font-semibold">Description du produit</label>
        <textarea name="description" class="w-full p-3 border rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300"><?php echo htmlspecialchars($product['description']); ?></textarea>
    </div>

    <div class="mb-6">
        <label class="block text-gray-700 font-semibold">Image (nom du fichier)</label>
        <input type="text" name="image" value="<?php echo htmlspecialchars($product['image']); ?>" class="w-full p-3 border rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300">
    </div>

    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <button type="submit" class="bg-indigo-600 text-white p-3 rounded-lg hover:bg-indigo-700 shadow-lg transition duration-300 w-full transform hover:scale-105">
        <i class="fas fa-save mr-2"></i> Mettre à jour le produit
    </button>
</form>

<?php require_once 'views/templates/footer.php'; ?>

<!-- Ajout des icônes Font Awesome -->
