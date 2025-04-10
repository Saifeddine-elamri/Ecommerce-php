<?php require_once 'views/templates/header.php'; ?>

<h1 class="text-5xl font-extrabold text-center text-indigo-900 mb-8 animate__animated animate__fadeInUp">Tableau de Bord Administrateur</h1>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Carte principale de gestion -->
    <div class="bg-white p-10 rounded-xl shadow-xl transition-all duration-300 hover:shadow-2xl transform hover:scale-105 hover:bg-gray-50">
        <h2 class="text-3xl font-semibold text-gray-800 mb-8">Gestion des Ressources</h2>
        
        <ul class="space-y-8">
            <!-- Gérer les produits -->
            <li class="transition-all duration-300 hover:bg-indigo-100 rounded-lg">
                <a href="/admin/products" class="block bg-indigo-600 text-white py-4 px-8 rounded-xl text-lg font-medium shadow-md hover:bg-indigo-700 hover:shadow-lg transition-all transform hover:scale-105">
                    <span class="mr-3 text-xl">📦</span> Gérer les produits
                    <span class="ml-4 inline-block text-white bg-indigo-500 py-1 px-3 rounded-full text-sm">Nouveau</span>
                </a>
            </li>
            <!-- Gérer les commandes -->
            <li class="transition-all duration-300 hover:bg-green-100 rounded-lg">
                <a href="/admin/orders" class="block bg-green-600 text-white py-4 px-8 rounded-xl text-lg font-medium shadow-md hover:bg-green-700 hover:shadow-lg transition-all transform hover:scale-105">
                    <span class="mr-3 text-xl">🛒</span> Gérer les commandes
                    <span class="ml-4 inline-block text-white bg-green-500 py-1 px-3 rounded-full text-sm">Urgent</span>
                </a>
            </li>
            <!-- Gérer les utilisateurs -->
            <li class="transition-all duration-300 hover:bg-yellow-100 rounded-lg">
                <a href="/admin/users" class="block bg-yellow-600 text-white py-4 px-8 rounded-xl text-lg font-medium shadow-md hover:bg-yellow-700 hover:shadow-lg transition-all transform hover:scale-105">
                    <span class="mr-3 text-xl">👤</span> Gérer les utilisateurs
                    <span class="ml-4 inline-block text-white bg-yellow-500 py-1 px-3 rounded-full text-sm">Gestion</span>
                </a>
            </li>
            <!-- Voir les rapports -->
            <li class="transition-all duration-300 hover:bg-blue-100 rounded-lg">
                <a href="/admin/reports" class="block bg-blue-600 text-white py-4 px-8 rounded-xl text-lg font-medium shadow-md hover:bg-blue-700 hover:shadow-lg transition-all transform hover:scale-105">
                    <span class="mr-3 text-xl">📊</span> Voir les rapports
                    <span class="ml-4 inline-block text-white bg-blue-500 py-1 px-3 rounded-full text-sm">Rapports</span>
                </a>
            </li>
        </ul>
    </div>
</div>

<!-- Ajouter une petite section pour un meilleur aperçu -->
<div class="mt-12 text-center">
    <h3 class="text-2xl font-semibold text-gray-700 mb-4">Vous avez accès à toutes les fonctionnalités nécessaires pour gérer votre boutique !</h3>
    <p class="text-lg text-gray-500">Chaque section est organisée pour vous offrir une gestion facile et rapide des produits, commandes, utilisateurs, et bien plus encore.</p>
</div>

<?php require_once 'views/templates/footer.php'; ?>
