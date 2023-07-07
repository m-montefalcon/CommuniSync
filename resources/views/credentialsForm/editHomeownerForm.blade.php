@include('partials.__header')
<h1>EDIT HOMEOWNER DETAILS FORM</h1>
<form action="{{ route('api.update', ['id' => $homeowner->id]) }}" method="POST" >

@csrf
@method('PUT')
<input type="hidden" name="form_type" value="editHomeownerForm">

<br>
  <label for="username">User Name:</label>
  <input type="text" id="username" name="user_name" value="{{$homeowner->user_name}}" required>
<br>
  <label for="firstname">First Name:</label>
  <input type="text" id="firstname" name="first_name" value="{{$homeowner->first_name}}" required>
<br>
  <label for="lastname">Last Name:</label>
  <input type="text" id="lastname" name="last_name" value="{{$homeowner->last_name}}" required>
<br>
  <label for="contactnumber">Contact Number:</label>
  <input type="text" id="contactnumber" name="contact_number" value="{{$homeowner->contact_number}}" required>
<br>
  <label for="email">Email:</label>
  <input type="email" id="email" name="email" value="{{$homeowner->email}}" required>
<br>
  <label for="manual_visit_option">Manual Visit Options</label>
    <select id="manual_visit_option" name="manual_visit_option">
        <option value="0" @if($homeowner->manual_visit_option == 0) selected @endif>0</option>
        <option value="1" @if($homeowner->manual_visit_option == 1) selected @endif>1</option>
    </select>
<br>
  <label for="house_no">House Number:</label>
  <input type="text" id="house_no" name="house_no" value="{{$homeowner->house_no}}" required>
<br>

  <label for="family_member">Family Member</label>
  <input type="text" id="family_member" name="family_member" value="{{$homeowner->family_member}}" required>
  
<br>
  <button type="submit">Update</button>

  
</form>
<br>
<form action= "{{ route ('api.delete', ['id'=> $homeowner->id]) }}" method="POST">
    @method('DELETE')
    @csrf
    <button type = 'submit'>Delete</button>
</form>

@include('partials.__footer')

