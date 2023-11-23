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
        EDIT HOMEOWNER DETAILS FORM
      </h2>
    </div>
    <div class="card">
      <div class="card-body">
        @auth        
          <div class="user-profile">
            <div class="card-profile">
              @if ($homeowner->photo)
              <img src="{{ asset('storage/' . $homeowner->photo) }}" alt="User Photo">
              @else
                <img src="{{ asset('Assets/default-user-profile.jpg') }}" alt="Default Photo">
              @endif
                <h3>{{ $homeowner->first_name}}  {{ $homeowner->last_name}}</h3>
              @if($homeowner->role == 1)
                  Visitor
              @elseif($homeowner->role == 2)
                  Homeowner
              @elseif($homeowner->role == 3)
                  Security Personnel
              @elseif($homeowner->role == 4)
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
                    <td> {{ $homeowner->user_name }} </td>
                  </tr>
                  <tr>
                    <th width="30%"> Full Name </th>
                    <td width="2%"> : </td>
                    <td> {{ $homeowner->first_name}}  {{ $homeowner->last_name}} </td>
                  </tr>
                  <tr>
                    <th width="30%"> Email </th>
                    <td width="2%"> : </td>
                    <td> {{ $homeowner->email }} </td>
                  </tr>
                  <tr>
                    <th width="30%"> Contact Number </th>
                    <td width="2%"> : </td>
                    <td> {{ $homeowner->contact_number }} </td>
                  </tr>
                  <tr>
                    <th width="30%"> House No. </th>
                    <td width="2%"> : </td>
                    <td> B {{ $homeowner->block_no }} - L {{ $homeowner->lot_no }}</td>
                  </tr>
                  <tr>
                    <th width="30%"> Visitation </th>
                    <td width="2%"> : </td>
                    <td>
                      @if($homeowner->manual_visit_option == 1)
                          Manual Visit Allowed
                      @else
                          Manual Visit Not Allowed
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <th width="30%"> Family Members </th>
                    <td width="2%"> : </td>
                    <td>
                      @php
                        $familyMembers = old('family_member', $homeowner->family_member ?? []);
                        $familyMembersString = implode(', ', $familyMembers);
                      @endphp
                        {{ $familyMembersString }}
                    </td>
                  </tr>
                </table>
              </div>
            </div> 
          </div>
        @endauth

        <div id="editForm" style="display: none;">

        <form action="{{ route('api.update', ['id' => $homeowner->id]) }}" method="POST" >

        @csrf
        @method('PUT')

        <input type="hidden" name="form_type" value="editHomeownerForm">

        <div class="input-box">
          <div class="input-group-prepend">
            <span class="input-icon"> 
              <i class="fa-solid fa-user"></i> 
            </span>
          </div>
          <label for="user_name">Username:</label>
          <input type="text" id="user_name" name="user_name" value="{{$homeowner->user_name}}" required>
        </div>
        
        <div class="user-details">
          <div class="input-box">
            <div class="input-group-prepend">
              <span class="input-icon"> 
                <i class="fa-solid fa-id-card"></i> 
              </span>
            </div>
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" value="{{$homeowner->first_name}}" required>
          </div>

          <div class="input-box">
            <div class="input-group-prepend">
              <span class="input-icon"> 
                <i class="fa-solid fa-id-card"></i> 
              </span>
            </div>
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" value="{{$homeowner->last_name}}" required>
          </div>

          <div class="input-box">
            <div class="input-group-prepend">
              <span class="input-icon"> 
                <i class="fa-solid fa-phone"></i> 
              </span>
            </div>
            <label for="contact_number">Contact Number:</label>
            <input type="text" id="contact_number" name="contact_number" value="{{$homeowner->contact_number}}" maxlength="11" required>
          </div>

          <div class="input-box">
            <div class="input-group-prepend">
              <span class="input-icon"> 
                <i class="fa-solid fa-envelope"></i> 
              </span>
            </div>
            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" value="{{$homeowner->email}}" required>
          </div>

          <div class="input-box">
            <div class="input-group-prepend">
              <span class="input-icon"> 
                <i class="fa-solid fa-map-location-dot"></i> 
              </span>
            </div>
            <label for="block_no">Block Number:</label>
            <input type="text" id="block_no" name="block_no" value="{{$homeowner->block_no}}" required>
          </div>

          <div class="input-box">
            <div class="input-group-prepend">
              <span class="input-icon"> 
                <i class="fa-solid fa-map-location-dot"></i> 
              </span>
            </div>
            <label for="lot_no">Lot Number:</label>
            <input type="text" id="lot_no" name="lot_no" value="{{$homeowner->lot_no}}" required>
          </div>
        </div>
    
          <div class="input-box">
            <div class="input-group-prepend">
              <span class="input-icon"> 
                <i class="fa-solid fa-person-walking-dashed-line-arrow-right"></i>
              </span>
            </div>   
            <label for="manual_visit_option">Manual Visit Option:</label>
              <select class="form-select" id="manual_visit_option" name="manual_visit_option">
                <option value="0" @if($homeowner->manual_visit_option == 0) selected @endif>Do not Allow</option>
                <option value="1" @if($homeowner->manual_visit_option == 1) selected @endif>Allow</option>
              </select>
          </div>

          <label for="family_member">Family Members:</label>
            @php $familyMembers = old('family_member', $homeowner->family_member ?? []); @endphp
            <div id="familyInputContainer">
                @foreach($familyMembers as $index => $member)
                <div class="input-box-member">
                    <span class="icon-member">
                      <i class="fa-solid fa-people-roof"></i>
                    </span>
                    <input class="input-member" type="text" name="family_member[]" value="{{ $member }}" required>
                    <button type="button" class="removeMember">Delete</button>
                </div>
                @endforeach
            </div>
            <button type="button" id="addMember">Add member</button>
            <br>
            <br>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
          <a id="button" href="{{ route('homeowner') }}" class="btn btn-danger">Cancel</a>
      </div>
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <script>
    document.getElementById('addMember').addEventListener('click', function() {
      var container = document.getElementById('familyInputContainer');
      var newInput = document.createElement('div');
      newInput.classList.add('input-box-member');
      newInput.innerHTML = `
          <span class="icon-member">
            <i class="fa-solid fa-people-roof"></i>
          </span>
          <input class="input-member" type="text" name="family_member[]" required>
          <button type="button" class="removeMember">Delete</button>`;
      container.appendChild(newInput);
    });

    document.addEventListener('click', function(event) {
      if (event.target && event.target.classList.contains('removeMember')) {
        event.target.closest('.input-box-member').remove();
      }
    });

    document.getElementById('editButton').addEventListener('click', function() {
      var editForm = document.getElementById('editForm');
      editForm.style.display = (editForm.style.display === 'none' || editForm.style.display === '') ? 'block' : 'none';
    });

  </script>
  
</body>  
</html>

@include('partials.__footer')


