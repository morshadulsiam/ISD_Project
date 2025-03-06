<?php
session_start();
require_once 'php/db_conn2.php';

$user_id1 = $_SESSION['user_id']; 
$sql_petcart = "SELECT * FROM petcart WHERE user_id1 = :user_id1";
$stmt_cart = $conn->prepare($sql_petcart);
$stmt_cart->bindParam(':user_id1', $user_id1, PDO::PARAM_INT);
$stmt_cart->execute();
$petcart_num = $stmt_cart->rowCount();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="font/css/all.min.css">
    <link rel="stylesheet" href="pet.css">
    <title>In Cart Pets</title>
</head>
<body>
    <?php include_once 'header4.php'; ?>

    <main>

        <div class = "num"> 
            Pets : <?php echo $petcart_num; ?>
        </div>
        
        <?php
        while ($row_petcart = $stmt_cart->fetch(PDO::FETCH_ASSOC)) {
            $sql = "SELECT * FROM giveadopt WHERE pet_id = :pet_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':pet_id', $row_petcart["pet_id"], PDO::PARAM_INT);
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
        
        <div class="card">
            <div class="images">
                <img src="<?php echo "upload/" . $row["up"]; ?>" alt="">
            </div>
            <div class="caption">
                <p class="petcatagory"><b><?php echo $row["petcatagory"]; ?></b></p>
                <p class="des">Description : <?php echo $row["des"]; ?></p>
                <p class="petage">Age : <?php echo $row["petage"]; ?></p>
                <p class="cinfo">Contact Information : <?php echo $row["cinfo"]; ?></p>
                <button class="remove" data-id="<?php echo $row_petcart["pet_id"]; ?>">Cancel</button>
            </div>
        </div>
        <?php
            }
        }
        ?>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var removeButtons = document.querySelectorAll('.remove');
            removeButtons.forEach(function (button) {
                button.addEventListener('click', function (event) {
                    var target = event.target;
                    var petcart_id = target.getAttribute('data-id');
                    var xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function () {
                        if (this.readyState === 4 && this.status === 200) {
                            target.innerHTML = this.responseText;
                            target.style.opacity = 0.3;
                        } else if (this.readyState === 4) {
                            console.error("Error: " + this.status);
                        }
                    };
                    xhr.open('GET', 'php/db_conn2.php?petcart_id=' + petcart_id, true);
                    xhr.send();
                });
            });
        });
    </script>
</body>
</html>
