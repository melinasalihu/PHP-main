<?php
// index.php
session_start();
// Sigurohuni që db_config.php është në të njëjtin vend dhe ka të dhënat e sakta të lidhjes.
include('db_config.php'); 

$message = "";
// Kontrollon nëse përdoruesi është i kyçur dhe ka rolin 'admin'
$is_admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
$edit_post = null; 

// ------------------------------------
// LOG OUT (Ç'kyçja)
// ------------------------------------
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

// ------------------------------------
// A. CREATE (KRIJIMI) - VETËM ADMIN
// ------------------------------------
if (isset($_POST['create_post'])) {
    if (!$is_admin) {
        $message = "<div class='error'>Vetëm administratorët mund të krijojnë postime.</div>";
    } else {
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $content = mysqli_real_escape_string($conn, $_POST['content']);
        $author_username = $_SESSION['username'] ?? 'Admin'; 

        $sql = "INSERT INTO posts (title, content, author) VALUES ('$title', '$content', '$author_username')";
        
        if (mysqli_query($conn, $sql)) {
            $message = "<div class='success'>Postimi u krijua me sukses!</div>";
        } else {
            $message = "<div classs='error'>Gabim gjatë krijimit: " . mysqli_error($conn) . "</div>";
        }
    }
}

// ------------------------------------
// B. DELETE (FSHIRJA) - VETËM ADMIN
// ------------------------------------
if (isset($_GET['delete'])) {
    if (!$is_admin) {
        $message = "<div class='error'>Vetëm administratorët mund të fshijnë postime.</div>";
    } else {
        $id = mysqli_real_escape_string($conn, $_GET['delete']);
        $sql = "DELETE FROM posts WHERE id=$id";
        
        if (mysqli_query($conn, $sql)) {
            header("Location: index.php"); 
            exit();
        } else {
            $message = "<div class='error'>Gabim gjatë fshirjes: " . mysqli_error($conn) . "</div>";
        }
    }
}

// ------------------------------------
// C. UPDATE (PËRDITËSIMI) - VETËM ADMIN
// ------------------------------------
if (isset($_POST['update_post'])) {
    if (!$is_admin) {
        $message = "<div class='error'>Vetëm administratorët mund të përditësojnë postime.</div>";
    } else {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $content = mysqli_real_escape_string($conn, $_POST['content']);
    
        $sql = "UPDATE posts SET title='$title', content='$content' WHERE id=$id";
    
        if (mysqli_query($conn, $sql)) {
            $message = "<div class='success'>Postimi u përditësua me sukses!</div>";
        } else {
            $message = "<div class='error'>Gabim gjatë përditësimit: " . mysqli_error($conn) . "</div>";
        }
    }
}

// ------------------------------------
// D. LEXO POSTIMIN PËR TË REDAKTUAR (Përgatitja e Formularit)
// ------------------------------------
if (isset($_GET['edit'])) {
    if (!$is_admin) {
         $message = "<div class='error'>Nuk keni autorizim për të redaktuar.</div>";
    } else {
        $id = mysqli_real_escape_string($conn, $_GET['edit']);
        $edit_result = mysqli_query($conn, "SELECT id, title, content, author FROM posts WHERE id=$id"); 
        if ($edit_result && mysqli_num_rows($edit_result) == 1) {
            $edit_post = mysqli_fetch_assoc($edit_result);
        }
    }
}


// ------------------------------------
// E. READ (LEXIMI) - Merr të gjitha postimet për shfaqje
// ------------------------------------
$posts_result = mysqli_query($conn, "SELECT id, title, content, created_at FROM posts ORDER BY created_at DESC");

?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Blogu me CRUD & Admin Access</title>
    <link rel="stylesheet" href="style.css"> 
    </head>
<body>

<div class="container">
    <header>
        <h1>Blogu Im</h1>
        <div class="auth-status">
            <?php if (isset($_SESSION['username'])): ?>
                Mirë se vini, **<?php echo htmlspecialchars($_SESSION['username']); ?>** <?php if ($is_admin): ?><span class="admin-note">(Administrator)</span><?php endif; ?>!
                <a href="index.php?logout=1">Ç'kyçu</a>
            <?php else: ?>
                <a href="login.php">Hyr (Log In)</a> | 
                <a href="register.php">Regjistrohu (Sign Up)</a>
            <?php endif; ?>
        </div>
    </header>
    
    <?php echo $message; // Shfaq mesazhet e suksesit/gabimit ?>
    
    <div class="search-bar">
        <form method="GET" action="search.php">
            <input 
                type="text" 
                name="query" 
                placeholder="Kërko postime (titull/përmbajtje)..." 
                required 
                style="width: 78%; display: inline-block; margin-right: 1%;"
            >
            <button type="submit" style="width: 20%; display: inline-block; margin-bottom: 15px;">Kërko</button>
        </form>
    </div>
    
    ---
    
    <?php if ($is_admin): ?>
        <h2><?php echo $edit_post ? 'Përditëso Postimin' : 'Krijo Postim të Ri'; ?></h2>
        
        <form method="POST" action="index.php">
            <?php if ($edit_post): ?>
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($edit_post['id']); ?>">
                <input type="hidden" name="update_post" value="1">
            <?php else: ?>
                <input type="hidden" name="create_post" value="1">
            <?php endif; ?>
            
            <input 
                type="text" 
                name="title" 
                placeholder="Titulli i Postimit" 
                value="<?php echo $edit_post ? htmlspecialchars($edit_post['title']) : ''; ?>" 
                required
            >
            
            <textarea 
                name="content" 
                placeholder="Përmbajtja e Postimit" 
                rows="5" 
                required
            ><?php echo $edit_post ? htmlspecialchars($edit_post['content']) : ''; ?></textarea>
            
            <?php if ($edit_post): ?>
                <button type="submit" class="update">Përditëso Postimin</button>
                <a href="index.php">Anulo Redaktimin</a>
            <?php else: ?>
                <button type="submit">Krijo Postimin</button>
            <?php endif; ?>
        </form>
    <?php else: ?>
        <div class="error">Vetëm Administratori mund të modifikojë/krijojë postime.</div>
    <?php endif; ?>
    
    ---
    
    <h2>Postimet Ekzistuese</h2>
    
    <?php if (mysqli_num_rows($posts_result) > 0): ?>
        <?php while($row = mysqli_fetch_assoc($posts_result)): ?>
            <div class="post">
                <h3><a href="view_post.php?id=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['title']); ?></a></h3>
                <small>Publikuar më: <?php echo $row['created_at']; ?></small>
                
                <p><?php echo htmlspecialchars(substr($row['content'], 0, 150)) . (strlen($row['content']) > 150 ? '...' : ''); ?></p>
                
                <div class="actions">
                    <?php if ($is_admin): ?>
                        <a href="index.php?edit=<?php echo $row['id']; ?>">Redakto</a>
                        <a href="index.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('A jeni i sigurt që dëshironi ta fshini këtë postim?');">Fshij</a>
                    <?php else: ?>
                        <a href="view_post.php?id=<?php echo $row['id']; ?>">Lexo më shumë dhe Komento</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Nuk ka asnjë postim të krijuar ende.</p>
    <?php endif; ?>
    
</div>

</body>
</html>