<?php require_once 'views/templates/header.php'; ?>
<h1 class="text-3xl font-semibold mb-6 text-center">Récapitulatif de la commande</h1>
<div class="container mx-auto px-4 py-6 bg-white shadow-lg rounded-lg">
    <?php if (empty($products)): ?>
        <p class="text-center text-lg text-gray-600">Votre commande est vide.</p>
    <?php else: ?>
        <div class="space-y-4">
            <?php foreach ($products as $item): ?>
                <div class="flex justify-between items-center bg-gray-100 p-4 rounded-lg shadow-sm">
                    <div class="flex-1">
                        <h2 class="text-lg font-semibold"><?php echo $item['name']; ?></h2>
                        <p class="text-gray-600">Prix unitaire : $<?php echo number_format($item['price'], 2); ?></p>
                        <p class="text-gray-500">Quantité : <?php echo $item['quantity']; ?></p>
                    </div>
                    <div>
                        <p class="text-gray-700 font-semibold">$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Total -->
        <div class="flex justify-between items-center bg-gray-200 p-4 rounded-lg mt-6">
            <p class="text-xl font-semibold">Total de la commande :</p>
            <p class="text-2xl text-green-600 font-bold">$<?php echo number_format($total, 2); ?></p>
        </div>

        <!-- Confirmer la commande -->
        <div class="mt-6 text-center">
            <form method="POST" action="/order">
                <button type="submit" class="bg-blue-500 text-white py-3 px-8 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 transition duration-200">Confirmer la commande</button>
            </form>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'views/templates/footer.php'; ?>
