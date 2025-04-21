<?php require_once 'views/templates/header.php'; ?>

<main class="bg-gradient-to-b from-gray-50 to-white min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <h1 class="text-4xl md:text-5xl font-bold mb-10 text-center text-gray-800 tracking-tight">Explorez Nos Produits</h1>

    <!-- Inclure les filtres -->
    <?php include 'views/products/index/filters.php'; ?>

    <!-- Grille des produits -->
    <section class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 max-w-7xl mx-auto">
        <?php foreach ($products as $product): ?>
            <?php include 'views/products/index/product-card.php'; ?>
        <?php endforeach; ?>
    </section>

    <!-- Inclure la pagination -->
    <?php include 'views/products/index/pagination.php'; ?>

    <!-- Produits récemment consultés et suggérés (si nécessaires) -->
    <?php if (!empty($viewedProducts)): ?>
        <section class="mt-16 max-w-7xl mx-auto">
            <h2 class="text-2xl font-semibold mb-6 text-center text-gray-700">Produits récemment consultés</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                <?php foreach ($viewedProducts as $product): ?>
                    <?php include 'views/products/index/product-card.php'; ?>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    <!-- Produits suggérés -->
    <?php if (!empty($suggestedProducts)): ?>
        <section class="mt-16 max-w-7xl mx-auto">
            <h2 class="text-2xl font-semibold mb-6 text-center text-gray-700">Suggestions pour vous</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                <?php foreach ($suggestedProducts as $product): ?>
                    <?php include 'views/products/index/product-card.php'; ?>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>
</main>

<?php require_once 'views/templates/footer.php'; ?>

<style>
    /* Styles pour l'animation */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeIn 0.5s ease-out forwards;
    }
</style>
