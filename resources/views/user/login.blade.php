<html>
<head>
  <title> Login </title>
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
  <link rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css">
</head>

<body>
<img src="Assets/gradient-bg.jpg" class="bg-img">

  <div class="card">
    <form action="{{ route('api.login.store') }}" method="POST">
      @csrf
      @if ($errors->has('user_name'))
        <div class="alert alert-danger">
          {{ $errors->first('user_name') }}
        </div>
        <script>
          setTimeout(function() {
            document.querySelector('.alert').style.display = 'none';
          }, 5000);
        </script>
      @endif

      <div class="logo-container">
        <img src="Assets/official-logo-green.png" class="logo-img">
			</div>

      <div class="form-group">
        <div class="input-group-prepend">
          <span class="input-icon"> <i class="fa-solid fa-user"></i> </span>
        </div>
          <input type="text" id="user_name" name="user_name" placeholder="Enter username" autocomplete="off"  required>
      </div>

      <div class="form-group">
        <div class="input-group-prepend">
          <span class="input-icon"><i class="fa-solid fa-lock"></i></span>
        </div>
          <input type="password" id="password" name="password" placeholder="Enter password" autocomplete="off" required>
        <span class="input-icon-end"> 
          <i class="fa fa-eye-slash password-toggle" id="password-toggle"></i>
        </span>
      </div>
      <div>
        <button type="submit">Login</button>
      </div>
    </form>
  </div>

  <script>
		const passwordInput = document.getElementById('password');
		const passwordToggle = document.getElementById('password-toggle');

		passwordToggle.addEventListener('click', function() {
		const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
		passwordInput.setAttribute('type', type);
		passwordToggle.classList.toggle('fa-eye');
		passwordInput.focus();
		});
	</script>

</body>
</html>
@include('partials.__footer')

