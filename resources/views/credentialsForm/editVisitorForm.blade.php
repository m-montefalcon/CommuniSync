@include('partials.__header')
@include('components.nav')
<html>

<head>
  <title> EDIT VISITOR </title>
  <link rel="stylesheet" href="{{ asset('css/usersProfileView.css') }}">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css">
</head>

<body>
  <div class="container">
    <div class="header">
      <h2>
        EDIT VISITOR DETAILS FORM
      </h2>
    </div>
    <div class="card">
      <div class="card-body">
        @auth        
        @error('user_name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
          <div class="user-profile">
            <div class="card-profile">
              @if ($visitor->photo)
              <img src="{{ asset('storage/' . $visitor->photo) }}" alt="User Photo">
              @else
                <img src="{{ asset('Assets/default-user-profile.jpg') }}" alt="Default Photo">
              @endif
                <h3>{{ $visitor->first_name}}  {{ $visitor->last_name}}</h3>
              @if($visitor->role == 1)
                  Visitor
              @elseif($visitor->role == 2)
                  Homeowner
              @elseif($visitor->role == 3)
                  Security Personnel
              @elseif($visitor->role == 4)
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
                    <td> {{ $visitor->user_name }} </td>
                  </tr>
                  <tr>
                    <th width="30%"> Full Name </th>
                    <td width="2%"> : </td>
                    <td> {{ $visitor->first_name}}  {{ $visitor->last_name}} </td>
                  </tr>
                  <tr>
                    <th width="30%"> Email </th>
                    <td width="2%"> : </td>
                    <td> {{ $visitor->email }} </td>
                  </tr>
                  <tr>
                    <th width="30%"> Contact Number </th>
                    <td width="2%"> : </td>
                    <td> {{ $visitor->contact_number }} </td>
                  </tr>
                </table>
              </div>
            </div> 
          </div>
        @endauth

        <div id="editForm" style="display: none;">
        
        <form action="{{ route('api.update', ['id' => $visitor->id]) }}" method="POST">
          
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
          <input type="text" id="user_name" name="user_name" value="{{$visitor->user_name}}" required>
        </div>

        <div class="user-details">      
          <div class="input-box">
            <div class="input-group-prepend">
              <span class="input-icon"> 
                <i class="fa-solid fa-id-card"></i> 
              </span>
            </div>
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" value="{{$visitor->first_name}}" required>
          </div>

          <div class="input-box">
            <div class="input-group-prepend">
              <span class="input-icon"> 
                <i class="fa-solid fa-id-card"></i> 
              </span>
            </div>
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" value="{{$visitor->last_name}}" required>
          </div>

          <div class="input-box">
            <div class="input-group-prepend">
              <span class="input-icon"> 
                <i class="fa-solid fa-phone"></i> 
              </span>
            </div>
            <label for="contact_number">Contact Number:</label>
            <input type="text" id="contact_number" name="contact_number" value="{{$visitor->contact_number}}" maxlength="11" required>
          </div>

          <div class="input-box">
            <div class="input-group-prepend">
              <span class="input-icon"> 
                <i class="fa-solid fa-envelope"></i> 
              </span>
            </div>
            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" value="{{$visitor->email}}" required>
          </div>
        </div>
        <div class="input-box">
            <div class="input-group-prepend">
              <span class="input-icon"> 
                <i class="fa-solid fa-user"></i> 
              </span>
            </div>
            <label for="role">Role:</label>
              <select class="form-select" id="role" name="role">
                <option value="1" @if($visitor->role == 1) selected @endif>Visitor</option>
                <option value="2" @if($visitor->role == 2) selected @endif>Homeowner</option>
                <option value="3" @if($visitor->role == 3) selected @endif>Personnel</option>
                <option value="4" @if($visitor->role == 4) selected @endif>Admin</option>
              </select>
          </div>
        <br>
          <button type="submit" class="btn btn-primary">Update</button>
        </form>
          <a id="button" href="{{ route('visitor') }}" class="btn btn-danger">Cancel</a>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.getElementById('editButton').addEventListener('click', function() {
      var editForm = document.getElementById('editForm');
      editForm.style.display = (editForm.style.display === 'none' || editForm.style.display === '') ? 'block' : 'none';
    });
  </script>

</body>
</html>
@include('partials.__footer')

