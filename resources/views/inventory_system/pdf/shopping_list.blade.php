@extends('layouts.export_layout')
@section('custom_style')
    <style type="text/css">
        .content-wrapper{
            position: relative;
            width:100%;
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
        <div class="table-container">
            <h5 class="mt-4">BON DE COMMANDE: {{$items->code}}</h5>
            <table class="table">
                <thead>
                <th>#</th>
                <th>Description</th>
                <th>Quantité</th>
                </thead>
                <tbody>
                @foreach( $items->cartDetails as $key=>$detail)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$detail->item->description}}</td>
                        <td>{{$detail->quantity}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="responsible">
            <p>Tsiferana RAKOTOARISOA</p>
            Responsable des Opérations
        </div>
    </div>
@endsection
