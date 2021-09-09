<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('custom/css/cash/payment.css')}}">
    <title>Payment</title>
</head>
<body>
    <div>
        <div>
            <h6>ONG Mobile Hilfe Madagaskar</h6>
            <small>Lot 53 Ambovo Ambohidratrimo 105 <br>
                NIF:3000676023
                Stat:94951 11 2011 0 07043
            </small>
        </div>
        <div>
            Date:{{\Carbon\Carbon::today()}}
        </div>
        <div>
            {{$response['patient']['firstName']." ".$response['patient']['lastName']}}
        </div>
        <table class="table">
            <tr>
                <td>Nature</td>
                <td>Price</td>
                <td>Quantity</td>
                <td>Value</td>
            </tr>
            @php
                $total = 0;
            @endphp

        @foreach($response['admissionCareDetails'] as $detail)
                <tr>
                    <td>{{$detail->activity_price['name']}}</td>
                    <td>{{$detail->total/$detail->qty}}</td>
                    <td>{{$detail->qty}}</td>
                    <td>{{ $detail->total}}</td>
                </tr>
                @php
                    $total +=$detail->total;
                @endphp
            @endforeach
            <tr>
                <td></td>
                <td></td>
                <td>Last due</td>
                <td><strong>{{$patient_due}}</strong></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>Total</td>
                <td><strong>{{$patient_due+$total}}</strong></td>
            </tr>
        </table>
        <div>
            <small>Always keep this receipt / tehirizo tsara ity rosia ity</small>
        </div>

    </div>
</body>
<script>
    window.onafterprint = window.close;
    window.print()
</script>
</html>
