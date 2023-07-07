@include('partials.__header')
<h1>EDIT VISITOR DETAILS FORM</h1>
<form action="{{ route('api.update', ['id' => $visitor->id]) }}" method="POST" >

@csrf
@method('PUT')
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
  <button type="submit">Update</button>
</form>
<br>
<form action= "{{ route ('api.delete', ['id'=> $visitor->id]) }}" method="POST">
    @method('DELETE')
    @csrf
    <button type = 'submit'>Delete</button>
</form>

@include('partials.__footer')

