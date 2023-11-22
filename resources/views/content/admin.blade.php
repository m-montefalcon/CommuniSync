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
                <div class="header">
                    <h2>
                        ADMIN
                    </h2>
                </div>   
                <div class="card">
                    <div class="top-table">
                        <a class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" id="searchInput" placeholder="Search...">
                        </a>  
                        <a class="add-btn" href="{{ route('registerAdmin') }}">
                            <i class="fa-solid fa-user-plus"></i>
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
                                    </tr>
                                    @foreach($admins as $admin)
                                    <tr class="clickable-row" data-href="{{ route('adminId', ['id' => $admin->id]) }}" method="GET">
                                        <td class="tooltip">
                                            <span class="tooltiptext">
                                                {{$admin->last_name}} {{$admin->first_name}}
                                                <br>
                                                @if ($admin->photo)
                                                    <img src="http://127.0.0.1:8000/storage/{{ Auth::user()->photo }}" alt="User Photo">
                                                @else
                                                    <img src="{{ asset('Assets/default-user-profile.jpg') }}" alt="Default Photo">
                                                @endif
                                            </span>
                                            {{$admin->user_name}}
                                        </td>
                                        <td>{{$admin->first_name}}</td>
                                        <td>{{$admin->last_name}}</td>
                                        <td>{{$admin->contact_number}}</td>
                                        <td>{{$admin->email}}</td> 
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

        $('#searchInput').on('input', function() {
            var searchText = $(this).val().toLowerCase();

            $('.clickable-row').each(function() {
                var row = $(this);
                var found = false;

                row.find('td').each(function() {
                    var cellText = $(this).text().toLowerCase();

                    if (cellText.includes(searchText)) {
                        found = true;
                        return false;
                    }
                });

                if (found) {
                    row.show();
                } else {
                    row.hide();
                }
            });
        });
    </script>
    
</body>
</html>
@include('partials.__footer')