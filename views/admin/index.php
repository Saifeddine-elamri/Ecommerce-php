<?php require_once 'views/templates/header.php'; ?>
<h1 class="text-2xl font-bold mb-4">Tableau de bord administrateur</h1>
<div class="bg-white p-6 rounded shadow">
    <ul class="space-y-4">
        <li><a href="/admin/products" class="text-blue-500 hover:underline">Gérer les produits</a></li>
        <li><a href="/admin/orders" class="text-blue-500 hover:underline">Gérer les commandes</a></li>
    </ul>
</div>
<?php require_once 'views/templates/footer.php'; ?>