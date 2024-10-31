<?php
session_start();
require '../actions/db.php';

// Initialize variables
$search = '';
$projects = []; // Initialize as an empty array

// Add a new project
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_project'])) {
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);

    // Check if the project already exists
    $stmt = $pdo->prepare('SELECT * FROM projects WHERE title = :title');
    $stmt->execute(['title' => $title]);
    if (!$stmt->fetch()) {
        $stmt = $pdo->prepare('INSERT INTO projects (user_id, title, description) VALUES (:user_id, :title, :description)');
        $stmt->execute([
            'user_id' => $_SESSION['id'],
            'title' => $title,
            'description' => $description,
        ]);
        header('Location: projects.php');
        exit();
    } else {
        echo "Project with this title already exists.";
    }
}

// Fetch projects
$search = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';
$stmt = $pdo->prepare('SELECT * FROM projects WHERE title LIKE :search');
$stmt->execute(['search' => '%' . $search . '%']);
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Add comments
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_comment'])) {
    $projectId = $_POST['project_id'];
    $comment = htmlspecialchars($_POST['comment']);
    
    $stmt = $pdo->prepare('INSERT INTO comments (project_id, user_id, comment) VALUES (:project_id, :user_id, :comment)');
    $stmt->execute([
        'project_id' => $projectId,
        'user_id' => $_SESSION['id'],
        'comment' => $comment,
    ]);
    header('Location: projects.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects</title>
    <link rel="stylesheet" href="../assets/styles/portofolio.css">
</head>
<body>
    <div class="container">
        <h1>Projects</h1>

        <?php if (isset($_SESSION['id'])): ?>
            <h2>Add New Project</h2>
            <form method="POST">
                <input type="hidden" name="add_project" value="1">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required>
                <label for="description">Description:</label>
                <textarea id="description" name="description" required></textarea>
                <button type="submit">Add Project</button>
            </form>
        <?php endif; ?>

        <h2>Search Projects</h2>
        <form method="GET">
            <input type="text" name="search" value="<?php echo $search; ?>" placeholder="Search projects...">
            <button type="submit">Search</button>
        </form>

        <h2>Project List</h2>
        <?php foreach ($projects as $project): ?>
            <div class="project">
                <h3>
                    <a href="project.php?id=<?php echo $project['id']; ?>">
                        <?php echo htmlspecialchars($project['title']); ?>
                    </a>
                </h3>
                <p><?php echo htmlspecialchars($project['description']); ?></p>
                
                <!-- Fetching user pseudo -->
                <?php
                $userStmt = $pdo->prepare('SELECT pseudo FROM users WHERE id = :id');
                $userStmt->execute(['id' => $project['user_id']]);
                $user = $userStmt->fetch();
                ?>
                <p>Added by: <?php echo htmlspecialchars($user['pseudo']); ?></p>

                <!-- Favorite button -->
                <?php if (isset($_SESSION['id'])): ?>
                    <form method="POST" action="actions/favorite.php">
                        <input type="hidden" name="project_id" value="<?php echo $project['id']; ?>">
                        <button type="submit">Favorite</button>
                    </form>
                <?php endif; ?>

                <!-- Comments -->
                <h4>Comments</h4>
                <form method="POST">
                    <input type="hidden" name="add_comment" value="1">
                    <input type="hidden" name="project_id" value="<?php echo $project['id']; ?>">
                    <textarea name="comment" required placeholder="Add a comment..."></textarea>
                    <button type="submit">Comment</button>
                </form>

                <!-- Display existing comments -->
                <?php
                $stmtComments = $pdo->prepare('SELECT * FROM comments WHERE project_id = :project_id');
                $stmtComments->execute(['project_id' => $project['id']]);
                $comments = $stmtComments->fetchAll();
                foreach ($comments as $comment):
                    $userStmt = $pdo->prepare('SELECT pseudo FROM users WHERE id = :id');
                    $userStmt->execute(['id' => $comment['user_id']]);
                    $commentUser = $userStmt->fetch();
                ?>
                    <p><?php echo htmlspecialchars($comment['comment']); ?> - <em><?php echo htmlspecialchars($commentUser['pseudo']); ?></em></p>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
