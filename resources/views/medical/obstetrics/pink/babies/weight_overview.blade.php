@extends('layouts.app')
@section('content')
    <div class="chart-container" style="position: relative; height:40vh; width:80vw">
        <canvas id="graph"></canvas>
    </div>

@endsection
@section('script')
            <script src="/custom/js/medical/obstetrics/pink/babies/weight_overview.js"></script>
@endsection
