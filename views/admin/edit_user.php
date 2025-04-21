<?php require_once 'views/templates/header.php'; ?>

<h1 class="text-3xl font-bold text-center text-indigo-800 mb-6 animate__animated animate__fadeInUp">Modifier un utilisateur</h1>

<?php if (isset($error)): ?>
    <div class="bg-red-100 text-red-800 p-4 rounded-lg mb-6 shadow-md animate__animated animate__fadeInUp">
        <i class="fas fa-exclamation-circle mr-2"></i>
        <span><?php echo $error; ?></span>
    </div>
<?php endif; ?>

<form method="POST" action="/admin/user/<?php echo $user['id']; ?>/edit" class="bg-white p-8 rounded-xl shadow-lg max-w-3xl mx-auto space-y-6">
    <div class="mb-6">
        <label class="block text-gray-700 font-semibold">Nom de l'utilisateur</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($user['username']); ?>" class="w-full p-3 border rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300" required>
    </div>
    
    <div class="mb-6">
        <label class="block text-gray-700 font-semibold">Email</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="w-full p-3 border rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300" required>
    </div>

    <div class="mb-6">
        <label class="block text-gray-700 font-semibold">Rôle</label>
        <select name="role" class="w-full p-3 border rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300" required>
            <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Administrateur</option>
            <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>Utilisateur</option>
        </select>
    </div>

    <div class="mb-6">
        <label class="block text-gray-700 font-semibold">Statut</label>
        <select name="is_active" class="w-full p-3 border rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300" required>
            <option value="1" <?php echo $user['is_active'] ? 'selected' : ''; ?>>Actif</option>
            <option value="0" <?php echo !$user['is_active'] ? 'selected' : ''; ?>>Inactif</option>
        </select>
    </div>

    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <button type="submit" class="bg-indigo-600 text-white p-3 rounded-lg hover:bg-indigo-700 shadow-lg transition duration-300 w-full transform hover:scale-105">
        <i class="fas fa-save mr-2"></i> Mettre à jour l'utilisateur
    </button>
</form>

<?php require_once 'views/templates/footer.php'; ?>
