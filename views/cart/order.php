<?php require_once 'views/templates/header.php'; ?>

<!-- Conteneur principal de confirmation -->
<section class="confirmation-container bg-gray-50 py-12">
    <div class="container mx-auto px-6 bg-white rounded-lg shadow-xl max-w-lg">
        <h1 class="text-4xl font-bold text-center text-green-600 mb-6">
            🎉 Commande confirmée !
        </h1>

        <!-- Message de confirmation -->
        <p class="text-lg text-center text-gray-700 mb-6">
            <?php echo $message; ?>
        </p>

        <!-- Bouton de retour -->
        <div class="text-center">
            <a href="/products" class="btn bg-green-600 text-white px-6 py-3 rounded-md hover:bg-green-700 transition duration-200">
                Retour aux produits
            </a>
        </div>
    </div>
</section>

<?php require_once 'views/templates/footer.php'; ?>
