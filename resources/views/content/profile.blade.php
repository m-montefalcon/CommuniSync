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
        <div class="header">
            <h2>
                PROFILE
            </h2>
        </div>
        <div class="card">
        @auth        
            <div class="user-profile">
                <div class="card-profile">
                    @if (auth()->user()->photo)
                        <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="User Photo">
                    @else
                        <img src="{{ asset('Assets/default-user-profile.jpg') }}" alt="Default Photo">
                    @endif
                        <h3>{{ auth()->user()->first_name}}  {{ auth()->user()->last_name}}</h3>
                        @if(auth()->user()->role == 1)
                            Visitor
                        @elseif(auth()->user()->role == 2)
                            Homeowner
                        @elseif(auth()->user()->role == 3)
                            Security Personnel
                        @elseif(auth()->user()->role == 4)
                            Admin
                        @else
                            Unknown Role
                        @endif
                </div>
                <div class="card-info">
                    <div class="card-header">
                        <h4>
                            <i class="far fa-clone"> </i>
                            General Information
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th width="30%"> User Name </th>
                                <td width="2%"> : </td>
                                <td> {{ auth()->user()->user_name }} </td>
                            </tr>
                            <tr>
                                <th width="30%"> Full Name </th>
                                <td width="2%"> : </td>
                                <td> {{ auth()->user()->first_name}}  {{ auth()->user()->last_name}} </td>
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
        @endauth
        </div>
    </div>
</body>
</html>

@include('partials.__footer')

