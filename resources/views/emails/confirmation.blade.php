@component('mail::message')
<img src="{{ asset('images/logo.png') }}" style="width: 100px; height: 100px; margin-left: auto; margin-right: auto; display: block;">
<h4 style="text-align: center; margin-top: -18px"><b>SONIC SALES & DISTRIBUTION, INC.</b></h4>
<h6 style="text-align: center; margin-top: -25px">
888 Mintrade Bldg. R. Castillo Street<br>
Agdao, Davao City<br>
Tel. No. 305-8005<br>
TIN 222-706-760-001<br>
</h6>

@foreach($customer_info as $customer)
Dear {{ $customer->first_name }},<br><br>
@endforeach
Thank you for choosing Sonic Sales & Distribution, Inc.<br><br>
Below is the summary of the products you ordered: <br><br>
@foreach($customer_order as $orderDetails )
<h4 style="text-align: center;"><b>Order number:</b> {{ $orderDetails->order_number }} </h4>
@endforeach
@component('mail::table')
| ITEM DESCRIPTION                                        | SRP                                                                     | QTY                                                                       | AMOUNT                                                                                                      |
|:--------------------------------------------------------|------------------------------------------------------------------------:|--------------------------------------------------------------------------:|------------------------------------------------------------------------------------------------------------:|
@foreach($order_details as $item)
| <p style="font-size: small;">{{ $item->item_name }}</p> | <p style="font-size: small;">₱ {{ number_format($item->price, 2) }}</p> | <p style="font-size: small; text-align: right;">{{ $item->quantity }}</p> | <p style="font-size:small; text-align: right;">₱ {{ number_format($item->price * $item->quantity, 2) }}</p> |
@endforeach
@endcomponent
@foreach($customer_order as $ordr)
<p style="float: left; width: 60%; text-align: right;">
Order amount: <br>
Delivery fee: <br>
Total amount: <br>
</p>
<p style="float: right; width: 40%; text-align: right;">
₱ {{ number_format($ordr->grand_total - $ordr->delivery_fee, 2) }} <br>
₱ {{ number_format($ordr->delivery_fee, 2) }} <br>
₱ {{ number_format($ordr->grand_total, 2) }} <br>
</p>
@endforeach


You will be contacted by one of our representatives to verify your information. 
Once again, thank you for choosing Sonic Sales & Distribution, Inc. Keep safe!<br>

Thanks,<br><br>
Sonic Sales & Distribution, Inc.
@endcomponent
