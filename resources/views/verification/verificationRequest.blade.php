@include('partials.__header')
@include('components.nav')
<html>

<head>
    <title> Request Verification </title>
    <link rel="stylesheet" href="{{ asset('css/accessControl.css') }}">
    <link rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="header">
                        <h2>
                            VERIFICATION REQUESTS
                        </h2>
                    </div>   
                <div class="card">
                    <div class="top-table">
                        <a class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" id="searchInput" placeholder="Search...">
                        </a>                        
                    </div>
                    <div class="card-body">
                        <div id="table">
                            <table class="table table-bordered table-stripe">
                                <tbody>
                                    <tr>
                                        <th>#</th>
                                        <th>ID</th>
                                        <th>User Name</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Contact Number</th>
                                        <th>Email</th>
                                        <th>Block Number</th>
                                        <th>Lot Number</th>
                                        <th>Family Member</th>
                                        <th>Approve</th>
                                    </tr>
                                    @foreach($verifyRequests as $request)
                                    <tr>
                                        <td>{{$request->id}}</td>
                                        <td>{{$request->user_id}}</td>
                                        <td>{{$request->user->user_name}}</td>
                                        <td>{{$request->user->first_name}}</td>
                                        <td>{{$request->user->last_name}}</td>
                                        <td>{{$request->user->contact_number}}</td>
                                        <td>{{$request->user->email}}</td>
                                        <td>{{ $request->block_no}}</td>
                                        <td>{{ $request->lot_no }}</td>
                                        <td>
                                            @php
                                                $familyMembersString = $request->family_member;
                                                // Remove square brackets and backslashes 
                                                $familyMembersString = str_replace(['[', ']', '\\', '"'], '', $familyMembersString);
                                                // Split the string by comma and trim whitespace
                                                $familyMembersArray = explode(',', $familyMembersString);
                                            @endphp

                                            @if (!empty($familyMembersArray) && $familyMembersArray[0] !== 'null')
                                                {{ implode(", ", $familyMembersArray) }}
                                            @else
                                                No member included
                                            @endif
                                        </td>
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

    <script>
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