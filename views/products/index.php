<?php require_once 'views/templates/header.php'; ?>

<h1 class="text-4xl font-extrabold mb-8 text-center text-indigo-800">Explorez Nos Produits</h1>

<div class="mb-8">
    <h2 class="text-xl font-semibold mb-4">Filtres :</h2>
    <form method="GET" action="/products" class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-6 bg-white p-4 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300">
        <div class="flex flex-col w-full md:w-1/4">
            <label for="category" class="text-gray-700 text-lg">Catégorie :</label>
            <select name="category" id="category" class="p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                <option value="">Toutes</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['id']; ?>" <?php echo $categoryId == $category['id'] ? 'selected' : ''; ?>><?php echo $category['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="flex flex-col w-full md:w-1/4">
            <label for="sort" class="text-gray-700 text-lg">Tri :</label>
            <select name="sort" id="sort" class="p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                <option value="name_asc" <?php echo $sort === 'name_asc' ? 'selected' : ''; ?>>Nom (A-Z)</option>
                <option value="name_desc" <?php echo $sort === 'name_desc' ? 'selected' : ''; ?>>Nom (Z-A)</option>
                <option value="price_asc" <?php echo $sort === 'price_asc' ? 'selected' : ''; ?>>Prix (croissant)</option>
                <option value="price_desc" <?php echo $sort === 'price_desc' ? 'selected' : ''; ?>>Prix (décroissant)</option>
            </select>
        </div>

        <div class="flex flex-col w-full md:w-1/4">
            <label for="stock" class="text-gray-700 text-lg">Stock :</label>
            <select name="stock" id="stock" class="p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                <option value="">Tous</option>
                <option value="in_stock" <?php echo $stockFilter === 'in_stock' ? 'selected' : ''; ?>>En stock</option>
            </select>
        </div>

        <div class="flex items-center justify-center md:justify-start w-full md:w-auto">
            <button type="submit" class="bg-indigo-600 text-white p-3 rounded-lg w-full md:w-auto hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                Appliquer
            </button>
        </div>
    </form>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 mt-6">
    <?php foreach ($products as $product): ?>
        <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-105">
            <a href="/product?id=<?php echo $product['id']; ?>" class="block">
                <img src="/public/images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="w-full h-56 object-cover rounded-t-lg transition-all duration-300 hover:scale-105" loading="lazy">
                <h2 class="text-lg font-semibold text-indigo-700 mt-4"><?php echo $product['name']; ?></h2>
            </a>
            <p class="text-gray-600 font-medium mt-2">$<?php echo number_format($product['price'], 2); ?></p>
            <p class="text-gray-500 mt-1">Stock: <?php echo $product['stock']; ?></p>
            <p class="text-gray-500 mt-1">Catégorie: <?php echo $product['category_name']; ?></p>
            <form method="POST" action="/cart/add" class="mt-4 flex items-center justify-between">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <input type="number" name="quantity" min="1" max="<?php echo $product['stock']; ?>" value="1" class="w-16 p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <button type="submit" class="bg-green-600 text-white p-2 ml-2 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition-all">
                    Ajouter au panier
                </button>
            </form>
        </div>
    <?php endforeach; ?>
</div>

<div class="mt-8 flex justify-center space-x-4">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="/products?page=<?php echo $i; ?>&category=<?php echo $categoryId ?? ''; ?>&sort=<?php echo $sort; ?>&stock=<?php echo $stockFilter ?? ''; ?>" class="px-5 py-2 bg-indigo-500 text-white rounded-lg <?php echo $page === $i ? 'bg-indigo-700' : ''; ?> hover:bg-indigo-600 transition-all duration-300">
            <?php echo $i; ?>
        </a>
    <?php endfor; ?>
</div>

<?php if (!empty($viewedProducts)): ?>
    <h2 class="text-2xl font-semibold mt-12 mb-6 text-center text-indigo-800">Produits récemment consultés</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
        <?php foreach ($viewedProducts as $product): ?>
            <div class="bg-white p-4 rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-105">
                <a href="/product?id=<?php echo $product['id']; ?>" class="block">
                    <img src="/public/images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="w-full h-40 object-cover rounded-lg transition-all duration-300 hover:scale-105" loading="lazy">
                    <h3 class="text-md font-semibold text-indigo-700 mt-2"><?php echo $product['name']; ?></h3>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if (!empty($suggestedProducts)): ?>
    <h2 class="text-2xl font-semibold mt-12 mb-6 text-center text-indigo-800">Suggestions pour vous</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
        <?php foreach ($suggestedProducts as $product): ?>
            <div class="bg-white p-4 rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-105">
                <a href="/product?id=<?php echo $product['id']; ?>" class="block">
                    <img src="/public/images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="w-full h-40 object-cover rounded-lg transition-all duration-300 hover:scale-105" loading="lazy">
                    <h3 class="text-md font-semibold text-indigo-700 mt-2"><?php echo $product['name']; ?></h3>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require_once 'views/templates/footer.php'; ?>
