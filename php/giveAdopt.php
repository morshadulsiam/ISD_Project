<?php 

session_start();

if(isset($_POST['petcatagory']) && isset($_POST['petage']) && isset($_POST['des']) && isset($_POST['cinfo'])) {
    include "db_conn2.php";

    $petcatagory = $_POST['petcatagory'];
    $petage = $_POST['petage'];
    $des = $_POST['des'];
    $cinfo = $_POST['cinfo'];
    $id = $_SESSION['id']; // Assuming user_id is stored in session during login

    $data = "&petcatagory=".$petcatagory."&petage=".$petage."&des=".$des."&cinfo=".$cinfo;

    if (empty($petcatagory)) {
        $em = "Pet category is required";
        header("Location: giveadoption.php?error=$em&$data");
        exit;
    } else if (empty($petage)) {
        $em = "Age is required";
        header("Location: ../giveadoption.php?error=$em&$data");
        exit;
    } else if (empty($des)) {
        $em = "Description is required";
        header("Location: ../giveadoption.php?error=$em&$data");
        exit;
    } else if (empty($cinfo)) {
        $em = "Contact information is required";
        header("Location: ../giveadoption.php?error=$em&$data");
        exit;
    } else {
        if (isset($_POST['submit']) && isset($_FILES['up'])) {
            $img_name = $_FILES['up']['name'];
            $tmp_name = $_FILES['up']['tmp_name'];
            $error = $_FILES['up']['error'];

            if($error === 0) {
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_to_lc = strtolower($img_ex);
                $allowed_exs = array("jpg", "jpeg", "png");

                if(in_array($img_ex_to_lc, $allowed_exs)) {
                    $new_img_name = uniqid($petcatagory, true).'.'.$img_ex_to_lc;
                    $img_upload_path = '../upload/'.$new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);

                    $sql = "INSERT INTO giveadopt(petcatagory, petage, des, cinfo, up, id) VALUES(?, ?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$petcatagory, $petage, $des, $cinfo, $new_img_name, $id]);

                    header("Location: ../giveadoption.php?success=Congrats!! uploaded successfully");
                    exit;
                } else {
                    $em = "You can't upload files of this type";
                    header("Location: ../giveadoption.php?error=$em&$data");
                    exit;
                }
            } else {
                $em = "Unknown error occurred!";
                header("Location: ../giveadoption.php?error=$em&$data");
                exit;
            }
        } else {
            $sql = "INSERT INTO giveadopt(petcatagory, petage, des, cinfo,id) VALUES(?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$petcatagory, $petage, $des, $cinfo, $id]);

            header("Location: ../giveadoption.php?success=Congrats!! uploaded successfully");
            exit;
        }
    }
} else {
    header("Location: ../giveadoption.php?error=error");
    exit;
}
