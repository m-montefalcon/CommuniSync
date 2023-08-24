@include('partials.__header')
<html>
<head>
  <title> Landing Page </title>
  <link rel="stylesheet" href="{{ asset('css/landingPage.css') }}">
  <link rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css">
</head>

<body>
  <div class="card">
    <form>
    <h2>Welcome</h2>  
  
    <div>
      <a href="/login" class="button">Sign In</a>
    </div>

 
    <!-- Will remove this after the auth setup -->
    <div>
      <a href="/register" class="button">Register</a>
    </div>


    </form>
  </div>
</body>
</html>
@include('partials.__footer')