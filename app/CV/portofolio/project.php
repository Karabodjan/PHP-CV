<?php
session_start();
require '../actions/db.php';

if (!isset($_GET['id'])) {
    header('Location: projects.php');
    exit();
}

$projectId = $_GET['id'];

// Fetch project details
$stmt = $pdo->prepare('SELECT * FROM projects WHERE id = :id');
$stmt->execute(['id' => $projectId]);
$project = $stmt->fetch();

if (!$project) {
    header('Location: projects.php');
    exit();
}

// Fetch user pseudo
$userStmt = $pdo->prepare('SELECT pseudo FROM users WHERE id = :id');
$userStmt->execute(['id' => $project['user_id']]);
$user = $userStmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($project['title']); ?></title>
    <link rel="stylesheet" href="assets/styles/navbar.css">
</head>
<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($project['title']); ?></h1>
        <p><?php echo htmlspecialchars($project['description']); ?></p>
        <p>Added by: <?php echo htmlspecialchars($user['pseudo']); ?></p>
        
        <!-- Comments Section -->
        <h4>Comments</h4>
        <form method="POST">
            <input type="hidden" name="add_comment" value="1">
            <input type="hidden" name="project_id" value="<?php echo $project['id']; ?>">
            <textarea name="comment" required placeholder="Add a comment..."></textarea>
            <button type="submit">Comment</button>
        </form>

        <?php
        $stmtComments = $pdo->prepare('SELECT * FROM comments WHERE project_id = :project_id');
        $stmtComments->execute(['project_id' => $project['id']]);
        $comments = $stmtComments->fetchAll();
        foreach ($comments as $comment):
        ?>
            <p><?php echo htmlspecialchars($comment['comment']); ?> - <em><?php echo htmlspecialchars($userPseudos[$comment['user_id']]); ?></em></p>
        <?php endforeach; ?>
    </div>
</body>
</html>
