@include('partials.__header')
@include('components.nav')
<html>

<head>
    <title> Payment History </title>
    <link rel="stylesheet" href="{{ asset('css/payment.css') }}">
    <link rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="header">
                    <h2>
                        PAYMENT HISTORY
                    </h2>
                </div>   
                <div class="card">
                    <div class="top-table">
                        <div class="query-form">
                            <label for="fromDropdown"><strong> From: </strong></label>
                            <select class="filter-field" id="fromDropdown">
                            <option value="" disabled selected> Month</option>
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
                            <select class="filter-field" id="yearFromDropdown">
                                <option value="" disabled selected>Year</option> 
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                            </select>

                            <label for="toDropdown"><strong> To: </strong></label>
                            <select class="filter-field" id="toDropdown">
                                <option value="" disabled selected>Month</option> 
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

                            <select class="filter-field" id="yearToDropdown">
                            <option value="" disabled selected>Year</option> 
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                            </select>

                            <button class="btn btn-primary filter-button" id="filterButton">FILTER AND OPEN PDF</button>
                            <button class="btn btn-danger filter-button pdf-button" id="resetFilter">RESET</button>
                        </div>
                        <div class="closed-container">
                            <a class="back-btn" href="{{ route('admin.payment.all.users') }}">
                                <i class="fa-solid fa-arrow-left-long"></i>
                            </a>   
                        </div>
                    </div>
              
                    <div class="card-body">
                        <div id="table">
                            <table class="table" id="payment-table">
                                <tbody>
                                    <tr>
                                        <th>Homeowner Name</th>
                                        <th>Admin Name</th>
                                        <th>Date</th>
                                        <th>Payment Amount</th>
                                        <th>Additional notes</th>
                                    </tr>
                                    @if($fetchALlRecords->isEmpty())
                                        <tr>
                                            <td colspan="5">No records available.</td>
                                        </tr>
                                    @else
                                        @foreach($fetchALlRecords as $fetchALlRecord)
                                            <tr>
                                                <td>{{ optional($fetchALlRecord->homeowner)->first_name }} {{ optional($fetchALlRecord->homeowner)->last_name }}</td>
                                                <td>{{ optional($fetchALlRecord->admin)->first_name }} {{ optional($fetchALlRecord->admin)->last_name }}</td>
                                                <td>{{ $fetchALlRecord->payment_date }}</td>
                                                <td>{{ $fetchALlRecord->payment_amount }}</td>
                                                <td>{{ $fetchALlRecord->notes }}</td>
                                            </tr>
                                        @endforeach
                                    @endif

                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center">
                                {{ $fetchALlRecords->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
          
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

    <script>
        $(document).ready(function () {
            // Function to handle the click event of the "Filter" button
            $("#filterButton").click(function () {
                // Retrieve selected values from the "FROM" dropdowns
                var fromMonth = $("#fromDropdown").val();
                var fromYear = $("#yearFromDropdown").val();

                // Retrieve selected values from the "TO" dropdowns
                var toMonth = $("#toDropdown").val();
                var toYear = $("#yearToDropdown").val();

                // Redirect to the specified route with the selected values as parameters
                window.open("{{ route('api.payments.filter') }}?fromMonth=" + fromMonth + "&fromYear=" + fromYear +
                                    "&toMonth=" + toMonth + "&toYear=" + toYear, '_blank');

            });

            // Function to handle the click event of the "RESET" button
            $("#resetFilter").click(function () {
                // Reset the "FROM" dropdowns to their default values
                $("#fromDropdown").val('');
                $("#yearFromDropdown").val('');

                // Reset the "TO" dropdowns to their default values
                $("#toDropdown").val('');
                $("#yearToDropdown").val('');
            });

            // Add similar logic for the "PRINT AS PDF" button if needed.
        });
    </script>
    
</body>
</html>
@include('partials.__footer')