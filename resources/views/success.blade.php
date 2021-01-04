<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/materialize.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/icon.ico') }}" type="image/x-icon">
    <title>Sonic Sales Delivery</title>
</head>
<body>
<div class="navbar-fixed">
    <nav>
        <div class="nav-wrapper blue darken-3">
            <a href="/" class="brand-logo"><img src="{{ asset('images/logo.png') }}" height="75px" width="75px"></a>
        </div>
    </nav>
</div>

<div class="container">
    <div class="card">
        <div class="card-image">
            <img src="{{ asset('images/cover.jpg') }}">
        </div>
        <div class="card-content">
            <div class="row">
                <div class="col s12 m12 l12 center-align">
                    <i class="large material-icons circle green-text">verified_user</i>
                    <h4><b>Order succesfully submitted!</b></h4>
                    <h6><b>Order Number: {{ $orderNumber }}</b></h6>
                    <span>Thank you for choosing Sonic Sales Delivery to deliver your favorite Unilever products!</span><br>
                    <span>We have sent you an email for your order confirmation.</span><br>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/materialize.min.js') }}"></script>   
</body>
</html>