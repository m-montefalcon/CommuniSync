<!DOCTYPE html>
<html>
<head>
  <title>Logbook</title>
  <link rel="stylesheet" href="{{ asset('css/user.css') }}">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css">
</head>
<body>
@include('partials.__header')
@include('components.nav')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>LOGBOOK</h2>
                </div>
                <div class="card-body">
                    <div id="table">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>V-ID</th>
                                    <th>V-Name</th>
                                    <th>H-ID</th>
                                    <th>H-Name</th>
                                    <th>S-ID</th>
                                    <th>S-Name</th>
                                    <th>A-ID</th>
                                    <th>A-Name</th>
                                    <th>Contact Number</th>
                                    <th>Visit Date</th>
                                    <th>Visit Members</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($fetchAllLb as $fetchLogbook)
                                <tr>
                                    <td>{{ $fetchLogbook->visitor_id }}</td>
                                    <td>{{ optional($fetchLogbook->visitor)->first_name . ' ' . optional($fetchLogbook->visitor)->last_name }}</td>
                                    <td>{{ $fetchLogbook->homeowner_id }}</td>
                                    <td>{{ optional($fetchLogbook->homeowner)->first_name . ' ' . optional($fetchLogbook->homeowner)->last_name }}</td>
                                    <td>{{ $fetchLogbook->personnel_id }}</td>
                                    <td>{{ optional($fetchLogbook->personnel)->first_name . ' ' . optional($fetchLogbook->personnel)->last_name }}</td>
                                    <td>{{ $fetchLogbook->admin_id }}</td>
                                    <td>{{ optional($fetchLogbook->admin)->first_name . ' ' . optional($fetchLogbook->admin)->last_name }}</td>
                                    <td>{{ $fetchLogbook->contact_number }}</td>
                                    <td>{{ $fetchLogbook->visit_date }}</td>
                                    
                                    @php
                                        $visitMembers = json_decode($fetchLogbook->visit_members);
                                    @endphp

                                    @if ($visitMembers === null)
                                        <td>No member found</td>
                                    @elseif (is_array($visitMembers))
                                        <td>{{ implode(",", $visitMembers) }}</td>
                                    @else
                                        <td>{{ $visitMembers }}</td> <!-- Handle other data types, e.g., string or object -->
                                    @endif
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

@include('partials.__footer')
</body>
</html>
