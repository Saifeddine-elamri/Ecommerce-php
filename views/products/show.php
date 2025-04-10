<?php require_once 'views/templates/header.php'; ?>
<div class="bg-white p-6 rounded shadow max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold mb-4"><?php echo $product['name']; ?></h1>
    <img src="/public/images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="w-full h-64 object-cover mb-4">
    <p class="text-gray-600 text-xl mb-2">$<?php echo $product['price']; ?></p>
    <p class="text-gray-500 mb-2">Stock: <?php echo $product['stock']; ?></p>
    <p class="text-gray-500 mb-4">Catégorie: <?php echo $product['category_name']; ?></p>
    <form method="POST" action="/cart/add" class="mb-4 flex">
        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <input type="number" name="quantity" min="1" max="<?php echo $product['stock']; ?>" value="1" class="w-16 p-1 border rounded">
        <button type="submit" class="bg-green-500 text-white p-2 ml-2 rounded hover:bg-green-600">Ajouter au panier</button>
    </form>

    <?php if (isset($_SESSION['user_id'])): ?>
        <form method="POST" action="<?php echo $isFavorite ? '/favorite/remove' : '/favorite/add'; ?>" class="mb-4">
            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <button type="submit" class="bg-<?php echo $isFavorite ? 'red' : 'yellow'; ?>-500 text-white p-2 rounded hover:bg-<?php echo $isFavorite ? 'red' : 'yellow'; ?>-600">
                <?php echo $isFavorite ? 'Retirer des favoris' : 'Ajouter aux favoris'; ?>
            </button>
        </form>
    <?php endif; ?>

    <h2 class="text-xl font-semibold mb-2">Avis</h2>
    <?php if (empty($reviews)): ?>
        <p class="text-gray-500">Aucun avis pour ce produit.</p>
    <?php else: ?>
        <?php foreach ($reviews as $review): ?>
            <div class="border-t py-2">
                <p class="text-gray-700"><strong><?php echo $review['username']; ?></strong> - Note : <?php echo $review['rating']; ?>/5</p>
                <p class="text-gray-600"><?php echo $review['comment']; ?></p>
                <p class="text-gray-400 text-sm"><?php echo $review['created_at']; ?></p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['user_id'])): ?>
        <h3 class="text-lg font-semibold mt-4 mb-2">Ajouter un avis</h3>
        <form method="POST" action="/review/add" class="flex flex-col space-y-2">
            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <select name="rating" class="p-2 border rounded">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
            <textarea name="comment" placeholder="Votre commentaire..." class="p-2 border rounded"></textarea>
            <button type="submit" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600">Soumettre</button>
        </form>
    <?php endif; ?>
</div>
<?php require_once 'views/templates/footer.php'; ?>