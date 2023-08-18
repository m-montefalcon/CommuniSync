@include('partials.__header')
@include('components.nav')
<html>
<head>
  <title> Homeowner </title>
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
                            HOMEOWNER
                        </h2>
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
                                        <th>House Number</th>
                                        <th>Family Member</th>
                                        <th>Manual Visit Option</th>
                                        <th>Role</th>
                                        <!-- <th>View</th> -->
                                    </tr>
                                    @foreach($homeowners as $homeowner)
                                    <tr class="clickable-row" data-href="{{ route('homeownerId', ['id' => $homeowner->id]) }}" method="GET">
                                        <td>{{$homeowner->user_name}}</td>
                                        <td>{{$homeowner->first_name}}</td>
                                        <td>{{$homeowner->last_name}}</td>
                                        <td>{{$homeowner->contact_number}}</td>
                                        <td>{{$homeowner->email}}</td>
                                        <td>{{$homeowner->house_no}}</td>
                                        <td>{{$homeowner->family_member}}</td>
                                        <td>{{$homeowner->manual_visit_option}}</td>
                                        <td>{{$homeowner->role}}</td>
                                        <!-- <td>
                                            <form action="{{ route('homeownerId', ['id' => $homeowner->id]) }}" method="GET">
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