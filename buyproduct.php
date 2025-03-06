<?php
session_start();
include 'php/db_conn1.php';

if (!isset($_SESSION['user_id'])) {
    echo "Please log in to continue.";
    exit();
}

$sql = "SELECT p.product_id, p.id, p.productcatagory, p.productname, p.des, p.cinfo, p.price, p.up, u.username
        FROM productsell p
        JOIN prousers u ON p.id = u.id";
$stmt = $conn->query($sql);
$all_product = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style1.css">
</head>

<style>

        .image{
            cursor: pointer; 
        }

main .card .caption .price{
    position: absolute;
    top: 96%;
    right: 2%;
}
    
</style>
<body>

<?php include_once 'header2.php'; ?>

<main>
    <?php if ($all_product) {
        $count = 1;
         foreach ($all_product as $row) { 
    ?>
            <div class="card">
                <div class="product">
                    Product : <?php echo $count++; ?>
                </div>
                <div class="image" onclick="openFullImage('upload/<?php echo $row['up']; ?>')">
                    <img src="upload/<?php echo $row['up']; ?>" class="img-fluid image" alt="">
                </div>
                <div class="caption">
                    <p class="productcatagory"><?php echo $row["productcatagory"]; ?></p>
                    <p class="des">Description : <?php echo $row["des"]; ?></p>
                    <p class="productname">Name : <?php echo $row["productname"]; ?></p>
                    <h2>
                            <b>Seller Account</b> : <a href="BuyProvProReport.php?username=<?php echo urlencode($row['username']); ?>" class="me-5" style="text-decoration: none;"><?php echo $row["username"]; ?>
                        </a>
                    </h2>
                    <p class="cinfo">Contact Information : <?php echo $row["cinfo"]; ?></p>
                    <p class="price">Price : <b>$<?php echo $row["price"]; ?></b></p>
                </div>
                <br>
                <button type="button" class="add btn btn-primary" data-id="<?php echo $row["product_id"]; ?>">Add To Cart</button>
            </div>
        <?php }
        }  else {
            echo"<p>No products available.</p>";
        }
        ?>
</main>

<script>
            function openFullImage(imageUrl) {
    window.open(imageUrl, '_blank');
}
    document.addEventListener('DOMContentLoaded', function () {
        var buttons = document.querySelectorAll('.add');
        buttons.forEach(function (button) {
            button.addEventListener('click', function (event) {
                var target = event.target;
                var id = target.getAttribute('data-id');
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        try {
                            var data = JSON.parse(this.responseText);
                            if (data.success) {
                                target.innerHTML = data.in_cart;
                                document.getElementById("badge").innerHTML = data.num_cart;
                            } else {
                                alert('Already in cart');
                            }
                        } catch (e) {
                            console.error('Error parsing JSON:', e);
                            alert('Sorry! This product is already sold. You cannot buy this product.');
                        }
                    }
                };
                xhr.open('GET', 'php/db_conn1.php?id=' + id, true);
                xhr.send();
            });
        });
    });
</script>
</body>
</html>
