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
