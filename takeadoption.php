<?php
session_start();
include 'php/db_conn2.php';

if (!isset($_SESSION['user_id'])) {
    echo "Please log in to continue.";
    exit();
}

$sql = "SELECT g.pet_id, g.id, g.petcatagory, g.petage, g.des, g.cinfo, g.up, u.username 
        FROM giveadopt g
        JOIN prousers u ON g.id = u.id";
$stmt = $conn->query($sql);
$all_pet = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Adoption</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
    <link rel="stylesheet" href="style1.css">
    <style>
        .image{
            cursor: pointer; 
        }
        </style>
</head>
<body>

<?php include_once 'header.php'; ?>

<main>
    <?php
     if ($all_pet) {
         $count = 1;
         foreach($all_pet as $row) { 
    ?>
        <div class="card">
            <div class="product">
                Pet : <?php echo $count++; ?>
            </div>
            <div class="image" onclick="openFullImage('upload/<?php echo $row['up']; ?>')">

                <img src="upload/<?php echo $row['up']; ?>" class="img-fluid image" alt="">
            </div>
            <div class="caption">
                <p class="petcatagory"><?php echo $row["petcatagory"]; ?></p>
                <p class="des">Description : <?php echo $row["des"]; ?></p>
                <p class="petage">AGE : <?php echo $row["petage"]; ?></p>
                <h2>
                    <b>Seller Account</b> : <a href="TakeProvProReport.php?username=<?php
                     echo urlencode($row['username']); ?>" class="me-5" 
                     style="text-decoration: none;"><?php echo $row["username"]; ?></a>
                </h2>
                <p class="cinfo">Contact Information : <?php echo $row["cinfo"]; ?></p>
            </div>
            <br> 
            <button type="button" class="add btn btn-primary" data-id="<?php echo $row["pet_id"]; ?>">Adopt</button>  
        </div>
        <?php
             }
        } else {
              echo "<p>No pet available.</p>";
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
                              target.innerHTML = data.in_petcart;
                              document.getElementById("badge").innerHTML = data.num_petcart;
                           } else {
                                alert('You have already adopted this pet');
                            }
                       } catch (e) {
                            console.error('Error parsing JSON:', e);
                            alert('Sorry! This pet is already adopted.You cannot adopt this pet');
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
