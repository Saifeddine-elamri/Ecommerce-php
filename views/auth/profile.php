<?php require_once 'views/templates/header.php'; ?>
<h1 class="text-2xl font-bold mb-4">Mon Profil</h1>
<?php if (isset($success)): ?>
    <p class="bg-green-100 text-green-800 p-2 rounded mb-4"><?php echo $success; ?></p>
<?php endif; ?>
<?php if (isset($error)): ?>
    <p class="bg-red-100 text-red-800 p-2 rounded mb-4"><?php echo $error; ?></p>
<?php endif; ?>
<form method="POST" action="/profile" class="bg-white p-6 rounded shadow max-w-md mx-auto">
    <div class="mb-4">
        <label class="block text-gray-700">Nom d'utilisateur</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" class="w-full p-2 border rounded" required>
    </div>
    <div class="mb-4">
        <label class="block text-gray-700">Email</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="w-full p-2 border rounded" required>
    </div>
    <div class="mb-4">
        <label class="block text-gray-700">Nouveau mot de passe (laisser vide pour ne pas changer)</label>
        <input type="password" name="password" class="w-full p-2 border rounded">
    </div>
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <button type="submit" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600 w-full">Mettre à jour</button>
</form>
<?php require_once 'views/templates/footer.php'; ?>