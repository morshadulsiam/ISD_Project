<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sign Up | Pethub</title>
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="registration.css">
</head>
<body>
    <div class="container">
      <div class="wrapper">
	     <div class="regis_box">
		 <div class="icon-wrapper">
            <a href="Welcome2.php"> 
                <i class="fa-regular fa-circle-left fa-2x"></i> 
            </a>
        </div>
		       <div class="regis-header">
			      <span>Registration</span>
                </div>
    	      <form class="shadow w-450 p-3" 
    	           action="php/recsignup.php" 
    	           method="post"
    	           enctype="multipart/form-data">

    		        <?php if(isset($_GET['error'])){ ?>
    		        <div class="alert alert-danger" role="alert">
					    <i class="fa-solid fa-exclamation-circle"></i>
			            <?php echo $_GET['error']; ?>
			        </div>
		            <?php } ?>

		            <?php if(isset($_GET['success'])){ ?>
    		          <div class="alert alert-success" role="alert">
				           <i class="fa-solid fa-check-circle"></i>
			               <?php echo $_GET['success']; ?>
			            </div>
		            <?php } ?>

		            <div class="input_box">
				         <input type="text" id="fname"
					     class="input-field"
					     name="fname"
		                 value="<?php echo (isset($_GET['fname']))?$_GET['fname']:"" ?>"required>
		                <label for="fname" class="label">Full Name</label>
					    <i class="bx bxs-user icon"></i>
		            </div>

		            <div class="input_box">
				          <input type="text" id="uname"
		                  class="input-field"
		                  name="uname"
		                  value="<?php echo (isset($_GET['uname']))?$_GET['uname']:"" ?>"required>
		                  <label for="uname" class="label">User name</label>
					      <i class="bx bxs-user icon"></i>
		            </div>

			        <div class="pass_field">
		                   <input type="password"  id="pass"
		                   class="input-field"
		                   name="pass" required>
						   <label for="pass" class="label">Password</label>
						   <i class="fa-solid fa-eye"></i>
		            </div>
				    <div class="content">
					    <p>Password must contains</p>
					   <u1 class="requirement-list">
						   <li>
							  <i class="fa-solid fa-circle"></i>
							   <span>At least 5 characters length</span>
				            </li>
						    <li>
							   <i class="fa-solid fa-circle"></i>
							    <span>At least 1 number(0.....9)</span>
				            </li>
						    <li>
							   <i class="fa-solid fa-circle"></i>
							   <span>At least 1 lowercase letter(a....z)</span>
				            </li>
						    <li>
							    <i class="fa-solid fa-circle"></i>
							    <span>At least 1 special symbol(!.....$)</span>
				            </li>
						    <li>
							    <i class="fa-solid fa-circle"></i>
							    <span>At least 1 uppercase letter(A....Z)</span>
				            </li>
				        </ui>
				    </div>

		            <div class="input_box">
				          <input type="file" id="pp"
		                  class="input-field1"
		                  name="pp"required>
						  <label for="pp" class="label1">Profile Picture</label>
						 <i class="bx bxs-image-add icon"></i>
		            </div>

				    <div class="input_box">
						   <input type="submit" class="input-submit" 
						   value="Sign Up">
				    </div>

				    <div class="register">
		                <a href="login.php">Login</a>
				    </div>
		        </form>
	       </div>
		   <div class="regis-text">
                 <p>Sign Up as Receiver</p>
            </div>
		</div>
    </div>

<script>
    const passwordInput = document.querySelector(".pass_field input");
    const eyeIcon = document.querySelector(".pass_field i");
    const requirementList = document.querySelectorAll(".requirement-list li"); 
    const requirements = [
        {regex: /.{5,}/, index: 0},         
        {regex: /[0-9]/, index: 1},         
        {regex: /[a-z]/, index: 2},         
        {regex: /[^A-Za-z0-9]/, index: 3},  
        {regex: /[A-Z]/, index: 4}          
    ];

    passwordInput.addEventListener("keyup", (e) => {
        requirements.forEach(item => {  
            const isValid = item.regex.test(e.target.value);
            const requirementItem = requirementList[item.index];
            if (isValid) {
                requirementItem.firstElementChild.className = "fa-solid fa-check";
				requirementItem.classList.add("valid");  
            } else {
                requirementItem.firstElementChild.className = "fa-solid fa-circle"; 
				requirementItem.classList.remove("valid"); 
            }
        });
    });

    eyeIcon.addEventListener("click", () => {
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeIcon.className = "fa-solid fa-eye-slash"; 
        } else {
            passwordInput.type = "password";
            eyeIcon.className = "fa-solid fa-eye"; 
        }
    });
</script>
</body>
</html>