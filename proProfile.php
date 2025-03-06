<?php 
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['fname'])) {
    include "php/db_conn1.php";
    include 'php/proUser.php';
    $user = getUserById($_SESSION['id'], $conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Provider Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="pprofile.css">
    <link rel="stylesheet" href="editProfile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .text-area {
            position: relative; 
            margin-left: 40%;
            color: black;
            font-weight: bold;
            font-size: 2rem;
        }   

        .icon-wrapper i {
            font-size: 1.5rem; 
            color: #000;
        }
        .logo-middle {
            position: absolute;
            display: flex;
            top: 10px;
            left: 120px;
            z-index: 10;
        }
        .logo-middle-img {
           height: 100px;
           width: 120px;
           margin-top:-17px;
           margin-left: 120px;
        }
        .title {
            position: absolute;
            display: flex;
            top: -5px;
            left: 47%;
            z-index: 10;
            color: black;
            font-weight: bold;
            font-size: 2rem;
            margin-top: 12px;
        }
        header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 50px;
        padding: 0 20px;
        background-color: white;
        box-shadow: black; 
        z-index: 10;
}
    </style>
</head>
<body>
    <?php if ($user) { ?>
        <header>
        <div class="icon-wrapper">
            <a href="Provider_home.php"> 
            <i class="fa-regular fa-circle-left fa-2x"></i> 
            </a>
        </div> 
        <div class="ms-5 logo-middle">
            <a>
            <img src="new/redpethub.png" alt="Logo" class="logo-middle-img">
            </a>
            </div>
        <div class="title">
            <B>Profile</B>
        </div>
    </header>

        <section class="home">
            <div class="content">
                <h1><span><?= htmlspecialchars($user['fname']) ?><br></span></h1>
                <br> <br> <br>
                <div class="btn_box">
                    <button class="btn-1" id="editBtn"><i class="fa-solid fa-pen-to-square me-2"></i>Edit Profile</button>
                    <button class="btn-2" onclick="window.location.href='adoptdetails.php';"><i class="fa-solid fa-circle-info"></i>Adoption Details</button>
                    <button class="btn-3" onclick="window.location.href='selldetails.php';"><i class="fa-solid fa-circle-info me-2"></i>Product Details</button>
                    <button class="btn-4" onclick="window.location.href='logout.php';"><i class="fa-solid fa-right-from-bracket"></i>Logout</button>
                </div>
            </div>
            <div class="profile-pic" onclick="openFullImage('upload/<?= htmlspecialchars($user['pp']) ?>')">
                <img src="upload/<?= htmlspecialchars($user['pp']) ?>" class="img-fluid profile-pic" alt="Profile Picture">
            </div>
        </section>

        <div id="myModal" class="modal">
            <div class="modal-content">
                <form class="shadow w-450 p-3" action="php/proedit.php" method="post" enctype="multipart/form-data">
                    <div class="text-area">
                      <div class="text mb-5">
                        <B>Edit Profile
                      </div>
                    </div>
                    <span class="close">&times;</span>
                    
                    <?php if (isset($_GET['error'])) { ?>
                        <div class="alert alert-danger" role="alert">
                            <?= htmlspecialchars($_GET['error']) ?>
                        </div>
                    <?php } ?>

                    <?php if (isset($_GET['success'])) { ?>
                        <div class="alert alert-success" role="alert">
                            <i class="fa-solid fa-check-circle"></i>
                            <?= htmlspecialchars($_GET['success']) ?>
                        </div>
                    <?php } ?>

                    <div class="mb-3">
                        <label class="form-label mb-2">Full Name</label>
                        <input type="text" name="fname" value="<?= htmlspecialchars($user['fname']) ?>" >
                    </div>

                    <div class="mb-3">
                        <label class="form-label mb-2">User Name</label>
                        <input type="text" name="uname" value="<?= htmlspecialchars($user['username']) ?>" >
                    </div>

                    <div class="mb-3">
                        <label class="form-label mb-2">Profile Picture</label>
                        <input type="file" name="pp" >
                        <img src="upload/<?= htmlspecialchars($user['pp']) ?>" class="rounded-circle" style="width: 70px" alt="Current Profile Picture">
                        <input type="hidden" name="old_pp" value="<?= htmlspecialchars($user['pp']) ?>">
                    </div>
                    <input type="submit" value="Update" class="btn btn-primary">
                </form>
            </div>
        </div>

    <?php } else {
        header("Location: login.php");
        exit;
    } ?>   

    <script>
        function openFullImage(imageUrl) {
            window.open(imageUrl, '_blank');
        }

        var modal = document.getElementById("myModal");
        var btn = document.getElementById("editBtn");
        var span = document.getElementsByClassName("close")[0];

        btn.onclick = function() {
            modal.style.display = "block";
        }

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        <?php if (isset($_GET['error']) || isset($_GET['success'])) { ?>
            modal.style.display = "block";
            setTimeout(function() {
                var url = window.location.href;
                url = url.split('?')[0];
                window.history.replaceState({}, document.title, url);
            }, 5000);
        <?php } ?>
    </script>
</body>
</html>

<?php } else {
    header("Location: login.php");
    exit;
} ?>
