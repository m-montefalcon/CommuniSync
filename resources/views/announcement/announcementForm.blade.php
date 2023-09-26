@include('partials.__header')
@include('components.nav')
<html>
<head>
  <title> CREATE ANNOUNCEMENT </title>
  <link rel="stylesheet" href="{{ asset('css/announcementForm.css') }}">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css">
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>
                    CREATE ANNOUNCEMENT
                </h2>
            </div>
            <div class="card-body">

                <form method="POST" action="{{route('announcementStore')}}">
                    
                @csrf

                    <label for="announcement_title">Title:</label>
                    <textarea type="text" name="announcement_title" id="announcement_title" required></textarea>
            
                    <label for="announcement_description">Description:</label>
                    <textarea type="text" name="announcement_description" id="announcement_description" placeholder="Announcement Description...." required></textarea>
                    
                    <label for="announcement_photo">Photo:</label>
                    <input type="file" name="announcement_photo" id="announcement_photo">
                    
                    <label>Roles:</label>
                        <div class="checkbox-row">
                            <input type="checkbox" name="role[]" value="1" id="role_viewer">
                            <label for="role_viewer">Visitor</label>
                        
                            <input type="checkbox" name="role[]" value="2" id="role_user">
                            <label for="role_user">Homeowner</label>
                        
                            <input type="checkbox" name="role[]" value="3" id="role_editor">
                            <label for="role_editor">Personnel</label>
                        </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button class="btn btn-danger" href="{{ route('announcement') }}" onclick="history.back()"> Cancel </button>
                </form>
            </div>
        </div>
    </div>
</html>
</body>

@include('partials.__footer')