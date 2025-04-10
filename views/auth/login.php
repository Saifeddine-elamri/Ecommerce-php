<?php require_once 'views/templates/header.php'; ?>

<h1 class="text-3xl font-semibold text-center mb-6">Connexion</h1>

<?php if (isset($_SESSION['error'])): ?>
    <div class="bg-red-100 text-red-800 p-4 mb-4 rounded-md">
        <?php echo $_SESSION['error']; ?>
        <?php unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<form method="POST" action="/login" class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
    <!-- CSRF Token -->
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="mb-4">
        <label for="username" class="block text-sm font-medium text-gray-700">Nom d'utilisateur</label>
        <input type="text" id="username" name="username" placeholder="Nom d'utilisateur" class="w-full p-3 mt-2 border border-gray-300 rounded-md" required autofocus>
    </div>

    <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
        <input type="password" id="password" name="password" placeholder="Mot de passe" class="w-full p-3 mt-2 border border-gray-300 rounded-md" required>
    </div>

    <div class="mb-6 flex items-center">
        <input type="checkbox" id="remember_me" name="remember_me" class="mr-2">
        <label for="remember_me" class="text-sm text-gray-700">Se souvenir de moi</label>
    </div>

    <button type="submit" class="w-full bg-blue-500 text-white p-3 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Se connecter</button>

    <div class="mt-4 text-center">
        <p class="text-sm text-gray-600">
            Pas encore de compte ? <a href="/register" class="text-blue-500 hover:underline">S'inscrire</a>
        </p>
    </div>
</form>

<?php require_once 'views/templates/footer.php'; ?>
