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
});

function createAlias(id) {
    let str = document.getElementById(id).value;
    let alias = document.getElementById("alias");
    str = str.replace(/^\s+|\s+$/g, "").toLowerCase();

    var from = "àáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđ·/_,:;";
    var to = "aaaaaaaaaaaaaaaaaeeeeeeeeeeeiiiiiooooooooooooooooouuuuuuuuuuuyyyyyd------";
    for (var i = 0, l = from.length; i < l; i++) {
        str = str.replace(new RegExp(from.charAt(i), "g"), to.charAt(i));
    }

    str = str.replace(/[^a-z0-9 -]/g, '')
        .replace(/\s+/g, "-")
        .replace(/-+/g, "-");

    alias.value = str;
};