@include('partials.__header')
@include('components.nav')
    <h1>personnel</h1>    
    <table>
    <thead>
        <tr>
            <th>User Name</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Contact Number</th>
            <th>Email</th>
            <th>View</th>
        </tr>
    </thead>
    <tbody>
        @foreach($personnels as $personnel)
        <tr>
            <td>{{$personnel->user_name}}</td>
            <td>{{$personnel->first_name}}</td>
            <td>{{$personnel->last_name}}</td>
            <td>{{$personnel->contact_number}}</td>
            <td>{{$personnel->email}}</td>
            <td>{{$personnel->role}}</td>
            <td>
            <form action="{{ route('personnelId', ['id' => $personnel->id]) }}" method="GET">
                @csrf
                <button type="submit">View</button>
            </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@include('partials.__footer')