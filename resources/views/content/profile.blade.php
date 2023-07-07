@include('partials.__header')
@include('components.nav')
<h1>Profile</h1>
@auth
    <p>Welcome, {{ auth()->user()->first_name }} {{ auth()->user()->last_name }} </p>
    <p>User Name: {{ auth()->user()->user_name }}</p>

    <p>Email: {{ auth()->user()->email }}</p>
    <p>Contact Number: {{ auth()->user()->contact_number }}</p>
    

    @if (auth()->user()->photo)
    <img src="http://127.0.0.1:8000/storage/{{Auth::user()->photo}}" alt="User Photo">
    @else
        <p>No photo available</p>
    @endif
    
@endauth

@include('partials.__footer')

