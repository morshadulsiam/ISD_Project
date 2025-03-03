<?php
require_once 'php/db_conn1.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


$user_id1 = $_SESSION['user_id'];
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
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<header>
    <div class="icon-wrapper">
        <a href="Receiver_home.php"> 
            <i class="fa-regular fa-circle-left fa-2x"></i> 
        </a>
    </div>
    <div class="ms-5 logo-middle">
        <a>
            <img src="new/redpethub.png" alt="Logo" class="logo-middle-img">
        </a>
    </div>
    <div class="title-text">
            <B>Buy Product</B>
    </div>
    <div class="icons">
        <a class="me-5" href="RecBuySearch.php"><i class="fas fa-search"></i></a>
        <a class="me-5" href="cart2.php"><i class="fa-solid fa-cart-shopping me-2"></i><span id="badge" class="ms-5"><?php echo $cart_num; ?></span></a>
    </div>
</header>
</body>
</html>


