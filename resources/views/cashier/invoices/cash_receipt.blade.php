<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cash</title>
    <style>
        .table{
            width:100%;
            border: solid 0.5px black;
        }
        table td{
            border: solid 0.5px grey;
            font-size: 11px;
        }
    </style>
</head>
<body>
<div class="ticket">
    <p>Mobile Hilfe Madagaskar</p>
    <p class="dateTime">{{now()}}</p>
    <hr>
    <table class= "table">
        <thead>
        <tr>
            <th>Service</th>
            <th>Amount</th>

        </tr>
        </thead>
        <tbody>
        @php
        $total=0;
        @endphp
        @foreach($data as $line)
            <tr>
                <td>{{$line->service}}</td>
                <td>{{$line->value}}</td>
            </tr>
            @php
                $total+=$line->value;
            @endphp
        @endforeach

        <tr>
            <th>TOTAL</th>
            <th>{{$total}}</th>
        </tr>
        </tbody>
    </table>
</div>
</body>
<script>
    window.onafterprint = window.close;
    window.print()
</script>
</html>
