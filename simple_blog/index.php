
<?php
// index.php
session_start();
// Sigurohuni që db_config.php është në të njëjtin vend dhe ka të dhënat e sakta të lidhjes.
include('db_config.php'); 

$is_admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
$user_id = $_SESSION['user_id'] ?? null;
$message = "";
$edit_post = null; 

// E RE: FUNKSIONI I TRAJTIMIT TË IMAZHIT (I NEVOJSHËM PËR CREATE/UPDATE)
// Kjo funksionon me kolonën image_path në tabelën posts.
function handle_image_upload() {
    $target_dir = "uploads/";
    
    // Sigurohuni që dosja 'uploads' ekziston
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if (isset($_FILES["post_image"]) && $_FILES["post_image"]["error"] == UPLOAD_ERR_OK) {
        $file_name = basename($_FILES["post_image"]["name"]);
        $image_file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $new_file_name = uniqid('img_', true) . '.' . $image_file_type;
        $target_file = $target_dir . $new_file_name;

        // Kontroll i Madhësisë/Tipit
        if ($_FILES["post_image"]["size"] > 5000000) {
            return ["error" => "Imazhi është shumë i madh (maks. 5MB)."];
        }
        
        if($image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg" && $image_file_type != "gif" ) {
            return ["error" => "Na vjen keq, lejohen vetëm formatet JPG, JPEG, PNG & GIF."];
        }

        if (move_uploaded_file($_FILES["post_image"]["tmp_name"], $target_file)) {
            return ["success" => $target_file]; 
        } else {
            return ["error" => "Gabim gjatë ngarkimit të skedarit."];
        }
    }
    return ["success" => null]; 
}

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
        
        $upload_result = handle_image_upload();
        
        if (isset($upload_result['error'])) {
            $message = "<div class='error'>Gabim Imazhi: " . $upload_result['error'] . "</div>";
        } else {
            $image_path = mysqli_real_escape_string($conn, $upload_result['success'] ?? NULL);
            $image_path_sql = $image_path ? "'$image_path'" : 'NULL';

            // Shton image_path
            $sql = "INSERT INTO posts (title, content, image_path, author) VALUES ('$title', '$content', $image_path_sql, '$author_username')";
            
            if (mysqli_query($conn, $sql)) {
                $message = "<div class='success'>Postimi u krijua me sukses!</div>";
            } else {
                $message = "<div class='error'>Gabim gjatë krijimit: " . mysqli_error($conn) . "</div>";
            }
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
        
        // Fshirja e Imazhit
        $get_img = mysqli_query($conn, "SELECT image_path FROM posts WHERE id=$id");
        $post_to_delete = mysqli_fetch_assoc($get_img);
        if ($post_to_delete && $post_to_delete['image_path'] && file_exists($post_to_delete['image_path'])) {
            unlink($post_to_delete['image_path']);
        }
        
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
        
        $set_image_sql = "";
        $upload_result = handle_image_upload();

        if (isset($upload_result['error'])) {
            $message = "<div class='error'>Gabim Imazhi: " . $upload_result['error'] . "</div>";
        } else if ($upload_result['success'] !== null) {
            $new_path = mysqli_real_escape_string($conn, $upload_result['success']);
            $set_image_sql = ", image_path='$new_path'";
        }
        
        // Përditëson image_path nëse ka ngarkesë të re
        $sql = "UPDATE posts SET title='$title', content='$content' $set_image_sql WHERE id=$id";
    
        if (mysqli_query($conn, $sql)) {
            $message = "<div class='success'>Postimi u përditësua me sukses!</div>";
             header("Location: index.php"); 
             exit();
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
        // Merr image_path për formularin e redaktimit
        $edit_result = mysqli_query($conn, "SELECT id, title, content, author, image_path FROM posts WHERE id=$id"); 
        if ($edit_result && mysqli_num_rows($edit_result) == 1) {
            $edit_post = mysqli_fetch_assoc($edit_result);
        }
    }
}


// ------------------------------------
// E. READ (LEXIMI) - Merr të gjitha postimet për shfaqje
// ------------------------------------
// Këtu nuk përdoret JOIN, merr vetëm të dhënat bazë nga tabela posts
$posts_result = mysqli_query($conn, "
    SELECT 
        id, title, content, created_at, image_path, author
    FROM posts 
    ORDER BY created_at DESC
");

?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Blogu Im Profesional</title>
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
    
    
    <?php if ($is_admin): ?>
        <h2><?php echo $edit_post ? 'Përditëso Postimin' : 'Krijo Postim të Ri'; ?></h2>
        
        <form method="POST" action="index.php" enctype="multipart/form-data">
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

            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Imazhi Kryesor:</label>
            <input 
                type="file" 
                name="post_image" 
                accept="image/*" 
                style="padding: 10px; margin-bottom: 15px; border: 1px solid var(--border-color); border-radius: 8px;"
            >
            <?php if ($edit_post && $edit_post['image_path']): ?>
                <p style="margin-top: -10px; margin-bottom: 15px; font-size: 0.9em;">
                    Imazhi aktual: 
                    <a href="<?php echo htmlspecialchars($edit_post['image_path']); ?>" target="_blank">Shih Imazhin</a>
                </p>
            <?php endif; ?>
            
            <textarea 
                name="content" 
                placeholder="Përmbajtja e Postimit" 
                rows="5" 
                required
            ><?php echo $edit_post ? htmlspecialchars($edit_post['content']) : ''; ?></textarea>
            
            <?php if ($edit_post): ?>
                <button type="submit" class="update">Përditëso Postimin</button>
                <a href="index.php" style="display: block; text-align: center; margin-top: 10px;">Anulo Redaktimin</a>
            <?php else: ?>
                <button type="submit">Krijo Postimin</button>
            <?php endif; ?>
        </form>
    <?php else: ?>
        <div class="error">Vetëm Administratori mund të modifikojë/krijojë postime.</div>
    <?php endif; ?>
    
    <hr> <h2>Postimet e Fundit</h2>

    <?php if (mysqli_num_rows($posts_result) > 0): ?>
        <?php while($row = mysqli_fetch_assoc($posts_result)): ?>
            <div class="post">
                <h3><a href="view_post.php?id=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['title']); ?></a></h3>
                <small>
                    Publikuar më: <?php echo $row['created_at']; ?> (Autor: <?php echo htmlspecialchars($row['author'] ?? 'Anonim'); ?>)
                </small>
                
                <p><?php echo htmlspecialchars(substr($row['content'], 0, 200)) . (strlen($row['content']) > 200 ? '...' : ''); ?></p>

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

