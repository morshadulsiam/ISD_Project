<?php 

function getUserById($id, $db){
    $sql = "SELECT * FROM giveadopt WHERE id = ?";
	$stmt = $db->prepare($sql);
	$stmt->execute([$id]);
    
   
        $user = $stmt->fetch();
        return $user;
    
}

 ?>