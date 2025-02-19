<?php
include('php/db_conn.php');
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Sell</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="Upload.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
      body{
      background-image: url("New/sell.jpg");
      background-position: center;
      background-size: cover;
      background-repeat: no-repeat;
      background-attachment: fixed;
      }
      #upload_container{
    margin: 4% 0 0 3%;
    width: 45%;
    position: relative;
    }
    </style>
  </head>
  <body>
    
  <section id="upload_container">
    <?php
      if(isset($_GET['id']))
      {
           $id = $_GET['id'];
           $sql="SELECT * FROM productsell WHERE product_id=:ID LIMIT 1";
           $stmt = $conn->prepare($sql);
           $data = [':ID'=> $id];
           $stmt->execute($data);
           $result = $stmt->fetch(PDO::FETCH_OBJ);
      }
    ?>
    <form class="shadow w-450 p-3" 
    action="php/selledit.php" method="post" class="rounded bg-white shadow p-5" enctype="multipart/form-data">
    <div class="icon-wrapper">
      <a href="selldetails.php"> 
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

    <input type="hidden" name="id" value="<?=$result->product_id; ?>">

    <div class="mb-3">
        <label class="form-label">Product Category</label>
        <select name="productcatagory" id="productcatagory" required>
        <option value="" disabled selected>Select product</option>
            <option <?=($result->productcatagory == 'Food') ? 'selected' : '';?>>Food</option>
            <option <?=($result->productcatagory == 'Medicine') ? 'selected' : '';?>>Medicine</option>
            <option <?=($result->productcatagory == 'Accessories') ? 'selected' : '';?>>Accessories</option>
            <option <?=($result->productcatagory == 'Toy') ? 'selected' : '';?>>Toy</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Product Name</label>
        <input type="text" 
               name="productname"
               value="<?=$result->productname; ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Description</label>
        <input type="text"
               name="des"
               value="<?=$result->des; ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Contact Information</label>
        <input type="text"
               name="cinfo"
               value="<?=$result->cinfo; ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Price</label>
        <input type="text"
               name="price"
               value="<?=$result->price; ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Update Picture</label>
        <input type="file" 
               name="up">
        <input type="hidden" 
               name="old_up"
               value="<?=$result->up; ?>" >
    </div>
    <input type="submit" value="Update" name="update_btn">
    </form>
  </section>                                                         
  </body>
</html>
