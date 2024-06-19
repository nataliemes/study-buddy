function showCategories(evt, tabName) {
            
    // hiding other tabs
    var tabcontent = document.getElementsByClassName("tabcontent");
    for (var i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // making other links inactive
    var tablinks = document.getElementsByClassName("tablinks");
    for (var i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // showing current tab & making current link active
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}