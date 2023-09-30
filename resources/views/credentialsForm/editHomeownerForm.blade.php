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
          EDIT HOMEOWNER DETAILS FORM
        </h2>
      </div>
      <div class="card-body">

        <form action="{{ route('api.update', ['id' => $homeowner->id]) }}" method="POST" >

        @csrf
        @method('PUT')

          <input type="hidden" name="form_type" value="editHomeownerForm">

          <label for="username">User Name:</label>
          <input type="text" id="username" name="user_name" value="{{$homeowner->user_name}}" required>

          <label for="firstname">First Name:</label>
          <input type="text" id="firstname" name="first_name" value="{{$homeowner->first_name}}" required>
  
          <label for="lastname">Last Name:</label>
          <input type="text" id="lastname" name="last_name" value="{{$homeowner->last_name}}" required>
      
          <label for="contactnumber">Contact Number:</label>
          <input type="text" id="contactnumber" name="contact_number" value="{{$homeowner->contact_number}}" required>
  
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" value="{{$homeowner->email}}" required>
  
          <label for="manual_visit_option">Manual Visit Option:</label>
            <select class="form-select" id="manual_visit_option" name="manual_visit_option">
              <option value="0" @if($homeowner->manual_visit_option == 0) selected @endif>Do not Allow</option>
              <option value="1" @if($homeowner->manual_visit_option == 1) selected @endif>Allow</option>
            </select>
      
          <label for="block_no">Block Number:</label>
          <input type="text" id="block_no" name="block_no" value="{{$homeowner->block_no}}" required>
        
          <label for="lot_no">Lot Number:</label>
          <input type="text" id="lot_no" name="lot_no" value="{{$homeowner->lot_no}}" required>

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
            <br>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $(document).on("click", "#addMember", function() {
      let newField = '<div class="inputField"><input type="text" name="family_member[]" required /><button type="button" class="removeMember">Delete</button></div>';
      $(newField).appendTo("#familyInputContainer");
    });

    $(document).on("click", ".removeMember", function() {
      $(this).parent('.inputField').remove();
    });
  });
</script>
