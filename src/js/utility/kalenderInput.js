/*
  Author: Jack Ducasse;
  Version: 0.1.0;
  (â— â€¿â— âœ¿)
*/
{
var Calendar = function (model, options, date) {
  // Default Values
  this.Options = {
    Color: "",
    LinkColor: "",
    NavShow: true,
    NavVertical: false,
    NavLocation: "",
    DateTimeShow: true,
    DateTimeFormat: "mmm, yyyy",
    DatetimeLocation: "",
    EventClick: "",
    EventTargetWholeDay: false,
    DisabledDays: [],
    ModelChange: model,
  };
  // Overwriting default values
  for (var key in options) {
    this.Options[key] =
      typeof options[key] == "string"
        ? options[key].toLowerCase()
        : options[key];
  }

  model ? (this.Model = model) : (this.Model = {});
  this.Today = new Date();

  this.Selected = this.Today;
  this.Today.Month = this.Today.getMonth();
  this.Today.Year = this.Today.getFullYear();
  if (date) {
    this.Selected = date;
  }
  this.Selected.Month = this.Selected.getMonth();
  this.Selected.Year = this.Selected.getFullYear();

  this.Selected.Days = new Date(
    this.Selected.Year,
    this.Selected.Month + 1,
    0
  ).getDate();
  this.Selected.FirstDay = new Date(
    this.Selected.Year,
    this.Selected.Month,
    1
  ).getDay();
  this.Selected.LastDay = new Date(
    this.Selected.Year,
    this.Selected.Month + 1,
    0
  ).getDay();

  this.Prev = new Date(this.Selected.Year, this.Selected.Month - 1, 1);
  if (this.Selected.Month == 0) {
    this.Prev = new Date(this.Selected.Year - 1, 11, 1);
  }
  this.Prev.Days = new Date(
    this.Prev.getFullYear(),
    this.Prev.getMonth() + 1,
    0
  ).getDate();
};

function createCalendar(calendar, element, adjuster) {
  if (typeof adjuster !== "undefined") {
    var newDate = new Date(
      calendar.Selected.Year,
      calendar.Selected.Month + adjuster,
      1
    );
    calendar = new Calendar(calendar.Model, calendar.Options, newDate);
    element.innerHTML = "";
  } else {
    for (var key in calendar.Options) {
      typeof calendar.Options[key] != "function" &&
      typeof calendar.Options[key] != "object" &&
      calendar.Options[key]
        ? (element.className += " " + key + "-" + calendar.Options[key])
        : 0;
    }
  }
  var months = [
    "Januari",
    "Februari",
    "Maart",
    "April",
    "Mei",
    "Juni",
    "Juli",
    "Augustus",
    "September",
    "Oktober",
    "November",
    "December",
  ];

  function AddSidebar() {
    var sidebar = document.createElement("div");
    sidebar.className += "Icld-sidebar";

    var monthList = document.createElement("ul");
    monthList.className += "Icld-monthList";

    for (var i = 0; i < months.length - 3; i++) {
      var x = document.createElement("li");
      x.className += "Icld-month";
      var n = i - (4 - calendar.Selected.Month);
      // Account for overflowing month values
      if (n < 0) {
        n += 12;
      } else if (n > 11) {
        n -= 12;
      }
      // Add Appropriate Class
      if (i == 0) {
        x.className += " Icld-rwd Icld-nav";
        x.addEventListener("click", function () {
          typeof calendar.Options.ModelChange == "function"
            ? (calendar.Model = calendar.Options.ModelChange())
            : (calendar.Model = calendar.Options.ModelChange);
          createCalendar(calendar, element, -1);
        });
        x.innerHTML +=
          '<svg height="15" width="15" viewBox="0 0 100 75" fill="rgba(255,255,255,0.5)"><polyline points="0,75 100,75 50,0"></polyline></svg>';
      } else if (i == months.length - 4) {
        x.className += " Icld-fwd Icld-nav";
        x.addEventListener("click", function () {
          typeof calendar.Options.ModelChange == "function"
            ? (calendar.Model = calendar.Options.ModelChange())
            : (calendar.Model = calendar.Options.ModelChange);
          createCalendar(calendar, element, 1);
        });
        x.innerHTML +=
          '<svg height="15" width="15" viewBox="0 0 100 75" fill="rgba(255,255,255,0.5)"><polyline points="0,0 100,0 50,75"></polyline></svg>';
      } else {
        if (i < 4) {
          x.className += " Icld-pre";
        } else if (i > 4) {
          x.className += " Icld-post";
        } else {
          x.className += " Icld-curr";
        }

        //prevent losing var adj value (for whatever reason that is happening)
        (function () {
          var adj = i - 4;
          //x.addEventListener('click', function(){createCalendar(calendar, element, adj);console.log('kk', adj);} );
          x.addEventListener("click", function () {
            typeof calendar.Options.ModelChange == "function"
              ? (calendar.Model = calendar.Options.ModelChange())
              : (calendar.Model = calendar.Options.ModelChange);
            createCalendar(calendar, element, adj);
          });
          x.setAttribute("style", "opacity:" + (1 - Math.abs(adj) / 4));
          x.innerHTML += months[n].substr(0, 3);
        })(); // immediate invocation

        if (n == 0) {
          var y = document.createElement("li");
          y.className += "Icld-year";
          if (i < 5) {
            y.innerHTML += calendar.Selected.Year;
          } else {
            y.innerHTML += calendar.Selected.Year + 1;
          }
          monthList.appendChild(y);
        }
      }
      monthList.appendChild(x);
    }
    sidebar.appendChild(monthList);
    if (calendar.Options.NavLocation) {
      document.getElementById(calendar.Options.NavLocation).innerHTML = "";
      document
        .getElementById(calendar.Options.NavLocation)
        .appendChild(sidebar);
    } else {
      element.appendChild(sidebar);
    }
  }

  var mainSection = document.createElement("div");
  mainSection.className += "Icld-main";
  mainSection.className += " Icld-mainInput";

  function AddDateTime() {
    var datetime = document.createElement("div");
    datetime.className += "Icld-datetime";
    if (calendar.Options.NavShow && !calendar.Options.NavVertical) {
      var rwd = document.createElement("div");
      rwd.className += " Icld-rwd Icld-nav";
      rwd.addEventListener("click", function () {
        createCalendar(calendar, element, -1);
        makeSelectDate();
      });
      rwd.innerHTML =
        '<svg height="15" width="15" viewBox="0 0 75 100" fill="rgba(0,0,0,0.5)"><polyline points="0,50 75,0 75,100"></polyline></svg>';
      datetime.appendChild(rwd);
    }
    var today = document.createElement("div");
    today.className += " today";
    today.innerHTML =
      months[calendar.Selected.Month] + ", " + calendar.Selected.Year;
    datetime.appendChild(today);
    if (calendar.Options.NavShow && !calendar.Options.NavVertical) {
      var fwd = document.createElement("div");
      fwd.className += " Icld-fwd Icld-nav";
      fwd.addEventListener("click", function () {
        createCalendar(calendar, element, 1);
        makeSelectDate();
      });
      fwd.innerHTML =
        '<svg height="15" width="15" viewBox="0 0 75 100" fill="rgba(0,0,0,0.5)"><polyline points="0,0 75,50 0,100"></polyline></svg>';
      datetime.appendChild(fwd);
    }
    if (calendar.Options.DatetimeLocation) {
      document.getElementById(calendar.Options.DatetimeLocation).innerHTML = "";
      document
        .getElementById(calendar.Options.DatetimeLocation)
        .appendChild(datetime);
    } else {
      mainSection.appendChild(datetime);
    }
  }

  function AddLabels() {
    var labels = document.createElement("ul");
    labels.className = "Icld-labels";
    var labelsList = ["Zo", "Ma", "Di", "Wo", "Do", "Vr", "Za"];
    for (var i = 0; i < labelsList.length; i++) {
      var label = document.createElement("li");
      label.className += "Icld-label";
      label.innerHTML = labelsList[i];
      labels.appendChild(label);
    }
    mainSection.appendChild(labels);
  }
  function AddDays() {
    // Create Number Element
    function DayNumber(n) {
      var number = document.createElement("p");
      number.className += "Icld-numberT";
      number.innerHTML += n;
      return number;
    }
    var days = document.createElement("ul");
    days.className += "Icld-days";
    // Previous Month's Days
    for (var i = 0; i < calendar.Selected.FirstDay; i++) {
      var day = document.createElement("li");
      day.className += "Icld-day prevMonth";
      //Disabled Days
      var d = i % 7;
      for (var q = 0; q < calendar.Options.DisabledDays.length; q++) {
        if (d == calendar.Options.DisabledDays[q]) {
          day.className += " disableDay";
        }
      }

      var number = DayNumber(
        calendar.Prev.Days - calendar.Selected.FirstDay + (i + 1)
      );
      day.appendChild(number);

      days.appendChild(day);
    }
    // Current Month's Days
    for (var i = 0; i < calendar.Selected.Days; i++) {
      var day = document.createElement("li");
      day.className += "Icld-day currMonth";
      //Disabled Days
      var d = (i + calendar.Selected.FirstDay) % 7;
      for (var q = 0; q < calendar.Options.DisabledDays.length; q++) {
        if (d == calendar.Options.DisabledDays[q]) {
          day.className += " disableDay";
        }
      }
      var number = DayNumber(i + 1);
      // Check Date against Event Dates
      for (var n = 0; n < calendar.Model.length; n++) {
        var evDate = calendar.Model[n].Date;
        var toDate = new Date(
          calendar.Selected.Year,
          calendar.Selected.Month,
          i + 1
        );
        if (evDate.getTime() == toDate.getTime()) {
          number.className += " eventday";
          var title = document.createElement("span");
          title.className += "Icld-title";
          if (
            typeof calendar.Model[n].Link == "function" ||
            calendar.Options.EventClick
          ) {
            var a = document.createElement("a");
            a.setAttribute("href", "#");
            a.innerHTML += calendar.Model[n].Title;
            if (calendar.Options.EventClick) {
              var z = calendar.Model[n].Link;
              if (typeof calendar.Model[n].Link != "string") {
                a.addEventListener(
                  "click",
                  calendar.Options.EventClick.bind.apply(
                    calendar.Options.EventClick,
                    [null].concat(z)
                  )
                );
                if (calendar.Options.EventTargetWholeDay) {
                  day.className += " clickable";
                  day.addEventListener(
                    "click",
                    calendar.Options.EventClick.bind.apply(
                      calendar.Options.EventClick,
                      [null].concat(z)
                    )
                  );
                }
              } else {
                a.addEventListener(
                  "click",
                  calendar.Options.EventClick.bind(null, z)
                );
                if (calendar.Options.EventTargetWholeDay) {
                  day.className += " clickable";
                  day.addEventListener(
                    "click",
                    calendar.Options.EventClick.bind(null, z)
                  );
                }
              }
            } else {
              a.addEventListener("click", calendar.Model[n].Link);
              if (calendar.Options.EventTargetWholeDay) {
                day.className += " clickable";
                day.addEventListener("click", calendar.Model[n].Link);
              }
            }
            title.appendChild(a);
          } else {
            title.innerHTML +=
              '<a href="' +
              calendar.Model[n].Link +
              '">' +
              calendar.Model[n].Title +
              "</a>";
          }
        }
      }
      day.appendChild(number);
      // If Today..
      if (
        i + 1 == calendar.Today.getDate() &&
        calendar.Selected.Month == calendar.Today.Month &&
        calendar.Selected.Year == calendar.Today.Year
      ) {
        day.className += " dateselected";
      }
      days.appendChild(day);
    }
    // Next Month's Days
    // Always same amount of days in calander
    var extraDays = 13;
    if (days.children.length > 35) {
      extraDays = 6;
    } else if (days.children.length < 29) {
      extraDays = 20;
    }

    for (var i = 0; i < extraDays - calendar.Selected.LastDay; i++) {
      var day = document.createElement("li");
      day.className += "Icld-day nextMonth";
      //Disabled Days
      var d = (i + calendar.Selected.LastDay + 1) % 7;
      for (var q = 0; q < calendar.Options.DisabledDays.length; q++) {
        if (d == calendar.Options.DisabledDays[q]) {
          day.className += " disableDay";
        }
      }

      var number = DayNumber(i + 1);
      day.appendChild(number);

      days.appendChild(day);
    }
    mainSection.appendChild(days);
  }
  if (calendar.Options.Color) {
    mainSection.innerHTML +=
      "<style>.Icld-main{color:" + calendar.Options.Color + ";}</style>";
  }
  if (calendar.Options.LinkColor) {
    mainSection.innerHTML +=
      "<style>.Icld-title a{color:" + calendar.Options.LinkColor + ";}</style>";
  }
  element.appendChild(mainSection);

  if (calendar.Options.NavShow && calendar.Options.NavVertical) {
    AddSidebar();
  }
  if (calendar.Options.DateTimeShow) {
    AddDateTime();
  }
  AddLabels();
  AddDays();
}

function caleandarX(el, data, settings) {
  var obj = new Calendar(data, settings);
  createCalendar(obj, el);
}

const selectDate = (e) =>{
  makeSelectDate();
  console.log(e.currentTarget.innerHTML);
  if((e.currentTarget.innerHTML.trim()).length == 1){
    e.currentTarget.innerHTML = '0'+e.currentTarget.innerHTML;
  }
  e.currentTarget.parentNode.classList.add('dateselected');
  const inputDate_text = document.querySelector('.inputDate_text');
  inputDate_text.innerHTML = e.currentTarget.innerHTML + ' ' + document.querySelector('.today').innerHTML + ' - ' + document.querySelector('.timeInput').value;
  document.querySelector('.toevoegen_overzicht_datum').innerHTML = 'Datum: ' + inputDate_text.innerHTML;

  //Number of selected date
  selectedDateTextNumber = (document.querySelector('.inputDate_text').innerHTML).substring(0,2);
  //Month of selected date
  selectedDateTextMonth = (document.querySelector('.inputDate_text').innerHTML).substring((document.querySelector('.inputDate_text').innerHTML).indexOf(' ')+1);
  selectedDateTextMonth = selectedDateTextMonth.substring(0,selectedDateTextMonth.indexOf(' -'));
}

let selectedDateTextNumber = '';
let selectedDateTextMonth = '';
const changeTime = () =>{
  document.querySelector('.inputDate_text').innerHTML = (document.querySelector('.inputDate_text').innerHTML).slice(0,-5) + document.querySelector('.timeInput').value;
  document.querySelector('.toevoegen_overzicht_datum').innerHTML = (document.querySelector('.toevoegen_overzicht_datum').innerHTML).slice(0,-5) + document.querySelector('.timeInput').value;
}

let events = [];

makeSelectDate = () =>{
  if(document.querySelector('.dateselected')){
    const selectes = Array.from(document.querySelectorAll('.dateselected'));

    for (let x = 0; x < selectes.length; x++) {
      selectes[x].classList.remove('dateselected');
    }
  }
  const numberDate = Array.from(document.querySelectorAll('.Icld-numberT'));
  for (let i = 0; i < numberDate.length; i++) {
    numberDate[i].addEventListener('click', selectDate);
  }
  if(document.querySelector('.today').innerHTML == selectedDateTextMonth){
    const dateNumbers = Array.from(document.querySelectorAll('.Icld-numberT'));
    for (let i = 0; i < dateNumbers.length; i++) {
      if(dateNumbers[i].innerHTML == selectedDateTextNumber){
        if(!(dateNumbers[i].parentNode.classList.contains('nextMonth'))){
          const selectes = Array.from(document.querySelectorAll('.dateselected'));

          for (let a = 0; a < selectes.length; a++) {
            selectes[a].classList.remove('dateselected');
          }
          dateNumbers[i].parentNode.classList.add('dateselected');
          //const selectesX = Array.from(document.querySelectorAll('.dateselected'));
          //selectesX[0].classList.remove('dateselected');
        }
      }
    }
  }
}

const init = () =>{

let currentPage = (window.location.href).split('?')[1];
    if(currentPage === "page=opdrachttoevoegen" && typeof currentPage !== "undefined"){
    const settings = {};
    const element = document.getElementById("caleandarInput");
    element.classList.add('kalenderInput')
    caleandarX(element, events, settings);
    makeSelectDate();
    document.querySelector('.timeInput').addEventListener('change', changeTime);
    document.querySelector('.Icld-rwd').addEventListener('click', makeSelectDate);
    document.querySelector('.Icld-fwd').addEventListener('click', makeSelectDate);
    }
}
init();
}
