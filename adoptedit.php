<?php
session_start();
include('php/db_conn.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM giveadopt WHERE pet_id=:ID LIMIT 1";
    $stmt = $conn->prepare($sql);
    $data = [':ID' => $id];
    $stmt->execute($data);
    $result = $stmt->fetch(PDO::FETCH_OBJ);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Adopt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="Upload.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-image: url("New/B1.jpg");
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        #upload_container {
            margin: 4% 0 0 3%;
            width: 45%;
            position: relative;
        }
    </style>
</head>
<body>
    <section id="upload_container">
        <form class="shadow w-450 p-3" 
              action="php/adoptedit.php" 
              method="post" 
              class="rounded bg-white shadow p-5" 
              enctype="multipart/form-data">
              
            <div class="icon-wrapper">
                <a href="adoptdetails.php">
                    <i class="fa-regular fa-circle-left fa-2x"></i>
                </a>
            </div>
            
            <div class="text-area">
                <div class="text mb-5">
                    Edit Post
                </div>
            </div>
            <div class="ms-5 logo-middle">
                            <a>
                                <img src="new/redpethub.png" alt="Logo" class="logo-middle-img">
                            </a>
                        </div>
            
            <input type="hidden" name="id" value="<?=$result->pet_id; ?>">

            <div class="mb-3">
                <label class="form-label">Pet Catagory</label>
                <select name="petcatagory" id="petcatagory" required>
                    <option value="" disabled selected>Select pet</option>
                    <option value="Cat" <?=$result->petcatagory == 'Cat' ? 'selected' : ''; ?>>Cat</option>
                    <option value="Dog" <?=$result->petcatagory == 'Dog' ? 'selected' : ''; ?>>Dog</option>
                    <option value="Fish" <?=$result->petcatagory == 'Fish' ? 'selected' : ''; ?>>Fish</option>
                    <option value="Bird" <?=$result->petcatagory == 'Bird' ? 'selected' : ''; ?>>Bird</option>
                    <option value="Rabbit" <?=$result->petcatagory == 'Rabbit' ? 'selected' : ''; ?>>Rabbit</option>
                    <option value="Hamster" <?=$result->petcatagory == 'Hamster' ? 'selected' : ''; ?>>Hamster</option>
                    <option value="Turtle" <?=$result->petcatagory == 'Turtle' ? 'selected' : ''; ?>>Turtle</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Pet Age</label>
                <input type="text" name="petage" value="<?=$result->petage; ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <input type="text" name="des" value="<?=$result->des; ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Contact Information</label>
                <input type="text" name="cinfo" value="<?=$result->cinfo; ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Update Picture</label>
                <input type="file" name="up">
                <input type="hidden" name="old_up" value="<?=$result->up; ?>">
            </div>
            
            <input type="submit" value="Update" name="update_btn">
        </form>
    </section>
</body>
</html>
