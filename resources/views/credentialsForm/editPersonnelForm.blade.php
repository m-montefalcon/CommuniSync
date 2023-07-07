@include('partials.__header')
<h1>EDIT PERSONNEL DETAILS FORM</h1>
<form action="{{ route('api.update', ['id' => $personnel->id]) }}" method="POST" >

@csrf
@method('PUT')
  <input type="hidden" name="form_type" value="editPersonnelForm">

  <label for="username">User Name:</label>
  <input type="text" id="username" name="user_name" value="{{$personnel->user_name}}" required>
  
  <label for="firstname">First Name:</label>
  <input type="text" id="firstname" name="first_name" value="{{$personnel->first_name}}" required>
  
  <label for="lastname">Last Name:</label>
  <input type="text" id="lastname" name="last_name" value="{{$personnel->last_name}}" required>
  
  <label for="contactnumber">Contact Number:</label>
  <input type="text" id="contactnumber" name="contact_number" value="{{$personnel->contact_number}}" required>
  
  <label for="email">Email:</label>
  <input type="email" id="email" name="email" value="{{$personnel->email}}" required>
  <br>
  <button type="submit">Update</button>
</form>
<br>
<form action= "{{ route ('api.delete', ['id'=> $personnel->id]) }}" method="POST">
    @method('DELETE')
    @csrf
    <button type = 'submit'>Delete</button>
</form>

@include('partials.__footer')

