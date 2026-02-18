<?php
session_start();
require "data.php";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name = $_POST["name"] ?? "";
  $password = $_POST["psw"] ?? "";
  $found = false;
  $pswinc = false;

  if (!empty($name) && !empty($password)) {
    foreach ($users as $user) {
      if ($user["name"] === $name && $user["password"] !== $password) {
        $pswinc = true;
        $errors[] = "password incorrect";
        break;
      }
      if ($user["name"] === $name && $user["password"] === $password) {
      $found = true;
        if (!$user["active"]) {
          $errors[] = "account deactived";
          break;
        }
        
        $_SESSION["user"] = [
          "name" => $user["name"],
          "role" => $user["role"]
        ];
        header("Location: dashboard.php");
        exit;
        
      }
    }
    if (!$found) {
    $errors[] = "invalide user";
  }
  } else {
     $errors[] = "fill all the fields";
  }

}
if (!empty($errors)) {
  foreach ($errors as $err) {
    echo "<p>$err</p>";
  }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <form method="post">
    <label>Nom :</label>
    <input type="text" name="name">

    <label>Password :</label>
    <input type="password" name="psw">
    <button type="submit">Login</button>
  </form>
</body>

</html>