@extends('admin')

@section('content')
    <div class="col s12 m12 l12">
        <div class="card">
            <div class="card-content">
                <h5 class="left-align"><b>Products</b></h5>
                <div class="divider"></div>
                <div class="row">
                    <form action="/search-item" method="get">
                    @csrf
                        <div class="input-field col s6 m6 l6">
                            <input type="text" name="itemcode" class="validate @error('itemcode') is-invalid @enderror">
                            <label for="itemcode">Item Code</label>
                            @error('itemcode')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="input-field col s6 m6 l6 center-align">
                            <button class="btn waves-effect waves-light blue darken-4">Search<i class="material-icons right">search</i></button>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <div class="input-field col m4 l4"></div>
                    <form action="/categorize-by" method="post" id="categoryForm">
                    @csrf
                        <div class="input-field col s12 m4 l4 center-align">
                            <select name="filter" id="filter">
                            <option value="" disabled selected>Choose option</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->description }}</option>
                            @endforeach
                            </select>
                            <label for="filter">Filter by</label>
                        </div>
                    </form>
                    <div class="input-field col m4 l4"></div>
                </div>
                <div class="row">
                <div class="col s12">
                    <ul class="tabs">
                        <li class="tab col s6 m6 l6"><a href="#outstock">Out of stock</a></li>
                        <li class="tab col s6 m6 l6"><a href="#instock">In stock</a></li>
                    </ul>
                    </div>
                    <div id="outstock" class="col s12 m12 l12">
                        <table class="striped">
                            <thead>
                                <tr>
                                    <th style="font-size: small;">Item Code</th>
                                    <th style="font-size: small;">Item Description</th>
                                    <th style="font-size: small;" class="right-align"><span>Quantity</span></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                @if($item->inventory == 0)
                                    <tr>
                                        <td style="font-size: small;"><a href="{{ url('/item', $item->id) }}">{{ $item->artcode }}</a></td>
                                        <td style="font-size: small;">{{ $item->artdesc }}</td>
                                        <td style="font-size: small;" class="right-align"><span>{{ $item->inventory }}</span></td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div id="instock" class="col s12 m12 l12">
                        <table class="striped">
                            <thead>
                                <tr>
                                    <th style="font-size: small;">Item Code</th>
                                    <th style="font-size: small;">Item Description</th>
                                    <th style="font-size: small;" class="right-align"><span>Quantity</span></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                @if($item->inventory > 0)
                                    <tr>
                                        <td style="font-size: small;"><a href="{{ url('/item', $item->id) }}">{{ $item->artcode }}</a></td>
                                        <td style="font-size: small;">{{ $item->artdesc }}</td>
                                        <td style="font-size: small;" class="right-align"><span>{{ $item->inventory }}</span></td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script type="text/javascript">
$(document).ready(function(){
    $('#filter').change(function(e){
        $('#categoryForm').submit();
    });
});
</script>
@endsection
