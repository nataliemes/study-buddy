<?php
    session_start();  // for nav-bar
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/side-image-layout.css">
    <link rel="stylesheet" href="css/faq.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="js/faq.js" ></script>
</head>

<body>
    <?php require_once "nav-bar.php"; ?>

    <aside>
        <img src="images/faq.png" alt="image">
    </aside>

    <main>
        <h1> FAQ </h1>

        <div class="faq-container">
            <h4 class="faq-question"> What is Study Buddy? </h4>
            <div class="faq-answer">
                <p> Study Buddy is an online platform where students can upload,
                    share, and discover study materials such as lecture notes,
                    summaries, and study guides. </p>
            </div>
        </div>

        <div class="faq-container">
            <h4 class="faq-question"> How do I upload my notes? </h4>
            <div class="faq-answer">
                <p> Uploading your notes is easy! Simply sign up or log in to your account,
                    navigate to your profile, choose your file, and categorize it accordingly. </p>
            </div>
        </div>

        <div class="faq-container">
            <h4 class="faq-question"> Is Study Buddy free to use? </h4>
            <div class="faq-answer">
                <p> Yes, Study Buddy is completely free to use.
                    You can upload and access study materials without any charges.
                    We aim to keep our platform accessible to all students. </p>
            </div>
        </div>

        <div class="faq-container">
            <h4 class="faq-question"> What types of files can I upload? </h4>
            <div class="faq-answer">
                <p> You can upload PDF files which are up to 1MB in size. </p>
            </div>
        </div>

        <div class="faq-container">
            <h4 class="faq-question"> How is the quality of the notes ensured? </h4>
            <div class="faq-answer">
                <p> Users can review notes and send us feedback via our contact page.
                    Additionally, our team periodically reviews the content to ensure
                    accuracy and relevance. </p>
            </div>
        </div>

        <div class="faq-container">
            <h4 class="faq-question"> Can I delete my uploaded notes? </h4>
            <div class="faq-answer">
                <p> Yes, you can delete your notes at any time.
                    Simply go to your profile, find the note you wish to 
                    delete, and make the necessary changes. </p>
            </div>
        </div>

    </main>

    <?php include_once 'footer.php'; ?>
    
</body>
</html>