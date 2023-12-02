@include('partials.__header')
<html>
<head>
  <title> Landing Page </title>
  <link rel="stylesheet" href="{{ asset('css/landingPage.css') }}">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
  <body>
    <div class="nav-bar">
      <nav class="main-nav">
        <img src="{{ asset('Assets/official-logo-green.png') }}" alt="logo">
        <ul class="nav">
          <li class="scroll-to-section"><a href="#" class="active">Home</a></li>
          <li class="scroll-to-section"><a href="/termsAndCondition">Terms and Condition</a></li>
          <li><div class="gradient-button"><a id="modal_trigger" href="/login"><i class="fa fa-sign-in-alt"></i> Sign In Now</a></div></li> 
        </ul>        
      </nav>
    </div>
    <div class="body-content">
      <div class="introduction">
        <img src="{{ asset('Assets/gradient-bg.jpg') }}" class="bg-img">
        <div class="main-text">
          <h2>WELCOME TO</h2>
          <h1>CommuniSync</h1>
        </div>
        <div class="sub-text">
          <h5>A Subdivision Management System that provide a 
          centralized platform on visitor management to monitor visitation, manage visitor registration, 
          and handle notification alerts, ensuring a safe environment for residents.</h5>
        </div>
        <form action="{{ url('/downloadApk') }}" method="get">
          <button class="download-button" type="submit">
              Download CommuniSync.apk
              <div class="button-container">
                <i class="fa-solid fa-download"></i>
              </div>  
          </button>
        </form>

      </div>
      <div class="phone-container">
        <img src="{{ asset('Assets/landing-page-img.png') }}" class="phone-img">
      </div>
    </div>
  </body>
</html>
@include('partials.__footer')