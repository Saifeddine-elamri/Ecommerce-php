<!DOCTYPE html>
<html>
<head>
    <title>E-commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <nav class="bg-gray-800 p-4 text-white">
        <div class="container mx-auto flex justify-between items-center">
            <div>
                <a href="/" class="mr-4">Home</a>
                <a href="/products" class="mr-4">Products</a>
                <a href="/cart" class="mr-4">Cart</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="/orders" class="mr-4">My Orders</a>
                    <a href="/logout">Logout (<?php echo $_SESSION['username']; ?>)</a>
                <?php else: ?>
                    <a href="/login" class="mr-4">Login</a>
                    <a href="/register">Register</a>
                <?php endif; ?>
            </div>
            <form action="/search" method="GET" class="flex">
                <input type="text" name="q" placeholder="Rechercher..." class="p-2 rounded-l">
                <button type="submit" class="bg-blue-500 p-2 rounded-r text-white">Rechercher</button>
            </form>
        </div>
    </nav>
    <main class="container mx-auto p-4">
    <?php if (isset($_GET['success'])): ?>
        <p class="bg-green-100 text-green-800 p-2 rounded"><?php echo $_GET['success'] === 'added' ? 'Produit ajouté !' : ($_GET['success'] === 'removed' ? 'Produit retiré !' : ($_GET['success'] === 'registered' ? 'Inscription réussie !' : 'Action réussie !')); ?></p>
    <?php endif; ?>
    <?php if (isset($_GET['error'])): ?>
        <p class="bg-red-100 text-red-800 p-2 rounded"><?php echo $_GET['error'] === 'stock_insuffisant' ? 'Stock insuffisant !' : ($_GET['error'] === 'login_required' ? 'Connexion requise !' : 'Erreur !'); ?></p>
    <?php endif; ?>
<?php