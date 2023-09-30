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
                            VISITOR
                        </h2>
                        <a class="add-btn" href="{{ route('registerVisitor') }}">
                            <i class="fa-solid fa-user-plus"></i> Add Visitor
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
                                    </tr>                       
                                    @foreach($visitors as $visitor)
                                    <tr class="clickable-row" data-href="{{ route('visitorId', ['id' => $visitor->id]) }}" method="GET">
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