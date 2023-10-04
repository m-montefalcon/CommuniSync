@include('partials.__header')
@include('components.nav')

<html>
<head>
  <title> Register Visitor </title>
  <link rel="stylesheet" href="{{ asset('css/register.css') }}">
  <link rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css">
</head>

<body>
    <div class="card">
        <form method="POST" action="{{ route('api.user.store') }}" enctype="multipart/form-data">
            @csrf

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
                <script>
                    setTimeout(function() {
                        document.querySelector('.alert').style.display = 'none';
                    }, 5000);
                </script>
            @endif

            <h2>Register Visitor</h2>

            <input type="hidden" name="form_type" value="registerVisitor">
            <div class="user-details">
                <div class="input-container">
                    <div class="flex-container">
                        <div class="form-group">
                            <label for="user_name">Username:</label>
                            <span class="input-icon-start">
                                <i class="fa-solid fa-user"></i>      
                            </span>
                            <input class="user-container" type="text" id="user_name" name="user_name" required>
                        </div>
                    </div>

                    <div class="flex-container">
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <span class="input-icon-start">
                                <i class="fa-solid fa-lock"></i>
                            </span>
                            <input class="user-container" type="password" id="password" name="password" required>
                            <span class="input-icon-end"> 
                                <i class="fa fa-eye-slash password-toggle" id="password-toggle"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="input-container">
                    <div class="flex-container">
                        <div class="form-group">
                            <label for="first_name">First Name:</label>
                            <span class="input-icon-start">
                                <i class="fa-solid fa-id-card"></i>
                            </span>   
                            <input class="user-container" type="text" id="first_name" name="first_name" required>         
                        </div>
                    </div>

                    <div class="flex-container">
                        <div class="form-group">
                            <label for="last_name">Last Name:</label>
                            <span class="input-icon-start">
                                <i class="fa-solid fa-id-card"></i>
                            </span>   
                        </div>             
                        <input class="user-container" type="text" id="last_name" name="last_name" required>
                    </div>
                </div>

                <div class="input-container">
                    <div class="flex-container">
                    <div class="form-group">
                            <label for="contact_number">Contact Number:</label>
                            <span class="input-icon-start">
                                <i class="fa-solid fa-phone"></i>
                            </span>   
                        </div>  
                        <input class="user-container" type="text" id="contact_number" name="contact_number" required>
                    </div>

                    <div class="flex-container">
                        <div class="form-group">
                            <label for="email">Email Address:</label>
                            <span class="input-icon-start">
                                <i class="fa-solid fa-envelope"></i>
                            </span>  
                        </div>
                        <input class="user-container" type="email" id="email" name="email" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="photo">Photo:</label>
                <span class="input-icon-start">
                    <i class="fa-solid fa-image"></i>
                </span>  
            </div>
            <input type="file" id="photo" name="photo">

            <div class="form-group">
                <label for="role">Role:</label>
                <span class="input-icon-start">
                    <i class="fa-solid fa-id-badge"></i>
                </span>
            </div>
            <input class="role-container" type="text" id="role" name="role" value="Visitor" readonly>
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
    
    <script>
        var roleInput = document.getElementById('role');

        roleInput.form.addEventListener('submit', function () {
            roleInput.value = "1";
        });
    </script>
    
</body>
</html>

@include('partials.__footer')
