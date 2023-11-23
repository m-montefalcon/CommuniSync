@include('partials.__header')
@include('components.nav')
<html>
<head>
  <title> Logbook </title>
  <link rel="stylesheet" href="{{ asset('css/logbook.css') }}">
  <link rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css">
  <style>
    .top-table {
    display: flex;
    align-items: center;
}

.date-filter {
    display: flex;
}

.filter-set {
    margin-right: 10px; /* Adjust the margin as needed for spacing */
}

.filter-button {
    margin-left: 10px; /* Adjust the margin as needed for spacing */
}

</style>
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
    <div class="search-box">
        <form action="{{ route('admin.get.logbook') }}" method="GET">
            <i class="fas fa-search"></i>
            <input type="text" name="search" id="searchInput" class="form-control" value="{{request()->input('search')}}">
            <button type="submit">Search</button>
        </form>
    </div>

    <div class="date-filter">
        <div class="filter-set">
            <label>From:</label>
            <select class="date-select" name="fromDay">
                <!-- Days -->
                <?php for ($i = 1; $i <= 31; $i++) { ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php } ?>
            </select>
            <select class="date-select" name="fromMonth">
                <!-- Months -->
                <option value="1">January</option>
                <option value="2">February</option>
                <option value="3">March</option>
                <option value="4">April</option>
                <option value="5">May</option>
                <option value="6">June</option>
                <option value="7">July</option>
                <option value="8">August</option>
                <option value="9">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
            </select>
            <select class="date-select" name="fromYear">
                <!-- Years -->
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
            </select>
        </div>
        <div class="filter-set">
            <label>To:</label>
            <select class="date-select" name="toDay">
                <!-- Days -->
                <?php for ($i = 1; $i <= 31; $i++) { ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php } ?>
            </select>
            <select class="date-select" name="toMonth">
                <!-- Months -->
                <option value="1">January</option>
                <option value="2">February</option>
                <option value="3">March</option>
                <option value="4">April</option>
                <option value="5">May</option>
                <option value="6">June</option>
                <option value="7">July</option>
                <option value="8">August</option>
                <option value="9">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
            </select>
            <select class="date-select" name="toYear">
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                
            </select>
        </div>
  
        <button type="button" onclick="filterLogbook()" class="filter-button">Filter</button>
    </div>
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
    <script>
        function filterLogbook() {
            var fromDay = document.getElementsByName("fromDay")[0].value;
            var fromMonth = document.getElementsByName("fromMonth")[0].value;
            var fromYear = document.getElementsByName("fromYear")[0].value;
            var toDay = document.getElementsByName("toDay")[0].value;
            var toMonth = document.getElementsByName("toMonth")[0].value;
            var toYear = document.getElementsByName("toYear")[0].value;

            if (!fromDay || !fromMonth || !fromYear || !toDay || !toMonth || !toYear) {
                alert('Please select a complete date range.');
                return;
            }

            var apiUrl = "{{ route('admin.get.logbook.filter') }}?fromDay=" + fromDay +
                "&fromMonth=" + fromMonth + "&fromYear=" + fromYear +
                "&toDay=" + toDay + "&toMonth=" + toMonth + "&toYear=" + toYear;

            window.open(apiUrl, '_blank');
        }
    </script>



</body>
</html>
@include('partials.__footer')