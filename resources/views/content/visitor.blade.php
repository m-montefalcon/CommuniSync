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
                        VISITOR
                    </h2>
                </div>  
                <div class="card">               
                    <div class="top-table">
                        <a class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" id="searchInput" placeholder="Search...">
                        </a>  
                        <a class="add-btn" href="{{ route('registerVisitor') }}">
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
                                    @foreach($visitors as $visitor)
                                    <tr class="clickable-row" data-href="{{ route('visitorId', ['id' => $visitor->id]) }}" method="GET">
                                        <td class="tooltip">
                                            <span class="tooltiptext">
                                                {{$visitor->last_name}} {{$visitor->first_name}}
                                                <br>
                                                @if ($visitor->photo)
                                                    <img src="http://127.0.0.1:8000/storage/{{ Auth::user()->photo }}" alt="User Photo">
                                                @else
                                                    <img src="Assets/default-user-profile.jpg" alt="Default Photo">
                                                @endif
                                                <br>
                                                @if($visitor->role == 1)
                                                    Visitor
                                                @elseif($visitor->role == 2)
                                                    Homeowner
                                                @elseif($visitor->role == 3)
                                                    Security Personnel
                                                @elseif($visitor->role == 4)
                                                    Admin
                                                @else
                                                    Unknown Role
                                                @endif
                                                <br>
                                                    <button class="your-button-class">Your Button</button>
                                            </span>
                                            {{$visitor->user_name}}
                                        </td>
                                        <td>{{$visitor->first_name}}</td>
                                        <td>{{$visitor->last_name}}</td>
                                        <td>{{$visitor->contact_number}}</td>
                                        <td>{{$visitor->email}}</td>
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
                var names = $(this).find('td:nth-child(3)').text().toLowerCase();

                if (names.includes(searchText)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    </script>

</body>
</html>
@include('partials.__footer')