<?php require_once 'views/templates/header.php'; ?>
<h1 class="text-2xl font-bold mb-4">Résultats de recherche</h1>
<form method="GET" action="/search" class="mb-4 flex space-x-2">
    <input type="text" name="q" value="<?php echo htmlspecialchars($search); ?>" placeholder="Rechercher..." class="p-2 border rounded flex-grow">
    <input type="number" name="min_price" placeholder="Prix min" class="p-2 border rounded w-24" step="0.01">
    <input type="number" name="max_price" placeholder="Prix max" class="p-2 border rounded w-24" step="0.01">
    <button type="submit" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600">Filtrer</button>
</form>
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
    <?php if (empty($products)): ?>
        <p>Aucun produit trouvé.</p>
    <?php else: ?>
        <?php foreach ($products as $product): ?>
            <div class="bg-white p-4 rounded shadow">
                <img src="/public/images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="w-full h-48 object-cover mb-2">
                <h2 class="text-lg font-semibold"><?php echo $product['name']; ?></h2>
                <p class="text-gray-600">$<?php echo $product['price']; ?></p>
                <p class="text-gray-500">Stock: <?php echo $product['stock']; ?></p>
                <form method="POST" action="/cart/add" class="mt-2 flex">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <input type="number" name="quantity" min="1" max="<?php echo $product['stock']; ?>" value="1" class="w-16 p-1 border rounded">
                    <button type="submit" class="bg-green-500 text-white p-2 ml-2 rounded hover:bg-green-600">Ajouter</button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<?php require_once 'views/templates/footer.php'; ?>