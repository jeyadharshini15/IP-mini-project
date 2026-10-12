<?php require 'config.php'; $title='Your Cart';
if(!isset($_SESSION['cart'])) $_SESSION['cart']=[];
if($_SERVER['REQUEST_METHOD']=='POST'){
 $id=(int)($_POST['id'] ?? 0); $a=$_POST['action'] ?? '';
 if($a=='add'){ $_SESSION['cart'][$id]=($_SESSION['cart'][$id] ?? 0)+1; }
 elseif($a=='update'){ $q=(int)$_POST['qty']; if($q>0) $_SESSION['cart'][$id]=$q; else unset($_SESSION['cart'][$id]); }
 elseif($a=='remove'){ unset($_SESSION['cart'][$id]); }
 header('Location: cart.php'); exit; }
$items=[]; $total=0;
foreach($_SESSION['cart'] as $id=>$q){ $s=$conn->prepare("SELECT * FROM books WHERE id=?"); $s->bind_param('i',$id); $s->execute();
 if($b=$s->get_result()->fetch_assoc()){ $b['qty']=$q; $b['sub']=$q*$b['price']; $total+=$b['sub']; $items[]=$b; } }
include 'includes/header.php'; ?>
<h1>Shopping Cart</h1>
<?php if(!$items): ?><p>Your cart is empty. <a href="index.php">Browse books</a></p>
<?php else: ?><table><tr><th>Book</th><th>Price</th><th>Qty</th><th>Subtotal</th><th></th></tr>
<?php foreach($items as $b): ?><tr><td><?= e($b['title']) ?></td><td>₹<?= $b['price'] ?></td>
<td><form method="post" class="inline"><input type="hidden" name="action" value="update"><input type="hidden" name="id" value="<?= $b['id'] ?>"><input type="number" name="qty" value="<?= $b['qty'] ?>" min="0" max="<?= $b['stock'] ?>"><button>Update</button></form></td>
<td>₹<?= number_format($b['sub'],2) ?></td>
<td><form method="post" class="inline"><input type="hidden" name="action" value="remove"><input type="hidden" name="id" value="<?= $b['id'] ?>"><button class="danger">Remove</button></form></td></tr><?php endforeach; ?>
<tr><td colspan="3"><b>Total</b></td><td colspan="2"><b>₹<?= number_format($total,2) ?></b></td></tr></table>
<a class="btn" href="checkout.php">Proceed to Checkout</a><?php endif; ?>
<?php include 'includes/footer.php'; ?>
