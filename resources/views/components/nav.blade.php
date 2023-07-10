<nav>
  <form action="{{ route('api.logout.store') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
  </form>
  
  <a href="{{ route('home') }}">Home</a>
  <a href="{{ route('visitor') }}">Visitors</a>
  <a href="{{ route('homeowner') }}">Homeowners</a>
  <a href="{{ route('personnel') }}">Personnel</a>
  <a href="{{ route('admin') }}">Admin</a>
  <a href="{{ route('profile') }}">Profile</a>
  <a href="{{ route('verificationRequests') }}">Verification Requests</a>


</nav>
