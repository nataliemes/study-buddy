<?php 
    session_start();  // for nav-bar
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Project Demo</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/side-image-layout.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <?php require_once 'nav-bar.php'; ?>

    <main>
        <h1> Your Ultimate Resource for Academic Success </h1>

        <p>
            Discover, share, and enhance your study materials in one collaborative platform.
            Join our community of students dedicated to achieving excellence through
            shared knowledge and support. Whether you're looking for detailed notes or 
            ready to share your own, Study Buddy is here to make your academic journey
            smoother and more successful. Start exploring now and take your studies to the next level!
        </p>
        
        <div>
            <img src="images/books.png" alt="image">
            <a href="about.php"> Learn More </a>
        </div>
        
    </main>

    <aside>
        <img src="images/study.png" alt="image">
    </aside>

    <?php include_once "footer.php"; ?>
</body>
</html>