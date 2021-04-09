<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('custom/css/cash/finance_rezept.css')}}">
    <title>Cash</title>
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
        @foreach($results as $result)
            <tr>
                <td>{{$result->name}}</td>
                <td>{{$result->sum}}</td>
            </tr>
        @endforeach
        <tr>
            <th>TOTAL</th>
            <th>$total</th>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>
