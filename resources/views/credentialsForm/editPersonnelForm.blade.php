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

        <form action="{{ route('api.update', ['id' => $personnel->id]) }}" method="POST" >

        @method('PUT')
        @csrf
        
          <input type="hidden" name="form_type" value="editPersonnelForm">

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
          <button class="btn btn-danger" onclick="history.back()"> Cancel </button>
      </div>
    </div>
  </div>

</html>
</body>

@include('partials.__footer')

