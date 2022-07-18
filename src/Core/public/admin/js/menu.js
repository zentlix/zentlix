$(document).ready(function () {
    $('.menu-submit').on('click', function () {
        $('#main form').submit();
    });
    $('.menu-controls').on('click', function (e) {
        e.preventDefault();
    });
});