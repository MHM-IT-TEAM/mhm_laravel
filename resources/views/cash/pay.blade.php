@extends('layouts.cash')
@section('content')
    <div class="panel panel-default p-4 m-4 bg-light">
        <section class="border w-75 m-auto">
            <h6> Former Transactions</h6>
            <table class="table table-bordered mt-4" id="paymentRecords">

                <thead>

                <th>Date</th>
                <th>Last due</th>
                <th>Value</th>
                <th>Paid</th>
                <th>Due</th>
                <th></th>
                </thead>
                <tbody>
                @foreach($cashFlows as $cf)
                    <tr>
                        <td>{{$cf["created_at"]}}</td>
                        <td>{{$cf["last_due"]}}</td>
                        <td>{{$cf["value"]}}</td>
                        <td>{{$cf["paid"]}}</td>
                        <td>{{$cf["due"]}}</td>
                        <td><a href="#" class="nav-link" data-toggle="modal" onclick="showDetail( {{$cf['consultation_id']}})" data-target="#view_care_detailsModal"><i class="fas fa-eye"></i></a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </section>
        <section class="w-75 m-auto">
            <h6> Operation for today</h6>
            <table id="todayTransac" class="table table-bordered mt-2 ">
                <thead>
                <th>Item</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                </thead>
                <tbody>

                @foreach($todayOperations as $todayOp)
                    <tr id="row $x">
                        <td> {{$todayOp->ServicePrices["name"]}}</td>
                        <td> {{$todayOp->ServicePrices["price"]}}</td>
                        <td> {{$todayOp["qty"]}}</td>
                        <td id="total"> {{$todayOp["total"]}}</td>
                    </tr>
                @endforeach
                </tbody>

            </table>
            <form class="mt-4" id="payForm" action=" {{url('/api/cash/finalize/')}}" method="POST" >
                @csrf
                <input type="hidden" name=" consult_id" value="{{$consult_id}}"/>
                <input type="hidden" name=" patId" value="{{$patId}}"/>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="last_due"> Last Due</label>
                            <input type="text" name="last_due" id="last_due" class="form-control" disabled value="{{$due}}"/>
                            <input hidden type="text" name="last_dues" id="last_due" class="form-control"  value="{{$due}}"/>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="toPay"> to pay</label>
                            <input type="text" name="toPay" id="toPay" class="form-control" disabled value="{{$toPay}}"/>
                            <input type="hidden" name="toPays" id="toPays" class="form-control" value="{{$toPay}}"/>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="paid"> paid</label>
                            <input type="text" name="paid" id="paid" onchange="newDueSum()"class="form-control" required/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="paid"> New Due</label>
                            <input type="text" name="new_due" id="new_due" class="form-control" disabled />
                            <input type="hidden" name="new_dues" id="new_dues" class="form-control"  />
                        </div>
                    </div>
                    <div class="col-8">
                        <button type="submit" id="submit" class="btn btn-primary mt-4 " > Submit</button>
                    </div>
                </div>

            </form>
        </section>
    </div>

    <div class="modal fade" id="view_care_detailsModal" tabindex="-1" role="dialog" aria-labelledby="view_care_detailsModal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h6 class="modal-title"> Payments records: <span id="patientName"></span></h6>
                </div>
                <div class="modal-body">
                    <table class=" table table-bordered" id="care_detail">
                        <thead>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('script')
    <script src="{{asset('custom/js/cash/pay.js')}}"></script>
@endsection
