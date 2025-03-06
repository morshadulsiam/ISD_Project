<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sell Product | Pethub </title>
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
            margin: 3% 0 0 3%;
            width: 45%;
            position: relative;
        }
    </style>
</head>
<body>
        <section id="upload_container">
           <form class="shadow w-450 p-3" 
                action="php/productSell.php" method="post" class="rounded bg-white shadow p-5" enctype="multipart/form-data">
                <div class="icon-wrapper">
               <a href="Provider_home.php"> 
                   <i class="fa-regular fa-circle-left fa-2x"></i> 
               </a>
           </div>
                <div class="text-area">
                   <div class="text mb-5">
                        <B>Sell product </B>
                    </div>
                </div>
                <div class="ms-5 logo-middle">
                            <a>
                                <img src="new/redpethub.png" alt="Logo" class="logo-middle-img">
                            </a>
                        </div>
               <h3> </h3>

                <?php if(isset($_GET['error'])){ ?>
    		    <div class="alert alert-danger" role="alert">
                <i class="fa-solid fa-exclamation-circle"></i>
			        <?php echo $_GET['error']; ?>
			    </div>
		        <?php } ?>

		        <?php if(isset($_GET['success'])){ ?>
    		    <div class="alert alert-success" role="alert">
                <i class="fa-solid fa-check-circle"></i>
			        <?php echo $_GET['success']; ?>
			    </div>
		        <?php } ?>


                <div class="mb-3">
                    <td>
                        <select name="productcatagory" id="productcatagory" required>
                            <option value="" disabled selected>Select product</option>
                            <option> Food </option>
                            <option> Medicine </option>
                            <option> Accessories </option>
                            <option> Toy </option>
                        </select>
                    </td>
                </div> <br>
                <input type="text" name="productname" id="productname" placeholder="Product Name" required><br>
                <input type="text" name="des" id="des" placeholder="Description" required><br>
                <input type="text" name="cinfo" id="cinfo" placeholder="Contact Information"><br>
                <input type="text" name="price" id="price" placeholder="Price"><br>
                <label class="form-label mb-2">Upload Picture</label>
                <input type="file" onclick="upload();" class="form-control" name="up"><br>
                <input type="submit" value="Upload" name="submit">
            </form>
        </section>
    </body>
</html>