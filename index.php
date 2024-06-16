<?php
    // nav-bar-shi mowmdeba user shemosulia tu ara
    include 'nav-bar.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Project Demo</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="nav-bar.css">
    <link rel="stylesheet" href="other.css">
    <!-- <script src="https://kit.fontawesome.com/92d78ba0ea.js" crossorigin="anonymous"></script> -->
</head>
<body>

    <main id="landing-page">
        <img src="images/img2.png" alt="image">
        
        <h1> Develop skills <br>
             from the best <br>
             source
        </h1>

        <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit.
            Enim hic illum sed aut quos vero labore excepturi cumque
            asperiores quae illo ratione, soluta reprehenderit,
            possimus at qui provident quis repudiandae?
        </p>

        <form name="search">
            <input type="text" name="txt" onmouseout="this.value = ''; this.blur();">
            <button> Search </button>
        </form>

        
        
    </main>

    <main id="popular-posts">
        <h1> Special <br>
            features are <br>
            only for you
        </h1><!--

        
        --><div>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                Enim hic illum sed aut quos vero labore excepturi cumque
                asperiores quae illo ratione, soluta reprehenderit,
                possimus at qui provident quis repudiandae?
            </p>

            <button> View all courses </button>
        </div>

        <div class="post">
            post 1
        </div><!--
        
        --><div class="post">
            post 2
        </div><!--

        --><div class="post">
            post 3
        </div>
    </main>

    <footer>
        <h1> NAME </h1>

        <div id="more-info">
            <a href="#"> Terms </a>
            <a href="#"> Privacy </a>
            <a href="#"> Cookies </a>
        </div>

        <div id="socials">
            <a href="#"> fb </a>
            <a href="#"> ln </a>
            <a href="#"> x </a>
        </div>
    </footer>


    
</body>
</html>