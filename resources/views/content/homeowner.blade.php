@include('partials.__header')
@include('components.nav')
    <h1>homeowner</h1>    
    <table>
        <thead>
            <tr>
            <th>User Name</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Contact Number</th>
            <th>Email</th>
            <th>House Number</th>
            <th>Family Member</th>
            <th>Manual Visit Option</th>
            <th>Role</th>
            </tr>
        </thead>
        <tbody>
            @foreach($homeowners as $homeowner)
            <tr>
            <td>{{$homeowner->user_name}}</td>
            <td>{{$homeowner->first_name}}</td>
            <td>{{$homeowner->last_name}}</td>
            <td>{{$homeowner->contact_number}}</td>
            <td>{{$homeowner->email}}</td>
            <td>{{$homeowner->house_no}}</td>
            <td>{{$homeowner->family_member}}</td>
            <td>{{$homeowner->manual_visit_option}}</td>
            <td>{{$homeowner->role}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@include('partials.__footer')