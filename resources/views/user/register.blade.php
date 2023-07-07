@include('partials.__header')
<h2>Register</h2>
<form method="POST" action="{{ route('api.register.store') }}" enctype="multipart/form-data">
        @csrf

        <label for="user_name">Username:</label>
        <input type="text" id="user_name" name="user_name" required><br><br>

        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required><br><br>

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required><br><br>

        <label for="contact_number">Contact Number:</label>
        <input type="text" id="contact_number" name="contact_number" required><br><br>


        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>


        <label for="photo">Photo:</label>
        <input type="file" id="photo" name="photo"><br><br>
        
        <label for="role">Role:</label>
        <select id="role" name="role">
            <option value="1">Role 1</option>
            <option value="2">Role 2</option>
            <option value="3">Role 3</option>
            <option value="4">Role 4</option>
        </select><br><br>

      
        <input type="submit" value="Register">
    </form>

@include('partials.__footer')
