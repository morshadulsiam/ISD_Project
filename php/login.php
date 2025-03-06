<?php 
session_start();

if(isset($_POST['uname']) && 
   isset($_POST['pass'])){

    include "db_conn.php";

    $uname = $_POST['uname'];
    $pass = $_POST['pass'];

    $data = "uname=".$uname;
    
    if(empty($uname)){
    	$em = "User name is required";
    	header("Location: ../login.php?error=$em&$data");
	    exit;
    }else if(empty($pass)){
    	$em = "Password is required";
    	header("Location: ../login.php?error=$em&$data");
	    exit;
    } else {
    	$sql = "SELECT * FROM prousers WHERE username = ?";
    	$stmt = $conn->prepare($sql);
    	$stmt->execute([$uname]);

      if($stmt->rowCount() == 1){
          $user = $stmt->fetch();

          $username =  $user['username'];
          $password =  $user['password'];
          $fname =  $user['fname'];
          $id =  $user['id'];
          $pp =  $user['pp'];


          if($username === $uname){
             if(password_verify($pass, $password)){
                 $_SESSION['id'] = $id;
                 $_SESSION['fname'] = $fname;
                 $_SESSION['pp'] = $pp;

                 header("Location: ../Provider_home.php");
                 exit;
             }else {
               $em = "Incorrect  password";
               header("Location: ../login.php?error=$em&$data");
               exit;
            }

          }else {
            $em = "Incorrect User name";
            header("Location: ../login.php?error=$em&$data");
            exit;
         }

      } else {
         // Check in recusers table if not found in prousers table
         $sql = "SELECT * FROM recusers WHERE username = ?";
         $stmt = $conn->prepare($sql);
         $stmt->execute([$uname]);

         if($stmt->rowCount() == 1){
             $user = $stmt->fetch();

             $username =  $user['username'];
             $password =  $user['password'];
             $fname =  $user['fname'];
             $user_id1 = $user['user_id'];
             $pp =  $user['pp'];

             if($username === $uname){
                if(password_verify($pass, $password)){
                    $_SESSION['user_id'] = $user_id1;
                    $_SESSION['fname'] = $fname;
                    $_SESSION['pp'] = $pp;

                    header("Location: ../Receiver_home.php");
                    exit;
                }else {
                  $em = "Incorrect password";
                  header("Location: ../login.php?error=$em&$data");
                  exit;
               }

             }else {
               $em = "Incorrect User name";
               header("Location: ../login.php?error=$em&$data");
               exit;
            }

         }else {
            $em = "Incorrect User name";
            header("Location: ../login.php?error=$em&$data");
            exit;
         }
      }
    }
}else {
	header("Location: ../login.php?error=error");
	exit;
}
?>