@extends('layouts.app')

@section('content')
<div class="container w-75">
    <h4 class="text-center">Welcome {{\Illuminate\Support\Facades\Auth::user()->name}}</h4>
    <div class="table-responsive">
        <table class="table">
            <tr>
                <th>Page name</th>
                <th>link</th>
            </tr>
        @foreach($pages as $page)
            <tr>
                <td>{{$page->description}}</td>
                <td><a href="{{$page->link}}">continue</a></td>
            </tr>
        @endforeach
        </table>
    </div>
</div>
@endsection
