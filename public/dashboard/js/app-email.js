const emailFilters = document.querySelectorAll(".email-categories li");
const emailListItems = document.querySelectorAll(".email-list li");
const deleteButtons = document.querySelectorAll(".delete-button");
const noResult = document.getElementById("no-result");
const singleEmail = $("#single-email");
const closeEmail = $(".close-email");
const emailSearch = document.querySelector("#email-search");
const emailSidebar = document.querySelector(".email-sidebar");
const sidebarMenu = document.querySelector(".open-sidebar");
const overlay = document.querySelector(".email-overlay");
singleEmail.hide();
if (noResult) {
  noResult.style.display = "none";
}
// mobile sidebar
if (window.innerWidth <= 1024) {
  emailSidebar?.classList.add("enter-lg");
}
sidebarMenu?.addEventListener("click", function () {
  emailSidebar?.classList.toggle("active");
  overlay.classList.toggle("active");
});
// overlay for mobile
overlay?.addEventListener("click", function () {
  emailSidebar?.classList.toggle("active");
  overlay.classList.toggle("active");
});

window.addEventListener("resize", function () {
  if (window.innerWidth <= 1024) {
    emailSidebar?.classList.add("enter-lg");
  } else {
    emailSidebar?.classList.remove("enter-lg");
  }
});

// email search
emailSearch?.addEventListener("keyup", function () {
  const searchText = emailSearch.value.trim().toLowerCase();
  let visibleItemCount = 0;
  for (let i = 0; i < emailListItems.length; i++) {
    const emailListItemText = emailListItems[i].textContent
      .trim()
      .toLowerCase();
    if (searchText === "" || emailListItemText.indexOf(searchText) >= 0) {
      emailListItems[i].style.display = "";
      visibleItemCount++;
    } else {
      emailListItems[i].style.display = "none";
    }
  }
  if (visibleItemCount === 0) {
    noResult.style.display = "block";
  } else {
    noResult.style.display = "none";
  }
});

for (let i = 0; i < emailFilters.length; i++) {
  emailFilters[i].addEventListener("click", function () {
    // check sidebar for mobile
    if (emailSidebar.classList.contains("active")) {
      emailSidebar.classList.remove("active");
      overlay.classList.remove("active");
    }
    // Remove the active class from all filters
    for (let j = 0; j < emailFilters.length; j++) {
      emailFilters[j].classList.remove("active");
    }
    // Add the active class to the clicked filter
    emailFilters[i].classList.add("active");
    const statusFilter = emailFilters[i].getAttribute("data-status");
    for (let j = 0; j < emailListItems.length; j++) {
      const emailListItemStatus = emailListItems[j].getAttribute("data-status");
      if (
        emailListItemStatus &&
        (statusFilter === "all" ||
          emailListItemStatus.indexOf(statusFilter) >= 0)
      ) {
        emailListItems[j].style.display = "";
      } else {
        emailListItems[j].style.display = "none";
      }
    }
  });
}

// Add event listener to the star icons
const starIcons = document.querySelectorAll(".email-list li .email-fav");
for (let i = 0; i < starIcons.length; i++) {
  starIcons[i].addEventListener("click", function (e) {
    const emailListItem = starIcons[i].parentNode;
    const statusArray = emailListItem.getAttribute("data-status").split(",");
    const staredIndex = statusArray.indexOf("stared");
    if (staredIndex >= 0) {
      statusArray.splice(staredIndex, 1);
    } else {
      statusArray.push("stared");
    }
    emailListItem.setAttribute("data-status", statusArray.join(","));
    emailListItem.setAttribute(
      "data-stared",
      statusArray.indexOf("stared") >= 0
    );
    const activeFilter = document.querySelector(".email-categories li.active");
    const statusFilter = activeFilter.getAttribute("data-status");
    if (
      statusFilter !== "all" &&
      emailListItem.getAttribute("data-status").indexOf(statusFilter) === -1
    ) {
      emailListItem.style.display = "none";
    } else {
      emailListItem.style.display = "";
    }
    e.stopPropagation();
  });
}
for (let i = 0; i < emailListItems.length; i++) {
  emailListItems[i].addEventListener("click", function () {
    emailListItems[i].classList.add("opened");
    singleEmail.show();
  });
}

// close email
closeEmail.on("click", function () {
  singleEmail.hide();
});
// delete email
for (let i = 0; i < deleteButtons.length; i++) {
  deleteButtons[i].addEventListener("click", function (e) {
    const parentListItem = deleteButtons[i].closest("li");
    parentListItem.remove();
    e.stopPropagation();
  });
}
// all check email
const allEmailCheckbox = document.getElementById("email-select-all");
const emailCheckbox = document.getElementsByName("email-checkbox");

allEmailCheckbox?.addEventListener("click", function () {
  for (let i = 0; i < emailCheckbox.length; i++) {
    emailCheckbox[i].checked = this.checked;
  }
});

// Add click event listener to other checkboxes
for (let i = 0; i < emailCheckbox.length; i++) {
  emailCheckbox[i].addEventListener("click", function (e) {
    e.stopPropagation();
    if (!this.checked) {
      allEmailCheckbox.checked = false;
      allEmailCheckbox.indeterminate = true;
    } else {
      let allChecked = true;
      for (let j = 0; j < emailCheckbox.length; j++) {
        if (emailCheckbox[j] !== this && !emailCheckbox[j].checked) {
          allChecked = false;
          allEmailCheckbox.indeterminate = false;
          break;
        }
      }
      allEmailCheckbox.checked = allChecked;
    }

    // Check if all checkboxes are checked
    let allChecked = true;
    for (let j = 0; j < emailCheckbox.length; j++) {
      if (emailCheckbox[j] !== allEmailCheckbox && !emailCheckbox[j].checked) {
        allChecked = false;
        break;
      }
    }
    allEmailCheckbox.checked = allChecked;
  });
}
// fav click for email
const favCheckbox = document.getElementsByName("fav-checkbox");
favCheckbox.forEach((item) => {
  item.addEventListener("click", function (e) {
    e.stopPropagation();
    console.log("sss");
  });
});
