<?php
include_once('config.php');

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Kontrollimi i fushave
    if (empty($name) || empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        echo "You have not filled in all the fields.";
    } elseif ($password !== $confirm_password) {
        echo "Passwords do not match.";
    } else {
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users(name, username, email, password) 
                VALUES (:name, :username, :email, :password)";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashPassword);

        if ($stmt->execute()) {
            echo "User registered successfully! <a href='login.php'>Login here</a>";
        } else {
            echo "Registration failed!";
        }
    }
}
?>

<!-- login.php -->
<form action="loginLogic.php" method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="submit">Login</button>
</form>



