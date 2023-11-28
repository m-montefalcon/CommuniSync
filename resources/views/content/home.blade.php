@include('partials.__header')
@include('components.nav')
<html>
    <head>
    <title> Visitor </title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css">
    </head>

    <body>
        <div class="header-wrapper">
            <div class="header-title">
                <H2>Dashboard</H2>
            </div>
        </div>
        <div class="box-container">
            <h2>Monthly Summary</h2>
            <div class="flex-container">
            <div class="boxes">
                <div class="box-divider">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="box-title">
                    <span>{{ $visitCount }}</span>
                    <span>Visits</span>
                </div>
                <button id="moreInfoButton">More Info</button>
            </div>

            <script>
                document.getElementById('moreInfoButton').addEventListener('click', function() {
                    window.location.href = "{{ route('admin.get.logbook') }}";
                });
            </script>





                <div class="boxes">
                    <div class="box-divider">
                        <i class="fa-solid fa-exclamation"></i>
                    </div>
                    <div class="box-title">
                        <span>{{ $complaintsCount }}</span>
                        <span>Complaints</span>
                    </div>
                    <button id="complaintsButton">More Info</button>
                </div>

                <script>
                    document.getElementById('complaintsButton').addEventListener('click', function() {
                        window.location.href = "{{ route('api.admin.complaint.fetch') }}";
                    });
                </script>
                
                <div class="boxes">
                    <div class="box-divider">
                        <i class="fa-solid fa-money-bill-1-wave"></i>
                    </div>
                    <div class="box-title">
                        <span>{{ $paymentCount }}</span>
                        <span>Payments</span>
                    </div>
                    <button id="paymentsButton">More Info</button>
                </div>

                <script>
                    document.getElementById('paymentsButton').addEventListener('click', function() {
                        window.location.href = "{{ route('admin.payment.all.users') }}";
                    });
                </script>


                <div class="boxes">
                    <div class="box-divider">
                        <i class="fa-solid fa-bullhorn"></i>
                    </div>
                    <div class="box-title">
                        <span>{{ $announcementCount }}</span>
                        <span class="announcement">Announcements</span>
                    </div>
                    <button id="announcementButton">More Info</button>
                </div>

                <script>
                    document.getElementById('announcementButton').addEventListener('click', function() {
                        window.location.href = "{{ route('announcement') }}";
                    });
                </script>

            </div>
        </div>
        <div class="container-divider">
            <div class="box-container-user1">
                <h2>User Summary</h2>
                <div class="flex-container">
                    <div class="boxes-user">
                        <div class="box-divider">
                            <i class="fa-solid fa-user-tie"></i>  
                        </div>
                        <div class="box-title">
                            <span>{{ $homeownerCount }}</span>
                            <span>Homeowners</span>
                        </div>
                    </div>
                    <div class="boxes-user">
                        <div class="box-divider">
                            <i class="fa-solid fa-users"></i>    
                        </div>
                        <div class="box-title">
                            <span>{{ $totalUsersCount }}</span>
                            <span>Total Users</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box-container-user2">
                <h2>Monthly due this Month</h2>
                <div class="boxes-total-amount">
                    <div class="box-divider">
                        <i class="fa-solid fa-sack-dollar"></i>   
                    </div>
                    <div class="box-title">
                        <span>{{ $totalAmountPayment }}</span>
                        <span>Total Amount </span>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
            function handleButtonClick(category) {
                // Perform the action you want when the button is clicked
                console.log(`Button clicked for ${category}`);
                // Add your logic here, such as displaying more details or navigating to another page.
            }
        </script>
    </body>
</html>
<div>
</div>

@include('partials.__footer')
