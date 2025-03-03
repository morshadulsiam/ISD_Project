<?php
require_once 'php/db_conn1.php';

if (!isset($_SESSION['user_id'])) {
      header("Location: login.php");
      exit();
  }
  
  $user_id = $_SESSION['user_id'];
  $sql_cart = "SELECT * FROM cart WHERE user_id1 = :user_id1";
  $stmt = $conn->prepare($sql_cart);
  $stmt->bindParam(':user_id1', $user_id1, PDO::PARAM_INT);
  $stmt->execute();
  $cart_num = $stmt->rowCount();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="header.css">
</head>
<body>
  <header>
    <div class="icon-wrapper">
      <a href="buyproduct.php"> 
        <i class="fa-regular fa-circle-left fa-2x"></i> 
          </a>
    </div>
    <div class="ms-5 logo-middle">
      <a>
        <img src="new/redpethub.png" alt="Logo" class="logo-middle-img">
      </a>
    </div>
    <div>
      <a href="Receiver_home.php" class="icon-wrapper1"> 
        <i class="fa-solid fa-house-chimney"> </i> 
          <span class="icon-text">Home</span> 
        </a>
    </div>
    <div class="title-text">
      <B>Product Cart</B>
    </div>
    </header>
</body>
</html>