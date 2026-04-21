<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    
    // Password check
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!'); window.history.back();</script>";
        exit();
    }
    
    // Check if email exists
    $check_email = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $check_email);
    
    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Email already exists!'); window.history.back();</script>";
        exit();
    }
    
    // Hash password
    $hashed_password = md5($password);
    
    // Insert user
    $insert = "INSERT INTO users (username, email, password) 
               VALUES ('$username', '$email', '$hashed_password')";
    
    if (mysqli_query($conn, $insert)) {
        echo "<script>alert('Account created successfully! Please login.'); window.location.href='login.html';</script>";
    } else {
        echo "<script>alert('Error creating account!'); window.history.back();</script>";
    }
}
?>