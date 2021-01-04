@extends('admin')

@section('content')
    <div class="col s12 m12 l12">
        <div class="card">
            <div class="card-content">
                <h5 class="center-align"><b>Update Product</b></h5>
                <div class="divider"></div>
                <div class="row">
                    <div class="col s12 m6 l6">
                        <div class="card">
                            <div class="card-image">
                                @foreach($item as $itemInfo)
                                    @if(!$itemInfo->photo)
                                        <img src="{{ asset('images/nopic.png') }}" height="300px" width="300px">
                                    @else
                                        <img src="{{ config('filesystems.aws_public_url').'/'.$itemInfo->photo }}" height="300px" width="300px">
                                    @endif
                            </div>
                            <div class="card-content center-align">
                                <h6><b>Category: {{ $itemInfo->subcat }}</b></h6>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m6 l6">
                        <div class="row">
                        @foreach($item as $itemInfo)
                            <form action="{{ url('/update/item', $itemInfo->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                                <div class="input-field col s12 m6 l6">
                                    <input type="text" name="itemCode" value="{{ $itemInfo->artcode }}" class="validate">
                                    <label for="itemcode">Item Code</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                    <select name="itemCategory">
                                        <option value="" disabled selected>Choose</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->description }}</option>
                                        @endforeach
                                    </select>
                                    <label>Category</label>
                                </div>
                                <div class="input-field col s12 m12 l12">
                                    <input type="text" name="itemName" value="{{ $itemInfo->artdesc }}" class="validate">
                                    <label for="itemName">Item Name</label>
                                </div>  
                                <div class="input-field col s6 m6 l6">
                                    <input type="text" name="itemPrice" value="{{ $itemInfo->price }}" class="validate">
                                    <label for="itemPrice">Price</label>
                                </div>
                                <div class="input-field col s6 m6 l6">
                                    <select name="itemStatus">
                                        @if($itemInfo->stat == 'Active')
                                        <option value="Active" selected>Active</option>
                                        <option value="Inactive">Inactive</option>
                                        @else
                                        <option value="Active">Active</option>
                                        <option value="Inactive" selected>Inactive</option>
                                        @endif
                                    </select>
                                    <label>Status</label>
                                </div>
                                <div class="input-field col s6 m6 l6">
                                    <input type="text" name="inventory" value="{{ $itemInfo->inventory }}" class="validate" >
                                    <label for="inventory">Stocks</label>
                                </div>
                                <div class="file-field input-field col s6 m6 l6">
                                    <div class="btn-small blue darken-4">
                                        <span>File</span>
                                        <input type="file" name="itemPhoto">
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" type="text" value="{{ $itemInfo->photo }}" readonly>
                                    </div>
                                </div>
                                <div class="input-field col s12 m12 l12 center-align">
                                    <button class="btn waves-effect waves-light blue darken-4">SAVE</button>
                                </div>        
                            </form>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
