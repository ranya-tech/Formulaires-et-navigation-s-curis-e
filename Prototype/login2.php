<?php
session_start();
include 'data.php';
$erreurs = [];
$found=false;
if($_SERVER['REQUEST_METHOD']==="POST"){
    $nom = strtolower($_POST["nom"] ?? "");
    $password = $_POST["password"] ?? "";
    if(empty($nom)){
        $erreurs [] = "Enter your name.";
    }
    if(empty($password)){
        $erreurs [] = "Enter your password.";
    }
    if (empty($erreurs)){
        foreach($users as $user){
        if (strtolower($user['name']) === $nom){
            $found=true;
            if ($user['password'] !== $password) {
                $erreurs [] = "Password incorrect!";
                break;
            }
            if ($user['password'] === $password && $user['active'] === false) {
                $erreurs [] = "Compte désactivé!";
                break;
            }
            $_SESSION['name'] = $user["name"];
            $_SESSION['role'] = $user["role"];
            header('Location: profil.php');
            exit;
        }
    
        }
        if(!$found)
        echo 'Identifiants incorrects !!!';
    }
    
    if(!empty($erreurs)){
        foreach($erreurs as $erreur){
            echo "<p style='color:red;'>$erreur</p><br>";
        }
    }
};

?>
<form method="post">
    <label>Name</label>
    <input type="text" name="nom">
    <label>Password</label>
    <input type="password" name="password">
    <button type="submit">Login</button>
</form>