@include('partials.__header')
@include('components.nav')
<h1>ANNOUNCEMENTS</h1>
@foreach ($announcements as $announcement)
<p>{{$announcement -> announcement_title}}</p>
@endforeach

<!-- KATE CHECK SA ANNOUNCEMENT CONTROLLER UNSAY MGA DATA NGA GIPANG PASA DIRI, SAMPLE NANA ANG TITLE -->
@include('partials.__footer')