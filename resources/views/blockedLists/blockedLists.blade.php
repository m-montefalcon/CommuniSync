<!DOCTYPE html>
<html>
<head>
    <title>Blocked Lists</title>
    <link rel="stylesheet" href="{{ asset('css/payment.css') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css">
</head>
<body>
    @include('partials.__header')
    @include('components.nav')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="header">
                    <h2>
                        REQUESTS
                    </h2>
                </div>
                <div class="card">
                    <div class="top-table">
                        <a class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" id="searchInput" placeholder="Search...">
                        </a>     
                        <a class="contacts-btn" href="{{ route('blockedlists') }}">
                            <!-- You can replace the content inside the <i> tag with the HTML or icon code for your contacts button logo -->
                            <i class="fa-solid fa-address-book"></i>
                        </a>
                    </div>

                    <div class="card-body">
                        <div id="table">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th>Homeowner Name</th>
                                        <th>Requested to be Blocked</th>
                                        <th>Contact Number</th>
                                        <th>Block Reason</th>
                                        <th>Accept Request</th>
                                        <th>Deny</th>
                                    </tr>
                                    @if(isset($blocklists) && count($blocklists) > 0)
                                        @foreach ($blocklists as $blocklist)
                                            <tr class="clickable-row">
                                                <td>{{$blocklist->homeowner->first_name}} {{$blocklist->homeowner->last_name}}</td>
                                                <td>{{$blocklist->first_name}} {{$blocklist->last_name}}</td>
                                                <td>{{$blocklist->contact_number}}</td>
                                                <td>{{$blocklist->blocked_reason}}</td>
                                                <td>
                                                    <button class="view-button" data-id="{{$blocklist->id}}">Accept</button>
                                                </td>
                                                <td>
                                                    <button class="deny-button" data-id="{{$blocklist->id}}">Deny</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6">No Request Found.</td>
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

    <!-- Accept Modal -->
    <div class="modal-container" id="blockListsContainer" style="display: none;">
        <div class="modal-content">
            <div class="header-container">
                    <div class="modal-header">
                        <h1>
                            Approved Blocked Person Request
                        </h1>
                    </div>
                    <span class="close-modal" id="closeModal">&times;</span>
                </div> 
                <form action="{{ route('api.admin.blocklists.validated.mobile', ['id' => ':logbookId']) }}" method="POST" id="acceptForm">
                @csrf
                @method('PUT') <!-- Assuming you want to use the PUT method -->
                <input type="hidden" name="homeowner_id" id="homeownerId">
                <div class="form-group">
                    <label for="blockedListResponseNotes">Block Status Response Description:</label>
                    <textarea class="noteTextArea" type="text" name="blocked_status_response_description" id="blockedListResponseNotes" placeholder="Block Status Response Description...."></textarea>
                </div>
                <button type="submit" class="paymentSubmitButton">Submit</button>
            </form>
        </div>
    </div>

    <!-- Deny Modal -->
    <div class="modal-container" id="denyContainer" style="display: none;">
        <div class="modal-content">
        <div class="header-container">
                    <div class="modal-header">
                        <h1>
                           Deny Blocked Person Request
                        </h1>
                    </div>
                    <span class="close-modal" id="closeDenyModal">&times;</span>
                </div> 
            <form action="{{ route('api.admin.blocklists.denied.mobile', ['id' => ':logbookId']) }}" method="POST" id="denyForm">
                @csrf
                @method('PUT') <!-- Assuming you want to use the PUT method -->
                <input type="hidden" name="homeowner_id" id="denyHomeownerId">
                <div class="form-group">
                    <label for="denyResponseNotes">Denial Response Description:</label>
                    <textarea class="noteTextArea" type="text" name="denial_response_description" id="denyResponseNotes" placeholder="Denial Response Description...."></textarea>
                </div>
                <button type="submit" class="paymentSubmitButton">Submit</button>
            </form>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.view-button').click(function(e) {
                e.preventDefault();

                // Show the accept modal
                $('#blockListsContainer').show();

                var logbookId = $(this).data('id');

                // Use the logbookId as needed
                console.log('Logbook ID (Accept):', logbookId);

                // Update the value of the hidden input field in the accept form
                $('#homeownerId').val(logbookId);

                // Update the action URL of the accept form dynamically
                var formAction = $('#acceptForm').attr('action');
                formAction = formAction.replace(':logbookId', logbookId);
                $('#acceptForm').attr('action', formAction);
            });

            $('.deny-button').click(function(e) {
                e.preventDefault();

                // Show the deny modal
                $('#denyContainer').show();

                var denyLogbookId = $(this).data('id');

                // Use the denyLogbookId as needed
                console.log('Logbook ID (Deny):', denyLogbookId);

                // Update the value of the hidden input field in the deny form
                $('#denyHomeownerId').val(denyLogbookId);

                // Update the action URL of the deny form dynamically
                var denyFormAction = $('#denyForm').attr('action');
                denyFormAction = denyFormAction.replace(':logbookId', denyLogbookId);
                $('#denyForm').attr('action', denyFormAction);
            });

            $('#closeModal').click(function() {
                $('#blockListsContainer').hide();
            });

            $('#closeDenyModal').click(function() {
                $('#denyContainer').hide();
            });

            // Handle form submission
            $('#acceptForm').submit(function(e) {
                var notesValue = $('#blockedListResponseNotes').val();
                $(this).append('<input type="hidden" name="blocked_status_response_description" value="' + notesValue + '">');
            });

            $('#denyForm').submit(function(e) {
                var denyNotesValue = $('#denyResponseNotes').val();
                $(this).append('<input type="hidden" name="blocked_status_response_description" value="' + denyNotesValue + '">');
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

    @include('partials.__footer')
</body>
</html>
