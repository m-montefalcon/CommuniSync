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
            
            <h2>Register Homeowner</h2>

                <input type="hidden" name="form_type" value="registerHomeowner">
                
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
                <input type="text" id="role" name="role" value="Homeowner" readonly>

                <label for="manual_visit_option">Manual Visit Option:</label>
                    <select class="form-select" id="manual_visit_option" name="manual_visit_option">
                        <option disabled selected> Visit Option </option>
                        <option value="0"> Do not Allow </option>
                        <option value="1"> Allow </option>
                    </select>
                    
                <label for="block_no">Block Number:</label>
                <input type="text" id="block_no" name="block_no" required>
            
                <label for="lot_no">Lot Number:</label>
                <input type="text" id="lot_no" name="lot_no" required>

                <label for="family_member">Family Members:</label> 
                        @php $familyMembers = old('family_member', $homeowner->family_member ?? []); @endphp
                        <div id="familyInputContainer">
                        @foreach($familyMembers as $index => $member)
                        <div class="inputField">
                            <input type="text" name="family_member[]" value="{{ $member }}" required>
                            <button type="button" class="removeMember">Delete</button>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" id="addMember">Add member</button>
       
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
            roleInput.value = "2";
        });

        document.getElementById('addMember').addEventListener('click', function() {
            var container = document.getElementById('familyInputContainer');
            var newInput = document.createElement('div');
            newInput.classList.add('inputField');
            newInput.innerHTML = '<input type="text" name="family_member[]" required><button type="button" class="removeMember">Delete</button>';
            container.appendChild(newInput);
        });

        // Optionally, you can add code to handle removing members as well.
        document.addEventListener('click', function(event) {
            if (event.target && event.target.classList.contains('removeMember')) {
                event.target.parentNode.remove();
            }
        });
    </script>
    
</body>
</html>

@include('partials.__footer')
