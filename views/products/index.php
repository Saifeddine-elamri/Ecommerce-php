<?php require_once 'views/templates/header.php'; ?>
<h1 class="text-2xl font-bold mb-4">Products</h1>
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
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
</div>
<div class="mt-4 flex justify-center space-x-2">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="/products?page=<?php echo $i; ?>" class="px-3 py-1 bg-blue-500 text-white rounded <?php echo $page === $i ? 'bg-blue-700' : ''; ?>"><?php echo $i; ?></a>
    <?php endfor; ?>
</div>
<?php require_once 'views/templates/footer.php'; ?>