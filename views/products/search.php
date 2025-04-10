<?php require_once 'views/templates/header.php'; ?>

<h1 class="text-4xl font-extrabold mb-6 text-center text-indigo-800">Résultats de Recherche</h1>

<!-- Formulaire de recherche avec filtres -->
<form method="GET" action="/search" class="mb-8 flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4 bg-white p-6 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300">
    <div class="flex-grow">
        <input type="text" name="q" value="<?php echo htmlspecialchars($search); ?>" placeholder="Rechercher des produits..." class="p-4 border rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-300">
    </div>

    <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4">
        <input type="number" name="min_price" placeholder="Prix min" class="p-3 border rounded-lg w-32 focus:outline-none focus:ring-2 focus:ring-indigo-500" step="0.01">
        <input type="number" name="max_price" placeholder="Prix max" class="p-3 border rounded-lg w-32 focus:outline-none focus:ring-2 focus:ring-indigo-500" step="0.01">
    </div>

    <button type="submit" class="bg-indigo-600 text-white p-4 rounded-lg w-full md:w-auto hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-300">
        Filtrer
    </button>
</form>

<!-- Affichage des résultats de la recherche -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
    <?php if (empty($products)): ?>
        <p class="text-center text-xl text-gray-600 col-span-4">Aucun produit trouvé.</p>
    <?php else: ?>
        <?php foreach ($products as $product): ?>
            <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-105">
                <a href="/product?id=<?php echo $product['id']; ?>" class="block">
                    <img src="/public/images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="w-full h-48 object-cover mb-4 rounded-lg transition-all duration-300 hover:scale-105" loading="lazy">
                    <h2 class="text-lg font-semibold text-indigo-700"><?php echo $product['name']; ?></h2>
                </a>
                <p class="text-gray-600 mt-2 font-medium">$<?php echo number_format($product['price'], 2); ?></p>
                <p class="text-gray-500 mt-1">Stock: <?php echo $product['stock']; ?></p>
                
                <form method="POST" action="/cart/add" class="mt-4 flex items-center justify-between">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="number" name="quantity" min="1" max="<?php echo $product['stock']; ?>" value="1" class="w-16 p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <button type="submit" class="bg-green-600 text-white p-3 ml-2 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition-all duration-300">
                        Ajouter
                    </button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php require_once 'views/templates/footer.php'; ?>
