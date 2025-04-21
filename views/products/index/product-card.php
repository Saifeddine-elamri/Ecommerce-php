<div class="bg-white p-5 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 animate-fade-in">
    <a href="/product?id=<?php echo $product['id']; ?>" class="block group">
        <div class="relative overflow-hidden rounded-xl">
            <img src="/public/images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="w-full h-64 object-cover transition-transform duration-300 group-hover:scale-105" loading="lazy">
            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-opacity duration-300"></div>
        </div>
        <h2 class="text-lg font-semibold text-gray-800 mt-4 group-hover:text-indigo-600 transition-colors duration-200"><?php echo $product['name']; ?></h2>
    </a>
    <p class="text-gray-700 font-medium mt-2">$<?php echo number_format($product['price'], 2); ?></p>
    <p class="text-gray-500 text-sm mt-1">Stock: <span class="font-semibold <?php echo $product['stock'] > 0 ? 'text-green-600' : 'text-red-600'; ?>"><?php echo $product['stock']; ?></span></p>
    <p class="text-gray-500 text-sm mt-1">Catégorie: <?php echo $product['category_name']; ?></p>
    <form method="POST" action="/cart/add" class="mt-4 flex items-center gap-2">
        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <input type="number" name="quantity" min="1" max="<?php echo $product['stock']; ?>" value="1" class="w-16 p-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
        <button type="submit" class="bg-gradient-to-r from-green-500 to-green-600 text-white py-2 px-4 rounded-lg hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-green-400 transition-all duration-200">
            Ajouter
        </button>
    </form>
</div>
