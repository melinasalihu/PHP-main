<?php
// search.php
session_start();
// Kujdes: sigurohuni që 'db_config.php' ekziston dhe funksionon
include('db_config.php');

$query = '';
$results_result = null;
$message = '';
$is_admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

// 1. Përpunimi i Termit të Kërkimit
if (isset($_GET['query']) && !empty(trim($_GET['query']))) {
    // Pastro termat e kërkimit për siguri
    $query = mysqli_real_escape_string($conn, trim($_GET['query']));
    
    // Pyetësori SQL: Përdor LIKE dhe % për të kërkuar përputhje në TITULL OSE PËRMBAJTJE
    $sql = "SELECT id, title, content, created_at, author 
            FROM posts 
            WHERE title LIKE '%$query%' OR content LIKE '%$query%'
            ORDER BY created_at DESC";
            
    $results_result = mysqli_query($conn, $sql);
    
    if (!$results_result) {
        $message = "<div class='error'>Gabim në pyetjen SQL: " . mysqli_error($conn) . "</div>";
    }

} else {
    // Nëse kërkohet search.php pa asnjë term kërkimi
    $message = "<div class='error'>Ju lutemi shkruani një term kërkimi në faqen kryesore.</div>";
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Rezultatet e Kërkimit: <?php echo htmlspecialchars($query); ?></title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Stilizim specifik që shfrytëzon variablat Rozë nga style.css */
        .search-term { 
            color: var(--primary-color); 
            font-weight: bold; 
        }
    </style>
</head>
<body>

<div class="container">
    <header>
        <h1>Rezultatet e Kërkimit</h1>
        <p><a href="index.php">← Kthehu në Blog</a></p>
    </header>
    
    <?php echo $message; ?>

    <?php if ($query): ?>
        <h2>Duke kërkuar për: <span class="search-term"><?php echo htmlspecialchars($query); ?></span></h2>
    <?php endif; ?>

    ---
    
    <?php if ($results_result && mysqli_num_rows($results_result) > 0): ?>
        <h3>U gjetën <?php echo mysqli_num_rows($results_result); ?> postime:</h3>
        
        <?php while($row = mysqli_fetch_assoc($results_result)): ?>
            <div class="post">
                <h3><a href="view_post.php?id=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['title']); ?></a></h3>
                <small>Publikuar më: <?php echo $row['created_at']; ?> (Autor: <?php echo htmlspecialchars($row['author'] ?? 'Anonim'); ?>)</small>
                
                <p><?php echo htmlspecialchars(substr($row['content'], 0, 150)) . (strlen($row['content']) > 150 ? '...' : ''); ?></p>
                
                <div class="actions">
                    <?php if ($is_admin): ?>
                        <a href="index.php?edit=<?php echo $row['id']; ?>">Redakto</a>
                        <a href="index.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('A jeni i sigurt që dëshironi ta fshini këtë postim?');">Fshij</a>
                    <?php else: ?>
                        <a href="view_post.php?id=<?php echo $row['id']; ?>">Lexo më shumë</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; ?>
    <?php elseif ($query): ?>
        <p>Nuk u gjet asnjë postim që përputhet me kërkesën tuaj.</p>
    <?php endif; ?>
    
</div>

</body>
</html>