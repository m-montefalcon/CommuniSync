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
          EDIT VISITOR DETAILS FORM
        </h2>
      </div>
      <div class="card-body">

        <form action="{{ route('api.update', ['id' => $visitor->id]) }}" method="POST">
        
        @method('PUT')
        @csrf
        
          <input type="hidden" name="form_type" value="editVisitorForm">

          <label for="username">User Name:</label>
          <input type="text" id="username" name="user_name" value="{{$visitor->user_name}}" required>
          
          <label for="firstname">First Name:</label>
          <input type="text" id="firstname" name="first_name" value="{{$visitor->first_name}}" required>
          
          <label for="lastname">Last Name:</label>
          <input type="text" id="lastname" name="last_name" value="{{$visitor->last_name}}" required>
          
          <label for="contactnumber">Contact Number:</label>
          <input type="text" id="contactnumber" name="contact_number" value="{{$visitor->contact_number}}" required>
          
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" value="{{$visitor->email}}" required>
          
          <br>
          
          <button type="submit" class="btn btn-primary">Update</button>

        </form>

        <!-- <form action= "{{ route ('api.delete', ['id'=> $visitor->id]) }}" method="POST">
        @method('DELETE')
        @csrf
          <button type="submit" class="btn btn-danger">Delete</button>
        </form> -->
        <button class="btn btn-danger" onclick="history.back()"> Cancel </button>

      </div>
    </div>
  </div>
</html>
</body>

@include('partials.__footer')

