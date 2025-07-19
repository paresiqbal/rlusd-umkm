(function () {

  'use strict';

  // MetisMenu js
  function initMetisMenu() {
    // MetisMenu js
    if (document.getElementById("side-menu")) {
      console.log('+++ loaded',);
      new MetisMenu('#side-menu');
    }

  }

  // initLeftMenuCollapse
  function initLeftMenuCollapse() {
    var currentSIdebarSize = document.body.getAttribute('data-sidebar-size');
    window.onload = function () {
      if (window.innerWidth >= 1024 && window.innerWidth <= 1366) {
        document.body.setAttribute('data-sidebar-size', 'sm');
        updateRadio('sidebar-size-small')
      }
    }
    var verticalButton = document.getElementsByClassName("vertical-menu-btn");
    for (var i = 0; i < verticalButton.length; i++) {
      (function (index) {
        verticalButton[index] && verticalButton[index].addEventListener('click', function (event) {
          event.preventDefault();
          document.body.classList.toggle('sidebar-enable');
          if (window.innerWidth >= 992) {
            if (currentSIdebarSize == null) {
              (document.body.getAttribute('data-sidebar-size') == null || document.body.getAttribute('data-sidebar-size') == "lg") ? document.body.setAttribute('data-sidebar-size', 'sm') : document.body.setAttribute('data-sidebar-size', 'lg')
            } else if (currentSIdebarSize == "md") {
              (document.body.getAttribute('data-sidebar-size') == "md") ? document.body.setAttribute('data-sidebar-size', 'sm') : document.body.setAttribute('data-sidebar-size', 'md')
            } else {
              (document.body.getAttribute('data-sidebar-size') == "sm") ? document.body.setAttribute('data-sidebar-size', 'lg') : document.body.setAttribute('data-sidebar-size', 'sm')
            }
          } else {
            initMenuItemScroll();
          }
        });
      })(i);
    }
  }

  // menu active
  function initActiveMenu() {
    var menuItems = document.querySelectorAll("#sidebar-menu a");
    menuItems && menuItems.forEach(function (item) {
      var pageUrl = window.location.href.split(/[?#]/)[0];

      if (item.href == pageUrl) {
        item.classList.add("active");
        var parent = item.parentElement;
        if (parent && parent.id !== "side-menu") {
          parent.classList.add("mm-active");
          var parent2 = parent.parentElement; // ul .
          if (parent2 && parent2.id !== "side-menu") {
            parent2.classList.add("mm-show"); // ul tag
            var parent3 = parent2.parentElement; // li tag
            if (parent3 && parent3.id !== "side-menu") {
              parent3.classList.add("mm-active"); // li
              var parent4 = parent3.parentElement; // ul
              if (parent4 && parent4.id !== "side-menu") {
                parent4.classList.add("mm-show"); // ul
                var parent5 = parent4.parentElement;
                if (parent5 && parent5.id !== "side-menu") {
                  parent5.classList.add("mm-active"); // li
                }
              }
            }
          }
        }
      }
    });
  }


  // sidebarMenu

  function initMenuItemScroll() {
    setTimeout(function () {
      var sidebarMenu = document.getElementById("side-menu");
      if (sidebarMenu) {
        var activeMenu = sidebarMenu.querySelector(".mm-active .active");
        var offset = activeMenu ? activeMenu.offsetTop : 0;
        if (offset > 300) {
          var verticalMenu = document.getElementsByClassName("vertical-menu") ? document.getElementsByClassName("vertical-menu")[0] : "";
          if (verticalMenu && verticalMenu.querySelector(".simplebar-content-wrapper")) {
            setTimeout(function () {
              offset == 330 ?
                (verticalMenu.querySelector(".simplebar-content-wrapper").scrollTop = offset + 85) :
                (verticalMenu.querySelector(".simplebar-content-wrapper").scrollTop = offset);
            }, 0);
          }
        }
      }
    }, 250);
  }

  function init() {
    initMetisMenu();
    initLeftMenuCollapse();
    initActiveMenu();
    initMenuItemScroll();
  }

  // init();

})();


//  My Custom Sidebar Handler Start *********

// on initialize
function hideSidebar() {
  const sidebarBrand = document.querySelector('.topbar-brand')
  const sidebar = document.querySelector('#dashboard-sidebar')
  const pageContent = document.querySelector('.page-content')

  sidebar.classList.remove('fixed')
  sidebar.classList.add('hidden')
  sidebarBrand.classList.remove('flex')
  sidebarBrand.classList.add('hidden')
  pageContent.classList.remove('ml-64')

}

if (document.body.clientWidth <= 960) {
  hideSidebar()
}

// on resize
window.addEventListener('resize', (e) => {
  const windowWidth = document.body.clientWidth

  if (windowWidth <= 960) {
    hideSidebar()
  }
})

function sidebarToggle(e) {
  const sidebarBrand = document.querySelector('.topbar-brand')
  const sidebar = document.querySelector('#dashboard-sidebar')
  const pageContent = document.querySelector('.page-content')

  pageContent.classList.toggle('ml-64')

  if (sidebar.classList.contains('fixed')) {
    sidebar.classList.remove('fixed')
    sidebar.classList.add('hidden')
  } else if (sidebar.classList.contains('hidden')) {
    sidebar.classList.remove('hidden')
    sidebar.classList.add('fixed')
  }

  if (sidebarBrand.classList.contains('flex')) {
    sidebarBrand.classList.remove('flex')
    sidebarBrand.classList.add('hidden')
  } else if (sidebarBrand.classList.contains('hidden')) {
    sidebarBrand.classList.remove('hidden')
    sidebarBrand.classList.add('flex')
  }

}

// active link

const currentActive = window.location.pathname.split('/')
  .filter(item => item != '').slice(0, 2).join('-')

const sidebarLinks = Array.from(document.querySelectorAll('#side-menu a'))
sidebarLinks.forEach(sidebarItem => {
  const linkname = sidebarItem.dataset.linkname
  if (currentActive == linkname) {
    sidebarItem.classList.add('text-violet-500')
  }
})

// My Custom Sidebar Handler End *********



/********* Alert common js *********/

// alert dismissible
if (document.querySelectorAll('.alert-dismissible')) {
  var alertDismiss = document.querySelectorAll('.alert-dismissible');

  Array.from(alertDismiss).forEach(function (item) {
    item.querySelector(".alert-close").addEventListener('click', function () {
      item.classList.add('hidden');
    });
  });
}


/********* dropdown common js *********/
var dropdownElem = document.querySelectorAll('.dropdown');
var dropupElem = document.querySelectorAll('.dropup');
var dropStartElem = document.querySelectorAll('.dropstart');
var dropendElem = document.querySelectorAll('.dropend');
var isShowDropMenu = false;
var isMenuInside = false;
// dropdown event
dropdownEvent(dropdownElem, 'bottom-start');
// dropup event
dropdownEvent(dropupElem, 'top-start');
// dropstart event
dropdownEvent(dropStartElem, 'left-start');
// dropend event
dropdownEvent(dropendElem, 'right-start');

function dropdownEvent(elem, place) {
  Array.from(elem).forEach(function (item) {
    item.querySelectorAll(".dropdown-toggle").forEach(function (subitem) {
      subitem.addEventListener("click", function (event) {
        subitem.classList.toggle("show");
        var popper = Popper.createPopper(subitem, item.querySelector(".dropdown-menu"), {
          placement: place
        });
        console.log('popper', item.querySelector(".dropdown-menu"));

        if (subitem.classList.contains("show") != true) {
          item.querySelector(".dropdown-menu").classList.remove("block")
          item.querySelector(".dropdown-menu").classList.add("hidden")
        } else {
          dismissDropdownMenu()
          item.querySelector(".dropdown-menu").classList.add("block")
          item.querySelector(".dropdown-menu").classList.remove("hidden")
          if (item.querySelector(".dropdown-menu").classList.contains("block")) {
            subitem.classList.add("show")
          } else {
            subitem.classList.remove("show")
          }
          event.stopPropagation();
        }

        isMenuInside = false;
      });
    });
  });
}

function dismissDropdownMenu() {
  Array.from(document.querySelectorAll(".dropdown-menu")).forEach(function (item) {
    item.classList.remove("block")
    item.classList.add("hidden")
  });
  Array.from(document.querySelectorAll(".dropdown-toggle")).forEach(function (item) {
    item.classList.remove("show")
  });
  isShowDropMenu = false;
}

// dropdown form
Array.from(document.querySelectorAll(".dropdown-menu")).forEach(function (item) {
  if (item.querySelectorAll("form")) {
    Array.from(item.querySelectorAll("form")).forEach(function (subitem) {
      subitem.addEventListener("click", function (event) {
        if (!isShowDropMenu) {
          isShowDropMenu = true;
        }
      })
    });
  }
});


// data-tw-auto-close
Array.from(document.querySelectorAll(".dropdown-toggle")).forEach(function (item) {
  var elem = item.parentElement
  if (item.getAttribute('data-tw-auto-close') == 'outside') {
    elem.querySelector(".dropdown-menu").addEventListener("click", function () {
      if (!isShowDropMenu) {
        isShowDropMenu = true;
      }
    });
  } else if (item.getAttribute('data-tw-auto-close') == 'inside') {
    item.addEventListener("click", function () {
      isShowDropMenu = true;
      isMenuInside = true;
    });
    elem.querySelector(".dropdown-menu").addEventListener("click", function () {
      isShowDropMenu = false;
      isMenuInside = false;
    });
  }
});

window.addEventListener('click', function (e) {
  if (!isShowDropMenu && !isMenuInside) {
    dismissDropdownMenu();
  }
  isShowDropMenu = false;
});




// Handler that uses various data-* attributes to trigger
// specific actions, mimicing bootstraps attributes
const triggers = Array.from(document.querySelectorAll('[data-toggle="collapse"]'));

window.addEventListener('click', (ev) => {
  const elm = ev.target;
  if (triggers.includes(elm)) {
    const selector = elm.getAttribute('data-target');
    collapse(selector, 'toggle');
  }
}, false);


const fnmap = {
  'toggle': 'toggle',
  'show': 'add',
  'hide': 'remove'
};
const collapse = (selector, cmd) => {
  const targets = Array.from(document.querySelectorAll(selector));
  targets.forEach(target => {
    target.classList[fnmap[cmd]]('show');
  });
}


/********* modal common js *********/
let isModalShow = false
function openModal(e) {
  let target = e.getAttribute('data-tw-target').substring(1)
  let modalWindow = document.getElementById(target)

  if (modalWindow.classList.contains('hidden')) {
    modalWindow.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
  } else {
    modalWindow.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
  }
  if (e.getAttribute('data-tw-backdrop') == 'static') {
    isModalShow = true;
  }
}

function openAddModal(e) {
  openModal(e)
  const data = { ...e.dataset }
  const target = e.getAttribute('data-tw-target').substring(1)
  const formDOM = document.querySelector(`.form-${target}`)

  formDOM.setAttribute('action', data.action)

  const methodDOM = formDOM.querySelector('[name="_method"]')
  if (methodDOM) methodDOM.value = 'POST'

}

function openDeleteModal(e, deleteRoute) {
  openModal(e)
  const modal = document.querySelector('#delete-confirmation-modal')
  modal.querySelector('form').setAttribute('action', deleteRoute)
}

function openEditModal(e) {
  openModal(e)
  const sourceData = e.closest('.edit-item').querySelector('.edit-item-data')

  const data = { ...sourceData.dataset }
  console.log(data)

  const target = e.getAttribute('data-tw-target').substring(1)
  const formDOM = document.querySelector(`.form-${target}`)
  formDOM.setAttribute('action', data.action)

  const methodDOM = formDOM.querySelector('[name="_method"]')
  if (methodDOM) methodDOM.value = 'PUT'


  Array.from(formDOM.querySelectorAll('input')).forEach(item => {
    if (!(data[item.getAttribute('name')] === undefined)) {
      item.value = data[item.getAttribute('name')]
      if (item.getAttribute('type') == 'checkbox') {
        item.checked = data[item.getAttribute('name')] == 1 ? true : false
      }
    }
  })

  Array.from(formDOM.querySelectorAll('textarea')).forEach(item => {
    if (!(data[item.getAttribute('name')] === undefined)) {
      item.value = data[item.getAttribute('name')]
    }
  })

  Array.from(formDOM.querySelectorAll('select')).forEach(item => {
    if (!(data[item.getAttribute('name')] === undefined)) {
      item.value = data[item.getAttribute('name')]
    }
  })

}

function closeModal(e) {
  let modalWindow = e.closest(".modal");
  if (modalWindow.classList.contains("hidden")) {
    modalWindow.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
  } else {
    modalWindow.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
  }
}

// feather.replace()
