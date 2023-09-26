@include('partials.__header')
@include('components.nav')
<html>
<head>
  <title> Profile </title>
  <link rel="stylesheet" href="{{ asset('css/userProfile.css') }}">
  <link rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css">
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>
                    PROFILE
                </h2>
            </div> 

    @auth
        <p>Welcome, {{ auth()->user()->first_name }} {{ auth()->user()->last_name }} </p>
        
        <div class="user-profile py-4">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card shadow-sm">
                    <div class="profile">
        @if (auth()->user()->photo)
        <img src="http://127.0.0.1:8000/storage/{{Auth::user()->photo}}" alt="User Photo">
        @else
            <p>No photo available</p>
        @endif
        </div>
                    </div>
                </div>
        
                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-transparent border-0">
                            <h4 class="mb-0">
                                <i class="far fa-clone"> </i>
                                General Information
                            </h4>
                        </div>
                        <div class="card-body pt-0">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%"> User Name </th>
                                    <td width="2%"> : </td>
                                    <td> {{ auth()->user()->user_name }} </td>
                                </tr>
                                <tr>
                                    <th width="30%"> Email </th>
                                    <td width="2%"> : </td>
                                    <td> {{ auth()->user()->email }} </td>
                                </tr>
                                <tr>
                                    <th width="30%"> Contact Number </th>
                                    <td width="2%"> : </td>
                                    <td> {{ auth()->user()->contact_number }} </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

    <!-- <p>User Name: {{ auth()->user()->user_name }}</p> -->

    <!-- <p>Email: {{ auth()->user()->email }}</p> -->
    <!-- <p>Contact Number: {{ auth()->user()->contact_number }}</p> -->
    

   
    
@endauth
                </div>
            </div>
        </div>
    </div>
</body>
</html>

@include('partials.__footer')

