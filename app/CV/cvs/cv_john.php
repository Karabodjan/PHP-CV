<?php
session_start();
require '../actions/db.php'; 

// Fetch user information from the database based on the pseudo
$pseudo = 'john'; 

$stmt = $pdo->prepare('SELECT * FROM users WHERE pseudo = :pseudo');
$stmt->execute(['pseudo' => $pseudo]);
$user = $stmt->fetch();

if (!$user) {
    die('User not found.');
}

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and retrieve form data
    $lastname = htmlspecialchars($_POST['lastname']);
    $firstname = htmlspecialchars($_POST['firstname']);
    $email = htmlspecialchars($_POST['email']);
    $address = htmlspecialchars($_POST['address']);
    $phone = htmlspecialchars($_POST['phone']);
    $profileDescription = htmlspecialchars($_POST['profileDescription']);

    // Update user information in the database
    $stmt = $pdo->prepare('UPDATE users SET lastname = :lastname, firstname = :firstname, email = :email, address = :address, phone = :phone, profile_description = :profile_description WHERE pseudo = :pseudo');
    $stmt->execute([
        'lastname' => $lastname,
        'firstname' => $firstname,
        'email' => $email,
        'address' => $address,
        'phone' => $phone,
        'profile_description' => $profileDescription,
        'pseudo' => $pseudo
    ]);

    // Optionally, redirect back to the same page to avoid resubmission on refresh
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curriculum Vitae</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.2/html2pdf.bundle.min.js" integrity="sha512-MpDFIChbcXl2QgipQrt1VcPHMldRILetapBl5MPCA9Y8r7qvlwx1/Mc9hNTzY+kS5kX6PdoDq41ws1HiVNLdZA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="../assets/styles/cv.css">
    <script src="../assets/js/main.js" defer></script>
</head>
<body class="light-theme">
<div class="container">
    <header>
        <h1><?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?></h1>
        <p>Email: <?php echo htmlspecialchars($user['email']); ?> | Phone: <?php echo htmlspecialchars($user['phone']); ?></p>
        <p>Address: <?php echo htmlspecialchars($user['address']); ?></p>
        <select id="theme-selector">
    <option value="light-theme">Light</option>
    <option value="dark-theme">Dark</option>
    <option value="blue-theme">Blue</option>
</select>
        <button id="updateBtn">Update Information</button>
        <button id ="generate-pdf" >Generate PDF</button>
    </header>

    <section class="profile">
        <h2>Profile</h2>
        <p><?php echo htmlspecialchars($user['profile_description']); ?></p>
    </section>

    <!-- Experience Section -->
    <section class="experience">
        <h2>Work Experience</h2>
        <div class="job">
            <h3>Senior Web Developer</h3>
            <p>ABC Company | 2019 - Present</p>
            <ul>
                <li>Lead the development team for designing responsive websites and applications.</li>
                <li>Optimized web performance, resulting in a 20% faster load time.</li>
                <li>Mentored junior developers on modern JavaScript frameworks.</li>
            </ul>
        </div>

        <div class="job">
            <h3>Junior Web Developer</h3>
            <p>XYZ Solutions | 2016 - 2019</p>
            <ul>
                <li>Assisted in building client websites using HTML, CSS, and JavaScript.</li>
                <li>Collaborated with designers to implement UI/UX designs.</li>
                <li>Maintained and updated existing websites for clients.</li>
            </ul>
        </div>
    </section>

    <!-- Education Section -->
    <section class="education">
        <h2>Education</h2>
        <p><strong>Bachelor of Science in Computer Science</strong> | University of Technology | 2012 - 2016</p>
    </section>

    <!-- Skills Section -->
    <section class="skills">
        <h2>Skills</h2>
        <ul>
            <li>HTML, CSS, JavaScript</li>
            <li>Node.js, Express.js</li>
            <li>React, Angular</li>
            <li>SQL, MongoDB</li>
            <li>Git, GitHub</li>
        </ul>
    </section>

    <!-- Projects Section -->
    <section class="projects">
        <h2>Projects</h2>
        <ul>
            <li><strong>Portfolio Website:</strong> A personal website showcasing my work and skills.</li>
            <li><strong>Task Manager App:</strong> A full-stack web application for managing tasks and deadlines.</li>
        </ul>
    </section>

    <!-- Footer Section -->

    <footer>
        <p>© 2024 <?php echo htmlspecialchars($user['pseudo']); ?> | Connect with me on <a href="#">LinkedIn</a> or <a href="#">GitHub</a></p>
    </footer>
</div>

<!-- Modal for updating information -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Update Your Information</h2>
        <form method="POST">
            <label for="pseudo">Pseudo:</label>
            <input type="text" id="pseudo" name="pseudo" value="<?php echo htmlspecialchars($user['pseudo']); ?>" readonly><br>
            <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastname" value="<?php echo htmlspecialchars($user['lastname']); ?>"><br>
            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" value="<?php echo htmlspecialchars($user['firstname']); ?>"><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"><br>
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user['address']); ?>"><br>
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>"><br>
            <label for="profileDescription">Profile Description:</label>
            <textarea id="profileDescription" name="profileDescription"><?php echo htmlspecialchars($user['profile_description']); ?></textarea><br>
            <button type="submit">Save Changes</button>
        </form>
    </div>
</div>

</body>
</html>
