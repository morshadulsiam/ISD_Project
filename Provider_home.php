<?php
session_start();

include 'php/db_conn1.php';
include 'php/proUser.php';
$user = getUserById($_SESSION['id'], $conn);

if (!isset($_SESSION['id'])) {
    echo "Please log in to continue.";
    exit();
}

$id = $_SESSION['id'];
$last_check_sql = "SELECT last_notification_check FROM recusers WHERE user_id = :id";
$last_check_stmt = $conn->prepare($last_check_sql);
$last_check_stmt->bindParam(':id', $id, PDO::PARAM_INT);
$last_check_stmt->execute();
$last_check_time = $last_check_stmt->fetchColumn();
$new_notifications_sql = "

 SELECT COUNT(*) 
FROM (
    SELECT created_at FROM cart WHERE created_at > :last_check_time AND product_id IN (SELECT product_id FROM productsell WHERE id = :id)
    UNION ALL
    SELECT created_at FROM petcart WHERE created_at > :last_check_time AND pet_id IN (SELECT pet_id FROM giveAdopt WHERE id = :id)
    UNION ALL
    SELECT created_at FROM reportapro WHERE created_at > :last_check_time AND id = :id AND reportnop = 1
) AS notifications"; 

$new_notifications_stmt = $conn->prepare($new_notifications_sql);
$new_notifications_stmt->bindParam(':last_check_time', $last_check_time);
$new_notifications_stmt->bindParam(':id', $id, PDO::PARAM_INT);
$new_notifications_stmt->execute();
$new_notifications_count = $new_notifications_stmt->fetchColumn();
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Provider Home | Pethub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="Bootstrap.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
  <header class= "header">
    <nav class="navbar navbar-expand-lg navigation-wrap mb-5">
      <div class="container">
        <div class="icon-wrapper margin-auto-right">
          <i class="fa-solid fa-bars" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample"></i>
            <span class="menu-text">Menu</span>
        </div>
        <div class="collapse navbar-collapse" id="navbarText">
          <ul class="navbar-nav ms-5 mb-2 mb-lg-0">
              <li class="ms-5 logo-middle">
                        <a href="#home">
                            <img src="new/redpethub.png" alt="Logo" class="logo-middle-img">
                        </a>
             </li>
            <li class="icons ms-5 position-relative">
              <a href="RecProSearch.php" class="icon-wrapper">
                <i class="fas fa-search"></i> 
                <span class="icon-text">Search</span> 
              </a>
            </li>
            <li class="icons ms-5 position-relative">
              <a href="#home" class="icon-wrapper"> 
                <i class="fa-solid fa-house-chimney"> </i> 
                <span class="icon-text">Home</span> 
              </a>
            </li>
            <li class="icons ms-5 position-relative notification-icon">
              <a href="pronotification.php" class="icon-wrapper">
                <i class="fa-solid fa-bell"> </i> 
                <span class="icon-text">Notifications</span>
                <?php if ($new_notifications_count > 0): ?>
                  <span class="notification-count"><?php echo $new_notifications_count; ?></span>
                    <?php endif; ?>
              </a>
            </li>
          </ul>
 
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item ms-3">
              <a class="nav-link" href="#About">About</a>
            </li>
            <li class="nav-item ms-3">
              <a class="nav-link" href="giveadoption.php">Give adoption</a>
            </li>
            <li class="nav-item ms-3">
              <a class="nav-link" href="sellproduct.php">Sell product</a>
            </li>

            <img src="upload/<?= htmlspecialchars($user['pp']) ?>" class="user-pic" onclick="toggleMenu()">
            <div class="sub-menu-wrap" id="subMenu">
                <div class="sub-menu">
                  <div class="user-info">
                    <img src="upload/<?= htmlspecialchars($user['pp']) ?>">
                    <h3><?= htmlspecialchars($user['fname']) ?></h3>
                  </div>
                </div>
            </div>
          </ul>  
        </div>
        </div>
    </nav>
  </header>
  
  <!-- Offcanvas Sidebar -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" href="proProfile.php"><i class="fa-solid fa-user me-2"></i>Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php"><i class="fa-solid fa-right-from-bracket me-2"></i>Sign out</a>
          </li>
        </ul>
      </div>
    </div>
<!--home design-->
    <section id="home">
      <div id="carouselExampleControls" class="carousel slide " data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="slide/c.jpg" class="d-block l-10 w-100" alt="pic1">
          </div>
          <div class="carousel-item">
            <img src="slide/d.jpg" class="d-block w-100" alt="pic2">
          </div>
          <div class="carousel-item">
            <img src="slide/b.jpg" class="d-block w-100" alt="pic3">
          </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </section>
<!--about design-->
    <section id="About">
      <div class="text-area ms-5">
            <div class="text">
                <div class="text mb-3 mt-5"><h3>About PetHub</h3></div>
                <p>
                Welcome to PetHub, your ultimate destination for everything related to pets. At PetHub, we believe in creating a world where pets and humans live in harmony, fostering relationships filled with joy, compassion, and mutual understanding.
               </p>
               <div class="text"><h5>Our Mission</h5></div>
               <p>
                Our mission is to connect pet lovers with the resources, services, and communities they need to ensure their pets live happy and healthy lives. Whether you are looking to adopt a new furry friend, seeking expert advice on pet care, or wanting to shop for the best pet products, PetHub is here to support you every step of the way.
            </p>
            <div class="text"><h5>Why PetHub?</h5></div>
                      <p>
                        <li>Comprehensive Pet Care: We offer a wide range of services including adoption assistance, veterinary care, grooming, and training to ensure your pet receives the best care possible.</li>
                        <li>Quality Products: Our store features top-quality products for all types of pets, ensuring they have everything they need to thrive.</li>
                        <li>Expert Advice: Our team of pet care experts is always available to provide advice and support on any pet-related queries you might have.</li>
                      </p>
                  <div class="text"><h5>The Human-Pet Connection</h5></div>
                      <p>
                        At PetHub, we understand the deep bond between humans and their pets. This connection is beautifully encapsulated in several quotes that inspire us daily:

                          <li>"Until one has loved an animal, a part of one's soul remains unawakened." — Anatole France</li>
                          <li>"The greatness of a nation and its moral progress can be judged by the way its animals are treated." — Mahatma Gandhi</li>
                          <li>"Animals are such agreeable friends—they ask no questions; they pass no criticisms." — George Eliot</li>
                          <li>"Pets understand humans better than humans do." — Ruchi Prabhu</li>
                          <li>"A dog is the only thing on earth that loves you more than he loves himself." — Josh Billings</li>
                          <br>
                        These quotes reflect the profound impact pets have on our lives. They bring joy, offer unconditional love, and teach us valuable lessons about compassion and empathy. At PetHub, we celebrate this special bond and strive to enhance it through our services and community engagement.
                      </p>
                  <div class="text"><h5>Join Our Community</h5></div>
                    <P>
                      Become a part of the PetHub community and join us in celebrating the love and joy that pets bring into our lives. Follow us on social media, participate in our events, and share your pet stories with us. Together, we can make the world a better place for pets and their human companions.
                      </p>
                      <br>
                      <p>
                      Welcome to PetHub, where pets and humans come together in perfect harmony.
                    </p>
                </p>   
            </div>
        </div>
    </section>

<!--bottom line--> 

<footer class="footer">
  	 <div class="containerf">
  	 	<div class="row">
  	 		<div class="footer-col">
  	 			<h4>CATEGORIES</h4>
  	 			<ul>
            <li><a href="giveadoption.php">Give pet for adoption</a></li>
            <li><a href="adoptdetails.php">Adoption Posts</a></li>
  	 				<li><a href="sellproduct.php">Sell Products</a></li>
             <li><a href="selldetails.php">Sell Posts</a></li>
  	 			</ul>
  	 		</div>
  	 		<div class="footer-col">
  	 			<h4>QUICK LINKS</h4>
  	 			<ul>
  	 				<li><a href="#home">HOME</a></li>
             <li><a href="#About">About us</a></li>
             <li><a href="proProfile.php">Profile</a></li>
  	 				<li><a href="logout.php">Sign Out </a></li>
  	 			</ul>
  	 		</div>
  	 		<div class="footer-col">
  	 			<h4>CONTACT</h4>
  	 			<ul>
  	 				<li><a href="#">pethub@gmail.com</a></li>
  	 			</ul>
  	 		</div>
  	 		<div class="footer-col">
  	 			<h4>FOLLOW US</h4>
  	 			<div class="social-links">
  	 				<a href="#"><i class="fab fa-facebook-f"></i></a>
  	 				<a href="#"><i class="fab fa-twitter"></i></a>
  	 				<a href="#"><i class="fab fa-instagram"></i></a>
  	 				<a href="#"><i class="fab fa-linkedin-in"></i></a>
  	 			</div>
  	 		</div>
  	 	</div>
  	 </div>
     <div class="bottom-bar">
          <p>&copy; 2024 PetHub | All Rights Reserved</p>
      </div>
  </footer>

<script>
  let subMenu = document.getElementById("subMenu");
  function toggleMenu() {
    subMenu.classList.toggle("open-menu");
  }
</script>

  </body>
</html>
