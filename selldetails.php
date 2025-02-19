<?php
session_start();
include 'php/db_conn1.php';
$id = $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sell Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/Sstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<main>
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-4">
                <?php if (isset($_SESSION['message'])) : ?>
                    <h5 class="alert alert-success"><?=$_SESSION['message'];?></h5>
                    <?php unset($_SESSION['message']); ?>
                <?php endif; ?>

                <div class="card">
                    <div class="card-header">
                        <div class="title1">
                          <B>Product Details</B>
                        </div>
                        <div class="icon-wrapper">
                            <a href="proProfile.php">
                                <i class="fa-regular fa-circle-left fa-2x"></i>
                            </a>
                        </div>
                        <div>
                            <a href="Provider_home.php" class="icon-wrapper1">
                                <i class="fa-solid fa-house-chimney"></i>
                                <span class="icon-text">Home</span>
                            </a>
                        </div>
                        <div class="ms-5 logo-middle">
                            <a>
                                <img src="new/redpethub.png" alt="Logo" class="logo-middle-img">
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Product Catagory</th>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Contact Information</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Upload Picture</th>
                                    <th scope="col">Update</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include 'php/db_conn.php';
                                $sql = "SELECT * FROM productsell WHERE id = ?";
                                $stmt = $conn->prepare($sql);
                                $stmt->execute([$id]);
                                $stmt->setFetchMode(PDO::FETCH_OBJ);
                                $result = $stmt->fetchAll();

                                if ($result) {
                                    foreach ($result as $row) {
                                ?>
                                        <tr>
                                            <td><?= $row->product_id; ?></td>
                                            <td><?= $row->productcatagory; ?></td>
                                            <td><?= $row->productname; ?></td>
                                            <td><?= $row->des; ?></td>
                                            <td><?= $row->cinfo; ?></td>
                                            <td><?= $row->price; ?></td>
                                            <td><img src="<?php echo "upload/" . $row->up; ?>" width="150px"></td>
                                            <td>
                                                <a href="selledit.php?id=<?= $row->product_id; ?>" class="btn btn-primary">Edit</a>
                                            </td>
                                            <td>
                                                <form action="php/selledit.php" method="post">
                                                    <button type="submit" name="delete" value="<?= $row->product_id; ?>" class="btn btn-danger">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                ?>
                                    <tr>
                                        <td colspan="9">Sorry!! you haven't uploaded anything :(</td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>
