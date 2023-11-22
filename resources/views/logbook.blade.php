@include('partials.__header')
@include('components.nav')
<html>
<head>
  <title> Logbook </title>
  <link rel="stylesheet" href="{{ asset('css/logbook.css') }}">
  <link rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="header">
                    <h2>
                        LOGBOOK
                    </h2>
                </div>
                <div class="card">
                    <div class="top-table">
                        <a class="search-box">
                            <form action="{{ route('admin.get.logbook') }}" method="GET">
                                <i class="fas fa-search"></i>
                                <input type="text" name="search" id="searchInput" class="form-control" value="{{request()->input('search')}}">
                            </form>
                        </a>                        
                    </div>
                    <div class="card-body">
                        <div id="table">
                            <table class="table table-bordered table-striped">    
                                <tbody>              
                                    <tr>
                                        <th>V-ID</th>
                                        <th>V-Name</th>
                                        <th>H-ID</th>
                                        <th>H-Name</th>
                                        <th>S-ID</th>
                                        <th>S-Name</th>
                                        <th>A-ID</th>
                                        <th>A-Name</th>
                                        <th>Destination Person</th>
                                        <th>Contact Number</th>
                                        <th>Visit In</th>
                                        <th>Visit Out</th>
                                        <th>Visit Members</th>
                                    </tr> 
                                    @foreach($fetchAllLb as $fetchLogbook)
                                    <tr>
                                        <td>
                                            @if($fetchLogbook->visitor_id)
                                                {{ $fetchLogbook->visitor_id }}
                                            @else
                                                MVO
                                            @endif
                                        </td>
                                        <td>
                                            @if(optional($fetchLogbook->visitor)->first_name && optional($fetchLogbook->visitor)->last_name)
                                                {{ optional($fetchLogbook->visitor)->first_name . ' ' . optional($fetchLogbook->visitor)->last_name }}
                                            @else
                                                MANUAL VISIT OPT
                                            @endif
                                        </td>
                                        <td>{{ $fetchLogbook->homeowner_id }}</td>
                                        <td>{{ optional($fetchLogbook->homeowner)->first_name . ' ' . optional($fetchLogbook->homeowner)->last_name }}</td>
                                        <td>{{ $fetchLogbook->personnel_id }}</td>
                                        <td>{{ optional($fetchLogbook->personnel)->first_name . ' ' . optional($fetchLogbook->personnel)->last_name }}</td>
                                        <td>
                                            @if($fetchLogbook->visitor_id)
                                                {{ $fetchLogbook->visitor_id }}
                                            @else
                                                MVO
                                            @endif
                                        </td>
                                        <td>
                                            @if(optional($fetchLogbook->admin)->first_name && optional($fetchLogbook->admin)->last_name)
                                                {{ optional($fetchLogbook->admin)->first_name . ' ' . optional($fetchLogbook->admin)->last_name }}
                                            @else
                                                MANUAL VISIT OPT
                                            @endif
                                        </td>
                                        <td>{{ $fetchLogbook->destination_person }}</td>

                                        <td>{{ $fetchLogbook->contact_number }}</td>
                                        <td>{{ $fetchLogbook->visit_date_in . ' ' . $fetchLogbook->visit_time_in }}</td>
                                        <td>
                                            @if ($fetchLogbook->visit_date_out && $fetchLogbook->visit_time_out)
                                                {{ $fetchLogbook->visit_date_out . ' ' . $fetchLogbook->visit_time_out }}
                                            @else
                                                Currently In
                                            @endif
                                        </td>

                                        @php
                                            $visitMembers = json_decode($fetchLogbook->visit_members);
                                        @endphp

                                        @if ($visitMembers === null)
                                            <td>No member found</td>
                                        @elseif (is_array($visitMembers))
                                            <td>{{ implode(",", $visitMembers) }}</td>
                                        @else
                                            <td>{{ $visitMembers }}</td> 
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center">
                                {{ $fetchAllLb->appends(['search' => $request->search])->links("pagination::bootstrap-4") }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>
</html>
@include('partials.__footer')