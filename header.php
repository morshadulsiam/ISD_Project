<?php
require_once 'php/db_conn2.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


$user_id1 = $_SESSION['user_id'];
$sql_petcart = "SELECT * FROM petcart WHERE user_id1 = :user_id1";
$stmt = $conn->prepare($sql_petcart);
$stmt->bindParam(':user_id1', $user_id1, PDO::PARAM_INT);
$stmt->execute();
$petcart_num = $stmt->rowCount();
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
            <B>Take Adoption</B>
    </div>
    <div class="icons">
        <a class="me-5" href="RecTakeSearch.php"><i class="fas fa-search"></i></a>
            <a class="me-5" href="petcart.php"><i class="fa-solid fa-box-open me-2"></i><span id="badge" class="ms-5"><?php echo $petcart_num; ?></span></a>
        </div>
    </header>
</body>
</html>