<?php
include 'php/reportAgainstRec.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Receiver Profile Search</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="header.css">
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
              <a href="Provider_home.php"> 
                <i class="fa-regular fa-circle-left fa-2x"></i> 
              </a>
           </div>
           <div class="ms-2 logo-middle">
                       <a>
                            <img src="new/redpethub.png" alt="Logo" class="logo-middle-img">
                        </a>
            </div>
            <div class="title-text">
                   <B> Search Receiver Profiles
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
      $select_profile = $conn->prepare("SELECT * FROM recusers WHERE username LIKE :search_box"); 
      $select_profile->bindValue(':search_box', "%$search_box%", PDO::PARAM_STR);
      $select_profile->execute();

      if ($select_profile->rowCount() > 0) {
         while ($fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC)) {
   ?>
            
        <div class="d-flex justify-content-center align-items-center vh-100">
             <div class="shadow w-350 p-3 text-center">
                <div class="profile-pic" onclick="openFullImage('upload/<?php echo $fetch_profile['pp']; ?>')">
                <img src="upload/<?php echo $fetch_profile['pp']; ?>" class="img-fluid profile-pic" alt="Profile Picture">
                </div>
                <h3 class="display-4"><?php echo $fetch_profile['fname']; ?></h3>

                <button type="button" class="report btn-4" data-user_id="<?php echo $fetch_profile['user_id']; ?>">Report</button>
               <?php if (isset($_GET['status']) && $_GET['status'] == 'reported'): ?>
               <p class="mt-3 text-danger">Reported</p>
               <?php endif; ?>
            </div>
        </div>
   <?php
         }
      } else {
         echo '<p class="empty">No profile found!</p>';
      }
   }
   ?>


<script>
    function openFullImage(imageUrl) {
    window.open(imageUrl, '_blank');
}

document.addEventListener('DOMContentLoaded', function () {
    var buttons = document.querySelectorAll('.report');
    buttons.forEach(function (button) {
        button.addEventListener('click', function (event) {
            var target = event.target;
            var user_id = target.getAttribute('data-user_id');
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    try {
                        var data = JSON.parse(this.responseText);
                        if (data.success) {
                            target.innerHTML = 'Reported';
                            target.disabled = true;
                        } else {
                            alert('This user has already been reported.');
                        }
                    } catch (e) {
                        console.error('Error parsing JSON:', e);
                    }
                }
            };
            xhr.open('GET', 'php/reportAgainstRec.php?user_id=' + user_id, true);
            xhr.send();
        });
    });
});
</script>
</main>
</body>
</html>
