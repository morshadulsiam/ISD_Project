<?php
session_start();
include 'php/db_conn2.php';

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
    <title>Search Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="header.css">
</head>
<body>
    <header>
        <div class="icon-wrapper">
            <a href="takeadoption.php">
                <i class="fa-regular fa-circle-left fa-2x"></i>
            </a>
        </div>
        <div class="ms-5 logo-middle">
                       <a>
                            <img src="new/redpethub.png" alt="Logo" class="logo-middle-img">
                        </a>
        </div>
        <div>
            <a href="Receiver_home.php" class="icon-wrapper2">
                <i class="fa-solid fa-house-chimney"></i>
            </a>
        </div>

        <div class="icons">
            <a class="me-5" href="petcart.php">
                <i class="fa-solid fa-box-open me-2"></i>
                <span id="badge" class="ms-5"><?php echo $petcart_num; ?></span>
            </a>
        </div>
        <div class="title-text">
            <B>Search your desired pets</B>
    </div>
    </header>
    <section class="search-form">
        <form action="" method="post">
            <div class="search-box-container">
                <input type="text" name="search_box" placeholder="Search here..." maxlength="100" class="box" required>
                <button type="submit" class="fas fa-search search-btn" name="search_btn"></button>
            </div>
        </form>
    </section>
    <main>
        <?php
        if (isset($_POST['search_box']) || isset($_POST['search_btn'])) {
            $search_box = $_POST['search_box'];
            $select_products = $conn->prepare("SELECT g.pet_id, g.id, g.petcatagory,g.des, g.petage, g.cinfo, g.up, u.username 
                                              FROM giveadopt g
                                              JOIN prousers u ON g.id = u.id 
                                              WHERE petcatagory LIKE :search_box");
            $select_products->bindValue(':search_box', "%$search_box%", PDO::PARAM_STR);
            $select_products->execute();

            if ($select_products->rowCount() > 0) {
                $count = 1;
                while ($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)) {
        ?>
                    <div class="card">
                       <div class="product">
                           Pet : <?php echo $count++; ?>
                        </div>
                        <div class="image">
                            <img src="<?php echo "upload/" . $fetch_product["up"]; ?>" alt="">
                        </div>
                        <div class="caption">
                            <p class="petcatagory"><?php echo $fetch_product["petcatagory"]; ?></p>
                            <p class="des">Description : <?php echo $fetch_product["des"]; ?></p>
                            <p class="petage">AGE: <?php echo $fetch_product["petage"]; ?></p>
                            <h2>
                                <b>Seller Account</b> : <a href="TakeProvProReport.php?username=<?php echo urlencode($fetch_product['username']); ?>" class="me-5" style="text-decoration: none;">
                                    <?php echo $fetch_product["username"]; ?>
                                </a>
                            </h2>
                            <p class="cinfo">Contact Information : <?php echo $fetch_product["cinfo"]; ?></p>
                        </div>
                        <br>
                        <button type="button" class="add btn btn-primary" data-id="<?php echo $fetch_product["pet_id"]; ?>">Adopt</button>
                    </div>
        <?php
                }
            } else {
                echo '<p class="empty">No pet found!</p>';
            }
        }
        ?>
    </main>
    <script>
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
                                    target.innerHTML = data.in_petcart;
                                    document.getElementById("badge").innerHTML = data.num_petcart;
                                } else {
                                    alert('You Already adopt this pet');
                                }
                            } catch (e) {
                                console.error('Error parsing JSON:', e);
                                alert('Sorry! this pet already adopted.You cannot adopt this pet');
                            }
                        }
                    };
                    xhr.open('GET', 'php/db_conn2.php?id=' + id, true);
                    xhr.send();
                });
            });
        });
    </script>
</body>
</html>
