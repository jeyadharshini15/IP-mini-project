<?php require 'config.php'; need_login(); $title='My Orders';
$s=$conn->prepare("SELECT o.id,o.total,o.created_at,GROUP_CONCAT(CONCAT(b.title,' ×',i.qty) SEPARATOR ', ') items FROM orders o JOIN order_items i ON i.order_id=o.id JOIN books b ON b.id=i.book_id WHERE o.user_id=? GROUP BY o.id ORDER BY o.id DESC");
$s->bind_param('i',$_SESSION['uid']); $s->execute(); $r=$s->get_result();
include 'includes/header.php'; ?>
<h1>My Orders</h1><table><tr><th>#</th><th>Date</th><th>Items</th><th>Total</th></tr>
<?php while($o=$r->fetch_assoc()): ?><tr><td><?= $o['id'] ?></td><td><?= $o['created_at'] ?></td><td><?= e($o['items']) ?></td><td>₹<?= number_format($o['total'],2) ?></td></tr><?php endwhile; ?></table>
<?php include 'includes/footer.php'; ?>
