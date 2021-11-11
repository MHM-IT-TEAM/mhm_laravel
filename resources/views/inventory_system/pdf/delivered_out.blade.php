@extends('.inventory_system/pdf/export_layout')
@section('custom_style')
    <style type="text/css">
        .content-wrapper{
            margin-top:20px;
            position:relative;
        }
        .doc-title{
            font-weight: bold;
        }
        .responsible{
            position:absolute;
            left: 500px;
            bottom: 10px;
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        <p class="doc-title">
            <strong>OUT  Nº: </strong> {{$order->code}}  / Date:{{$order->created_at->format("Y/m/d")}}  / {{$order->orderer->name}}  /{{$order->collector->name}}
        </p>
        <table class="table">
            <tr>
            <th>#</th>
            <th>Code</th>
            <th>Description</th>
            <th>Quantity</th>
            </tr>
            @foreach( $order->out_details as $key=>$detail)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$detail->item->code}}</td>
                    <td>{{$detail->item->description}}</td>
                    <td>{{$detail->quantity}}</td>
                </tr>
            @endforeach
        </table>
        <div class="responsible">
            <p>Tsiferana RAKOTOARISOA</p>
            Operation responsible
        </div>
    </div>
@endsection
