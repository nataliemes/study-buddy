<?php 
    session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Project Demo</title>
    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet" href="main.css">
    <!-- <script src="https://kit.fontawesome.com/92d78ba0ea.js" crossorigin="anonymous"></script> -->
</head>
<body>

    <?php include 'nav-bar.php'; ?>

    <main id="landing-page">
        
        <h1> Your Ultimate Resource for Academic Success </h1>

        <p>
            Discover, share, and enhance your study materials in one collaborative platform.
            Join our community of students dedicated to achieving excellence through
            shared knowledge and support. Whether you're looking for detailed notes or 
            ready to share your own, Study Buddy is here to make your academic journey
            smoother and more successful. Start exploring now and take your studies to the next level!
        </p>

        <a href="about.php"> Learn More </a>
        
        <img src="images/books.png" alt="image">
        
    </main>

    <aside>
        <img src="images/study.png" alt="image">
    </aside>

    <main id="popular-posts">
        <h1> Stay Updated with <br>
             the Latest Posts <br>
             from Your Peers
        </h1>
        
        <div>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                Enim hic illum sed aut quos vero labore excepturi cumque
                asperiores quae illo ratione, soluta reprehenderit,
                possimus at qui provident quis repudiandae?
            </p>

            <a href="about.php"> View all posts </a>
        </div>

        <div class="post">
            post 1
        </div>
        
        <div class="post">
            post 2
        </div>
        
        <div class="post">
            post 3
        </div>
    </main>

    <?php include_once "footer.php"; ?>
    
</body>
</html>