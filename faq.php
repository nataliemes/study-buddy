<?php
    // nav-bar-shi mowmdeba user shemosulia tu ara
    include 'nav-bar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/92d78ba0ea.js" crossorigin="anonymous"></script>

    <script>
        $( document ).ready(function() {
    
    var container = '.eachFaq';
    var question = '.eachFaq .title';
    var answer = '.accordion-content';
  
    $(container).each(function() {
      $( this ).addClass('close');
      $( this ).find(answer).hide();
    });
    
    $(question).click(function(){
      var faqClass = $(this).closest(container).attr('class');
		console.log(faqClass);
      
      if(faqClass.indexOf('close') != -1){
        //WHEN CLOSED
        // $(container).find(answer).slideUp('slow'); //CLOSE ALL
        // $(container).addClass('close').removeClass('open'); //set all faq as closed
        
        $(this).closest(container).removeClass('close').addClass('open');
        $( this ).closest(container).find(answer).slideDown('slow');
        
      } else {
        $(this).closest(container).addClass('close').removeClass('open');
        $( this ).closest(container).find(answer).slideUp('slow');
      }
      
    });
    
  });
    </script>
</head>

<body>
    <h1> FAQ </h1>

    <div class="eachFaq">
	<h4 class="title">Where can I find your product?</h4>
	<div class="accordion-content">
	<p>We are currently only available in California, but to a state near you as soon as possible.  You can locate our amazing retailers carrying Company on our  Where To Find page.</p>
	</div> <!-- //.accordion-content -->
</div> <!-- //.eachFaq -->

<div class="eachFaq">
	<h4 class="title">Where can I find your product?</h4>
	<div class="accordion-content">
	<p>We are currently only available in California, but to a state near you as soon as possible.  You can locate our amazing retailers carrying Company on our  Where To Find page.</p>
	</div> <!-- //.accordion-content -->
</div> <!-- //.eachFaq -->

    
</body>
</html>


