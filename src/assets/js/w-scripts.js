$(function () {
    $('.openSearch').on('click', function(event) {
        event.preventDefault();
        $('#search').addClass('open');
        $('#search > form > input[type="search"]').focus();
    });
    
    $('#search, #search button.close').on('click keyup', function(event) {
        if (event.target == this || event.target.className == 'close' || event.keyCode == 27) {
            $(this).removeClass('open');
        }
    });

    $(window).ready(function() {
      $("#search > form").on("keypress", function (event) {
          var keyPressed = event.keyCode || event.which;

          if (keyPressed === 13) {
              return false;
          }
      });
    });
});