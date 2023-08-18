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
              <span class="icon"><i class="fa-solid fa-home"></i></span>
            </a>
          </li>
          <li>
            <!-- <a class="side-link <?php if(basename($_SERVER['PHP_SELF']) == "home.php") echo "active"; ?>" href="{{ route('home') }}"> -->
            <a class="side-link @if(Request::is('home')) active @endif" href="{{ route('home') }}">
              <span class="icon"> <i class="fa-solid fa-home"></i> </span>
              <span class="text">Home</span>
              <span class="tooltip"> Home </span>
            </a>
          </li>

          <li class="user-dropdown">
            <a class="side-link <?php if(basename($_SERVER['PHP_SELF']) == "home.php") echo "active"; ?>" href="#" id="users-dropdown-toggle">
              <span class="icon"> <i class="fa-solid fa-users"></i> </span>
              <span class="text"> Users <i class="fa-solid fa-angle-right" id="users-icon"></i> </span>
            </a>
            <ul class="dropdown-menu" id="users-dropdown">
              <li>
                <a class="dropdown" href="{{ route('visitor') }}">
                  <span class="icon"> <i class="fa-solid fa-home"></i> </span>
                  <span class="text">Visitor</span>
                </a>
              </li>
              <li>
                <a class="dropdown" href="{{ route('homeowner') }}">
                  <span class="icon"> <i class="fa-solid fa-house-chimney-user"></i> </span>
                  <span class="text">Homeowner</span>
                </a>
              </li>
              <li>
                <a class="dropdown" href="{{ route('personnel') }}">
                  <span class="icon"> <i class="fa-solid fa-home"></i> </span>
                  <span class="text">Personnel</span>
                </a>
              </li>
              <li>
                <a class="dropdown " href="{{ route('admin') }}">
                  <span class="icon"> <i class="fa-solid fa-home"></i> </span>
                  <span class="text">Admin</span>
                </a>
              </li>
            </ul>
          </li>
            <!-- <li>
              <a class="side-link <?php if(basename($_SERVER['PHP_SELF']) == "home.php") echo "active"; ?>" href="{{ route('visitor') }}">
                <span class="icon"> <i class="fa-solid fa-users"></i> </span>
                <span class="text">Visitors</span>
              </a>
                <span class="tooltip"> Visitors </span>
            </li>

            <li>
              <a class="side-link <?php if(basename($_SERVER['PHP_SELF']) == "home.php") echo "active"; ?>" href="{{ route('homeowner') }}">
                <span class="text">Homeowners</span>
              </a>
                <span class="tooltip"> Homeowners </span>
            </li>

            <li>
              <a class="side-link <?php if(basename($_SERVER['PHP_SELF']) == "home.php") echo "active"; ?>" href="{{ route('personnel') }}">
                <span class="text">Personnel</span>
              </a>
                <span class="tooltip"> Personnel </span>
            </li>

            <li>
              <a class="side-link <?php if(basename($_SERVER['PHP_SELF']) == "home.php") echo "active"; ?>" href="{{ route('admin') }}">
                <span class="text">Admin</span>
              </a>
                <span class="tooltip"> Admin </span>
            </li> -->

          <li>
            <!-- <a class="side-link <?php if(basename($_SERVER['PHP_SELF']) == "home.php") echo "active"; ?>" href="{{ route('verificationRequests') }}"> -->
            <a class="side-link @if(Request::is('verification/requests')) active @endif" href="{{ route('verificationRequests') }}">
              <span class="icon"> <i class="fa-solid fa-user-check"></i> </span>
              <span class="text">Verification Requests</span>
              <span class="tooltip"> Verification Requests </span>
            </a>
          </li>

          <li>
            <!-- <a class="side-link <?php if(basename($_SERVER['PHP_SELF']) == "home.php") echo "active"; ?>" href="{{ route('announcement') }}"> -->
            <a class="side-link @if(Request::is('announcement')) active @endif" href="{{ route('announcement') }}">
              <span class="icon"> <i class="fa-solid fa-bullhorn"></i> </span>
              <span class="text">Announcement</span>
              <span class="tooltip"> Announcement </span>
            </a>
          </li>

          <li>
            <!-- <a class="side-link <?php if(basename($_SERVER['PHP_SELF']) == "home.php") echo "active"; ?>" href="{{ route('announcement.form') }}"> -->
            <a class="side-link @if(Request::is('announcement/create/form')) active @endif" href="{{ route('announcement.form') }}">
              <span class="icon"> <i class="fa-solid fa-scroll"></i> </span>
              <span class="text">Create Announcement</span>
              <span class="tooltip"> Create Announcement </span>
            </a>
          </li>
          <li>
            <!-- <a class="side-link <?php if(basename($_SERVER['PHP_SELF']) == "home.php") echo "active"; ?>" href="{{ route('profile') }}"> -->
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
      <div class="top-navbar">
        <div class="bx bx-menu" id="menu-icon"></div>
          <div class="profile">
							
          @if (auth()->user()->photo)
          <img src="http://127.0.0.1:8000/storage/{{Auth::user()->photo}}" alt="User Photo">
          @else
              <p>No photo available</p>
          @endif
          </div>
      </div>
      <main class="home-section"> </main>
      

  <script>
    let menu = document.querySelector('#menu-icon');
    let sidenavbar = document.querySelector('.side-navbar');
    let content = document.querySelector('.content');
    // let dropdown = document.querySelector('.dropdown-menu');

    menu.onclick = () => {
      sidenavbar.classList.toggle('active');
      content.classList.toggle('active');
      // dropdown.classList.toggle('active');
    }

    function menuBtnChange() {
      if(sidebar.classList.contains("active")){
        closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");
      } else {
        closeBtn.classList.replace("bx-menu-alt-right","bx-menu");
      }
    }
  </script>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const usersDropdownToggle = document.getElementById("users-dropdown-toggle");
      const usersDropdown = document.getElementById("users-dropdown");

      // Add an event listener to the "Users" link to toggle the dropdown
      usersDropdownToggle.addEventListener("click", function (event) {
        event.preventDefault();
        usersDropdown.classList.toggle("active");
      });

      // Add an event listener to close the dropdown when clicking outside
      document.addEventListener("click", function (event) {
        if (!usersDropdownToggle.contains(event.target) && !usersDropdown.contains(event.target)) {
          usersDropdown.classList.remove("active");
        }
      });
    });
  </script>

  <script>
    const usersDropdownToggle = document.getElementById("users-dropdown-toggle");
    const usersIcon = document.getElementById("users-icon");

    usersDropdownToggle.addEventListener("click", function () {
      usersIcon.classList.toggle("rotate-down");
    });
  </script>

  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>
</html>
