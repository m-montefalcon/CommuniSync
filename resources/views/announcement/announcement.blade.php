@include('partials.__header')
@include('components.nav')
<h1>ANNOUNCEMENTS</h1>
@foreach ($announcements as $announcement)

<p>{{ $announcement->admin->first_name . ' ' . $announcement->admin->last_name }}</p>
<p>{{$announcement -> announcement_title}}</p>
<p>{{$announcement -> announcement_description}}</p>
<p>{{$announcement -> announcement_date}}</p>
<p>{{$announcement -> role}}</p>


@endforeach

<!-- KATE CHECK SA ANNOUNCEMENT CONTROLLER UNSAY MGA DATA NGA GIPANG PASA DIRI, SAMPLE NANA ANG TITLE -->
@include('partials.__footer')