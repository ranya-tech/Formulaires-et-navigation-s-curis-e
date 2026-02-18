<?php
session_start();
if (!isset($_SESSION["user"])) {
  header("Location: index.php");
  exit;
}
$user = $_SESSION["user"];

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>
  <a href="logout.php">logout</a>
  <p>Welcome<?=$user["name"]?>,
    Your role is <?=$user["role"]?>
  </p>
</body>
</html>