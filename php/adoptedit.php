<?php  
session_start();
include "db_conn2.php";

if(isset($_POST['delete']))
{
   $id = $_POST['delete'];
   try{
      $sql = "DELETE FROM giveadopt WHERE pet_id=:ID";
      $stmt = $conn->prepare($sql);
      $data = [':ID' => $id];
      $sql_execute = $stmt->execute($data);

      if($sql_execute)
      {
         $_SESSION['message'] = "Deleted Successfully";
         header('Location: ../adoptdetails.php');
         exit(0);
      }
      else
      {
        $_SESSION['message'] = "Not Deleted";
        header('Location: ../adoptdetails.php');
        exit(0);
      }

   } catch(PDOException $e){
      echo $e->getMessage();
   }
}

if(isset($_POST['update_btn']))
{
    $id = $_POST['id'];
    $petcatagory = $_POST['petcatagory'];
    $petage = $_POST['petage'];
    $des = $_POST['des'];
    $cinfo = $_POST['cinfo'];
    $old_up = $_POST['old_up'];

    if (isset($_FILES['up']) && $_FILES['up']['error'] === 0) {
        $img_name = $_FILES['up']['name'];
        $tmp_name = $_FILES['up']['tmp_name'];
        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
        $img_ex_to_lc = strtolower($img_ex);

        $allowed_exs = array('jpg', 'jpeg', 'png');
        if(in_array($img_ex_to_lc, $allowed_exs)) {
            $new_img_name = uniqid($petcatagory, true).'.'.$img_ex_to_lc;
            $img_upload_path = '../upload/'.$new_img_name;

            // Delete old profile pic
            $old_up_des = "../upload/$old_up";
            if(file_exists($old_up_des) && $old_up !== 'default-pp.png') {
                unlink($old_up_des);
            }
            move_uploaded_file($tmp_name, $img_upload_path);

            // Update the Database
            $sql = "UPDATE giveadopt 
                    SET petcatagory=?, petage=?, des=?, cinfo=?, up=?
                    WHERE pet_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$petcatagory, $petage, $des, $cinfo, $new_img_name, $id]);
            $_SESSION['message'] = "Updated Successfully";
            header("Location: ../adoptdetails.php");
            exit;
        } else {
            $em = "You can't upload files of this type";
            header("Location: ../adoptdetails.php?error=$em");
            exit;
        }
    } else {
        // Update the Database without changing the image
        $sql = "UPDATE giveadopt 
                SET petcatagory=?, petage=?, des=?, cinfo=?
                WHERE pet_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$petcatagory, $petage, $des, $cinfo, $id]);

        $_SESSION['message'] = "Updated Successfully";
        header("Location: ../adoptdetails.php");
        exit;
    }
} else {
    header("Location: login.php");
    exit;
}
?>
