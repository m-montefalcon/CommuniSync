<!DOCTYPE html>
<html>
<head>
    <title>Payment</title>
    <link rel="stylesheet" href="{{ asset('css/payment.css') }}">
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
                        <h2>Payment</h2>
                        <div class="search-box">
                            <button id="searchButton"><i class="fas fa-search"></i></button>
                            <input type="text" id="searchInput" placeholder="Search...">
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="table">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <th>Names</th>
                                        <th>Payment</th>
                                        <th>History</th>
                                    </tr>
                                    @if(isset($homeowners) && count($homeowners) > 0)
                                        @foreach ($homeowners as $homeowner)
                                            <tr class="clickable-row">
                                                <td>{{$homeowner->id}}</td>
                                                <td>{{$homeowner->first_name}} {{$homeowner->last_name}}</td>
                                                <td>
                                                    <button class="view-button" data-id="{{$homeowner->id}}" data-name="{{$homeowner->first_name}} {{$homeowner->last_name}}">Pay</button>
                                                </td>
                                                <td>
                                                    <form action="{{ route('api.user.payment.save.records', ['id' => $homeowner->id]) }}" method="GET" target="_blank">
                                                        @csrf
                                                        <button type="submit">View</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4">No Users found.</td>
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

    <div class="modal-container" id="paymentModalContainer" style="display: none;">
        <div class="modal-content">
            <div class="header-container">
                <div class="modal-header">
                    <h1>Payment Form</h1>
                </div>
                <span class="close-modal" id="closeModal">&times;</span>
            </div>
            <form action="{{ route('api.admin.payment.records.store') }}" method="POST">
                @csrf
                <input type="hidden" name="homeowner_id" id="homeownerId">
                <div class="flex-group">
                    <div class="form-group1">
                        <label for="homeownersName">Account Name:</label>
                        <input type="text" class="form-control" id="homeownersName" readonly>
                    </div>
                    <div class="form-group1">
                        <label for="transactionDate">Date:</label>
                        <input type="text" class="form-control" name="transaction_date" id="transactionDate" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="paymentAmount">Amount:</label>
                    <div class="input-group">
                        <span class="input-group-text">₱</span>
                        <input type="text" class="form-control1" name="payment_amount" id="paymentAmount">
                    </div>
                </div>
                <div class="form-group">
                    <label for="transactionNumber">Transaction Number</label>
                    <div class="input-group">
                        <span class="input-group-text">₱</span>
                        <input type="text" class="form-control1" name="transaction_number" id="transaction_number">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="paymentNotes">Notes:</label>
                    <textarea class="noteTextArea" type="text" name="notes" id="paymentNotes" placeholder="Payment Description...."></textarea>
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
                var homeownerId = $(this).data('id');
                var homeownersName = $(this).data('name');
                var currentDate = new Date().toISOString().slice(0, 10);

                $('#homeownerId').val(homeownerId);
                $('#homeownersName').val(homeownersName);
                $('#transactionDate').val(currentDate);

                $('#paymentModalContainer').show();
            });

            $('#searchButton').click(function() {
                var searchText = $('#searchInput').val().toLowerCase();

                $('.clickable-row').each(function() {
                    var names = $(this).find('td:first-child').text().toLowerCase();

                    if (names.includes(searchText)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            $('#searchInput').on('input', function() {
                var searchText = $(this).val().toLowerCase();

                $('.clickable-row').each(function() {
                    var names = $(this).find('td:nth-child(2)').text().toLowerCase(); // Use nth-child to target the second column.

                    if (names.includes(searchText)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            $('#closeModal').click(function() {
                $('#paymentModalContainer').hide();
            });
        });
    </script>

    @include('partials.__footer')
</body>
</html>
