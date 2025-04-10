<?php require_once 'views/templates/header.php'; ?>

<div class="container mx-auto px-4 py-8 max-w-6xl">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Mon Panier</h1>
        <a href="/products" class="text-blue-600 hover:text-blue-800 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Continuer mes achats
        </a>
    </div>

    <?php if (isset($message)): ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p><?php echo $message; ?></p>
        </div>
    <?php endif; ?>

    <?php if (empty($products)): ?>
        <div class="text-center py-16 bg-white rounded-lg shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-400 mx-auto mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <p class="text-2xl text-gray-600 mb-4">Votre panier est vide</p>
            <p class="text-gray-500 mb-8 max-w-md mx-auto">Ajoutez des produits pour commencer vos achats.</p>
            <a href="/products" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200 inline-flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
                Explorer nos produits
            </a>
        </div>
    <?php else: ?>
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Produits du panier -->
            <div class="lg:w-2/3">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b">
                        <div class="flex justify-between text-gray-600">
                            <div class="w-1/2">Produit</div>
                            <div class="w-1/6 text-center">Prix</div>
                            <div class="w-1/6 text-center">Quantité</div>
                            <div class="w-1/6 text-center">Total</div>
                        </div>
                    </div>
                    
                    <div class="divide-y" id="cart-items">
                        <?php foreach ($products as $item): ?>
                            <div class="px-6 py-4 flex items-center hover:bg-gray-50 transition-colors cart-item" data-id="<?php echo $item['id']; ?>" data-price="<?php echo $item['price']; ?>">
                                <div class="w-1/2 flex items-center">
                                    <div class="w-20 h-20 flex-shrink-0 mr-4">
                                        <img src="/public/images/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" class="w-full h-full object-cover rounded-md">
                                    </div>
                                    <div>
                                        <h2 class="font-medium text-gray-800"><?php echo $item['name']; ?></h2>
                                        <?php if (!empty($item['options'])): ?>
                                            <p class="text-sm text-gray-500 mt-1"><?php echo $item['options']; ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div class="w-1/6 text-center">
                                    <span class="text-gray-700"><?php echo number_format($item['price'], 2); ?> €</span>
                                </div>
                                
                                <div class="w-1/6 flex justify-center">
                                    <div class="flex items-center border rounded-md">
                                        <button type="button" class="decrease-quantity px-3 py-1 text-gray-600 hover:bg-gray-100" data-id="<?php echo $item['id']; ?>">-</button>
                                        <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" max="99" class="quantity-input w-12 text-center border-x py-1 focus:outline-none" data-id="<?php echo $item['id']; ?>">
                                        <button type="button" class="increase-quantity px-3 py-1 text-gray-600 hover:bg-gray-100" data-id="<?php echo $item['id']; ?>">+</button>
                                    </div>
                                </div>
                                
                                <div class="w-1/6 text-center">
                                    <span class="font-medium text-gray-800 item-total"><?php echo number_format($item['price'] * $item['quantity'], 2); ?> €</span>
                                </div>
                                
                                <div class="ml-4">
                                    <button type="button" class="remove-item text-gray-400 hover:text-red-500 transition-colors" data-id="<?php echo $item['id']; ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="bg-gray-50 px-6 py-4 flex justify-between items-center">
                        <button id="clear-cart" class="text-red-600 hover:text-red-800 flex items-center text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Vider le panier
                        </button>
                        
                        <button id="update-cart" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200 text-sm flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Mettre à jour
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Résumé de la commande -->
            <div class="lg:w-1/3">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-6">Résumé de la commande</h2>
                    
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between text-gray-600">
                            <span>Sous-total</span>
                            <span id="subtotal"><?php echo number_format($total, 2); ?> €</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Frais de livraison</span>
                            <span id="shipping">
                                <?php
                                    $shipping = $total >= 50 ? 0 : 5.99;
                                    echo $shipping === 0 ? 'Gratuit' : number_format($shipping, 2) . ' €';
                                ?>
                            </span>
                        </div>
                        <?php if ($total >= 50): ?>
                            <div class="text-green-600 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Livraison gratuite
                            </div>
                        <?php else: ?>
                            <div class="text-sm text-gray-500">
                                Plus que <?php echo number_format(50 - $total, 2); ?> € pour la livraison gratuite
                                <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: <?php echo min(100, ($total / 50) * 100); ?>%"></div>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <div class="border-t pt-4">
                            <div class="flex justify-between font-bold text-lg">
                                <span>Total</span>
                                <span id="total-price"><?php echo number_format($total + $shipping, 2); ?> €</span>
                            </div>
                            <p class="text-gray-500 text-sm mt-1">TVA incluse</p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <!-- Code promo -->
                        <div class="flex">
                            <input type="text" id="promo-code" placeholder="Code promo" class="flex-grow border rounded-l-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <button id="apply-promo" class="bg-gray-800 text-white px-4 py-2 rounded-r-md hover:bg-gray-900 transition duration-200">Appliquer</button>
                        </div>
                        
                        <!-- Bouton de commande -->
                        <a href="/checkout" class="block w-full bg-green-600 text-white text-center px-6 py-3 rounded-md hover:bg-green-700 transition duration-200 font-medium">
                            Passer à la commande
                        </a>
                        
                        <!-- Options de paiement -->
                        <div class="flex justify-center space-x-3 mt-4">
                            <img src="/public/images/visa.svg" alt="Visa" class="h-8">
                            <img src="/public/images/mastercard.svg" alt="Mastercard" class="h-8">
                            <img src="/public/images/paypal.svg" alt="PayPal" class="h-8">
                            <img src="/public/images/apple-pay.svg" alt="Apple Pay" class="h-8">
                        </div>
                        
                        <!-- Sécurité -->
                        <div class="text-center text-gray-500 text-sm flex items-center justify-center mt-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Paiement 100% sécurisé
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Suggestions de produits -->
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Vous pourriez aussi aimer</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php if (isset($suggested_products) && !empty($suggested_products)): ?>
                    <?php foreach ($suggested_products as $product): ?>
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                            <img src="/public/images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3 class="font-medium text-gray-800"><?php echo $product['name']; ?></h3>
                                <p class="text-gray-500 text-sm mt-1"><?php echo substr($product['description'], 0, 60); ?>...</p>
                                <div class="flex justify-between items-center mt-4">
                                    <span class="font-bold text-gray-800"><?php echo number_format($product['price'], 2); ?> €</span>
                                    <button class="add-to-cart bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition duration-200 text-sm" data-id="<?php echo $product['id']; ?>">
                                        Ajouter
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Produits suggérés fictifs pour la démo -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="bg-gray-200 w-full h-48"></div>
                        <div class="p-4">
                            <h3 class="font-medium text-gray-800">Produit suggéré</h3>
                            <p class="text-gray-500 text-sm mt-1">Description du produit suggéré...</p>
                            <div class="flex justify-between items-center mt-4">
                                <span class="font-bold text-gray-800">24.99 €</span>
                                <button class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition duration-200 text-sm">
                                    Ajouter
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Répéter pour d'autres produits suggérés -->
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Modal de confirmation pour vider le panier -->
<div id="clear-cart-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-4">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Vider le panier ?</h3>
        <p class="text-gray-600 mb-6">Êtes-vous sûr de vouloir supprimer tous les articles de votre panier ?</p>
        <div class="flex justify-end space-x-3">
            <button id="cancel-clear" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Annuler</button>
            <form action="/cart/clear" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?? ''; ?>">
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Vider le panier</button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Éléments
    const cartItems = document.getElementById('cart-items');
    const clearCartBtn = document.getElementById('clear-cart');
    const clearCartModal = document.getElementById('clear-cart-modal');
    const cancelClearBtn = document.getElementById('cancel-clear');
    const updateCartBtn = document.getElementById('update-cart');
    const subtotalEl = document.getElementById('subtotal');
    const shippingEl = document.getElementById('shipping');
    const totalEl = document.getElementById('total-price');
    const promoInput = document.getElementById('promo-code');
    const promoBtn = document.getElementById('apply-promo');
    
    // Constantes
    const FREE_SHIPPING_THRESHOLD = 50;
    const SHIPPING_COST = 5.99;
    
    // État
    let cartData = [];
    let discount = 0;
    
    // Initialiser les données du panier
    function initCartData() {
        const items = document.querySelectorAll('.cart-item');
        items.forEach(item => {
            const id = item.dataset.id;
            const price = parseFloat(item.dataset.price);
            const quantityInput = item.querySelector('.quantity-input');
            const quantity = parseInt(quantityInput.value);
            
            cartData.push({ id, price, quantity });
        });
    }
    
    // Recalculer les totaux
    function recalculateTotals() {
        let subtotal = 0;
        
        cartData.forEach(item => {
            subtotal += item.price * item.quantity;
            
            // Mettre à jour le total par article
            const itemEl = document.querySelector(`.cart-item[data-id="${item.id}"]`);
            const itemTotalEl = itemEl.querySelector('.item-total');
            itemTotalEl.textContent = (item.price * item.quantity).toFixed(2) + ' €';
        });
        
        // Appliquer le discount si nécessaire
        if (discount > 0) {
            subtotal = subtotal * (1 - discount);
        }
        
        // Déterminer les frais de livraison
        const shipping = subtotal >= FREE_SHIPPING_THRESHOLD ? 0 : SHIPPING_COST;
        
        // Mettre à jour l'interface
        subtotalEl.textContent = subtotal.toFixed(2) + ' €';
        shippingEl.textContent = shipping === 0 ? 'Gratuit' : shipping.toFixed(2) + ' €';
        totalEl.textContent = (subtotal + shipping).toFixed(2) + ' €';
    }
    
    // Gestion des quantités
    if (cartItems) {
        initCartData();
        
        // Boutons - et +
        document.querySelectorAll('.decrease-quantity').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const input = document.querySelector(`.quantity-input[data-id="${id}"]`);
                let value = parseInt(input.value);
                
                if (value > 1) {
                    value--;
                    input.value = value;
                    
                    // Mettre à jour l'état
                    const itemIndex = cartData.findIndex(item => item.id === id);
                    if (itemIndex !== -1) {
                        cartData[itemIndex].quantity = value;
                        recalculateTotals();
                    }
                }
            });
        });
        
        document.querySelectorAll('.increase-quantity').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const input = document.querySelector(`.quantity-input[data-id="${id}"]`);
                let value = parseInt(input.value);
                
                if (value < 99) {
                    value++;
                    input.value = value;
                    
                    // Mettre à jour l'état
                    const itemIndex = cartData.findIndex(item => item.id === id);
                    if (itemIndex !== -1) {
                        cartData[itemIndex].quantity = value;
                        recalculateTotals();
                    }
                }
            });
        });
        
        // Inputs quantité
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', function() {
                const id = this.dataset.id;
                let value = parseInt(this.value);
                
                // Vérifier les limites
                if (isNaN(value) || value < 1) {
                    value = 1;
                } else if (value > 99) {
                    value = 99;
                }
                
                this.value = value;
                
                // Mettre à jour l'état
                const itemIndex = cartData.findIndex(item => item.id === id);
                if (itemIndex !== -1) {
                    cartData[itemIndex].quantity = value;
                    recalculateTotals();
                }
            });
        });
        
        // Suppression d'un article
        document.querySelectorAll('.remove-item').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const item = document.querySelector(`.cart-item[data-id="${id}"]`);
                
                // Animation de suppression
                item.style.transition = 'all 0.3s ease';
                item.style.opacity = '0';
                item.style.height = '0';
                
                setTimeout(() => {
                    item.remove();
                    
                    // Mettre à jour l'état
                    const itemIndex = cartData.findIndex(item => item.id === id);
                    if (itemIndex !== -1) {
                        cartData.splice(itemIndex, 1);
                        recalculateTotals();
                        
                        // Si le panier est vide, recharger la page
                        if (cartData.length === 0) {
                            location.reload();
                        }
                    }
                    
                    // Envoyer une requête AJAX pour supprimer l'article
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', '/cart/remove', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.send(`product_id=${id}&csrf_token=${document.querySelector('input[name="csrf_token"]').value}`);
                }, 300);
            });
        });
        
        // Mise à jour du panier
        if (updateCartBtn) {
            updateCartBtn.addEventListener('click', function() {
                // Collecter les données
                const formData = new FormData();
                cartData.forEach(item => {
                    formData.append(`quantities[${item.id}]`, item.quantity);
                });
                formData.append('csrf_token', document.querySelector('input[name="csrf_token"]').value);
                
                // Envoyer la requête AJAX
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '/cart/update', true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        // Afficher une notification de succès
                        const notification = document.createElement('div');
                        notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-md shadow-lg z-50';
                        notification.textContent = 'Panier mis à jour avec succès';
                        document.body.appendChild(notification);
                        
                        setTimeout(() => {
                            notification.style.opacity = '0';
                            notification.style.transition = 'opacity 0.5s ease';
                            setTimeout(() => notification.remove(), 500);
                        }, 2000);
                    }
                };
                xhr.send(formData);
            });
        }
    }
    
    // Modal pour vider le panier
    if (clearCartBtn && clearCartModal) {
        clearCartBtn.addEventListener('click', function() {
            clearCartModal.classList.remove('hidden');
        });
        
        cancelClearBtn.addEventListener('click', function() {
            clearCartModal.classList.add('hidden');
        });
        
        // Fermer le modal en cliquant à l'extérieur
        clearCartModal.addEventListener('click', function(e) {
            if (e.target === clearCartModal) {
                clearCartModal.classList.add('hidden');
            }
        });
    }
    
    // Gestion du code promo
    if (promoBtn) {
        promoBtn.addEventListener('click', function() {
            const code = promoInput.value.trim();
            
            if (!code) return;
            
            // Simuler la validation du code promo
            // Dans une application réelle, cela devrait être vérifié côté serveur
            if (code.toUpperCase() === 'BIENVENUE10') {
                discount = 0.1; // 10% de réduction
                recalculateTotals();
                
                // Afficher une notification
                const notification = document.createElement('div');
                notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-md shadow-lg z-50';
                notification.textContent = 'Code promo appliqué : 10% de réduction';
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    notification.style.opacity = '0';
                    notification.style.transition = 'opacity 0.5s ease';
                    setTimeout(() => notification.remove(), 500);
                }, 2000);
                
                // Désactiver le champ et le bouton
                promoInput.disabled = true;
                promoBtn.disabled = true;
                promoBtn.classList.add('bg-gray-400');
                promoBtn.classList.remove('bg-gray-800', 'hover:bg-gray-900');
            } else {
                // Code promo invalide
                promoInput.classList.add('border-red-500');
                
                setTimeout(() => {
                    promoInput.classList.remove('border-red-500');
                }, 1500);
            }
        });
    }
    
    // Ajouter les produits suggérés au panier
    document.querySelectorAll('.add-to-cart').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            
            // Animation du bouton
            const originalText = this.textContent;
            this.textContent = 'Ajouté !';
            this.classList.remove('bg-blue-500', 'hover:bg-blue-600');
            this.classList.add('bg-green-500');
            
            setTimeout(() => {
                this.textContent = originalText;
                this.classList.remove('bg-green-500');
                this.classList.add('bg-blue-500', 'hover:bg-blue-600');
            }, 1500);
            
            // Envoyer une requête AJAX pour ajouter au panier
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '/cart/add', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send(`product_id=${id}&quantity=1&csrf_token=${document.querySelector('input[name="csrf_token"]').value}`);
        });
    });
});
</script>

<?php require_once 'views/templates/footer.php' ?>