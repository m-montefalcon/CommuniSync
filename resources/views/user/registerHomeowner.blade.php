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
        <div class="card">
            <div class="card-header">
                <h2>
                    Register Homeowner
                </h2>
            </div>
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
                    
                    <input type="hidden" name="form_type" value="registerHomeowner">

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
                            <input type="text" id="contact_number" name="contact_number" required>
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

                        <div class="input-box">
                            <div class="input-group-prepend">
                                <span class="input-icon"> 
                                    <i class="fa-solid fa-map-location-dot"></i> 
                                </span>
                            </div>
                            <label for="block_no">Block Number:</label>
                            <input type="text" id="block_no" name="block_no" required>
                        </div>

                        <div class="input-box">
                            <div class="input-group-prepend">
                                <span class="input-icon"> 
                                    <i class="fa-solid fa-map-location-dot"></i> 
                                </span>
                            </div>
                            <label for="lot_no">Lot Number:</label>
                            <input type="text" id="lot_no" name="lot_no" required>
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
                            <input type="text" id="role" name="role" value="Homeowner" readonly>
                        </div>

                        <div class="input-box">
                            <div class="input-group-prepend">
                                <span class="input-icon"> 
                                    <i class="fa-solid fa-person-walking-dashed-line-arrow-right"></i>
                                </span>
                            </div>   
                            <label for="manual_visit_option">Manual Visit Option:</label>
                            <select class="form-select" id="manual_visit_option" name="manual_visit_option">
                                <option disabled selected> Visit Option </option>
                                <option value="0"> Do not Allow </option>
                                <option value="1"> Allow </option>
                            </select>
                        </div>
                        
                        <label for="family_member">Family Members:</label> 
                        @php $familyMembers = old('family_member', $homeowner->family_member ?? []); @endphp
                        <div id="familyInputContainer">
                            @foreach($familyMembers as $index => $member)
                            <div class="input-box-member">
                                <div class="input-group-prepend">
                                    <span class="input-icon-member">
                                        <i class="fa-solid fa-people-roof"> </i>
                                    </span>
                                </div>
                                    <input class="input-member" type="text" name="family_member[]" value="{{ $member }}" required>
                                    <button type="button" class="removeMember">Delete</button>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" id="addMember">Add member</button>
                        <br>
                        <br>
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
            roleInput.value = "2";
        });

        // document.getElementById('addMember').addEventListener('click', function() {
        //     var container = document.getElementById('familyInputContainer');
        //     var newInput = document.createElement('div');
        //     newInput.classList.add('inputField');
        //     newInput.innerHTML = '<div class="input-box"><div class="input-group-prepend"><span class="input-icon"><i class="fa-solid fa-people-roof"></i></span></div><input class="input-member" type="text" name="family_member[]" required><div class="flex-container"><button type="button" class="removeMember">Delete</button></div></div>';
        //     container.appendChild(newInput);
        // });
        


        // Optionally, you can add code to handle removing members as well.
        document.addEventListener('click', function(event) {
            if (event.target && event.target.classList.contains('removeMember')) {
                event.target.closest('.input-box').remove();
            }
        });

    </script>

    <script>
    document.getElementById('addMember').addEventListener('click', function() {
        var container = document.getElementById('familyInputContainer');
        var newInput = document.createElement('div');
        newInput.classList.add('input-box');
        newInput.innerHTML = `
            <div class="input-box-member">
                <div class="input-group-prepend">
                    <span class="input-icon-member">
                        <i class="fa-solid fa-people-roof"></i>
                    </span>
                </div>
                    <input class="input-member" type="text" name="family_member[]" required>
                    <button type="button" class="removeMember">Delete</button>
            </div>`;
        container.appendChild(newInput);
    });
    </script>
    
</body>
</html>

@include('partials.__footer')
