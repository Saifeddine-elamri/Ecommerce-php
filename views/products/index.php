<?php require_once 'views/templates/header.php'; ?>
<h1 class="text-2xl font-bold mb-4">Products</h1>
<div class="mb-4">
    <h2 class="text-lg font-semibold">Filtres :</h2>
    <form method="GET" action="/products" class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4">
        <div>
            <label class="mr-2">Catégorie :</label>
            <select name="category" class="p-2 border rounded">
                <option value="">Toutes</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['id']; ?>" <?php echo $categoryId == $category['id'] ? 'selected' : ''; ?>><?php echo $category['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label class="mr-2">Tri :</label>
            <select name="sort" class="p-2 border rounded">
                <option value="name_asc" <?php echo $sort === 'name_asc' ? 'selected' : ''; ?>>Nom (A-Z)</option>
                <option value="name_desc" <?php echo $sort === 'name_desc' ? 'selected' : ''; ?>>Nom (Z-A)</option>
                <option value="price_asc" <?php echo $sort === 'price_asc' ? 'selected' : ''; ?>>Prix (croissant)</option>
                <option value="price_desc" <?php echo $sort === 'price_desc' ? 'selected' : ''; ?>>Prix (décroissant)</option>
            </select>
        </div>
        <div>
            <label class="mr-2">Stock :</label>
            <select name="stock" class="p-2 border rounded">
                <option value="">Tous</option>
                <option value="in_stock" <?php echo $stockFilter === 'in_stock' ? 'selected' : ''; ?>>En stock</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600">Appliquer</button>
    </form>
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
    <?php foreach ($products as $product): ?>
        <div class="bg-white p-4 rounded shadow">
            <a href="/product?id=<?php echo $product['id']; ?>">
                <img src="/public/images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="w-full h-48 object-cover mb-2" loading="lazy">
                <h2 class="text-lg font-semibold"><?php echo $product['name']; ?></h2>
            </a>
            <p class="text-gray-600">$<?php echo $product['price']; ?></p>
            <p class="text-gray-500">Stock: <?php echo $product['stock']; ?></p>
            <p class="text-gray-500">Catégorie: <?php echo $product['category_name']; ?></p>
            <form method="POST" action="/cart/add" class="mt-2 flex">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <input type="number" name="quantity" min="1" max="<?php echo $product['stock']; ?>" value="1" class="w-16 p-1 border rounded">
                <button type="submit" class="bg-green-500 text-white p-2 ml-2 rounded hover:bg-green-600">Ajouter</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>
<div class="mt-4 flex justify-center space-x-2">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="/products?page=<?php echo $i; ?>&category=<?php echo $categoryId ?? ''; ?>&sort=<?php echo $sort; ?>&stock=<?php echo $stockFilter ?? ''; ?>" class="px-3 py-1 bg-blue-500 text-white rounded <?php echo $page === $i ? 'bg-blue-700' : ''; ?>"><?php echo $i; ?></a>
    <?php endfor; ?>
</div>

<?php if (!empty($viewedProducts)): ?>
    <h2 class="text-xl font-semibold mt-8 mb-4">Récemment consultés</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
        <?php foreach ($viewedProducts as $product): ?>
            <div class="bg-white p-4 rounded shadow">
                <a href="/product?id=<?php echo $product['id']; ?>">
                    <img src="/public/images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="w-full h-32 object-cover mb-2" loading="lazy">
                    <h3 class="text-md font-semibold"><?php echo $product['name']; ?></h3>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if (!empty($suggestedProducts)): ?>
    <h2 class="text-xl font-semibold mt-8 mb-4">Suggestions pour vous</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
        <?php foreach ($suggestedProducts as $product): ?>
            <div class="bg-white p-4 rounded shadow">
                <a href="/product?id=<?php echo $product['id']; ?>">
                    <img src="/public/images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="w-full h-32 object-cover mb-2" loading="lazy">
                    <h3 class="text-md font-semibold"><?php echo $product['name']; ?></h3>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require_once 'views/templates/footer.php'; ?>