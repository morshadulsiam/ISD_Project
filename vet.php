<?php
include "php/db_conn1.php";

$selectedDivision = '';
$hospitals = [];
$petShops = [];

if (isset($_POST['division'])) {
    $selectedDivision = $_POST['division'];

    $stmtHospitals = $conn->prepare("SELECT hosp_name, location FROM vet_hospitals WHERE division = ?");
    $stmtHospitals->execute([$selectedDivision]);
    $hospitals = $stmtHospitals->fetchAll(PDO::FETCH_ASSOC);
    $stmtShops = $conn->prepare("SELECT shop_name, location FROM pet_shops WHERE division = ?");
    $stmtShops->execute([$selectedDivision]);
    $petShops = $stmtShops->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
   
    <style>
         header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    height: 50px;
    padding: 0 20px;
    box-shadow: 1px 1px 1px 1px lightgrey;
 }
        main{
            max-width: 1500px;
            width: 100%;
            margin: 30px auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin: auto;
            background: #eceaffad;
            margin-top:40px;
        }
        form {
    margin-bottom: 40px; /* Adjust the value as needed for the gap */
}
        .icon-wrapper {
            margin-top: 10px;
            margin-left: 10px; 
        }
        .icon-wrapper i {
           font-size: 1.5rem; 
           color: #000;
        }
        .location-container {
            display: flex;
            width: 100%;
            gap: 200px;
            margin-left: 100px;
            margin-top:100;
        }
        .location-column {
            width: 36%;
            padding: 15px;
            box-sizing: border-box;
            border: 1px solid black;
            border-radius: 20px;
            background-color: 	#add8e6;
        }
        .location-column.first-column {
            margin-left: 20px;
        }
        .location-column h3 {
            text-align: center;
            border-bottom: 1px solid black;
            padding-bottom: 10px;
            margin-bottom: 10px;
            font-size: 2rem;
            font-weight: bold;
        }
        .centered-content {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            position: absolute;
            left: 48%;
            transform: translateX(-50%);

        }
        .logo-middle {
           position: absolute;
           display: flex;
           top: 10px;
           right: 20px;
           z-index: 10;
        }
      .logo-middle-img {
        height: 100px;
        width: 120px;
        margin-right: 1450px;
        margin-top: -13px;
     }
     .location-column ul li {
    font-size: 1.2rem; 
}
.location-column ul li a {
            font-size: 1.2rem; 
            color: #007bff;
            text-decoration: none; 
        }
select {
    font-size: 2rem;
}
.no-results-message {
    font-size: 2rem;
    text-align: center; 
    color: #333;
    font-weight: normal; 
}
    </style>
    <title>Hospitals and Shops</title>
</head>
<body>
<?php include_once 'searchheader.php'; ?>
<main>
    <div class="centered-content mb-5">
        <div class="mb-5 ms-5">
            <form method="POST" action="vet.php">
                <label><h3>Choose your division</h3></label>
                <select name="division" id="division" required onchange="this.form.submit()">
                    <option value="" disabled selected><h3>Divisions</h3></option>
                    <option value="Dhaka" <?= $selectedDivision == 'Dhaka' ? 'selected' : '' ?>>Dhaka</option>
                    <option value="Chittagong" <?= $selectedDivision == 'Chittagong' ? 'selected' : '' ?>>Chittagong</option>
                    <option value="Rajshahi" <?= $selectedDivision == 'Rajshahi' ? 'selected' : '' ?>>Rajshahi</option>
                    <option value="Rangpur" <?= $selectedDivision == 'Rangpur' ? 'selected' : '' ?>>Rangpur</option>
                    <option value="Barishal" <?= $selectedDivision == 'Barishal' ? 'selected' : '' ?>>Barishal</option>
                    <option value="Sylhet" <?= $selectedDivision == 'Sylhet' ? 'selected' : '' ?>>Sylhet</option>
                    <option value="Khulna" <?= $selectedDivision == 'Khulna' ? 'selected' : '' ?>>Khulna</option>
                    <option value="Mymensingh" <?= $selectedDivision == 'Mymensingh' ? 'selected' : '' ?>>Mymensingh</option>
                </select>
            </form>
        </div>
    </div>

    <div class="location-container ms-5 p-5">
        <div class="location-column first-column  p-5">
            <h3>Veterinary Hospitals</h3>
            <?php if (!empty($hospitals)) { ?>
                <ul>
                    <?php foreach ($hospitals as $hospital) { ?>
                        <li>
                            <strong><?= $hospital['hosp_name'] ?></strong>&nbsp;&nbsp;
                            <a href="<?= $hospital['location'] ?>" target="_blank">View on Map</a>
                        </li>
                    <?php } ?>
                </ul>
            <?php } else { ?>
                <p class="no-results-message">Please select division to find veterinarian hospitals.</p>
            <?php } ?>
        </div>
        <div class="location-column ms-5 p-5">
            <h3>Pet Shops</h3>
            <?php if (!empty($petShops)) { ?>
                <ul>
                    <?php foreach ($petShops as $shop) { ?>
                        <li>
                            <strong><?= $shop['shop_name'] ?></strong>&nbsp;&nbsp;
                            <a href="<?= $shop['location'] ?>" target="_blank">View on Map</a>
                        </li>
                    <?php } ?>
                </ul>
            <?php } else { ?>
                <p class="no-results-message">Please select division to find pet shops.</p>
            <?php } ?>
        </div>
    </div>
</main>
</body>
</html>