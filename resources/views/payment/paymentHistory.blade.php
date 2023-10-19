@include('partials.__header')
@include('components.nav')
<html>
<head>
  <title> Payment </title>
  <link rel="stylesheet" href="{{ asset('css/payment.css') }}">
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
                            Payment History
                        </h2>
                    </div>
                    <div class="card-body">
                        <div id="table">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                <tr>
                                    <th>Names</th>
                                    <th>Payment</th>
                                    <th>History</th>
                                </tr>     
                                @if(isset($homeowners) && count($homeowners) > 0)
                                    @foreach ($homeowners as $homeowner)
                                    <tr class="clickable-row">
                                        <td>{{$homeowner->first_name}} {{$homeowner->last_name}}</td>
                                        <td>
                                            <form action="">
                                                @csrf
                                                <button class="view-button" id="view-button" type="submit">View</button>
                                            </form>
                                        </td>
                                        <td>
                                            <form action="">
                                                @csrf
                                                <button type="submit">View</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                        <tr>
                                            <td colspan="2">No Users found.</td>
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

    <div class="modal-container" id="paymentModalContainer">
        <div class="modal-content">
            <div class="header-container">
                <div class="modal-header">
                    <h1>
                        Payment Form
                    </h1>
                </div>
                <span class="close-modal" id="closeModal">&times;</span>
            </div>
            <div class="flex-group">
                <div class="form-group1">
                    <label for="homeownersName">Account Name:</label>
                    <input type="text" class="form-control" id="homeownersName" readonly>
                </div>
                <div class="form-group1">
                    <label for="transactionDate">Date:</label>
                    <input type="text" class="form-control" id="transactionDate" readonly>
                </div>
            </div>
            
            <div class="form-group">
                <label for="paymentAmount">Amount:</label>
                <div class="input-group">
                    <span class="input-group-text">₱</span>
                    <input type="text" class="form-control1" id="paymentAmount">
                </div>
            </div>

            <div class="form-group">
                <label for="paymentNotes">Notes:</label>
                <textarea class="noteTextArea" type="text" name="paymentNotes" id="paymentNotes" placeholder="Payment Description...."></textarea>
            </div>

            <button type="submit" class="paymentSubmitButton">Submit</button>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.view-button').click(function(e) {

                e.preventDefault();

                var homeownersName = $(this).closest('tr').find('td:first-child').text();
                var currentDate = new Date().toISOString().slice(0, 10);

                $('#homeownersName').val(homeownersName);
                $('#transactionDate').val(currentDate);

                $('#paymentModalContainer').show();
                var modalContainer = document.getElementById("paymentModalContainer");
                modalContainer.style.display = "flex";
            });

            $('#closeModal').click(function() {
                $('#paymentModalContainer').hide();
            });
        });

        
    </script>

    </script>

</body>
</html>

@include('partials.__footer')

