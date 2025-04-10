<?php require_once 'views/templates/header.php'; ?>
<h1 class="text-2xl font-bold mb-4">Inscription</h1>
<?php if (isset($error)): ?>
    <p class="bg-red-100 text-red-800 p-2 rounded mb-4"><?php echo $error; ?></p>
<?php endif; ?>
<form method="POST" action="/register" class="bg-white p-6 rounded shadow max-w-md mx-auto">
    <div class="mb-4">
        <label class="block text-gray-700">Nom d'utilisateur</label>
        <input type="text" name="username" class="w-full p-2 border rounded" required>
    </div>
    <div class="mb-4">
        <label class="block text-gray-700">Email</label>
        <input type="email" name="email" class="w-full p-2 border rounded" required>
    </div>
    <div class="mb-4">
        <label class="block text-gray-700">Mot de passe</label>
        <input type="password" name="password" class="w-full p-2 border rounded" required>
    </div>
    <div class="mb-4">
        <label class="block text-gray-700">Confirmer le mot de passe</label>
        <input type="password" name="confirm_password" class="w-full p-2 border rounded" required>
    </div>
    <button type="submit" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600 w-full">S'inscrire</button>
</form>
<?php require_once 'views/templates/footer.php'; ?>