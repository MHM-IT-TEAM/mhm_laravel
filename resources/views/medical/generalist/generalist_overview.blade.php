@extends('layouts.generalist')
@section('style')
    <style>
        .table-title{
            background-color: #1390C6;
            color:white;
        }
        .input{
            background-color: lightgray;
        }
        @media print{
            .table-title{
                background:lightgray !important;
                color:black;
            }
        }
    </style>
@endsection
@section('content')
    <div class="container w-75 bg-white">
        <table class="table table-sm table-borderless">
            <tr>
                <th class="table-title" colspan="3">A) Personal information </th>
            </tr>
            <tr>
                <th style="width:20%"><span class="text-danger">*</span>Id</th>
                <th style="width:40%">First name</th>
                <th style="width:40%">Last name</th>
            </tr>
            <tr>
                <td>
                    {{$data->patient['id']}}
                </td>
                <td class="required">
                    {{$data->patient['firstName']}}
                </td>
                <td class="required">
                    {{$data->patient['lastName']}}
                </td>
            </tr>
            <tr>
                <th>Date of birth</th>
                <th>Address</th>
                <th>Tel</th>
            </tr>
            <tr>
                <td class="required">
                    {{$data->patient['birthDate']}}
                </td>
                <td class="required">
                    {{$data->patient['adress']}}
                </td>
                <td class="required">
                    {{$data->patient['tel']}}
                </td>
            </tr>
        </table>
        <table class="table table-sm table-borderless">
            <tr>
                <th class="table-title" colspan="13">B) Today's actions</th>
            </tr>
            <tr>
                <td colspan="13">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="admission_type1" name="admission_type1" value="{{$data->generalist['new_case']}}" class="custom-control-input" >
                        <label class="custom-control-label" for="admission_type1">New case</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="admission_type2" name="admission_type1" value="{{$data->generalist['new_case']}}" class="custom-control-input">
                        <label class="custom-control-label" for="admission_type2">Followup</label>
                    </div>
                </td>
            </tr>
            <tr>
                <th style="width:10%" colspan="4"> B.1. Symptoms:</th>
                <td>
                    {{$data->generalist['symptoms']}}
                </td>
            </tr>
            <tr>
                <th colspan="5">B.2. Diagnostics</th>
            </tr>
            <tr>
                <td class="pl-4 text-decoration-underline" colspan="4">2.1. Vital signs</td>
            </tr>
            <tr>
                <td colspan="4"><span style="margin-left: 25px">From JC</span></td>
                <td colspan="7">

                    <div class="row w-50">
                        <div class="col">
                            BP:{{$data->taDia}} / {{$data->taSysto}}
                        </div>
                        <div class="col">
                            Pulse: {{$data->pulse}}
                        </div>
                        <div class="col">
                            Weight:{{$data->weight}}
                        </div>
                        <div class="col">
                            Spo2:{{$data->spo2}}
                        </div>
                    </div>

                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <span style="margin-left: 25px">Updated</span>
                </td>
                <td colspan="7" >
                    <div class="row w-50">
                        <div class="col">
                            BP:<span class="input">{{$data->generalist['taDia']}} / {{$data->generalist['taSysto']}}</span>
                        </div>
                        <div class="col">
                            Pulse: <span class="input">{{$data->generalist['pulse']}}</span>
                        </div>
                        <div class="col">
                            Weight:<span class="input">{{$data->generalist['weight']}}</span>
                        </div>
                        <div class="col">
                            Spo2:<span class="input">{{$data->generalist['spo2']}}</span>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="4"><span style="margin-left: 25px">Cause:</span></td>
                <td colspan="12">
                    <textarea class="form-control" readonly>{{$data->generalist['vital_sign_update_cause']}}</textarea>
                </td>
            </tr>
            <tr>
                <td class="pl-4 text-decoration-underline" colspan="4">2.2. Body Check:</td>
                <td colspan="12">
                    <textarea class="form-control" readonly >{{$data->generalist['body_check']}}</textarea>
                </td>
            </tr>
            <tr>
                <td class="pl-4 text-decoration-underline" colspan="4">2.3. Lab-work</td>
                <td colspan="12">
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" />
                        <label class="form-check-label">Internal</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" />
                        <label class="form-check-label">External</label>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="pl-4 text-decoration-underline"colspan="4" >2.4. Consultation</td>
                <td colspan="12">
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" />
                        <label class="form-check-label">Internal</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" />
                        <label class="form-check-label">External</label>
                    </div>
                </td>
            </tr>
            <tr>
                <th colspan="5">B.3. Diagnose:</th>
            </tr>
            <tr>
                <th class="pl-4" colspan="4"></th>
                <th colspan="2">Code</th>
                <th colspan="2">Status</th>
                <th colspan="5">Details</th>
            </tr>
{{--            {{dd($data->generalist['generalistDiagCodes'])}}--}}
            @if($data->generalist['generalistDiagCodes'])
                @foreach($data->generalist['generalistDiagCodes'] as $diag)
                    <tr>
                        <td class="pl-4" colspan="4"></td>
                        <td colspan="2" class="input">[&nbsp{{$diag->diagCode['code']}}&nbsp] &nbsp {{$diag->diagCode['description']}}</td>
                        <td colspan="2" class="input">{{$diag->status}}</td>
                        <td colspan="5" class="input">{{$diag->details}}</td>
                    </tr>
                @endforeach
            @endif
            <tr>
                <th colspan="5">B.4. Treatment:</th>
            </tr>
            <tr>
                <td class="pl-4 text-decoration-underline"  colspan="2">4.1. Medication:</td>
                <td colspan="4">
                    Medicine
                </td>
                <td>
                    Breakfast
                </td>
                <td>
                    Lunch
                </td>
                <td>
                   Dinner
                </td>
                <td>
                    Given
                </td>
                <td>

                </td>
            </tr>
{{--            {{dd($data->graceCsbTransaction)}}--}}
            @if($data->graceCsbTransaction)
              @foreach($data->graceCsbTransaction['graceCsbTransactionDetail'] as $detail)
                  @endforeach
            @endif
            <tr>
                <td class="pl-4 text-decoration-underline" colspan="2">4.2. Wound care</td>
                <td colspan="10">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="woundcare" id="woundcare1" value="1" >
                        <label class="form-check-label" for="woundcare1">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="woundcare" id="woundcare2" value="0" >
                        <label class="form-check-label" for="woundcare2">No</label>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="pl-4 text-decoration-underline" colspan="2">4.3. Stitches</td>
                <td colspan="10">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="stitches" id="stitches1" value="1" >
                        <label class="form-check-label" for="stitches1">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="stitches" id="stitches2" value="0" >
                        <label class="form-check-label" for="stitches2">No</label>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="pl-4 text-decoration-underline" colspan="2">4.4. Nebulizer</td>
                <td colspan="10">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="nebulizer" id="nebulizer1" value="1" >
                        <label class="form-check-label" for="nebulizer1">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="nebulizer" id="nebulizer2" value="0" >
                        <label class="form-check-label" for="nebulizer2">No</label>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="pl-4 text-decoration-underline" colspan="2">4.5. Vaccination:</td>
                <td colspan="10">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="nebulizer" id="vaccination1" value="1" >
                        <label class="form-check-label" for="vaccination1">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="vaccination" id="vaccination2" value="0" >
                        <label class="form-check-label" for="nebulizer2">No</label>
                    </div>
                </td>
            </tr>
            <tr>
                <th class="pt-6" colspan="2">B.5. Outcome:</th>
            </tr>
        </table>
    </div>
@endsection
