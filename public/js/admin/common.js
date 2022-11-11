$(function () {
    $('.flash-message').fadeIn('slow').delay(4000).fadeOut('slow');
});

// Listen for input event on numInput.
$("#number").on("keydown", function (e) {
    if(!((e.keyCode > 95 && e.keyCode < 106)
        || (e.keyCode > 47 && e.keyCode < 58)
        || e.keyCode == 8)) {
        return false;
    }
})
