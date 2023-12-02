@include('partials.__header')
@include('components.nav')
<html>

<head>
    <title> Register Admin </title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <link rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>
                Register Admin
            </h2>
        </div>
        <div class="card">

            <div class="card-body">
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
                    
                    <input type="hidden" name="form_type" value="registerAdmin">

                    <div class="user-details">
                        <div class="input-box">
                            <div class="input-group-prepend">
                                <span class="input-icon"> 
                                    <i class="fa-solid fa-user"></i> 
                                </span>
                            </div>
                            <label for="user_name">Username:</label>
                            <input type="text" id="user_name" name="user_name" required>
                        </div>

                        <div class="input-box">
                            <div class="form-group">
                                <div class="input-group-prepend">
                                    <span class="input-icon"> 
                                        <i class="fa-solid fa-lock"></i> 
                                    </span>
                                </div>
                                <label for="password">Password:</label>
                                <input type="password" id="password" name="password" required>
                                <span class="input-icon-end"> 
                                    <i class="fa fa-eye-slash password-toggle" id="password-toggle"></i>
                                </span>
                            </div>
                        </div>
                    
                        <div class="input-box">
                            <div class="input-group-prepend">
                                <span class="input-icon"> 
                                    <i class="fa-solid fa-id-card"></i> 
                                </span>
                            </div>
                            <label for="first_name">First Name:</label>
                            <input type="text" id="first_name" name="first_name" required>
                        </div>

                        <div class="input-box">
                            <div class="input-group-prepend">
                                <span class="input-icon"> 
                                    <i class="fa-solid fa-id-card"></i> 
                                </span>
                            </div>
                            <label for="last_name">Last Name:</label>
                            <input type="text" id="last_name" name="last_name" required>
                        </div>

                        <div class="input-box">
                            <div class="input-group-prepend">
                                <span class="input-icon"> 
                                    <i class="fa-solid fa-phone"></i> 
                                </span>
                            </div>
                            <label for="contact_number">Contact Number:</label>
                            <input type="text" id="contact_number" name="contact_number" maxlength="11" required>
                        </div>

                        <div class="input-box">
                            <div class="input-group-prepend">
                                <span class="input-icon"> 
                                    <i class="fa-solid fa-envelope"></i> 
                                </span>
                            </div>
                            <label for="email">Email Address:</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                    </div>

                        <div class="input-box">
                            <div class="input-group-prepend">
                                <span class="input-icon"> 
                                    <i class="fa-solid fa-image"></i> 
                                </span>
                            </div>
                            <label for="photo">Photo:</label>
                            <input type="file" id="photo" name="photo">
                        </div>

                        <div class="input-box">
                            <div class="input-group-prepend">
                                <span class="input-icon"> 
                                    <i class="fa-solid fa-id-card-clip"></i> 
                                </span>
                            </div>    
                            <label for="role">Role:</label>
                            <input type="text" id="role" name="role" value="Admin" readonly>
                        </div>
                    <button type="submit" value="Register" class="btn btn-primary"> Register </button>
                </form>
                    <button class="btn btn-danger" onclick="history.back()"> Cancel </button> 
            </div>
        </div>
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
            roleInput.value = "4";
        });
    </script>
    
</body>
</html>

@include('partials.__footer')
