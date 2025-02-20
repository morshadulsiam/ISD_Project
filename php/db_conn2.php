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
        $pet_id = $_GET["id"];
        $user_id1 = $_SESSION['user_id'];

        // Check if the pet is already in the petcart
        $sql = "SELECT * FROM petcart WHERE pet_id = :pet_id AND user_id1 = :user_id1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':pet_id', $pet_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id1', $user_id1, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $in_petcart = "Already adopted";
            $success = true;
        } else {
            // If the pet is not in the cart, insert it
            $insert = "INSERT INTO petcart (pet_id, user_id1) VALUES (:pet_id,:user_id1)";
            $insert_stmt = $conn->prepare($insert);
            $insert_stmt->bindParam(':pet_id', $pet_id, PDO::PARAM_INT);
            $insert_stmt->bindParam(':user_id1', $user_id1, PDO::PARAM_INT);
            $insert_stmt->execute();
            $in_petcart = "Adopted";
            $success = true;
        }

        // Get the total number of items in the petcart
        $total_petcart = "SELECT * FROM petcart WHERE user_id1 = :user_id1";
        $total_petcart_result = $conn->prepare($total_petcart);
        $total_petcart_result->bindParam(':user_id1', $user_id1, PDO::PARAM_INT);
        $total_petcart_result->execute();
        $petcart_num = $total_petcart_result->rowCount();

        echo json_encode(["success" => $success,"num_petcart" => $petcart_num, "in_petcart" => $in_petcart]);
    }

    if (isset($_GET["petcart_id"])) {

        $pet_id = $_GET["petcart_id"];
        $user_id1 = $_SESSION['user_id'];
        
        $sql = "DELETE FROM petcart WHERE pet_id = :pet_id AND user_id1 = :user_id1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':pet_id', $pet_id, PDO::PARAM_INT); // Change from $id to $pet_id
        $stmt->bindParam(':user_id1', $user_id1, PDO::PARAM_INT);
        $stmt->execute();

        echo "Removed";
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

