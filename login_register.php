<?php
session_start();
require 'Database.php';
require_once 'config.php';

// $config = require('config.php');


// $db = new Database($config['database']);
// $posts = $db->query("SELECT * FROM `users`")->fetchAll();

// foreach($posts as $post) {
//     echo "<li>" . $post['name'] . "</li>";
// }

// $email = "test_email@email.com";
// $error = '';

// $checkEmail = $db->query("SELECT email FROM users WHERE email = '$email'");

if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];

    $checkEmail = $conn->query("SELECT * FROM `users` WHERE `email` = '$email'");
    if ($checkEmail->num_rows > 0) {
        $_SESSION['register_error'] = 'Email is already registered';
        $_SESSION['active_form'] = 'register';
    } else {
        $conn->query("INSERT INTO `users` (`username`, `email`, `password`, `role`) VALUES ('$username', '$email', '$password', '$role')");

    }

    header("Location: index.php");
    exit();
} //checks if there's an existing email registered

if (isset($_POST['signin'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE email = '$email'");
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];

            if ($user['role'] === 'role1') {
                header("Location: role1_page.php");
            } else {
                header("Location: role2_page.php");
            }
            exit();
        }
    }

    $_SESSION['login_error'] = 'Incorrect email or password';
    $_SESSION['active_form'] = 'login';
    header("Location: index.php");
    exit();
} //login validation

// if (isset($_POST['continue'])) {
//     $email = $_POST['email'];
//     $new_password = $_POST['new-password'];
//     $confirm_password = $_POST['confirm-password'];

//     $checkNewPass = $conn->query("SELECT * FROM users WHERE email = '$email'");

//     if (isset($checkNewPass)) {
//         //    $new_hash_password = password_hash($confirm_password);
//         if ($new_password !== $confirm_password) {
//             echo 'Password do not match!';
//         }

//         $new_hash_pass = password_hash($new_password, PASSWORD_BCRYPT);

//         // $conn->query(" UPDATE users SET `password`='$new_hash_pass' WHERE email = '$email'");

//         $stmt = $conn->prepare("UPDATE users SET `password` = ? WHERE `email` = ?");
//         $stmt->bind_param("ss", $new_hash_pass, $email);
//         $stmt->execute();
//         echo 'Success';
//     }

//     if (isset($checkNewPass)) {

//     }
// }

if (isset($_POST['continue'])) {
    $email = $_POST['email'];
    $new_password = $_POST['new-password'];
    $confirm_password = $_POST['confirm-password'];

    // Get user's current password hash
    $stmt = $conn->prepare("SELECT `password` FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "Email not found";
        exit;
    }

    $row = $result->fetch_assoc();
    $current_hash = $row['password'];

    // Check password match
    if ($new_password !== $confirm_password) {
        echo "Passwords do not match";
        exit;
    }

    // Check if new password is same as old password
    if (password_verify($new_password, $current_hash)) {
        echo "New password cannot be the same as the old password";
        exit;
    }

    // Hash and update
    $new_hash_pass = password_hash($new_password, PASSWORD_BCRYPT);

    $updateStmt = $conn->prepare("UPDATE users SET `password` = ? WHERE `email` = ?");
    $updateStmt->bind_param("ss", $new_hash_pass, $email);

    if ($updateStmt->execute()) {
        echo "Password updated successfully";
    } else {
        echo "Error updating password";
    }
}

