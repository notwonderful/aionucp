const todoFilters = document.querySelectorAll(".todo-categories li");
const todoListItems = document.querySelectorAll(".todo-list li");
const todoDeleteButtons = document.querySelectorAll(".delete-button");
const todoNoResult = document.getElementById("no-result");

const todoSearch = document.querySelector("#todo-search");
const todoSidebar = document.querySelector(".todo-sidebar");
const todoSidebarMenu = document.querySelector(".open-sidebar");
const todooverlay = document.querySelector(".todo-todooverlay");

if (todoNoResult) {
  todoNoResult.style.display = "none";
}
// mobile sidebar
if (window.innerWidth <= 1024) {
  todoSidebar?.classList.add("enter-lg");
}
todoSidebarMenu?.addEventListener("click", function () {
  todoSidebar?.classList.toggle("active");
  todooverlay?.classList.toggle("active");
});
// todooverlay for mobile
todooverlay?.addEventListener("click", function () {
  todoSidebar?.classList.toggle("active");
  todooverlay.classList.toggle("active");
});

window.addEventListener("resize", function () {
  if (window.innerWidth <= 1024) {
    todoSidebar?.classList.add("enter-lg");
  } else {
    todoSidebar?.classList.remove("enter-lg");
  }
});

// todo search
todoSearch?.addEventListener("keyup", function () {
  const searchText = todoSearch.value.trim().toLowerCase();
  let visibleItemCount = 0;
  for (let i = 0; i < todoListItems.length; i++) {
    const todoListItemText = todoListItems[i].textContent.trim().toLowerCase();
    if (searchText === "" || todoListItemText.indexOf(searchText) >= 0) {
      todoListItems[i].style.display = "";
      visibleItemCount++;
    } else {
      todoListItems[i].style.display = "none";
    }
  }
  if (visibleItemCount === 0) {
    todoNoResult.style.display = "block";
  } else {
    todoNoResult.style.display = "none";
  }
});

for (let i = 0; i < todoFilters.length; i++) {
  todoFilters[i].addEventListener("click", function () {
    // check sidebar for mobile
    if (todoSidebar.classList.contains("active")) {
      todoSidebar.classList.remove("active");
      todooverlay.classList.remove("active");
    }
    // Remove the active class from all filters
    for (let j = 0; j < todoFilters.length; j++) {
      todoFilters[j].classList.remove("active");
    }
    // Add the active class to the clicked filter
    todoFilters[i].classList.add("active");
    const statusFilter = todoFilters[i].getAttribute("data-status");
    for (let j = 0; j < todoListItems.length; j++) {
      const todoListItemStatus = todoListItems[j].getAttribute("data-status");
      if (
        todoListItemStatus &&
        (statusFilter === "all" ||
          todoListItemStatus.indexOf(statusFilter) >= 0)
      ) {
        todoListItems[j].style.display = "";
      } else {
        todoListItems[j].style.display = "none";
      }
    }
  });
}

// Add event listener to the star icons
const todoStarIcons = document.querySelectorAll(".todo-list li .todo-fav");
for (let i = 0; i < todoStarIcons.length; i++) {
  todoStarIcons[i].addEventListener("click", function (e) {
    const todoListItem = todoStarIcons[i].parentNode;
    const statusArray = todoListItem.getAttribute("data-status").split(",");
    const staredIndex = statusArray.indexOf("stared");
    if (staredIndex >= 0) {
      statusArray.splice(staredIndex, 1);
    } else {
      statusArray.push("stared");
    }
    todoListItem.setAttribute("data-status", statusArray.join(","));
    todoListItem.setAttribute(
      "data-stared",
      statusArray.indexOf("stared") >= 0
    );
    const activeFilter = document.querySelector(".todo-categories li.active");
    const statusFilter = activeFilter.getAttribute("data-status");
    if (
      statusFilter !== "all" &&
      todoListItem.getAttribute("data-status").indexOf(statusFilter) === -1
    ) {
      todoListItem.style.display = "none";
    } else {
      todoListItem.style.display = "";
    }
    e.stopPropagation();
  });
}

// delete todo
for (let i = 0; i < todoDeleteButtons.length; i++) {
  todoDeleteButtons[i].addEventListener("click", function (e) {
    const parentListItem = todoDeleteButtons[i].closest("li");
    parentListItem.remove();
    e.stopPropagation();
  });
}

//  Add event listener to the checkbox
const todoIsDoneCheckbox = document.getElementsByName("todo-checkbox");

for (let i = 0; i < todoIsDoneCheckbox.length; i++) {
  const checkbox = todoIsDoneCheckbox[i];
  const todoListItem = checkbox.parentNode;

  const statusArray = todoListItem.getAttribute("data-status").split(",");
  const isComplete = statusArray.indexOf("done") >= 0;

  checkbox.checked = isComplete;
  todoListItem.setAttribute("data-complete", isComplete);

  if (isComplete) {
    todoListItem.classList.add("completed");
  }

  checkbox.addEventListener("click", function (e) {
    const staredIndex = statusArray.indexOf("done");
    const isChecked = checkbox.checked;

    if (staredIndex >= 0) {
      statusArray.splice(staredIndex, 1);
      checkbox.checked = false;
    } else {
      statusArray.push("done");
      checkbox.checked = true;
    }

    todoListItem.setAttribute("data-status", statusArray.join(","));
    todoListItem.setAttribute(
      "data-complete",
      statusArray.indexOf("done") >= 0
    );

    if (isChecked) {
      todoListItem.classList.add("completed");
    } else {
      todoListItem.classList.remove("completed");
    }

    const activeFilter = document.querySelector(".todo-categories li.active");
    const statusFilter = activeFilter.getAttribute("data-status");

    if (
      statusFilter !== "all" &&
      todoListItem.getAttribute("data-status").indexOf(statusFilter) === -1
    ) {
      todoListItem.style.display = "none";
    } else {
      todoListItem.style.display = "";
    }
  });
}
