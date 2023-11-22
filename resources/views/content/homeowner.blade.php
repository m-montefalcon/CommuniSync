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
                <div class="header">
                    <h2>
                        HOMEOWNER
                    </h2>
                </div>   
                <div class="card">
                    <div class="top-table">
                        <a class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" id="searchInput" placeholder="Search...">
                        </a>  
                        <a class="add-btn" href="{{ route('registerHomeowner') }}">
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
                                        <th>House Number</th>
                                        <th>Family Member</th>
                                        <th>Manual Visit Option</th>
                                    </tr>
                                    @foreach($homeowners as $homeowner)
                                    <tr class="clickable-row" data-href="{{ route('homeownerId', ['id' => $homeowner->id]) }}" method="GET">
                                        <td>{{$homeowner->user_name}}</td>                                      
                                        <td>{{$homeowner->first_name}}</td>
                                        <td>{{$homeowner->last_name}}</td>
                                        <td>{{$homeowner->contact_number}}</td>
                                        <td>{{$homeowner->email}}</td>
                                        <td> B {{ $homeowner->block_no }} - L {{ $homeowner->lot_no }}</td>
                                            @php
                                            // Attempt to decode the JSON string into an array
                                            $family_members = json_decode($homeowner->family_member, true);

                                            // Check if decoding was successful and if it is an array
                                            if (is_array($family_members)) {
                                                // Use implode to create a comma-separated string
                                                $commaSeparatedMember = implode(", ", $family_members);
                                            } else {
                                                // Handle the case where decoding fails or the result is not an array
                                                $commaSeparatedMember = "Invalid data format";
                                            }
                                        @endphp
                                        <td>{{ $commaSeparatedMember }}</td>
                                        <td>
                                            @if ($homeowner->manual_visit_option == 0)
                                                Do not allow
                                            @elseif ($homeowner->manual_visit_option == 1)
                                                Allow
                                            @endif
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