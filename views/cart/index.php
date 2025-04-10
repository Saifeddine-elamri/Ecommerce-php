<?php require_once 'views/templates/header.php'; ?>
<h1 class="text-3xl font-semibold mb-6 text-center">Mon Panier</h1>
<div class="container mx-auto px-4 py-6">
    <?php if (empty($products)): ?>
        <p class="text-center text-xl text-gray-600">Votre panier est vide. Ajoutez des produits pour commencer vos achats.</p>
    <?php else: ?>
        <div class="space-y-4">
            <?php foreach ($products as $item): ?>
                <div class="bg-white p-4 rounded-lg shadow-lg flex items-center justify-between">
                    <div class="flex items-center">
                        <img src="/public/images/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" class="w-20 h-20 object-cover rounded mr-4">
                        <div>
                            <h2 class="text-xl font-semibold"><?php echo $item['name']; ?></h2>
                            <p class="text-gray-600">Prix unitaire : $<?php echo $item['price']; ?></p>
                            <p class="text-gray-500">Quantité : <?php echo $item['quantity']; ?></p>
                        </div>
                    </div>
                    <form method="POST" action="/cart/remove" class="flex items-center">
                        <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition duration-200">
                            <i class="bi bi-trash"></i> Supprimer
                        </button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="mt-6 flex justify-between items-center">
            <p class="text-xl font-semibold">Total: <span class="text-green-600">$<?php echo number_format($total, 2); ?></span></p>
            <a href="/order" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition duration-200">Passer la commande</a>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'views/templates/footer.php'; ?>
