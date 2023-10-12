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
                <div class="card">
                    <div class="card-header">
                        <h2>ANNOUNCEMENTS</h2>
                        <a class="add-btn" href="{{ route('announcement.form') }}">
                            <i class="fa-regular fa-square-plus"></i> Add Announcement
                        </a>
                    </div>
                    <div class="card-body">
                        <div id="table">
                            @if (isset($announcements) && count($announcements) > 0)
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th>Title</th>
                                        <th>Date</th>
                                    </tr>
                                    @foreach ($announcements as $announcement)
                                    <tr class="clickable-row"
                                        data-announcement-title="{{ $announcement->announcement_title }}"
                                        data-announcement-date="{{ $announcement->announcement_date }}"
                                        data-announcement-description="{{ $announcement->announcement_description }}"
                                        data-announcement-sendFrom="{{ $announcement->admin->first_name . ' ' . $announcement->admin->last_name }}"
                                        data-announcement-sendTo="{{ $announcement->role }}"
                                        data-announcement-photo="{{ asset('storage/' . $announcement->announcement_photo) }}">
                                        <td>
                                            <div class="card-title">
                                                <div class="card-body">
                                                    {{ $announcement->announcement_title }}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="card-date">
                                                <div class="card-body">
                                                    {{ $announcement->announcement_date }}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <p>No announcements made.</p>
                            @endif
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

        

    
        // document.addEventListener('DOMContentLoaded', function() {
        //     const announcementSendToElement = document.getElementById('announcementSendTo');
        //     const announcementRoleElement = document.getElementById('announcementRole');

        // });
    </script>
</body>

</html>

@include('partials.__footer')
