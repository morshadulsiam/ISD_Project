<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Pethub</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="Login.css">
</head>
<body>
    <div class="wrapper">
        <div class="login_box">
            <div class="login-header">
                <span>LOGIN</span>
            </div>
            <form class="shadow w-450 p-3" action="php/login.php" method="post">
                <?php if (isset($_GET['error'])) { ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="fa-solid fa-exclamation-circle"></i>
                        <?php echo $_GET['error']; ?>
                    </div>
                <?php } ?>

                <div class="input_box">
                    <input
                        type="text"
                        id="uname"
                        class="input-field"
                        name="uname"
                        value="<?php echo (isset($_GET['uname'])) ? $_GET['uname'] : ""; ?>"
                        required
                    >
                    <label for="uname" class="label">User name</label>
                    <i class="bx bxs-user icon"></i>
                </div>

                <div class="pass_field">
                    <input
                        type="password"
                        id="pass"
                        class="input-field"
                        name="pass"
                        required
                    >
                    <label for="pass" class="label">Password</label>
                    <i class="fa-solid fa-eye"></i>
                </div>

                <div class="input_box">
                    <input
                        type="submit"
                        class="input-submit"
                        value="Login"
                    >
                </div>

                <div class="register">
                    <span>Don't have an account? <a href="Welcome.php">Sign Up</a></span>
                </div>
            </form>
        </div>
    </div>

    <script>
        const passwordInput = document.querySelector(".pass_field input");
        const eyeIcon = document.querySelector(".pass_field i");

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
