<?php
session_start();
$conn = new mysqli('localhost','root','','bookstore');
if($conn->connect_error){ die('DB connection failed: '.$conn->connect_error); }
function e($s){ return htmlspecialchars($s, ENT_QUOTES); }
function need_login(){ if(!isset($_SESSION['uid'])){ header('Location: login.php'); exit; } }
