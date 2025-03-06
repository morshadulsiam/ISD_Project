<?php

$sName = "localhost";
$uName = "root";
$pass = "";
$db_name = "auth_db";

try {
    $conn = new PDO("mysql:host=$sName;dbname=$db_name", $uName, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_GET["id"])) {
        $product_id = $_GET["id"];
        $user_id1 = $_SESSION['user_id'];

        //Check if the product is already in the cart
        $sql = "SELECT * FROM cart WHERE product_id = :product_id AND user_id1 = :user_id1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id1', $user_id1, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $in_cart = "Already in cart";
            $success = false;
        } else {
            //If the product is not in the cart, insert it
            $insert = "INSERT INTO cart (product_id, user_id1) VALUES (:product_id, :user_id1)";
            $insert_stmt = $conn->prepare($insert);
            $insert_stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $insert_stmt->bindParam(':user_id1', $user_id1, PDO::PARAM_INT);
            $insert_stmt->execute();
            $in_cart = "Added to cart";
            $success = true;
        }

        // Get the total number of items in the user's cart
        $total_cart = "SELECT * FROM cart WHERE user_id1 = :user_id1";
        $total_cart_stmt = $conn->prepare($total_cart);
        $total_cart_stmt->bindParam(':user_id1', $user_id1, PDO::PARAM_INT);
        $total_cart_stmt->execute();
        $cart_num = $total_cart_stmt->rowCount();

        echo json_encode(["success" => $success, "num_cart" => $cart_num, "in_cart" => $in_cart]);
    }

    if (isset($_GET["cart_id"])) {
        $product_id = $_GET["cart_id"];
        $user_id1 = $_SESSION['user_id'];

        $sql = "DELETE FROM cart WHERE product_id = :product_id AND user_id1 = :user_id1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id1', $user_id1, PDO::PARAM_INT);
        $stmt->execute();

        echo "Removed from cart";
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
