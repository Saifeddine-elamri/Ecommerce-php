<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce Premium</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --secondary: #7c3aed;
            --accent: #ec4899;
            --text-light: #f8fafc;
            --text-dark: #1e293b;
            --bg-dark: #0f172a;
        }
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        /* Navigation styles */
        .nav-gradient {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 50%, var(--accent) 100%);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }
        
        .nav-link {
            position: relative;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--text-light);
            transition: width 0.3s ease;
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
        
        /* Dropdown styles */
        .dropdown-menu {
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
            animation: fadeIn 0.3s ease-out;
        }
        
        .dropdown-item {
            transition: all 0.2s ease;
        }
        
        .dropdown-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }
        
        /* Search bar */
        .search-input:focus {
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.3);
        }
        
        /* Cart indicator */
        .cart-indicator {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: var(--accent);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: bold;
            animation: pulse 1.5s infinite;
        }
        
        /* Mobile menu */
        .mobile-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s ease-out;
        }
        
        .mobile-menu.open {
            max-height: 500px;
        }
        
        /* Responsive adjustments */
        @media (max-width: 1023px) {
            .nav-links {
                display: none;
            }
            
            .mobile-menu-button {
                display: block;
            }
        }
        
        @media (min-width: 1024px) {
            .mobile-menu-button {
                display: none;
            }
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">

    <?php if (session_status() == PHP_SESSION_NONE) session_start(); ?>
    <?php if (!isset($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); ?>
    <?php 
    $userModel = new User(); 
    $user = isset($_SESSION['user_id']) ? $userModel->getById($_SESSION['user_id']) : null;
    $cartCount = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
    ?>

    <!-- Main Navigation -->
    <header class="sticky top-0 z-50">
        <!-- Top Announcement Bar -->
        <div class="bg-indigo-900 text-white text-center py-2 px-4 text-sm">
            <p>🎉 Livraison gratuite à partir de 50€ | Retours faciles sous 30 jours</p>
        </div>
        
        <!-- Main Nav -->
        <nav class="nav-gradient text-white shadow-lg">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center py-4">
                    <!-- Logo -->
                    <div class="flex items-center space-x-4">
                        <button class="mobile-menu-button lg:hidden text-white focus:outline-none">
                            <i class="fas fa-bars text-2xl"></i>
                        </button>
                        <a href="/" class="flex items-center space-x-2">
                            <i class="fas fa-shopping-bag text-3xl text-white"></i>
                            <span class="text-2xl font-bold tracking-tighter bg-clip-text text-transparent bg-gradient-to-r from-white to-gray-200">
                                LuxeShop
                            </span>
                        </a>
                    </div>
                    
                    <!-- Desktop Navigation -->
                    <div class="hidden lg:flex items-center space-x-8">
                        <!-- Search Bar (Desktop) -->
                        <div class="relative w-64">
                            <form action="/search" method="GET" class="relative">
                                <input type="text" name="q" placeholder="Rechercher des produits..." 
                                    class="search-input w-full py-2 px-4 pr-10 rounded-full text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-300">
                                <button type="submit" class="absolute right-3 top-2 text-gray-500 hover:text-indigo-600">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                        </div>
                        
                        <div class="flex items-center space-x-6">
                            <a href="/" class="nav-link flex items-center space-x-1">
                                <i class="fas fa-home"></i>
                                <span>Accueil</span>
                            </a>
                            
                            <a href="/products" class="nav-link flex items-center space-x-1">
                                <i class="fas fa-store"></i>
                                <span>Boutique</span>
                            </a>
                            
                            <!-- Categories Dropdown -->
                            <div class="dropdown relative">
                                <button class="nav-link flex items-center space-x-1 focus:outline-none">
                                    <i class="fas fa-tags"></i>
                                    <span>Catégories</span>
                                    <i class="fas fa-chevron-down text-xs ml-1 transition-transform duration-200 dropdown-arrow"></i>
                                </button>
                                <div class="dropdown-menu absolute left-0 mt-2 w-48 bg-white rounded-md shadow-xl z-50 py-1 text-gray-800">
                                    <?php 
                                    $productModel = new Product();
                                    $categories = $productModel->getCategories();
                                    foreach ($categories as $category): ?>
                                        <a href="/products?category=<?php echo $category['id']; ?>" 
                                           class="dropdown-item block px-4 py-2 text-sm hover:bg-indigo-50 flex items-center">
                                           <i class="fas fa-<?php echo $category['icon'] ?? 'tag'; ?> mr-2 text-indigo-500"></i>
                                           <?php echo $category['name']; ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            
                            <a href="/cart" class="nav-link relative flex items-center space-x-1">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Panier</span>
                                <?php if ($cartCount > 0): ?>
                                    <span class="cart-indicator"><?php echo $cartCount; ?></span>
                                <?php endif; ?>
                            </a>
                        </div>
                        
                        <!-- User Section -->
                        <div class="dropdown relative ml-4">
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <button class="flex items-center space-x-2 focus:outline-none">
                                    <div class="w-8 h-8 rounded-full bg-indigo-300 flex items-center justify-center text-indigo-800 font-semibold">
                                        <?php echo substr($_SESSION['username'], 0, 1); ?>
                                    </div>
                                    <span class="nav-link">Mon compte</span>
                                    <i class="fas fa-chevron-down text-xs ml-1 transition-transform duration-200 dropdown-arrow"></i>
                                </button>
                                <div class="dropdown-menu absolute right-0 mt-2 w-56 bg-white rounded-md shadow-xl z-50 py-1 text-gray-800">
                                    <a href="/profile" class="dropdown-item block px-4 py-2 text-sm hover:bg-indigo-50 flex items-center">
                                        <i class="fas fa-user-circle mr-2 text-indigo-500"></i>
                                        Mon profil
                                    </a>
                                    <a href="/orders" class="dropdown-item block px-4 py-2 text-sm hover:bg-indigo-50 flex items-center">
                                        <i class="fas fa-clipboard-list mr-2 text-indigo-500"></i>
                                        Mes commandes
                                    </a>
                                    <?php if ($user['is_admin']): ?>
                                        <a href="/admin" class="dropdown-item block px-4 py-2 text-sm hover:bg-indigo-50 flex items-center">
                                            <i class="fas fa-lock mr-2 text-indigo-500"></i>
                                            Administration
                                        </a>
                                    <?php endif; ?>
                                    <div class="border-t border-gray-200 my-1"></div>
                                    <a href="/logout" class="dropdown-item block px-4 py-2 text-sm hover:bg-indigo-50 text-red-500 flex items-center">
                                        <i class="fas fa-sign-out-alt mr-2"></i>
                                        Déconnexion
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="flex items-center space-x-4">
                                    <a href="/login" class="nav-link flex items-center space-x-1">
                                        <i class="fas fa-sign-in-alt"></i>
                                        <span>Connexion</span>
                                    </a>
                                    <a href="/register" class="bg-white text-indigo-600 hover:bg-gray-100 px-4 py-2 rounded-full font-medium transition duration-300 flex items-center space-x-1">
                                        <i class="fas fa-user-plus"></i>
                                        <span>S'inscrire</span>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Mobile Icons -->
                    <div class="flex lg:hidden items-center space-x-4">
                        <a href="/search" class="text-white">
                            <i class="fas fa-search text-xl"></i>
                        </a>
                        <a href="/cart" class="text-white relative">
                            <i class="fas fa-shopping-cart text-xl"></i>
                            <?php if ($cartCount > 0): ?>
                                <span class="cart-indicator"><?php echo $cartCount; ?></span>
                            <?php endif; ?>
                        </a>
                    </div>
                </div>
                
                <!-- Mobile Menu -->
                <div class="mobile-menu lg:hidden bg-indigo-800 rounded-lg mb-2">
                    <div class="px-2 pt-2 pb-4 space-y-1">
                        <a href="/" class="block px-3 py-2 rounded-md text-white hover:bg-indigo-700 flex items-center">
                            <i class="fas fa-home mr-2"></i> Accueil
                        </a>
                        <a href="/products" class="block px-3 py-2 rounded-md text-white hover:bg-indigo-700 flex items-center">
                            <i class="fas fa-store mr-2"></i> Boutique
                        </a>
                        
                        <!-- Mobile Categories -->
                        <div class="px-3 py-2">
                            <button class="w-full flex justify-between items-center text-white focus:outline-none">
                                <span class="flex items-center">
                                    <i class="fas fa-tags mr-2"></i> Catégories
                                </span>
                                <i class="fas fa-chevron-down transition-transform duration-200"></i>
                            </button>
                            <div class="mt-2 pl-6 hidden">
                                <?php foreach ($categories as $category): ?>
                                    <a href="/products?category=<?php echo $category['id']; ?>" 
                                       class="block px-3 py-2 rounded-md text-indigo-100 hover:bg-indigo-700 flex items-center">
                                       <i class="fas fa-<?php echo $category['icon'] ?? 'tag'; ?> mr-2"></i>
                                       <?php echo $category['name']; ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a href="/profile" class="block px-3 py-2 rounded-md text-white hover:bg-indigo-700 flex items-center">
                                <i class="fas fa-user-circle mr-2"></i> Mon profil
                            </a>
                            <a href="/orders" class="block px-3 py-2 rounded-md text-white hover:bg-indigo-700 flex items-center">
                                <i class="fas fa-clipboard-list mr-2"></i> Mes commandes
                            </a>
                            <?php if ($user['is_admin']): ?>
                                <a href="/admin" class="block px-3 py-2 rounded-md text-white hover:bg-indigo-700 flex items-center">
                                    <i class="fas fa-lock mr-2"></i> Administration
                                </a>
                            <?php endif; ?>
                            <a href="/logout" class="block px-3 py-2 rounded-md text-white hover:bg-indigo-700 flex items-center">
                                <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                            </a>
                        <?php else: ?>
                            <a href="/login" class="block px-3 py-2 rounded-md text-white hover:bg-indigo-700 flex items-center">
                                <i class="fas fa-sign-in-alt mr-2"></i> Connexion
                            </a>
                            <a href="/register" class="block px-3 py-2 rounded-md bg-white text-indigo-600 hover:bg-gray-100 flex items-center">
                                <i class="fas fa-user-plus mr-2"></i> S'inscrire
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mx-auto px-4 py-6">
        <!-- Success or Error messages -->
        <?php if (isset($_GET['success'])): ?>
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-lg shadow-sm animate-fadeIn">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-500 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">
                            <?php echo $_GET['success'] === 'added' ? 'Produit ajouté à votre panier avec succès!' : 
                                  ($_GET['success'] === 'removed' ? 'Produit retiré de votre panier.' : 
                                  ($_GET['success'] === 'registered' ? 'Inscription réussie! Bienvenue parmi nous.' : 
                                  'Opération effectuée avec succès!')); ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg shadow-sm animate-fadeIn">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">
                            <?php echo $_GET['error'] === 'stock_insuffisant' ? 'Désolé, le stock est insuffisant pour ce produit.' : 
                                  ($_GET['error'] === 'login_required' ? 'Veuillez vous connecter pour accéder à cette fonctionnalité.' : 
                                  'Une erreur est survenue. Veuillez réessayer.'); ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <script>
        // Mobile menu toggle
        document.querySelector('.mobile-menu-button').addEventListener('click', function() {
            const menu = document.querySelector('.mobile-menu');
            menu.classList.toggle('open');
            
            // Toggle icon between bars and times
            const icon = this.querySelector('i');
            if (icon.classList.contains('fa-bars')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });
        
        // Mobile categories toggle
        const mobileCatButton = document.querySelector('.mobile-menu button');
        if (mobileCatButton) {
            mobileCatButton.addEventListener('click', function() {
                const dropdown = this.nextElementSibling;
                dropdown.classList.toggle('hidden');
                
                // Rotate chevron icon
                const icon = this.querySelector('.fa-chevron-down');
                icon.classList.toggle('rotate-180');
            });
        }
        
        // Dropdown arrow animation
        const dropdowns = document.querySelectorAll('.dropdown');
        dropdowns.forEach(dropdown => {
            const button = dropdown.querySelector('button');
            if (button) {
                button.addEventListener('click', function() {
                    const menu = dropdown.querySelector('.dropdown-menu');
                    menu.classList.toggle('opacity-0');
                    menu.classList.toggle('invisible');
                    menu.classList.toggle('visible');
                    menu.classList.toggle('opacity-100');
                    
                    // Rotate arrow
                    const arrow = dropdown.querySelector('.dropdown-arrow');
                    arrow.classList.toggle('rotate-180');
                });
            }
        });
    </script>
</body>
</html>