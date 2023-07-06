@include('partials.__header')
@include('components.nav')
    <h1>visitor</h1>    
    <table>
    <thead>
        <tr>
            <th>User Name</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Contact Number</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        @foreach($visitors as $visitor)
        <tr>
            <td>{{$visitor->user_name}}</td>
            <td>{{$visitor->first_name}}</td>
            <td>{{$visitor->last_name}}</td>
            <td>{{$visitor->contact_number}}</td>
            <td>{{$visitor->email}}</td>
            <td>{{$visitor->role}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@include('partials.__footer')