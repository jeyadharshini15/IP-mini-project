<?php require 'config.php'; need_login(); $title='Checkout';
if(empty($_SESSION['cart'])){ header('Location: cart.php'); exit; }
$items=[]; $total=0;
foreach($_SESSION['cart'] as $id=>$q){ $s=$conn->prepare("SELECT * FROM books WHERE id=?"); $s->bind_param('i',$id); $s->execute();
 if($b=$s->get_result()->fetch_assoc()){ $b['qty']=$q; $total+=$q*$b['price']; $items[]=$b; } }
$done=false;
if($_SERVER['REQUEST_METHOD']=='POST'){
 $conn->begin_transaction();
 $s=$conn->prepare("INSERT INTO orders(user_id,total) VALUES(?,?)"); $s->bind_param('id',$_SESSION['uid'],$total); $s->execute(); $oid=$conn->insert_id;
 foreach($items as $b){
  $s=$conn->prepare("INSERT INTO order_items(order_id,book_id,qty,price) VALUES(?,?,?,?)"); $s->bind_param('iiid',$oid,$b['id'],$b['qty'],$b['price']); $s->execute();
  $s=$conn->prepare("UPDATE books SET stock=GREATEST(stock-?,0) WHERE id=?"); $s->bind_param('ii',$b['qty'],$b['id']); $s->execute(); }
 $conn->commit(); $_SESSION['cart']=[]; $done=true; }
include 'includes/header.php'; ?>
<?php if($done): ?><div class="box"><h2>✅ Order Placed!</h2><p>Your order #<?= $oid ?> was successful.</p><a class="btn" href="orders.php">View Orders</a></div>
<?php else: ?><div class="box"><h2>Order Summary</h2>
<?php foreach($items as $b): ?><p><?= e($b['title']) ?> × <?= $b['qty'] ?> — ₹<?= number_format($b['qty']*$b['price'],2) ?></p><?php endforeach; ?>
<h3>Total: ₹<?= number_format($total,2) ?></h3><form method="post"><button>Confirm Order</button></form></div><?php endif; ?>
<?php include 'includes/footer.php'; ?>
