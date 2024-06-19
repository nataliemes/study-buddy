<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="faq.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/92d78ba0ea.js" crossorigin="anonymous"></script>

    <script src="faq.js" ></script>
</head>

<body>
    <?php include_once "nav-bar.php"; ?>

    <aside>
        <img src="images/faq.png" alt="image">
    </aside>

    <main>
        <h1> FAQ </h1>

        <div class="eachFaq">
            <h4 class="title"> What is Study Buddy? </h4>
            <div class="accordion-content">
                <p> Study Buddy is an online platform where students can upload,
                    share, and discover study materials such as lecture notes,
                    summaries, and study guides. </p>
            </div>
        </div>

        <div class="eachFaq">
            <h4 class="title"> How do I upload my notes? </h4>
            <div class="accordion-content">
                <p> Uploading your notes is easy! Simply sign up or log in to your account,
                    navigate to your profile, choose your file, and categorize it accordingly. </p>
            </div>
        </div>

        <div class="eachFaq">
            <h4 class="title"> Is Study Buddy free to use? </h4>
            <div class="accordion-content">
                <p> Yes, Study Buddy is completely free to use.
                    You can upload and access study materials without any charges.
                    We aim to keep our platform accessible to all students. </p>
            </div>
        </div>

        <div class="eachFaq">
            <h4 class="title"> What types of files can I upload? </h4>
            <div class="accordion-content">
                <p> You can upload PDF files which are up to 1MB in size. </p>
            </div>
        </div>

        <div class="eachFaq">
            <h4 class="title"> How is the quality of the notes ensured? </h4>
            <div class="accordion-content">
                <p> Users can review notes and send us feedback via our contact page.
                    Additionally, our team periodically reviews the content to ensure
                    accuracy and relevance. </p>
            </div>
        </div>

        <div class="eachFaq">
            <h4 class="title"> Can I delete my uploaded notes? </h4>
            <div class="accordion-content">
                <p> Yes, you can delete your notes at any time.
                    Simply go to your profile, find the note you wish to 
                    delete, and make the necessary changes. </p>
            </div>
        </div>

    </main>

    <?php include_once 'footer.php'; ?>
    
</body>
</html>


