@include('partials.__header')
@include('components.nav')
<html>

<head>
    <title>Announcements</title>
    <link rel="stylesheet" href="{{ asset('css/announcement.css') }}">
    <link rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="header">
                    <h2>
                        ANNOUNCEMENTS
                    </h2>
                </div>
                <div class="card">
                    <div class="top-table">
                        <a class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" id="searchInput" placeholder="Search...">
                        </a>  
                        <a class="add-btn" href="{{ route('announcement.form') }}">
                            <i class="fa-regular fa-square-plus"></i>
                        </a>                     
                    </div>
                    
                    <div class="card-body">
                        <div id="table">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>Title</th>
                                        <th>Date</th>
                                    </tr>
                                    @if(isset($announcements) && count($announcements) > 0)
                                        @foreach ($announcements as $announcement)
                                    <tr class="clickable-row"
                                        data-announcement-title="{{ $announcement->announcement_title }}"
                                        data-announcement-date="{{ $announcement->announcement_date }}"
                                        data-announcement-description="{{ $announcement->announcement_description }}"
                                        data-announcement-sendFrom="{{ $announcement->admin->first_name . ' ' . $announcement->admin->last_name }}"
                                        data-announcement-sendTo="{{ $announcement->role }}"
                                        data-announcement-photo="{{ asset('storage/' . $announcement->announcement_photo) }}"
                                        >
                                        <td>{{ $announcement->announcement_title }}</td>
                                        <td>{{ $announcement->announcement_date }}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                        <tr>
                                            <td colspan="2">No announcements made.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-container" id="announcementModalContainer">
    <div class="modal-content">
        <div class="header-container">
            <div class="modal-header">
                <h1>
                    Announcement Detail
                </h1>
            </div>
            <span class="close-modal" id="closeModal">&times;</span>
        </div>
        <div class="form-group">
            <label for="announcementTitle">Title:</label>
            <input type="text" class="form-control" id="announcementTitle" readonly>
        </div>
        <div class="form-group">
            <label for="announcementDate">Date:</label>
            <input type="text" class="form-control" id="announcementDate" readonly>
        </div>
        <div class="form-group">
            <label for="announcementDescription">Description:</label>
            <textarea class="form-control" id="announcementDescription" rows="3" readonly></textarea>
        </div>
        <div class="form-group">
            <label for="announcementSendFrom">From:</label>
            <input class="form-control" id="announcementSendFrom" readonly>
        </div>
        <div class="form-group">
            <label for "announcementSendTo">To:</label>
            <input class="form-control" id="announcementSendTo" readonly>
        </div>
        <div class="card-photo">
            <div class="form-group">
                <img id="announcementPhoto" class="announcement-photo" alt="announcement photo">
            </div>
        </div>
    </div>
</div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        var modalContainer = document.getElementById("announcementModalContainer");
        var closeModalButton = document.getElementById("closeModal");

        $(document).on('click', '.clickable-row', function() {
            var announcementId = $(this).data('announcement-id');
            var title = $(this).data('announcement-title');
            var date = $(this).data('announcement-date');
            var description = $(this).data('announcement-description');
            var sendFrom = $(this).data('announcement-sendfrom');
            var sendToRoles = $(this).data('announcement-sendto'); 
            var photo = $(this).data('announcement-photo');
            var imageId = "announcementPhoto"; 

            var sendTo = mapRolesToLabels(sendToRoles);

            function mapRolesToLabels(roles) {
                var roleLabels = [];
                
                for (var i = 0; i < roles.length; i++) {
                    var role = roles[i];
                    if (role == 1) {
                        roleLabels.push(" Visitor");
                    } else if (role == 2) {
                        roleLabels.push(" Homeowner");
                    } else if (role == 3) {
                        roleLabels.push(" Security");
                    } else {
                        roleLabels.push("Unknown");
                    }
                }

                return roleLabels;
            }

            $('#announcementTitle').val(title);
            $('#announcementDate').val(date);
            $('#announcementDescription').val(description);
            $('#announcementSendFrom').val(sendFrom);
            $('#announcementSendTo').val(sendTo);
            $('.announcement-photo').attr('src', photo);

            modalContainer.style.display = "flex";
        });

        $(document).on('click', '#closeModal', function() {
            modalContainer.style.display = "none"; 
        });
        
        $('#searchInput').on('input', function() {
            var searchText = $(this).val().toLowerCase();

            $('.clickable-row').each(function() {
                var row = $(this);
                var found = false;

                row.find('td').each(function() {
                    var cellText = $(this).text().toLowerCase();

                    if (cellText.includes(searchText)) {
                        found = true;
                        return false;
                    }
                });

                if (found) {
                    row.show();
                } else {
                    row.hide();
                }
            });
        });
    </script>
</body>

</html>

@include('partials.__footer')
