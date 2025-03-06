<?php
session_start();
include 'php/db_conn1.php'; 

if (!isset($_SESSION['user_id'])) {
    echo "Please log in to continue.";
    exit();
}
$user_id = $_SESSION['user_id'];
$notifications = "";

$update_check_time_sql = "UPDATE prousers SET last_notification_check = NOW() WHERE id = :user_id";
$update_check_time_stmt = $conn->prepare($update_check_time_sql);
$update_check_time_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$update_check_time_stmt->execute();

$report_check_sql = "
    SELECT * FROM reportarec 
    WHERE user_id = :user_id AND reportnor = 1
    ORDER BY created_at ASC
";
$report_check_stmt = $conn->prepare($report_check_sql);
$report_check_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$report_check_stmt->execute();

if ($report_check_stmt->rowCount() > 0) {
    while ($row = $report_check_stmt->fetch(PDO::FETCH_ASSOC)) {
        $notifications = 'Someone reported you on ' . $row['created_at'] . "<br>" . $notifications;
    }
} else {
    $notifications = 'No reports on your account.<br>' . $notifications;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .icon-wrapper i {
            font-size: 1.5rem;
            color: #000;
        }
        .notification-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 10px;
        }
        .notification-column {
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid black;
            border-radius: 20px;
            background-color: rgb(206, 197, 233);
        }
        .notification-column h3 {
            text-align: center;
            border-bottom: 1px solid black;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        .logo-middle {
            position: absolute;
            display: flex;
            top: 10px;
            left: 120px;
            z-index: 10;
        }
        .logo-middle-img {
           height: 100px;
           width: 120px;
            margin-top:-13px;
        }
        .title {
            position: absolute;
            display: flex;
            top: -5px;
            left: 45%;
            z-index: 10;
            color: black;
            font-weight: bold;
            font-size: 2rem;
            margin-top: 17px;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 50px;
            padding: 0 20px;
            box-shadow: 1px 1px 1px 1px lightgrey;
        }
    </style>
    <title>Notifications</title>
</head>
<body>

<header>
        <div class="icon-wrapper">
            <a href="Receiver_home.php"> 
            <i class="fa-regular fa-circle-left fa-2x"></i> 
            </a>
        </div> 
        <div class="ms-5 logo-middle">
            <a>
            <img src="new/redpethub.png" alt="Logo" class="logo-middle-img">
            </a>
            </div>
        <div class="title">
            <B>Notification</B>
        </div>
    </header>
    <br>
    <br>
    <div class="notification-container">
        <div class="notification-column">
            <h3>Report Warnings</h3>
            <?php echo $notifications; ?>
        </div>
    </div>
</body>
</html>
