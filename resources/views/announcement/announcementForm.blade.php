@include('partials.__header')
@include('components.nav')
<h1>CREATE ANNOUNCEMENTS</h1>
<form method="POST" action="{{route('announcementStore')}}">
    @csrf

    <label for="announcement_title">Title:</label>
    <input type="text" name="announcement_title" id="announcement_title" required>
    <br>
    <label for="announcement_description">Description:</label>
    <input type="text" name="announcement_description" id="announcement_description" required>
    <br>
    <label for="announcement_photo">Photo:</label>
    <input type="file" name="announcement_photo" id="announcement_photo">
    <br>
    <label for="announcement_date">Date:</label>
    <input type="date" name="announcement_date" id="announcement_date" required>
    <br>
    <label>Roles:</label>
    <br>
    <input type="checkbox" name="role[]" value="1" id="role_viewer">
    <label for="role_viewer">Visitor</label>
    <br>
    <input type="checkbox" name="role[]" value="2" id="role_user">
    <label for="role_user">Homeowner</label>
    <br>
    <input type="checkbox" name="role[]" value="3" id="role_editor">
    <label for="role_editor">Personnel</label>
    <br>
   


    <button type="submit">Submit</button>
</form>


@include('partials.__footer')