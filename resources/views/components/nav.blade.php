<nav>

    <form action="api/logout/store" method="POST">
    @csrf
    <button type="submit">Logout</button>
    </form>
    
    <!-- <a href="/addstudent">Add students</a> -->
<!--     
    <a href="/register">Register</a>
    <br>
    <a href="/login">Sign in</a>
     -->
     <a href="/">Home</a>
     <a href="/visitor">Visitors</a>
     <a href="/homeowner">Homeowners</a>
     <a href="/personnel">Personnel</a>
     <a href="/admin">Admin</a>

</nav>
