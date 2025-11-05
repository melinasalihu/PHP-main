<?php
// register.php
session_start();
include('db_config.php'); // Lidhja me bazën e të dhënave

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Hash-imi i fjalëkalimit para ruajtjes
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Kontrollo nëse përdoruesi ekziston
    $check_user_sql = "SELECT id FROM users WHERE username = '$username' OR email = '$email'";
    $result = mysqli_query($conn, $check_user_sql);

    if (mysqli_num_rows($result) > 0) {
        $message = "<div class='error'>Përdoruesi ose Emaili ekziston.</div>";
    } else {
        // Futja e përdoruesit të ri në DB
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
        
        if (mysqli_query($conn, $sql)) {
            $message = "<div class='success'>Regjistrimi u krye me sukses! Tani mund të hyni.</div>";
        } else {
            $message = "<div class='error'>Gabim gjatë regjistrimit: " . mysqli_error($conn) . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Regjistrimi (Sign Up)</title>
    <link rel="stylesheet" href="style.css"> </head>
<body>
    <div class="container">
        <h1>Regjistrimi</h1>
        <?php echo $message; ?>
        
        <form method="POST" action="register.php">
            <input type="text" name="username" placeholder="Emri i Përdoruesit" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Fjalëkalimi" required>
            
            <button type="submit">Regjistrohu</button>
        </form>
        
        <p>Keni llogari? <a href="login.php">Hyni këtu</a></p>
        <p><a href="index.php">Kthehu në Blog</a></p>
    </div>
</body>
</html>