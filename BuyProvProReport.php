<?php 
session_start();
include 'php/reportAgainstPro.php';

if (isset($_GET['username'])) {
    $username = $_GET['username'];
    $select_profile = $conn->prepare("SELECT * FROM prousers WHERE username = :username"); 
    $select_profile->bindParam(':username', $username, PDO::PARAM_STR);
    $select_profile->execute();

    if ($select_profile->rowCount() > 0) {
        $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "User not found.";
        exit();
    }
} else {
    echo "No username provided.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="Profile.css">
    <style>
        .profile-pic {
            width: 300px;
            height: 300px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto;
            cursor: pointer; 
        }
        .profile-container {
            text-align: center;
        }
        main{
        max-width: 1500px;
        width: 100%;
        margin: auto;
        background: #eceaffad;

    }
    .btn-4{
    padding: 15px 14px;
    background-color: red;
    color: white;
    border: 2px solid black;
    border-radius: 16px;
    font-size: 18px;
    letter-spacing: 1px;
    font-weight: 600;
    transition: 0.3s ease;
    cursor: pointer;
}
.btn-4:hover{
    background-color: white;
    color: red;
}

    </style>
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
              </a>
        </div>
            <div class="title-text">
                    <B>Seller Profile</B>
            </div>
            
</header>
<main>
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="shadow w-350 p-3 profile-container">
        <div class="profile-pic" onclick="openFullImage('upload/<?php echo $fetch_profile['pp']; ?>')">
            <img src="upload/<?php echo $fetch_profile['pp']; ?>" class="img-fluid profile-pic" alt="Profile Picture">
        </div>
        <h3 class="display-4"><?php echo $fetch_profile['fname']; ?></h3>

        <button type="button" class="report btn-4" data-id="<?php echo $fetch_profile['id']; ?>">Report</button>
        
        <?php if (isset($_GET['status']) && $_GET['status'] == 'reported'): ?>
            <p class="mt-3 text-danger">Reported</p>
        <?php endif; ?>
    </div>
</div>

<script>
function openFullImage(imageUrl) {
    window.open(imageUrl, '_blank');
}

document.addEventListener('DOMContentLoaded', function () {
    var buttons = document.querySelectorAll('.report');
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
                            target.innerHTML = data.message;
                            target.disabled = true; 
                        } else {
                            alert('This user has already been reported.');
                        }
                    } catch (e) {
                        console.error('Error parsing JSON:', e);
                    }
                }
            };
            xhr.open('GET', 'php/reportAgainstPro.php?id=' + id, true);
            xhr.send();
        });
    });
});
</script>
</main>
</body>
</html>
