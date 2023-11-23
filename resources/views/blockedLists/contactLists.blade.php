@include('partials.__header')
@include('components.nav')
<html>

<head>
    <title>Blocked Lists</title>
    <link rel="stylesheet" href="{{ asset('css/payment.css') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="header">
                    <h2>
                        BLOCKED LISTS
                    </h2>
                </div>
                <div class="card">
                    <div class="top-table">
                        <a class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" id="searchInput" placeholder="Search...">
                        </a>     
                        <a class="back-btn" href="{{ route('blockedlists.request') }}">
                            <i class="fa-solid fa-arrow-left-long"></i>
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
                                        <th>Remove</th>
                                    </tr>
                                    @if(isset($blocklists) && count($blocklists) > 0)
                                        @foreach ($blocklists as $blocklist)
                                            <tr class="clickable-row">
                                                <td>{{$blocklist->homeowner->first_name}} {{$blocklist->homeowner->last_name}}</td>
                                                <td>{{$blocklist->first_name}} {{$blocklist->last_name}}</td>
                                                <td>{{$blocklist->contact_number}}</td>
                                                <td>{{$blocklist->blocked_reason}}</td>
                                                <td>
                                                    <button class="view-button" data-id="{{$blocklist->id}}">Remove</button>
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

    <div class="modal-container" id="blockListsContainer" style="display: none;">
    <div class="modal-content">
        <div class="header-container">
            <div class="modal-header">
                <h1>Remove person from being blocked?</h1>
            </div>
            <span class="close-modal" id="closeModal">&times;</span>
        </div>
        <form action="{{ route('api.blockedlists.remove', ['id' => ':blocklistId']) }}" method="POST" id="removeForm">
            @csrf
            @method('PUT') <!-- Assuming you want to use the PUT method -->
            <input type="hidden" name="blocklist_id" id="blocklistId">
            <button type="button" class="cancelButton" id="cancelButton">Cancel</button>
            <button type="submit" class="confirmButton">Confirm</button>
        </form>
    </div>
</div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.view-button').on('click', function () {
                var blocklistId = $(this).data('id');
                $('#blocklistId').val(blocklistId);

                // Set the form action dynamically
                var formAction = "{{ route('api.blockedlists.remove', ['id' => ':blocklistId']) }}";
                formAction = formAction.replace(':blocklistId', blocklistId);
                $('#removeForm').attr('action', formAction);

                $('#blockListsContainer').show();
            });

            $('#cancelButton, #closeModal').on('click', function () {
                $('#blockListsContainer').hide();
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
