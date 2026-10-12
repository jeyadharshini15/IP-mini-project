<?php require 'config.php'; $title='Home – BookNest';
$q = '%'.($_GET['q'] ?? '').'%'; $cat = $_GET['cat'] ?? '';
if($cat){ $s=$conn->prepare("SELECT * FROM books WHERE (title LIKE ? OR author LIKE ?) AND category=?"); $s->bind_param('sss',$q,$q,$cat); }
else { $s=$conn->prepare("SELECT * FROM books WHERE title LIKE ? OR author LIKE ?"); $s->bind_param('ss',$q,$q); }
$s->execute(); $books=$s->get_result();
$cats=$conn->query("SELECT DISTINCT category FROM books");
include 'includes/header.php'; ?>
<h1>Browse Books</h1>
<form class="search" method="get"><input name="q" placeholder="Search title or author" value="<?= e($_GET['q'] ?? '') ?>">
<select name="cat"><option value="">All categories</option>
<?php while($c=$cats->fetch_assoc()): ?><option <?= $cat==$c['category']?'selected':'' ?>><?= e($c['category']) ?></option><?php endwhile; ?></select>
<button>Search</button></form>
<div class="grid">
<?php while($b=$books->fetch_assoc()): ?>
<div class="card"><div class="cover"><?= e(mb_substr($b['title'],0,1)) ?></div>
<h3><?= e($b['title']) ?></h3><p class="muted"><?= e($b['author']) ?> • <?= e($b['category']) ?></p>
<p><?= e($b['description']) ?></p><p class="price">₹<?= number_format($b['price'],2) ?></p>
<?php if($b['stock']>0): ?><form method="post" action="cart.php"><input type="hidden" name="action" value="add"><input type="hidden" name="id" value="<?= $b['id'] ?>"><button>Add to Cart</button></form>
<?php else: ?><span class="muted">Out of stock</span><?php endif; ?></div>
<?php endwhile; ?></div>
<?php include 'includes/footer.php'; ?>
