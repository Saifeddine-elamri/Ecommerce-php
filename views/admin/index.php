<?php require_once 'views/templates/header.php'; ?>

<h1 class="text-5xl font-extrabold text-center text-indigo-900 mb-8 animate__animated animate__fadeInUp">
    Tableau de Bord Administrateur
</h1>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Carte principale de gestion -->
    <div class="bg-white p-10 rounded-xl shadow-xl transition-all duration-300 hover:shadow-2xl transform hover:scale-105 hover:bg-gray-50">
        <h2 class="text-3xl font-semibold text-gray-800 mb-8">Gestion des Ressources</h2>
        
        <!-- Liste des actions avec transitions avancées -->
        <ul class="space-y-8">
            <!-- Gérer les produits -->
            <li class="transition-all duration-300 hover:bg-indigo-100 rounded-lg shadow-lg hover:shadow-xl">
                <a href="/admin/products" class="block bg-indigo-600 text-white py-4 px-8 rounded-xl text-lg font-medium shadow-md hover:bg-indigo-700 hover:shadow-lg transition-all transform hover:scale-105 focus:outline-none relative"
                    aria-label="Accéder à la gestion des produits">
                    <span class="mr-3 text-xl">📦</span> Gérer les produits
                    <span class="ml-4 inline-block text-white bg-indigo-500 py-1 px-3 rounded-full text-sm">Nouveau</span>
                    
                    <!-- Notification dynamique avec pop-up au survol -->
                    <span class="absolute top-0 right-0 mt-2 mr-2 text-xs bg-red-500 text-white px-2 py-1 rounded-full opacity-0 hover:opacity-100 transition-opacity duration-300">5 Produits en rupture</span>
                </a>
            </li>

            <!-- Gérer les commandes -->
            <li class="transition-all duration-300 hover:bg-green-100 rounded-lg shadow-lg hover:shadow-xl">
                <a href="/admin/orders" class="block bg-green-600 text-white py-4 px-8 rounded-xl text-lg font-medium shadow-md hover:bg-green-700 hover:shadow-lg transition-all transform hover:scale-105 focus:outline-none relative"
                    aria-label="Accéder à la gestion des commandes">
                    <span class="mr-3 text-xl">🛒</span> Gérer les commandes
                    <span class="ml-4 inline-block text-white bg-green-500 py-1 px-3 rounded-full text-sm">Urgent</span>
                    
                    <!-- Badge dynamique indiquant les commandes en cours -->
                    <span class="absolute top-0 right-0 mt-2 mr-2 text-xs bg-yellow-500 text-white px-2 py-1 rounded-full opacity-0 hover:opacity-100 transition-opacity duration-300">3 Commandes en cours</span>
                </a>
            </li>

            <!-- Gérer les utilisateurs -->
            <li class="transition-all duration-300 hover:bg-yellow-100 rounded-lg shadow-lg hover:shadow-xl">
                <a href="/admin/users" class="block bg-yellow-600 text-white py-4 px-8 rounded-xl text-lg font-medium shadow-md hover:bg-yellow-700 hover:shadow-lg transition-all transform hover:scale-105 focus:outline-none relative"
                    aria-label="Accéder à la gestion des utilisateurs">
                    <span class="mr-3 text-xl">👤</span> Gérer les utilisateurs
                    <span class="ml-4 inline-block text-white bg-yellow-500 py-1 px-3 rounded-full text-sm">Gestion</span>
                    
                    <!-- Notification de l'alerte avec actions sur les utilisateurs -->
                    <span class="absolute top-0 right-0 mt-2 mr-2 text-xs bg-blue-500 text-white px-2 py-1 rounded-full opacity-0 hover:opacity-100 transition-opacity duration-300">4 Utilisateurs inactifs</span>
                </a>
            </li>

            <!-- Voir les rapports -->
            <li class="transition-all duration-300 hover:bg-blue-100 rounded-lg shadow-lg hover:shadow-xl">
                <a href="/admin/reports" class="block bg-blue-600 text-white py-4 px-8 rounded-xl text-lg font-medium shadow-md hover:bg-blue-700 hover:shadow-lg transition-all transform hover:scale-105 focus:outline-none relative"
                    aria-label="Accéder aux rapports">
                    <span class="mr-3 text-xl">📊</span> Voir les rapports
                    <span class="ml-4 inline-block text-white bg-blue-500 py-1 px-3 rounded-full text-sm">Rapports</span>
                    
                    <!-- Badge de rapports avec notifications -->
                    <span class="absolute top-0 right-0 mt-2 mr-2 text-xs bg-green-500 text-white px-2 py-1 rounded-full opacity-0 hover:opacity-100 transition-opacity duration-300">Rapports mensuels</span>
                </a>
            </li>
        </ul>
    </div>
</div>

<!-- Section d'alertes modale -->
<div id="alerts-container" class="mt-6 space-y-4">
    <!-- Alertes contextuelles avec transitions -->
    <div class="alert-modal bg-red-100 text-red-800 p-4 rounded-lg shadow-lg transition-all duration-300 hover:bg-red-200">
        <strong>Attention !</strong> Un produit en rupture de stock. Veuillez mettre à jour votre inventaire.
    </div>
    <div class="alert-modal bg-green-100 text-green-800 p-4 rounded-lg shadow-lg transition-all duration-300 hover:bg-green-200">
        <strong>Succès !</strong> Les rapports ont été générés avec succès.
    </div>
</div>

<!-- Ajouter une petite section pour un meilleur aperçu -->
<div class="mt-12 text-center">
    <h3 class="text-2xl font-semibold text-gray-700 mb-4">Vous avez accès à toutes les fonctionnalités nécessaires pour gérer votre boutique !</h3>
    <p class="text-lg text-gray-500">Chaque section est organisée pour vous offrir une gestion facile et rapide des produits, commandes, utilisateurs, et bien plus encore.</p>

    <!-- Message contextuel amélioré -->
    <div class="mt-6 bg-yellow-100 text-yellow-800 p-4 rounded-md shadow-lg">
        <strong>Note importante :</strong> Assurez-vous que les informations sur les produits et commandes sont mises à jour régulièrement pour garantir la bonne gestion des stocks.
    </div>
</div>

<!-- Dark Mode Switcher -->
<div class="mt-6 text-center">
    <button id="darkModeToggle" class="bg-gray-800 text-white px-4 py-2 rounded-full transition-all duration-300 hover:bg-gray-700">
        Basculer en Mode Sombre
    </button>
</div>

<?php require_once 'views/templates/footer.php'; ?>

<script>
// Dark Mode Toggle
document.getElementById("darkModeToggle").addEventListener("click", function() {
    document.body.classList.toggle("dark");
    localStorage.setItem("darkMode", document.body.classList.contains("dark"));
});

// Maintien du mode sombre en rafraîchissant la page
if (localStorage.getItem("darkMode") === "true") {
    document.body.classList.add("dark");
}
</script>
