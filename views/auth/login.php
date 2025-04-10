<?php require_once 'views/templates/header.php'; ?>
<h1>Login</h1>
<form method="POST" action="/login">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>
<?php require_once 'views/templates/footer.php'; ?>