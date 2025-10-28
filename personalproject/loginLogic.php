<?php
include_once('config.php');

if (isset($_POST['submit'])) {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        die("Please enter username and password.");
    }

    // Marr përdoruesin nga username
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Kontrollo fjalëkalimin e hash-uar
        if (password_verify($password, $user['password'])) {
            echo "Login successful! Welcome " . $user['username'];
            // Mund të fillosh session këtu:
            // session_start();
            // $_SESSION['username'] = $user['username'];
        } else {
            echo "Wrong password!";
        }
    } else {
        echo "The user does not exist";
    }
} else {
    echo "Form not submitted correctly.";
}
?>



