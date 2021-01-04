@extends('admin')

@section('content')
    <div class="row">
        <div class="col s12 m4 l4">
            <div class="card">
                <div class="card-content">
                    <div class="center-align">
                        <h6><strong>New Order(s)</strong></h6>
                    </div>
                    <div class="center-align">
                        @if(!$items3)
                        <h5><strong>0</strong></h5>
                        @else
                        <h5><strong>{{ $items3 }}</strong></h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m4 l4">
            <div class="card">
                <div class="card-content">
                    <div class="center-align">
                        <h6><strong>Active Items</strong></h6>
                    </div>
                    <div class="center-align">
                        <h5><strong>{{ $items }}</strong></h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m4 l4">
            <div class="card">
                <div class="card-content">
                    <div class="center-align">
                        <h6><strong>Inactive Items</strong></h6>
                    </div>
                    <div class="center-align">
                        <h5><strong>{{ $items2 }}</strong></h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m6 l6">
            <div class="card">
                <div class="card-content">
                    <div class="center-align">
                        <h6><strong>Out of Stock Items</strong></h6>
                    </div>
                    <div class="center-align">
                        <h5><strong>{{ $items5 }}</strong></h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m6 l6">
            <div class="card">
                <div class="card-content">
                    <div class="center-align">
                        <h6><strong>In Stock Items</strong></h6>
                    </div>
                    <div class="center-align">
                        <h5><strong>{{ $items4 }}</strong></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
