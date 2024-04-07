"use strict";

/****** ****************
 * add current theme *
 **********************/
var root = document.getElementsByTagName('html')[0];
if (localStorage.theme) {
  var currentTheme = localStorage.theme;
  if (currentTheme == 'dark') {
    root.classList.add(currentTheme);
    root.classList.remove('light');
    root.classList.remove('semiDark');
  } else if (currentTheme == 'semiDark') {
    root.classList.add(currentTheme);
    root.classList.add('light');
  } else {
    root.classList.add(currentTheme);
    root.classList.remove('dark');
    root.classList.remove('semiDark');
  }
}

/****** ****************
 * add grayscale theme *
 **********************/
if (localStorage.effect == "grayScale") {
  document.documentElement.classList.add(localStorage.effect);
  root.classList.add(localStorage.effect);
}

// Direction Type Local Storage
if (localStorage.dir == "rtl") {
  root.setAttribute("dir", localStorage.dir);
} else if (localStorage.dir == "ltr") {
  root.setAttribute("dir", localStorage.dir);
}