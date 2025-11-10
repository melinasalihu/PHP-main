<<<<<<< HEAD



<?php
// login.php
session_start();
include('db_config.php'); // Sigurohuni që keni këtë skedar

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // MERRET FJALËKALIMI I HASH-UAR DHE ROLI
    $sql = "SELECT id, username, password, role FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        
        // Verifikimi i fjalëkalimit
        if (password_verify($password, $user['password'])) {
            // Hyrja (Log In) u krye me sukses!
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role']; // RUAJMË ROLIN
            
            header("Location: index.php"); 
            exit();
        } else {
            $message = "<div class='error'>Fjalëkalimi është i pasaktë.</div>";
        }
    } else {
        $message = "<div class='error'>Emri i përdoruesit nuk u gjet.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Hyrja në Blog</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Stilizim specifik për Login Card - Shfrytëzon variablat e 'style.css' */
        .login-card {
            max-width: 400px;
            margin: 80px auto; /* Vendose më në mes vertikalisht */
            background: var(--background-card);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(255, 105, 180, 0.2); /* Hije më e theksuar rozë */
            text-align: center;
        }
        .login-card h1 {
            color: var(--primary-color);
            margin-top: 0;
            margin-bottom: 25px;
            border-bottom: 2px solid var(--border-color);
            padding-bottom: 10px;
        }
        .login-card form {
            padding: 0;
            border: none; /* Heq kufirin e formularit brenda kartës */
            background: none;
            box-shadow: none;
        }
        /* Butonat Log In dhe Regjistrohu do të marrin stilin nga style.css */
    </style>
</head>
<body>
    
    <div class="login-card">
        <h1>Hyrja në Llogari</h1>
        <?php echo $message; ?>
        
        <form method="POST" action="login.php">
            <input type="text" name="username" placeholder="Emri i Përdoruesit" required>
            <input type="password" name="password" placeholder="Fjalëkalimi" required>
            
            <button type="submit">Hyr</button>
        </form>
        
        <p style="margin-top: 20px; color: var(--secondary-color);">
            Nuk keni llogari? <a href="register.php">Regjistrohuni këtu</a>
        </p>
        <p><a href="index.php" style="font-size: 14px;">← Kthehu në Blog</a></p>
    </div>
    
</body>
=======



<?php
// login.php
session_start();
include('db_config.php'); // Sigurohuni që keni këtë skedar

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // MERRET FJALËKALIMI I HASH-UAR DHE ROLI
    $sql = "SELECT id, username, password, role FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        
        // Verifikimi i fjalëkalimit
        if (password_verify($password, $user['password'])) {
            // Hyrja (Log In) u krye me sukses!
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role']; // RUAJMË ROLIN
            
            header("Location: index.php"); 
            exit();
        } else {
            $message = "<div class='error'>Fjalëkalimi është i pasaktë.</div>";
        }
    } else {
        $message = "<div class='error'>Emri i përdoruesit nuk u gjet.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Hyrja në Blog</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Stilizim specifik për Login Card - Shfrytëzon variablat e 'style.css' */
        .login-card {
            max-width: 400px;
            margin: 80px auto; /* Vendose më në mes vertikalisht */
            background: var(--background-card);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(255, 105, 180, 0.2); /* Hije më e theksuar rozë */
            text-align: center;
        }
        .login-card h1 {
            color: var(--primary-color);
            margin-top: 0;
            margin-bottom: 25px;
            border-bottom: 2px solid var(--border-color);
            padding-bottom: 10px;
        }
        .login-card form {
            padding: 0;
            border: none; /* Heq kufirin e formularit brenda kartës */
            background: none;
            box-shadow: none;
        }
        /* Butonat Log In dhe Regjistrohu do të marrin stilin nga style.css */
    </style>
</head>
<body>
    
    <div class="login-card">
        <h1>Hyrja në Llogari</h1>
        <?php echo $message; ?>
        
        <form method="POST" action="login.php">
            <input type="text" name="username" placeholder="Emri i Përdoruesit" required>
            <input type="password" name="password" placeholder="Fjalëkalimi" required>
            
            <button type="submit">Hyr</button>
        </form>
        
        <p style="margin-top: 20px; color: var(--secondary-color);">
            Nuk keni llogari? <a href="register.php">Regjistrohuni këtu</a>
        </p>
        <p><a href="index.php" style="font-size: 14px;">← Kthehu në Blog</a></p>
    </div>
    
</body>
>>>>>>> e64f7dbfcfab5e039ad57c666537456aa99c4a7d
</html>