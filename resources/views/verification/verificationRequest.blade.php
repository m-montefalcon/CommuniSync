@include('partials.__header')
@include('components.nav')
    <h1>VERIFICATION REQUESTS</h1>    
    <table>
        <thead>
            <tr>
            <th>ID</th>

            <th>User Name</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Contact Number</th>
            <th>Email</th>
            <th>House Number</th>
            <th>Family Member</th>
            <!-- <th>Manual Visit Option</th> -->
            <!-- <th>Role</th> -->
            <th>View</th>
            </tr>
        </thead>
        <tbody>
            @foreach($verifyRequests as $request)
            <tr>
            <td>{{$request->id}}</td>

            <td>{{$request->user_name}}</td>
            <td>{{$request->first_name}}</td>
            <td>{{$request->last_name}}</td>
            <td>{{$request->contact_number}}</td>
            <td>{{$request->email}}</td>
            <td>{{$request->house_no}}</td>
            <td>{{$request->family_member}}</td>
            <!-- <td>{{$request->manual_visit_option}}</td> -->
            <!-- <td>{{$request->role}}</td> -->
            <td>
            <form action="{{ route('api.approved.verification', ['id' => $request->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <button type="submit">APPROVE</button>
            </form>


            </td>
           
            </tr>
            @endforeach
        </tbody>
    </table>
@include('partials.__footer')