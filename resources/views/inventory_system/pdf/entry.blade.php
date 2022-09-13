@extends('.inventory_system/pdf/export_layout')
@section('custom_style')
    <style type="text/css">
        .content-wrapper{
            margin-top:20px;
            position:relative;
            width:100%;
        }
        .doc-title{
            font-weight: bold;
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        <p class="doc-title">
            <strong>Entry: </strong> {{$entries->code}} / Date:{{$entries->created_at}}
        </p>
        <table class="table">
            <tr>
                <th>#</th>
                <th>Code</th>
                <th>Description</th>
                <th>Quantity</th>
            </tr>
            @foreach( $entries->inDetail as $key=>$detail)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$detail->code}}</td>
                    <td>{{$detail->item->description}}</td>
                    <td>{{$detail->quantity}}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
