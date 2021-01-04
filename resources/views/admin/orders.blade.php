@extends('admin')

@section('content')
    <div class="col s12 m12 l12">
        <div class="card">
            <div class="card-content">
                <h5 class="left-align"><b>Orders</b></h5>
                <div class="divider"></div>
                <div class="row">
                    <ul class="tabs">
                        <li class="tab col s6 m6 l6"><a href="#new">New Orders</a></li>
                        <li class="tab col s6 m6 l6"><a href="#confirmed">Confirmed Orders</a></li>
                    </ul>
                </div>
                <div class="row">
                    <div class="col s12 m12 l12" id="new">
                        <table>
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Order date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($newOrder as $new)
                                <tr>
                                    <td><a href="{{ url('/check-order', $new->id) }}">{{ $new->first_name." ".$new->last_name }}</a></td>
                                    <td>{{ $new->created_at }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col s12 m12 l12" id="confirmed">
                        <table>
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Order date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($confirmedOrder as $confirmed)
                                <tr>
                                    <td><a href="{{ url('/check-order' , $confirmed->id) }}">{{ $confirmed->first_name." ".$confirmed->last_name }}</a></td>
                                    <td>{{ $confirmed->created_at }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection