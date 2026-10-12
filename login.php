<?php require 'config.php'; $title='Login'; $err='';
if($_SERVER['REQUEST_METHOD']=='POST'){
 $s=$conn->prepare("SELECT * FROM users WHERE email=?"); $s->bind_param('s',$_POST['email']); $s->execute();
 $u=$s->get_result()->fetch_assoc();
 if($u && password_verify($_POST['password'],$u['password'])){
  session_regenerate_id(true); $_SESSION['uid']=$u['id']; $_SESSION['name']=$u['name']; $_SESSION['role']=$u['role'];
  header('Location: index.php'); exit; } else { $err='Invalid email or password.'; } }
include 'includes/header.php'; ?>
<div class="box"><h2>Login</h2>
<?php if(isset($_GET['registered'])): ?><p class="ok">Registration successful. Please login.</p><?php endif; ?>
<?php if($err): ?><p class="error"><?= e($err) ?></p><?php endif; ?>
<form method="post"><input type="email" name="email" placeholder="Email" required><input type="password" name="password" placeholder="Password" required><button>Login</button></form></div>
<?php include 'includes/footer.php'; ?>
