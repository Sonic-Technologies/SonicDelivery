@component('mail::message')
<p style="text-align: center;">
<b>SONIC SALES & DISTRIBUTION, INC.</b><br>
888 Mintrade Bldg. R. Castillo Street<br>
Agdao, Davao City<br>
Tel. No. 305-8005<br>
TIN 222-706-760-001<br><br>
</p>

@foreach($customer_info as $customer)
<p style="float: left; width: 30%;">
Order #:<br>
Date:<br>
Customer:<br>
Phone #: <br>
Address: <br>
</p>
<p style="float: right; width: 70%;">
@foreach($customer_order as $order)
<u>{{ $order->order_number }}</u><br>
<u>{{ $order->order_date }}</u><br>
@endforeach
<u>{{ $customer->first_name.' '.$customer->last_name }}</u><br>
<u>{{ $customer->phone }}</u><br>
@foreach($customer_barangay as $barangay)
@if(!$customer->street2)
<u>{{ $barangay->name.', '.$customer->street.', '.$customer->city.', '.$customer->province.', '.$customer->zip }}</u><br>
@else
<u>{{ $barangay->name.', '.$customer->street.', '.$customer->street2.','.$customer->city.', '.$customer->province.', '.$customer->zip }}</u><br>
@endif
@endforeach
</p><br><br><br><br><br><br><br><br><br><br><br><br>
@endforeach
<h1 style="text-align: center;"><b><u>TELESALES ORDER via Sonic Sales Delivery</u></b></h1>
@component('mail::table')
| SAP CODE                                                | ITEM DESCRIPTION                                        | SRP                                                                                        | QTY                                                    | AMOUNT                                                                                                                          |
|:-------------------------------------------------------:|:-------------------------------------------------------:|-------------------------------------------------------------------------------------------:|-------------------------------------------------------:|--------------------------------------------------------------------------------------------------------------------------------:|
@foreach($order_details as $item)
| <p style="font-size: small;">{{ $item->item_code }}</p> | <p style="font-size: small;">{{ $item->item_name }}</p> | <p style="font-size: small; text-align: right;">₱ {{ number_format($item->price, 2) }}</p> | <p style="font-size: small; text-align: right;">{{ $item->quantity }}</p> | <p style="font-size: small; text-align: right;">₱ {{ number_format($item->price * $item->quantity, 2) }}</p> |
@endforeach
@endcomponent
@foreach($customer_order as $ordr)
<p style="float: left; width: 70%; text-align: right;">
Order amount: <br>
Delivery fee: <br>
Total amount: <br>
</p>
<p style="float: right; width: 30%; text-align: right;">
₱ {{ number_format($ordr->grand_total - $ordr->delivery_fee, 2) }} <br>
₱ {{ number_format($ordr->delivery_fee, 2) }} <br>
₱ {{ number_format($ordr->grand_total, 2) }} <br>
</p>
@endforeach
@endcomponent