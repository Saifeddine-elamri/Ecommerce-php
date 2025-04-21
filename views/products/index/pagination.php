<!-- views/templates/pagination.php -->
<nav class="mt-12 flex justify-center gap-3 max-w-7xl mx-auto">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="/products?page=<?php echo $i; ?>&category=<?php echo $categoryId ?? ''; ?>&sort=<?php echo $sort; ?>&stock=<?php echo $stockFilter ?? ''; ?>" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-indigo-500 hover:text-white transition-all duration-200 <?php echo $page === $i ? 'bg-indigo-500 text-white' : ''; ?>">
            <?php echo $i; ?>
        </a>
    <?php endfor; ?>
</nav>
