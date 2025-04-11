<?php include 'views/templates/header.php'; ?>

<div class="max-w-4xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-lg">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Récapitulatif de la commande</h1>

    <?php if (!empty($products)) : ?>
        <div class="divide-y divide-gray-200">
            <?php foreach ($products as $item) : ?>
                <div class="flex justify-between py-4 items-center">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-700"><?= htmlspecialchars($item['name']) ?></h2>
                        <p class="text-sm text-gray-500">Quantité : <?= $item['quantity'] ?></p>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-800 font-medium"><?= number_format($item['price'], 2) ?> €</p>
                        <p class="text-sm text-gray-500">Total : <?= number_format($item['price'] * $item['quantity'], 2) ?> €</p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="text-right mt-6">
            <p class="text-xl font-bold text-gray-800">Total général : <?= number_format($total, 2) ?> €</p>
        </div>

        <form method="POST" action="/order" class="mt-8">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
            <button type="submit" class="w-full bg-green-600 text-white py-3 px-4 rounded-md hover:bg-green-700 transition font-medium">
                Confirmer la commande
            </button>
        </form>
    <?php else : ?>
        <p class="text-gray-600">Votre panier est vide.</p>
    <?php endif; ?>
</div>

<?php include 'views/templates/footer.php'; ?>
