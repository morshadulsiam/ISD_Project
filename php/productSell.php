<?php 

session_start();

if(isset($_POST['productcatagory']) && isset($_POST['productname']) &&  isset($_POST['des']) &&  isset($_POST['cinfo']) &&  isset($_POST['price'])){
   include "db_conn.php";
    
    $productcatagory = $_POST['productcatagory'];
    $productname = $_POST['productname'];
    $des = $_POST['des'];
    $cinfo = $_POST['cinfo'];
    $price = $_POST['price'];
    $id = $_SESSION['id'];

    $data = "&productcatagory=".$productcatagory."&productname=".$productname."&des=".$des."&cinfo=".$cinfo."&price=".$price;
    
    if (empty($productcatagory)) {
    	$em = "product Catagory is required";
    	header("Location: ../sellproduct.php?error=$em&$data");
	    exit;
    }else if(empty($productname)){
    	$em = "product Name is required";
    	header("Location: ../sellproduct.php?error=$em&$data");
	    exit;
    }else if(empty($des)){
    	$em = "Description is required";
    	header("Location: ../sellproduct.php?error=$em&$data");
	    exit;
    }else if(empty($cinfo)){
            $em = "Contact information is required";
            header("Location: ../sellproduct.php?error=$em&$data");
            exit;
    }else if(empty($price)){
        $em = "Price is required";
        header("Location: ../sellproduct.php?error=$em&$data");
        exit;
    }else {
      
      if (isset($_POST['submit']) && isset($_FILES['up'])) {
         $img_name = $_FILES['up']['name'];
         $tmp_name = $_FILES['up']['tmp_name'];
         $error = $_FILES['up']['error'];
         
         if($error === 0){
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_to_lc = strtolower($img_ex);
            $allowed_exs = array("jpg", "jpeg", "png");

            if(in_array($img_ex_to_lc, $allowed_exs)){
               $new_img_name = uniqid($productname, true).'.'.$img_ex_to_lc;
               $img_upload_path = '../upload/'.$new_img_name;
               move_uploaded_file($tmp_name, $img_upload_path);

               $sql = "INSERT INTO productsell(productcatagory,productname,des,cinfo,price,up,id) VALUES(?,?,?,?,?,?,?)";
               $stmt = $conn->prepare($sql);
               $stmt->execute([$productcatagory, $productname, $des, $cinfo, $price, $new_img_name, $id]);

               header("Location: ../sellproduct.php?success= Congrats!! uploaded successfully");
                exit;
            }else {
               $em = "You can't upload files of this type";
               header("Location: ../sellproduct.php?error=$em&$data");
               exit;
            }
         }else {
            $em = "unknown error occurred!";
            header("Location: ../sellproduct.php?error=$em&$data");
            exit;
         }

        
      }else {
       	$sql = "INSERT INTO productsell(productcatagory,productname,des,cinfo,price,id) VALUES(?,?,?,?,?,?)";
       	$stmt = $conn->prepare($sql);
       	$stmt->execute([$productcatagory, $productname, $des, $cinfo, $price, $id]);

       	header("Location: ../sellproduct.php?success=Congrats!! uploaded successfully");
   	    exit;
      }
    }


}else {
	header("Location: ../sellproduct.php?error=error");
	exit;
}
