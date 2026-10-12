<?php require 'config.php'; $title='Register'; $err='';
if($_SERVER['REQUEST_METHOD']=='POST'){
 $n=trim($_POST['name']); $em=trim($_POST['email']); $p=$_POST['password'];
 if(!$n||!filter_var($em,FILTER_VALIDATE_EMAIL)||strlen($p)<6){ $err='Please enter valid details (password min 6 chars).'; }
 else { $h=password_hash($p,PASSWORD_DEFAULT);
  $s=$conn->prepare("INSERT INTO users(name,email,password) VALUES(?,?,?)"); $s->bind_param('sss',$n,$em,$h);
  if($s->execute()){ header('Location: login.php?registered=1'); exit; } else { $err='Email already registered.'; } } }
include 'includes/header.php'; ?>
<div class="box"><h2>Create Account</h2><?php if($err): ?><p class="error"><?= e($err) ?></p><?php endif; ?>
<form method="post" onsubmit="return validateRegister(this)">
<input name="name" placeholder="Full name" required><input type="email" name="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Password" required><input type="password" name="confirm" placeholder="Confirm password" required>
<button>Register</button></form></div>
<?php include 'includes/footer.php'; ?>
