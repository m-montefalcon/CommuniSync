@include('partials.__header')
@include('components.nav')
<h1>Home</h1>

<div>
    <p>Number of Visits this month: {{ $visitCount }}</p>
    <p>Number of Complaints this month: {{ $complaintsCount }}</p>
    <p>Number of Payments this month: {{ $paymentCount }}</p>
    <p>Number of Homeowners overall: {{ $homeownerCount }}</p>
    <p>Number of Announcements this month: {{ $announcementCount }}</p>
    <p>Total amount of monthly due this month: ₱{{ $totalAmountPayment }}</p>
    <p>Number of users: {{ $totalUsersCount }}</p>


</div>

@include('partials.__footer')
