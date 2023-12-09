@include('partials.__header')
@include('components.nav')
<html>
  
<head>
  <title> Profile </title>
  <link rel="stylesheet" href="{{ asset('css/usersProfileView.css') }}">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css">
</head>
<style>
  /* Add this style to your CSS file or in the <head> section of your HTML */
#changePasswordModal {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1;
    width: 450px; /* Adjust the width as needed */
    background-color: #fff; /* Add your preferred background color */
    padding: 20px;
    border: 1px solid #ccc; /* Add your preferred border style */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;

}

.modal-content {
    width: 100%;
}

.close {
    position: absolute;
    top: 0;
    right: 0;
    padding: 10px;
    cursor: pointer;
}

</style>
<body>
  <div class="container">
    <div class="header">
      <h2>
        Profile
      </h2>
    </div>
    <div class="card">
      <div class="card-body">
        @auth       
        @error('user_name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror 
        @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
          <div class="user-profile">
            <div class="card-profile">
            @if (auth()->user()->photo)
                <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Personnel Photo">
              @else
                <img src="{{ asset('Assets/default-user-profile.jpg') }}" alt="Default Photo">
              @endif
                <h3>{{ auth()->user()->first_name}}  {{ auth()->user()->last_name}}</h3>
              @if(auth()->user()->role == 1)
                  Visitor
              @elseif(auth()->user()->role == 2)
                  Homeowner
              @elseif(auth()->user()->role == 3)
                  Security Personnel
              @elseif(auth()->user()->role == 4)
                  Admin
              @else
                  Unknown Role
              @endif
            </div>
            <div class="card-info">
              <div class="card-header">
                <h4>
                  <i class="far fa-clone"> </i>
                  General Information
                </h4>
                <a id="editButton" class="btn btn-primary">
                  <i class="fa-solid fa-user-pen"></i>
                </a>  
              </div>
              <div class="card-body">
                <table class="table">
                  <tr>
                    <th width="30%"> User Name </th>
                    <td width="2%"> : </td>
                    <td> {{ auth()->user()->user_name }} </td>
                  </tr>
                  <tr>
                    <th width="30%"> Full Name </th>
                    <td width="2%"> : </td>
                    <td> {{ auth()->user()->first_name}}  {{ auth()->user()->last_name}} </td>
                  </tr>
                  <tr>
                    <th width="30%"> Email </th>
                    <td width="2%"> : </td>
                    <td> {{ auth()->user()->email }} </td>
                  </tr>
                  <tr>
                    <th width="30%"> Contact Number </th>
                    <td width="2%"> : </td>
                    <td> {{ auth()->user()->contact_number }} </td>
                  </tr>
                </table>
              </div>
            </div> 
          </div>
        @endauth

        <div id="editForm" style="display: none;">
        
        <form action="{{ route('api.update', ['id' => auth()->user()->id]) }}" method="POST">
          
        @csrf
        @method('PUT')
      
        <input type="hidden" name="form_type" value="editAdminForm">
        
        <div class="input-box">
          <div class="input-group-prepend">
            <span class="input-icon"> 
              <i class="fa-solid fa-user"></i> 
            </span>
          </div>
          <label for="user_name">Username:</label>
          <input type="text" id="user_name" name="user_name" value="{{auth()->user()->user_name}}" required>
        </div>

        <div class="user-details">      
          <div class="input-box">
              <div class="input-group-prepend">
                <span class="input-icon"> 
                  <i class="fa-solid fa-id-card"></i> 
                </span>
              </div>
              <label for="first_name">First Name:</label>
              <input type="text" id="first_name" name="first_name" value="{{auth()->user()->first_name}}" required>
          </div>

          <div class="input-box">
            <div class="input-group-prepend">
              <span class="input-icon"> 
                <i class="fa-solid fa-id-card"></i> 
              </span>
            </div>
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" value="{{ auth()->user()->last_name}}" required>
          </div>

          <div class="input-box">
            <div class="input-group-prepend">
              <span class="input-icon"> 
                <i class="fa-solid fa-phone"></i> 
              </span>
            </div>
            <label for="contact_number">Contact Number:</label>
            <input type="text" id="contact_number" name="contact_number" value="{{auth()->user()->contact_number}}" maxlength="11" required>
          </div>

          <div class="input-box">
            <div class="input-group-prepend">
              <span class="input-icon"> 
                <i class="fa-solid fa-envelope"></i> 
              </span>
            </div>
            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" value="{{auth()->user()->email}}" required>
          </div>
          <div class="input-box">
            <div class="input-group-prepend">
              <span class="input-icon"> 
                <i class="fa-solid fa-user"></i> 
              </span>
            </div>
            <label for="role">Role:</label>
              <select class="form-select" id="role" name="role">
                <option value="1" @if(auth()->user()->role == 1) selected @endif>Visitor</option>
                <option value="2" @if(auth()->user()->role == 2) selected @endif>Homeowner</option>
                <option value="3" @if(auth()->user()->role == 3) selected @endif>Personnel</option>
                <option value="4" @if(auth()->user()->role == 4) selected @endif>Admin</option>
              </select>
          </div>
          <button type="button" class="btn btn-primary" onclick="openModal('changePasswordModal')">Change Password</button>

        </div>
        
        <br>
          <button type="submit" class="btn btn-primary">Update</button>
        </form>
          <a id="button" href="{{ route('profile') }}" class="btn btn-danger">Cancel</a>
        </div>
      </div>
      <div id="changePasswordModal" class="modal" style="display: none;">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <h2>Change Password</h2>
    <form action="{{ route('changepassword') }}" method="POST">
        @csrf
        @method('PUT')
        <!-- Add your password change form fields here -->
        <label for="current_password">Current Password:</label>
        <input type="password" id="current_password" name="current_password" required>

        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" required>

        <label for="confirm_password">Retype New Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <button type="submit" class="btn btn-primary">Change Password</button>
    </form>
  </div>
</div>

    </div>

  </div>

  <script>
    document.getElementById('editButton').addEventListener('click', function() {
      var editForm = document.getElementById('editForm');
      editForm.style.display = (editForm.style.display === 'none' || editForm.style.display === '') ? 'block' : 'none';
    });

    function openModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.style.display = 'block';

  }

  function closeModal() {
    var modal = document.getElementById('changePasswordModal');
    modal.style.display = 'none';
  }

  // Automatically hide error and success messages after 10 seconds
setTimeout(function() {
   var errorAlert = document.querySelector('.alert-danger');
   var successAlert = document.querySelector('.alert-success');
   if (errorAlert) errorAlert.style.display = 'none';
   if (successAlert) successAlert.style.display = 'none';
}, 10000);

  </script>
  


</html>
</body>

@include('partials.__footer')

