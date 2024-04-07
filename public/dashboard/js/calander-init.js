const date = new Date();
const prevDay = new Date().getDate() - 1;
const nextDay = new Date(new Date().getTime() + 24 * 60 * 60 * 1000);

// prettier-ignore
const nextMonth = date.getMonth() === 11 ? new Date(date.getFullYear() + 1, 0, 1) : new Date(date.getFullYear(), date.getMonth() + 1, 1)
// prettier-ignore
const prevMonth = date.getMonth() === 11 ? new Date(date.getFullYear() - 1, 0, 1) : new Date(date.getFullYear(), date.getMonth() - 1, 1)

let categories = [
  {
    label: "business",
    value: "business",
    activeClass: "ring-primary-500 bg-primary-500",
  },

  {
    label: "personal",
    value: "personal",
    activeClass: "ring-success-500 bg-success-500",
  },

  {
    label: "holiday",
    value: "holiday",
    activeClass: "ring-danger-500 bg-danger-500",
  },
  {
    label: "family",
    value: "family",
    activeClass: "ring-info-500 bg-info-500",
  },
  {
    label: "meeting",
    value: "meeting",
    activeClass: "ring-warning-500 bg-warning-500",
  },
  {
    label: "etc",
    value: "etc",
    activeClass: "ring-info-500 bg-info-500",
  },
];

let calendarEvents = [
  {
    id: 1,
    title: "All Day Event",
    start: date,
    end: nextDay,
    allDay: false,
    //className: "warning",
    extendedProps: {
      calendar: "business",
    },
  },
  {
    id: 2,
    title: "Meeting With Client",
    start: new Date(date.getFullYear(), date.getMonth() + 1, -11),
    end: new Date(date.getFullYear(), date.getMonth() + 1, -10),
    allDay: true,
    //className: "success",
    extendedProps: {
      calendar: "personal",
    },
  },
  {
    id: 3,
    title: "Lunch",
    allDay: true,
    start: new Date(date.getFullYear(), date.getMonth() + 1, -9),
    end: new Date(date.getFullYear(), date.getMonth() + 1, -7),
    // className: "info",
    extendedProps: {
      calendar: "family",
    },
  },
  {
    id: 4,
    title: "Birthday Party",
    start: new Date(date.getFullYear(), date.getMonth() + 1, -11),
    end: new Date(date.getFullYear(), date.getMonth() + 1, -10),
    allDay: true,
    //className: "primary",
    extendedProps: {
      calendar: "meeting",
    },
  },
  {
    id: 5,
    title: "Birthday Party",

    start: new Date(date.getFullYear(), date.getMonth() + 1, -13),
    end: new Date(date.getFullYear(), date.getMonth() + 1, -12),
    allDay: true,
    // className: "danger",
    extendedProps: {
      calendar: "holiday",
    },
  },
  {
    id: 6,
    title: "Monthly Meeting",
    start: nextMonth,
    end: nextMonth,
    allDay: true,
    //className: "primary",
    extendedProps: {
      calendar: "business",
    },
  },
];

const handleClassName = (arg) => {
  if (arg.event.extendedProps.calendar === "holiday") {
    return "danger";
  } else if (arg.event.extendedProps.calendar === "business") {
    return "primary";
  } else if (arg.event.extendedProps.calendar === "personal") {
    return "success";
  } else if (arg.event.extendedProps.calendar === "family") {
    return "info";
  } else if (arg.event.extendedProps.calendar === "etc") {
    return "info";
  } else if (arg.event.extendedProps.calendar === "meeting") {
    return "warning";
  }
};

let selectedCategories = categories.map((c) => c.value);

const allCheckbox = document.querySelector('input[value="all"]');
const categoryCheckboxes = document.getElementsByName("category");

// Check all checkboxes by default

for (let i = 0; i < categoryCheckboxes.length; i++) {
  categoryCheckboxes[i].checked = true;
}

// Add click event listener to "all" checkbox

allCheckbox?.addEventListener("click", function () {
  for (let i = 0; i < categoryCheckboxes.length; i++) {
    categoryCheckboxes[i].checked = this.checked;
  }
});

// Add click event listener to other checkboxes
for (let i = 0; i < categoryCheckboxes.length; i++) {
  categoryCheckboxes[i].addEventListener("click", function () {
    if (!this.checked) {
      allCheckbox.checked = false;
    } else {
      let allChecked = true;
      for (let j = 0; j < categoryCheckboxes.length; j++) {
        if (categoryCheckboxes[j] !== this && !categoryCheckboxes[j].checked) {
          allChecked = false;
          break;
        }
      }
      allCheckbox.checked = allChecked;
    }

    // Check if all checkboxes are checked
    let allChecked = true;
    for (let j = 0; j < categoryCheckboxes.length; j++) {
      if (
        categoryCheckboxes[j] !== allCheckbox &&
        !categoryCheckboxes[j].checked
      ) {
        allChecked = false;
        break;
      }
    }
    allCheckbox.checked = allChecked;
  });
}

const addEventModal = document.getElementById("addeventModal");
$(".close-event-modal").on("click", function () {
  $("#addeventModal").removeClass("open-add-modal");
});
$(".startdate").flatpickr({
  dateFormat: "Y-m-d",
  defaultDate: "today",
});
$(".enddate").flatpickr({
  dateFormat: "Y-m-d",
  defaultDate: "today",
});

const openDate = (info) => {
  addEventModal.classList.add("open-add-modal");

  // Add an event listener to the form submit button
  const title = (document.getElementById("event-title").value = "");
  const category = (document.getElementById("event-category").value = "");

  var selectedDate = ($(".startdate").flatpickr().selectedDates[0] = "");
  var endDate = ($(".enddate").flatpickr().selectedDates[0] = "");
  document
    .getElementById("add-event-form")
    .addEventListener("submit", function (e) {
      e.preventDefault();

      // Get the form data
      const title = document.getElementById("event-title").value;
      const category = document.getElementById("event-category").value;

      var selectedDate = $(".startdate").flatpickr().selectedDates[0];
      var endDate = $(".enddate").flatpickr().selectedDates[0];

      // Add the new event to the calendar
      calendar.addEvent({
        id: calendarEvents.length + 10,
        title: title,
        start: selectedDate,
        end: endDate,
        allDay: true,
        extendedProps: {
          calendar: category,
        },
      });

      // Close the add event modal
      addEventModal.classList.remove("open-add-modal");
      // Reset the form
      document.getElementById("add-event-form").reset();
    });
};
$(".add-event").on("click", function () {
  openDate();
});

var calendarEl = document.getElementById("full-calander-active");

if (calendarEl) {
  var calendar = new FullCalendar.Calendar(calendarEl, {
    headerToolbar: {
      left: "prev,next today",
      center: "title",
      right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek",
    },
    initialView: "dayGridMonth",
    events: calendarEvents,
    editable: true,
    selectable: true,
    selectMirror: true,
    dayMaxEvents: 2,
    weekends: true,
    dateClick: (info) => {
      openDate(info);
    },
    eventClick: (info) => {
      const event = info.event;

      document.getElementById("event-title").value = event.title;
      document.getElementById("event-start-date").value = event.start;
      document.getElementById("event-end-date").value = event.end;
      document.getElementById("event-category").value =
        event.extendedProps.calendar;

      addEventModal.classList.add("open-add-modal");
      document
        .getElementById("add-event-form")
        .addEventListener("submit", function (e) {
          e.preventDefault();
          addEventModal.classList.remove("open-add-modal");

          // get values
          var title = document.getElementById("event-title").value;
          var startDate = document.getElementById("event-start-date").value;
          var endDate = document.getElementById("event-end-date").value;
          var category = document.getElementById("event-category").value;
          // update the data of the clicked event
          event.setProp("title", title);
          event.setStart(startDate);
          event.setEnd(endDate);
          event.setExtendedProp("calendar", category);

          document.getElementById("add-event-form").reset();
        });
    },
    eventClassNames: handleClassName,
  });
  calendar.render();
}

// Filter events based on checkbox selection
for (let i = 0; i < categoryCheckboxes.length; i++) {
  categoryCheckboxes[i].addEventListener("click", function () {
    let selectedCategories = [];
    for (let j = 0; j < categoryCheckboxes.length; j++) {
      if (categoryCheckboxes[j].checked) {
        selectedCategories.push(categoryCheckboxes[j].value);
      }
    }
    calendar.getEvents().forEach(function (event) {
      if (selectedCategories.includes(event.extendedProps.calendar)) {
        event.setProp("display", "auto");
      } else {
        event.setProp("display", "none");
      }
    });
  });
}
