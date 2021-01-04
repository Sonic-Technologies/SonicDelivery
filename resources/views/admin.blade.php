<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/materialize.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/icon.ico') }}" type="image/x-icon">
    <title>Sonic Admin Panel</title>
</head>
<body>
    @auth
        <div class="navbar-fixed">
            <nav class="blue darken-4">
                <a data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            </nav>
        </div>
        <ul id="slide-out" class="sidenav sidenav-fixed blue darken-4">
            <li>
                <div class="user-view">
                    <div class="background hide">
                        <img src="">
                    </div>
                <a href="#user"><img class="circle" src="{{ asset('images/avatar.png') }}"></a>
                <a><span class="white-text"><strong>Sonic Admin Panel</strong></span></a>
                </div>
            </li>
            <li><a href="/dashboard" class="waves-effect waves-light"><i class="material-icons left">dashboard</i>Dashboard</a></li>
            <li><a href="/import" class="waves-effect waves-light"><i class="material-icons left">receipt</i>Import Stocks/Audit Report</a></li>
            <li><a href="/orders" class="waves-effect waves-light"><i class="material-icons left">shopping_basket</i>Orders</a></li>
            <li><a href="/products" class="waves-effect waves-light"><i class="material-icons left">loyalty</i>Products</a></li>
            <li><a href="/logout" class="waves-effect waves-light"><i class="material-icons left">exit_to_app</i>Logout</a></li>
        </ul>
        <div class="row">
            <div class="col m3 l3"></div>
            <div class="col s12 m9 l9">
                <div class="container">
                    @yield('content')
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col m4 l4"></div>
            <div class="col s12 m4 l4">
                <div class="card">
                    <div class="card-content">
                        <div class="center-align">
                            <h4 class="center-align"><b>Login</b></h4>
                        </div>
                        @if(session()->has('message'))
                        <div class="row">
                            <div class="col m2 l3"></div>
                            <div class="col s12 m8 l6 center-align" role="alert">
                                <span class="red-text"><i class="left material-icons red-text">warning</i><b> {{ session()->get('message') }}</b></span>
                            </div>
                            <div class="col m2 l3"></div>
                        </div>
                        @endif
                        <div class="row">
                            <form action="/login" method="post">
                            @csrf
                                <div class="input-field col s12 m12 l12">
                                    <i class="material-icons prefix">email</i>
                                    <input type="text" name="email" class="validate @error('email') is-invalid @enderror">
                                    <label for="email">Email Address</label>
                                    <div class="center-align">
                                        @error('email')
                                            <span class="red-text center-align"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="input-field col s12 m12 l12">
                                    <i class="material-icons prefix">lock_outline</i>
                                    <input type="password" name="password" class="validate @error('password') is-invalid @enderror">
                                    <label for="password">Password</label>
                                    <div class="center-align">
                                        @error('password')
                                            <span class="red-text"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="input-field col s12 m12 l12 center-align">
                                    <button class="btn waves-effect waves-light blue darken-3">Login<i class="material-icons right">lock_open</i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col m4 l4"></div>
        </div>
    @endauth
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/materialize.min.js') }}"></script>
<script src="{{ asset('js/admin.js') }}"></script>
@yield('script')
</body>
</html>