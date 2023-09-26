@include('partials.__header')
@include('components.nav')
<html>
<head>
  <title> Complaints </title>
  <link rel="stylesheet" href="{{ asset('css/announcement.css') }}">
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
                            COMPLAINTS
                        </h2>
                    </div>
                    <div class="card-body">
                        <div id="table">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                <tr>
                                    <th>Title</th>
                                    <th>Date</th>
                                </tr>     
                                @foreach ($fetchALlComplaints as $complaint)
                                <tr>
                                    <td>
                                        <div class="card-title">
                                            <div class="card-body">
                                                <!-- {{ $announcement->admin->first_name . ' ' . $announcement->admin->last_name }} -->
                                                {{ $complaint->complaint_date }}
                                                <!-- {{ $announcement->announcement_description }} -->
                                                <!-- {{ $announcement->announcement_date }} -->
                                                <!-- {{ $announcement->role }}
                                                {{ $announcement->announcement_photo }} -->
                                            </div>
                                        </div>                   
                                    </td>
                                    <td>
                                        <div class="card-date">
                                            <div class="card-body">
                                                {{ $complaint->complaint_status }}
                                            </div>
                                        </div>                   
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
</body>
</html>

@include('partials.__footer')