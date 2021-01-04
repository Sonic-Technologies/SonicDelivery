@extends('admin')

@section('content')
    <div class="col s12 m12 l12">
        <div class="card">
            <div class="card-content">
                <div class="row">
                    <h5 class="center-align"><strong>Customer Information</strong></h5>
                @foreach($getCustomer as $item) 
                   <div class="col s6 m6 l6">
                        <ul>
                            <li>Customer: {{ $item->first_name.' '.$item->last_name }}</li>
                            @if(!$item->street2)
                            <li>Address: {{ $item->street.', '.$item->city.', '.$item->province.', '.$item->zip }}</li>
                            @else
                            <li>Address: {{ $item->street.', '.$item->street2.', '.$item->city.', '.$item->province.', '.$item->zip }}</li>
                            @endif
                        </ul>
                   </div>
                   <div class="col s6 m6 l6">
                        <ul>
                            <li>Phone number: {{ $item->phone }}</li>
                            <li>Email address: {{ $item->email }}</li>
                        </ul>
                   </div>
                @endforeach
                </div>
                <div class="center-align">
                    <h5><strong>Order details</strong></h5>
                    @foreach($getCustomer as $order_id)
                    <p><b>Order #{{ $order_id->order_number }}</b></p>
                    @endforeach
                </div>
                <table class="responsive-table">
                    <thead>
                        <tr>
                            <th>Item code</th>
                            <th>Item name</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($getOrderDetails as $items)
                            <tr>
                                <td>{{ $items->item_code }}</td>
                                <td>{{ $items->item_name }}</td>
                                <td>{{ $items->quantity }}</td>
                                <td>₱{{ number_format($items->price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    
                    <tfoot>
                        <tr>
                            <td>Grand Total: ₱<strong>{{ number_format($items->grand_total, 2) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
                <div class="row">
                    @if($item->status == "new")
                        <div class="input-field col s12 m12 l12 center-align">
                            <a href="{{ url('/confirm-order' , $item->item_id) }}" class="btn waves-effect waves-light blue darken-4">Confirm Order</a>
                        </div>
                    @else
                        <div class="hide input-field col s12 m12 l12 center-align">
                            <a href="{{ url('/confirm-order' , $item->item_id) }}" class="btn waves-effect waves-light blue darken-4">Confirm Order</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection