@include('partials.__header')
@include('components.nav')
<html>
<head>
  <title> Request Verification </title>
  <link rel="stylesheet" href="{{ asset('css/user.css') }}">
  <link rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2>
                            VERIFICATION REQUESTS
                        </h2>
                    </div>   
                    <div class="card-body">
                        <div id="table">
                            <table class="table table-bordered table-stripe">
                                <tbody>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
@include('partials.__footer')