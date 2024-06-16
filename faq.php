<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="nav-bar.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/92d78ba0ea.js" crossorigin="anonymous"></script>

    <script src="faq.js" ></script>
</head>

<body>
    <?php include_once "nav-bar.php"; ?>

    <main>
        <h1> FAQ </h1>

        <div class="eachFaq">
            <h4 class="title">Where can I find your product?</h4>
            <div class="accordion-content">
                <p> We are currently only available in California,
                    but to a state near you as soon as possible.
                    You can locate our amazing retailers carrying
                    Company on our Where To Find page. </p>
            </div> <!-- //.accordion-content -->
        </div> <!-- //.eachFaq -->

        <div class="eachFaq">
            <h4 class="title">Where can I find your product?</h4>
            <div class="accordion-content">
                <p> We are currently only available in California,
                    but to a state near you as soon as possible.
                    You can locate our amazing retailers carrying
                    Company on our Where To Find page. </p>
            </div> <!-- //.accordion-content -->
        </div> <!-- //.eachFaq -->
    </main>

    
</body>
</html>


