@include('partials.__header')
@include('components.nav')
<html>
<head>
  <title> VIEW ANNOUNCEMENT </title>
  <link rel="stylesheet" href="{{ asset('css/announcement.css') }}">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css">
</head>

<body>
  <div class="container">
    <div class="card">
      <div class="card-header">
        <h2>
          ANNOUNCEMENT
        </h2>
      </div>
      <div class="card-body">

      <div id="table">
          <table class="table table-bordered table-striped">
            <tbody>
              <tr>
                <th>Name</th>
                <th>Title</th>
                <th>Description</th>
                <th>Date</th>
                <th>Role</th>
                <th>Photo</th>
              </tr>     
              <tr>
                  <td>
                    <div class="card-title">
                      <div class="card-body">
                          {{ $announcement->admin->first_name . ' ' . $announcement->admin->last_name }}
                          <!-- {{ $announcement->announcement_title }}
                          {{ $announcement->announcement_description }}
                          {{ $announcement->announcement_date }}
                          {{ $announcement->role }}
                          {{ $announcement->announcement_photo }} -->
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
                  <td>
                    <div class="card-description">
                      <div class="card-body">
                        {{ $announcement->announcement_description }}
                      </div>
                    </div>                   
                  </td>
                  <td>
                    <div class="card-description">
                      <div class="card-body">
                      {{ $announcement->announcement_date }}
                      </div>
                    </div>                   
                  </td>
                  <td>
                    <div class="card-description">
                      <div class="card-body">
                      {{ $announcement->role }}
                      </div>
                    </div>                   
                  </td>
                  <td>
                  <div class="card-description">
                      <div class="card-body">
                          <img src="{{ asset('storage/' . $announcement->announcement_photo) }}" alt="user photo">
                      </div>
                  </div>                   
              </td>


              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</html>
</body>

@include('partials.__footer')

