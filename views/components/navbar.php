<nav>
    <a href="./">Home</a> |
    <a href="products">Produk</a> |
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="logout">Logout (<?= htmlspecialchars($_SESSION['username'] ?? '') ?>)</a>
    <?php else: ?>
        <a href="login">Login</a>
    <?php endif; ?>
</nav>