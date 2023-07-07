@include('partials.__header')
@include('components.nav')
    <h1>admin</h1>    
    <table>
        <thead>
            <tr>
            <th>User Name</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Contact Number</th>
            <th>Email</th>
            <th>Role</th>
            <th>View</th>
            </tr>
        </thead>
        <tbody>
            @foreach($admins as $admin)
            <tr>
            <td>{{$admin->user_name}}</td>
            <td>{{$admin->first_name}}</td>
            <td>{{$admin->last_name}}</td>
            <td>{{$admin->contact_number}}</td>
            <td>{{$admin->email}}</td> 
            <td>{{$admin->role}}</td>
            <td>
            <form action="/admin/{{$admin->id}}" method="GET">
                @csrf
                <button type="submit">View</button>
            </form>
            </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@include('partials.__footer')