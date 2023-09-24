@include('partials.__header')
@include('components.nav')
<html>
<head>
  <title> Access Control </title>
  <link rel="stylesheet" href="{{ asset('css/accessControl.css') }}">
  <link rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2>
                            ACCESS CONTROL
                        </h2>
                    </div>   
                    <div class="card-body">
                        <div id="table">
                            <table class="table table-bordered table-stripe">
                                <tbody>
                                    <tr> 
                                        <th>ID</th>
                                        <th>User Name</th>
                                        <th>Visitor Name</th>
                                        <th>User Name</th>
                                        <th>Homeowner Name</th>
                                        <th>Destination Person</th>
                                        <th>Visit Member</th>
                                        <th> Accept </th>
                                        <th> Deny </th>
                                    </tr>                       
                                    @foreach($fetchRequests as $fetchRequest)

                                    <tr>

                                        <td>{{$fetchRequest->id}}</td>
                                        <td>{{$fetchRequest->visitor->user_name }}</td>
                                        <td>{{$fetchRequest->visitor->first_name . ' ' . $fetchRequest->visitor->last_name }}</td>
                                        <td>{{$fetchRequest->homeowner->user_name }}</td>
                                        <td>{{$fetchRequest->homeowner->first_name . ' ' . $fetchRequest->homeowner->last_name }}</td>
                                        <td>{{$fetchRequest->destination_person}}</td>
                                        @php
                                            $visitMembers = json_decode($fetchRequest->visit_members);
                                        @endphp

                                        @if ($visitMembers === null)
                                            <td>No member found</td>
                                        @else
                                            @php
                                                $commaSeparatedMember = implode(",", $visitMembers);
                                            @endphp

                                            <td>{{ $commaSeparatedMember }}</td>
                                        @endif

                                        <td>
                                            <form action="{{ route('api.admin.control.access.validated', $fetchRequest->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-primary">Accept</button>
                                            </form>
                                        </td>  
                                        <td>
                                                <button type="submit" class="btn btn-danger btn-sm">Reject</button>
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
    </script>

</body>
</html>
@include('partials.__footer')