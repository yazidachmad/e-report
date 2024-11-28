<?php
session_start();

include "db.php";

if (isset($_SESSION['user'])) {
    header("Location: register.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $firstname = $_POST['fname'];
    $lastname = $_POST['lname'];
    $gender = $_POST['gender'];
    $num = $_POST['number'];
    $address = $_POST['add'];
    $email = $_POST['email'];
    $password = password_hash($_POST['pass'], PASSWORD_DEFAULT);

    if (!empty($email) && !empty($password) && !empty($firstname) && !empty($lastname) && !empty($gender) && !empty($num) && !empty($address)) {
        try {
            $stmt = $con->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "<script type='text/javascript'> alert('Email already exists')</script>";
                exit();
            } else {
                $stmt = $con->prepare("INSERT INTO users (fname, lname, gender, cnum, address, email, pass) VALUES (?,?,?,?,?,?,?)");
                $stmt->bind_param("sssssss", $firstname, $lastname, $gender, $num, $address, $email, $password);
                if ($stmt->execute()) {
                    $_SESSION['user'] = array(
                        'fname' => $firstname,
                        'lname' => $lastname,
                        'gender' => $gender,
                        'cnum' => $num,
                        'address' => $address,
                        'email' => $email,
                        'role' => 'basic',
                    );
                    header("Location: index.php");
                }
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "<script type='text/javascript'> alert('please Enter some Valid Infomation')</script>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pengaduan masyarakat</title>
    <link rel="stylesheet" href="style_user.css">
</head>
<body>
    <div class="signup">
        <h1>Sign Up</h1>
        <h4>It's free ang only takes a minute</h4>
        <form method="POST">
            <label>First Name</label>
            <input type="text" name="fname" required>
            <label>Last Name</label>
            <input type="text" name="lname" required>
            <label>Gender</label>
            <select name="gender">
                <option value="" disabled selected>---SELECT GENDER---</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
            <label>Contact Address</label>
            <input type="tel" name="number" required>
            <label>Address</label>
            <input type="text" name="add" required>
            <label>Email</label>
            <input type="email" name="email" required>
            <label>Password</label>
            <input type="password" name="pass" required>
            <input type="submit" name="" value="Submit">
        </form>
        <p>By clicking the Sign Up button, you agree to our<br>
        <a href="">Terms and Condition</a> and <a href="#">policy privacy</a>
        </p>
        <p>Already heve an account? <a href="login.php">Login Hare</a></p>
    </div>

</body>
</html>
