@include('partials.__header')

<html>
<head>
  <title> Register </title>
  <link rel="stylesheet" href="{{ asset('css/register.css') }}">
  <link rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css">
</head>

<body>
    <div class="card">
        <form method="POST" action="{{ route('api.register.store') }}" enctype="multipart/form-data">
            @csrf
            <h2>Register</h2>

                <label for="user_name">Username:</label>
                <input type="text" id="user_name" name="user_name" required>

                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" required>

                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" required>

                <label for="contact_number">Contact Number:</label>
                <input type="text" id="contact_number" name="contact_number" required>

                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" required>

                <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <span class="input-icon-end"> 
                    <i class="fa fa-eye-slash password-toggle" id="password-toggle"></i>
                </span>
                </div>

                <label for="photo">Photo:</label>
                <input type="file" id="photo" name="photo">

                <label for="role">Role:</label>
                <select class="form-select" id="role" name="role">
                    <option disabled selected> Role </option>
                    <option value="1"> Vistor </option>
                    <option value="2"> Homeowner </option>
                    <option value="3"> Security Personnel </option>
                    <option value="4"> Admin </option>
                </select>

            <button type="submit" value="Register"> Register </button>
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
