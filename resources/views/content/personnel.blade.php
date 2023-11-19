@include('partials.__header')
@include('components.nav')
<html>
<head>
  <title> Security Personnel </title>
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
                        SECURITY PERSONNEL
                    </h2>
                </div>   
                <div class="card">  
                    <div class="top-table">
                        <a class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" id="searchInput" placeholder="Search...">
                        </a>  
                        <a class="add-btn" href="{{ route('registerPersonnel') }}">
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
                                    @foreach($personnels as $personnel)
                                    <tr class="clickable-row" data-href="{{ route('personnelId', ['id' => $personnel->id]) }}" method="GET">
                                        <td>{{$personnel->user_name}}</td>
                                        <td>{{$personnel->first_name}}</td>
                                        <td>{{$personnel->last_name}}</td>
                                        <td>{{$personnel->contact_number}}</td>
                                        <td>{{$personnel->email}}</td>
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