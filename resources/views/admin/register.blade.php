<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/materialize.min.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Register Admin Panel</title>
</head>
<body>
    <div class="row">
        <div class="col m4 l4"></div>
        <div class="col s12 m4 l4">
            <div class="card">
                <div class="card-content">
                    <div class="center-align">
                        <h5><strong>Create Admin Account</strong></h5>
                    </div>
                    <div class="row">
                        <form action="/register" method="post">
                        @csrf
                            <div class="input-field col s12 m12 l12">
                                <i class="material-icons prefix">email</i>
                                <input type="text" name="email" class="validate">
                                <label for="email">Email Address</label>
                            </div>
                            <div class="input-field col s12 m12 l12">
                                <i class="material-icons prefix">lock_open</i>
                                <input type="password" name="password" class="validate">
                                <label for="password">Password</label>
                            </div>
                            <div class="input-field col s12 m12 l12">
                                <i class="material-icons prefix">lock_outline</i>
                                <input type="password" name="password_confirmation" class="validate">
                                <label for="password_confirmation">Confirm Password</label>
                            </div>
                            <div class="input-field col s12 m12 l12 center-align">
                                <button class="btn waves-effect waves-light blue darken-3">Submit<i class="material-icons right">send</i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col m4 l4"></div>
    </div>
<script src="{{ asset('js/jquery-3.5.0.min.js') }}"></script>
<script src="{{ asset('js/materialize.min.js') }}"></script>
</body>
</html>