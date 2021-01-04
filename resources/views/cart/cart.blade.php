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
            <div class="nav-wrapper blue darken-4">
                <a href="/" class="brand-logo"><img src="{{ asset('logo2.png') }}" height="65px"></a>
            </div>
        </nav>
    </div>
    <div class="row">
        <div class="col m2 l2"></div>
        <div class="col s12 m8 l8">
            <div class="card">
                <div class="card-content">
                    <div class="center-align">
                        <i class="material-icons medium">shopping_cart</i>
                        
                    </div>
                    <div class="row">
                        <table class="responsive-table">
                            <thead>
                                <tr>
                                    <th>Item code</th>
                                    <th>Item name</th>
                                    <th>Quantity</th>
                                    <th>Amount</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $total = 0.00 ?>
                                @if(session('cart'))
                                    @foreach(session('cart') as $id => $details)
                                    <?php $total += $details['price'] * $details['quantity'] ?>
                                    <tr>
                                        <td>{{ $details['item_code'] }}</td>
                                        <td>{{ $details['item_name'] }}</td>
                                        <td>{{ $details['quantity'] }}</td>
                                        <td>{{ $details['price'] }}</td>
                                        <td><button data-id="{{ $id }}" class="remove-from-cart red btn-small waves-effect waves-light"><i class="material-icons">clear</i></button></td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td><strong>Delivery Fee: PHP <span id="deliveryFee"></span></strong></td>
                                    <td><strong>Grand Total: PHP <span id="totalFee"></span></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="center-align">
                        <i style="font-size: small;">*Please note that our delivery fee varies from your area / barangay.</i>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-content">
                    <h4><strong>Order Form</strong></h4>
                    <i style="font-size: small;">*Please fill out the form</i>
                    <div class="divider"></div>
                    <div class="row">
                        <div class="container">
                            <form action="/submit-order" method="POST" id="orderForm">
                            @csrf
                                <input type="hidden" id="grand_total" name="grand_total">
                                <input type="hidden" id="delivery_fee" name="delivery_fee">
                                @if(session('customer'))
                                    @foreach(session('customer') as $key => $cx)
                                    <div class="input-field col s6 m6 l6">
                                        <input type="text" name="first_name" value="{{ $cx['first_name'] }}" class="validate @error('first_name') is-invalid @enderror">
                                        <label for="first_name">First name</label>
                                        @error('first_name')
                                            <span class="red-text">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="input-field col s6 m6 l6">
                                        <input type="text" name="last_name" value="{{ $cx['last_name'] }}" class="validate @error('last_name') is-invalid @enderror">
                                        <label for="last_name">Last name</label>
                                        @error('last_name')
                                            <span class="red-text">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="input-field col s6 m6 l6">
                                        <input type="text" name="email" value="{{ $cx['email'] }}" class="validate @error('email') is-invalid @enderror">
                                        <label for="email">Email address</label>
                                        @error('email')
                                            <span class="red-text">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="input-field col s6 m6 l6">
                                        <input type="number" name="phone" value="{{ $cx['phone'] }}" class="validate @error('phone') is-invalid @enderror">
                                        <label for="phone">Phone number</label>
                                        @error('phone')
                                            <span class="red-text">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="input-field col s6 m6 l6">
                                        <select name="barangay" id="areaBrgy" class="validate @error('barangay') is-invalid @enderror">
                                            <option value="" disabled selected>Choose</option>
                                            @foreach($barangay as $area)
                                            <option value="{{ $area->id }}">{{ $area->name }}</option>
                                            @endforeach
                                        </select>
                                        <label>Area / Barangay</label>
                                        @error('barangay')
                                            <span class="red-text">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="input-field col s6 m6 l6">
                                        <input type="text" name="street" value="{{ $cx['street'] }}" class="validate @error('street') is-invalid @enderror">
                                        <label for="street">Street Address</label>
                                        @error('street')
                                            <span class="red-text">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="input-field col s12 m12 l12">
                                        <input type="text" name="street2" value="{{ $cx['street2'] }}" placeholder="Optional" class="validate">
                                        <label for="street2">Street Address Line 2</label>
                                    </div>
                                    <div class="input-field col s4 m4 l4">
                                        <input type="text" name="city" value="{{ $cx['city'] }}" class="validate @error('city') is-invalid @enderror">
                                        <label for="city">City</label>
                                        @error('city')
                                            <span class="red-text">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="input-field col s4 m4 l4">
                                        <input type="text" name="province" value="{{ $cx['province'] }}" class="validate @error('city') is-invalid @enderror">
                                        <label for="province">Province</label>
                                        @error('province')
                                            <span class="red-text">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="input-field col s4 m4 l4">
                                        <input type="text" name="zip" value="{{ $cx['zip'] }}" class="validate @error('zip') is-invalid @enderror">
                                        <label for="zip">Zip Code</label>
                                        @error('zip')
                                            <span class="red-text">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    @endforeach
                                @else
                                <div class="input-field col s6 m6 l6">
                                    <input type="text" name="first_name" id="first_name" class="validate @error('first_name') is-invalid @enderror">
                                    <label for="first_name">First name</label>
                                    @error('first_name')
                                        <span class="red-text"><strong>{{$message}}</strong></span>
                                    @enderror
                                </div>
                                <div class="input-field col s6 m6 l6">
                                    <input type="text" name="last_name" id="last_name" class="validate @error('last_name') is-invalid @enderror">
                                    <label for="last_name">Last name</label>
                                    @error('last_name')
                                        <span class="red-text"><strong>{{$message}}</strong></span>
                                    @enderror
                                </div>
                                <div class="input-field col s6 m6 l6">
                                    <input type="text" name="email" id="email" class="validate @error('email') is-invalid @enderror">
                                    <label for="email">Email address</label>
                                    @error('email')
                                        <span class="red-text"><strong>{{$message}}</strong></span>
                                    @enderror
                                </div>
                                <div class="input-field col s6 m6 l6">
                                    <input type="number" name="phone" id="phone" class="validate @error('phone') is-invalid @enderror">
                                    <label for="phone">Phone number</label>
                                    @error('phone')
                                        <span class="red-text"><strong>{{$message}}</strong></span>
                                    @enderror
                                </div>
                                <div class="input-field col s6 m6 l6">
                                    <select name="barangay" id="areaBrgy" class="validate @error('barangay') is-invalid @enderror">
                                        <option value="" disabled selected>Choose</option>
                                        @foreach($barangay as $area)
                                        <option value="{{ $area->id }}">{{ $area->name }}</option>
                                        @endforeach
                                    </select>
                                    <label>Area / Barangay</label>
                                    @error('barangay')
                                        <span class="red-text"><strong>{{$message}}</strong></span>
                                    @enderror
                                </div>
                                <div class="input-field col s6 m6 l6">
                                    <input type="text" name="street" id="street" class="validate @error('street') is-invalid @enderror">
                                    <label for="street">Street Address</label>
                                    @error('street')
                                        <span class="red-text"><strong>{{$message}}</strong></span>
                                    @enderror
                                </div>
                                <div class="input-field col s12 m12 l12">
                                    <input type="text" name="street2" id="street2" placeholder="Optional" class="validate">
                                    <label for="street2">Street Address Line 2</label>
                                </div>
                                <div class="input-field col s4 m4 l4">
                                    <input type="text" name="city" value="Davao City" id="city" class="validate @error('city') is-invalid @enderror">
                                    <label for="city">City</label>
                                    @error('city')
                                        <span class="red-text"><strong>{{$message}}</strong></span>
                                    @enderror
                                </div>
                                <div class="input-field col s4 m4 l4">
                                    <input type="text" name="province" value="Davao Del Sur" id="province" class="validate @error('province') is-invalid @enderror">
                                    <label for="province">Province</label>
                                    @error('province')
                                        <span class="red-text"><strong>{{$message}}</strong></span>
                                    @enderror
                                </div>
                                <div class="input-field col s4 m4 l4">
                                    <input type="text" name="zip" value="8000" id="zip" class="validate @error('zip') is-invalid @enderror">
                                    <label for="zip">Zip Code</label>
                                    @error('zip') 
                                        <span class="red-text"><strong>{{$message}}</strong></span>
                                    @enderror
                                </div>
                                @endif
                                <div class="row" id="captchaDiv">
                                    <div class="captcha col s12 m12 l12 center-align">
                                        <span>{!! captcha_img() !!}</span><br>
                                        <button type="button" id="refreshCaptchaBtn" class="btn-small waves-effect waves-light blue darken-4" style="font-size: x-small;">Refresh Captcha</button>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col m4 l4"></div>
                                        <div class="input-field col s12 m4 l4 center-align">
                                            <input type="text" id="captcha" name="captcha" class="validate @error('captcha') is-invalid @enderror" placeholder="Enter captcha answer">
                                            @error('captcha')
                                                <span class="red-text"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                        <div class="input-field col m4 l4"></div>
                                    </div>
                                </div>
                                <div class="input-field col s12 m12 l12 center-align">
                                    <button class="btn waves-effect waves-light blue darken-4" id="submitBtn" disabled>Submit Order</button>
                                </div>
                            </form>
                            <p class="center-align">
                                <label>
                                    <input type="checkbox" id="checkbox">
                                    <span style="font-size: small;">I confirm that I am atleast 18 years old.</span>
                                </label>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col m2 l2"></div>
    </div>
    <div class="modal" id="confirm_delivery_charge">
        <div class="modal-content">
            <div class="container">
                <div class="row">
                    <div class="input-field col s12 m12 l12 center-align">
                        <i class="material-icons large">local_shipping</i>
                    </div>
                    <div class="input-field col s12 m12 l12 center-align">
                        <h6><i>Please be advised our delivery charge<br>for the area you selected is <span id="modalDeliveryFee"></span> pesos.</i></h6>
                    </div>
                    <div class="input-field col s12 m12 l12 center-align">
                        <a class="modal-close btn blue waves-effect waves-light">Agree<i class="material-icons right">done</i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="submitOrderModal">
        <div class="modal-content center-align">
            <h5><b>One moment please, submitting order</b></h5>
        </div>
    </div>
    <div class="modal" id="errorModal">
        <div class="modal-content center-align">
        <i class="material-icons red-text medium">warning</i>
        <br>
        @if(Session::has('message'))
        <span class="red-text"><b>{{ Session::get('message') }}</b></span>
        @endif
        <br><br>
        <div class="row">
            <div class="col s12 m12 l12 center-align">
                <span class="red-text" style="font-size: small;"><b>Please update your cart. Thank you!</b></span>
            </div>
            <br><br>
            <div class="col s12 m12 l12 center-align">
                <button class="btn-small blue darken-4 waves-effect waves-light modal-close" type='button'>Confirm</button>
            </div>
        </div>
        </div>
    </div>

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/materialize.min.js') }}"></script>
<script src="{{ asset('js/index.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){

        $(".remove-from-cart").click(function (e) {
            e.preventDefault();
 
            var ele = $(this);
 
            if(confirm("Are you sure")) {
                $.ajax({
                    url: '{{ url('remove-from-cart') }}',
                    method: "DELETE",
                    data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id")},
                    success: function (response) {
                        window.location.reload();
                    }
                });
            }
        });

        checkbox.addEventListener('click', e=>{
            if(document.getElementById('checkbox').checked == true){
                document.getElementById('submitBtn').disabled = false;
            }else{
                document.getElementById('submitBtn').disabled = true;
                document.getElementById('captcha').value = "";
            }
        });

        $('#refreshCaptchaBtn').click(function(e){
                e.preventDefault();

            $.ajax({
                type: "GET",
                url: "{{ url('/refresh-captcha') }}",
                success: function(data){
                    $('.captcha span').html(data);
                }
            });
        });

        $("#areaBrgy").change(function(e){
            e.preventDefault();
            var district_id = $('#areaBrgy').val();
            $.ajax({
                url: "{{ url('/delivery-fee') }}/"+district_id,
                method: "GET",
                dataType: "json",
                success:function(response){
                    var charge = response['delivery_charge'];
                    $('#deliveryFee').text(charge);                    
                    $('#totalFee').text(<?php echo $total; ?>+charge);
                    $('#grand_total').val(<?php echo $total; ?>+charge);
                    $('#delivery_fee').val(charge);
                    $('#modalDeliveryFee').text(charge);
                    $('#confirm_delivery_charge').modal('open');
                }
            });
        });

        $(window).on("beforeunload", function(e){
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ url('/continue-shopping') }}",
                data: $('#orderForm').serialize(),
                success:function(){
                }
            });
        });
    });
</script>
@if(Session::has('message'))
<script type="text/javascript">
    $(document).ready(function(){
        $('#errorModal').modal('open');
    });
</script>
@endif
</body>
</html>