<?php
// view_post.php
session_start();
include('db_config.php');

$message = '';
$post = null;
$is_admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

// 1. Merr ID-në e postimit nga URL dhe shfaq detajet
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $post_id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Merr detajet e postimit
    $post_sql = "SELECT id, title, content, created_at FROM posts WHERE id = $post_id";
    $post_result = mysqli_query($conn, $post_sql);
    
    if (mysqli_num_rows($post_result) == 1) {
        $post = mysqli_fetch_assoc($post_result);
    } else {
        die("Postimi nuk u gjet!");
    }

} else {
    header("Location: index.php"); 
    exit();
}

// ------------------------------------
// 2. LOGJIKA E FSHIRJES SË KOMENTIT (VETËM ADMIN)
// ------------------------------------
if (isset($_GET['delete_comment_id'])) {
    if (!$is_admin) {
        $message = "<div class='error'>Vetëm administratorët mund të fshijnë komente.</div>";
    } else {
        $comment_id = mysqli_real_escape_string($conn, $_GET['delete_comment_id']);
        $delete_sql = "DELETE FROM comments WHERE id = '$comment_id' AND post_id = '$post_id'";
        
        if (mysqli_query($conn, $delete_sql)) {
            // Ridrejto veten pas fshirjes
            header("Location: view_post.php?id=$post_id");
            exit();
        } else {
            $message = "<div class='error'>Gabim gjatë fshirjes së komentit: " . mysqli_error($conn) . "</div>";
        }
    }
}

// ------------------------------------
// 3. LOGJIKA E SHTIMIT TË KOMENTIT
// ------------------------------------
if (isset($_POST['submit_comment'])) {
    if (!isset($_SESSION['username'])) {
        $message = "<div class='error'>Duhet të jeni të kyçur për të komentuar.</div>";
    } else {
        $author = mysqli_real_escape_string($conn, $_SESSION['username']);
        $comment_text = mysqli_real_escape_string($conn, $_POST['comment_text']);

        if (!empty($comment_text)) {
            $insert_sql = "INSERT INTO comments (post_id, author, comment_text) VALUES ('$post_id', '$author', '$comment_text')";
            
            if (mysqli_query($conn, $insert_sql)) {
                // Ridrejto veten për të shmangur dërgimin e dyfishtë
                header("Location: view_post.php?id=$post_id");
                exit();
            } else {
                $message = "<div class='error'>Gabim gjatë shtimit të komentit: " . mysqli_error($conn) . "</div>";
            }
        } else {
            $message = "<div class='error'>Komentimi nuk mund të jetë bosh.</div>";
        }
    }
}


// ------------------------------------
// 4. LOGJIKA E SHFAQJES SË KOMENTEVE
// ------------------------------------
$comments_sql = "SELECT id, author, comment_text, created_at FROM comments WHERE post_id = $post_id ORDER BY created_at DESC";
$comments_result = mysqli_query($conn, $comments_sql);

?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($post['title']); ?></title>
    <link rel="stylesheet" href="style.css">
    <style>
        .container { max-width: 900px; margin: auto; background: white; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .full-post { padding: 20px; border: 1px solid #e0e0e0; margin-bottom: 20px; border-radius: 5px; }
        .full-post h1 { color: #333; margin-top: 0; }
        .full-post small { color: #777; display: block; margin-bottom: 20px; }
        .comment-section h3 { border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-top: 30px; }
        .comment { border: 1px solid #f0f0f0; padding: 10px; margin-bottom: 10px; background: #fafafa; border-left: 3px solid #007bff; }
        .comment strong { color: #007bff; }
        .comment-meta { display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px; }
        .comment-meta small { color: #777; }
        .delete-btn { color: red; text-decoration: none; font-size: 12px; margin-left: 10px; }
        textarea { width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; box-sizing: border-box; }
    </style>
</head>
<body>

<div class="container">
    <header>
        <h1><?php echo htmlspecialchars($post['title']); ?></h1>
        <small>Publikuar më: <?php echo $post['created_at']; ?></small>
        <p><a href="index.php">Kthehu në Faqen Kryesore</a></p>
    </header>

    <div class="full-post">
        <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
    </div>

    <?php echo $message; ?>

    <div class="comment-section">
        <h3>Komente (<?php echo mysqli_num_rows($comments_result); ?>)</h3>

        <?php if (isset($_SESSION['username'])): ?>
            <h4>Shto Komentin Tënd si **<?php echo htmlspecialchars($_SESSION['username']); ?>**</h4>
            <form method="POST" action="view_post.php?id=<?php echo $post_id; ?>">
                <textarea name="comment_text" placeholder="Shkruaj komentin tënd..." rows="4" required></textarea>
                <button type="submit" name="submit_comment">Dërgo Komentin</button>
            </form>
        <?php else: ?>
            <p>Ju lutemi <a href="login.php">kyçuni</a> për të komentuar.</p>
        <?php endif; ?>

        <hr>

        <?php if (mysqli_num_rows($comments_result) > 0): ?>
            <?php while($comment = mysqli_fetch_assoc($comments_result)): ?>
                <div class="comment">
                    <div class="comment-meta">
                        <p><strong><?php echo htmlspecialchars($comment['author']); ?></strong></p>
                        <small>
                            <?php echo $comment['created_at']; ?>
                            
                            <?php if ($is_admin): ?>
                                <a 
                                    href="view_post.php?id=<?php echo $post_id; ?>&delete_comment_id=<?php echo $comment['id']; ?>" 
                                    class="delete-btn"
                                    onclick="return confirm('A jeni i sigurt që dëshironi ta fshini këtë koment?');"
                                >
                                    [Fshij]
                                </a>
                            <?php endif; ?>
                        </small>
                    </div>
                    <p><?php echo nl2br(htmlspecialchars($comment['comment_text'])); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Nuk ka komente për këtë postim. Bëhu i pari!</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
<?php
// Lidhja mbyllet automatikisht nga PHP
?>