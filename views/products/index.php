<?php require_once 'views/templates/header.php'; ?>

<!-- Main container with a light gradient background -->
<main class="bg-gradient-to-b from-gray-50 to-white min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <h1 class="text-4xl md:text-5xl font-bold mb-10 text-center text-gray-800 tracking-tight">Explorez Nos Produits</h1>

    <!-- Section des filtres -->
    <section class="mb-12 max-w-7xl mx-auto">
        <h2 class="text-2xl font-semibold mb-6 text-gray-700">Filtres</h2>
        <form method="GET" action="/products" class="flex flex-col md:flex-row gap-4 bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="flex flex-col w-full md:w-1/4">
                <label for="category" class="text-gray-600 text-sm font-medium mb-2">Catégorie</label>
                <select name="category" id="category" class="p-3 border border-gray-200 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition-all duration-200">
                    <option value="">Toutes</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>" <?php echo $categoryId == $category['id'] ? 'selected' : ''; ?>><?php echo $category['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="flex flex-col w-full md:w-1/4">
                <label for="sort" class="text-gray-600 text-sm font-medium mb-2">Tri</label>
                <select name="sort" id="sort" class="p-3 border border-gray-200 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition-all duration-200">
                    <option value="name_asc" <?php echo $sort === 'name_asc' ? 'selected' : ''; ?>>Nom (A-Z)</option>
                    <option value="name_desc" <?php echo $sort === 'name_desc' ? 'selected' : ''; ?>>Nom (Z-A)</option>
                    <option value="price_asc" <?php echo $sort === 'price_asc' ? 'selected' : ''; ?>>Prix (croissant)</option>
                    <option value="price_desc" <?php echo $sort === 'price_desc' ? 'selected' : ''; ?>>Prix (décroissant)</option>
                </select>
            </div>

            <div class="flex flex-col w-full md:w-1/4">
                <label for="stock" class="text-gray-600 text-sm font-medium mb-2">Stock</label>
                <select name="stock" id="stock" class="p-3 border border-gray-200 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition-all duration-200">
                    <option value="">Tous</option>
                    <option value="in_stock" <?php echo $stockFilter === 'in_stock' ? 'selected' : ''; ?>>En stock</option>
                </select>
            </div>

            <div class="flex items-end w-full md:w-auto">
                <button type="submit" class="w-full md:w-auto bg-gradient-to-r from-indigo-500 to-indigo-600 text-white py-3 px-6 rounded-lg hover:from-indigo-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition-all duration-200">
                    Appliquer
                </button>
            </div>
        </form>
    </section>

    <!-- Grille des produits -->
    <section class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 max-w-7xl mx-auto">
        <?php foreach ($products as $product): ?>
            <div class="bg-white p-5 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 animate-fade-in">
                <a href="/product?id=<?php echo $product['id']; ?>" class="block group">
                    <div class="relative overflow-hidden rounded-xl">
                        <img src="/public/images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="w-full h-64 object-cover transition-transform duration-300 group-hover:scale-105" loading="lazy">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-opacity duration-300"></div>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-800 mt-4 group-hover:text-indigo-600 transition-colors duration-200"><?php echo $product['name']; ?></h2>
                </a>
                <p class="text-gray-700 font-medium mt-2">$<?php echo number_format($product['price'], 2); ?></p>
                <p class="text-gray-500 text-sm mt-1">Stock: <span class="font-semibold <?php echo $product['stock'] > 0 ? 'text-green-600' : 'text-red-600'; ?>"><?php echo $product['stock']; ?></span></p>
                <p class="text-gray-500 text-sm mt-1">Catégorie: <?php echo $product['category_name']; ?></p>
                <form method="POST" action="/cart/add" class="mt-4 flex items-center gap-2">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="number" name="quantity" min="1" max="<?php echo $product['stock']; ?>" value="1" class="w-16 p-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    <button type="submit" class="bg-gradient-to-r from-green-500 to-green-600 text-white py-2 px-4 rounded-lg hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-green-400 transition-all duration-200">
                        Ajouter
                    </button>
                </form>
            </div>
        <?php endforeach; ?>
    </section>

    <!-- Pagination -->
    <nav class="mt-12 flex justify-center gap-3 max-w-7xl mx-auto">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="/products?page=<?php echo $i; ?>&category=<?php echo $categoryId ?? ''; ?>&sort=<?php echo $sort; ?>&stock=<?php echo $stockFilter ?? ''; ?>" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-indigo-500 hover:text-white transition-all duration-200 <?php echo $page === $i ? 'bg-indigo-500 text-white' : ''; ?>">
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>
    </nav>

    <!-- Section des produits récemment consultés -->
    <?php if (!empty($viewedProducts)): ?>
        <section class="mt-16 max-w-7xl mx-auto">
            <h2 class="text-2xl font-semibold mb-6 text-center text-gray-700">Produits récemment consultés</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                <?php foreach ($viewedProducts as $product): ?>
                    <div class="bg-white p-4 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 animate-fade-in">
                        <a href="/product?id=<?php echo $product['id']; ?>" class="block group">
                            <img src="/public/images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="w-full h-48 object-cover rounded-xl transition-transform duration-300 group-hover:scale-105" loading="lazy">
                            <h3 class="text-md font-semibold text-gray-800 mt-3 group-hover:text-indigo-600 transition-colors duration-200"><?php echo $product['name']; ?></h3>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    <!-- Section des produits suggérés -->
    <?php if (!empty($suggestedProducts)): ?>
        <section class="mt-16 max-w-7xl mx-auto">
            <h2 class="text-2xl font-semibold mb-6 text-center text-gray-700">Suggestions pour vous</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                <?php foreach ($suggestedProducts as $product): ?>
                    <div class="bg-white p-4 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 animate-fade-in">
                        <a href="/product?id=<?php echo $product['id']; ?>" class="block group">
                            <img src="/public/images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="w-full h-48 object-cover rounded-xl transition-transform duration-300 group-hover:scale-105" loading="lazy">
                            <h3 class="text-md font-semibold text-gray-800 mt-3 group-hover:text-indigo-600 transition-colors duration-200"><?php echo $product['name']; ?></h3>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>
</main>

<?php require_once 'views/templates/footer.php'; ?>

<!-- Custom CSS for animations -->
<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeIn 0.5s ease-out forwards;
    }
</style>