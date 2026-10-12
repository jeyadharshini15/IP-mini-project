<?php require 'config.php'; need_login(); if($_SESSION['role']!='admin'){ die('Access denied'); } $title='Admin Panel';
if($_SERVER['REQUEST_METHOD']=='POST'){
 if(isset($_POST['delete'])){ $s=$conn->prepare("DELETE FROM books WHERE id=?"); $s->bind_param('i',$_POST['delete']); @$s->execute(); }
 else { $s=$conn->prepare("INSERT INTO books(title,author,category,price,stock,description) VALUES(?,?,?,?,?,?)");
  $s->bind_param('sssdis',$_POST['title'],$_POST['author'],$_POST['category'],$_POST['price'],$_POST['stock'],$_POST['description']); $s->execute(); }
 header('Location: admin.php'); exit; }
$books=$conn->query("SELECT * FROM books ORDER BY id DESC");
include 'includes/header.php'; ?>
<h1>Admin – Manage Books</h1>
<div class="box wide"><h3>Add New Book</h3><form method="post">
<input name="title" placeholder="Title" required><input name="author" placeholder="Author" required><input name="category" placeholder="Category">
<input type="number" step="0.01" name="price" placeholder="Price" required><input type="number" name="stock" placeholder="Stock" value="10">
<textarea name="description" placeholder="Description"></textarea><button>Add Book</button></form></div>
<table><tr><th>ID</th><th>Title</th><th>Author</th><th>Price</th><th>Stock</th><th></th></tr>
<?php while($b=$books->fetch_assoc()): ?><tr><td><?= $b['id'] ?></td><td><?= e($b['title']) ?></td><td><?= e($b['author']) ?></td><td>₹<?= $b['price'] ?></td><td><?= $b['stock'] ?></td>
<td><form method="post" class="inline" onsubmit="return confirm('Delete this book?')"><button class="danger" name="delete" value="<?= $b['id'] ?>">Delete</button></form></td></tr><?php endwhile; ?></table>
<?php include 'includes/footer.php'; ?>
