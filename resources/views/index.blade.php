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
            <a href="/" class="left"><img src="{{ asset('logo2.png') }}" height="65px"></a>
            <ul class="nav-mobile right">
                <li><a href="/cart"><i class="material-icons left">shopping_cart</i><span class="new badge" data-badge-caption="item(s)" id="cartNum">{{ count(Session::get('cart', array())) }}</span></a></li>
            </ul>
        </div>
    </nav>
</div>

<div class="container">
    <div class="card">
        <div class="card-image">
            <img src="{{ asset('images/cover.jpg') }}">
        </div>
        <div class="card-content">
            <div class="col s12 m12 l12 center-align">
                <h5 class="center-align"><b>Sonic Sales Delivery</b></h5>
                <span class="center-align" style="font-size: small;">Order Form</span>
            </div>
            <div class="divider"></div>
            <span>
                We are SONIC SALES DELIVERY, a home delivery service of Sonic Sales & Distribution, Inc., an accredited distributor of Unilever Philippines. We deliver a variety of products for home and personal care. The products we can bring at your doorsteps include laundry, home sanitation, hair, skin, and oral care, including some food items.
                <br><br>
                All you have to do is submit your order and our Telesales rep will call you for confirmation. Payment mode is Cash on Delivery only.
                <br><br>
                <i>For a minimum order of P250.00 plus delivery charge, you can now buy your favorite Unilever products.</i>
                <br><br>    
            </span>
            <ul class="collapsible">
                @foreach($categories as $category)
                <li>
                    <div class="collapsible-header">{{ $category->description }}</div>
                    <div class="collapsible-body">
                        <ul class="collection" id="inline">
                        <?php $countPromo = 0; ?>
                            @foreach ($items as $item)
                                @if($category->description == $item->subcat)
                                <div class="row">
                                    <li>
                                        <div class="col s5 m2 l2">
                                            <div class="card">
                                                <div class="card-image">
                                                    @if(!$item->photo)
                                                    <img class="materialboxed" src="{{ asset('nopic.png') }}">
                                                    @else
                                                    <img class="materialboxed" src="{{ config('filesystems.aws_public_url').'/'.$item->photo }}">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col s7 m5 l5">
                                            <h6><strong>{{ $item->artdesc }}</strong></h6>
                                            <p style="font-size: small;">{{ $item->artcode }}</p>
                                            <p>₱ <span>{{ number_format($item->price, 2) }}</span></p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col s12 m5 l5 center-align">
                                        @if($item->inventory == 0)
                                            <img src="{{ asset('images/outofstock.png') }}" alt="Out of Stock" width="120px" height="120px">
                                        @else
                                        <form id="{{ $category->category_name }}<?php echo $countPromo; ?>">
                                            @csrf
                                                <input type="hidden" id="{{ $category->category_name }}Id<?php echo $countPromo; ?>" value="{{ $item->id }}">
                                                <input type="hidden" name="item_inventory" value="{{ $item->inventory }}" id="itemInventory<?php echo $countPromo; ?>">
                                                <div class="input-field col s4 m4 l4 right-align">
                                                    <button type="button" id="{{ $category->category_name }}Min<?php echo $countPromo; ?>" class="btn-flat waves-effect waves-dark"><i class="material-icons red-text">remove</i></button>
                                                </div>
                                                <div class="input-field col s4 m4 l4 center-align">
                                                    <input type="number" name="quantity" value="1"  id="{{ $category->category_name }}Qty<?php echo $countPromo; ?>" class="validate @error('quantity') is-invalid @enderror" readonly>
                                                    <label for="quantity">Quantity</label>
                                                    @error('quantity')
                                                    <span class="red-text">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="input-field col s4 m4 l4 left-align">
                                                    <button type="button" id="{{ $category->category_name }}Add<?php echo $countPromo; ?>" class="btn-flat waves-effect waves-dark"><i class="material-icons blue-text">add</i></button>
                                                </div>
                                                <div class="input-field col s12 m12 l12 center-align">
                                                    <button class="btn-small waves-effect waves-light blue darken-4">Add Cart</button>
                                                </div>
                                            </form>
                                        @endif
                                        </div>
                                    </li>
                                </div>
                                @endif
                            <?php $countPromo++ ?>
                            @endforeach
                        </ul>
                    </div>
                </li>
                @endforeach
            </ul>
            <div class="row">
                <div class="input-field col s12 m12 l12 center-align">
                    <a href="/cart" class="btn-large waves-effect waves-light blue darken-4 white-text">Proceed to Check Out</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="preloaderModal" class="modal">
    <div class="modal-content center-align">
        <h5><b>One moment please...</b></h5>
        <div class="row">
            <div class="preloader-wrapper big active">
                <div class="spinner-layer spinner-blue-only">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/materialize.min.js') }}"></script>
<script src="{{ asset('js/index.js') }}"></script>
<script type="text/javascript">
$(document).ready(function(){
    <?php $maxPromo = count($items);
        foreach($categories as $category){
            for($i = 0; $i < $maxPromo; $i++){?>
                $('#<?php echo $category->category_name; echo $i; ?>').on('submit', function(e){
                    e.preventDefault();
                    var cartItems = parseInt($('#cartNum').text());
                    var itemQty = $('#itemInventory<?php echo $i; ?>').val();
                    $('#preloaderModal').modal('open');
                    var prod_id<?php echo $i;?> = $('#<?php echo $category->category_name; ?>Id<?php echo $i;?>').val();
                    $.ajax({
                        type: "POST",
                        url: "{{ url('/addcart') }}/"+prod_id<?php echo $i;?>,
                        data: $('#<?php echo $category->category_name; echo $i; ?>').serialize(),
                        success:function(response){
                            cartItems++;
                            $('#<?php echo $category->category_name; ?>Qty<?php echo $i; ?>').val('1');
                            M.toast({html: 'Added to cart!'});
                            $('#preloaderModal').modal('close');
                            $('#cartNum').text(cartItems);
                        },
                        error:function(response){
                            M.toast({html: 'Sorry, item has '+itemQty+'pcs. left.'});
                            $('#preloaderModal').modal('close');
                        }
                    });
                });

                $('#<?php echo $category->category_name; ?>Min<?php echo $i; ?>').click(function(e){
                    var quantity<?php echo $i; ?> = parseInt($('#<?php echo $category->category_name; ?>Qty<?php echo $i; ?>').val());
                    if(quantity<?php echo $i; ?> == 1){
                        //NOTHING TO DO HERE....
                    }else{
                        quantity<?php echo $i; ?>--;
                        $('#<?php echo $category->category_name; ?>Qty<?php echo $i; ?>').val(quantity<?php echo $i; ?>);
                    }
                });

                $('#<?php echo $category->category_name; ?>Add<?php echo $i; ?>').click(function(e){
                    var quantity<?php echo $i; ?> = parseInt($('#<?php echo $category->category_name; ?>Qty<?php echo $i; ?>').val());
                    quantity<?php echo $i; ?>++;
                    $('#<?php echo $category->category_name; ?>Qty<?php echo $i; ?>').val(quantity<?php echo $i; ?>);
                });
        <?php } ?>
    <?php } ?>
});
</script>
</body>
</html>