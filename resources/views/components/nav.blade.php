@include('partials.__header')
<html>

<head>
  <title> Login </title>
  <link rel="stylesheet" href="{{ asset('css/sideNavbar.css') }}">
  <link rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css">
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
</head>

<body>
  <div class="dashboard-container">
    <aside class="side-navbar">
      <ul class="nav-list">
        <nav>
          <li>
            <a>
              <img src="{{ asset('Assets/official-logo-green.png') }}" class="logo-img">
            </a>
          </li>
          <li>
            <a class="side-link @if(Request::is('home')) active @endif" href="{{ route('home') }}">
              <span class="icon"> <i class="fa-solid fa-home"></i> </span>
              <span class="text">Home</span>
              <span class="tooltip"> Home </span>
            </a>
          </li>
          <li>
            <a class="side-link @if(Request::is('admin/get/logbook')) active @endif" href="{{ route('admin.get.logbook') }}">
              <span class="icon"> <i class="fa-solid fa-address-book"></i> </span>
              <span class="text">Logbook</span>
              <span class="tooltip"> Logbook </span>
            </a>
          </li>
          <li>
            <a class="side-link @if(Request::is('users/control/access/get/all')) active @endif" href="{{ route('users.control.access.get.all') }}">
              <span class="icon"> <i class="fa-solid fa-house-lock"></i> </span>
              <span class="text">Access Control</span>
              <span class="tooltip"> Access Control </span>
            </a>
          </li>
          <li>
            <a class="side-link @if(Request::is('blockedlists/request')) active @endif" href="{{ route('blockedlists.request') }}">
              <span class="icon"> <i class="fa-solid fa-user-large-slash"></i> </span>
              <span class="text">Blocked List</span>
              <span class="tooltip"> Blocked List </span>
            </a>
          </li>
          <li class="user-dropdown">
            <a class="side-link" id="users-dropdown-toggle">
              <span class="icon"> <i class="fa-solid fa-users"></i> </span>
              <span class="text"> Users <i class="fa-solid fa-angle-right" id="users-down"></i> </span>
            </a>
            <ul class="dropdown-menu " id="users-dropdown">
              <li>
                <a class="dropdown @if(Request::is('visitor')) active @endif" href="{{ route('visitor') }}">
                  <span class="icon"> <i class="fa-solid fa-person-shelter"></i> </span>
                  <span class="text">Visitor</span>
                </a>
              </li>
              <li>
                <a class="dropdown @if(Request::is('homeowner')) active @endif" href="{{ route('homeowner') }}">
                  <span class="icon"> <i class="fa-solid fa-house-chimney-user"></i> </span>
                  <span class="text">Homeowner</span>
                </a>
              </li>
              <li>
                <a class="dropdown @if(Request::is('personnel')) active @endif" href="{{ route('personnel') }}">
                  <span class="icon"> <i class="fa-solid fa-user-lock"></i> </span>
                  <span class="text">Personnel</span>
                </a>
              </li>
              <li>
                <a class="dropdown @if(Request::is('admin')) active @endif" href="{{ route('admin') }}">
                  <span class="icon"> <i class="fa-solid fa-user-gear"></i> </span>
                  <span class="text">Admin</span>
                </a>
              </li>
            </ul>
          </li>
          <li>
            <a class="side-link @if(Request::is('verification/requests')) active @endif" href="{{ route('verificationRequests') }}">
              <span class="icon"> <i class="fa-solid fa-user-check"></i> </span>
              <span class="text">Verification <br> Requests</span>
              <span class="tooltip"> Verification Requests </span>
            </a>
          </li>
          <li>
            <a class="side-link @if(Request::is('announcement')) active @endif" href="{{ route('announcement') }}">
              <span class="icon"> <i class="fa-solid fa-bullhorn"></i> </span>
              <span class="text">Announcement</span>
              <span class="tooltip"> Announcement </span>
            </a>
          </li>
          <li>
            <a class="side-link @if(Request::is('admin/complaint/fetch')) active @endif" href="{{ route('api.admin.complaint.fetch') }}">
              <span class="icon"> <i class="fa-solid fa-scroll"></i> </span>
              <span class="text">Complaints</span>
              <span class="tooltip"> Complaints </span>
            </a>
          </li>
          <li>
          <li>
            <a class="side-link @if(Request::is('admin/payment/all/users')) active @endif" href="{{ route('admin.payment.all.users') }}">
              <span class="icon"> <i class="fa-solid fa-money-check-dollar"></i> </span>
              <span class="text">Monthly Due <br> Records</span>
              <span class="tooltip"> Payment </span>
            </a>
          </li>
          <li>
            <a class="side-link @if(Request::is('profile')) active @endif" href="{{ route('profile') }}">
              <span class="icon"> <i class="fa-solid fa-user"></i> </span>
              <span class="text">Profile</span>
              <span class="tooltip"> Profile </span>
            </a>
          </li>
          <li class="logout">
            <form action="{{ route('api.logout.store') }}" method="POST" id="logout-form" style="display: none;">
              @csrf
            </form>
              <a class="side-link" href="{{ route('api.logout.store') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <span class="icon"> <i class="fa-solid fa-right-from-bracket fa-rotate-180"></i> </span>
                <span class="text"> Logout </span>
                <span class="tooltip"> Logout </span>
              </a>
          </li>
        </nav>
      </ul>
    </aside>
  </div>

  <div class="content">
  <style>
    .top-navbar {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        padding: 10px;
        position: relative;
    }

    .notification-icon {
        margin-right: 10px;
        cursor: pointer;
        position: relative; /* Add relative positioning for the counter */
    }

    #notification-counter {
    background-color: #ff4d4d;
    color: #fff;
    border-radius: 50%;
    padding: 2px 6px;
    font-size: 12px;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    left: 10px; /* Adjust the right position to create some space between the counter and the bell icon */
    display: none;
}


    .profile {
        display: flex;
        align-items: center;
    }

    .profile-name {
        margin-right: 10px;
    }

    .profile img {
        border-radius: 50%;
    }

    .notification-popup {
        position: absolute;
        top: 100%;
        right: 0;
        background-color: white;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border: 1px solid #ddd;
        padding: 10px;
        display: none;
        min-width: 400px;
        max-height: 200px; /* Adjust the height as needed */
        overflow-y: auto;
    }

    .notification-item {
        padding: 6px; /* Adjust the padding to your preference */
        border-bottom: 4px solid #eee;
    }
    .notification-item.not-hovered {
        background-color: lightgreen;
    }
</style>


<script>
document.addEventListener('DOMContentLoaded', function () {
    var notificationIcon = document.getElementById('notification-icon');
    var notificationPopup = document.getElementById('notification-popup');
    var notificationCounter = document.getElementById('notification-counter');

    // Fetch notifications immediately upon page load
    fetchNotifications();

    notificationIcon.addEventListener('click', function (event) {
        // Toggle the visibility of the notification popup
        notificationPopup.style.display = (notificationPopup.style.display === 'none') ? 'block' : 'none';

        // Prevent the click event from propagating to the document click listener
        event.stopPropagation();
    });

    // Close the notification popup if the user clicks outside of it
    document.addEventListener('click', function () {
        notificationPopup.style.display = 'none';
    });

    // Handle clicks on notification items using event delegation
    notificationPopup.addEventListener('click', function (event) {
        var target = event.target;

        // Check if the clicked element has the "mark-as-read" class
        if (target.classList.contains('mark-as-read')) {
            // Extract the notification ID from the data-id attribute
            var notificationId = target.getAttribute('data-id');

            // Mark the notification as read
            markAsRead(notificationId);
        }
    });

    setInterval(fetchNotifications, 3600000); // 1 hour = 60 minutes * 60 seconds * 1000 milliseconds

    // Function to fetch notifications from the server
    function fetchNotifications() {
        console.log('Fetching notifications...');

        // Replace the URL with your actual endpoint
        fetch('/fetch/notifications')
            .then(response => response.json())
            .then(data => {
                console.log('Received data:', data);

                // Filter out read notifications
                const unreadNotifications = data.notifications.filter(notification => !notification.is_hovered);

                // Update the notification popup with the fetched notifications
                updateNotificationPopup(unreadNotifications);

                // Update the notification counter with the count of unread notifications
                updateNotificationCounter(unreadNotifications.length);
            })
            .catch(error => console.error('Error fetching notifications:', error));
    }

    // Function to update the notification popup content
    function updateNotificationPopup(notifications) {
        console.log('Updating notification popup...');

        var notificationItems = notifications.map(notification => {
            // Add a CSS class if is_hover is false
            var hoverClass = (notification.is_hovered) ? '' : ' not-hovered';
            return `<div class="notification-item${hoverClass} mark-as-read" data-id="${notification.id}">${notification.title}: ${notification.body}</div>`;
        });

        // Replace the content of the notification popup
        notificationPopup.innerHTML = notificationItems.join('');
    }

    // Function to mark a notification as read
    function markAsRead(notificationId) {
        // Get the CSRF token from the meta tag
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Send an API request to mark the notification as read
        fetch(`/mark-as-read/${notificationId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
        })
            .then(response => response.json())
            .then(data => {
                // Fetch notifications again after marking as read
                fetchNotifications();
            })
            .catch(error => console.error('Error marking notification as read:', error));
    }

    // Function to update the notification counter
    function updateNotificationCounter(count) {
        console.log('Updating notification counter...');

        // Display or hide the counter based on the number of notifications
        notificationCounter.style.display = (count > 0) ? 'block' : 'none';

        // Update the counter text
        notificationCounter.innerText = count.toString();
    }
});

</script>



<!-- Your HTML structure -->
<div class="top-navbar">
<div class="bx bx-menu" id="menu-icon"></div>

    <div class="notification-icon" id="notification-icon">
        <!-- Notification bell icon -->
        <i class="fas fa-bell"></i>
        <span id="notification-counter" style="display: none;"></span>

        <!-- Notification popup -->
        <div class="notification-popup" id="notification-popup">
            <!-- Replace the content below with your actual notifications -->
           
            <!-- Add more notification items as needed -->
        </div>
    </div>

    <div class="profile">
        <div class="profile-name">
            <a>{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</a>
        </div>

        @if (auth()->user()->photo)
            <a href="{{ route('profile') }}">
                <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="User Photo">
            </a>
        @else
            <a href="{{ route('profile') }}">
                <img src="{{ asset('Assets/default-user-profile.jpg') }}" alt="Default Photo">
            </a>
        @endif
    </div>
</div>



      <main class="home-section"> </main>

  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
      
  <script>
    let menu = document.querySelector('#menu-icon');
    let sidenavbar = document.querySelector('.side-navbar');
    let content = document.querySelector('.content');

    // Retrieve the initial state from localStorage
    let isSidebarActive = localStorage.getItem("isSidebarActive") === "true";

    // Set the initial state
    updateSidebarState(isSidebarActive);
    
    menu.onclick = () => {
      isSidebarActive = !isSidebarActive;
      updateSidebarState(isSidebarActive);
    }

    function updateSidebarState(isActive) {
      sidenavbar.classList.toggle('active', isActive);
      content.classList.toggle('active', isActive);
      menuBtnChange(isActive);
      
      // Update localStorage to persist the state
      localStorage.setItem("isSidebarActive", isActive.toString());
    }

    function menuBtnChange(isActive) {
      if(isActive){
        menu.classList.replace("bx-menu", "bx-menu-alt-left"); 
      } else {
        menu.classList.replace("bx-menu-alt-left", "bx-menu");
      }
    }
  </script>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const usersDropdownToggle = document.getElementById("users-dropdown-toggle");
      const usersDropdown = document.getElementById("users-dropdown");
      const usersIcon = document.getElementById("users-down");
      const menuIcon = document.getElementById("menu-icon");
      const sideNavbar = document.querySelector('.side-navbar');
      const content = document.querySelector('.content');

      // Retrieve the dropdown state from localStorage
      let isDropdownOpen = localStorage.getItem("isUsersDropdownOpen") === "true";
      let isSidebarActive = localStorage.getItem("isSidebarActive") === "true";

      const updateDropdownState = function (isOpen) {
          usersDropdown.classList.toggle("active", isOpen);
          usersIcon.classList.toggle("rotate-down", isOpen);
      };

      const updateSidebarState = function (isActive) {

          sideNavbar.classList.toggle("active", isActive);
          content.classList.toggle("active", isActive);

          // Restore transition after the state update
          setTimeout(() => {
              sideNavbar.style.transition = "";
              content.style.transition = "";
          }, 0);
      };

      // Set the initial states
      updateDropdownState(isDropdownOpen);
      updateSidebarState(isSidebarActive);

      // Add an event listener to the "Users" link to toggle the dropdown
      usersDropdownToggle.addEventListener("click", function (event) {
          event.preventDefault();
          isDropdownOpen = !isDropdownOpen;
          updateDropdownState(isDropdownOpen);

          // Update the localStorage to persist the state
          localStorage.setItem("isUsersDropdownOpen", isDropdownOpen.toString());
      });

      // Add an event listener to toggle the sidebar when the menu icon is clicked
      menuIcon.addEventListener("click", function () {
          isSidebarActive = !isSidebarActive;
          updateSidebarState(isSidebarActive);

          // Update the localStorage to persist the state
          localStorage.setItem("isSidebarActive", isSidebarActive.toString());
      });

      // No transition effect on window resize
      window.addEventListener("resize", function () {
          isDropdownOpen = false;
          updateDropdownState(isDropdownOpen);
          // Update the localStorage to reflect the closed state
          localStorage.setItem("isUsersDropdownOpen", "false");
      });
    });
  </script>

</body>
</html>