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
    <div class="card">
      <div class="card-header">
        <h2>
          EDIT ADMIN DETAILS FORM
        </h2>
      </div>
      <div class="card-body">

        <form action="{{ route('api.update', ['id' => $admin->id]) }}" method="POST" >

        @csrf
        @method('PUT')
        
          <input type="hidden" name="form_type" value="editAdminForm">

          <label for="username">User Name:</label>
          <input type="text" id="username" name="user_name" value="{{$admin->user_name}}" required>
          
          <label for="firstname">First Name:</label>
          <input type="text" id="firstname" name="first_name" value="{{$admin->first_name}}" required>
          
          <label for="lastname">Last Name:</label>
          <input type="text" id="lastname" name="last_name" value="{{$admin->last_name}}" required>
          
          <label for="contactnumber">Contact Number:</label>
          <input type="text" id="contactnumber" name="contact_number" value="{{$admin->contact_number}}" required>
          
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" value="{{$admin->email}}" required>

          <br>

          <button type="submit" class="btn btn-primary">Update</button>

        </form>
    
        <form action= "{{ route ('api.delete', ['id'=> $admin->id]) }}" method="POST">
        @method('DELETE')
        @csrf
          <button type="submit" class="btn btn-danger">Delete</button>
        </form>

      </div>
    </div>
  </div>
</html>
</body>

@include('partials.__footer')

