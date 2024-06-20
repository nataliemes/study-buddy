$(document).ready(function() {
    var container = '.faq-container';
    var question = '.faq-container .faq-question';
    var answer = '.faq-answer';

    // at first all the answers are hidden
    $(container).each(function() {
        $(this).addClass('close');
        $(this).find(answer).hide();
    });

    // when a question is clicked
    $(question).click(function(){
        var faqClass = $(this).closest(container).attr('class');
        
        if (faqClass.indexOf('close') != -1) {  // if closed

            // close all answers & set all containers as closed
            $(container).find(answer).slideUp('slow');
            $(container).addClass('close').removeClass('open');

            // open the clicked question's answer & set this container as open
            $(this).closest(container).removeClass('close').addClass('open');
            $(this).closest(container).find(answer).slideDown('slow');
        }
        else {
            $(this).closest(container).addClass('close').removeClass('open');
            $(this).closest(container).find(answer).slideUp('slow');
        }
    });
});