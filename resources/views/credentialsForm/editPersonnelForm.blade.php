@include('partials.__header')
@include('components.nav')
<html>
<head>
  <title> EDIT PERSONNEL </title>
  <link rel="stylesheet" href="{{ asset('css/usersProfileView.css') }}">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css">
</head>

<body>
  <div class="container">
    <div class="header">
      <h2>
        EDIT PERSONNEL DETAILS FORM
      </h2>
    </div>
    <div class="card">
      <div class="card-body">
        @auth        
          <div class="user-profile">
            <div class="card-profile">
              @if ($personnel->photo)
                <img src="{{ asset('storage/' . $personnel->photo) }}" alt="Personnel Photo">
              @else
                <img src="{{ asset('Assets/default-user-profile.jpg') }}" alt="Default Photo">
              @endif
                <h3>{{ $personnel->first_name}}  {{ $personnel->last_name}}</h3>
              @if($personnel->role == 1)
                  Visitor
              @elseif($personnel->role == 2)
                  Homeowner
              @elseif($personnel->role == 3)
                  Security Personnel
              @elseif($personnel->role == 4)
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
                    <td> {{ $personnel->user_name }} </td>
                  </tr>
                  <tr>
                    <th width="30%"> Full Name </th>
                    <td width="2%"> : </td>
                    <td> {{ $personnel->first_name}}  {{ $personnel->last_name}} </td>
                  </tr>
                  <tr>
                    <th width="30%"> Email </th>
                    <td width="2%"> : </td>
                    <td> {{ $personnel->email }} </td>
                  </tr>
                  <tr>
                    <th width="30%"> Contact Number </th>
                    <td width="2%"> : </td>
                    <td> {{ $personnel->contact_number }} </td>
                  </tr>
                </table>
              </div>
            </div> 
          </div>
        @endauth

        <div id="editForm" style="display: none;">
        
        <form action="{{ route('api.update', ['id' => $personnel->id]) }}" method="POST">
          
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
          <input type="text" id="user_name" name="user_name" value="{{$personnel->user_name}}" required>
        </div>

        <div class="user-details">      
          <div class="input-box">
            <div class="input-group-prepend">
              <span class="input-icon"> 
                <i class="fa-solid fa-id-card"></i> 
              </span>
            </div>
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" value="{{$personnel->first_name}}" required>
          </div>

          <div class="input-box">
            <div class="input-group-prepend">
              <span class="input-icon"> 
                <i class="fa-solid fa-id-card"></i> 
              </span>
            </div>
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" value="{{$personnel->last_name}}" required>
          </div>

          <div class="input-box">
            <div class="input-group-prepend">
              <span class="input-icon"> 
                <i class="fa-solid fa-phone"></i> 
              </span>
            </div>
            <label for="contact_number">Contact Number:</label>
            <input type="text" id="contact_number" name="contact_number" value="{{$personnel->contact_number}}" maxlength="11" required>
          </div>

          <div class="input-box">
            <div class="input-group-prepend">
              <span class="input-icon"> 
                <i class="fa-solid fa-envelope"></i> 
              </span>
            </div>
            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" value="{{$personnel->email}}" required>
          </div>
        </div>
        <br>
          <button type="submit" class="btn btn-primary">Update</button>
        </form>
          <a id="button" href="{{ route('personnel') }}" class="btn btn-danger">Cancel</a>
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

</html>
</body>

@include('partials.__footer')

