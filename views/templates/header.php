<!DOCTYPE html>
<html>
<head>
    <title>E-commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="bg-gray-100">
    <?php if (session_status() == PHP_SESSION_NONE) session_start(); ?>
    <?php if (!isset($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); ?>
    <?php $userModel = new User(); $user = isset($_SESSION['user_id']) ? $userModel->getById($_SESSION['user_id']) : null; ?>
    <nav class="bg-gray-800 p-4 text-white">
        <div class="container mx-auto flex flex-col md:flex-row justify-between items-center">
            <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4">
                <a href="/" class="hover:underline">Home</a>
                <a href="/products" class="hover:underline">Products</a>
                <div class="relative group">
                    <span class="cursor-pointer hover:underline">Categories ▼</span>
                    <div class="absolute hidden group-hover:block bg-gray-700 text-white rounded mt-1 z-10">
                        <?php 
                        $productModel = new Product();
                        $categories = $productModel->getCategories();
                        foreach ($categories as $category): ?>
                            <a href="/products?category=<?php echo $category['id']; ?>" class="block px-4 py-2 hover:bg-gray-600"><?php echo $category['name']; ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <a href="/cart" class="hover:underline">Cart</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="/orders" class="hover:underline">My Orders</a>
                    <a href="/profile" class="hover:underline">Profile</a>
                    <?php if ($user['is_admin']): ?>
                        <a href="/admin" class="hover:underline">Admin</a>
                    <?php endif; ?>
                    <a href="/logout" class="hover:underline">Logout (<?php echo $_SESSION['username']; ?>)</a>
                <?php else: ?>
                    <a href="/login" class="hover:underline">Login</a>
                    <a href="/register" class="hover:underline">Register</a>
                <?php endif; ?>
            </div>
            <form action="/search" method="GET" class="flex mt-2 md:mt-0">
                <input type="text" name="q" placeholder="Rechercher..." class="p-2 rounded-l w-full md:w-auto">
                <button type="submit" class="bg-blue-500 p-2 rounded-r text-white hover:bg-blue-600">Rechercher</button>
            </form>
        </div>
    </nav>
    <main class="container mx-auto p-4">
    <?php if (isset($_GET['success'])): ?>
        <p class="bg-green-100 text-green-800 p-2 rounded"><?php echo $_GET['success'] === 'added' ? 'Produit ajouté !' : ($_GET['success'] === 'removed' ? 'Produit retiré !' : ($_GET['success'] === 'registered' ? 'Inscription réussie !' : ($_GET['success'] === 'review_added' ? 'Avis ajouté !' : ($_GET['success'] === 'favorite_added' ? 'Ajouté aux favoris !' : ($_GET['success'] === 'favorite_removed' ? 'Retiré des favoris !' : 'Action réussie !'))))); ?></p>
    <?php endif; ?>
    <?php if (isset($_GET['error'])): ?>
        <p class="bg-red-100 text-red-800 p-2 rounded"><?php echo $_GET['error'] === 'stock_insuffisant' ? 'Stock insuffisant !' : ($_GET['error'] === 'login_required' ? 'Connexion requise !' : ($_GET['error'] === 'invalid_review' ? 'Avis invalide !' : 'Erreur !')); ?></p>
    <?php endif; ?>
<?php