@extends('layouts.cash')
<style>
    .panel-body{
        height: 80vh;
    }
</style>
@section('content')
    <div class="panel panel-default p-4 m-4 bg-light">
        <div class="panel-heading">
            <div class="page-heading"> <i class="glyphicon glyphicon-edit"></i>List of patient</div>
        </div> <!-- /panel-heading -->
        <div class="panel-body">

            <div class="remove-messages"></div>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <div class="div-action pull pull-right" style="padding-bottom:20px;">
                <!-- <button class="btn btn-default button1" data-toggle="modal" data-target="#addBrandModel"> <i class="glyphicon glyphicon-plus-sign"></i> </button> -->
            </div> <!-- /div-action -->

            <table class="table" id="consult_list_table">
                <thead>
                <tr>
                    <th>Consult ID</th>
                    <th>Patient ID</th>
                    <th>Patient Name</th>
                    <th>Service</th>
                    <th>Time joy</th>
                    <th>Status</th>
                    <th>Actions</th>
                    <!--<th style="width:15%;">Options</th>-->
                </tr>
                </thead>
                <tbody>
                @foreach($consultations as $consult)
                  <tr>
                      <td> {{$consult->id}}</td>
                      <td>{{$consult->patient["id"]}}</td>
                      <td>{{$consult->patient["firstName"]." ".$consult->patient["lastName"]}}</td>
                      <td>{{$consult->typeConsult["name"]}}</td>
                      <td>{{date_create_from_format("Y-m-d H:i:s",$consult->created_at)->format("H:i")}}</td>
                      <td> <span class="@if($consult->status==='RUNNING')
                                badge  badge-primary
                                        @else
                                badge  badge-success
                                        @endif
                              ">
                              {{$consult->status}}
                          </span>
                      </td>
                      <td><a href="{{url("cash/home/pay/$consult->id/patId/$consult->patient_id/type_consult/$consult->type_consult_id")}}" class="btn btn-primary">Pay</a></td>
                  </tr>
                @endforeach
                </tbody>
            </table>
            <!-- /table -->

        </div> <!-- /panel-body -->
    </div> <!-- /panel -->
@endsection

