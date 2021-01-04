@extends('admin')

@section('content')
    <div class="col s12 m12 l12">
        <div class="card">
            <div class="card-content">
                <h6 class="left-align"><b>Import Stock Transfer</b></h6>
                <div class="divider"></div>
                <br><br><br>
                <div class="row">
                    <form action="/import-stl" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="file-field input-field col s12 m6 l6">
                            <div class="btn blue darken-4 waves-effect waves-light">
                                <span>File</span>
                                <input type="file" name="file" class="validate @error('file') is-invalid @enderror">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" name="filepath" type="text" placeholder="No file chosen" readonly>
                            </div>
                            @error('file')
                                <span class="red-text"> {{ $message }} </span>
                            @enderror
                        </div>
                        <div class="input-field col s12 m6 l6 center-align">
                            <button class="btn blue darken-4 waves-effect waves-light">Submit<i class="material-icons right">send</i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col s12 m12 l12">
        <div class="card">
            <div class="card-content">
                <h6 class="left-align"><b>Audit Report</b></h6>
                <div class="divider"></div>
                <br>
                <div class="row">
                    <div class="col s12 m12 l12">
                    <form action="/select-audit-date" method="POST">
                        @csrf
                        <div class="row">
                            <div class="input-field col s6 m6 l6">
                                <input type="text" name="date" class="datepicker @error('date') is-invalid @enderror">
                                <label for="date">Filter by date</label>
                                @error('date')
                                    <span class="red-text">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="input-field col s6 m6 l6 center-align">
                                <button class="btn blue darken-4 waves-effect waves-light">Search<i class="material-icons right">search</i></button>
                            </div>
                        </div>
                    </form>
                        <ul class="tabs">
                            <li class="tab col s6 m6 l6"><a href="#in">Item In</a></li>
                            <li class="tab col s6 m6 l6"><a href="#out">Item Out</a></li>
                        </ul>
                    </div>
                    <div class="col s12 m12 12" id="in">
                        <div class="row">
                            <table class="striped" id="tableIn">
                                <thead>
                                    <tr>
                                        <th style="font-size: small;">User ID</th>
                                        <th style="font-size: small;">Item #</th>
                                        <th style="font-size: small;">Description</th>
                                        <th style="font-size: small;">QTY</th>
                                        <th style="font-size: small;">TXN</th>
                                        <th style="font-size: small;">Ref #</th>
                                        <th style="font-size: small;">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($updates as $update)
                                        <tr>
                                            <td class="center-align" style="font-size: small;">{{ $update->user_id }}</td>
                                            <td style="font-size: small;">{{ $update->item_number }}</td>
                                            <td style="font-size: small;">{{ $update->artdesc }}</td>
                                            <td class="right-align" style="font-size: small;">{{ $update->quantity }}</td>
                                            <td class="center-align" style="font-size: small;">In</td>
                                            <td style="font-size: small;">{{ $update->reference_number }}</td>
                                            <td style="font-size: small;">{{ $update->date }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if($updates != "[]")
                                <button type="button" id="exportUpdates" class="btn-small blue darken-4 waves-effect waves-light"><i class="material-icons">file_download</i></button>
                            @endif
                        </div>
                    </div>
                    <div class="col s12 m12 l12" id="out">
                        <div class="row">
                            <table class="striped" id="tableOut">
                                <thead>
                                    <tr>
                                        <th style="font-size: small;">Item #</th>
                                        <th style="font-size: small;">Description</th>
                                        <th style="font-size: small;">QTY</th>
                                        <th style="font-size: small;">TXN</th>
                                        <th style="font-size: small;">Ref #</th>
                                        <th style="font-size: small;">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($audits as $audit)
                                        <tr>
                                            <td style="font-size: small;">{{ $audit->item_code }}</td>
                                            <td style="font-size: small;">{{ $audit->item_name }}</td>
                                            <td style="font-size: small;" class="right-align">{{ $audit->quantity }}</td>
                                            <td style="font-size: small;" class="center-align">Out</td>
                                            <td style="font-size: small;">{{ $audit->order_number }}</td>
                                            <td style="font-size: small;">{{ $audit->order_date }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if($audits != "[]")
                                <button type="button" id="exportAudits" class="btn-small blue darken-4 waves-effect waves-light"><i class="material-icons">file_download</i></button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="successModal">
        <div class="modal-content center-align">
            <i class="material-icons green-text large">verified_user</i>
            @if(Session::has('message'))
                <h5><b>{{ Session::get('message') }}</b></h5>
            @endif
            <button type="button" class="modal-close btn-small blue darken-4 waves-light waves-effect">Confirm<i class="material-icons right">check</i></button>
        </div>
    </div>
@endsection

@section('script')
@if(Session::has('message'))
<script type="text/javascript">
    $(document).ready(function(){
        $('#successModal').modal('open')
    });
    exportAudits.addEventListener('click', e=>{

    });
</script>
@endif
@if($audits != "[]")
<script type="text/javascript">

    function download_csv2(csv, filename) {
        var csvFile;
        var downloadLink;
        csvFile = new Blob([csv], {type: "text/csv"});
        downloadLink = document.createElement("a");
        downloadLink.download = filename;
        downloadLink.href = window.URL.createObjectURL(csvFile);
        downloadLink.style.display = "none";
        document.body.appendChild(downloadLink);
        downloadLink.click();
    }

    function export_table_to_csv2(html, filename) {
        var csv = [];
        var rows = document.querySelectorAll("#tableOut tr");
        for (var i = 0; i < rows.length; i++) {
            var row = [], cols = rows[i].querySelectorAll("td, th");
            for (var j = 0; j < cols.length; j++) 
                row.push(cols[j].innerText);
            csv.push(row.join(","));		
        }
        download_csv2(csv.join("\n"), filename);
    }

    var d = new Date();
    var year = d.getFullYear();
    var month = d.getMonth()+1;
    var date = d.getDate();

    document.getElementById("exportAudits").addEventListener("click", function () {
        var html = document.getElementById("tableOut").outerHTML;
        export_table_to_csv2(html, "txn-Out-"+year+"-"+month+"-"+date+".csv");
    });
</script>
@endif
@if($updates != "[]")
<script type="text/javascript">
    function download_csv(csv, filename) {
        var csvFile;
        var downloadLink;
        csvFile = new Blob([csv], {type: "text/csv"});
        downloadLink = document.createElement("a");
        downloadLink.download = filename;
        downloadLink.href = window.URL.createObjectURL(csvFile);
        downloadLink.style.display = "none";
        document.body.appendChild(downloadLink);
        downloadLink.click();
    }

    function export_table_to_csv(html, filename) {
        var csv = [];
        var rows = document.querySelectorAll("#tableIn tr");
        for (var i = 0; i < rows.length; i++) {
            var row = [], cols = rows[i].querySelectorAll("td, th");
            for (var j = 0; j < cols.length; j++) 
                row.push(cols[j].innerText);
            csv.push(row.join(","));		
        }
        download_csv(csv.join("\n"), filename);
    }

    var d = new Date();
    var year = d.getFullYear();
    var month = d.getMonth()+1;
    var date = d.getDate();
    
    document.getElementById("exportUpdates").addEventListener("click", function () {
        var html = document.getElementById("tableIn").outerHTML;
        export_table_to_csv(html, "txn-In"+year+"-"+month+"-"+date+".csv");
    });
</script>
@endif
@endsection