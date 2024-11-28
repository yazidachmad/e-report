<?php
session_start();

include "db.php";

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    if ($user['role'] === 'admin') {
        header("Location: admin.php");
        exit();
    } else {
        header("Location: index.php");
        exit();
    }
}

$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['pass'];

    if (!empty($email) && !empty($password) && !is_numeric($email)) {
        try {
            $stmt = $con->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                if (password_verify($password, $user['pass'])) {
                    $_SESSION['user'] = array(
                        'fname' => $user['fname'],
                        'lname' => $user['lname'],
                        'gender' => $user['gender'],
                        'cnum' => $user['cnum'],
                        'address' => $user['address'],
                        'email' => $user['email'],
                        'role' => $user['role'],
                    );

                    if ($user['role'] === 'admin') {
                        header("Location: admin.php");
                        exit();
                    } else {
                        header("Location: index.php");
                        exit();
                    }
                } else {
                    $errorMessage = "Invalid Password";
                }
            } else {
                $errorMessage = "Email hasn't been registered";

            }

        } catch (Exception $e) {
            die("An error has occured: " . $e->getMessage());
        }
    } else {
        echo "<script type='text/javascript'> alert('Please Input valid information')</script>";
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
    <div class="login">
        <h1>Login</h1>
        <?php
if (!empty($errorMessage)) {
    echo "<p class='error' style='color: red;'>$errorMessage</p>";
}
?>
        <form method="POST">
            <label>Email</label>
            <input type="email" name="email" required>
            <label>Password</label>
            <input type="password" name="pass" required>
            <input type="submit" name="" value="Submit">
        </form>
        <p>Don't have an account? <a href="signup.php">Register Hare</a></p>
    </div>

</body>
</html>
