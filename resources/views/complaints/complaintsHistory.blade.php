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
                <div class="header">
                    <h2>
                        COMPLAINTS HISTORY
                    </h2>
                </div>
                <div class="card">
                    <div class="top-table">
                        <a class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" id="searchInput" placeholder="Search...">
                        </a>    
                        <a class="back-btn" href="{{ route('api.admin.complaint.fetch') }}">
                            <i class="fa-solid fa-arrow-left-long"></i>
                        </a>                    
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
                                        <td>{{ $complaint->complaint_title }}</td>
                                        <td>{{ \Carbon\Carbon::parse($complaint->complaint_date)->format('F j, Y') }}</td>
                                    </tr>
                                @endforeach
                                @if (count($fetchALlComplaints) === 0)
                                    <tr>
                                        <td colspan="2"> No complaint history found. </td>
                                    </tr>
                                @endif
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
                <div id="complaintUpdates" class="form-control" readonly></div>
            </div>
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
            var updatesHtml = "";

            if (updates && updates.length > 0) {
                updatesHtml = "<ul>";
                updates.forEach(function (update) {
                    updatesHtml += "<li style='margin-bottom: 20px;'>";
                    updatesHtml += "Date: " + update.date + "&nbsp;&nbsp;&nbsp;";
                    if ('update' in update) {
                        updatesHtml += "Update: " + update.update;
                    } else if ('resolution' in update) {
                        updatesHtml += "Resolution: " + update.resolution;
                    }
                    updatesHtml += "</li>";
                });
                updatesHtml += "</ul>";
            } else {
                updatesHtml = "No updates available.";
            }

            $('#complaintTitle').val(title);
            $('#complaintDate').val(date);
            $('#complaintDescription').val(description);
            $('#complaintStatus').val(currentStatus);
            $('#complaintUpdates').html(updatesHtml);
            $('#complaintSendFrom').val(sendFrom);
            $('#complaintPhoto').attr('src', '{{ asset("storage/") }}' + '/' + photo);
            modalContainer.style.display = "flex";
        });

        $(document).on('click', '#closeModal', function() {
            modalContainer.style.display = "none"; 
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