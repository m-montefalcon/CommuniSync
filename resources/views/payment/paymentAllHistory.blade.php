        @include('partials.__header')
        @include('components.nav')
        <html>
        <head>
        <title> Homeowner </title>
        <link rel="stylesheet" href="{{ asset('css/user.css') }}">
        <link rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

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
                        <!-- ... Existing code ... -->

        <!-- ... Existing code ... -->
        <style>
            .top-table {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 15px; /* Add margin to separate from the table */
            }

            .search-box {
                display: flex;
                align-items: center;
            }

            .search-box i {
                margin-right: 5px; /* Add spacing between search icon and input */
            }

            .options {
                display: flex;
                gap: 10px;
            }

            .options label {
                margin-right: 5px;
            }

            .filter-button {
                margin-top: 10px;
            }
        </style>

        <div class="top-table">
            <div class="options">
            <div class="d-flex align-items-center">
                <label for="fromDropdown">FROM:</label>
                <select class="form-control" id="fromDropdown">
                <option value="" disabled selected>Select Month</option> <!-- Disabled default option -->
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
                    <!-- Add other months as needed -->
                </select>
                <select class="form-control" id="yearFromDropdown">
                    <option value="" disabled selected>Select Year</option> <!-- Disabled default option -->

                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <!-- Add other years as needed -->
                </select>
            </div>

                <div class="d-flex align-items-center"> <!-- Added container for horizontal alignment -->
                    <label for="toDropdown">TO:</label>
                    <select class="form-control" id="toDropdown">
                        <option value="" disabled selected>Select Month</option> <!-- Disabled default option -->
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

                    <select class="form-control" id="yearToDropdown">
                    <option value="" disabled selected>Select Year</option> <!-- Disabled default option -->

                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <!-- Add other years as needed -->
                    </select>
                </div>
                <button class="btn btn-primary filter-button" id="filterButton">FILTER AND OPEN PDF</button>
                <button class="btn btn-danger filter-button pdf-button" id="resetFilter">RESET</button>


            </div>
        </div>

        <!-- ... Existing code ... -->





                        </div>
                            <div class="card-body">
                            <div id="table">
                            <table class="table table-bordered table-stripe" id="payment-table">
                                    <thead>
                                        <tr>
                                            <th>Homeowner Name</th>
                                            <th>Admin Name</th>
                                            <th>Date</th>
                                            <th>Payment Amount</th>
                                            <th>Additional notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($fetchALlRecords as $fetchALlRecord)
                                            <tr>
                                                <td>{{ strtoupper($fetchALlRecord->homeowner->first_name) }} {{ strtoupper($fetchALlRecord->homeowner->last_name) }}</td>
                                                <td>{{ strtoupper($fetchALlRecord->admin->first_name) }} {{ strtoupper($fetchALlRecord->admin->last_name) }}</td>
                                                <td>{{$fetchALlRecord->payment_date}}</td>
                                                <td>{{$fetchALlRecord->payment_amount}}</td>
                                                <td>{{$fetchALlRecord->notes}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center">
                                    {{ $fetchALlRecords->links() }} <!-- Add this line to display pagination links -->
                                </div>
                            </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
 

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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