<?php $cnt = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0; ?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e($title ?? 'Online Book Store') ?></title>
<link rel="stylesheet" href="css/style.css"><script src="js/script.js" defer></script></head><body>
<header><a class="logo" href="index.php">📚 BookNest</a>
<nav><a href="index.php">Home</a><a href="cart.php">Cart (<?= $cnt ?>)</a>
<?php if(isset($_SESSION['uid'])): ?>
<a href="orders.php">My Orders</a>
<?php if($_SESSION['role']=='admin'): ?><a href="admin.php">Admin</a><?php endif; ?>
<a href="logout.php">Logout (<?= e($_SESSION['name']) ?>)</a>
<?php else: ?><a href="login.php">Login</a><a href="register.php">Register</a><?php endif; ?>
</nav></header><main>
