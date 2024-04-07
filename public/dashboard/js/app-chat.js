(function ($) {
  // chat init
  const $blankBox = $("#blank-box");
  const $mainMessageBox = $("#main-message-box");
  const $infoBox = $("#info-box");
  const $contactBox = $(".chat-contact-bar");
  const $startChat = $(".start-chat");
  const $overlay = $(".chat-overlay");

  let $window = $(window);
  if (window.innerWidth <= 1024) {
    $contactBox.addClass("enter-lg");
  }

  // by default set display none
  $mainMessageBox.hide();
  $infoBox.hide();

  // mobile device open chat contact
  $startChat.on("click", function () {
    $contactBox.toggleClass("active");
    $overlay.toggleClass("active");
  });
  $overlay.on("click", function () {
    $contactBox.toggleClass("active");
    $overlay.toggleClass("active");
  });

  // show main message box and info box when contact is clicked
  $("#message-contact li").on("click", function () {
    $mainMessageBox.show();
    if (window.innerWidth >= 1024) {
      $infoBox.show();
    }
    if ($contactBox.hasClass("active")) {
      $contactBox.removeClass("active");
      $overlay.removeClass("active");
    }

    $blankBox.hide();
  });
  // hide info box when window width is greater than 1024 pixels
  $(window).resize(function () {
    if (window.innerWidth <= 1024) {
      $infoBox.hide();
      $contactBox.addClass("enter-lg");
    } else {
      //$infoBox.show();
      $contactBox.removeClass("enter-lg");
    }
  });

  // toggle info box when hide info button is clicked
  $("#hide-info").on("click", function () {
    $infoBox.toggle();
  });
})(jQuery);
