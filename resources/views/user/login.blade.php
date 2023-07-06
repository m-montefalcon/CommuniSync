@include('partials.__header')
<h2>Login</h2>
  <form action="api/login/store" method="POST">
    @csrf
    <div>
      <label for="user_name">Username:</label>
      <input type="text" id="user_name" name="user_name" required>
    </div>
    <div>
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>
    </div>
    <div>
      <button type="submit">Login</button>
    </div>
  </form>
@include('partials.__footer')

