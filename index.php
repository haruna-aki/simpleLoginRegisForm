<?php
session_start();

$errors = [
    'signin' => $_SESSION['signin_error'] ?? '',
    'signup' => $_SESSION['signup_error'] ?? '',
    'forget-pass' => $_SESSION['forget-pass_error'] ?? ''
];

$activeForm = $_SESSION['active_form'] ?? 'signin';

session_unset();

function showError($error) {
    return !empty($error) ? "<p class='error-message'>$error</p>" : '';
}

function isActiveForm($formName, $activeForm) {
    return $formName === $activeForm ? 'active' : '';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<!-- <?php
// if(isset($_POST['signin'])){
//     echo $_POST['email'];
// }   

// require 'login_register.php';
?> -->

<body>
    <div class="container">
        <div class="form-box <?= isActiveForm('signin', $activeForm); ?>" id="login-form">
            <form action="" method="POST">
                <p id="headingl">Login</p>
                <?= showError($errors['signin']); ?>
                <div>
                    <label class="form-label" for="email">Email:</label><br>
                    <input class="form-input" type="email" id="email" name="email" placeholder="Enter your email"
                        required />
                </div>
                <div>
                    <label class="form-label" for="password">Password:</label><br>
                    <input class="form-input" type="password" id="password" name="password"
                        placeholder="Enter your password" required />
                </div>

                <div id="btns">
                    <button class="sbmt-btn" type="submit" name="signin">Sign In</button>
                    <!--alternative button if js-->
                    <button class="sbmt-btn" type="button" name="signup" onclick="showForm('register-form')">Sign
                        Up</button>
                </div>

                <div class="frgt-pas">
                    <a href="#" onclick="showForm('frgt-form')">Forgot password?</a>
                </div>
            </form>
        </div>

        <div class="form-box <?= isActiveForm('signup', $activeForm); ?>" id="register-form">
            <form action="login_register.php" method="post">
                <p id="headingr">Register</p>
                <?= showError($errors['signup']); ?>
                <div>
                    <label class="form-label" for="username">Username:</label><br>
                    <input class="form-input" type="text" id="username" name="username" placeholder="Enter username"
                        required />
                </div>
                <div>
                    <label class="form-label" for="email">Email:</label><br>
                    <input class="form-input" type="email" id="email" name="email" placeholder="Enter your email"
                        required />
                </div>
                <div>
                    <label class="form-label" for="password">Password:</label><br>
                    <input class="form-input" type="password" id="password" name="password"
                        placeholder="Enter your password" required />
                </div>

                <div class="lwrprt">
                    <select name="role" id="selrol" required>
                        <option value="">Select Role</option>
                        <option value="role1">Role1</option>
                        <option value="role2">Role2</option>
                    </select>

                    <button class="sbmt-btn" type="submit" name="signup">Sign Up</button>
                </div>

                <div class="alr-sgned">
                    <label class="form-label" for="alrhvanacc">Already have an account? <a href="#"
                            onclick="showForm('login-form')">Login</a></label>
                </div>
            </form>
        </div>

        <div class="form-box" id="frgt-form">
            <form action="login_register.php" method="post">
                <p id="headingf">Forgot Password</p>
                <?= showError($errors['forget-pass']); ?>
                <div>
                    <label class="form-label" for="email">Email:</label><br>
                    <input class="form-input" type="email" id="email" name="email" placeholder="Enter your email"
                        required />
                </div>
                <div>
                    <label class="form-label" for="new-password">New Password:</label><br>
                    <input class="form-input" type="password" id="new-password" name="new-password"
                        placeholder="Enter your new password" required />
                </div>
                <div>
                    <label class="form-label" for="confirm-password">Confirm Password:</label><br>
                    <input class="form-input" type="password" id="confirm-password" name="confirm-password"
                        placeholder="Confirm password" required />
                </div>
                <div id="btns">
                    <button class="sbmt-btn" type="button" name="cancel"
                        onclick="showForm('login-form')">Cancel</button>
                    <!--alternative button if js-->
                    <button class="sbmt-btn" type="submit" name="continue">Continue</button>
                </div>
            </form>
        </div>
    </div>
    <script src="script.js"></script>
</body>

</html>