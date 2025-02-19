<?php 

if(isset($_POST['fname']) && 
   isset($_POST['uname']) &&  
   isset($_POST['pass'])) {

    include "db_conn.php";

    $fname = $_POST['fname'];
    $uname = $_POST['uname'];
    $pass = $_POST['pass'];

    $data = "fname=".$fname."&uname=".$uname;

    $password_errors = [];

    if(strlen($pass) < 5){
        $password_errors[] = "Password must be at least 5 characters long.";
    }

    if(!preg_match('/[0-9]/', $pass)){
        $password_errors[] = "Password must contain at least one number (0-9).";
    }

    if(!preg_match('/[a-z]/', $pass)){
        $password_errors[] = "Password must contain at least one lowercase letter (a-z).";
    }

    if(!preg_match('/[A-Z]/', $pass)){
        $password_errors[] = "Password must contain at least one uppercase letter (A-Z).";
    }

    if(!preg_match('/[^A-Za-z0-9]/', $pass)){
        $password_errors[] = "Password must contain at least one special character (e.g., !, @) #, $, etc.).";
    }

    if (!empty($password_errors)) {
        $em = implode(" ", $password_errors);
        header("Location: ../proRegistration.php?error=$em&$data");
        exit;
    }

    if (empty($fname)) {
        $em = "Full name is required";
        header("Location: ../proRegistration.php?error=$em&$data");
        exit;
    } else if(empty($uname)){
        $em = "User name is required";
        header("Location: ../proRegistration.php?error=$em&$data");
        exit;
    } else if(empty($pass)){
        $em = "Password is required";
        header("Location: ../proRegistration.php?error=$em&$data");
        exit;
    } else {
        $pass = password_hash($pass, PASSWORD_DEFAULT);

        if (isset($_FILES['pp']['name']) && !empty($_FILES['pp']['name'])) {
            
            $img_name = $_FILES['pp']['name'];
            $tmp_name = $_FILES['pp']['tmp_name'];
            $error = $_FILES['pp']['error'];

            if($error === 0){
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_to_lc = strtolower($img_ex);

                $allowed_exs = array('jpg', 'jpeg', 'png');
                if(in_array($img_ex_to_lc, $allowed_exs)){
                    $new_img_name = uniqid($uname, true).'.'.$img_ex_to_lc;
                    $img_upload_path = '../upload/'.$new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);

                    $sql = "INSERT INTO prousers(fname, username, password, pp) 
                            VALUES(?,?,?,?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$fname, $uname, $pass, $new_img_name]);

                    header("Location: ../proRegistration.php?success=Your account has been created successfully");
                    exit;
                } else {
                    $em = "You can't upload files of this type";
                    header("Location: ../proRegistration.php?error=$em&$data");
                    exit;
                }
            } else {
                $em = "Unknown error occurred!";
                header("Location: ../proRegistration.php?error=$em&$data");
                exit;
            }
        } else {
            $sql = "INSERT INTO prousers(fname, username, password) 
                    VALUES(?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$fname, $uname, $pass]);

            header("Location: ../proRegistration.php?success=Your account has been created successfully");
            exit;
        }
    }
} else {
    header("Location: ../proRegistration.php?error=error");
    exit;
}
