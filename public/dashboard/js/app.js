"use strict";

// import * as te from 'tw-elements';
(function ($) {
  var currentPageUrl = window.location.href;
  var currentLink = currentPageUrl.split("/");
  var Href = currentLink[currentLink.length - 1];
  $('a[href="' + Href + '"]').addClass("active");
  var ParentUl = $("a.active").parent().parent();
  $(ParentUl).addClass("menu-open");
  var ParentClass = $("a.active").parent().parent().parent();
  $(ParentClass).addClass("active");
  function screenWidth() {
    if ($(window).width() < 1281) {
      $(".sidebar-wrapper").addClass("menu-hide");
      $("#menuCollapse").hide();
      $(".app-header").addClass("margin-0");
      $(".site-footer ").addClass("margin-0");
      $("#content_wrapper").addClass("margin-0");
      $(".sidebarCloseIcon").show();
      $("#sidebar_type").hide();
      $("#bodyOverlay").addClass("block");
    } else {
      $(".sidebar-wrapper").removeClass("menu-hide");
      $("#menuCollapse").show();
      $(".app-header").removeClass("margin-0");
      $(".site-footer").removeClass("margin-0");
      $("#content_wrapper").removeClass("margin-0");
      $(".sidebarCloseIcon").hide();
      $("#sidebar_type").show();
      $("#bodyOverlay").removeClass("block");
    }
  }
  screenWidth();
  $(window).resize(function () {
    screenWidth();
  });

  /*===================================
   Dark and light theme change
  =====================================*/
  var themes = [{
    name: "dark",
    "class": "dark",
    checked: false
  }, {
    name: "semiDark",
    "class": "semiDark",
    checked: false
  }, {
    name: "light",
    "class": "light",
    checked: false
  }];

  // Loop through themes and add event listener for changes
  themes.forEach(function (theme) {
    var radioBtn = $("#".concat(theme["class"]));
    radioBtn.prop("checked", theme.name === currentTheme);
    radioBtn.on("change", function () {
      if (this.checked) {
        currentTheme = theme.name;
        localStorage.theme = theme.name;
        location.reload();
      }
    });
  });

  // Theme Change by Header Button
  $("#themeMood").on("click", function () {
    if (currentTheme === "light") {
      currentTheme = "dark";
    } else {
      currentTheme = "light";
    }
    localStorage.theme = currentTheme;
    location.reload();
  });
  $("#grayScale").on("click", function () {
    if ($("html").hasClass("grayScale")) {
      $("html").removeClass("grayScale");
      localStorage.effect = "";
    } else {
      $("html").addClass("grayScale");
      localStorage.effect = "grayScale";
    }
  });

  /*===================================
   Layout Changer
  =====================================*/
  // Sidebar Type Local Storage save
  if (localStorage.sideBarType == "extend") {
    $(".app-wrapper").addClass(localStorage.sideBarType);
  } else if (localStorage.sideBarType == "collapsed") {
    $(".app-wrapper").removeClass("extend").addClass("collapsed");
    $("#menuCollapse input[type=checkbox]").prop("checked", true);
  }
  // Header Area Toggle switch
  $("#sidebar_type").on("click", function () {
    if ($(".app-wrapper").hasClass("collapsed")) {
      $(".app-wrapper").removeClass("collapsed").addClass("extend");
      $("#menuCollapse input[type=checkbox]").prop("checked", false);
      localStorage.sideBarType = "extend";
    } else {
      $(".app-wrapper").removeClass("extend").addClass("collapsed");
      $("#menuCollapse input[type=checkbox]").prop("checked", true);
      localStorage.sideBarType = "collapsed";
    }
  });

  // Settings Area Toggle Switch
  $("#menuCollapse input[type=checkbox]").on("click", function () {
    if ($("#menuCollapse input[type=checkbox]").is(":checked")) {
      $(".app-wrapper").removeClass("extend").addClass("collapsed");
      localStorage.sideBarType = "collapsed";
    } else {
      $(".app-wrapper").removeClass("collapsed").addClass("extend");
      localStorage.sideBarType = "extend";
    }
  });

  // Menu Hide and show toggle
  $("#menuHide input[type=checkbox]").on("click", function () {
    if ($("#menuHide input[type=checkbox]").is(":checked")) {
      $(".sidebar-wrapper").addClass("menu-hide");
      $("#menuCollapse").hide();
      $(".app-header").addClass("margin-0");
      $(".site-footer").addClass("margin-0");
      $("#content_wrapper").addClass("margin-0");
    } else {
      $(".sidebar-wrapper").removeClass("menu-hide");
      $("#menuCollapse").show();
      $(".app-header").removeClass("margin-0");
      $(".site-footer").removeClass("margin-0");
      $("#content_wrapper").removeClass("margin-0");
    }
  });

  // Content layout toggle
  if (localStorage.contentLayout == "container") {
    $("#page_layout").addClass(localStorage.contentLayout);
    $("#boxed").prop("checked", true);
  } else {
    $("#page_layout").addClass("container-fluid");
    $("#fullWidth").prop("checked", true);
  }

  // Content layout Changing options
  $("#fullWidth").on("change", function () {
    $("#page_layout").removeClass("container").addClass("container-fluid");
    localStorage.contentLayout = "container-fluid";
  });
  $("#boxed").on("change", function () {
    $("#page_layout").removeClass("container-fluid").addClass("container");
    localStorage.contentLayout = "container";
  });

  // Menu Layout toggle
  if (localStorage.menuLayout == "horizontalMenu") {
    // $(".app-wrapper").addClass(localStorage.menuLayout);
    $("#horizontal_menu").prop("checked", true);
  } else {
    // $(".app-wrapper").removeClass("horizontalMenu");
    $("#vertical_menu").prop("checked", true);
  }

  // Menu Layout Changing options
  $("#vertical_menu").on("change", function () {
    $(".app-wrapper").removeClass("horizontalMenu");
    localStorage.menuLayout = "";
  });
  $("#horizontal_menu").on("change", function () {
    $(".app-wrapper").addClass("horizontalMenu");
    localStorage.menuLayout = "horizontalMenu";
  });

  // Header Area styles

  // Check local storage and set Header Style
  if (localStorage.navbar == "floating") {
    $("#app_header").addClass(localStorage.navbar);
    $("#nav_" + localStorage.navbar).prop("checked", true);
  } else if (localStorage.navbar == "sticky top-0") {
    $("#app_header").addClass(localStorage.navbar);
    $("#nav_sticky").prop("checked", true);
  } else if (localStorage.navbar == "hidden") {
    $("#app_header").addClass(localStorage.navbar);
    $("#nav_" + localStorage.navbar).prop("checked", true);
  } else {
    $("#app_header").addClass("static");
    $("#nav_static").prop("checked", true);
  }
  // Header Changing options
  $("#nav_floating").on("change", function () {
    $("#app_header").removeClass("sticky top-0").removeClass("hidden").removeClass("static").addClass("floating");
    localStorage.navbar = "floating";
  });
  $("#nav_sticky").on("change", function () {
    $("#app_header").removeClass("floating").removeClass("hidden").removeClass("static").addClass("sticky top-0");
    localStorage.navbar = "sticky top-0";
  });
  $("#nav_static").on("change", function () {
    $("#app_header").removeClass("floating").removeClass("hidden").removeClass("sticky top-0").addClass("static");
    localStorage.navbar = "static";
  });
  $("#nav_hidden").on("change", function () {
    $("#app_header").removeClass("floating").removeClass("static").removeClass("sticky top-0").addClass("hidden");
    localStorage.navbar = "hidden";
  });

  // Footer Area
  // Check local storage and set Footer Style
  if (localStorage.footer == "sticky bottom-0") {
    $("#footer").addClass(localStorage.footer);
    $("#footer_sticky").prop("checked", true);
  } else if (localStorage.footer == "hidden") {
    $("#footer").addClass(localStorage.footer);
    $("#footer_hidden").prop("checked", true);
  } else {
    $("#footer").addClass("static");
    $("#footer_static").prop("checked", true);
  }
  // Footer Changing options
  $("#footer_static").on("change", function () {
    $("#footer").removeClass("sticky bottom-0").removeClass("hidden").addClass("static");
    localStorage.footer = "static";
  });
  $("#footer_sticky").on("change", function () {
    $("#footer").removeClass("static").removeClass("hidden").addClass("sticky bottom-0");
    localStorage.footer = "sticky bottom-0";
  });
  $("#footer_hidden").on("change", function () {
    $("#footer").removeClass("sticky bottom-0").removeClass("static").addClass("hidden");
    localStorage.footer = "hidden";
  });

  // RTL and LTR
  // Direction Type Local Storage
  if (localStorage.dir == "rtl") {
    $("#rtl_ltr input[type=checkbox]").prop("checked", true);
    $('#offcanvas').removeClass('offcanvas-end');
    $('#offcanvas').addClass('offcanvas-start');
  }

  // Change Direction
  $("#rtl_ltr input[type=checkbox]").on("click", function () {
    if ($("#rtl_ltr input[type=checkbox]").is(":checked")) {
      $("html").attr("dir", "rtl");
      localStorage.dir = "rtl";
      location.reload();
    } else {
      $("html").attr("dir", "ltr");
      localStorage.dir = "ltr";
      location.reload();
    }
  });

  /* =============================
  Small Device Buttons function
  ===============================*/
  $(".smallDeviceMenuController").on("click", function () {
    $(".sidebar-wrapper").toggleClass("menu-hide");
    $("#bodyOverlay").removeClass("hidden");
    $("body").addClass("overflow-hidden");
  });
  $(".sidebarCloseIcon, #bodyOverlay").on("click", function () {
    $(".sidebar-wrapper").toggleClass("menu-hide");
    $("#bodyOverlay").addClass("hidden");
    $("body").removeClass("overflow-hidden");
  });

  // Password Show Hide Toggle
  $("#toggleIcon").on("click", function () {
    var x = $(".passwordfield").attr("type");
    if (x === "password") {
      $(".passwordfield").prop("type", "text");
      $("#hidePassword").hide();
      $("#showPassword").show();
    } else {
      $(".passwordfield").prop("type", "password");
      $("#showPassword").hide();
      $("#hidePassword").show();
    }
  });


  /*===================================
   Plugin initialization
  =====================================*/
  // Sidebar Menu
  $.sidebarMenu($(".sidebar-menu"));

  // Simple Bar
  new SimpleBar($("#sidebar_menus, #scrollModal")[0]);

})(jQuery);