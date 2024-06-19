$(document).ready(function() {
  var container = '.eachFaq';
  var question = '.eachFaq .title';
  var answer = '.accordion-content';

  $(container).each(function() {
      $(this).addClass('close');
      $(this).find(answer).hide();
  });

  $(question).click(function(){
      var faqClass = $(this).closest(container).attr('class');
      

      if(faqClass.indexOf('close') != -1){
          //WHEN CLOSED
          $(container).find(answer).slideUp('slow'); //CLOSE ALL
          $(container).addClass('close').removeClass('open'); //set all faq as closed

          $(this).closest(container).removeClass('close').addClass('open');
          $( this ).closest(container).find(answer).slideDown('slow');

      }
      else {
          $(this).closest(container).addClass('close').removeClass('open');
          $( this ).closest(container).find(answer).slideUp('slow');
      }
  });
});