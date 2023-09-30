@include('partials.__header')
@include('components.nav')
<html>
<head>
  <title> Visitor </title>
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
                            ADMIN
                        </h2>
                        <a class="add-btn" href="{{ route('registerAdmin') }}">
                            <i class="fa-solid fa-user-plus"></i> Add Admin
                        </a>
                    </div>   
                    <div class="card-body">
                        <div id="table">
                            <table class="table table-bordered table-stripe">
                                <tbody>
                                    <tr>
                                        <th>User Name</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Contact Number</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <!-- <th>View</th> -->
                                    </tr>
                                    @foreach($admins as $admin)
                                    <tr class="clickable-row" data-href="{{ route('adminId', ['id' => $admin->id]) }}" method="GET">
                                        <td>{{$admin->user_name}}</td>
                                        <td>{{$admin->first_name}}</td>
                                        <td>{{$admin->last_name}}</td>
                                        <td>{{$admin->contact_number}}</td>
                                        <td>{{$admin->email}}</td> 
                                        <td>{{$admin->role}}</td>
                                        <!-- <td>
                                            <form action="{{ route('adminId', ['id' => $admin->id]) }}" method="GET">
                                                @csrf
                                                <button type="submit">View</button>
                                            </form>
                                        </td> -->
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Add a click event to all elements with the class "clickable-row"
            $(".clickable-row").click(function() {
                // Get the URL from the "data-href" attribute of the clicked <tr>
                var url = $(this).data("href");
                // Navigate to the URL
                window.location.href = url;
            });
        });
    </script>
    
</body>
</html>
@include('partials.__footer')