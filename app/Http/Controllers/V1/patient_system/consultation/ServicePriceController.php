<?php

namespace App\Http\Controllers\v1\patient_system\consultation;

use App\Http\Controllers\Controller;
use App\Models\ActivityPrice;
use Illuminate\Http\Request;

class ServicePriceController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
    public function filter_per_service($service_activity_id,$patient_category,$from_joy=null){
            $prices=ActivityPrice::where('service_activity_id',$service_activity_id);
        switch ($patient_category){
            case 0:
            case 2:
                $prices=$prices->get(['id','name','out_sector as price']);

             break;
            case 1:
                $prices=$prices->get(['id','name','sector as price']);
                break;
            case 3:
                $prices=$prices->get(['id','name','mhm_staff as price']);
                break;
            case 4:
                $prices=$prices->get(['id','name','mhm_staff_family as price']);
                break;
            case 5:
                $prices=$prices->get(['id','name','mhm_partners as price']);
                break;
            case 6:
                $prices=$prices->get(['id','name','vip as price']);
                break;
        }
        return $prices;
    }
}
