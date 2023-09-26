@include('partials.__header')
@include('components.nav')
<html>
<head>
  <title> QR Code </title>
  <link rel="stylesheet" href="{{ asset('css/qrCode.css') }}">
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
                            QR CODE
                        </h2>
                    </div>   
                    <div class="card-body">
                        <div id="table">
                            <table class="table table-bordered table-stripe">
                                <tbody>
                                    <tr>
                                        <th>QR</th>
                                    </tr>
                                    @foreach($qrcodes as $code)
                                    <tr>
                                        <td>
                                            {!! $code->qr_code !!} 
                                            <!-- <hr> -->
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