<?php
session_start();
require_once 'php/db_conn.php';
$user_id1 = $_SESSION['user_id'];
$sql_cart = "SELECT * FROM cart WHERE user_id1 = :user_id1";
$stmt_cart = $conn->prepare($sql_cart);
$stmt_cart->bindParam(':user_id1', $user_id1, PDO::PARAM_INT);
$stmt_cart->execute();
$cart_num = $stmt_cart->rowCount();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="font/css/all.min.css">
    <link rel="stylesheet" href="cart.css">
    <title>In Cart Products</title>
</head>
<body>
<?php include_once 'header3.php'; ?>

<main>

    <div class = "num"> 
        Items : <?php echo $cart_num; ?>
    </div>

    <?php
    while ($row_cart = $stmt_cart->fetch(PDO::FETCH_ASSOC)) {
        $sql = "SELECT * FROM productsell WHERE product_id = :product_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':product_id', $row_cart["product_id"], PDO::PARAM_INT);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
    <div class="card">
        <div class="images">
            <img src="<?php echo "upload/" . $row["up"]; ?>" alt="">
        </div>
        <div class="caption">
            <p class="productcatagory"><b><?php echo $row["productcatagory"]; ?></b></p>
            <p class="productname">Name : <?php echo $row["productname"]; ?></p>
            <p class="des">Description : <?php echo $row["des"]; ?></p>
            <p class="price">Price : <b>$<?php echo $row["price"]; ?></b></p>
            <p class="cinfo">Contact Information : <?php echo $row["cinfo"]; ?></p>
            <button class="remove" data-id="<?php echo $row["product_id"]; ?>">Cancel</button>
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
            var cart_id = target.getAttribute('data-id');
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    target.innerHTML = this.responseText;
                    target.style.opacity = .3;
                }
            };
            xhr.open('GET', 'php/db_conn1.php?cart_id=' + cart_id, true);
            xhr.send();
        });
    });
});
</script>
</body>
</html>

