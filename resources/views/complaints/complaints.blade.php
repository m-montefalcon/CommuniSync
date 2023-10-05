@include('partials.__header')
@include('components.nav')
<html>
<head>
  <title> Complaints </title>
  <link rel="stylesheet" href="{{ asset('css/complaint.css') }}">
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
                                <tr class="clickable-row" 
                                    data-complaint-title="{{ $complaint->complaint_title }}" 
                                    data-complaint-date="{{ \Carbon\Carbon::parse($complaint->complaint_date)->format('F j, Y') }}"
                                    data-complaint-description="{{ $complaint->complaint_desc }}"
                                    data-complaint-currentStatus="{{ $complaint->complaint_status }}"
                                    data-complaint-updates="{{ $complaint->complaint_updates }}"
                                    data-complaint-sendFrom="{{ $complaint->homeowner->first_name . ' ' . $complaint->homeowner->last_name 
                                        . ' Block ' . $complaint->homeowner->block_no . ' - Lot ' . $complaint->homeowner->lot_no }}"
                                    data-complaint-photo="{{ $complaint->complaint_photo }}"
                                    >
                                    <td>
                                        <div class="card-title">
                                            <div class="card-body">
                                                {{ $complaint->complaint_title }}
                                            </div>
                                        </div>                   
                                    </td>
                                    <td>
                                        <div class="card-date">
                                            <div class="card-body">
                                                {{ \Carbon\Carbon::parse($complaint->complaint_date)->format('F j, Y') }}
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

    <div class="modal-container" id="complaintModalContainer">
        <div class="modal-content">
            <div class="header-container">
                <div class="modal-header">
                    <h1>
                        Complaint Detail
                    </h1>
                </div>
                <span class="close-modal" id="closeModal">&times;</span>
            </div>
            <div class="form-group">
                <label for="complaintTitle">Title:</label>
                <input type="text" class="form-control" id="complaintTitle" readonly>
            </div>
            <div class="form-group">
                <label for="complaintDate">Date:</label>
                <input type="text" class="form-control" id="complaintDate" readonly>
            </div>
            <div class="form-group">
                <label for="complaintDescription">Description:</label>
                <textarea class="form-control" id="complaintDescription" rows="3" readonly></textarea>
            </div>
            <div class="form-group">
                <label for="complaintStatus">Status:</label>
                <input class="form-control" id="complaintStatus" readonly>
            </div>
            <div class="form-group">
                <label for="complaintSendFrom">From:</label>
                <input class="form-control" id="complaintSendFrom" readonly>
            </div>
            <div class="form-group">
                <label for="complaintPhoto">Image:</label>
                <img class="form-control" id="complaintPhoto" src="" alt="Complaint Photo">
            </div>
            <div class="form-group">
                <label for="complaintUpdates">Updates:</label>
                <input class="form-control" id="complaintUpdates" readonly>
            </div>

            <form method="POST" action="{{ route('api.admin.complaint.update', ['id' => $complaint->id]) }}" enctype="multipart/form-data"> 
                @method('PUT')
                @csrf 

                <div class="form-group">
                    <label for="complaintAdminUpdates">Updates:</label>
                    <div class="textarea-container">
                        <textarea class="form-control" type="text" name="complaint_updates[]" id="complaintAdminUpdates" placeholder="Update Description...."></textarea>
                        <button type="submit" href="{{ route('api.admin.complaint.fetch') }}" class="fa-solid fa-share-from-square fa-flip-vertical sendIcon"></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        var modalContainer = document.getElementById("complaintModalContainer");
        var closeModalButton = document.getElementById("closeModal");

        $(document).on('click', '.clickable-row', function() {
            var title = $(this).data('complaint-title');
            var date = $(this).data('complaint-date');
            var description = $(this).data('complaint-description');
            var status = $(this).data('complaint-currentstatus');
            var updates = $(this).data('complaint-updates');
            var sendFrom = $(this).data('complaint-sendfrom');
            var photo = $(this).data('complaint-photo');

            var currentStatus = mapStatusToLabels(status);

            function mapStatusToLabels(stateStatus) {
                var statusLabels = "";

                stateStatus = stateStatus.toString();

                if (stateStatus === "1") {
                    statusLabels = "Opened";
                } else if (stateStatus === "2") {
                    statusLabels = "Ongoing";
                } else if (stateStatus === "3") {
                    statusLabels = "Closed";
                } else {
                    statusLabels = "Unknown";
                }

                return statusLabels;
            }

            $('#complaintTitle').val(title);
            $('#complaintDate').val(date);
            $('#complaintDescription').val(description);
            $('#complaintStatus').val(currentStatus);
            $('#complaintUpdates').val(updates);
            $('#complaintSendFrom').val(sendFrom);
            $('#complaintPhoto').attr('src', 'http://127.0.0.1:8000/storage/' + photo);

            modalContainer.style.display = "flex";
        });

        $(document).on('click', '#closeModal', function() {
            modalContainer.style.display = "none"; 
        });
    </script>

</body>
</html>

@include('partials.__footer')