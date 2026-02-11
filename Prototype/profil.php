<?php
session_start();
if(!isset($_SESSION['name'])){
header('Location: login.php');
exit;
}else{
    $name = $_SESSION['name'];
    $role = $_SESSION['role'];
}
echo "<h2>Bienvenue, ". $name . " " . $role ."</h2>";
echo "<a href='logout.php'>Se déconnecter</a>";
?>